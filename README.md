# Cloud 9 Cafe - Cafe Management System

A complete Core PHP-based Cafe Management System with user authentication, menu management, ordering system, and admin dashboard.

---

## 📁 Folder Structure

```
cloud_9_cafe_rebuild/
├── .env                          # Environment configuration (create from .env.example)
├── .env.example                  # Example environment file
├── .gitignore                    # Git ignore rules
├── index.php                     # Entry point (redirects to pages/)
├── README.md                     # This file
│
├── assets/                       # Public assets (CSS, JS, images, uploads)
│   ├── css/
│   ├── js/
│   ├── fontawesome/
│   ├── images/
│   └── uploads/
│
├── config/                       # Configuration files
│   ├── db_config.php            # Database connection (uses .env)
│   ├── Env.php                  # Environment loader class
│   └── Config.php               # Configuration helper class
│
├── database/                     # Database files
│   ├── schema.sql               # Complete database schema
│   └── install_database.php     # Web installer
│
├── includes/                     # Shared components
│   ├── layout.php               # Main layout template
│   ├── dashboard_layout.php     # User dashboard layout
│   └── functions.php            # Common functions
│
├── pages/                        # Public pages
│   ├── index.php                # Home page
│   ├── about.php
│   ├── contact.php
│   ├── faq.php
│   ├── offers.php
│   ├── privacy_policy.php
│   ├── terms_of_service.php
│   └── menu/                    # Menu section
│       ├── menu.php
│       └── menu_item_detail.php
│
├── auth/                         # Authentication
│   ├── login.php
│   ├── register.php
│   ├── forgot_password.php
│   ├── reset_password.php
│   ├── verify_otp.php
│   └── logout.php
│
├── user/                         # User dashboard
│   ├── dashboard.php
│   ├── profile.php
│   ├── edit_profile.php
│   ├── orders.php
│   ├── cart.php
│   ├── wishlist.php
│   ├── addresses.php
│   └── change_password.php
│
├── admin/                        # Admin panel (future)
│   └── index.php
│
└── vendor/                       # Third-party libraries
    └── PHPMailer/
```

---

## ⚙️ Environment Configuration (.env)

### Setup Steps

1. **Copy the example file:**
   ```bash
   cp .env.example .env
   ```

2. **Edit `.env` with your settings:**
   ```ini
   # Database
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   
   # Email (for notifications)
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_app_password
   
   # Admin (change default password)
   ADMIN_PASSWORD=secure_password
   ```

### Available Environment Variables

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | Cloud 9 Cafe |
| `APP_ENV` | Environment (development/production) | development |
| `APP_URL` | Base URL | http://localhost/cloud_9_cafe_rebuild |
| `DB_HOST` | Database host | localhost |
| `DB_PORT` | Database port | 3306 |
| `DB_DATABASE` | Database name | PHP_Project_25_261 |
| `DB_USERNAME` | Database username | root |
| `DB_PASSWORD` | Database password | (empty) |
| `SESSION_LIFETIME` | Session timeout (minutes) | 120 |
| `MAIL_HOST` | SMTP server | smtp.gmail.com |
| `MAIL_PORT` | SMTP port | 587 |
| `MAX_UPLOAD_SIZE` | Max file upload (bytes) | 5242880 (5MB) |
| `ENABLE_REGISTRATION` | Allow new registrations | true |
| `ENABLE_LOYALTY_POINTS` | Enable reward points | true |

### Using Env in PHP

```php
<?php
require_once 'config/Env.php';

// Get string value
$dbHost = Env::get('DB_HOST', 'localhost');

// Get boolean value
$debug = Env::getBool('APP_DEBUG', false);

// Get integer value
$maxSize = Env::getInt('MAX_UPLOAD_SIZE', 5242880);

// Check if exists
if (Env::has('API_KEY')) {
    // Use API key
}
?>
```

### Using Config Helper

```php
<?php
require_once 'config/Config.php';

// Application info
$appName = Config::appName();
$appUrl = Config::appUrl();

// Check environment
if (Config::isDevelopment()) {
    // Show debug info
}

// Check features
if (Config::featureEnabled('loyalty')) {
    // Show reward points
}

// Get mail config
$mail = Config::mailConfig();
?>
```

---

## 🗄️ Database Schema

### Tables

1. **cafe_users** - Customer accounts with reward points
2. **cafe_admins** - Admin/Staff accounts
3. **menu_items** - Menu products (Coffee, Snack, Dessert)
4. **cafe_orders** - Customer orders with notes
5. **cafe_order_items** - Items in each order
6. **cafe_cart** - Shopping cart
7. **cafe_offers** - Promotional offers
8. **contact_messages** - Contact form submissions

### Installation

1. **Create database and import schema:**
   ```
   http://localhost/cloud_9_cafe_rebuild/database/install_database.php
   ```

2. **Or import SQL directly via phpMyAdmin:**
   ```
   database/schema.sql
   ```

---

## 🔐 Session Variables

| Variable | Purpose |
|----------|---------|
| `$_SESSION['cafe_user_id']` | Logged in user ID |
| `$_SESSION['cafe_user_name']` | Logged in user name |
| `$_SESSION['cafe_admin_id']` | Admin ID (when implemented) |

---

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server

### Installation

1. **Clone/copy files to web root:**
   ```
   C:\xampp\htdocs\cloud_9_cafe_rebuild\
   ```

2. **Create `.env` file:**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials
   ```

3. **Install database:**
   ```
   http://localhost/cloud_9_cafe_rebuild/database/install_database.php
   ```

4. **Access website:**
   ```
   http://localhost/cloud_9_cafe_rebuild/
   ```

### Default Admin Credentials
- **Email:** admin@cloud9cafe.com
- **Password:** admin123 (change in .env before deployment)

---

## 🔒 Security Features

- Environment variables for sensitive data
- Password hashing ready (bcrypt)
- Session-based authentication
- CSRF token support
- SQL injection protection (use prepared statements)
- XSS protection (output escaping)

---

## 📝 Naming Conventions

- Database tables: `cafe_*` prefix
- Session variables: `cafe_*` prefix
- PHP files: lowercase with underscores
- CSS classes: hyphen-separated
- Database columns: lowercase with underscores

---

## 🛠️ Development

### Adding New Configuration

1. Add to `.env` file:
   ```ini
   NEW_FEATURE=true
   ```

2. Access in code:
   ```php
   $enabled = Env::getBool('NEW_FEATURE', false);
   ```

### Feature Flags

Enable/disable features via `.env`:
```ini
ENABLE_REGISTRATION=true
ENABLE_WISHLIST=true
ENABLE_REVIEWS=false
ENABLE_LOYALTY_POINTS=true
```

---

## 📧 Email Configuration

For Gmail SMTP:
1. Enable 2-Factor Authentication
2. Generate App Password
3. Update `.env`:
   ```ini
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your_email@gmail.com
   MAIL_PASSWORD=your_app_password
   MAIL_ENCRYPTION=tls
   ```

---

## ⚠️ Important Notes

- **Never commit `.env` file** - it contains sensitive data
- **Change default admin password** before going live
- **Set APP_ENV=production** in production environment
- **Regular backups** of database and uploads folder

---

## 📄 License

Developed for Cloud 9 Cafe Management System.

---

## 🤝 Credits

Core PHP E-commerce Project converted to Cafe Management System.
