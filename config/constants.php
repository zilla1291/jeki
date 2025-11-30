<?php
/**
 * Application Constants
 */

// File paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('SRC_PATH', ROOT_PATH . '/src');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('CONFIG_PATH', ROOT_PATH . '/config');
define('DATABASE_PATH', ROOT_PATH . '/database');

// Base URL (adjust based on your server)
define('BASE_URL', 'http://localhost/jeki-bakers-website/public/');
define('ASSETS_URL', BASE_URL . '../assets/');

// Pagination
define('ITEMS_PER_PAGE', 12);
define('ADMIN_ITEMS_PER_PAGE', 20);

// File upload limits
define('MAX_UPLOAD_SIZE', 5242880); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'webp']);
define('ALLOWED_FILE_TYPES', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);

// Session timeout
define('SESSION_TIMEOUT', 3600); // 1 hour

// Admin panel settings
define('ADMIN_TIMEZONE', 'Africa/Nairobi');
define('ADMIN_RECORDS_PER_PAGE', 25);

// Email settings
define('SMTP_HOST', 'your_smtp_host');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your_email');
define('SMTP_PASS', 'your_password');
define('ADMIN_EMAIL', 'admin@jekibakers.co.ke');
define('SUPPORT_EMAIL', 'support@jekibakers.co.ke');

// Social media
define('FACEBOOK_URL', 'https://facebook.com/jekibakers');
define('INSTAGRAM_URL', 'https://instagram.com/jekibakers');
define('TWITTER_URL', 'https://twitter.com/jekibakers');
define('WHATSAPP_NUMBER', '+254712345678');

// Business info
define('BUSINESS_NAME', 'Jeki Bakers');
define('BUSINESS_PHONE', '+254712345678');
define('BUSINESS_EMAIL', 'info@jekibakers.co.ke');
define('BUSINESS_ADDRESS', 'Nairobi, Kenya');
define('BUSINESS_HOURS', 'Mon-Sat: 6AM - 8PM, Sun: 7AM - 6PM');
?>
