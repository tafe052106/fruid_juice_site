// Account Page JavaScript

document.addEventListener('DOMContentLoaded', function () {
    setupAccountPage();
});

function setupAccountPage() {
    // Profile form
    const profileForm = document.getElementById('profileForm');
    if (profileForm) {
        profileForm.addEventListener('submit', handleProfileUpdate);
    }

    // Password form
    const passwordForm = document.getElementById('passwordForm');
    if (passwordForm) {
        passwordForm.addEventListener('submit', handlePasswordChange);
    }

    // Load orders
    loadUserOrders();

    // Tab switching
    setupTabNavigation();
}

function setupTabNavigation() {
    const menuButtons = document.querySelectorAll('.menu-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    menuButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            if (this.textContent.includes('Logout')) return;

            e.preventDefault();

            // Remove active class from all buttons
            menuButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Hide all tabs
            tabContents.forEach(tab => tab.classList.add('hidden'));

            // Show selected tab
            const tabId = this.textContent.split(' ')[1]?.toLowerCase() + '-tab' || 
                         (this.textContent.toLowerCase().includes('profile') ? 'profile-tab' :
                          this.textContent.toLowerCase().includes('orders') ? 'orders-tab' :
                          this.textContent.toLowerCase().includes('address') ? 'addresses-tab' :
                          this.textContent.toLowerCase().includes('password') ? 'password-tab' : 'profile-tab');

            const selectedTab = document.getElementById(tabId);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
            }
        });
    });
}

async function handleProfileUpdate(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const data = {
        first_name: formData.get('first_name'),
        last_name: formData.get('last_name'),
        phone: formData.get('phone'),
        address: formData.get('address'),
        city: formData.get('city'),
        state: formData.get('state'),
        zip_code: formData.get('zip_code'),
        country: formData.get('country')
    };

    const result = await apiCall('update_profile', 'POST', data);

    const alertContainer = document.getElementById('alertContainer');
    if (alertContainer) {
        if (result.success) {
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-success';
            alertDiv.textContent = result.message;
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alertDiv);

            setTimeout(() => alertDiv.remove(), 5000);
        } else {
            showAlert('error', result.message);
        }
    }
}

async function handlePasswordChange(e) {
    e.preventDefault();

    const oldPassword = e.target.querySelector('input[name="old_password"]').value;
    const newPassword = e.target.querySelector('input[name="new_password"]').value;
    const confirmPassword = e.target.querySelector('input[name="confirm_password"]').value;

    // Validation
    if (!validatePassword(oldPassword)) {
        showAlert('error', 'Current password is required');
        return;
    }

    if (!validatePassword(newPassword)) {
        showAlert('error', 'New password must be at least 6 characters');
        return;
    }

    if (newPassword !== confirmPassword) {
        showAlert('error', 'New passwords do not match');
        return;
    }

    if (oldPassword === newPassword) {
        showAlert('error', 'New password must be different from current password');
        return;
    }

    const result = await apiCall('change_password', 'POST', {
        old_password: oldPassword,
        new_password: newPassword
    });

    const alertContainer = document.getElementById('passwordAlertContainer');
    if (alertContainer) {
        const alertDiv = document.createElement('div');
        alertDiv.className = result.success ? 'alert alert-success' : 'alert alert-error';
        alertDiv.textContent = result.message;
        alertContainer.innerHTML = '';
        alertContainer.appendChild(alertDiv);

        if (result.success) {
            e.target.reset();
        }

        setTimeout(() => alertDiv.remove(), 5000);
    }
}

async function loadUserOrders() {
    const ordersList = document.getElementById('ordersList');
    if (!ordersList) return;

    showLoader(ordersList);

    const result = await apiCall('get_user_orders', 'GET');

    if (result.success && result.orders.length > 0) {
        ordersList.innerHTML = '';
        result.orders.forEach(order => {
            const orderElement = document.createElement('div');
            orderElement.style.cssText = 'padding: 20px; border: 1px solid #ECF0F1; border-radius: 8px; margin-bottom: 15px;';
            orderElement.innerHTML = `
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <h4 style="margin: 0 0 8px 0;">Order ${order.order_number}</h4>
                        <p style="margin: 0; color: #7F8C8D; font-size: 0.9rem;">${formatDate(order.created_at)}</p>
                    </div>
                    <div style="text-align: right;">
                        <p style="margin: 0; font-size: 1.2rem; font-weight: 700; color: #FF8C42;">$${parseFloat(order.total_amount).toFixed(2)}</p>
                        <span style="display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; 
                            background: ${getStatusBadgeColor(order.status)}; color: white; margin-top: 5px;">
                            ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                        </span>
                    </div>
                </div>
            `;
            ordersList.appendChild(orderElement);
        });
    } else {
        ordersList.innerHTML = '<p style="text-align: center; color: #7F8C8D;">No orders yet. Start shopping now!</p>';
    }
}

function getStatusBadgeColor(status) {
    const colors = {
        'pending': '#F39C12',
        'processing': '#3498DB',
        'shipped': '#2ECC71',
        'delivered': '#27AE60',
        'cancelled': '#E74C3C'
    };
    return colors[status] || '#95A5A6';
}

function switchTab(tabName) {
    const tabContents = document.querySelectorAll('.tab-content');
    const menuButtons = document.querySelectorAll('.menu-btn');

    // Hide all tabs
    tabContents.forEach(tab => tab.classList.add('hidden'));

    // Remove active from all buttons
    menuButtons.forEach(btn => btn.classList.remove('active'));

    // Show selected tab
    const selectedTab = document.getElementById(tabName + '-tab');
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }

    // Activate button
    const buttons = {
        'profile': 0,
        'orders': 1,
        'addresses': 2,
        'password': 3
    };

    if (buttons[tabName] !== undefined) {
        menuButtons[buttons[tabName]].classList.add('active');
    }
}
