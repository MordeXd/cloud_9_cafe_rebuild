-- =====================================================
-- CLOUD 9 CAFE - DATABASE SCHEMA
-- Complete Cafe Management System
-- =====================================================
-- 
-- Instructions:
-- 1. Run via web: http://localhost/cloud_9_cafe_rebuild/database/init.php
-- 2. Run via CLI: php database/cli-init.php
-- 3. Or import this file directly in phpMyAdmin
--
-- Note: DROP statements are commented for safety
-- Uncomment if you want to reset all data
-- =====================================================

-- CREATE DATABASE IF NOT EXISTS cloud_9_cafe CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE cloud_9_cafe;

-- =====================================================
-- TABLE: cafe_users
-- =====================================================
-- Uncomment below to reset all tables:
-- DROP TABLE IF EXISTS cafe_order_items;
-- DROP TABLE IF EXISTS cafe_cart;
-- DROP TABLE IF EXISTS cafe_offers;
-- DROP TABLE IF EXISTS contact_messages;
-- DROP TABLE IF EXISTS cafe_orders;
-- DROP TABLE IF EXISTS menu_items;
-- DROP TABLE IF EXISTS cafe_admins;
-- DROP TABLE IF EXISTS cafe_users;

CREATE TABLE cafe_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female', 'other') DEFAULT NULL,
    mobile BIGINT(15),
    profile_picture VARCHAR(255) DEFAULT NULL,
    address TEXT,
    reward_points INT DEFAULT 0,
    status ENUM('Active', 'Inactive') DEFAULT 'Inactive',
    role ENUM('User', 'Admin') DEFAULT 'User',
    token VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: cafe_admins
-- =====================================================
CREATE TABLE cafe_admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    mobile BIGINT(15),
    profile_picture VARCHAR(255) DEFAULT NULL,
    role ENUM('super_admin', 'manager', 'staff') DEFAULT 'staff',
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    last_login DATETIME DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: menu_items
-- =====================================================
CREATE TABLE menu_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category ENUM('Coffee', 'Snack', 'Dessert') NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    stock_quantity INT DEFAULT 0,
    availability ENUM('Available', 'Out of Stock') DEFAULT 'Available',
    featured TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: cafe_orders
-- =====================================================
CREATE TABLE cafe_orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    order_note TEXT,
    status ENUM('Pending', 'Confirmed', 'Preparing', 'Ready', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    payment_status ENUM('Pending', 'Paid', 'Failed', 'Refunded') DEFAULT 'Pending',
    payment_method ENUM('Cash', 'Card', 'UPI', 'Wallet') DEFAULT 'Cash',
    delivery_address TEXT,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES cafe_users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: cafe_order_items
-- =====================================================
CREATE TABLE cafe_order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    customization TEXT,
    FOREIGN KEY (order_id) REFERENCES cafe_orders(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: cafe_cart
-- =====================================================
CREATE TABLE cafe_cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    menu_item_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    customization TEXT,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES cafe_users(id) ON DELETE CASCADE,
    FOREIGN KEY (menu_item_id) REFERENCES menu_items(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, menu_item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: cafe_offers
-- =====================================================
CREATE TABLE cafe_offers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    offer_code VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    discount_type ENUM('Percentage', 'Fixed') DEFAULT 'Percentage',
    discount_value DECIMAL(10, 2) NOT NULL,
    min_order_amount DECIMAL(10, 2) DEFAULT 0,
    max_discount DECIMAL(10, 2) DEFAULT NULL,
    valid_from DATE NOT NULL,
    valid_until DATE NOT NULL,
    usage_limit INT DEFAULT NULL,
    usage_count INT DEFAULT 0,
    status ENUM('Active', 'Inactive', 'Expired') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- TABLE: contact_messages
-- =====================================================
CREATE TABLE contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) DEFAULT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'Read', 'Replied', 'Archived') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    replied_at DATETIME DEFAULT NULL,
    replied_by INT DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================
-- INSERT SAMPLE DATA
-- =====================================================

-- Sample Admin
INSERT INTO cafe_admins (fullname, email, password, mobile, role, status) VALUES
('Admin User', 'admin@cloud9cafe.com', 'admin123', 9876543210, 'super_admin', 'Active');

-- Sample Menu Items
INSERT INTO menu_items (name, description, price, category, image, stock_quantity, availability, featured) VALUES
('Espresso', 'Rich and bold single shot espresso', 3.50, 'Coffee', 'images/menu/espresso.jpg', 100, 'Available', 1),
('Cappuccino', 'Classic Italian coffee with steamed milk foam', 4.50, 'Coffee', 'images/menu/cappuccino.jpg', 80, 'Available', 1),
('Latte', 'Smooth espresso with steamed milk', 4.00, 'Coffee', 'images/menu/latte.jpg', 80, 'Available', 0),
('Mocha', 'Chocolate flavored coffee delight', 5.00, 'Coffee', 'images/menu/mocha.jpg', 60, 'Available', 1),
('Croissant', 'Buttery flaky French pastry', 3.00, 'Snack', 'images/menu/croissant.jpg', 50, 'Available', 0),
('Sandwich', 'Grilled cheese and vegetable sandwich', 6.50, 'Snack', 'images/menu/sandwich.jpg', 40, 'Available', 0),
('Chocolate Cake', 'Rich chocolate layer cake', 5.50, 'Dessert', 'images/menu/chocolate-cake.jpg', 30, 'Available', 1),
('Cheesecake', 'Creamy New York style cheesecake', 5.00, 'Dessert', 'images/menu/cheesecake.jpg', 25, 'Available', 0);

-- Sample Offers
INSERT INTO cafe_offers (offer_code, title, description, discount_type, discount_value, min_order_amount, max_discount, valid_from, valid_until, usage_limit, status) VALUES
('SAVE20', 'Save 20%', 'Get 20% off on orders above $50', 'Percentage', 20.00, 50.00, 20.00, '2026-01-01', '2026-12-31', 100, 'Active'),
('FIRST50', 'First Order Discount', 'Flat $5 off on your first order', 'Fixed', 5.00, 0, NULL, '2026-01-01', '2026-12-31', NULL, 'Active'),
('COFFEE10', 'Coffee Lovers', '10% off on all coffee items', 'Percentage', 10.00, 0, 10.00, '2026-01-01', '2026-12-31', NULL, 'Active');

-- =====================================================
-- END OF SCHEMA
-- =====================================================
