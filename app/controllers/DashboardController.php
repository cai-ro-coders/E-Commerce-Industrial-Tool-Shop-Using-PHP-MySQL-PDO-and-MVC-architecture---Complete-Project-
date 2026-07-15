<?php

namespace App\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        require_admin();

        $totalRevenue = $this->db->fetch(
            "SELECT COALESCE(SUM(grand_total), 0) as total FROM orders WHERE order_status != 'Cancelled'"
        )['total'];

        $todayOrders = $this->db->fetch(
            "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()"
        )['count'];

        $yesterdayOrders = $this->db->fetch(
            "SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE() - INTERVAL 1 DAY"
        )['count'];

        $totalOrders = $this->db->fetch(
            "SELECT COUNT(*) as count FROM orders"
        )['count'];

        $totalProducts = $this->db->fetch(
            "SELECT COUNT(*) as count FROM products"
        )['count'];

        $totalCustomers = $this->db->fetch(
            "SELECT COUNT(*) as count FROM users WHERE role = 'customer'"
        )['count'];

        $totalCategories = $this->db->fetch(
            "SELECT COUNT(*) as count FROM categories"
        )['count'];

        $totalRevenueToday = $this->db->fetch(
            "SELECT COALESCE(SUM(grand_total), 0) as total FROM orders WHERE DATE(created_at) = CURDATE() AND order_status != 'Cancelled'"
        )['total'];

        $weeklySales = $this->db->fetchAll(
            "SELECT DATE(created_at) as date, COALESCE(SUM(grand_total), 0) as total
             FROM orders WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
             AND order_status != 'Cancelled'
             GROUP BY DATE(created_at) ORDER BY date ASC"
        );

        $bestSellers = $this->db->fetchAll(
            "SELECT oi.product_id, p.name, p.slug, SUM(oi.quantity) as total_qty, SUM(oi.total) as total_revenue
             FROM order_items oi JOIN products p ON oi.product_id = p.id
             GROUP BY oi.product_id ORDER BY total_qty DESC LIMIT 5"
        );

        $recentOrders = $this->db->fetchAll(
            "SELECT o.*, u.name as customer_name
             FROM orders o JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC LIMIT 10"
        );

        foreach ($recentOrders as &$order) {
            $image = $this->db->fetch(
                "SELECT pi.image FROM order_items oi
                 JOIN product_images pi ON oi.product_id = pi.product_id AND pi.is_primary = 1
                 WHERE oi.order_id = ? LIMIT 1",
                [$order['id']]
            );
            $order['product_image'] = $image ? $image['image'] : null;
        }
        unset($order);

        $this->data['title'] = 'Dashboard';
        $this->data['total_revenue'] = $totalRevenue;
        $this->data['today_orders'] = $todayOrders;
        $this->data['yesterday_orders'] = $yesterdayOrders;
        $this->data['total_orders'] = $totalOrders;
        $this->data['total_products'] = $totalProducts;
        $this->data['total_customers'] = $totalCustomers;
        $this->data['total_categories'] = $totalCategories;
        $this->data['total_revenue_today'] = $totalRevenueToday;
        $this->data['weekly_sales'] = $weeklySales;
        $this->data['best_sellers'] = $bestSellers;
        $this->data['recent_orders'] = $recentOrders;

        $this->render('admin/dashboard/index');
    }
}
