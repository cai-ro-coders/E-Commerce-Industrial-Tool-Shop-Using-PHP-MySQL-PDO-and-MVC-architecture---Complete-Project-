<form action="<?= $base_url ?>login" method="POST" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <h4 class="card-title text-center mb-1">Welcome Back</h4>
    <p class="text-muted text-center mb-4 small">Sign in to your admin account</p>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= old('email') ?>" placeholder="you@example.com"
                   required autofocus autocomplete="email">
        </div>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter your password" required autocomplete="current-password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
            <label class="form-check-label small" for="remember">Remember Me</label>
        </div>
        <a href="<?= $base_url ?>forgot-password" class="small text-decoration-none">Forgot Password?</a>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2">
        <i class="fas fa-sign-in-alt me-2"></i>Sign In
    </button>
</form>

<script>
document.getElementById('togglePassword')?.addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});
</script>
