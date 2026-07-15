<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductSpecification;

class ProductController extends Controller
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
            $where = "WHERE (p.name LIKE ? OR p.sku LIKE ?)";
            $params = ["%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM products p {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT p.*, c.name as category_name, b.name as brand_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                {$where}
                ORDER BY p.created_at DESC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $products = $this->db->fetchAll($sql, $queryParams);

        foreach ($products as &$product) {
            $image = $this->db->fetch(
                "SELECT image FROM product_images WHERE product_id = ? AND is_primary = 1 LIMIT 1",
                [$product['id']]
            );
            $product['primary_image'] = $image ? $image['image'] : null;
        }
        unset($product);

        $this->data['title'] = 'Products';
        $this->data['products'] = $products;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/products/index');
    }

    public function create()
    {
        require_admin();

        $categories = $this->db->fetchAll("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
        $brands = $this->db->fetchAll("SELECT id, name FROM brands WHERE status = 1 ORDER BY name ASC");

        $this->data['title'] = 'Add Product';
        $this->data['categories'] = $categories;
        $this->data['brands'] = $brands;

        $this->render('admin/products/create');
    }

    public function store()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/products');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/products/create');
        }

        $rules = [
            'name' => 'required',
            'price' => 'required|numeric'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $slug = !empty($_POST['slug']) ? sanitize($_POST['slug']) : $this->generateSlug($name);

        $existing = $this->db->fetch("SELECT id FROM products WHERE slug = ?", [$slug]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        if (!empty($_POST['sku'])) {
            $skuExists = $this->db->fetch("SELECT id FROM products WHERE sku = ?", [sanitize($_POST['sku'])]);
            if ($skuExists) {
                flash('error', 'SKU already exists');
                $this->back();
            }
        }

        $primaryImage = null;
        if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['primary_image'], 'products');
            if ($upload['success']) {
                $primaryImage = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $productData = [
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'brand_id' => !empty($_POST['brand_id']) ? (int)$_POST['brand_id'] : null,
            'sku' => sanitize($_POST['sku'] ?? ''),
            'name' => $name,
            'slug' => $slug,
            'short_description' => sanitize($_POST['short_description'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'price' => (float)($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null,
            'cost_price' => !empty($_POST['cost_price']) ? (float)$_POST['cost_price'] : null,
            'stock_quantity' => (int)($_POST['stock_quantity'] ?? 0),
            'minimum_stock' => (int)($_POST['minimum_stock'] ?? 0),
            'weight' => !empty($_POST['weight']) ? (float)$_POST['weight'] : null,
            'dimensions' => sanitize($_POST['dimensions'] ?? ''),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'status' => ($_POST['status'] ?? 'active') === 'active' ? 1 : 0
        ];

        $product = new Product();
        $productId = $product->create($productData);

        if (!$productId) {
            flash('error', 'Failed to create product');
            $this->back();
        }

        if ($primaryImage) {
            $imageModel = new ProductImage();
            $imageModel->create([
                'product_id' => $productId,
                'image' => $primaryImage,
                'is_primary' => 1,
                'sort_order' => 0
            ]);
        }

        if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
            $files = $_FILES['additional_images'];
            $fileCount = count($files['name']);
            $imageModel = new ProductImage();
            $sortOrder = 1;

            for ($i = 0; $i < $fileCount; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $files['name'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i]
                    ];
                    $upload = $this->uploadFile($file, 'products');
                    if ($upload['success']) {
                        $imageModel->create([
                            'product_id' => $productId,
                            'image' => $upload['filename'],
                            'is_primary' => 0,
                            'sort_order' => $sortOrder++
                        ]);
                    }
                }
            }
        }

        if (isset($_POST['specs']) && is_array($_POST['specs'])) {
            $specModel = new ProductSpecification();
            foreach ($_POST['specs'] as $spec) {
                $attrName = sanitize($spec['attribute_name'] ?? '');
                $attrValue = sanitize($spec['attribute_value'] ?? '');
                if (!empty($attrName) && !empty($attrValue)) {
                    $specModel->create([
                        'product_id' => $productId,
                        'attribute_name' => $attrName,
                        'attribute_value' => $attrValue
                    ]);
                }
            }
        }

        flash('success', 'Product created successfully');
        $this->redirect('admin/products');
    }

    public function edit($id)
    {
        require_admin();

        $product = new Product();
        $record = $product->find($id);

        if (!$record) {
            flash('error', 'Product not found');
            $this->redirect('admin/products');
        }

        $categories = $this->db->fetchAll("SELECT id, name FROM categories WHERE status = 1 ORDER BY name ASC");
        $brands = $this->db->fetchAll("SELECT id, name FROM brands WHERE status = 1 ORDER BY name ASC");

        $images = $this->db->fetchAll(
            "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC",
            [$id]
        );

        $specs = $this->db->fetchAll(
            "SELECT * FROM product_specifications WHERE product_id = ? ORDER BY id ASC",
            [$id]
        );

        $this->data['title'] = 'Edit Product';
        $this->data['product'] = $record;
        $this->data['categories'] = $categories;
        $this->data['brands'] = $brands;
        $this->data['images'] = $images;
        $this->data['specs'] = $specs;

        $this->render('admin/products/edit');
    }

    public function update($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/products');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect("admin/products/edit/{$id}");
        }

        $product = new Product();
        $record = $product->find($id);

        if (!$record) {
            flash('error', 'Product not found');
            $this->redirect('admin/products');
        }

        $rules = [
            'name' => 'required',
            'price' => 'required|numeric'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $slug = !empty($_POST['slug']) ? sanitize($_POST['slug']) : $this->generateSlug($name);

        $existing = $this->db->fetch("SELECT id FROM products WHERE slug = ? AND id != ?", [$slug, $id]);
        if ($existing) {
            $slug = $slug . '-' . time();
        }

        if (!empty($_POST['sku'])) {
            $skuExists = $this->db->fetch("SELECT id FROM products WHERE sku = ? AND id != ?", [sanitize($_POST['sku']), $id]);
            if ($skuExists) {
                flash('error', 'SKU already exists');
                $this->back();
            }
        }

        $productData = [
            'category_id' => !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null,
            'brand_id' => !empty($_POST['brand_id']) ? (int)$_POST['brand_id'] : null,
            'sku' => sanitize($_POST['sku'] ?? ''),
            'name' => $name,
            'slug' => $slug,
            'short_description' => sanitize($_POST['short_description'] ?? ''),
            'description' => $_POST['description'] ?? '',
            'price' => (float)($_POST['price'] ?? 0),
            'sale_price' => !empty($_POST['sale_price']) ? (float)$_POST['sale_price'] : null,
            'cost_price' => !empty($_POST['cost_price']) ? (float)$_POST['cost_price'] : null,
            'stock_quantity' => (int)($_POST['stock_quantity'] ?? 0),
            'minimum_stock' => (int)($_POST['minimum_stock'] ?? 0),
            'weight' => !empty($_POST['weight']) ? (float)$_POST['weight'] : null,
            'dimensions' => sanitize($_POST['dimensions'] ?? ''),
            'featured' => isset($_POST['featured']) ? 1 : 0,
            'status' => ($_POST['status'] ?? 'active') === 'active' ? 1 : 0
        ];

        $product->update($id, $productData);

        if (isset($_FILES['primary_image']) && $_FILES['primary_image']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['primary_image'], 'products');
            if ($upload['success']) {
                $oldImage = $this->db->fetch(
                    "SELECT image FROM product_images WHERE product_id = ? AND is_primary = 1 LIMIT 1",
                    [$id]
                );
                if ($oldImage) {
                    $this->deleteFile($oldImage['image']);
                    $this->db->delete(
                        "DELETE FROM product_images WHERE product_id = ? AND is_primary = 1",
                        [$id]
                    );
                }

                $imageModel = new ProductImage();
                $imageModel->create([
                    'product_id' => $id,
                    'image' => $upload['filename'],
                    'is_primary' => 1,
                    'sort_order' => 0
                ]);
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
            $files = $_FILES['additional_images'];
            $fileCount = count($files['name']);
            $imageModel = new ProductImage();
            $maxSort = $this->db->fetch(
                "SELECT COALESCE(MAX(sort_order), 0) as max_sort FROM product_images WHERE product_id = ?",
                [$id]
            );
            $sortOrder = $maxSort['max_sort'] + 1;

            for ($i = 0; $i < $fileCount; $i++) {
                if ($files['error'][$i] === UPLOAD_ERR_OK) {
                    $file = [
                        'name' => $files['name'][$i],
                        'type' => $files['type'][$i],
                        'tmp_name' => $files['tmp_name'][$i],
                        'error' => $files['error'][$i],
                        'size' => $files['size'][$i]
                    ];
                    $upload = $this->uploadFile($file, 'products');
                    if ($upload['success']) {
                        $imageModel->create([
                            'product_id' => $id,
                            'image' => $upload['filename'],
                            'is_primary' => 0,
                            'sort_order' => $sortOrder++
                        ]);
                    }
                }
            }
        }

        if (isset($_POST['delete_images']) && is_array($_POST['delete_images'])) {
            $imageModel = new ProductImage();
            foreach ($_POST['delete_images'] as $imageId) {
                $image = $imageModel->find((int)$imageId);
                if ($image && $image['product_id'] == $id) {
                    $this->deleteFile($image['image']);
                    $imageModel->delete($image['id']);
                }
            }
        }

        $this->db->delete("DELETE FROM product_specifications WHERE product_id = ?", [$id]);

        if (isset($_POST['specs']) && is_array($_POST['specs'])) {
            $specModel = new ProductSpecification();
            foreach ($_POST['specs'] as $spec) {
                $attrName = sanitize($spec['attribute_name'] ?? '');
                $attrValue = sanitize($spec['attribute_value'] ?? '');
                if (!empty($attrName) && !empty($attrValue)) {
                    $specModel->create([
                        'product_id' => $id,
                        'attribute_name' => $attrName,
                        'attribute_value' => $attrValue
                    ]);
                }
            }
        }

        flash('success', 'Product updated successfully');
        $this->redirect('admin/products');
    }

    public function show($id)
    {
        require_admin();

        $product = $this->db->fetch(
            "SELECT p.*, c.name as category_name, b.name as brand_name
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN brands b ON p.brand_id = b.id
             WHERE p.id = ?",
            [$id]
        );

        if (!$product) {
            flash('error', 'Product not found');
            $this->redirect('admin/products');
        }

        $images = $this->db->fetchAll(
            "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC",
            [$id]
        );

        $specs = $this->db->fetchAll(
            "SELECT * FROM product_specifications WHERE product_id = ? ORDER BY id ASC",
            [$id]
        );

        $this->data['title'] = $product['name'];
        $this->data['product'] = $product;
        $this->data['images'] = $images;
        $this->data['specs'] = $specs;

        $this->render('admin/products/view');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/products');
        }

        $product = new Product();
        $record = $product->find($id);

        if (!$record) {
            flash('error', 'Product not found');
            $this->redirect('admin/products');
        }

        $images = $this->db->fetchAll(
            "SELECT image FROM product_images WHERE product_id = ?",
            [$id]
        );

        foreach ($images as $img) {
            $this->deleteFile($img['image']);
        }

        $this->db->delete("DELETE FROM product_images WHERE product_id = ?", [$id]);
        $this->db->delete("DELETE FROM product_specifications WHERE product_id = ?", [$id]);
        $product->delete($id);

        flash('success', 'Product deleted successfully');
        $this->redirect('admin/products');
    }

    public function export($type)
    {
        require_admin();

        $products = $this->db->fetchAll(
            "SELECT p.*, c.name as category_name, b.name as brand_name
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN brands b ON p.brand_id = b.id
             ORDER BY p.name ASC"
        );

        $data = [];
        foreach ($products as $p) {
            $data[] = [
                'ID' => $p['id'],
                'Name' => $p['name'],
                'SKU' => $p['sku'],
                'Category' => $p['category_name'] ?? '',
                'Brand' => $p['brand_name'] ?? '',
                'Price' => $p['price'],
                'Sale Price' => $p['sale_price'] ?? '',
                'Cost Price' => $p['cost_price'] ?? '',
                'Stock' => $p['stock_quantity'],
                'Status' => $p['status'],
                'Featured' => $p['featured'] ? 'Yes' : 'No',
                'Created At' => $p['created_at']
            ];
        }

        if ($type === 'csv') {
            export_csv($data, 'products_export.csv');
        } else {
            export_json($data, 'products_export.json');
        }
    }
}
