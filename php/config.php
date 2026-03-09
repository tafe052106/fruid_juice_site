<?php
// Database Configuration
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fruid_juice_site');

// Site Configuration
define('SITE_URL', 'http://localhost/Fruid juice website/');
define('SITE_NAME', 'Jacky Fruid Juice - Fresh & Delicious');
define('UPLOADS_DIR', __DIR__ . '/../uploads/');
define('UPLOADS_URL', SITE_URL . 'uploads/');

// Session settings
define('SESSION_TIMEOUT', 3600); // 1 hour
define('SESSION_COOKIE_SECURE', false); // Set to true in production with HTTPS
define('SESSION_COOKIE_HTTPONLY', true);

// Payment settings
define('TAX_RATE', 0.08); // 8% tax
define('SHIPPING_COST', 10.00); // Standard shipping

// Security settings
define('PASSWORD_MIN_LENGTH', 6);
define('HASH_ALGO', 'bcrypt');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set error reporting for development (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once 'db.php';
?>
