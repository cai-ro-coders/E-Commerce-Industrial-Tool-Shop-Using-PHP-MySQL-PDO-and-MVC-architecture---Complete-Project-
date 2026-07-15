<?php

namespace App\Controllers;

class CategoryController extends Controller
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
            $where = "WHERE (c.name LIKE ? OR c.description LIKE ?)";
            $params = ["%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM categories c {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT c.*,
                       p.name as parent_name,
                       (SELECT COUNT(*) FROM products WHERE category_id = c.id) as products_count
                FROM categories c
                LEFT JOIN categories p ON c.parent_id = p.id
                {$where}
                ORDER BY c.name ASC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $categories = $this->db->fetchAll($sql, $queryParams);

        $this->data['title'] = 'Categories';
        $this->data['categories'] = $categories;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/categories/index');
    }

    public function create()
    {
        require_admin();

        $parentCategories = $this->db->fetchAll(
            "SELECT id, name FROM categories WHERE parent_id IS NULL ORDER BY name ASC"
        );

        $this->data['title'] = 'Add Category';
        $this->data['parentCategories'] = $parentCategories;

        $this->render('admin/categories/create');
    }

    public function store()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/categories');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/categories/create');
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

        $existing = $this->db->fetch("SELECT id FROM categories WHERE slug = ?", [$slug]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['image'], 'categories');
            if ($upload['success']) {
                $image = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

        $this->db->insert(
            "INSERT INTO categories (parent_id, name, slug, image, description, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [$parentId, $name, $slug, $image, $_POST['description'] ?? '', ($_POST['status'] ?? 'active') === 'active' ? 1 : 0]
        );

        flash('success', 'Category created successfully');
        $this->redirect('admin/categories');
    }

    public function edit($id)
    {
        require_admin();

        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);

        if (!$category) {
            flash('error', 'Category not found');
            $this->redirect('admin/categories');
        }

        $parentCategories = $this->db->fetchAll(
            "SELECT id, name FROM categories WHERE parent_id IS NULL AND id != ? ORDER BY name ASC",
            [$id]
        );

        $this->data['title'] = 'Edit Category';
        $this->data['category'] = $category;
        $this->data['parentCategories'] = $parentCategories;

        $this->render('admin/categories/edit');
    }

    public function update($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/categories');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect("admin/categories/edit/{$id}");
        }

        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);

        if (!$category) {
            flash('error', 'Category not found');
            $this->redirect('admin/categories');
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

        $existing = $this->db->fetch("SELECT id FROM categories WHERE slug = ? AND id != ?", [$slug, $id]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        $image = $category['image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['image'], 'categories');
            if ($upload['success']) {
                if ($image) {
                    $this->deleteFile($image);
                }
                $image = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $parentId = !empty($_POST['parent_id']) ? (int)$_POST['parent_id'] : null;

        $this->db->update(
            "UPDATE categories SET parent_id = ?, name = ?, slug = ?, image = ?, description = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [$parentId, $name, $slug, $image, $_POST['description'] ?? '', ($_POST['status'] ?? 'active') === 'active' ? 1 : 0, $id]
        );

        flash('success', 'Category updated successfully');
        $this->redirect('admin/categories');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/categories');
        }

        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);

        if (!$category) {
            flash('error', 'Category not found');
            $this->redirect('admin/categories');
        }

        $productCount = $this->db->fetch(
            "SELECT COUNT(*) as count FROM products WHERE category_id = ?",
            [$id]
        )['count'];

        if ($productCount > 0) {
            flash('warning', "Cannot delete '" . sanitize($category['name']) . "': {$productCount} product(s) are linked to this category.");
            $this->redirect('admin/categories');
        }

        if ($category['image']) {
            $this->deleteFile($category['image']);
        }

        $this->db->update("UPDATE categories SET parent_id = NULL WHERE parent_id = ?", [$id]);
        $this->db->delete("DELETE FROM categories WHERE id = ?", [$id]);

        flash('success', 'Category deleted successfully');
        $this->redirect('admin/categories');
    }
}
