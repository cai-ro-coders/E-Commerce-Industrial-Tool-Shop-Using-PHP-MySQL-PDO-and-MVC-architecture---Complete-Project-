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
$success_msg = flash('success');
$error_msg = flash('error');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?> - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/admin.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">

        <!-- Offcanvas Sidebar (Mobile) -->
        <div class="offcanvas offcanvas-start sidebar-offcanvas" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title"><?= $app_name ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <?php require __DIR__ . '/_sidebar.php'; ?>
            </div>
        </div>

        <!-- Sidebar (Desktop) -->
        <aside class="sidebar d-none d-lg-block">
            <div class="sidebar-brand">
                <a href="<?= $base_url ?>admin/dashboard">
                    <i class="fas fa-tools me-2"></i><?= $app_name ?>
                </a>
            </div>
            <hr class="sidebar-divider">
            <?php require __DIR__ . '/_sidebar.php'; ?>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">

            <!-- Top Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-outline-secondary d-lg-none me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarOffcanvas">
                        <i class="fas fa-bars"></i>
                    </button>
                    <button class="btn btn-outline-secondary d-none d-lg-inline-block me-2 sidebar-toggle-btn" type="button">
                        <i class="fas fa-bars"></i>
                    </button>

                    <span class="navbar-text d-none d-md-inline">
                        <i class="fas fa-tachometer-alt me-1"></i>Admin Panel
                    </span>

                    <div class="ms-auto d-flex align-items-center gap-3">
                        <form class="d-none d-md-flex" action="<?= $base_url ?>admin/products" method="GET">
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" name="search" placeholder="Search..." aria-label="Search">
                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </form>

                        <a href="#" class="text-dark position-relative" title="Notifications">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </a>

                        <div class="dropdown">
                            <button class="btn btn-link text-dark dropdown-toggle text-decoration-none" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fa-lg me-1"></i>
                                <span class="d-none d-md-inline"><?= $current_user['name'] ?? 'Admin' ?></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?= $base_url ?>admin/profile"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="<?= $base_url ?>admin/change-password"><i class="fas fa-key me-2"></i>Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= $base_url ?>logout"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="main-content p-3 p-lg-4">
                <?php if ($success_msg): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i><?= $success_msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if ($error_msg): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle me-2"></i><?= $error_msg ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php require dirname(__DIR__) . '/' . $content_view . '.php'; ?>
            </main>

            <!-- Footer -->
            <footer class="footer bg-white border-top px-4 py-3 text-center text-muted small">
                &copy; <?= date('Y') ?> <?= $app_name ?>. All rights reserved. &mdash; Built with <i class="fas fa-heart text-danger"></i>
            </footer>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="<?= $assets_url ?>js/admin.js"></script>
</body>
</html>
