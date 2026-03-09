// Authentication JavaScript

document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }

    if (registerForm) {
        registerForm.addEventListener('submit', handleRegister);
    }
});

async function handleLogin(e) {
    e.preventDefault();

    const email = e.target.querySelector('input[name="email"]').value;
    const password = e.target.querySelector('input[name="password"]').value;

    if (!validateEmail(email)) {
        showAlert('error', 'Please enter a valid email address');
        return;
    }

    if (!validatePassword(password)) {
        showAlert('error', 'Password must be at least 6 characters');
        return;
    }

    const result = await apiCall('login', 'POST', {
        email: email,
        password: password
    });

    if (result.success) {
        showAlert('success', 'Login successful! Redirecting...');
        setTimeout(() => {
            window.location.href = 'account.php';
        }, 1500);
    } else {
        showAlert('error', result.message);
    }
}

async function handleRegister(e) {
    e.preventDefault();

    const username = e.target.querySelector('input[name="username"]').value.trim();
    const email = e.target.querySelector('input[name="email"]').value;
    const firstName = e.target.querySelector('input[name="first_name"]').value.trim();
    const lastName = e.target.querySelector('input[name="last_name"]').value.trim();
    const password = e.target.querySelector('input[name="password"]').value;
    const confirmPassword = e.target.querySelector('input[name="confirm_password"]').value;
    const termsCheckbox = e.target.querySelector('input[type="checkbox"]');

    // Validation
    if (!username) {
        showAlert('error', 'Username is required');
        return;
    }

    if (!validateEmail(email)) {
        showAlert('error', 'Please enter a valid email address');
        return;
    }

    if (!firstName || !lastName) {
        showAlert('error', 'First and last name are required');
        return;
    }

    if (!validatePassword(password)) {
        showAlert('error', 'Password must be at least 6 characters');
        return;
    }

    if (password !== confirmPassword) {
        showAlert('error', 'Passwords do not match');
        return;
    }

    if (!termsCheckbox.checked) {
        showAlert('error', 'You must agree to the terms of service');
        return;
    }

    const result = await apiCall('register', 'POST', {
        username: username,
        email: email,
        password: password,
        confirm_password: confirmPassword,
        first_name: firstName,
        last_name: lastName
    });

    if (result.success) {
        showAlert('success', result.message + ' Redirecting to login...');
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000);
    } else {
        showAlert('error', result.message);
    }
}
