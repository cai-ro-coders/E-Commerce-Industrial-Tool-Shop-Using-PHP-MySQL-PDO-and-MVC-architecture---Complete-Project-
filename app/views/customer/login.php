<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Sign in to your ToolShop account.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/customer-auth.css" rel="stylesheet">
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<!-- Hero Breadcrumb -->
<section class="auth-hero">
    <div class="auth-hero-bg"></div>
    <div class="auth-hero-overlay"></div>
    <div class="auth-hero-content">
        <h1 class="auth-hero-title">Sign In</h1>
        <nav class="auth-breadcrumb">
            <a href="<?= $base_url ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">Sign In</span>
        </nav>
    </div>
</section>

<main class="customer-auth-page">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-header">
                <div class="auth-icon"><i class="fas fa-user-circle"></i></div>
                <h1>Welcome Back</h1>
                <p>Sign in to your account to continue</p>
            </div>
            <div class="auth-card-body">
                <?php if ($msg = flash('error')): ?>
                    <div class="auth-alert auth-alert-error"><?= htmlspecialchars($msg) ?></div>
                <?php endif; ?>
                <?php if ($msg = flash('success')): ?>
                    <div class="auth-alert auth-alert-success"><?= htmlspecialchars($msg) ?></div>
                <?php endif; ?>
                <form method="POST" action="<?= $base_url ?>customer/login">
                    <?= csrf_field() ?>
                    <div class="auth-field">
                        <label for="email">Email Address</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="email" name="email" class="auth-input" placeholder="you@example.com" value="<?= htmlspecialchars(old('email')) ?>" required>
                        </div>
                    </div>
                    <div class="auth-field">
                        <label for="password">Password</label>
                        <div class="auth-input-wrap">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="password" name="password" class="auth-input" placeholder="Enter your password" required>
                        </div>
                    </div>
                    <div class="auth-options">
                        <label class="auth-checkbox">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Remember me
                        </label>
                        <a href="<?= $base_url ?>forgot-password" class="auth-forgot">Forgot password?</a>
                    </div>
                    <button type="submit" class="auth-submit">Sign In</button>
                </form>
            </div>
            <div class="auth-card-footer">
                Don't have an account? <a href="<?= $base_url ?>customer/register">Create one</a>
            </div>
        </div>
    </div>
</main>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

</body>
</html>
