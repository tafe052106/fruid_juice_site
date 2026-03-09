// Products Page JavaScript

document.addEventListener('DOMContentLoaded', function () {
    loadCategories();
    loadProducts();
});

let currentFilters = {
    category_id: null,
    min_price: 0,
    max_price: 50,
    sort_by: 'popularity',
    search: new URLSearchParams(window.location.search).get('search') || ''
};

// Load categories
async function loadCategories() {
    const result = await apiCall('get_categories', 'GET');
    
    if (result.success) {
        const filterContainer = document.getElementById('categoryFilters');
        const categoryGrid = document.getElementById('categoriesGrid');

        if (filterContainer) {
            filterContainer.innerHTML = '';
            result.categories.forEach(category => {
                const label = document.createElement('label');
                label.className = 'checkbox-item';
                label.innerHTML = `
                    <input type="checkbox" value="${category.id}" onchange="applyFilters()">
                    <span>${category.name}</span>
                `;
                filterContainer.appendChild(label);
            });
        }

        // Display categories as cards on homepage
        if (categoryGrid) {
            categoryGrid.innerHTML = '';
            result.categories.forEach(category => {
                const card = document.createElement('div');
                card.className = 'product-card';
                card.style.cursor = 'pointer';
                card.innerHTML = `
                    <div class="product-image" style="font-size: 60px;">
                        ${getCategoryEmoji(category.name)}
                    </div>
                    <div class="product-info">
                        <h4>${category.name}</h4>
                        <p>${category.description}</p>
                        <a href="products.php?category=${category.id}" class="btn btn-primary btn-small" style="display: inline-block;">Shop</a>
                    </div>
                `;
                categoryGrid.appendChild(card);
            });
        }
    }
}

function getCategoryEmoji(categoryName) {
    const emojiMap = {
        'Citrus': '🍊',
        'Berry': '🫐',
        'Tropical': '🥭',
        'Mixed Fruit': '🍹',
        'Green & Vegetable': '🥬'
    };
    return emojiMap[categoryName] || '🥤';
}

// Load products
async function loadProducts() {
    const productsGrid = document.getElementById('productsGrid');
    const featuredProducts = document.getElementById('featuredProducts');

    // Load featured products on homepage
    if (featuredProducts) {
        showLoader(featuredProducts);
        const result = await apiCall('get_featured', 'GET', { limit: 6 });
        
        if (result.success) {
            displayProducts(result.products, featuredProducts);
        }
    }

    // Load all products on products page
    if (productsGrid) {
        showLoader(productsGrid);
        
        if (currentFilters.search) {
            const result = await apiCall('search_products', 'GET', { keyword: currentFilters.search });
            if (result.success) {
                displayProducts(result.products, productsGrid);
            }
        } else {
            const result = await apiCall('get_products', 'GET', currentFilters);
            if (result.success) {
                displayProducts(result.products, productsGrid);
            }
        }
    }
}

// Display products in grid
function displayProducts(products, container) {
    container.innerHTML = '';

    if (!products || products.length === 0) {
        container.innerHTML = '<p style="text-align: center; grid-column: 1 / -1;">No products found</p>';
        return;
    }

    products.forEach(product => {
        const productCard = document.createElement('div');
        productCard.className = 'product-card';
        productCard.innerHTML = `
            <div class="product-image">
                ${getProductEmoji(product.category_id)}
                ${product.discount_percentage > 0 ? `<div class="product-badge">-${product.discount_percentage}%</div>` : ''}
            </div>
            <div class="product-info">
                <div class="product-category">${getCategoryName(product.category_id)}</div>
                <h4 class="product-name">${product.name}</h4>
                <p class="product-description">${product.description.substring(0, 80)}...</p>
                <div class="product-rating">
                    <span class="stars">${getStarRating(product.rating)}</span>
                    <span class="rating-count">${product.total_reviews} reviews</span>
                </div>
                <div class="product-footer">
                    <div>
                        ${product.discount_percentage > 0 ? `<span class="original-price">${parseFloat(product.price).toFixed(0)} CFA</span>` : ''}
                        <span class="product-price">${(parseFloat(product.price) * (1 - product.discount_percentage / 100)).toFixed(0)} CFA</span>
                    </div>
                    <button class="btn btn-primary btn-small" onclick="addToCart(${product.id}, 1)">Add</button>
                </div>
            </div>
        `;

        productCard.addEventListener('click', function (e) {
            if (e.target.textContent !== 'Add') {
                showProductDetail(product.id);
            }
        });

        container.appendChild(productCard);
    });
}

// Get product emoji based on category
function getProductEmoji(categoryId) {
    const emojiMap = {
        1: '🍊',
        2: '🫐',
        3: '🥭',
        4: '🍹',
        5: '🥬'
    };
    return emojiMap[categoryId] || '🥤';
}

// Get category name
function getCategoryName(categoryId) {
    const categoryMap = {
        1: 'Citrus',
        2: 'Berry',
        3: 'Tropical',
        4: 'Mixed Fruit',
        5: 'Green & Vegetable'
    };
    return categoryMap[categoryId] || 'Juice';
}

// Get star rating display
function getStarRating(rating) {
    const fullStars = Math.floor(rating);
    const hasHalfStar = rating % 1 !== 0;
    let stars = '⭐'.repeat(fullStars);
    if (hasHalfStar) stars += '✨';
    return stars;
}

// Show product detail
async function showProductDetail(productId) {
    const modal = document.getElementById('productModal');
    const productDetail = document.getElementById('productDetail');

    if (!modal || !productDetail) return;

    showLoader(productDetail);
    modal.style.display = 'block';

    const result = await apiCall('get_product', 'GET', { id: productId });

    if (result.success) {
        const product = result.product;
        const discountedPrice = parseFloat(product.price) * (1 - product.discount_percentage / 100);

        productDetail.innerHTML = `
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div style="text-align: center;">
                    <div class="product-image" style="height: 300px; font-size: 100px;">
                        ${getProductEmoji(product.category_id)}
                    </div>
                </div>
                <div>
                    <div class="product-category">${getCategoryName(product.category_id)}</div>
                    <h2>${product.name}</h2>
                    <div class="product-rating" style="margin-bottom: 20px;">
                        <span class="stars">${getStarRating(product.rating)}</span>
                        <span class="rating-count">${product.total_reviews} reviews</span>
                    </div>
                    <p>${product.description}</p>
                    <div style="margin: 20px 0;">
                        <h3 style="margin-bottom: 10px;">
                            ${product.discount_percentage > 0 ? `<span style="text-decoration: line-through; color: #7F8C8D;">$${parseFloat(product.price).toFixed(2)}</span> ` : ''}
                            <span style="color: #FF8C42;">$${discountedPrice.toFixed(2)}</span>
                        </h3>
                        ${product.quantity_in_stock > 0 ? `<p style="color: #2ECC71; font-weight: 600;">In Stock</p>` : `<p style="color: #E74C3C; font-weight: 600;">Out of Stock</p>`}
                    </div>
                    <div style="display: flex; gap: 10px; margin-top: 20px;">
                        <input type="number" id="productQuantity" min="1" max="${product.quantity_in_stock}" value="1" style="width: 80px; padding: 10px; border: 2px solid #ECF0F1; border-radius: 8px;">
                        <button class="btn btn-primary" onclick="addToCartFromDetail(${product.id})" ${product.quantity_in_stock === 0 ? 'disabled' : ''}>Add to Cart</button>
                    </div>
                    <div style="margin-top: 20px; padding: 20px; background: #f9f9f9; border-radius: 8px;">
                        <h4>About this juice</h4>
                        <ul style="color: #7F8C8D; line-height: 2;">
                            <li>✓ 100% Fresh Ingredients</li>
                            <li>✓ No Artificial Additives</li>
                            <li>✓ Rich in Vitamins & Minerals</li>
                            <li>✓ Fast & Free Shipping</li>
                        </ul>
                    </div>
                </div>
            </div>
        `;
    }
}

function addToCartFromDetail(productId) {
    const quantity = parseInt(document.getElementById('productQuantity')?.value || 1);
    addToCart(productId, quantity);
    closeModal();
}

// Apply filters
async function applyFilters() {
    const categoryCheckboxes = document.querySelectorAll('#categoryFilters input:checked');
    currentFilters.category_id = categoryCheckboxes.length > 0 ? categoryCheckboxes[0].value : null;

    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        currentFilters.max_price = priceRange.value;
        document.getElementById('priceDisplay').textContent = '$' + priceRange.value;
    }

    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        currentFilters.sort_by = sortBy.value;
    }

    loadProducts();
}

function resetFilters() {
    currentFilters = {
        category_id: null,
        min_price: 0,
        max_price: 50,
        sort_by: 'popularity'
    };

    document.querySelectorAll('#categoryFilters input').forEach(input => input.checked = false);
    const priceRange = document.getElementById('priceRange');
    if (priceRange) {
        priceRange.value = 50;
        document.getElementById('priceDisplay').textContent = '$50';
    }

    const sortBy = document.getElementById('sortBy');
    if (sortBy) {
        sortBy.value = 'popularity';
    }

    loadProducts();
}
