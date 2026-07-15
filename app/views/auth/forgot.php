<form action="<?= $base_url ?>forgot-password" method="POST" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <h4 class="card-title text-center mb-1">Forgot Password</h4>
    <p class="text-muted text-center mb-4 small">
        Enter your email address and we'll send you a link to reset your password.
    </p>

    <div class="mb-4">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email"
                   placeholder="you@example.com" required autofocus autocomplete="email">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2">
        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
    </button>

    <div class="text-center mt-3">
        <a href="<?= $base_url ?>login" class="small text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i>Back to Login
        </a>
    </div>
</form>
