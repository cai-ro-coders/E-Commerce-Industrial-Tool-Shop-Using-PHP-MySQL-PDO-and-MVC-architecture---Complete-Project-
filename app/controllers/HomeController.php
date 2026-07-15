<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $categories = $this->db->fetchAll(
            "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
        );

        $brands = $this->db->fetchAll(
            "SELECT * FROM brands WHERE status = 1 ORDER BY name ASC"
        );

        $featuredProducts = $this->db->fetchAll(
            "SELECT p.*, pi.image as primary_image
             FROM products p
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
             WHERE p.status = 1 AND p.featured = 1
             ORDER BY p.created_at DESC LIMIT 8"
        );

        $trendingProducts = $this->db->fetchAll(
            "SELECT p.*, pi.image as primary_image
             FROM products p
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
             WHERE p.status = 1
             ORDER BY p.created_at DESC LIMIT 8"
        );

        $newArrivals = $this->db->fetchAll(
            "SELECT p.*, pi.image as primary_image
             FROM products p
             LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
             WHERE p.status = 1
             ORDER BY p.created_at DESC LIMIT 4"
        );

        $reviews = $this->db->fetchAll(
            "SELECT r.*, u.name as user_name
             FROM reviews r
             LEFT JOIN users u ON r.user_id = u.id
             WHERE r.status = 1
             ORDER BY r.created_at DESC LIMIT 6"
        );

        $this->data['title'] = APP_NAME;
        $this->data['categories'] = $categories;
        $this->data['brands'] = $brands;
        $this->data['featured_products'] = $featuredProducts;
        $this->data['trending_products'] = $trendingProducts;
        $this->data['new_arrivals'] = $newArrivals;
        $this->data['reviews'] = $reviews;

        $this->view('home/index');
    }
}
