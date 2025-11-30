/**
 * JEKI BAKERS - Main JavaScript File
 * Modern Animations, Interactions & Form Handling
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize all features
    initScrollAnimations();
    initSmoothScroll();
    initFormValidation();
    initMobileMenu();
    initCartFunctionality();
    initProductFilters();
});

/* ============================================
   SCROLL ANIMATIONS
   ============================================ */

function initScrollAnimations() {
    const elements = document.querySelectorAll('.scroll-reveal');
    
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        });
        
        elements.forEach(el => observer.observe(el));
    } else {
        // Fallback for older browsers
        elements.forEach(el => el.classList.add('visible'));
    }
}

/* ============================================
   SMOOTH SCROLL
   ============================================ */

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/* ============================================
   FORM VALIDATION
   ============================================ */

function initFormValidation() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
            }
        });
    });
}

function validateForm(form) {
    const inputs = form.querySelectorAll('input, textarea, select');
    let isValid = true;
    
    inputs.forEach(input => {
        // Clear previous error
        const errorEl = input.nextElementSibling;
        if (errorEl && errorEl.classList.contains('error-message')) {
            errorEl.remove();
        }
        
        // Validate based on type
        if (!validateField(input)) {
            isValid = false;
            showFieldError(input);
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const type = field.type;
    const name = field.name;
    
    // Required check
    if (field.required && !value) {
        return false;
    }
    
    // Email validation
    if (type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            return false;
        }
    }
    
    // Phone validation (Kenya)
    if (name === 'phone' && value) {
        const phoneRegex = /^(\+254|0)[1-9]\d{8}$/;
        if (!phoneRegex.test(value.replace(/[\s-]/g, ''))) {
            return false;
        }
    }
    
    // Min length
    if (field.minLength && value.length < field.minLength) {
        return false;
    }
    
    // Max length
    if (field.maxLength && value.length > field.maxLength) {
        return false;
    }
    
    return true;
}

function showFieldError(field) {
    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.cssText = 'color: #E74C3C; font-size: 0.85rem; margin-top: 0.25rem;';
    
    let errorMessage = 'This field is required';
    
    if (field.type === 'email') {
        errorMessage = 'Please enter a valid email address';
    } else if (field.name === 'phone') {
        errorMessage = 'Please enter a valid Kenyan phone number';
    } else if (field.minLength) {
        errorMessage = `Minimum ${field.minLength} characters required`;
    }
    
    errorDiv.textContent = errorMessage;
    field.parentNode.insertBefore(errorDiv, field.nextSibling);
    
    field.style.borderColor = '#E74C3C';
}

/* ============================================
   MOBILE MENU
   ============================================ */

function initMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (!hamburger) return;
    
    hamburger.addEventListener('click', function() {
        this.classList.toggle('active');
        mobileMenu.classList.toggle('active');
    });
    
    // Close menu when link is clicked
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
        });
    });
}

/* ============================================
   CART FUNCTIONALITY
   ============================================ */

function initCartFunctionality() {
    // Add to cart buttons
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const quantity = parseInt(document.getElementById(`qty-${productId}`)?.value || 1);
            addToCart(productId, quantity);
        });
    });
    
    // Quantity adjusters
    document.querySelectorAll('.qty-decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.nextElementSibling;
            const current = parseInt(input.value);
            if (current > 1) input.value = current - 1;
        });
    });
    
    document.querySelectorAll('.qty-increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const current = parseInt(input.value);
            input.value = current + 1;
        });
    });
}

function addToCart(productId, quantity) {
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Product added to cart!', 'success');
            updateCartCount(data.cart_count);
        } else {
            showNotification('Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error adding to cart', 'error');
    });
}

function updateCartCount(count) {
    const cartCount = document.getElementById('cart-count');
    if (cartCount) {
        cartCount.textContent = count;
        cartCount.style.animation = 'none';
        setTimeout(() => {
            cartCount.style.animation = 'bounce 0.5s ease-in-out';
        }, 10);
    }
}

/* ============================================
   PRODUCT FILTERS
   ============================================ */

function initProductFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const products = document.querySelectorAll('.product-item');
    
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active button
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            
            // Filter products with animation
            products.forEach(product => {
                const category = product.dataset.category;
                
                if (filter === 'all' || category === filter) {
                    product.style.display = 'block';
                    setTimeout(() => {
                        product.classList.add('animate-scale-in');
                    }, 10);
                } else {
                    product.style.display = 'none';
                    product.classList.remove('animate-scale-in');
                }
            });
        });
    });
}

/* ============================================
   NOTIFICATIONS
   ============================================ */

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background: ${type === 'success' ? '#27AE60' : type === 'error' ? '#E74C3C' : '#3498DB'};
        color: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        animation: slideInRight 0.3s ease-out;
        max-width: 300px;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideInLeft 0.3s ease-out reverse';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

/* ============================================
   AJAX HELPERS
   ============================================ */

function fetchJSON(url, options = {}) {
    return fetch(url, {
        headers: {
            'Content-Type': 'application/json',
            ...options.headers
        },
        ...options
    }).then(response => {
        if (!response.ok) throw new Error('Network error');
        return response.json();
    });
}

/* ============================================
   UTILITIES
   ============================================ */

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

function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

/* ============================================
   LAZY LOADING IMAGES
   ============================================ */

function initLazyLoading() {
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        });
        
        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }
}

// Initialize lazy loading when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLazyLoading);
} else {
    initLazyLoading();
}

/* ============================================
   SCROLL TO TOP BUTTON
   ============================================ */

function initScrollToTop() {
    const scrollBtn = document.getElementById('scroll-to-top');
    
    if (!scrollBtn) return;
    
    window.addEventListener('scroll', throttle(() => {
        if (window.pageYOffset > 300) {
            scrollBtn.classList.add('visible');
        } else {
            scrollBtn.classList.remove('visible');
        }
    }, 100));
    
    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

document.addEventListener('DOMContentLoaded', initScrollToTop);
