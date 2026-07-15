<?php
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base_path = parse_url($base_url, PHP_URL_PATH);
$route = str_replace($base_path, '', $uri);
$route = trim($route, '/');
$is_active = function($slug) use ($route) {
    return strpos($route, $slug) === 0 ? 'active' : '';
};
$is_open = function($slug) use ($route) {
    return strpos($route, $slug) === 0 ? 'menu-open' : '';
};
?>
<ul class="sidebar-nav list-unstyled mb-0">
    <li class="nav-item <?= $is_active('admin/dashboard') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/dashboard">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item has-submenu <?= $is_open('admin/products') ?>">
        <a class="nav-link" href="#productsSubmenu" data-bs-toggle="collapse" role="button" aria-expanded="<?= strpos($route, 'admin/products') === 0 ? 'true' : 'false' ?>">
            <i class="fas fa-boxes"></i>
            <span>Products</span>
            <i class="fas fa-chevron-down ms-auto submenu-icon"></i>
        </a>
        <ul class="collapse submenu <?= strpos($route, 'admin/products') === 0 ? 'show' : '' ?>" id="productsSubmenu">
            <li><a class="nav-link <?= $route === 'admin/products' ? 'active' : '' ?>" href="<?= $base_url ?>admin/products"><i class="fas fa-list me-2"></i>All Products</a></li>
            <li><a class="nav-link <?= $route === 'admin/products/create' ? 'active' : '' ?>" href="<?= $base_url ?>admin/products/create"><i class="fas fa-plus me-2"></i>Add Product</a></li>
        </ul>
    </li>

    <li class="nav-item <?= $is_active('admin/orders') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/orders">
            <i class="fas fa-shopping-cart"></i>
            <span>Orders</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/customers') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/customers">
            <i class="fas fa-users"></i>
            <span>Customers</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/categories') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/categories">
            <i class="fas fa-tags"></i>
            <span>Categories</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/brands') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/brands">
            <i class="fas fa-trademark"></i>
            <span>Brands</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/coupons') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/coupons">
            <i class="fas fa-ticket-alt"></i>
            <span>Coupons</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/reviews') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/reviews">
            <i class="fas fa-star"></i>
            <span>Reviews</span>
        </a>
    </li>

    <li class="nav-item <?= $is_active('admin/settings') ?>">
        <a class="nav-link" href="<?= $base_url ?>admin/settings">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
        </a>
    </li>
</ul>
