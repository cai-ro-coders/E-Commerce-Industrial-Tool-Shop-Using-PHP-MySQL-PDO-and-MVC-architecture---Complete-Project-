<?php

namespace App\Controllers;

class CouponController extends Controller
{
    public function index()
    {
        require_admin();

        $search = sanitize($_GET['search'] ?? '');
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $where = '';
        $params = [];

        if (!empty($search)) {
            $where = "WHERE code LIKE ?";
            $params = ["%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM coupons {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT * FROM coupons {$where} ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $coupons = $this->db->fetchAll($sql, $queryParams);

        $this->data['title'] = 'Coupons';
        $this->data['coupons'] = $coupons;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/coupons/index');
    }

    public function create()
    {
        require_admin();

        $this->data['title'] = 'Add Coupon';

        $this->render('admin/coupons/create');
    }

    public function store()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/coupons');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/coupons/create');
        }

        $rules = [
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $code = strtoupper(sanitize($_POST['code']));

        $existing = $this->db->fetch("SELECT id FROM coupons WHERE code = ?", [$code]);
        if ($existing) {
            flash('error', 'Coupon code already exists');
            $this->back();
        }

        $this->db->insert(
            "INSERT INTO coupons (code, type, value, minimum_order, maximum_discount, usage_limit, start_date, end_date, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [
                $code,
                sanitize($_POST['type']),
                sanitize($_POST['value']),
                sanitize($_POST['minimum_order'] ?? 0),
                !empty($_POST['maximum_discount']) ? sanitize($_POST['maximum_discount']) : null,
                !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null,
                sanitize($_POST['start_date']),
                sanitize($_POST['end_date']),
                ($_POST['status'] ?? 'active') === 'active' ? 1 : 0,
            ]
        );

        flash('success', 'Coupon created successfully');
        $this->redirect('admin/coupons');
    }

    public function edit($id)
    {
        require_admin();

        $coupon = $this->db->fetch("SELECT * FROM coupons WHERE id = ?", [$id]);

        if (!$coupon) {
            flash('error', 'Coupon not found');
            $this->redirect('admin/coupons');
        }

        $this->data['title'] = 'Edit Coupon';
        $this->data['coupon'] = $coupon;

        $this->render('admin/coupons/edit');
    }

    public function update($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/coupons');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect("admin/coupons/edit/{$id}");
        }

        $coupon = $this->db->fetch("SELECT * FROM coupons WHERE id = ?", [$id]);

        if (!$coupon) {
            flash('error', 'Coupon not found');
            $this->redirect('admin/coupons');
        }

        $rules = [
            'code' => 'required',
            'type' => 'required',
            'value' => 'required|numeric',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $code = strtoupper(sanitize($_POST['code']));

        $existing = $this->db->fetch("SELECT id FROM coupons WHERE code = ? AND id != ?", [$code, $id]);
        if ($existing) {
            flash('error', 'Coupon code already exists');
            $this->back();
        }

        $this->db->update(
            "UPDATE coupons SET code = ?, type = ?, value = ?, minimum_order = ?, maximum_discount = ?, usage_limit = ?, start_date = ?, end_date = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [
                $code,
                sanitize($_POST['type']),
                sanitize($_POST['value']),
                sanitize($_POST['minimum_order'] ?? 0),
                !empty($_POST['maximum_discount']) ? sanitize($_POST['maximum_discount']) : null,
                !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null,
                sanitize($_POST['start_date']),
                sanitize($_POST['end_date']),
                ($_POST['status'] ?? 'active') === 'active' ? 1 : 0,
                $id,
            ]
        );

        flash('success', 'Coupon updated successfully');
        $this->redirect('admin/coupons');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/coupons');
        }

        $coupon = $this->db->fetch("SELECT * FROM coupons WHERE id = ?", [$id]);

        if (!$coupon) {
            flash('error', 'Coupon not found');
            $this->redirect('admin/coupons');
        }

        $this->db->delete("DELETE FROM coupons WHERE id = ?", [$id]);

        flash('success', 'Coupon deleted successfully');
        $this->redirect('admin/coupons');
    }
}
