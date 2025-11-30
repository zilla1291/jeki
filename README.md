# Jeki Bakers - Professional Bakery Website

A fully-featured, modern, professional bakery website built with PHP, MySQL, and advanced frontend technologies. Designed and optimized for Jeki Bakers, a premium bakery in Kenya.

## Features

### Frontend
- ✨ **Responsive Design** - Works perfectly on all devices (desktop, tablet, mobile)
- 🎨 **Modern UI/UX** - Professional color scheme with golden and brown tones
- 🎬 **Smooth Animations** - Scroll animations, hover effects, and transitions
- 📱 **Mobile First** - Optimized for mobile experience
- ♿ **Accessibility** - WCAG compliant, semantic HTML
- 🚀 **Performance** - Lazy loading, optimized CSS/JS
- 📊 **SEO Friendly** - Proper meta tags and structure

### Backend
- 🔐 **Secure Authentication** - Bcrypt password hashing, session management
- 🛒 **E-commerce Features** - Shopping cart, product management, orders
- 💾 **Database** - MySQL with normalized schema
- 📧 **Contact Forms** - Email notification system
- 👨‍💼 **Admin Panel** - Product management, order tracking, user management
- 🔔 **Notifications** - Toast notifications for user actions
- 📦 **API Ready** - RESTful endpoints for cart and product operations

### Advanced Features
- ⭐ **Product Reviews & Ratings** - Customer testimonials
- 🎯 **Product Categories** - Organized product listings
- 📰 **Newsletter** - Email subscription management
- 🔍 **Search & Filter** - Find products easily
- 🎁 **Discounts** - Apply coupon codes and discounts
- 📱 **Order Tracking** - Track order status in real-time
- 👤 **User Accounts** - Customer profiles and order history

## Technology Stack

### Frontend
- **HTML5** - Semantic structure
- **CSS3** - Modern styling with CSS Variables, Flexbox, Grid
- **JavaScript (ES6+)** - Modern vanilla JavaScript
- **Google Fonts** - Poppins, Playfair Display, Inter fonts
- **SVG** - Scalable graphics

### Backend
- **PHP 7.4+** - Server-side logic
- **MySQL/MariaDB** - Relational database
- **PDO** - Database abstraction layer
- **Composer** (optional) - Dependency management

## Project Structure

```
jeki-bakers-website/
├── public/
│   ├── index.php              # Main homepage
│   ├── login.php              # Login page
│   ├── register.php           # Registration page
│   └── [other pages]
├── src/
│   ├── php/
│   │   ├── Router.php         # URL routing
│   │   ├── Database.php       # Database helper
│   │   └── Auth.php           # Authentication
│   ├── css/
│   │   └── styles.css         # Main stylesheet
│   └── js/
│       └── main.js            # Main JavaScript
├── assets/
│   ├── images/                # Product and page images
│   └── fonts/                 # Custom fonts (if any)
├── config/
│   ├── constants.php          # Application constants
│   └── database.php           # Database configuration
├── database/
│   └── schema.sql             # Database schema
└── README.md

```

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.3
- Web server (Apache/Nginx)

### Step 1: Clone or Download
```bash
git clone https://github.com/yourusername/jeki-bakers-website.git
cd jeki-bakers-website
```

### Step 2: Configure Database
1. Open `config/database.php`
2. Update database credentials:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'jeki_bakers_db');
```

### Step 3: Create Database
```bash
# Using MySQL command line
mysql -u your_username -p < database/schema.sql

# Or import via phpMyAdmin
```

### Step 4: Configure Environment
1. Update `config/constants.php` with your business information
2. Set up SMTP email settings
3. Configure social media URLs

### Step 5: Set Permissions
```bash
# On Linux/Mac
chmod 755 -R public/
chmod 755 -R assets/
```

### Step 6: Access the Website
Navigate to: `http://localhost/jeki-bakers-website/public/`

## Configuration Files

### config/database.php
Database connection settings and PDO configuration.

### config/constants.php
Application-wide constants:
- Business information
- Email settings
- Social media URLs
- File upload limits
- Payment gateway settings (if applicable)

## Database Schema

The application includes the following tables:
- **users** - Customer and admin accounts
- **categories** - Product categories
- **products** - Product listings
- **orders** - Customer orders
- **order_items** - Order line items
- **cart** - Shopping cart
- **reviews** - Product reviews
- **contact_messages** - Contact form submissions
- **newsletter_subscribers** - Newsletter emails
- **testimonials** - Customer testimonials
- **activity_log** - System activity tracking

## Default Credentials

**Admin Account:**
- Email: `admin@jekibakers.co.ke`
- Password: `admin123`

⚠️ **IMPORTANT**: Change these credentials immediately after first login!

## API Endpoints

### Cart Management
```
POST /api/cart/add
    - product_id (int)
    - quantity (int)

POST /api/cart/remove
    - product_id (int)

GET /api/cart/items
```

### Products
```
GET /api/products
    - category (optional)
    - search (optional)
    - sort (optional)
```

## Security Features

- ✅ Password hashing with Bcrypt
- ✅ SQL injection prevention with prepared statements
- ✅ CSRF token validation (can be added)
- ✅ Input validation and sanitization
- ✅ Secure session management
- ✅ XSS prevention with output escaping
- ✅ HTTPS ready
- ✅ Role-based access control

## Performance Optimization

- 🚀 CSS and JS minification ready
- 📦 Image lazy loading
- 💾 Database query optimization
- 🔄 CSS Grid and Flexbox for efficient layouts
- ⚡ Smooth scroll animations
- 📱 Mobile-first responsive design

## Browser Support

- ✅ Chrome/Chromium (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Edge (latest)
- ✅ Mobile browsers (iOS Safari, Chrome Mobile)

## Customization

### Colors
Edit CSS variables in `src/css/styles.css`:
```css
:root {
    --primary-color: #D4A574;
    --secondary-color: #8B4513;
    --accent-color: #F4E4C1;
    /* ... more variables */
}
```

### Business Information
Update `config/constants.php` with your business details.

### Adding Products
1. Log in as admin
2. Navigate to admin panel
3. Add products with images, prices, and descriptions

## Email Configuration

To enable email notifications, configure SMTP settings in `config/constants.php`:

```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-app-password');
```

## Backup & Maintenance

### Database Backup
```bash
mysqldump -u username -p database_name > backup.sql
```

### Restore Database
```bash
mysql -u username -p database_name < backup.sql
```

## Troubleshooting

### Database Connection Error
- Check database credentials in `config/database.php`
- Ensure MySQL server is running
- Verify database name exists

### 404 Errors
- Check .htaccess file (if using Apache)
- Verify BASE_URL in `config/constants.php`
- Check file permissions

### CSS/JS Not Loading
- Verify ASSETS_URL path in `config/constants.php`
- Check browser console for 404 errors
- Clear browser cache

## Support & Contact

For issues and inquiries:
- **Email**: admin@jekibakers.co.ke
- **Phone**: +254712345678
- **Location**: Nairobi, Kenya

## License

This project is proprietary to Jeki Bakers. All rights reserved.

## Credits

Developed with ❤️ for Jeki Bakers, Kenya.

---

**Version**: 1.0.0  
**Last Updated**: November 2025  
**Status**: Production Ready ✅
