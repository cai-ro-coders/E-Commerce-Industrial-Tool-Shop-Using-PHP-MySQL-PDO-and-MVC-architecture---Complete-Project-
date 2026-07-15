<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Change Password</h5>
        <p class="text-muted small mb-0">Update your account password</p>
    </div>
    <a href="<?= $base_url ?>admin/profile" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Profile
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="<?= $base_url ?>admin/change-password" method="POST" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="current_password"
                                   name="current_password" placeholder="Enter current password" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="new_password"
                                   name="new_password" placeholder="Min. 8 characters"
                                   required minlength="8">
                            <button class="btn btn-outline-secondary" type="button" id="toggleNew">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="form-text">Must be at least 8 characters long and different from your current password.</div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="confirm_password"
                                   name="confirm_password" placeholder="Re-enter new password" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Password
                        </button>
                        <a href="<?= $base_url ?>admin/profile" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('toggleNew')?.addEventListener('click', function() {
    const input = document.getElementById('new_password');
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
