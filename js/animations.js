// Animations and Effects

// Intersection Observer for scroll animations
const animationObserver = new IntersectionObserver(function (entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
            animationObserver.unobserve(entry.target);
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

// Apply animation observer to elements
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-card, .testimonial-card, .footer-section').forEach(el => {
        animationObserver.observe(el);
    });

    // Add smooth scroll to anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#') {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Smooth scroll for buttons
    document.querySelectorAll('button[class*="btn"]').forEach(btn => {
        btn.addEventListener('mousedown', function () {
            this.style.transform = 'scale(0.98)';
        });

        btn.addEventListener('mouseup', function () {
            this.style.transform = 'scale(1)';
        });
    });

    // Add parallax effect to hero section
    const hero = document.querySelector('.hero');
    if (hero) {
        window.addEventListener('scroll', function () {
            const scrollPosition = window.pageYOffset;
            hero.style.backgroundPosition = `0% ${scrollPosition * 0.5}px`;
        });
    }

    // Fade in images as they load
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('load', function () {
            this.style.opacity = '1';
        });
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
    });

    // Add ripple effect to buttons
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function (e) {
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.position = 'absolute';
            ripple.style.width = '20px';
            ripple.style.height = '20px';
            ripple.style.background = 'rgba(255, 255, 255, 0.5)';
            ripple.style.borderRadius = '50%';
            ripple.style.pointerEvents = 'none';
            ripple.style.animation = 'ripple 0.6s ease-out';

            if (this.style.position !== 'absolute' && this.style.position !== 'fixed') {
                this.style.position = 'relative';
                this.style.overflow = 'hidden';
            }

            this.appendChild(ripple);

            setTimeout(() => ripple.remove(), 600);
        });
    });
});

// Ripple animation
const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to {
            width: 200px;
            height: 200px;
            opacity: 0;
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animated {
        animation: fadeInUp 0.6s ease forwards;
    }
`;
document.head.appendChild(style);

// Add click feedback to form inputs
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input, textarea, select').forEach(input => {
        input.addEventListener('focus', function () {
            this.style.boxShadow = '0 0 0 3px rgba(255, 140, 66, 0.1)';
        });

        input.addEventListener('blur', function () {
            this.style.boxShadow = 'none';
        });
    });
});

// Add tooltip functionality
function showTooltip(element, message) {
    const tooltip = document.createElement('div');
    tooltip.style.cssText = `
        position: absolute;
        background: #2C3E50;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 0.85rem;
        white-space: nowrap;
        z-index: 1000;
        animation: slideUp 0.3s ease;
    `;
    tooltip.textContent = message;

    const rect = element.getBoundingClientRect();
    tooltip.style.left = rect.left + 'px';
    tooltip.style.top = (rect.top - 40) + 'px';

    document.body.appendChild(tooltip);

    setTimeout(() => {
        tooltip.style.opacity = '0';
        tooltip.style.transition = 'opacity 0.3s ease';
        setTimeout(() => tooltip.remove(), 300);
    }, 2000);
}

// Page load animation
window.addEventListener('load', function () {
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 10);
});

// Add loading state to buttons
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !this.id.includes('contact')) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Processing...';

                // Re-enable after a timeout
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.textContent = originalText;
                }, 2000);
            }
        });
    });
});

// Lazy load images
if ('IntersectionObserver' in window) {
    const lazyImages = document.querySelectorAll('[data-lazy]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.lazy;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });

    lazyImages.forEach(img => imageObserver.observe(img));
}

// Add page transition effect
function pageTransition(url) {
    const overlay = document.createElement('div');
    overlay.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #FF8C42, #2ECC71);
        opacity: 0;
        z-index: 9999;
        transition: opacity 0.5s ease;
    `;

    document.body.appendChild(overlay);

    setTimeout(() => {
        overlay.style.opacity = '1';
    }, 10);

    setTimeout(() => {
        window.location.href = url;
    }, 500);
}

// Visibility API - pause animations when tab is not visible
document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
        document.querySelectorAll('[style*="animation"]').forEach(el => {
            el.style.animationPlayState = 'paused';
        });
    } else {
        document.querySelectorAll('[style*="animation"]').forEach(el => {
            el.style.animationPlayState = 'running';
        });
    }
});
