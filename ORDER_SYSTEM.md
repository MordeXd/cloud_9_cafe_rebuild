# Cloud 9 Cafe - Order System Documentation

## Overview

The order system handles the complete order flow from cart to order completion, including reward points tracking.

---

## Order Flow

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  Cart Page  │────▶│  Checkout   │────▶│   Success   │
│  (cart.php) │     │ (checkout.  │     │  (order_    │
│             │     │   php)      │     │  success)   │
└─────────────┘     └─────────────┘     └─────────────┘
                           │
                           ▼
                    ┌─────────────┐
                    │  Process:   │
                    │ 1. Create   │
                    │    order    │
                    │ 2. Move     │
                    │    items    │
                    │ 3. Clear    │
                    │    cart     │
                    │ 4. Add +10  │
                    │    points   │
                    └─────────────┘
```

---

## Files

### 1. `user/cart.php`
**Purpose:** Display cart items and checkout button

**Features:**
- Display items from `cafe_cart` table
- Quantity update buttons
- Remove item functionality
- Clear cart functionality
- Order summary calculation
- Checkout modal with:
  - Delivery address
  - Order note
  - Payment method selection

**Database Operations:**
```sql
-- Get cart items
SELECT c.*, m.name, m.price, m.image 
FROM cafe_cart c 
JOIN menu_items m ON c.menu_item_id = m.id 
WHERE c.user_id = ?

-- Update quantity
UPDATE cafe_cart SET quantity = ? WHERE id = ? AND user_id = ?

-- Remove item
DELETE FROM cafe_cart WHERE id = ? AND user_id = ?

-- Clear cart
DELETE FROM cafe_cart WHERE user_id = ?
```

---

### 2. `user/checkout.php`
**Purpose:** Process order creation

**Logic Flow:**
1. Get cart items for user
2. Calculate total amount
3. Generate unique order number (`ORD-YYYYMMDD-XXXX`)
4. **Start Database Transaction**
5. Insert order into `cafe_orders`
6. Insert items into `cafe_order_items`
7. Update stock quantities
8. Clear user's cart
9. **Add 10 reward points to user**
10. **Commit Transaction**
11. Redirect to success page

**Database Operations:**
```sql
-- 1. Create order
INSERT INTO cafe_orders (order_number, user_id, total_amount, order_note, 
                         status, payment_status, payment_method, delivery_address) 
VALUES (?, ?, ?, ?, 'Pending', 'Pending', ?, ?)

-- 2. Move items
INSERT INTO cafe_order_items (order_id, menu_item_id, quantity, unit_price, subtotal, customization)
VALUES (?, ?, ?, ?, ?, ?)

-- 3. Update stock
UPDATE menu_items SET stock_quantity = stock_quantity - ? WHERE id = ?

-- 4. Clear cart
DELETE FROM cafe_cart WHERE user_id = ?

-- 5. Add reward points
UPDATE cafe_users SET reward_points = reward_points + 10 WHERE id = ?
```

---

### 3. `user/order_success.php`
**Purpose:** Display order confirmation

**Features:**
- Success animation
- Order number display
- Points earned notification
- Order summary
- Order status tracker
- Navigation buttons

---

### 4. `user/orders.php`
**Purpose:** Display order history

**Features:**
- List all user orders
- Filter by status (Pending, Preparing, Completed, Cancelled)
- Order details modal
- Cancel order option (for Pending orders)
- Status tracking visualization

**Order Statuses:**
- **Pending** - Order received, waiting to be prepared
- **Preparing** - Chef is preparing the order
- **Completed** - Order is ready/delivered
- **Cancelled** - Order was cancelled

---

### 5. `user/dashboard.php` (Updated)
**Purpose:** User dashboard with order stats

**New Features:**
- Total orders count
- Pending orders count
- Reward points display
- Recent orders list
- Quick order button

---

## Order Statuses

| Status | Description | Color Code |
|--------|-------------|------------|
| **Pending** | Order received, not started | Yellow `#fff3cd` |
| **Preparing** | Being prepared in kitchen | Blue `#cce5ff` |
| **Completed** | Ready/delivered | Green `#d4edda` |
| **Cancelled** | Order cancelled | Red `#f8d7da` |

---

## Reward Points System

### Earning Points
- **+10 points** for every successful order
- Points added automatically after checkout

### Database Schema
```sql
-- User table includes reward_points column
CREATE TABLE cafe_users (
    ...
    reward_points INT DEFAULT 0,
    ...
);
```

### Display Points
Points are shown in:
- Dashboard stat card
- Order success page
- Sidebar (future enhancement)

---

## Database Tables Used

### 1. `cafe_orders`
```sql
id INT PK
order_number VARCHAR(50) UNIQUE
user_id INT FK
total_amount DECIMAL(10,2)
order_note TEXT
status ENUM('Pending','Preparing','Completed','Cancelled')
payment_status ENUM('Pending','Paid','Failed','Refunded')
payment_method ENUM('Cash','Card','UPI','Wallet')
delivery_address TEXT
order_date TIMESTAMP
updated_at TIMESTAMP
```

### 2. `cafe_order_items`
```sql
id INT PK
order_id INT FK
menu_item_id INT FK
quantity INT
unit_price DECIMAL(10,2)
subtotal DECIMAL(10,2)
customization TEXT
```

### 3. `cafe_cart`
```sql
id INT PK
user_id INT FK
menu_item_id INT FK
quantity INT
customization TEXT
added_at TIMESTAMP
```

### 4. `cafe_users` (reward_points column)
```sql
id INT PK
...
reward_points INT DEFAULT 0
...
```

---

## Security Features

1. **Session Authentication** - All pages check `cafe_user_id`
2. **User Verification** - Orders linked to user_id
3. **SQL Injection Protection** - Using mysqli_real_escape_string()
4. **Transaction Safety** - Orders use database transactions
5. **Stock Management** - Stock updated atomically with order

---

## URL Structure

| Page | URL |
|------|-----|
| Cart | `/user/cart.php` |
| Checkout Process | `/user/checkout.php` (POST only) |
| Order Success | `/user/order_success.php?order_id=X` |
| Order History | `/user/orders.php` |
| Dashboard | `/user/dashboard.php` |

---

## Testing the Order Flow

1. **Add items to cart** (via menu)
2. **Go to cart** → `/user/cart.php`
3. **Click Checkout** → Fill address & payment
4. **Place Order** → Redirected to success page
5. **Check points** → Dashboard shows +10 points
6. **View orders** → `/user/orders.php`

---

## Future Enhancements

- [ ] Email confirmation on order
- [ ] SMS notifications
- [ ] Real-time order tracking
- [ ] Redeem points for discounts
- [ ] Order rating/review system
- [ ] Reorder previous orders
- [ ] Scheduled/pre-orders
