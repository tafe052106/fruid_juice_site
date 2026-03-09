// Cart Page JavaScript

document.addEventListener('DOMContentLoaded', function () {
    loadCart();
});

async function loadCart() {
    const result = await getCartItems();

    if (result.success && result.item_count > 0) {
        displayCartItems(result.items);
        updateCartTotals(result.total);
    } else {
        const cartItems = document.getElementById('cartItems');
        if (cartItems) {
            cartItems.innerHTML = `
                <div class="empty-cart">
                    <div class="empty-cart-icon">🛒</div>
                    <h3>Your Cart is Empty</h3>
                    <p>Start shopping to add items to your cart</p>
                    <a href="products.php" class="btn btn-primary">Continue Shopping</a>
                </div>
            `;
        }
    }
}

function displayCartItems(items) {
    const cartItems = document.getElementById('cartItems');
    if (!cartItems) return;

    cartItems.innerHTML = '';

    items.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.className = 'cart-item';
        itemElement.innerHTML = `
            <div class="cart-item-image">
                🥤
            </div>
            <div class="cart-item-details">
                <div>
                    <h3 class="cart-item-name">${item.name}</h3>
                    <p class="cart-item-price">$${parseFloat(item.price).toFixed(2)}</p>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div class="quantity-control">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity - 1})">−</button>
                        <input type="number" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)">
                        <button onclick="updateQuantity(${item.id}, ${item.quantity + 1})">+</button>
                    </div>
                    <span class="remove-item" onclick="removeFromCart(${item.id})">Remove</span>
                </div>
            </div>
            <div>
                <p style="text-align: right; font-weight: 700; font-size: 1.1rem;">$${(parseFloat(item.price) * item.quantity).toFixed(2)}</p>
            </div>
        `;
        cartItems.appendChild(itemElement);
    });
}

function updateCartTotals(subtotal) {
    const tax = subtotal * TAX_RATE;
    const total = subtotal + tax + SHIPPING_COST;

    document.getElementById('subtotal').textContent = formatCurrency(subtotal);
    document.getElementById('tax').textContent = formatCurrency(tax);
    document.getElementById('total').textContent = formatCurrency(total);
}

async function updateQuantity(cartItemId, newQuantity) {
    newQuantity = parseInt(newQuantity);
    
    if (newQuantity < 1) {
        removeFromCart(cartItemId);
        return;
    }

    const result = await apiCall('update_cart_item', 'POST', {
        cart_item_id: cartItemId,
        quantity: newQuantity
    });

    if (result.success) {
        displayCartItems(result.items);
        updateCartTotals(result.total);
        updateCartCount();
    }
}

async function removeFromCart(cartItemId) {
    if (!confirm('Remove this item from cart?')) return;

    const result = await apiCall('remove_from_cart', 'POST', {
        cart_item_id: cartItemId
    });

    if (result.success) {
        if (result.item_count === 0) {
            loadCart();
        } else {
            displayCartItems(result.items);
            updateCartTotals(result.total);
        }
        updateCartCount();
        showAlert('success', 'Item removed from cart');
    }
}
