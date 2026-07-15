<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Add Customer</h5>
        <p class="text-muted small mb-0">Create a new customer account</p>
    </div>
    <a href="<?= $base_url ?>admin/customers" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Customers
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer Information</h6>
            </div>
            <div class="card-body">
                <form action="<?= $base_url ?>admin/customers/store" method="POST" class="needs-validation" novalidate>
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" minlength="6" required>
                        <div class="form-text">Minimum 6 characters</div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Create Customer
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
    if (password.value !== confirm.value) {
        e.preventDefault();
        confirm.setCustomValidity('Passwords do not match');
        confirm.reportValidity();
    }
});
document.getElementById('password_confirm')?.addEventListener('input', function() {
    this.setCustomValidity('');
});
</script>
