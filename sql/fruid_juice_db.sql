-- Create database
CREATE DATABASE IF NOT EXISTS fruid_juice_db;
USE fruid_juice_db;

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    slug VARCHAR(100) UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity_in_stock INT DEFAULT 0,
    image_url VARCHAR(255),
    popularity INT DEFAULT 0,
    rating DECIMAL(3, 2) DEFAULT 0,
    total_reviews INT DEFAULT 0,
    seo_keywords VARCHAR(255),
    seo_description VARCHAR(255),
    featured BOOLEAN DEFAULT FALSE,
    discount_percentage DECIMAL(5, 2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_popularity (popularity),
    INDEX idx_rating (rating),
    INDEX idx_price (price),
    FULLTEXT INDEX ft_search (name, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) UNIQUE NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(100),
    last_name VARCHAR(100),
    phone VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    zip_code VARCHAR(20),
    country VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    is_admin BOOLEAN DEFAULT FALSE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Cart items table
CREATE TABLE IF NOT EXISTS cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id),
    INDEX idx_user (user_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    tax DECIMAL(10, 2) DEFAULT 0,
    shipping_cost DECIMAL(10, 2) DEFAULT 0,
    discount_applied DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address VARCHAR(255),
    billing_address VARCHAR(255),
    payment_method VARCHAR(50),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id),
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Reviews table
CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    title VARCHAR(150),
    comment TEXT,
    is_verified BOOLEAN DEFAULT FALSE,
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_user (user_id),
    INDEX idx_rating (rating)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample categories
INSERT INTO categories (name, description, slug) VALUES
('Citrus', 'Fresh citrus juices - Oranges, Lemons, Limes', 'citrus'),
('Berry', 'Delicious berry juices - Strawberries, Blueberries, Raspberries', 'berry'),
('Tropical', 'Exotic tropical juices - Mango, Pineapple, Passion Fruit', 'tropical'),
('Mixed Fruit', 'Wonderful blends of multiple fruits', 'mixed-fruit'),
('Green & Vegetable', 'Healthy green juices with vegetables', 'green-vegetable');

-- Insert sample products
INSERT INTO products (category_id, name, description, price, quantity_in_stock, popularity, rating, total_reviews, seo_keywords, seo_description, featured, discount_percentage) VALUES
(1, 'Fresh Orange Juice', 'Pure freshly squeezed orange juice packed with Vitamin C', 4.99, 150, 95, 4.8, 245, 'orange juice, fresh, vitamin c', 'Fresh squeezed orange juice', TRUE, 0),
(1, 'Lemon Lime Blast', 'Refreshing blend of lemon and lime juices', 5.49, 120, 85, 4.6, 180, 'lemon juice, lime juice, citrus', 'Refreshing lemon lime juice blend', TRUE, 5),
(2, 'Strawberry Delight', 'Sweet and juicy strawberry juice', 6.99, 100, 88, 4.7, 210, 'strawberry juice, red juice', 'Fresh strawberry juice drink', TRUE, 0),
(2, 'Blueberry Power', 'Antioxidant-rich blueberry juice', 7.49, 90, 92, 4.9, 195, 'blueberry juice, antioxidants', 'Pure blueberry juice power', TRUE, 10),
(3, 'Mango Paradise', 'Tropical mango juice sensation', 5.99, 140, 90, 4.8, 220, 'mango juice, tropical', 'Fresh mango juice', TRUE, 0),
(3, 'Pineapple Express', 'Refreshing pineapple juice with tropical flavor', 5.49, 130, 87, 4.7, 175, 'pineapple juice, tropical', 'Fresh pineapple juice', FALSE, 0),
(3, 'Passion Fruit Punch', 'Exotic passion fruit juice', 6.49, 85, 83, 4.5, 165, 'passion fruit juice, exotic', 'Passion fruit juice drink', FALSE, 0),
(4, 'Berry Orange Fusion', 'Mix of berries with orange sweetness', 6.99, 110, 89, 4.7, 200, 'mixed fruit juice, berry orange', 'Berry and orange juice blend', TRUE, 0),
(4, 'Tropical Rainbow', 'Medley of all tropical fruits', 7.99, 75, 91, 4.8, 190, 'tropical juice, mixed fruits', 'Rainbow tropical fruit juice', TRUE, 15),
(5, 'Green Energy', 'Spinach, apple, and ginger juice blend', 5.99, 95, 86, 4.6, 170, 'green juice, detox, vegetable', 'Green detox juice blend', FALSE, 0);
