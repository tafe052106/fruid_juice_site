<?php
require_once 'php/functions.php';
Auth::requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Jacky Fruid Juice</title>
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
                    <button class="icon-btn" onclick="logout()">👤</button>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <section style="background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(46, 204, 113, 0.1)); padding: 40px 0; text-align: center;">
        <div class="container">
            <h1>Checkout</h1>
        </div>
    </section>

    <!-- CHECKOUT CONTENT -->
    <section class="section">
        <div class="container">
            <div style="max-width: 1000px; margin: 0 auto;">
                <div id="alertContainer"></div>

                <form id="checkoutForm" style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                    <!-- LEFT COLUMN - ADDRESS & PAYMENT -->
                    <div>
                        <h3>Shipping Address</h3>
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" required>
                        </div>
                        <div class="form-group">
                            <label>Street Address *</label>
                            <input type="text" name="street_address" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>City *</label>
                                <input type="text" name="city" required>
                            </div>
                            <div class="form-group">
                                <label>State *</label>
                                <input type="text" name="state" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>ZIP Code *</label>
                                <input type="text" name="zip_code" required>
                            </div>
                            <div class="form-group">
                                <label>Country *</label>
                                <input type="text" name="country" required>
                            </div>
                        </div>

                        <h3 style="margin-top: 40px;">Billing Address</h3>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" id="sameAsShipping"> Same as Shipping Address
                            </label>
                        </div>
                        <div id="billingAddressForm">
                            <div class="form-group">
                                <label>Street Address *</label>
                                <input type="text" name="billing_street" required>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>City *</label>
                                    <input type="text" name="billing_city" required>
                                </div>
                                <div class="form-group">
                                    <label>State *</label>
                                    <input type="text" name="billing_state" required>
                                </div>
                            </div>
                        </div>

                        <h3 style="margin-top: 40px;">Payment Method</h3>
                        <div class="form-group">
                            <label>
                                <input type="radio" name="payment_method" value="credit_card" checked> Credit Card
                            </label>
                            <label>
                                <input type="radio" name="payment_method" value="paypal"> PayPal
                            </label>
                            <label>
                                <input type="radio" name="payment_method" value="bank_transfer"> Bank Transfer
                            </label>
                        </div>

                        <h3 style="margin-top: 40px;">Card Details</h3>
                        <div class="form-group">
                            <label>Card Number *</label>
                            <input type="text" placeholder="1234 5678 9012 3456" maxlength="19" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Expiration Date *</label>
                                <input type="text" placeholder="MM/YY" required>
                            </div>
                            <div class="form-group">
                                <label>CVV *</label>
                                <input type="text" placeholder="123" maxlength="4" required>
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT COLUMN - ORDER SUMMARY -->
                    <div>
                        <div class="cart-summary" style="position: static;">
                            <h3>Order Summary</h3>
                            <div id="orderItems" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                                <!-- Loaded via JavaScript -->
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Subtotal:</span>
                                <span class="summary-value" id="checkoutSubtotal">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Tax (8%):</span>
                                <span class="summary-value" id="checkoutTax">$0.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Shipping:</span>
                                <span class="summary-value">$10.00</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">Total:</span>
                                <span class="summary-value" id="checkoutTotal">$0.00</span>
                            </div>
                            <button type="submit" class="btn btn-primary checkout-btn">Complete Purchase</button>
                            <a href="cart.php" class="btn btn-outline checkout-btn">Back to Cart</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>About Fruid Juice</h4>
                    <p>Premium fruit juices delivered to your doorstep.</p>
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
    <script src="js/checkout.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
