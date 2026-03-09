<?php
require_once __DIR__ . '/functions.php';

header('Content-Type: application/json');

$action = $_GET['action'] ?? $_POST['action'] ?? null;
$response = ['success' => false, 'message' => 'Invalid action'];

try {
    switch ($action) {
        // Auth APIs
        case 'login':
            Auth::requireLogin = false; // Allow without login
            $response = Auth::login($_POST['email'] ?? '', $_POST['password'] ?? '');
            break;

        case 'register':
            $response = Auth::register(
                $_POST['username'] ?? '',
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['confirm_password'] ?? '',
                $_POST['first_name'] ?? '',
                $_POST['last_name'] ?? ''
            );
            break;

        case 'get_whatsapp_link':
            Auth::requireLogin = false;
            if (!isset($_GET['order_id']) || !isset($_SESSION['user_id'])) {
                $response = ['success' => false, 'message' => 'Missing parameters'];
                break;
            }
            $notification = Notifications::sendOrderNotification($_GET['order_id'], $_SESSION['user_id']);
            $response = array_merge(['success' => true], $notification);
            break;

        // Product APIs
        case 'get_products':
            Auth::requireLogin = false;
            $products = Product::getAll(
                $_GET['category_id'] ?? null,
                $_GET['min_price'] ?? null,
                $_GET['max_price'] ?? null,
                $_GET['sort_by'] ?? 'popularity'
            );
            $response = ['success' => true, 'products' => $products];
            break;

        case 'get_product':
            Auth::requireLogin = false;
            $product = Product::getById($_GET['id'] ?? 0);
            if ($product) {
                Product::incrementPopularity($_GET['id']);
                $response = ['success' => true, 'product' => $product];
            } else {
                $response = ['success' => false, 'message' => 'Product not found'];
            }
            break;

        case 'get_featured':
            Auth::requireLogin = false;
            $products = Product::getFeatured($_GET['limit'] ?? 6);
            $response = ['success' => true, 'products' => $products];
            break;

        case 'search_products':
            Auth::requireLogin = false;
            $products = Product::search($_GET['keyword'] ?? '');
            $response = ['success' => true, 'products' => $products];
            break;

        // Category APIs
        case 'get_categories':
            Auth::requireLogin = false;
            $categories = Category::getAll();
            $response = ['success' => true, 'categories' => $categories];
            break;

        // Cart APIs
        case 'add_to_cart':
            Auth::requireLogin();
            $response = Cart::addItem(
                $_SESSION['user_id'],
                $_POST['product_id'] ?? 0,
                $_POST['quantity'] ?? 1
            );
            break;

        case 'get_cart':
            Auth::requireLogin();
            $items = Cart::getItems($_SESSION['user_id']);
            $total = Cart::getTotal($_SESSION['user_id']);
            $response = ['success' => true, 'items' => $items, 'total' => $total, 'item_count' => count($items)];
            break;

        case 'update_cart_item':
            Auth::requireLogin();
            Cart::updateQuantity($_POST['cart_item_id'] ?? 0, $_POST['quantity'] ?? 0);
            $items = Cart::getItems($_SESSION['user_id']);
            $total = Cart::getTotal($_SESSION['user_id']);
            $response = ['success' => true, 'items' => $items, 'total' => $total];
            break;

        case 'remove_from_cart':
            Auth::requireLogin();
            Cart::removeItem($_POST['cart_item_id'] ?? 0);
            $items = Cart::getItems($_SESSION['user_id']);
            $total = Cart::getTotal($_SESSION['user_id']);
            $response = ['success' => true, 'items' => $items, 'total' => $total];
            break;

        // Order APIs
        case 'create_order':
            Auth::requireLogin();
            $response = Order::create(
                $_SESSION['user_id'],
                $_POST['shipping_address'] ?? '',
                $_POST['billing_address'] ?? '',
                $_POST['payment_method'] ?? ''
            );
            break;

        case 'get_order':
            Auth::requireLogin();
            $order = Order::getById($_POST['order_id'] ?? 0, $_SESSION['user_id']);
            if ($order) {
                $items = Order::getOrderItems($order['id']);
                $response = ['success' => true, 'order' => $order, 'items' => $items];
            } else {
                $response = ['success' => false, 'message' => 'Order not found'];
            }
            break;

        case 'get_user_orders':
            Auth::requireLogin();
            $orders = Order::getUserOrders($_SESSION['user_id']);
            $response = ['success' => true, 'orders' => $orders];
            break;

        // User Profile APIs
        case 'get_profile':
            Auth::requireLogin();
            $profile = UserProfile::getById($_SESSION['user_id']);
            $response = ['success' => true, 'profile' => $profile];
            break;

        case 'update_profile':
            Auth::requireLogin();
            $response = UserProfile::update($_SESSION['user_id'], $_POST);
            break;

        case 'change_password':
            Auth::requireLogin();
            $response = UserProfile::changePassword(
                $_SESSION['user_id'],
                $_POST['old_password'] ?? '',
                $_POST['new_password'] ?? ''
            );
            break;

        default:
            $response = ['success' => false, 'message' => 'Unknown action'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => 'Error: ' . $e->getMessage()];
}

echo json_encode($response);
?>
