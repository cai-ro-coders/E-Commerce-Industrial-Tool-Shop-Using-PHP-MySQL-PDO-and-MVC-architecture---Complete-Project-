<?php

namespace App\Controllers;

class ReviewController extends Controller
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
            $where = "WHERE (r.title LIKE ? OR r.comment LIKE ?)";
            $params = ["%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM reviews r {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT r.*, p.name as product_name, u.name as user_name
                FROM reviews r
                JOIN products p ON r.product_id = p.id
                JOIN users u ON r.user_id = u.id
                {$where}
                ORDER BY r.created_at DESC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $reviews = $this->db->fetchAll($sql, $queryParams);

        $this->data['title'] = 'Reviews';
        $this->data['reviews'] = $reviews;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/reviews/index');
    }

    public function edit($id)
    {
        require_admin();

        $review = $this->db->fetch(
            "SELECT r.*, p.name as product_name, u.name as user_name
             FROM reviews r
             JOIN products p ON r.product_id = p.id
             JOIN users u ON r.user_id = u.id
             WHERE r.id = ?",
            [$id]
        );

        if (!$review) {
            flash('error', 'Review not found');
            $this->redirect('admin/reviews');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
            if (!verify_csrf($token)) {
                flash('error', 'Invalid security token');
                $this->redirect("admin/reviews/edit/{$id}");
            }

            $title = sanitize($_POST['title'] ?? '');
            $comment = sanitize($_POST['comment'] ?? '');
            $status = (int)($_POST['status'] ?? 0);

            $this->db->update(
                "UPDATE reviews SET title = ?, comment = ?, status = ?, updated_at = NOW() WHERE id = ?",
                [$title, $comment, $status, $id]
            );

            flash('success', 'Review updated successfully');
            $this->redirect('admin/reviews');
        }

        $this->data['title'] = 'Edit Review';
        $this->data['review'] = $review;

        $this->render('admin/reviews/edit');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/reviews');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/reviews');
        }

        $review = $this->db->fetch("SELECT * FROM reviews WHERE id = ?", [$id]);

        if (!$review) {
            flash('error', 'Review not found');
            $this->redirect('admin/reviews');
        }

        $this->db->delete("DELETE FROM reviews WHERE id = ?", [$id]);

        flash('success', 'Review deleted successfully');
        $this->redirect('admin/reviews');
    }
}
