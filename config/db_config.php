<?php
/**
 * Cloud 9 Cafe - Database Configuration
 * Uses .env file for environment variables
 */

// Load environment configuration
require_once __DIR__ . '/Env.php';

// Get database credentials from .env
$db_host = Env::get('DB_HOST', 'localhost');
$db_port = Env::get('DB_PORT', '3306');
$db_name = Env::get('DB_DATABASE', 'PHP_Project_25_261');
$db_user = Env::get('DB_USERNAME', 'root');
$db_pass = Env::get('DB_PASSWORD', '');
$db_charset = Env::get('DB_CHARSET', 'utf8mb4');

// Create connection
$con = mysqli_connect($db_host, $db_user, $db_pass, '', $db_port);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select database
if (!mysqli_select_db($con, $db_name)) {
    die("Error selecting database: " . mysqli_error($con));
}

// Set charset
mysqli_set_charset($con, $db_charset);

// =====================================================
// DATABASE SCHEMA (for reference)
// =====================================================
/*
Tables:
- cafe_users (id, fullname, email, password, gender, mobile, profile_picture, address, reward_points, status, role, token, created_at, updated_at)
- cafe_admins (id, fullname, email, password, mobile, profile_picture, role, status, last_login, created_at, updated_at)
- menu_items (id, name, description, price, category, image, stock_quantity, availability, featured, created_at, updated_at)
- cafe_orders (id, order_number, user_id, total_amount, order_note, status, payment_status, payment_method, delivery_address, order_date, updated_at)
- cafe_order_items (id, order_id, menu_item_id, quantity, unit_price, subtotal, customization)
- cafe_cart (id, user_id, menu_item_id, quantity, customization, added_at)
- cafe_offers (id, offer_code, title, description, discount_type, discount_value, min_order_amount, max_discount, valid_from, valid_until, usage_limit, usage_count, status, created_at)
- contact_messages (id, name, email, subject, message, status, created_at, replied_at, replied_by)

Run: database/install_database.php to set up
*/

// =====================================================
// DEPRECATED: Old registration table
// =====================================================
// This table is no longer used. All new users go to cafe_users
?>
