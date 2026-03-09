<?php
require_once __DIR__ . '/config.php';

// User Authentication Functions
class Auth {
    public static function login($email, $password) {
        global $db;
        
        $email = trim($email);
        $stmt = $db->prepare("SELECT id, username, password, is_active, is_admin FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (!$user['is_active']) {
                return ['success' => false, 'message' => 'Account is inactive'];
            }
            
            if (password_verify($password, $user['password'])) {
                // Update last login
                $update_stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $update_stmt->bind_param("i", $user['id']);
                $update_stmt->execute();
                
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['is_admin'] = $user['is_admin'];
                
                return ['success' => true, 'message' => 'Login successful'];
            } else {
                return ['success' => false, 'message' => 'Invalid password'];
            }
        } else {
            return ['success' => false, 'message' => 'Email not found'];
        }
    }

    public static function register($username, $email, $password, $confirm_password, $first_name, $last_name) {
        global $db;
        
        // Validation
        if (empty($username) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }
        
        if (strlen($password) < PASSWORD_MIN_LENGTH) {
            return ['success' => false, 'message' => 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters'];
        }
        
        if ($password !== $confirm_password) {
            return ['success' => false, 'message' => 'Passwords do not match'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        // Check if email exists
        $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'Email already registered'];
        }
        
        // Check if username exists
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            return ['success' => false, 'message' => 'Username already taken'];
        }
        
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert user
        $stmt = $db->prepare("INSERT INTO users (username, email, password, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $username, $email, $hashed_password, $first_name, $last_name);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Registration successful. Please login.', 'user_id' => $db->insert_id];
        } else {
            return ['success' => false, 'message' => 'Registration failed: ' . $db->error];
        }
    }

    public static function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }

    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public static function isAdmin() {
        return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1;
    }

    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username']];
        }
        return null;
    }

    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header('Location: ' . SITE_URL . 'login.php');
            exit();
        }
    }
}

// Product Functions
class Product {
    public static function getAll($category_id = null, $min_price = null, $max_price = null, $sort_by = 'popularity') {
        global $db;
        
        $query = "SELECT * FROM products WHERE 1=1";
        $params = [];
        $types = "";
        
        if ($category_id) {
            $query .= " AND category_id = ?";
            $params[] = $category_id;
            $types .= "i";
        }
        
        if ($min_price !== null) {
            $query .= " AND price >= ?";
            $params[] = $min_price;
            $types .= "d";
        }
        
        if ($max_price !== null) {
            $query .= " AND price <= ?";
            $params[] = $maxPrice;
            $types .= "d";
        }
        
        // Sort options
        switch ($sort_by) {
            case 'price_low':
                $query .= " ORDER BY price ASC";
                break;
            case 'price_high':
                $query .= " ORDER BY price DESC";
                break;
            case 'rating':
                $query .= " ORDER BY rating DESC";
                break;
            case 'newest':
                $query .= " ORDER BY created_at DESC";
                break;
            case 'popularity':
            default:
                $query .= " ORDER BY popularity DESC";
        }
        
        $stmt = $db->prepare($query);
        
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById($product_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public static function getFeatured($limit = 6) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM products WHERE featured = TRUE ORDER BY popularity DESC LIMIT ?");
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function search($keyword) {
        global $db;
        
        $keyword = "%{$keyword}%";
        $stmt = $db->prepare("SELECT * FROM products WHERE MATCH(name, description) AGAINST(? IN BOOLEAN MODE) OR name LIKE ? OR description LIKE ? ORDER BY popularity DESC");
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function incrementPopularity($product_id) {
        global $db;
        
        $stmt = $db->prepare("UPDATE products SET popularity = popularity + 1 WHERE id = ?");
        $stmt->bind_param("i", $product_id);
        return $stmt->execute();
    }
}

// Category Functions
class Category {
    public static function getAll() {
        global $db;
        
        $result = $db->query("SELECT * FROM categories ORDER BY name ASC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public static function getById($category_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param("i", $category_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}

// Cart Functions
class Cart {
    public static function addItem($user_id, $product_id, $quantity = 1) {
        global $db;
        
        // Check if product exists and has stock
        $product = Product::getById($product_id);
        if (!$product) {
            return ['success' => false, 'message' => 'Product not found'];
        }
        
        if ($product['quantity_in_stock'] < $quantity) {
            return ['success' => false, 'message' => 'Insufficient stock'];
        }
        
        // Check if item already in cart
        $stmt = $db->prepare("SELECT id, quantity FROM cart_items WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $item = $result->fetch_assoc();
            $new_quantity = $item['quantity'] + $quantity;
            $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $new_quantity, $item['id']);
        } else {
            $stmt = $db->prepare("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $user_id, $product_id, $quantity);
        }
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Item added to cart'];
        } else {
            return ['success' => false, 'message' => 'Failed to add item'];
        }
    }

    public static function getItems($user_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT ci.*, p.name, p.price, p.image_url FROM cart_items ci 
                             JOIN products p ON ci.product_id = p.id 
                             WHERE ci.user_id = ? ORDER BY ci.added_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function updateQuantity($cart_item_id, $quantity) {
        global $db;
        
        if ($quantity <= 0) {
            return self::removeItem($cart_item_id);
        }
        
        $stmt = $db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->bind_param("ii", $quantity, $cart_item_id);
        return $stmt->execute();
    }

    public static function removeItem($cart_item_id) {
        global $db;
        
        $stmt = $db->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->bind_param("i", $cart_item_id);
        return $stmt->execute();
    }

    public static function clear($user_id) {
        global $db;
        
        $stmt = $db->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }

    public static function getTotal($user_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT SUM(ci.quantity * p.price) as total FROM cart_items ci 
                             JOIN products p ON ci.product_id = p.id 
                             WHERE ci.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['total'] ?? 0;
    }
}

// Order Functions
class Order {
    public static function create($user_id, $shipping_address, $billing_address, $payment_method) {
        global $db;
        
        $cart_items = Cart::getItems($user_id);
        if (empty($cart_items)) {
            return ['success' => false, 'message' => 'Cart is empty'];
        }
        
        $subtotal = Cart::getTotal($user_id);
        $tax = $subtotal * TAX_RATE;
        $shipping = SHIPPING_COST;
        $total = $subtotal + $tax + $shipping;
        
        $order_number = 'ORD-' . date('YmdHis') . '-' . $user_id;
        
        $stmt = $db->prepare("INSERT INTO orders (user_id, order_number, total_amount, tax, shipping_cost, shipping_address, billing_address, payment_method) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isdddsss", $user_id, $order_number, $total, $tax, $shipping, $shipping_address, $billing_address, $payment_method);
        
        if (!$stmt->execute()) {
            return ['success' => false, 'message' => 'Failed to create order'];
        }
        
        $order_id = $db->insert_id;
        
        // Add order items
        foreach ($cart_items as $item) {
            $subtotal_item = $item['quantity'] * $item['price'];
            $insert_stmt = $db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, subtotal) 
                                        VALUES (?, ?, ?, ?, ?)");
            $insert_stmt->bind_param("iiidd", $order_id, $item['product_id'], $item['quantity'], $item['price'], $subtotal_item);
            $insert_stmt->execute();
            
            // Update product stock
            $update_stmt = $db->prepare("UPDATE products SET quantity_in_stock = quantity_in_stock - ? WHERE id = ?");
            $update_stmt->bind_param("ii", $item['quantity'], $item['product_id']);
            $update_stmt->execute();
        }
        
        // Clear cart
        Cart::clear($user_id);
        
        return ['success' => true, 'message' => 'Order created successfully', 'order_id' => $order_id, 'order_number' => $order_number];
    }

    public static function getById($order_id, $user_id = null) {
        global $db;
        
        if ($user_id) {
            $stmt = $db->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $order_id, $user_id);
        } else {
            $stmt = $db->prepare("SELECT * FROM orders WHERE id = ?");
            $stmt->bind_param("i", $order_id);
        }
        
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function getOrderItems($order_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT oi.*, p.name FROM order_items oi 
                             JOIN products p ON oi.product_id = p.id 
                             WHERE oi.order_id = ?");
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getUserOrders($user_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// User Profile Functions
class UserProfile {
    public static function getById($user_id) {
        global $db;
        
        $stmt = $db->prepare("SELECT id, username, email, first_name, last_name, phone, address, city, state, zip_code, country, created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public static function update($user_id, $data) {
        global $db;
        
        $fields = [];
        $values = [];
        $types = "";
        
        $allowed_fields = ['first_name', 'last_name', 'phone', 'address', 'city', 'state', 'zip_code', 'country'];
        
        foreach ($allowed_fields as $field) {
            if (isset($data[$field])) {
                $fields[] = "$field = ?";
                $values[] = $data[$field];
                $types .= "s";
            }
        }
        
        if (empty($fields)) {
            return ['success' => false, 'message' => 'No data to update'];
        }
        
        $query = "UPDATE users SET " . implode(", ", $fields) . " WHERE id = ?";
        $values[] = $user_id;
        $types .= "i";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param($types, ...$values);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Profile updated successfully'];
        } else {
            return ['success' => false, 'message' => 'Update failed'];
        }
    }

    public static function changePassword($user_id, $old_password, $new_password) {
        global $db;
        
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if (!password_verify($old_password, $result['password'])) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }
        
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $hashed_password, $user_id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Password changed successfully'];
        } else {
            return ['success' => false, 'message' => 'Password change failed'];
        }
    }
}
?>
