<?php
require_once 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Fruid Juice</title>
    <meta name="description" content="Browse our complete selection of fresh fruit juices. Filter by category, price, and popularity.">
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
                    <li><a href="index.php#features">About</a></li>
                    <li><a href="index.php#contact">Contact</a></li>
                    <?php if (Auth::isLoggedIn()): ?>
                        <li><a href="account.php">Account</a></li>
                    <?php endif; ?>
                </nav>
                
                <div class="nav-icons">
                    <input type="text" id="searchInput" placeholder="Search...">
                    <?php if (Auth::isLoggedIn()): ?>
                        <button class="icon-btn" id="cartIcon">
                            🛒
                            <span class="cart-badge" id="cartCount">0</span>
                        </button>
                        <button class="icon-btn" onclick="logout()">👤</button>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-small">Login</a>
                    <?php endif; ?>
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
            <h1>Shop Our Juices</h1>
            <p>Browse our complete selection of fresh, delicious fruit juices</p>
        </div>
    </section>

    <!-- PRODUCTS PAGE CONTENT -->
    <section class="section">
        <div class="container">
            <div style="display: grid; grid-template-columns: 250px 1fr; gap: 30px;">
                <!-- FILTERS SIDEBAR -->
                <aside>
                    <div class="filters-section">
                        <h3 class="filters-title">Filters</h3>
                        
                        <div class="filter-group">
                            <label>Category</label>
                            <div class="checkbox-group" id="categoryFilters">
                                <!-- Loaded via JavaScript -->
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label>Price Range</label>
                            <input type="range" id="priceRange" min="0" max="50" value="50">
                            <div style="display: flex; justify-content: space-between; margin-top: 10px;">
                                <span>$0</span>
                                <span id="priceDisplay">$50</span>
                            </div>
                        </div>
                        
                        <div class="filter-group">
                            <label>Sort By</label>
                            <select id="sortBy">
                                <option value="popularity">Popularity</option>
                                <option value="price_low">Price: Low to High</option>
                                <option value="price_high">Price: High to Low</option>
                                <option value="rating">Highest Rated</option>
                                <option value="newest">Newest</option>
                            </select>
                        </div>
                        
                        <button class="btn btn-primary" style="width: 100%" onclick="applyFilters()">Apply Filters</button>
                        <button class="btn btn-outline" style="width: 100%; margin-top: 10px;" onclick="resetFilters()">Reset</button>
                    </div>
                </aside>

                <!-- PRODUCTS GRID -->
                <main>
                    <div class="products-grid" id="productsGrid">
                        <!-- Loaded via JavaScript -->
                    </div>
                </main>
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
                        <li><a href="index.php#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Shipping Info</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Fruid Juice. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- PRODUCT DETAIL MODAL -->
    <div id="productModal" class="modal">
        <div class="modal-content" style="max-width: 600px;">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <div id="productDetail">
                <!-- Loaded via JavaScript -->
            </div>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="js/products.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
