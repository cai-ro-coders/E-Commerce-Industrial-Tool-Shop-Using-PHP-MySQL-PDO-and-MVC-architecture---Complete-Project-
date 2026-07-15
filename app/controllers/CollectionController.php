<?php

namespace App\Controllers;

class CollectionController extends Controller
{
    public function all()
    {
        $sort = $_GET['sort'] ?? 'newest';
        $search = trim($_GET['search'] ?? '');
        $brandFilter = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 99999;

        $orderClause = match ($sort) {
            'price-asc'  => 'p.price ASC',
            'price-desc' => 'p.price DESC',
            'name-asc'   => 'p.name ASC',
            'name-desc'  => 'p.name DESC',
            default      => 'p.created_at DESC',
        };

        $params = [];
        $where = 'WHERE p.status = 1';
        $searchWhere = '';
        if ($search !== '') {
            $searchWhere = " AND p.name LIKE ?";
            $params[] = '%' . $search . '%';
        }
        $brandWhere = '';

        if (!empty($brandFilter)) {
            $placeholders = implode(',', array_fill(0, count($brandFilter), '?'));
            $brandWhere = " AND p.brand_id IN ({$placeholders})";
            $params = array_merge($params, $brandFilter);
        }

        $priceWhere = '';
        if ($minPrice > 0) {
            $priceWhere .= " AND COALESCE(p.sale_price, p.price) >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice < 99999) {
            $priceWhere .= " AND COALESCE(p.sale_price, p.price) <= ?";
            $params[] = $maxPrice;
        }

        $countSql = "SELECT COUNT(*) as count FROM products p
                     LEFT JOIN brands b ON p.brand_id = b.id
                     {$where} {$searchWhere} {$brandWhere} {$priceWhere}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $perPage = 12;
        $pagination = paginate($total, $perPage);

        $sql = "SELECT p.*, b.name as brand_name,
                       (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
                       COALESCE(AVG(r.rating), 0) as avg_rating, COUNT(r.id) as review_count
                FROM products p
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 1
                {$where} {$searchWhere} {$brandWhere} {$priceWhere}
                GROUP BY p.id
                ORDER BY {$orderClause}
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $pagination['offset']]);
        $products = $this->db->fetchAll($sql, $queryParams);

        $categories = $this->db->fetchAll(
            "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
        );

        $brands = $this->db->fetchAll(
            "SELECT DISTINCT b.id, b.name, b.slug
             FROM brands b
             WHERE b.status = 1
             ORDER BY b.name ASC"
        );

        $priceRange = $this->db->fetch(
            "SELECT MIN(COALESCE(sale_price, price)) as min_price,
                    MAX(COALESCE(sale_price, price)) as max_price
             FROM products
             WHERE status = 1"
        );

        $this->data['title'] = $search ? "Search results for &quot;" . htmlspecialchars($search) . "&quot;" : 'All Products — Industrial Tool Shop';
        $this->data['category'] = null;
        $this->data['all_page'] = true;
        $this->data['search_query'] = $search;
        $this->data['products'] = $products;
        $this->data['categories'] = $categories;
        $this->data['brands'] = $brands;
        $this->data['price_range'] = $priceRange;
        $this->data['pagination'] = $pagination;
        $this->data['current_sort'] = $sort;
        $this->data['active_brands'] = $brandFilter;
        $this->data['min_price_filter'] = $minPrice;
        $this->data['max_price_filter'] = $maxPrice;

        $this->view('collections/show');
    }

    public function show($slug)
    {
        $category = $this->db->fetch(
            "SELECT * FROM categories WHERE slug = ? AND status = 1",
            [$slug]
        );

        if (!$category) {
            $this->redirect('');
        }

        $sort = $_GET['sort'] ?? 'newest';
        $brandFilter = isset($_GET['brand']) ? (array)$_GET['brand'] : [];
        $minPrice = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
        $maxPrice = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 99999;

        $orderClause = match ($sort) {
            'price-asc'  => 'p.price ASC',
            'price-desc' => 'p.price DESC',
            'name-asc'   => 'p.name ASC',
            'name-desc'  => 'p.name DESC',
            default      => 'p.created_at DESC',
        };

        $params = [$category['id']];
        $brandWhere = '';

        if (!empty($brandFilter)) {
            $placeholders = implode(',', array_fill(0, count($brandFilter), '?'));
            $brandWhere = "AND p.brand_id IN ({$placeholders})";
            $params = array_merge($params, $brandFilter);
        }

        $priceWhere = '';
        if ($minPrice > 0) {
            $priceWhere .= " AND COALESCE(p.sale_price, p.price) >= ?";
            $params[] = $minPrice;
        }
        if ($maxPrice < 99999) {
            $priceWhere .= " AND COALESCE(p.sale_price, p.price) <= ?";
            $params[] = $maxPrice;
        }

        $sql = "SELECT p.*, b.name as brand_name,
                       (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
                       COALESCE(AVG(r.rating), 0) as avg_rating, COUNT(r.id) as review_count
                FROM products p
                LEFT JOIN brands b ON p.brand_id = b.id
                LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 1
                WHERE p.category_id = ? AND p.status = 1
                {$brandWhere} {$priceWhere}
                GROUP BY p.id
                ORDER BY {$orderClause}";

        $products = $this->db->fetchAll($sql, $params);

        $categories = $this->db->fetchAll(
            "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
        );

        $brands = $this->db->fetchAll(
            "SELECT DISTINCT b.id, b.name, b.slug
             FROM brands b
             JOIN products p ON p.brand_id = b.id
             WHERE p.category_id = ? AND p.status = 1 AND b.status = 1
             ORDER BY b.name ASC",
            [$category['id']]
        );

        $priceRange = $this->db->fetch(
            "SELECT MIN(COALESCE(sale_price, price)) as min_price,
                    MAX(COALESCE(sale_price, price)) as max_price
             FROM products
             WHERE category_id = ? AND status = 1",
            [$category['id']]
        );

        $this->data['title'] = html_entity_decode($category['name']) . ' — Industrial Tool Shop';
        $this->data['category'] = $category;
        $this->data['all_page'] = false;
        $this->data['products'] = $products;
        $this->data['categories'] = $categories;
        $this->data['brands'] = $brands;
        $this->data['price_range'] = $priceRange;
        $this->data['current_sort'] = $sort;
        $this->data['active_brands'] = $brandFilter;
        $this->data['min_price_filter'] = $minPrice;
        $this->data['max_price_filter'] = $maxPrice;

        $this->view('collections/show');
    }
}
