<?php
require_once 'php/functions.php';
if (Auth::isLoggedIn()) {
    header('Location: account.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Fruid Juice</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">🥤 Fruid Juice</div>
                <nav class="nav-menu" id="navMenu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Shop</a></li>
                </nav>
                <div class="nav-icons">
                    <a href="register.php" class="btn btn-primary btn-small">Sign Up</a>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- LOGIN SECTION -->
    <section class="section" style="min-height: 80vh; display: flex; align-items: center;">
        <div class="container">
            <div style="max-width: 500px; margin: 0 auto;">
                <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                    <h2 style="text-align: center;">Login to Your Account</h2>
                    <p style="text-align: center; margin-bottom: 30px;">Access your orders and manage your account</p>

                    <div id="alertContainer"></div>

                    <form id="loginForm">
                        <div class="form-group">
                            <label>Email Address</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" required>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                            <label>
                                <input type="checkbox"> Remember me
                            </label>
                            <a href="#">Forgot password?</a>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
                    </form>

                    <p style="text-align: center; margin-top: 20px;">
                        Don't have an account? <a href="register.php"><strong>Sign up here</strong></a>
                    </p>
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
    <script src="js/auth.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
