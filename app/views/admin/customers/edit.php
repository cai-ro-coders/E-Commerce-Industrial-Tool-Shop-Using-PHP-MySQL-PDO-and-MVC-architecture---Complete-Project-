<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Customer</h5>
        <p class="text-muted small mb-0"><?= sanitize($customer['name']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/customers/view/<?= $customer['id'] ?>" class="btn btn-outline-info btn-sm">
            <i class="fas fa-eye me-1"></i>View
        </a>
        <a href="<?= $base_url ?>admin/customers" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Customers
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer Information</h6>
            </div>
            <div class="card-body">
                <form action="<?= $base_url ?>admin/customers/update/<?= $customer['id'] ?>" method="POST" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= sanitize($customer['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= sanitize($customer['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= sanitize($customer['phone']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6">
                        <div class="form-text">Leave blank to keep current password. Minimum 6 characters if changing.</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?= $customer['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $customer['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Customer
                        </button>
                        <a href="<?= $base_url ?>admin/customers" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelector('form')?.addEventListener('submit', function(e) {
    const password = document.getElementById('password');
    const confirm = document.getElementById('password_confirm');
    if (password.value !== '' || confirm.value !== '') {
        if (password.value !== confirm.value) {
            e.preventDefault();
            confirm.setCustomValidity('Passwords do not match');
            confirm.reportValidity();
        }
    }
});
document.getElementById('password_confirm')?.addEventListener('input', function() {
    this.setCustomValidity('');
});
</script>
