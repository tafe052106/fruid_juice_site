# Fruid Juice - E-Commerce Website

A complete, fully-functional e-commerce platform for selling fresh fruit juices with a modern, responsive design and comprehensive backend management.

## 🎯 Features

### Frontend
- **Responsive Design**: Mobile-first approach with seamless experience on all devices
- **Beautiful UI**: Fruit-inspired color palette with smooth animations and transitions
- **Product Catalog**: Browse juices by category (Citrus, Berry, Tropical, Mixed Fruit, Green)
- **Product Filtering**: Filter by category, price range, and sort by popularity, price, or rating
- **Search Functionality**: Real-time product search with FULLTEXT indexing
- **Shopping Cart**: Add/remove items, update quantities, persistent cart management
- **User Authentication**: Secure login/registration with password hashing
- **Checkout Process**: Complete checkout flow with shipping and billing address
- **Order Confirmation**: Order summary and tracking information
- **Account Management**: User profile, order history, password management
- **Smooth Animations**: CSS animations, scroll effects, ripple effects on interactions

### Backend
- **MySQL Database**: Comprehensive schema with proper relationships and indexing
- **PHP REST API**: Well-structured API endpoints for all operations
- **User Management**: Secure authentication with bcrypt hashing
- **Product Management**: Dynamic product loading from database
- **Shopping Cart**: Session-based cart management
- **Order Processing**: Complete order creation and tracking
- **Admin Structure Ready**: Database prepared for admin functionality

### Security
- Password hashing with bcrypt
- Session-based authentication
- HTTPS-ready configuration
- SQL injection prevention with prepared statements
- Input validation and sanitization
- CORS support ready

## 📁 Project Structure

```
Fruid juice website/
├── index.php                 # Homepage
├── products.php              # Product catalog page
├── cart.php                  # Shopping cart page
├── checkout.php              # Checkout page
├── login.php                 # Login page
├── register.php              # Registration page
├── account.php               # User account management
├── order-confirmation.php    # Order confirmation page
│
├── php/
│   ├── config.php           # Configuration and constants
│   ├── db.php               # Database connection
│   ├── functions.php        # All PHP classes and functions
│   └── api.php              # REST API endpoints
│
├── css/
│   └── styles.css           # Complete stylesheet with responsive design
│
├── js/
│   ├── main.js              # Core functionality and utilities
│   ├── products.js          # Product page logic
│   ├── cart.js              # Cart management
│   ├── checkout.js          # Checkout logic
│   ├── auth.js              # Authentication logic
│   ├── account.js           # Account management
│   └── animations.js        # Animations and effects
│
├── sql/
│   └── fruid_juice_db.sql   # Database schema and sample data
│
├── uploads/                 # User-uploaded files (images, etc.)
└── images/                  # Static images directory
```

## 📋 Database Schema

### Tables
1. **categories** - Product categories (Citrus, Berry, Tropical, etc.)
2. **products** - Product information with pricing and inventory
3. **users** - Customer and admin accounts
4. **cart_items** - Shopping cart items
5. **orders** - Order records
6. **order_items** - Items within orders
7. **reviews** - Product reviews and ratings

## 🚀 Installation & Setup

### 1. Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- Modern web browser

### 2. Database Setup
1. Open phpMyAdmin or MySQL command line
2. Import the SQL file:
   ```sql
   source php/../sql/fruid_juice_db.sql
   ```
   Or copy-paste the contents of `sql/fruid_juice_db.sql`

3. Database will be created with:
   - All necessary tables
   - Proper relationships and constraints
   - Sample data with 10 products across categories
   - Indexes for optimization

### 3. Configuration
1. Edit `php/config.php`:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USER', 'root');        // Your MySQL username
   define('DB_PASS', '');            // Your MySQL password
   define('DB_NAME', 'fruid_juice_db');
   define('SITE_URL', 'http://localhost/Fruid juice website/');
   ```

2. Ensure `uploads/` directory has write permissions:
   ```bash
   chmod 755 uploads/
   ```

### 4. Run the Website
1. Place the entire folder in your web server's document root
2. Access via `http://localhost/Fruid juice website/`
3. Start shopping!

## 👥 Default Test Credentials

After database import, you can create an account or test with:
- **Email**: test@example.com
- **Password**: password123

(Note: First user must be registered through the registration page)

## 🎨 Design Features

### Color Palette
- **Primary Orange**: #FF8C42 - Main accent color
- **Secondary Green**: #2ECC71 - Secondary accent
- **Bright Yellow**: #F1C40F - Highlights
- **Dark Green**: #27AE60 - Darker elements
- **Pale Yellow**: #FFF9E6 - Light backgrounds

### Responsive Breakpoints
- Desktop: 1200px and above
- Tablet: 768px to 1199px
- Mobile: Below 768px
- Small Mobile: Below 480px

### Animations
- Fade in up on scroll
- Smooth transitions on hover
- Ripple effect on button clicks
- Cart icon animation
- Modal slide-up effect
- Product card lift on hover

## 📱 Key Pages

### Homepage (`index.php`)
- Hero section with CTA buttons
- Featured products slider
- Category showcase
- Customer testimonials
- Newsletter signup
- Contact form

### Product Catalog (`products.php`)
- Grid layout with filtering
- Category filter sidebar
- Price range slider
- Sort options
- Product detail modal
- Add to cart functionality

### Shopping Cart (`cart.php`)
- Cart items list with images
- Quantity controls
- Order summary
- Subtotal, tax, shipping calculation
- Checkout button

### Checkout (`checkout.php`)
- Shipping address form
- Billing address option
- Payment method selection
- Card details input
- Order review
- Complete purchase button

### Account (`account.php`)
- Profile information
- Order history
- Address management
- Password change
- Logout option

## 🔐 Security Features

1. **Password Security**
   - Bcrypt hashing algorithm
   - Minimum 6 character requirement
   - Session-based authentication

2. **Database Security**
   - Prepared statements for all queries
   - Parameterized inputs
   - SQL injection prevention

3. **Session Management**
   - Secure session handling
   - Session timeout configuration
   - HTTPONLY cookie flags

4. **Data Protection**
   - Input validation
   - Output escaping
   - XSS prevention

## ⚡ Performance Optimizations

1. **Database Optimizations**
   - Proper indexing
   - FULLTEXT search on products
   - Query optimization

2. **Frontend Optimizations**
   - CSS animation optimization
   - Lazy loading ready
   - Minimal external dependencies
   - Efficient JavaScript

3. **SEO Features**
   - Meta tags and descriptions
   - Semantic HTML
   - Proper heading hierarchy
   - URL-friendly structure

## 🛠️ API Endpoints

All endpoints use `php/api.php` with action parameters:

### Authentication
- `auth=login` - User login
- `action=register` - User registration
- `action=logout` - Logout

### Products
- `action=get_products` - Get all products with filters
- `action=get_product` - Get single product
- `action=get_featured` - Get featured products
- `action=search_products` - Search products

### Cart
- `action=add_to_cart` - Add item to cart
- `action=get_cart` - Get cart items
- `action=update_cart_item` - Update quantity
- `action=remove_from_cart` - Remove item

### Orders
- `action=create_order` - Create new order
- `action=get_order` - Get order details
- `action=get_user_orders` - Get user orders

### Account
- `action=get_profile` - Get user profile
- `action=update_profile` - Update profile
- `action=change_password` - Change password

## 📝 Usage Examples

### Adding a Product to Cart (JavaScript)
```javascript
addToCart(productId, quantity);
```

### Creating an Order
```javascript
const result = await apiCall('create_order', 'POST', {
    shipping_address: '123 Main St, City, ST 12345',
    billing_address: '456 Oak Ave, City, ST 67890',
    payment_method: 'credit_card'
});
```

### Getting Cart Items
```javascript
const result = await getCartItems();
console.log(result.items); // Array of cart items
console.log(result.total); // Cart total
```

## 🎓 Learning Features

This project demonstrates:
- Full-stack web development
- RESTful API design
- Database modeling and relationships
- Frontend form handling and validation
- JavaScript async/await and fetch API
- CSS responsiveness and animations
- Security best practices
- Code organization and structure

## 📄 License

This project is open source and available under the MIT License.

## 🤝 Support

For issues, questions, or suggestions:
1. Check the code comments
2. Review the database schema in `sql/fruid_juice_db.sql`
3. Check API responses for error messages

## 🚀 Future Enhancements

- Payment gateway integration (Stripe, PayPal)
- Email notifications for orders
- Admin dashboard
- Product reviews and ratings
- Wishlist functionality
- Abandoned cart recovery
- Customer testimonials management
- More detailed analytics
- Mobile app version
- Multiple language support

## ✨ Version History

### v1.0.0 (Initial Release)
- Complete e-commerce platform
- User authentication
- Product catalog with filtering
- Shopping cart and checkout
- Order management
- Account management
- Responsive design
- Smooth animations

---

Made with ❤️ for fresh juice lovers! 🥤🍊🫐🥭
