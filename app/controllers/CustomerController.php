<?php

namespace App\Controllers;

class CustomerController extends Controller
{
    public function index()
    {
        require_admin();

        $search = sanitize($_GET['search'] ?? '');
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $where = "WHERE u.role = 'customer'";
        $params = [];

        if (!empty($search)) {
            $where .= " AND (u.name LIKE ? OR u.email LIKE ? OR u.phone LIKE ?)";
            $params = ["%{$search}%", "%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM users u {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT u.*,
                (SELECT COUNT(*) FROM orders WHERE user_id = u.id) as orders_count
                FROM users u
                {$where}
                ORDER BY u.created_at DESC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $customers = $this->db->fetchAll($sql, $queryParams);

        $this->data['title'] = 'Customers';
        $this->data['customers'] = $customers;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/customers/index');
    }

    public function create()
    {
        require_admin();

        $this->data['title'] = 'Add Customer';
        $this->render('admin/customers/create');
    }

    public function store()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/customers');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/customers/create');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $password = $_POST['password'];
        $status = ($_POST['status'] ?? 'active') === 'active' ? 1 : 0;

        $existing = $this->db->fetch("SELECT id FROM users WHERE email = ?", [$email]);
        if ($existing) {
            flash('error', 'Email already exists');
            $this->back();
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->db->insert(
            "INSERT INTO users (name, email, phone, password, role, status, created_at, updated_at) VALUES (?, ?, ?, ?, 'customer', ?, NOW(), NOW())",
            [$name, $email, $phone, $hashedPassword, $status]
        );

        flash('success', 'Customer created successfully');
        $this->redirect('admin/customers');
    }

    public function edit($id)
    {
        require_admin();

        $customer = $this->db->fetch("SELECT * FROM users WHERE id = ? AND role = 'customer'", [$id]);

        if (!$customer) {
            flash('error', 'Customer not found');
            $this->redirect('admin/customers');
        }

        $this->data['title'] = 'Edit Customer';
        $this->data['customer'] = $customer;

        $this->render('admin/customers/edit');
    }

    public function update($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/customers');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect("admin/customers/edit/{$id}");
        }

        $customer = $this->db->fetch("SELECT * FROM users WHERE id = ? AND role = 'customer'", [$id]);
        if (!$customer) {
            flash('error', 'Customer not found');
            $this->redirect('admin/customers');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone']);
        $status = ($_POST['status'] ?? 'active') === 'active' ? 1 : 0;

        $existing = $this->db->fetch("SELECT id FROM users WHERE email = ? AND id != ?", [$email, $id]);
        if ($existing) {
            flash('error', 'Email already exists');
            $this->back();
        }

        $password = $_POST['password'] ?? '';
        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->db->update(
                "UPDATE users SET name = ?, email = ?, phone = ?, password = ?, status = ?, updated_at = NOW() WHERE id = ?",
                [$name, $email, $phone, $hashedPassword, $status, $id]
            );
        } else {
            $this->db->update(
                "UPDATE users SET name = ?, email = ?, phone = ?, status = ?, updated_at = NOW() WHERE id = ?",
                [$name, $email, $phone, $status, $id]
            );
        }

        flash('success', 'Customer updated successfully');
        $this->redirect('admin/customers');
    }

    public function show($id)
    {
        require_admin();

        $customer = $this->db->fetch("SELECT * FROM users WHERE id = ? AND role = 'customer'", [$id]);

        if (!$customer) {
            flash('error', 'Customer not found');
            $this->redirect('admin/customers');
        }

        $orders = $this->db->fetchAll(
            "SELECT o.*, 
                    (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as items_count
             FROM orders o 
             WHERE o.user_id = ? 
             ORDER BY o.created_at DESC",
            [$id]
        );

        $this->data['title'] = $customer['name'];
        $this->data['customer'] = $customer;
        $this->data['orders'] = $orders;

        $this->render('admin/customers/view');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/customers');
        }

        $customer = $this->db->fetch("SELECT * FROM users WHERE id = ? AND role = 'customer'", [$id]);

        if (!$customer) {
            flash('error', 'Customer not found');
            $this->redirect('admin/customers');
        }

        $this->db->delete("DELETE FROM addresses WHERE user_id = ?", [$id]);
        $this->db->delete("DELETE FROM cart_items WHERE cart_id IN (SELECT id FROM carts WHERE user_id = ?)", [$id]);
        $this->db->delete("DELETE FROM carts WHERE user_id = ?", [$id]);
        $this->db->delete("DELETE FROM reviews WHERE user_id = ?", [$id]);
        $this->db->delete("DELETE FROM wishlists WHERE user_id = ?", [$id]);
        $orderIds = $this->db->fetchAll("SELECT id FROM orders WHERE user_id = ?", [$id]);
        foreach ($orderIds as $order) {
            $this->db->delete("DELETE FROM order_items WHERE order_id = ?", [$order['id']]);
        }
        $this->db->delete("DELETE FROM orders WHERE user_id = ?", [$id]);
        $this->db->delete("DELETE FROM users WHERE id = ?", [$id]);

        flash('success', 'Customer deleted successfully');
        $this->redirect('admin/customers');
    }
}
