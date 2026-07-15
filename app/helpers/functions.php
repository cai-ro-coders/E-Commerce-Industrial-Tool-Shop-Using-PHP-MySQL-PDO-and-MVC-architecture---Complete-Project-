<?php

function base_url($path = '') {
    return BASE_URL . ltrim($path, '/');
}

function assets_url($path = '') {
    return ASSETS_URL . ltrim($path, '/');
}

function uploads_url($path = '') {
    return UPLOADS_URL . ltrim($path, '/');
}

function redirect($url) {
    header('Location: ' . BASE_URL . ltrim($url, '/'));
    exit;
}

function back() {
    $url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL;
    header('Location: ' . $url);
    exit;
}

function json_response($data, $code = 200) {
    http_response_code($code);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function sanitize($input) {
    return htmlspecialchars(strip_tags(trim((string)$input)), ENT_QUOTES, 'UTF-8');
}

function old($key, $default = '') {
    return isset($_SESSION['_old_input'][$key]) ? $_SESSION['_old_input'][$key] : $default;
}

function set_old_input($data) {
    $_SESSION['_old_input'] = $data;
}

function clear_old_input() {
    unset($_SESSION['_old_input']);
}

function flash($key, $message = null) {
    if ($message !== null) {
        $_SESSION['_flash'][$key] = $message;
    } elseif (isset($_SESSION['_flash'][$key])) {
        $msg = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $msg;
    }
    return null;
}

function has_flash($key) {
    return isset($_SESSION['_flash'][$key]);
}

function csrf_field() {
    $token = csrf_token();
    return '<input type="hidden" name="_csrf_token" value="' . $token . '">';
}

function csrf_token() {
    if (!isset($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function verify_csrf($token) {
    if (!isset($_SESSION['_csrf_token']) || $token !== $_SESSION['_csrf_token']) {
        return false;
    }
    return true;
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function is_staff() {
    return isset($_SESSION['user_role']) && ($_SESSION['user_role'] === 'staff' || $_SESSION['user_role'] === 'admin');
}

function require_login() {
    if (!is_logged_in()) {
        flash('error', 'Please login to continue');
        redirect('login');
    }
}

function wishlist_count() {
    if (!is_logged_in()) return 0;
    $db = \App\Helpers\Database::getInstance();
    return (int)$db->fetch(
        "SELECT COUNT(*) as c FROM wishlists WHERE user_id = ?",
        [$_SESSION['user_id']]
    )['c'];
}

function cart_count() {
    if (!is_logged_in()) return 0;
    $db = \App\Helpers\Database::getInstance();
    return (int)$db->fetch(
        "SELECT COALESCE(SUM(ci.quantity), 0) as c
         FROM cart_items ci
         JOIN carts ca ON ci.cart_id = ca.id
         WHERE ca.user_id = ?",
        [$_SESSION['user_id']]
    )['c'];
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        flash('error', 'Access denied. Admin only.');
        redirect('dashboard');
    }
}

function require_staff() {
    require_login();
    if (!is_staff()) {
        flash('error', 'Access denied.');
        redirect('dashboard');
    }
}

function format_price($price) {
    $currency = get_setting('currency', 'USD');
    $symbols = ['USD' => '$', 'EUR' => '€', 'GBP' => '£', 'CAD' => 'CA$'];
    $symbol = isset($symbols[$currency]) ? $symbols[$currency] : '$';
    return $symbol . number_format((float)$price, 2);
}

function format_date($date, $format = 'M d, Y') {
    if (!$date || $date === '0000-00-00 00:00:00') return '-';
    return date($format, strtotime($date));
}

function format_datetime($date) {
    return format_date($date, 'M d, Y h:i A');
}

function time_ago($datetime) {
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;
    $intervals = [
        31536000 => 'year', 2592000 => 'month', 604800 => 'week',
        86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second'
    ];
    foreach ($intervals as $seconds => $label) {
        $count = floor($diff / $seconds);
        if ($count >= 1) {
            return $count . ' ' . $label . ($count > 1 ? 's' : '') . ' ago';
        }
    }
    return 'just now';
}

function truncate($text, $length = 100) {
    if (strlen($text) <= $length) return $text;
    return substr($text, 0, $length) . '...';
}

function upload_file($file, $directory = 'images') {
    $target_dir = dirname(dirname(__DIR__)) . '/public/uploads/' . $directory . '/';
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
    if (!in_array($ext, $allowed)) {
        return ['success' => false, 'error' => 'File type not allowed'];
    }
    $filename = time() . '_' . uniqid() . '.' . $ext;
    if (move_uploaded_file($file['tmp_name'], $target_dir . $filename)) {
        return ['success' => true, 'filename' => $directory . '/' . $filename];
    }
    return ['success' => false, 'error' => 'Failed to upload file'];
}

function delete_file($path) {
    if ($path) {
        $full_path = dirname(dirname(__DIR__)) . '/public/uploads/' . $path;
        if (file_exists($full_path)) {
            unlink($full_path);
        }
    }
}

function paginate($total, $per_page = 10) {
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $total_pages = ceil($total / $per_page);
    $offset = ($page - 1) * $per_page;
    return [
        'page' => $page,
        'per_page' => $per_page,
        'total' => $total,
        'total_pages' => $total_pages,
        'offset' => $offset
    ];
}

function pagination_links($pagination) {
    $query = $_GET;
    unset($query['page']);
    $base = '?' . http_build_query($query) . '&page=';
    
    $html = '<nav><ul class="pagination justify-content-center">';
    
    if ($pagination['page'] > 1) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base . '1' . '">First</a></li>';
        $html .= '<li class="page-item"><a class="page-link" href="' . $base . ($pagination['page'] - 1) . '">Prev</a></li>';
    }
    
    $start = max(1, $pagination['page'] - 2);
    $end = min($pagination['total_pages'], $pagination['page'] + 2);
    
    for ($i = $start; $i <= $end; $i++) {
        $active = $i == $pagination['page'] ? ' active' : '';
        $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $base . $i . '">' . $i . '</a></li>';
    }
    
    if ($pagination['page'] < $pagination['total_pages']) {
        $html .= '<li class="page-item"><a class="page-link" href="' . $base . ($pagination['page'] + 1) . '">Next</a></li>';
        $html .= '<li class="page-item"><a class="page-link" href="' . $base . $pagination['total_pages'] . '">Last</a></li>';
    }
    
    $html .= '</ul></nav>';
    return $html;
}

function get_setting($key, $default = '') {
    try {
        $db = \App\Helpers\Database::getInstance();
        $stmt = $db->query("SELECT `value` FROM settings WHERE `key` = ?", [$key]);
        $result = $stmt->fetch();
        return $result ? $result['value'] : $default;
    } catch (Exception $e) {
        return $default;
    }
}

function generate_slug($string) {
    $string = preg_replace('/[^a-zA-Z0-9\s-]/', '', $string);
    $string = strtolower(trim(preg_replace('/\s+/', '-', $string)));
    return $string;
}

function generate_order_number() {
    return 'ORD-' . strtoupper(uniqid());
}

function export_csv($data, $filename = 'export.csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    $output = fopen('php://output', 'w');
    fputcsv($output, array_keys($data[0]));
    foreach ($data as $row) {
        fputcsv($output, $row);
    }
    fclose($output);
    exit;
}

function export_json($data, $filename = 'export.json') {
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    echo json_encode($data, JSON_PRETTY_PRINT);
    exit;
}

function get_status_badge($status) {
    $badges = [
        'Pending' => 'warning',
        'Processing' => 'info',
        'Shipped' => 'primary',
        'Delivered' => 'success',
        'Cancelled' => 'danger',
        'Returned' => 'secondary',
        'Paid' => 'success',
        'Failed' => 'danger',
        'Refunded' => 'warning',
        'active' => 'success',
        'inactive' => 'danger',
        1 => 'success',
        0 => 'danger',
    ];
    $class = isset($badges[$status]) ? $badges[$status] : 'secondary';
    return '<span class="badge bg-' . $class . '">' . ucfirst($status) . '</span>';
}
