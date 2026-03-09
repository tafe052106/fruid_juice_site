// Checkout Page JavaScript

document.addEventListener('DOMContentLoaded', function () {
    loadCheckoutData();
    setupCheckoutForm();
    setupBillingAddress();
});

async function loadCheckoutData() {
    const result = await getCartItems();

    if (result.success) {
        displayCheckoutItems(result.items);
        updateCheckoutTotals(result.total);
    }
}

function displayCheckoutItems(items) {
    const orderItems = document.getElementById('orderItems');
    if (!orderItems) return;

    orderItems.innerHTML = '';

    items.forEach(item => {
        const itemElement = document.createElement('div');
        itemElement.style.cssText = 'display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ECF0F1;';
        itemElement.innerHTML = `
            <div>
                <p style="margin: 0; font-weight: 600;">${item.name}</p>
                <p style="margin: 5px 0 0 0; color: #7F8C8D; font-size: 0.9rem;">Qty: ${item.quantity}</p>
            </div>
            <p style="margin: 0; font-weight: 600;">${(parseFloat(item.price) * item.quantity).toFixed(0)} CFA</p>
        `;
        orderItems.appendChild(itemElement);
    });
}

function updateCheckoutTotals(subtotal) {
    const tax = subtotal * TAX_RATE;
    const total = subtotal + tax + SHIPPING_COST;

    document.getElementById('checkoutSubtotal').textContent = formatCurrency(subtotal);
    document.getElementById('checkoutTax').textContent = formatCurrency(tax);
    document.getElementById('checkoutTotal').textContent = formatCurrency(total);
}

function setupBillingAddress() {
    const checkbox = document.getElementById('sameAsShipping');
    const billingForm = document.getElementById('billingAddressForm');

    if (checkbox && billingForm) {
        checkbox.addEventListener('change', function () {
            if (this.checked) {
                billingForm.style.display = 'none';
                billingForm.querySelectorAll('input').forEach(input => {
                    input.removeAttribute('required');
                });
            } else {
                billingForm.style.display = 'block';
                billingForm.querySelectorAll('input').forEach(input => {
                    input.setAttribute('required', 'required');
                });
            }
        });
        billingForm.style.display = 'none';
    }
}

function setupCheckoutForm() {
    const checkoutForm = document.getElementById('checkoutForm');
    if (!checkoutForm) return;

    checkoutForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(checkoutForm);
        
        const shippingAddress = `${formData.get('street_address')}, ${formData.get('city')}, ${formData.get('state')} ${formData.get('zip_code')}, ${formData.get('country')}`;
        
        let billingAddress = shippingAddress;
        const sameAsShipping = document.getElementById('sameAsShipping').checked;
        if (!sameAsShipping) {
            billingAddress = `${formData.get('billing_street')}, ${formData.get('billing_city')}, ${formData.get('billing_state')}`;
        }

        const result = await apiCall('create_order', 'POST', {
            shipping_address: shippingAddress,
            billing_address: billingAddress,
            payment_method: formData.get('payment_method')
        });

        if (result.success) {
            showAlert('success', 'Order placed successfully! Redirecting...');
            setTimeout(() => {
                window.location.href = `order-confirmation.php?order_id=${result.order_id}&order_number=${result.order_number}`;
            }, 2000);
        } else {
            showAlert('error', result.message);
        }
    });
}

// Format credit card input
document.addEventListener('DOMContentLoaded', function () {
    const cardInputs = document.querySelectorAll('input[placeholder*="1234"]');
    cardInputs.forEach(input => {
        input.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    });

    const expiryInput = document.querySelector('input[placeholder*="MM/YY"]');
    if (expiryInput) {
        expiryInput.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });
    }
});
