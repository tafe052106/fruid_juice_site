<?php
require_once 'php/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruid Juice - Fresh & Delicious - Premium Fruit Juices Online</title>
    <meta name="description" content="Fresh, delicious premium fruit juices delivered to your door. Explore citrus, berry, tropical, and mixed fruit juices from Fruid Juice.">
    <meta name="keywords" content="fresh juice, fruit juice, citrus juice, berry juice, tropical juice, healthy drinks, organic juice">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">🥤 Fruid Juice</div>
                
                <nav class="nav-menu" id="navMenu">
                    <li><a href="#home">Home</a></li>
                    <li><a href="products.php">Shop</a></li>
                    <li><a href="#features">About</a></li>
                    <li><a href="#contact">Contact</a></li>
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

    <!-- HERO SECTION -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Fresh Fruit Juices, Nature's Finest</h1>
            <p>Discover our premium selection of fresh, delicious fruit juices made with the finest ingredients. Healthy, refreshing, and bursting with natural flavors.</p>
            <div class="hero-buttons">
                <a href="products.php" class="btn btn-primary">Shop Now</a>
                <a href="#features" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- FEATURED PRODUCTS -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2>Featured Products</h2>
            </div>
            <div class="products-grid" id="featuredProducts">
                <!-- Loaded via JavaScript -->
            </div>
        </div>
    </section>

    <!-- FEATURES SECTION -->
    <section class="section" id="features" style="background: #f9f9f9;">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Fruid Juice?</h2>
            </div>
            <div class="products-grid">
                <div class="product-card">
                    <div class="product-image">🥕</div>
                    <div class="product-info">
                        <h4>100% Fresh</h4>
                        <p>Made from the freshest ingredients without any artificial additives or preservatives.</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">🌱</div>
                    <div class="product-info">
                        <h4>Organic & Natural</h4>
                        <p>All our juices are crafted from organic, naturally grown juices without any chemicals.</p>
                    </div>
                </div>
                <div class="product-card">
                    <div class="product-image">⚡</div>
                    <div class="product-info">
                        <h4>Packed with Nutrients</h4>
                        <p>Rich in vitamins, minerals, and antioxidants to boost your health and energy.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CATEGORIES SECTION -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2>Shop by Category</h2>
            </div>
            <div class="products-grid" id="categoriesGrid">
                <!-- Loaded via JavaScript -->
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="section" style="background: #f9f9f9;">
        <div class="container">
            <div class="section-header">
                <h2>What Our Customers Say</h2>
            </div>
            <div class="products-grid">
                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"The freshest juice I've ever had! The taste is incredible and it's so convenient to order online."</p>
                    <p class="testimonial-author">- Sarah M.</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"Perfect for my morning routine. I love knowing exactly what's in my juice - no preservatives!"</p>
                    <p class="testimonial-author">- John D.</p>
                </div>
                <div class="testimonial-card">
                    <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
                    <p class="testimonial-text">"Best quality juices at competitive prices. Fast delivery and excellent customer service!"</p>
                    <p class="testimonial-author">- Emma L.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- NEWSLETTER SECTION -->
    <section class="section" style="background: linear-gradient(135deg, #FF8C42, #2ECC71); color: white; text-align: center;">
        <div class="container">
            <h2 style="color: white;">Subscribe to Our Newsletter</h2>
            <p>Get exclusive deals, new products, and health tips delivered to your inbox!</p>
            <div style="max-width: 500px; margin: 0 auto; display: flex; gap: 10px;">
                <input type="email" placeholder="Enter your email" style="flex: 1; padding: 12px; border: none; border-radius: 8px;">
                <button class="btn btn-primary">Subscribe</button>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="section" id="contact">
        <div class="container">
            <div class="section-header">
                <h2>Get In Touch</h2>
            </div>
            <div style="max-width: 600px; margin: 0 auto;">
                <form id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Message</label>
                        <textarea required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Send Message</button>
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
                    <p>Discover the fresh taste of premium fruit juices delivered right to your doorstep. Quality, freshness, and health in every bottle.</p>
                    <div class="social-links">
                        <div class="social-icon">f</div>
                        <div class="social-icon">🐦</div>
                        <div class="social-icon">📷</div>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="products.php">Shop</a></li>
                        <li><a href="#features">About Us</a></li>
                        <li><a href="#contact">Contact</a></li>
                        <li><a href="#" onclick="alert('Coming soon!')">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Customer Service</h4>
                    <ul>
                        <li><a href="#" onclick="alert('Coming soon!')">FAQ</a></li>
                        <li><a href="#" onclick="alert('Coming soon!')">Shipping Info</a></li>
                        <li><a href="#" onclick="alert('Coming soon!')">Returns</a></li>
                        <li><a href="#" onclick="alert('Coming soon!')">Support</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <p>📧 info@fruibjuice.com</p>
                    <p>📞 1-800-JUICE-NOW</p>
                    <p>📍 123 Juice Street, Fresh City, FC 12345</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2026 Fruid Juice. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
            </div>
        </div>
    </footer>

    <!-- CART MODAL -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeCart()">&times;</span>
            <h2>Shopping Cart</h2>
            <div id="cartContent">
                <!-- Loaded via JavaScript -->
            </div>
            <button class="btn btn-primary" style="width: 100%; margin-top: 20px;" onclick="window.location.href='cart.php'">View Full Cart</button>
        </div>
    </div>

    <script src="js/main.js"></script>
    <script src="js/animations.js"></script>
</body>
</html>
