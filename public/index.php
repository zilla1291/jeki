<?php
/**
 * JEKI BAKERS - Main Application File
 * Professional Bakery Website - Kenya
 */

// Start session
session_start();

// Include configuration files
require_once dirname(__DIR__) . '/config/constants.php';
require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/src/php/Database.php';
require_once dirname(__DIR__) . '/src/php/Auth.php';
require_once dirname(__DIR__) . '/src/php/Router.php';

// Initialize database
$db = new Database($pdo);

// Initialize authentication
$auth = new Auth($db);

// Get current user if logged in
$currentUser = $auth->isLoggedIn() ? $auth->getUser() : null;

// Get cart count
$cartCount = 0;
if ($auth->isLoggedIn()) {
    $cartCount = $db->count('cart', 'user_id = ' . $_SESSION['user_id']);
}

// Get featured products
$featuredProducts = $db->select(
    "SELECT * FROM products WHERE featured = 1 AND status = 'active' ORDER BY views DESC LIMIT 6"
);

// Get categories
$categories = $db->select("SELECT * FROM categories WHERE status = 'active'");

// Get testimonials
$testimonials = $db->select(
    "SELECT * FROM testimonials WHERE status = 'approved' ORDER BY created_at DESC LIMIT 5"
);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Jeki Bakers - Premium baked goods and pastries in Kenya. Handcrafted with love since 2020.">
    <meta name="keywords" content="bakery, bread, cakes, pastries, Kenya, Nairobi">
    <meta name="author" content="Jeki Bakers">
    
    <title><?php echo APP_NAME; ?> - Premium Baked Goods in Kenya</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>css/styles.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='75' font-size='75' fill='%23D4A574'>🍰</text></svg>">
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="container">
            <div class="logo">
                🍰 <?php echo APP_NAME; ?>
            </div>
            
            <ul class="nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <?php if ($auth->isLoggedIn()): ?>
                    <li><a href="?page=account">Account</a></li>
                    <li><a href="?page=logout">Logout</a></li>
                <?php else: ?>
                    <li><a href="?page=login">Login</a></li>
                <?php endif; ?>
                <li><a href="?page=cart" class="cart-link">🛒 <span id="cart-count"><?php echo $cartCount; ?></span></a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content container">
            <h1>Welcome to Jeki Bakers</h1>
            <p>Handcrafted, Premium Baked Goods Made with Love</p>
            <p>Fresh from our oven to your table, every single day</p>
            <a href="#products" class="btn btn-primary btn-lg">Explore Our Products</a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="products">
        <div class="container">
            <div class="section-title">
                <h2>Featured Products</h2>
                <p class="section-subtitle">Discover our most popular selections</p>
            </div>
            
            <?php if ($featuredProducts): ?>
                <div class="grid grid-3">
                    <?php foreach ($featuredProducts as $product): ?>
                        <div class="card scroll-reveal">
                            <div class="card-image">
                                <img src="<?php echo ASSETS_URL; ?>images/placeholder-product.jpg" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     data-src="<?php echo htmlspecialchars($product['image']); ?>">
                            </div>
                            <div class="card-body">
                                <h3 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p class="card-text"><?php echo substr(htmlspecialchars($product['description']), 0, 100) . '...'; ?></p>
                                <div class="card-price">
                                    KES <?php echo number_format($product['price'], 2); ?>
                                </div>
                                <div class="flex gap-1">
                                    <input type="number" id="qty-<?php echo $product['id']; ?>" 
                                           value="1" min="1" style="width: 60px; padding: 8px;">
                                    <button class="btn btn-primary btn-add-cart flex-grow" 
                                            data-product-id="<?php echo $product['id']; ?>">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: #999;">No products available yet.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Categories Section -->
    <section style="background: #f9f9f9;">
        <div class="container">
            <div class="section-title">
                <h2>Our Categories</h2>
                <p class="section-subtitle">Browse our collection</p>
            </div>
            
            <div class="grid grid-4">
                <?php foreach ($categories as $category): ?>
                    <div class="card scroll-reveal text-center" style="cursor: pointer;">
                        <div style="padding: 40px 20px; font-size: 3rem;">
                            <?php 
                            $icons = [
                                'bread' => '🍞',
                                'cakes' => '🎂',
                                'pastries' => '🥐',
                                'cookies' => '🍪',
                                'specialty-items' => '✨'
                            ];
                            echo $icons[$category['slug']] ?? '🍰';
                            ?>
                        </div>
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="section-title">
                <h2>About Jeki Bakers</h2>
            </div>
            
            <div class="grid grid-2" style="align-items: center; gap: 3rem;">
                <div class="scroll-reveal">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 400 300'><rect fill='%23F4E4C1' width='400' height='300'/><text x='50%' y='50%' font-size='100' fill='%23D4A574' text-anchor='middle' dominant-baseline='middle'>🏪</text></svg>" 
                         alt="Jeki Bakers Storefront" style="width: 100%; border-radius: 12px;">
                </div>
                
                <div class="scroll-reveal">
                    <h3>Crafted with Passion Since 2020</h3>
                    <p>Jeki Bakers is a proudly Kenyan bakery committed to delivering the finest baked goods in Nairobi and beyond. We use only premium ingredients and traditional baking methods to ensure every bite is exceptional.</p>
                    
                    <h4 style="margin-top: 1.5rem;">Why Choose Us?</h4>
                    <ul style="list-style: none; margin-top: 1rem;">
                        <li style="margin-bottom: 0.8rem;">✓ <strong>Fresh Daily</strong> - Baked fresh every morning</li>
                        <li style="margin-bottom: 0.8rem;">✓ <strong>Premium Ingredients</strong> - Only the finest quality</li>
                        <li style="margin-bottom: 0.8rem;">✓ <strong>Custom Orders</strong> - Personalized for your needs</li>
                        <li style="margin-bottom: 0.8rem;">✓ <strong>Fast Delivery</strong> - Quick delivery across Nairobi</li>
                        <li style="margin-bottom: 0.8rem;">✓ <strong>Best Prices</strong> - Affordable quality</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <?php if ($testimonials): ?>
        <section style="background: var(--gradient-primary); color: white;">
            <div class="container">
                <div class="section-title">
                    <h2 style="color: white;">What Our Customers Say</h2>
                </div>
                
                <div class="grid grid-3">
                    <?php foreach ($testimonials as $testimonial): ?>
                        <div class="card scroll-reveal" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);">
                            <div class="card-body">
                                <div style="color: #FFD700; margin-bottom: 1rem;">
                                    <?php echo str_repeat('★', $testimonial['rating']); ?>
                                </div>
                                <p style="color: white; margin-bottom: 1rem;"><?php echo htmlspecialchars($testimonial['content']); ?></p>
                                <strong style="color: #F4E4C1;"><?php echo htmlspecialchars($testimonial['author_name']); ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container-sm">
            <div class="section-title">
                <h2>Get In Touch</h2>
                <p class="section-subtitle">We'd love to hear from you</p>
            </div>
            
            <form method="POST" action="?page=contact" class="scroll-reveal">
                <div class="grid grid-2">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="+254712345678">
                </div>
                
                <div class="form-group">
                    <label for="subject">Subject *</label>
                    <input type="text" id="subject" name="subject" required>
                </div>
                
                <div class="form-group">
                    <label for="message">Message *</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary btn-lg btn-block">Send Message</button>
            </form>
            
            <!-- Contact Information -->
            <div class="grid grid-3" style="margin-top: 3rem;">
                <div class="text-center scroll-reveal">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📍</div>
                    <h4>Location</h4>
                    <p><?php echo BUSINESS_ADDRESS; ?></p>
                </div>
                <div class="text-center scroll-reveal">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📞</div>
                    <h4>Phone</h4>
                    <p><?php echo BUSINESS_PHONE; ?></p>
                </div>
                <div class="text-center scroll-reveal">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📧</div>
                    <h4>Email</h4>
                    <p><?php echo BUSINESS_EMAIL; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section style="background: #f9f9f9;">
        <div class="container-sm text-center">
            <h2>Subscribe to Our Newsletter</h2>
            <p>Get the latest updates on new products and special offers</p>
            
            <form method="POST" action="?page=subscribe" style="margin-top: 2rem; display: flex; gap: 1rem;">
                <input type="email" name="email" placeholder="Enter your email" required style="flex: 1;">
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-section">
                    <h4>About Jeki Bakers</h4>
                    <p>Premium bakery providing fresh baked goods daily to Kenya.</p>
                    <div style="margin-top: 1rem;">
                        <a href="<?php echo FACEBOOK_URL; ?>" style="margin-right: 1rem;">Facebook</a>
                        <a href="<?php echo INSTAGRAM_URL; ?>" style="margin-right: 1rem;">Instagram</a>
                        <a href="<?php echo TWITTER_URL; ?>">Twitter</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#products">Products</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Business Hours</h4>
                    <p><?php echo BUSINESS_HOURS; ?></p>
                    <p style="margin-top: 1rem;">
                        <strong>WhatsApp:</strong><br>
                        <a href="https://wa.me/<?php echo str_replace('+', '', WHATSAPP_NUMBER); ?>"><?php echo WHATSAPP_NUMBER; ?></a>
                    </p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. All rights reserved. Handcrafted with ❤️ in Kenya.</p>
                <p>
                    <a href="#" style="color: var(--primary-color);">Privacy Policy</a> | 
                    <a href="#" style="color: var(--primary-color);">Terms of Service</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button -->
    <button id="scroll-to-top" style="
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: var(--gradient-primary);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        box-shadow: var(--shadow-lg);
        z-index: 999;
    ">↑</button>

    <!-- JavaScript -->
    <script src="<?php echo ASSETS_URL; ?>js/main.js"></script>
</body>
</html>
