<form action="<?= $base_url ?>reset-password/<?= $token ?>" method="POST" class="needs-validation" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="token" value="<?= $token ?>">

    <h4 class="card-title text-center mb-1">Reset Password</h4>
    <p class="text-muted text-center mb-4 small">
        Enter your new password below.
    </p>

    <div class="mb-3">
        <label for="password" class="form-label">New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Min. 8 characters" required minlength="8" autocomplete="new-password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <i class="fas fa-eye"></i>
            </button>
        </div>
        <div class="form-text">Must be at least 8 characters long.</div>
    </div>

    <div class="mb-4">
        <label for="password_confirm" class="form-label">Confirm New Password</label>
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" id="password_confirm" name="password_confirm"
                   placeholder="Re-enter new password" required autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2">
        <i class="fas fa-save me-2"></i>Reset Password
    </button>

    <div class="text-center mt-3">
        <a href="<?= $base_url ?>login" class="small text-decoration-none">
            <i class="fas fa-arrow-left me-1"></i>Back to Login
        </a>
    </div>
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
