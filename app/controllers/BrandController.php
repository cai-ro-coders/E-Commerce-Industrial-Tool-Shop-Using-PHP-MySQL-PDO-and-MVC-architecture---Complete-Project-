<?php

namespace App\Controllers;

class BrandController extends Controller
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
            $where = "WHERE (b.name LIKE ? OR b.description LIKE ?)";
            $params = ["%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM brands b {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT b.*,
                       (SELECT COUNT(*) FROM products WHERE brand_id = b.id) as products_count
                FROM brands b
                {$where}
                ORDER BY b.name ASC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $brands = $this->db->fetchAll($sql, $queryParams);

        $this->data['title'] = 'Brands';
        $this->data['brands'] = $brands;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/brands/index');
    }

    public function create()
    {
        require_admin();

        $this->data['title'] = 'Add Brand';

        $this->render('admin/brands/create');
    }

    public function store()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/brands');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/brands/create');
        }

        $rules = ['name' => 'required'];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $slug = !empty($_POST['slug']) ? sanitize($_POST['slug']) : $this->generateSlug($name);

        $existing = $this->db->fetch("SELECT id FROM brands WHERE slug = ?", [$slug]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $logo = null;
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['logo'], 'brands');
            if ($upload['success']) {
                $logo = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $this->db->insert(
            "INSERT INTO brands (name, slug, logo, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())",
            [$name, $slug, $logo, sanitize($_POST['description'] ?? ''), ($_POST['status'] ?? 'active') === 'active' ? 1 : 0]
        );

        flash('success', 'Brand created successfully');
        $this->redirect('admin/brands');
    }

    public function edit($id)
    {
        require_admin();

        $brand = $this->db->fetch("SELECT * FROM brands WHERE id = ?", [$id]);

        if (!$brand) {
            flash('error', 'Brand not found');
            $this->redirect('admin/brands');
        }

        $this->data['title'] = 'Edit Brand';
        $this->data['brand'] = $brand;

        $this->render('admin/brands/edit');
    }

    public function update($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/brands');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect("admin/brands/edit/{$id}");
        }

        $brand = $this->db->fetch("SELECT * FROM brands WHERE id = ?", [$id]);

        if (!$brand) {
            flash('error', 'Brand not found');
            $this->redirect('admin/brands');
        }

        $rules = ['name' => 'required'];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $slug = !empty($_POST['slug']) ? sanitize($_POST['slug']) : $this->generateSlug($name);

        $existing = $this->db->fetch("SELECT id FROM brands WHERE slug = ? AND id != ?", [$slug, $id]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $logo = $brand['logo'];
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['logo'], 'brands');
            if ($upload['success']) {
                if ($logo) {
                    $this->deleteFile($logo);
                }
                $logo = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $this->db->update(
            "UPDATE brands SET name = ?, slug = ?, logo = ?, description = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [$name, $slug, $logo, sanitize($_POST['description'] ?? ''), ($_POST['status'] ?? 'active') === 'active' ? 1 : 0, $id]
        );

        flash('success', 'Brand updated successfully');
        $this->redirect('admin/brands');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/brands');
        }

        $brand = $this->db->fetch("SELECT * FROM brands WHERE id = ?", [$id]);

        if (!$brand) {
            flash('error', 'Brand not found');
            $this->redirect('admin/brands');
        }

        $productCount = $this->db->fetch(
            "SELECT COUNT(*) as count FROM products WHERE brand_id = ?",
            [$id]
        )['count'];

        if ($productCount > 0) {
            flash('warning', "Cannot delete '" . sanitize($brand['name']) . "': {$productCount} product(s) are linked to this brand.");
            $this->redirect('admin/brands');
        }

        if ($brand['logo']) {
            $this->deleteFile($brand['logo']);
        }

        $this->db->delete("DELETE FROM brands WHERE id = ?", [$id]);

        flash('success', 'Brand deleted successfully');
        $this->redirect('admin/brands');
    }
}
