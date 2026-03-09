<?php
require_once 'php/functions.php';
Auth::requireLogin();
$profile = UserProfile::getById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - Fruid Juice</title>
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
                    <button class="icon-btn" id="cartIcon">🛒<span class="cart-badge" id="cartCount">0</span></button>
                    <button class="icon-btn" onclick="logout()">👤</button>
                </div>
                <div class="hamburger" id="hamburger">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </header>

    <!-- PAGE HEADER -->
    <section style="background: linear-gradient(135deg, rgba(255, 140, 66, 0.1), rgba(46, 204, 113, 0.1)); padding: 40px 0;">
        <div class="container">
            <h1>Welcome, <?php echo htmlspecialchars($profile['first_name'] ?? 'User'); ?>! 👋</h1>
        </div>
    </section>

    <!-- ACCOUNT CONTENT -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
                <!-- SIDEBAR -->
                <aside>
                    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                        <div style="text-align: center; margin-bottom: 20px;">
                            <div style="font-size: 60px; margin-bottom: 10px;">👤</div>
                            <h4><?php echo htmlspecialchars($profile['first_name'] ?? 'User'); ?></h4>
                            <p style="color: #7F8C8D; font-size: 0.9rem;"><?php echo htmlspecialchars($profile['email']); ?></p>
                        </div>
                        <nav style="display: flex; flex-direction: column; gap: 10px;">
                            <button class="menu-btn active" onclick="switchTab('profile')">📋 Profile</button>
                            <button class="menu-btn" onclick="switchTab('orders')">📦 Orders</button>
                            <button class="menu-btn" onclick="switchTab('addresses')">📍 Addresses</button>
                            <button class="menu-btn" onclick="switchTab('password')">🔐 Password</button>
                            <button class="menu-btn" onclick="logout()" style="border-top: 1px solid #ECF0F1; margin-top: 10px; padding-top: 10px;">🚪 Logout</button>
                        </nav>
                    </div>
                </aside>

                <!-- MAIN CONTENT -->
                <main>
                    <!-- PROFILE TAB -->
                    <div id="profile-tab" class="tab-content">
                        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                            <h3>Profile Information</h3>
                            <div id="alertContainer"></div>
                            <form id="profileForm" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($profile['first_name'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($profile['last_name'] ?? ''); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" value="<?php echo htmlspecialchars($profile['email']); ?>" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($profile['phone'] ?? ''); ?>">
                                </div>
                                <div class="form-group" style="grid-column: 1 / -1;">
                                    <label>Address</label>
                                    <input type="text" name="address" value="<?php echo htmlspecialchars($profile['address'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" name="city" value="<?php echo htmlspecialchars($profile['city'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state" value="<?php echo htmlspecialchars($profile['state'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>ZIP Code</label>
                                    <input type="text" name="zip_code" value="<?php echo htmlspecialchars($profile['zip_code'] ?? ''); ?>">
                                </div>
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" name="country" value="<?php echo htmlspecialchars($profile['country'] ?? ''); ?>">
                                </div>
                                <div style="grid-column: 1 / -1;">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- ORDERS TAB -->
                    <div id="orders-tab" class="tab-content hidden">
                        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);">
                            <h3>My Orders</h3>
                            <div id="ordersList">
                                <!-- Loaded via JavaScript -->
                            </div>
                        </div>
                    </div>

                    <!-- PASSWORD TAB -->
                    <div id="password-tab" class="tab-content hidden">
                        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); max-width: 500px;">
                            <h3>Change Password</h3>
                            <div id="passwordAlertContainer"></div>
                            <form id="passwordForm">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input type="password" name="old_password" required>
                                </div>
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input type="password" name="new_password" required minlength="6">
                                </div>
                                <div class="form-group">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="confirm_password" required minlength="6">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Password</button>
                            </form>
                        </div>
                    </div>
                </main>
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

    <style>
        .menu-btn {
            background: transparent;
            border: none;
            padding: 12px;
            text-align: left;
            cursor: pointer;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 1rem;
            color: #7F8C8D;
        }

        .menu-btn:hover,
        .menu-btn.active {
            background: #FF8C42;
            color: white;
        }

        .tab-content {
            animation: fadeIn 0.3s ease;
        }

        .tab-content.hidden {
            display: none;
        }
    </style>

    <script src="js/main.js"></script>
    <script src="js/account.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
