# Fruid Juice - Developer Documentation

## API Reference

### Base URL
```
http://localhost/Fruid juice website/php/api.php?action={ACTION}
```

## Authentication Endpoints

### Login User
**Request:**
```
POST /api.php?action=login
Parameters:
  - email (string, required)
  - password (string, required)
```

**Response:**
```json
{
  "success": true,
  "message": "Login successful"
}
```

### Register User
**Request:**
```
POST /api.php?action=register
Parameters:
  - username (string, required)
  - email (string, required)
  - password (string, required, min 6 chars)
  - confirm_password (string, required)
  - first_name (string, required)
  - last_name (string, required)
```

### Logout
**Request:**
```
POST /api.php?action=logout
```

---

## Product Endpoints

### Get All Products
**Request:**
```
GET /api.php?action=get_products
Optional Parameters:
  - category_id (integer)
  - min_price (decimal)
  - max_price (decimal)
  - sort_by (string): popularity|price_low|price_high|rating|newest
```

**Response:**
```json
{
  "success": true,
  "products": [
    {
      "id": 1,
      "name": "Product Name",
      "price": 4.99,
      "description": "...",
      "category_id": 1,
      "rating": 4.8,
      "total_reviews": 245,
      ...
    }
  ]
}
```

### Get Single Product
**Request:**
```
GET /api.php?action=get_product&id={PRODUCT_ID}
```

### Get Featured Products
**Request:**
```
GET /api.php?action=get_featured&limit=6
```

### Search Products
**Request:**
```
GET /api.php?action=search_products&keyword={SEARCH_TERM}
```

---

## Category Endpoints

### Get All Categories
**Request:**
```
GET /api.php?action=get_categories
```

**Response:**
```json
{
  "success": true,
  "categories": [
    {
      "id": 1,
      "name": "Citrus",
      "description": "...",
      "slug": "citrus"
    }
  ]
}
```

---

## Cart Endpoints

### Add to Cart
**Request:**
```
POST /api.php?action=add_to_cart
Parameters:
  - product_id (integer, required)
  - quantity (integer, default 1)
```

### Get Cart Items
**Request:**
```
GET /api.php?action=get_cart
```

**Response:**
```json
{
  "success": true,
  "items": [
    {
      "id": 1,
      "product_id": 5,
      "name": "Product Name",
      "price": 5.99,
      "quantity": 2,
      "image_url": "..."
    }
  ],
  "total": 11.98,
  "item_count": 1
}
```

### Update Cart Item
**Request:**
```
POST /api.php?action=update_cart_item
Parameters:
  - cart_item_id (integer, required)
  - quantity (integer, required)
```

### Remove from Cart
**Request:**
```
POST /api.php?action=remove_from_cart
Parameters:
  - cart_item_id (integer, required)
```

---

## Order Endpoints

### Create Order
**Request:**
```
POST /api.php?action=create_order
Parameters:
  - shipping_address (string, required)
  - billing_address (string, required)
  - payment_method (string, required)
```

**Response:**
```json
{
  "success": true,
  "message": "Order created successfully",
  "order_id": 1,
  "order_number": "ORD-20260309120000-1"
}
```

### Get Order
**Request:**
```
POST /api.php?action=get_order
Parameters:
  - order_id (integer, required)
```

### Get User Orders
**Request:**
```
GET /api.php?action=get_user_orders
```

---

## User Profile Endpoints

### Get Profile
**Request:**
```
GET /api.php?action=get_profile
```

### Update Profile
**Request:**
```
POST /api.php?action=update_profile
Parameters:
  - first_name (string)
  - last_name (string)
  - phone (string)
  - address (string)
  - city (string)
  - state (string)
  - zip_code (string)
  - country (string)
```

### Change Password
**Request:**
```
POST /api.php?action=change_password
Parameters:
  - old_password (string, required)
  - new_password (string, required)
```

---

## JavaScript API Reference

### Main Functions

#### apiCall(action, method, data)
```javascript
// GET request
const result = await apiCall('get_products', 'GET', { category_id: 1 });

// POST request
const result = await apiCall('login', 'POST', { 
  email: 'user@example.com', 
  password: 'password123' 
});
```

#### addToCart(productId, quantity)
```javascript
await addToCart(5, 2); // Add product 5, quantity 2
```

#### updateCartCount()
```javascript
await updateCartCount(); // Updates cart badge
```

#### getCartItems()
```javascript
const result = await getCartItems();
console.log(result.total); // Cart total
console.log(result.items); // Cart items array
```

### Utilities

#### showAlert(type, message)
```javascript
showAlert('success', 'Item added to cart!');
showAlert('error', 'Something went wrong');
showAlert('warning', 'Warning message');
```

#### formatCurrency(amount)
```javascript
formatCurrency(19.99); // Returns "$19.99"
```

#### formatDate(dateString)
```javascript
formatDate('2026-03-09'); // Returns "Mar 09, 2026"
```

#### validateEmail(email)
```javascript
if (validateEmail(email)) { /* Valid */ }
```

---

## Database Schema

### users table
```
- id (INT, PRIMARY KEY)
- username (VARCHAR 100, UNIQUE)
- email (VARCHAR 150, UNIQUE)
- password (VARCHAR 255) - bcrypt hash
- first_name (VARCHAR 100)
- last_name (VARCHAR 100)
- phone (VARCHAR 20)
- address (VARCHAR 255)
- city (VARCHAR 100)
- state (VARCHAR 100)
- zip_code (VARCHAR 20)
- country (VARCHAR 100)
- is_active (BOOLEAN)
- is_admin (BOOLEAN)
- last_login (TIMESTAMP)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### products table
```
- id (INT, PRIMARY KEY)
- category_id (INT, FOREIGN KEY)
- name (VARCHAR 150)
- description (TEXT)
- price (DECIMAL 10,2)
- quantity_in_stock (INT)
- image_url (VARCHAR 255)
- popularity (INT)
- rating (DECIMAL 3,2)
- total_reviews (INT)
- seo_keywords (VARCHAR 255)
- seo_description (VARCHAR 255)
- featured (BOOLEAN)
- discount_percentage (DECIMAL 5,2)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

### orders table
```
- id (INT, PRIMARY KEY)
- user_id (INT, FOREIGN KEY)
- order_number (VARCHAR 50, UNIQUE)
- total_amount (DECIMAL 10,2)
- tax (DECIMAL 10,2)
- shipping_cost (DECIMAL 10,2)
- discount_applied (DECIMAL 10,2)
- status (ENUM): pending|processing|shipped|delivered|cancelled
- shipping_address (VARCHAR 255)
- billing_address (VARCHAR 255)
- payment_method (VARCHAR 50)
- notes (TEXT)
- created_at (TIMESTAMP)
- updated_at (TIMESTAMP)
```

---

## Constants

All constants defined in `php/config.php`:

```php
// Database
DB_SERVER = 'localhost'
DB_USER = 'root'
DB_PASS = ''
DB_NAME = 'fruid_juice_db'

// Site
SITE_URL = 'http://localhost/Fruid juice website/'
SITE_NAME = 'Fruid Juice - Fresh & Delicious'

// Business Rules
TAX_RATE = 0.08 (8%)
SHIPPING_COST = 10.00
PASSWORD_MIN_LENGTH = 6

// Timeouts
SESSION_TIMEOUT = 3600 (1 hour)
```

---

## Error Handling

All API responses follow this format:

```json
{
  "success": true/false,
  "message": "Response message",
  "data": {} // Optional additional data
}
```

Common error codes:
- 401: Not authenticated (requires login)
- 400: Bad request (missing/invalid parameters)
- 404: Not found (resource doesn't exist)
- 500: Server error

---

## Extending the API

### Adding a New Endpoint

1. **In `php/functions.php`**, add your class/function:
```php
class MyFeature {
    public static function doSomething($param) {
        // Your logic here
    }
}
```

2. **In `php/api.php`**, add the action:
```php
case 'my_action':
    $response = MyFeature::doSomething($data);
    break;
```

3. **In JavaScript**, call it:
```javascript
const result = await apiCall('my_action', 'POST', { param: value });
```

---

## Testing

### Manual Testing with Browser Console

```javascript
// Test login
await apiCall('login', 'POST', {
  email: 'test@example.com',
  password: 'password123'
});

// Test getting products
const products = await apiCall('get_products', 'GET');
console.log(products);

// Test adding to cart
await addToCart(1, 2);

// Check cart
const cart = await getCartItems();
console.log(cart.total);
```

### cURL Testing

```bash
# Get products
curl "http://localhost/Fruid juice website/php/api.php?action=get_products"

# Login
curl -X POST "http://localhost/Fruid juice website/php/api.php?action=login" \
  -d "email=test@example.com&password=password123"
```

---

## Performance Tips

1. **Database Queries**: Use indexes on frequently searched columns
2. **API Calls**: Batch requests when possible
3. **Images**: Use lazy loading for product images
4. **Cache**: Implement product caching for popular items
5. **Compression**: Enable gzip on server

---

## Security Best Practices

1. Always use HTTPS in production
2. Validate all inputs server-side
3. Use prepared statements (already implemented)
4. Keep passwords bcrypt hashed
5. Implement rate limiting for API
6. Use CSRF tokens for form submissions
7. Sanitize all output to prevent XSS

---

## Troubleshooting

### API Returns 404
- Check action parameter spelling
- Ensure user is logged in for protected endpoints
- Check URL formatting

### Database Connection Error
- Verify MySQL is running
- Check credentials in config.php
- Ensure database exists

### Cart Operations Fail
- User must be logged in
- Check browser console for JavaScript errors
- Verify session is active

---

For more information, refer to README.md and SETUP.md files.
