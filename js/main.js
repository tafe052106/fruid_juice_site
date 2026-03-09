// Main JavaScript - Common functions for all pages

const API_URL = 'php/api.php';
const TAX_RATE = 0.08;
const SHIPPING_COST = 10.00;

// ==================== API CALLS ====================

async function apiCall(action, method = 'GET', data = null) {
    try {
        const options = {
            method: method,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
        };

        let url = `${API_URL}?action=${action}`;

        if (method === 'GET' && data) {
            Object.keys(data).forEach(key => {
                url += `&${key}=${encodeURIComponent(data[key])}`;
            });
        } else if (method === 'POST' && data) {
            const formData = new URLSearchParams();
            Object.keys(data).forEach(key => {
                formData.append(key, data[key]);
            });
            options.body = formData;
        }

        const response = await fetch(url, options);
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('API Error:', error);
        return { success: false, message: 'Network error' };
    }
}

// ==================== AUTHENTICATION ====================

async function logout() {
    const result = await apiCall('logout', 'POST');
    if (result.success) {
        window.location.href = 'index.php';
    }
}

// ==================== CART FUNCTIONS ====================

async function updateCartCount() {
    const result = await apiCall('get_cart', 'GET');
    if (result.success) {
        const badge = document.getElementById('cartCount');
        if (badge) {
            badge.textContent = result.item_count || 0;
        }
    }
}

async function addToCart(productId, quantity = 1) {
    const isLoggedIn = document.querySelector('[href="login.php"]') === null;
    
    if (!isLoggedIn) {
        window.location.href = 'login.php';
        return;
    }

    const result = await apiCall('add_to_cart', 'POST', {
        product_id: productId,
        quantity: quantity
    });

    if (result.success) {
        showAlert('success', result.message);
        updateCartCount();
    } else {
        showAlert('error', result.message);
    }
}

async function getCartItems() {
    return await apiCall('get_cart', 'GET');
}

// ==================== UI HELPERS ====================

function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) return;

    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;

    alertContainer.appendChild(alertDiv);

    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

function showLoader(container) {
    const loader = document.createElement('div');
    loader.className = 'loader';
    loader.style.margin = '20px auto';
    container.innerHTML = '';
    container.appendChild(loader);
}

// ==================== HEADER & NAVIGATION ====================

document.addEventListener('DOMContentLoaded', function () {
    // Mobile menu toggle
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('navMenu');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function () {
            navMenu.classList.toggle('active');
        });

        // Close menu when a link is clicked
        navMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navMenu.classList.remove('active');
            });
        });
    }

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        if (navMenu && hamburger && !navMenu.contains(event.target) && !hamburger.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });

    // Cart icon modal
    const cartIcon = document.getElementById('cartIcon');
    const cartModal = document.getElementById('cartModal');

    if (cartIcon && cartModal) {
        cartIcon.addEventListener('click', async function () {
            cartModal.style.display = 'block';
            await loadCartPreview();
        });

        window.addEventListener('click', function (event) {
            if (event.target === cartModal) {
                cartModal.style.display = 'none';
            }
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', async function (e) {
            if (e.key === 'Enter') {
                const keyword = searchInput.value.trim();
                if (keyword) {
                    window.location.href = `products.php?search=${encodeURIComponent(keyword)}`;
                }
            }
        });
    }

    // Update cart count on page load
    if (document.querySelector('[href="account.php"]') || document.querySelector('[onclick="logout()"]')) {
        updateCartCount();
    }
});

async function loadCartPreview() {
    const cartContent = document.getElementById('cartContent');
    if (!cartContent) return;

    showLoader(cartContent);
    const result = await getCartItems();

    if (result.success && result.item_count > 0) {
        let html = '<div style="max-height: 400px; overflow-y: auto;">';
        result.items.forEach(item => {
            html += `
                <div class="cart-item" style="border-bottom: 1px solid #ECF0F1; padding: 10px 0;">
                    <div style="flex: 1;">
                        <h4 style="margin: 0 0 5px 0;">${item.name}</h4>
                        <p style="margin: 0; color: #FF8C42; font-weight: 600; font-size: 1.1rem;">$${parseFloat(item.price).toFixed(2)}</p>
                        <p style="margin: 5px 0 0 0; color: #7F8C8D; font-size: 0.9rem;">Qty: ${item.quantity}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="margin: 0; font-weight: 700;">$${(parseFloat(item.price) * item.quantity).toFixed(2)}</p>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        html += `<p style="margin-top: 20px; text-align: center; font-size: 1.1rem; font-weight: 700;">Total: $${parseFloat(result.total).toFixed(2)}</p>`;
        cartContent.innerHTML = html;
    } else {
        cartContent.innerHTML = '<p style="text-align: center; color: #7F8C8D;">Your cart is empty</p>';
    }
}

function closeCart() {
    const cartModal = document.getElementById('cartModal');
    if (cartModal) {
        cartModal.style.display = 'none';
    }
}

function closeModal() {
    const modal = document.getElementById('productModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// ==================== SCROLL ANIMATIONS ====================

const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -100px 0px'
};

const observer = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animated');
            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-card').forEach(card => {
        observer.observe(card);
    });
});

// ==================== FORM VALIDATION ====================

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    return password && password.length >= 6;
}

// ==================== CURRENCY FORMATTING ====================

function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

// ==================== LOCAL STORAGE ====================

function getLocalStorage(key) {
    return localStorage.getItem(key);
}

function setLocalStorage(key, value) {
    localStorage.setItem(key, value);
}

function removeLocalStorage(key) {
    localStorage.removeItem(key);
}

// ==================== UTILITIES ====================

function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}
