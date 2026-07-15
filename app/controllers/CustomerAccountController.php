<?php

namespace App\Controllers;

class CustomerAccountController extends Controller
{
    public function index()
    {
        require_login();

        $userId = $_SESSION['user_id'];

        $user = $this->db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);

        $orders = $this->db->fetchAll(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT 5",
            [$userId]
        );

        $wishlistItems = $this->db->fetchAll(
            "SELECT w.*, p.name, p.slug, p.price, p.sale_price,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
             FROM wishlists w
             JOIN products p ON w.product_id = p.id
             WHERE w.user_id = ?",
            [$userId]
        );

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.name, p.slug, p.price, p.sale_price,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );

        $addresses = $this->db->fetchAll(
            "SELECT * FROM addresses WHERE user_id = ? ORDER BY is_default DESC, id ASC",
            [$userId]
        );

        $notifications = $this->db->fetchAll(
            "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 20",
            [$userId]
        );
        $unreadCount = $this->db->fetch(
            "SELECT COUNT(*) as count FROM notifications WHERE user_id = ? AND is_read = 0",
            [$userId]
        )['count'];

        $orderCount = $this->db->fetch("SELECT COUNT(*) as count FROM orders WHERE user_id = ?", [$userId])['count'];
        $wishlistCount = $this->db->fetch("SELECT COUNT(*) as count FROM wishlists WHERE user_id = ?", [$userId])['count'];
        $cartCount = $this->db->fetch("SELECT COUNT(*) as count FROM cart_items ci JOIN carts c ON ci.cart_id = c.id WHERE c.user_id = ?", [$userId])['count'];

        $this->data['title'] = 'My Account';
        $this->data['user'] = $user;
        $this->data['orders'] = $orders;
        $this->data['wishlist_items'] = $wishlistItems;
        $this->data['cart_items'] = $cartItems;
        $this->data['addresses'] = $addresses;
        $this->data['notifications'] = $notifications;
        $this->data['unread_count'] = $unreadCount;
        $this->data['order_count'] = $orderCount;
        $this->data['wishlist_count'] = $wishlistCount;
        $this->data['cart_count'] = $cartCount;

        $this->view('customer/my-account');
    }

    public function updateDetails()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/my-account');
        }

        $userId = $_SESSION['user_id'];

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            $this->redirect('customer/my-account');
        }

        $email = sanitize($_POST['email']);
        $existing = $this->db->fetch(
            "SELECT id FROM users WHERE email = ? AND id != ?",
            [$email, $userId]
        );
        if ($existing) {
            flash('error', 'This email is already in use');
            $this->redirect('customer/my-account');
        }

        $this->db->query(
            "UPDATE users SET name = ?, email = ?, phone = ? WHERE id = ?",
            [sanitize($_POST['name']), $email, sanitize($_POST['phone'] ?? ''), $userId]
        );

        $_SESSION['user_name'] = sanitize($_POST['name']);
        $_SESSION['user_email'] = $email;

        flash('success', 'Your details have been updated');
        $this->redirect('customer/my-account');
    }

    public function showOrder($orderNumber)
    {
        require_login();

        $userId = $_SESSION['user_id'];

        $order = $this->db->fetch(
            "SELECT * FROM orders WHERE order_number = ? AND user_id = ?",
            [$orderNumber, $userId]
        );

        if (!$order) {
            flash('error', 'Order not found');
            $this->redirect('customer/my-account');
        }

        $items = $this->db->fetchAll(
            "SELECT oi.*, p.name, p.slug,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
             FROM order_items oi
             JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = ?",
            [$order['id']]
        );

        $address = null;
        if ($order['shipping_address_id']) {
            $address = $this->db->fetch(
                "SELECT * FROM addresses WHERE id = ?",
                [$order['shipping_address_id']]
            );
        }

        $this->data['title'] = 'Order #' . htmlspecialchars($orderNumber);
        $this->data['order'] = $order;
        $this->data['items'] = $items;
        $this->data['address'] = $address;

        $this->view('customer/order-detail');
    }

    public function saveAddress()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/my-account');
        }

        $userId = $_SESSION['user_id'];
        $id = $_POST['id'] ?? '';

        $rules = [
            'full_name' => 'required',
            'phone' => 'required',
            'address_line_1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'country' => 'required'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            $this->redirect('customer/my-account');
        }

        $data = [
            'full_name' => sanitize($_POST['full_name']),
            'phone' => sanitize($_POST['phone']),
            'address_line_1' => sanitize($_POST['address_line_1']),
            'address_line_2' => sanitize($_POST['address_line_2'] ?? ''),
            'city' => sanitize($_POST['city']),
            'province' => sanitize($_POST['province']),
            'postal_code' => sanitize($_POST['postal_code']),
            'country' => sanitize($_POST['country']),
        ];

        if ($id) {
            $addr = $this->db->fetch(
                "SELECT id FROM addresses WHERE id = ? AND user_id = ?",
                [$id, $userId]
            );
            if (!$addr) {
                flash('error', 'Address not found');
                $this->redirect('customer/my-account');
            }
            $set = implode(' = ?, ', array_keys($data)) . ' = ?';
            $vals = array_values($data);
            $vals[] = $id;
            $this->db->query("UPDATE addresses SET {$set} WHERE id = ?", $vals);
            flash('success', 'Address updated');
        } else {
            $data['user_id'] = $userId;
            $count = $this->db->fetch(
                "SELECT COUNT(*) as c FROM addresses WHERE user_id = ?",
                [$userId]
            )['c'];
            $data['is_default'] = $count === 0 ? 1 : 0;

            $cols = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $this->db->query(
                "INSERT INTO addresses ({$cols}) VALUES ({$placeholders})",
                array_values($data)
            );
            flash('success', 'Address added');
        }

        $this->redirect('customer/my-account');
    }

    public function markNotificationsRead()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/my-account');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            $this->json(['error' => 'Invalid security token'], 403);
        }

        $userId = $_SESSION['user_id'];
        $this->db->query(
            "UPDATE notifications SET is_read = 1 WHERE user_id = ? AND is_read = 0",
            [$userId]
        );

        $this->json(['success' => true]);
    }
}
