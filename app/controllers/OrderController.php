<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Address;
use App\Models\Notification;

class OrderController extends Controller
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
            $where = "WHERE (o.order_number LIKE ? OR u.name LIKE ?)";
            $params = ["%{$search}%", "%{$search}%"];
        }

        $countSql = "SELECT COUNT(*) as count FROM orders o
                     LEFT JOIN users u ON o.user_id = u.id {$where}";
        $total = $this->db->fetch($countSql, $params)['count'];
        $pagination = paginate($total, $perPage);

        $sql = "SELECT o.*, u.name as customer_name
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                {$where}
                ORDER BY o.created_at DESC
                LIMIT ? OFFSET ?";
        $queryParams = array_merge($params, [$perPage, $offset]);
        $orders = $this->db->fetchAll($sql, $queryParams);

        foreach ($orders as &$order) {
            $items = $this->db->fetchAll(
                "SELECT COUNT(*) as count, SUM(total) as total FROM order_items WHERE order_id = ?",
                [$order['id']]
            );
            $order['items_count'] = $items[0]['count'];
            $order['items_total'] = $items[0]['total'];
        }
        unset($order);

        $this->data['title'] = 'Orders';
        $this->data['orders'] = $orders;
        $this->data['pagination'] = $pagination;
        $this->data['search'] = $search;

        $this->render('admin/orders/index');
    }

    public function show($id)
    {
        require_admin();

        $order = $this->resolveOrder($id);

        if (!$order) {
            flash('error', 'Order not found');
            $this->redirect('admin/orders');
        }

        $address = null;
        if ($order['shipping_address_id']) {
            $address = $this->db->fetch(
                "SELECT * FROM addresses WHERE id = ?",
                [$order['shipping_address_id']]
            );
        }

        $items = $this->db->fetchAll(
            "SELECT oi.*, pi.image as product_image
             FROM order_items oi
             LEFT JOIN product_images pi ON oi.product_id = pi.product_id AND pi.is_primary = 1
             WHERE oi.order_id = ?",
            [$order['id']]
        );

        $payment = $this->db->fetch(
            "SELECT * FROM payments WHERE order_id = ? LIMIT 1",
            [$order['id']]
        );

        $this->data['title'] = 'Order #' . $order['order_number'];
        $this->data['order'] = $order;
        $this->data['address'] = $address;
        $this->data['items'] = $items;
        $this->data['payment'] = $payment;

        $this->render('admin/orders/view');
    }

    public function edit($id)
    {
        require_admin();

        $order = new Order();
        $record = $order->find($id);
        if (!$record) {
            $record = $order->findBy('order_number', $id);
        }

        if (!$record) {
            flash('error', 'Order not found');
            $this->redirect('admin/orders');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
            if (!verify_csrf($token)) {
                flash('error', 'Invalid security token');
                $this->redirect("admin/orders/edit/{$id}");
            }

            $orderStatus = sanitize($_POST['order_status'] ?? '');
            $paymentStatus = sanitize($_POST['payment_status'] ?? '');
            $notes = sanitize($_POST['notes'] ?? '');

            $validOrderStatuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled', 'Returned'];
            $validPaymentStatuses = ['Pending', 'Paid', 'Failed', 'Refunded'];

            if (!in_array($orderStatus, $validOrderStatuses)) {
                flash('error', 'Invalid order status');
                $this->back();
            }

            if (!in_array($paymentStatus, $validPaymentStatuses)) {
                flash('error', 'Invalid payment status');
                $this->back();
            }

            if ($orderStatus === 'Delivered' && $paymentStatus !== 'Paid') {
                $paymentStatus = 'Paid';
            }

            $updateData = [
                'order_status' => $orderStatus,
                'payment_status' => $paymentStatus,
                'notes' => $notes
            ];

            $order->update($record['id'], $updateData);

            if ($orderStatus !== $record['order_status']) {
                $statusMessages = [
                    'Pending'    => 'Your order is now pending.',
                    'Processing' => 'Your order is being processed.',
                    'Shipped'    => 'Your order has been shipped!',
                    'Delivered'  => 'Your order has been delivered.',
                    'Cancelled'  => 'Your order has been cancelled.',
                    'Returned'   => 'Your order has been returned.',
                ];
                $message = $statusMessages[$orderStatus] ?? "Order status changed to {$orderStatus}.";
                $this->db->query(
                    "CREATE TABLE IF NOT EXISTS notifications (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        user_id INT NOT NULL,
                        type VARCHAR(50) NOT NULL DEFAULT 'order',
                        title VARCHAR(255) NOT NULL,
                        message TEXT,
                        order_id INT,
                        order_number VARCHAR(50),
                        order_status VARCHAR(50),
                        is_read TINYINT(1) NOT NULL DEFAULT 0,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE SET NULL
                    ) ENGINE=InnoDB"
                );
                $notif = new Notification();
                $notif->create([
                    'user_id'      => $record['user_id'],
                    'type'         => 'order',
                    'title'        => "Order #{$record['order_number']} - {$orderStatus}",
                    'message'      => $message,
                    'order_id'     => $record['id'],
                    'order_number' => $record['order_number'],
                    'order_status' => $orderStatus,
                ]);
            }

            flash('success', 'Order updated successfully');
            $this->redirect("admin/orders/view/{$record['id']}");
        }

        $items = $this->db->fetchAll(
            "SELECT * FROM order_items WHERE order_id = ?",
            [$record['id']]
        );

        $this->data['title'] = 'Edit Order #' . $record['order_number'];
        $this->data['order'] = $record;
        $this->data['items'] = $items;

        $this->render('admin/orders/edit');
    }

    public function delete($id)
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/orders');
        }

        $order = new Order();
        $record = $order->find($id);
        if (!$record) {
            $record = $order->findBy('order_number', $id);
        }

        if (!$record) {
            flash('error', 'Order not found');
            $this->redirect('admin/orders');
        }

        $this->db->delete("DELETE FROM order_items WHERE order_id = ?", [$record['id']]);
        $this->db->delete("DELETE FROM payments WHERE order_id = ?", [$record['id']]);
        $order->delete($record['id']);

        flash('success', 'Order deleted successfully');
        $this->redirect('admin/orders');
    }

    public function printReceipt($id)
    {
        require_admin();

        $order = $this->resolveOrder($id);

        if (!$order) {
            flash('error', 'Order not found');
            $this->redirect('admin/orders');
        }

        $address = null;
        if ($order['shipping_address_id']) {
            $address = $this->db->fetch(
                "SELECT * FROM addresses WHERE id = ?",
                [$order['shipping_address_id']]
            );
        }

        $items = $this->db->fetchAll(
            "SELECT oi.*, pi.image as product_image
             FROM order_items oi
             LEFT JOIN product_images pi ON oi.product_id = pi.product_id AND pi.is_primary = 1
             WHERE oi.order_id = ?",
            [$order['id']]
        );

        $payment = $this->db->fetch(
            "SELECT * FROM payments WHERE order_id = ? LIMIT 1",
            [$order['id']]
        );

        $this->data['title'] = 'Receipt #' . $order['order_number'];
        $this->data['order'] = $order;
        $this->data['address'] = $address;
        $this->data['items'] = $items;
        $this->data['payment'] = $payment;
        $this->view('admin/orders/print');
    }

    public function exportCsv()
    {
        require_admin();

        $orders = $this->db->fetchAll(
            "SELECT o.*, u.name as customer_name, u.email as customer_email
             FROM orders o
             LEFT JOIN users u ON o.user_id = u.id
             ORDER BY o.created_at DESC"
        );

        $data = [];
        foreach ($orders as $o) {
            $items = $this->db->fetchAll(
                "SELECT product_name, quantity, price, total FROM order_items WHERE order_id = ?",
                [$o['id']]
            );
            $itemDetails = [];
            foreach ($items as $item) {
                $itemDetails[] = $item['product_name'] . ' (x' . $item['quantity'] . ')';
            }

            $data[] = [
                'Order #' => $o['order_number'],
                'Customer' => $o['customer_name'] ?? 'Guest',
                'Email' => $o['customer_email'] ?? '',
                'Items' => implode(', ', $itemDetails),
                'Subtotal' => $o['subtotal'],
                'Discount' => $o['discount'],
                'Shipping' => $o['shipping_fee'],
                'Tax' => $o['tax'],
                'Grand Total' => $o['grand_total'],
                'Payment Method' => $o['payment_method'],
                'Payment Status' => $o['payment_status'],
                'Order Status' => $o['order_status'],
                'Notes' => $o['notes'] ?? '',
                'Created At' => $o['created_at']
            ];
        }

        export_csv($data, 'orders_export.csv');
    }

    private function resolveOrder($id)
    {
        if (is_numeric($id)) {
            $order = $this->db->fetch(
                "SELECT o.*, u.name as customer_name, u.email as customer_email
                 FROM orders o
                 LEFT JOIN users u ON o.user_id = u.id
                 WHERE o.id = ?",
                [$id]
            );
            if ($order) return $order;
        }

        return $this->db->fetch(
            "SELECT o.*, u.name as customer_name, u.email as customer_email
             FROM orders o
             LEFT JOIN users u ON o.user_id = u.id
             WHERE o.order_number = ?",
            [$id]
        );
    }
}
