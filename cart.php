<?php
require_once 'php/functions.php';
Auth::requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Jacky Fruid Juice</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <div class="jfj-logo">
                        <span class="jfj-letter">J</span>
                        <span class="jfj-letter">F</span>
                        <span class="jfj-letter">J</span>
                    </div>
                    <span class="logo-text">Jacky Fruid Juice</span>
                </div>
                
                <nav class="nav-menu" id="navMenu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Shop</a></li>
                    <li><a href="account.php">Account</a></li>
                </nav>
                
                <div class="nav-icons">
                    <button class="icon-btn" id="cartIcon">🛒<span class="cart-badge">👉</span></button>
                    <button class="icon-btn" onclick="logout()">👤</button>
                </div>
                
                <div class="hamburger" id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <section style="background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(46, 204, 113, 0.1)); padding: 40px 0; text-align: center;">
        <div class="container">
            <h1>Shopping Cart</h1>
        </div>
    </section>

    <!-- CART CONTENT -->
    <section class="section">
        <div class="container">
            <div class="cart-container">
                <!-- CART ITEMS -->
                <div class="cart-items-list" id="cartItems">
                    <!-- Loaded via JavaScript -->
                </div>

                <!-- CART SUMMARY -->
                <div class="cart-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-item">
                        <span class="summary-label">Subtotal:</span>
                        <span class="summary-value" id="subtotal">$0.00</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Tax (8%):</span>
                        <span class="summary-value" id="tax">$0.00</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Shipping:</span>
                        <span class="summary-value" id="shipping">$10.00</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Total:</span>
                        <span class="summary-value" id="total">$0.00</span>
                    </div>
                    <a href="checkout.php" class="btn btn-primary checkout-btn">Proceed to Checkout</a>
                    <a href="products.php" class="btn btn-outline checkout-btn">Continue Shopping</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About Fruid Juice</h4>
                    <p>Discover the fresh taste of premium fruit juices delivered right to your doorstep.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="products.php">Shop</a></li>
                        <li><a href="index.php">Home</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Fruid Juice. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
