<?php
$success_msg = flash('success');
$error_msg = flash('error');
$warning_msg = flash('warning');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $app_name ?> - <?= $title ?? 'Authentication' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/auth.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="auth-wrapper min-vh-100 d-flex align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-9 col-md-7 col-lg-5 col-xl-4">

                    <div class="text-center mb-4">
                        <a href="<?= $base_url ?>" class="text-decoration-none">
                            <i class="fas fa-tools fa-3x text-primary"></i>
                            <h3 class="mt-2 fw-bold text-dark"><?= $app_name ?></h3>
                        </a>
                    </div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">

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
                            <?php if ($warning_msg): ?>
                                <div class="alert alert-warning alert-dismissible fade show">
                                    <i class="fas fa-exclamation-triangle me-2"></i><?= $warning_msg ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            <?php endif; ?>

                            <?php require dirname(__DIR__) . '/' . $content_view . '.php'; ?>

                        </div>
                    </div>

                    <p class="text-center text-muted small mt-3">
                        &copy; <?= date('Y') ?> <?= $app_name ?>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $assets_url ?>js/auth.js"></script>
</body>
</html>
