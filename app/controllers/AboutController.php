<?php

namespace App\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        $reviews = $this->db->fetchAll(
            "SELECT r.*, u.name as user_name
             FROM reviews r
             LEFT JOIN users u ON r.user_id = u.id
             WHERE r.status = 1
             ORDER BY r.created_at DESC LIMIT 3"
        );

        $brands = $this->db->fetchAll(
            "SELECT * FROM brands WHERE status = 1 ORDER BY name ASC"
        );

        $this->data['title'] = 'About Us';
        $this->data['reviews'] = $reviews;
        $this->data['brands'] = $brands;

        $this->view('about/index');
    }
}
