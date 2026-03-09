# Fruid Juice Website - Setup Guide

## Quick Start Guide

### Step 1: Database Setup (5 minutes)

1. **Open phpMyAdmin**
   - Go to http://localhost/phpmyadmin

2. **Create Database**
   - Click "New" in left sidebar
   - Enter database name: `fruid_juice_db`
   - Click "Create"

3. **Import SQL File**
   - Select the newly created `fruid_juice_db` database
   - Click "Import" tab
   - Choose file: `sql/fruid_juice_db.sql`
   - Click "Go"

✅ Your database is now ready with all tables and sample data!

### Step 2: Configure PHP Settings (2 minutes)

1. **Edit `php/config.php`**
   
   Update the database credentials:
   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USER', 'root');        // Your MySQL username
   define('DB_PASS', '');            // Your MySQL password (if any)
   define('DB_NAME', 'fruid_juice_db');
   define('SITE_URL', 'http://localhost/Fruid juice website/');
   ```

2. **Set Folder Permissions**
   - Ensure `uploads/` folder is writable
   - Linux/Mac: `chmod 755 uploads/`

### Step 3: Access the Website (1 minute)

1. **Start your web server** (Apache/Nginx)
2. **Open browser** and go to:
   ```
   http://localhost/Fruid juice website/
   ```

3. **Create your account**
   - Click "Sign Up" in navigation
   - Fill in your details
   - Start shopping!

## 🎯 What You'll See

### Homepage
- Beautiful hero section with "Shop Now" button
- 6 featured products from database
- 5 product categories you can browse
- Customer testimonials
- Newsletter signup
- Contact form

### Products Page
- Complete product catalog
- Filter by category
- Filter by price range ($0-$50)
- Sort options (popularity, price, rating)
- Product detail modals
- "Add to Cart" buttons

### Shopping Cart
- View all cart items
- Update quantities
- Remove items
- Order summary with tax & shipping
- Proceed to checkout

### Checkout
- Shipping address form
- Billing address option
- Payment method selection
- Order review
- Complete purchase

### Account
- View profile information
- Edit profile details
- View order history
- Change password

## 📊 Sample Data Included

The database comes pre-loaded with:
- **10 Products** across all categories
- **5 Categories** (Citrus, Berry, Tropical, Mixed, Green)
- **Realistic pricing** and descriptions
- **Sample ratings** and reviews

### Featured Products:
1. 🍊 Fresh Orange Juice - $4.99
2. 🫐 Blueberry Power - $7.49
3. 🥭 Mango Paradise - $5.99
4. 🍹 Tropical Rainbow - $7.99 (15% discount)
5. and more...

## 🔑 Features Overview

### User-Facing Features
✅ Browse products by category
✅ Search for products
✅ Filter by price and popularity
✅ View product details
✅ Add items to cart
✅ Manage shopping cart
✅ Complete secure checkout
✅ Create user account
✅ Login/logout
✅ View order history
✅ Update profile
✅ Change password
✅ Smooth animations

### Technical Features
✅ Responsive design (mobile, tablet, desktop)
✅ MySQL database with proper relationships
✅ PHP REST API
✅ Secure authentication (bcrypt)
✅ Session management
✅ API error handling
✅ Form validation
✅ SEO-optimized

## 🎨 Color Scheme

The website uses a beautiful fruit-inspired palette:
- **Orange** (#FF8C42) - Primary action color
- **Green** (#2ECC71) - Secondary action
- **Yellow** (#F1C40F) - Accents
- **Light backgrounds** - Pale yellow (#FFF9E6)

## 📋 File Organization

```
Key Files to Know:

Frontend Pages:
- index.php → Homepage
- products.php → Product catalog
- cart.php → Shopping cart
- checkout.php → Checkout
- login.php → Login page
- register.php → Registration
- account.php → User account
- order-confirmation.php → Order success

Backend:
- php/config.php → Settings
- php/db.php → Database connection
- php/functions.php → All business logic
- php/api.php → REST API endpoints

Styling:
- css/styles.css → All styles (1300+ lines)

JavaScript:
- js/main.js → Core utilities
- js/products.js → Product page logic
- js/cart.js → Cart logic
- js/checkout.js → Checkout logic
- js/auth.js → Login/Register
- js/account.js → Account page
- js/animations.js → Effects

Database:
- sql/fruid_juice_db.sql → Database schema
```

## 🧪 Test the Website

### Test User Flow:
1. Go to homepage
2. Click "Shop Now"
3. Browse products
4. Click on a product to see details
5. Add item to cart
6. Click cart icon
7. Go to cart page
8. Proceed to checkout
9. Create account or login
10. Fill shipping details
11. Complete order
12. View confirmation page
13. Check order in account page

### Test Features:
- **Search**: Type in search box (e.g., "orange")
- **Filters**: Use sidebar categories and price range
- **Sorting**: Change "Sort By" dropdown
- **Mobile**: Resize browser to see responsive design
- **Animations**: Scroll page, click buttons to see effects

## 🐛 Troubleshooting

### "Database Connection Error"
- Check if MySQL is running
- Verify credentials in `php/config.php`
- Ensure database name is `fruid_juice_db`

### "Page not found"
- Check file paths in configuration
- Ensure all PHP files are in correct folders
- Verify SITE_URL in config.php

### "Can't add to cart"
- Make sure you're logged in
- Check browser console for JavaScript errors
- Verify API endpoints are working

### "Cart won't load"
- Clear browser cookies/cache
- Check if products exist in database
- Verify session is working

## 📞 Common Tasks

### Add a New Product
```sql
INSERT INTO products (category_id, name, description, price, quantity_in_stock)
VALUES (1, 'Product Name', 'Description', 9.99, 100);
```

### Add a Category
```sql
INSERT INTO categories (name, description, slug)
VALUES ('Category Name', 'Description', 'category-slug');
```

### Reset Database
1. Delete `fruid_juice_db` database
2. Re-import the SQL file
3. Recreate your user account

## ✨ Pro Tips

1. **Speed**: Database is indexed for fast searches
2. **Security**: All passwords are bcrypt hashed
3. **Mobile**: Fully responsive on all devices
4. **Animations**: Smooth CSS animations (no jank)
5. **SEO**: Meta tags and semantic HTML included
6. **Extensible**: Easy to add payment gateway later

## 🎓 What You Can Learn

- Full-stack development workflow
- Database design and relationships
- REST API creation
- Form handling and validation
- Authentication implementation
- Responsive web design
- JavaScript async operations
- CSS animations
- Security best practices

## 🚀 Next Steps

After getting the website running:

1. **Test Everything**: Create accounts, add products, checkout
2. **Explore Code**: Read comments in PHP and JavaScript
3. **Customize Colors**: Edit CSS variables in `css/styles.css`
4. **Add Products**: Use phpMyAdmin to add more products
5. **Modify Text**: Update copy in HTML files
6. **Scale Up**: Consider payment gateway integration

---

**Enjoy your fresh juice e-commerce platform! 🥤🍊🫐🥭**

Need help? Check the README.md for detailed documentation!
