<?php
require_once 'php/functions.php';
Auth::requireLogin();

$order_id = $_GET['order_id'] ?? 0;
$order_number = $_GET['order_number'] ?? '';

$order = Order::getById($order_id, $_SESSION['user_id']);
$order_items = [];

if ($order) {
    $order_items = Order::getOrderItems($order_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - Jacky Fruid Juice</title>
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

    <!-- CONFIRMATION SECTION -->
    <section class="section" style="min-height: 80vh;">
        <div class="container">
            <div style="max-width: 600px; margin: 0 auto; text-align: center;">
                <div style="font-size: 80px; margin-bottom: 20px;">✅</div>
                <h1>Thank You for Your Order!</h1>
                <p style="font-size: 1.1rem; margin-bottom: 30px;">Your order has been placed successfully. We're now preparing your delicious fresh juices.</p>

                <?php if ($order): ?>
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); text-align: left;">
                    <h3>Order Details</h3>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; padding-bottom: 20px; border-bottom: 1px solid #ECF0F1;">
                        <div>
                            <p style="color: #7F8C8D; font-size: 0.9rem; margin: 0;">Order Number</p>
                            <p style="font-weight: 700; font-size: 1.2rem; margin: 0;"><?php echo htmlspecialchars($order['order_number']); ?></p>
                        </div>
                        <div>
                            <p style="color: #7F8C8D; font-size: 0.9rem; margin: 0;">Order Date</p>
                            <p style="font-weight: 700; font-size: 1.2rem; margin: 0;"><?php echo date('M d, Y', strtotime($order['created_at'])); ?></p>
                        </div>
                        <div>
                            <p style="color: #7F8C8D; font-size: 0.9rem; margin: 0;">Order Status</p>
                            <p style="font-weight: 700; font-size: 1.2rem; margin: 0;">
                                <span style="padding: 5px 15px; border-radius: 20px; background: #F39C12; color: white;">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <h4>Items Ordered</h4>
                    <?php foreach ($order_items as $item): ?>
                    <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ECF0F1;">
                        <div>
                            <p style="margin: 0; font-weight: 600;"><?php echo htmlspecialchars($item['name']); ?></p>
                            <p style="margin: 5px 0 0 0; color: #7F8C8D; font-size: 0.9rem;">Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <p style="margin: 0; font-weight: 600;">$<?php echo number_format($item['subtotal'], 2); ?></p>
                    </div>
                    <?php endforeach; ?>

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid #ECF0F1;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span>Subtotal:</span>
                            <span>$<?php echo number_format($order['total_amount'] - $order['tax'] - $order['shipping_cost'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                            <span>Tax:</span>
                            <span>$<?php echo number_format($order['tax'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span>Shipping:</span>
                            <span>$<?php echo number_format($order['shipping_cost'], 2); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 1.3rem; font-weight: 700; padding-top: 15px; border-top: 2px solid #FF8C42;">
                            <span>Total:</span>
                            <span style="color: #FF8C42;">$<?php echo number_format($order['total_amount'], 2); ?></span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px; padding: 20px; background: #f9f9f9; border-radius: 12px;">
                    <h4>What's Next?</h4>
                    <ul style="text-align: left; color: #7F8C8D; line-height: 2;">
                        <li>📧 A confirmation email has been sent to your email address</li>
                        <li>🚚 You'll receive tracking information once your order ships</li>
                        <li>⏱️ Typical delivery time is 2-5 business days</li>
                        <li>❓ Check your <a href="account.php" style="color: #FF8C42; font-weight: 600;">account page</a> for order status</li>
                    </ul>
                </div>
                <?php else: ?>
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                    <p style="color: #E74C3C; font-weight: 600;">Order not found. Please check your email for confirmation details.</p>
                </div>
                <?php endif; ?>

                <div style="margin-top: 30px; display: flex; gap: 10px; justify-content: center;">
                    <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                    <a href="account.php" class="btn btn-secondary">View All Orders</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-bottom">
                <p>&copy; 2026 Fruid Juice. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/main.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
