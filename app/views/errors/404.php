<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light min-vh-100 d-flex align-items-center">
    <div class="container text-center py-5">
        <div class="mb-4">
            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 6rem;"></i>
        </div>
        <h1 class="display-1 fw-bold text-muted">404</h1>
        <h3 class="mb-3">Oops! Page Not Found</h3>
        <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">
            The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
        </p>
        <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg px-4">
            <i class="fas fa-home me-2"></i>Go to Homepage
        </a>
    </div>
</body>
</html>
