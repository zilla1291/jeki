# Jeki Bakers Website - Installation & Setup Guide

## Quick Start (5 Minutes)

### 1. Prerequisites
Ensure you have installed:
- PHP 7.4 or higher (`php -v`)
- MySQL 5.7+ or MariaDB (`mysql --version`)
- Apache with mod_rewrite enabled OR Nginx

### 2. File Placement
Place the project in your web root:
- **Apache**: `C:\xampp\htdocs\` or `/var/www/html/`
- **Nginx**: `/usr/share/nginx/html/` or similar

### 3. Database Setup

#### Option A: Using Command Line
```bash
# Login to MySQL
mysql -u root -p

# Create database and user
CREATE DATABASE jeki_bakers_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'jeki_bakers_user'@'localhost' IDENTIFIED BY 'secure_password_here';
GRANT ALL PRIVILEGES ON jeki_bakers_db.* TO 'jeki_bakers_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Import schema
mysql -u jeki_bakers_user -p jeki_bakers_db < database/schema.sql
```

#### Option B: Using phpMyAdmin
1. Go to `http://localhost/phpmyadmin`
2. Create new database: `jeki_bakers_db`
3. Go to SQL tab and paste contents of `database/schema.sql`
4. Click Execute

### 4. Configuration

#### Step 1: Copy Environment File
```bash
# Windows
copy .env.example .env

# Linux/Mac
cp .env.example .env
```

#### Step 2: Edit Database Configuration
Open `config/database.php` and update:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'jeki_bakers_user');
define('DB_PASS', 'secure_password_here');
define('DB_NAME', 'jeki_bakers_db');
```

#### Step 3: Update Application Constants
Edit `config/constants.php` with your business information:
```php
define('APP_NAME', 'Jeki Bakers');
define('BUSINESS_EMAIL', 'your-email@jekibakers.co.ke');
define('BUSINESS_PHONE', '+254712345678');
define('ADMIN_EMAIL', 'admin@jekibakers.co.ke');
```

### 5. Access the Website

**Via XAMPP:**
```
http://localhost/jeki-bakers-website/public/
```

**Via Built-in PHP Server (Development):**
```bash
cd public
php -S localhost:8000
# Then visit: http://localhost:8000
```

### 6. Default Login
- **Email**: admin@jekibakers.co.ke
- **Password**: admin123

**⚠️ IMPORTANT**: Change these credentials immediately!

## Detailed Setup Instructions

### Apache Configuration

#### Enable mod_rewrite
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# Windows/XAMPP
# Already enabled, just ensure it's active
```

#### Virtual Host (Optional but Recommended)
Create `/etc/apache2/sites-available/jekibakers.conf`:
```apache
<VirtualHost *:80>
    ServerName jekibakers.local
    DocumentRoot /var/www/jekibakers-website/public
    
    <Directory /var/www/jekibakers-website/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/jekibakers-error.log
    CustomLog ${APACHE_LOG_DIR}/jekibakers-access.log combined
</VirtualHost>
```

Enable and test:
```bash
sudo a2ensite jekibakers.conf
sudo apache2ctl configtest
sudo systemctl restart apache2
```

Add to `/etc/hosts`:
```
127.0.0.1 jekibakers.local
```

### Nginx Configuration (Alternative)

Create `/etc/nginx/sites-available/jekibakers`:
```nginx
server {
    listen 80;
    server_name jekibakers.local;
    root /var/www/jekibakers-website/public;
    index index.php;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

Enable and test:
```bash
sudo ln -s /etc/nginx/sites-available/jekibakers /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

## File Permissions (Linux/Mac)

```bash
# Set correct permissions
chmod 755 -R /path/to/jeki-bakers-website
chmod 755 public/
chmod 755 assets/
chmod 755 config/
chmod 755 database/

# Make directories writable
chmod 775 assets/uploads/ (if you create this)
chmod 775 logs/ (if you create this)
```

## SSL/HTTPS Setup

### Using Let's Encrypt (Recommended for Production)

```bash
# Install Certbot
sudo apt-get install certbot python3-certbot-apache

# Generate certificate
sudo certbot --apache -d jekibakers.co.ke -d www.jekibakers.co.ke

# Auto-renewal
sudo certbot renew --dry-run
```

Then in `config/constants.php`, update:
```php
define('BASE_URL', 'https://jekibakers.co.ke/public/');
```

## Email Configuration

### Gmail SMTP Setup

1. Enable 2-Factor Authentication in Google Account
2. Generate App Password at: https://myaccount.google.com/apppasswords
3. Update `config/constants.php`:
```php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'your-email@gmail.com');
define('SMTP_PASS', 'your-16-digit-app-password');
define('ADMIN_EMAIL', 'admin@jekibakers.co.ke');
```

### Alternative SMTP Providers
- **SendGrid**: `smtp.sendgrid.net:587`
- **AWS SES**: `email-smtp.region.amazonaws.com:587`
- **Mailgun**: `smtp.mailgun.org:587`

## Database Backup & Restore

### Regular Backups
```bash
# Create backup
mysqldump -u jeki_bakers_user -p jeki_bakers_db > backup-$(date +%Y%m%d).sql

# Or with gzip compression
mysqldump -u jeki_bakers_user -p jeki_bakers_db | gzip > backup-$(date +%Y%m%d).sql.gz
```

### Restore from Backup
```bash
# From SQL file
mysql -u jeki_bakers_user -p jeki_bakers_db < backup-20251130.sql

# From gzipped file
gunzip < backup-20251130.sql.gz | mysql -u jeki_bakers_user -p jeki_bakers_db
```

## Performance Optimization

### 1. Enable Caching
```php
// In config/constants.php
define('CACHE_ENABLED', true);
define('CACHE_TTL', 3600);
```

### 2. Database Optimization
```sql
-- Run periodically
OPTIMIZE TABLE users;
OPTIMIZE TABLE products;
OPTIMIZE TABLE orders;
```

### 3. Image Optimization
```bash
# Using ImageMagick
convert image.jpg -quality 85 image-optimized.jpg

# Or use online tools
```

## Troubleshooting

### Problem: Database Connection Error
**Solution:**
1. Verify MySQL is running: `service mysql status`
2. Check credentials in `config/database.php`
3. Confirm database exists: `mysql -u user -p -e "SHOW DATABASES;"`

### Problem: 404 Errors on All Pages
**Solution:**
1. Verify mod_rewrite is enabled: `apache2ctl -M | grep rewrite`
2. Check `.htaccess` permissions: `chmod 644 public/.htaccess`
3. Verify BASE_URL in `config/constants.php`

### Problem: Permission Denied Errors
**Solution:**
```bash
# Fix permissions
sudo chown -R www-data:www-data /var/www/jeki-bakers-website
sudo chmod -R 755 /var/www/jeki-bakers-website
```

### Problem: Blank White Pages
**Solution:**
1. Check PHP error logs: `tail -f /var/log/apache2/error.log`
2. Enable debug mode: Set `error_reporting(E_ALL);` in index.php
3. Check for fatal PHP errors

### Problem: Emails Not Sending
**Solution:**
1. Test SMTP settings
2. Check firewall/port 587 availability
3. Verify Gmail app password (not account password)
4. Check mail logs: `tail -f /var/log/mail.log`

## Security Checklist

- [ ] Changed default admin credentials
- [ ] Set correct file permissions
- [ ] Enabled SSL/HTTPS
- [ ] Configured firewall rules
- [ ] Set up database backups
- [ ] Disabled PHP display_errors in production
- [ ] Set strong database passwords
- [ ] Configured CSRF protection
- [ ] Set up log rotation
- [ ] Tested input validation

## Testing the Installation

Visit these URLs to test functionality:

1. **Homepage**: `http://localhost/jeki-bakers-website/public/`
2. **Login**: `http://localhost/jeki-bakers-website/public/login.php`
3. **View Database**: `http://localhost/phpmyadmin` → `jeki_bakers_db`

## Support

If you encounter issues:
1. Check browser console (F12) for JavaScript errors
2. Check PHP error logs
3. Verify all files are uploaded
4. Ensure permissions are correct
5. Contact: admin@jekibakers.co.ke

---

**Installation Guide v1.0**  
**Last Updated**: November 2025
