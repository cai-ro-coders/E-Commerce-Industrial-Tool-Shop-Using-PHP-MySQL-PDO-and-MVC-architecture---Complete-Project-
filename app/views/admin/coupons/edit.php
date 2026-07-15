<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Coupon</h5>
        <p class="text-muted small mb-0"><?= sanitize($coupon['code']) ?></p>
    </div>
    <a href="<?= $base_url ?>admin/coupons" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Coupons
    </a>
</div>

<form action="<?= $base_url ?>admin/coupons/update/<?= $coupon['id'] ?>" method="POST" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Coupon Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="code" class="form-label">Coupon Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-uppercase" id="code" name="code" value="<?= sanitize($coupon['code']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class="form-label">Discount Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="percentage" <?= $coupon['type'] === 'percentage' ? 'selected' : '' ?>>Percentage</option>
                                <option value="fixed" <?= $coupon['type'] === 'fixed' ? 'selected' : '' ?>>Fixed Amount</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="value" class="form-label">Discount Value <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" class="form-control" id="value" name="value" value="<?= (float)$coupon['value'] ?>" required>
                                <span class="input-group-text" id="valueSuffix"><?= $coupon['type'] === 'percentage' ? '%' : '$' ?></span>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="minimum_order" class="form-label">Minimum Order Amount</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="minimum_order" name="minimum_order" value="<?= (float)$coupon['minimum_order'] ?>">
                            <div class="form-text">Minimum cart total to apply this coupon.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="maximum_discount" class="form-label">Maximum Discount</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="maximum_discount" name="maximum_discount" value="<?= $coupon['maximum_discount'] !== null ? (float)$coupon['maximum_discount'] : '' ?>" placeholder="Leave empty for no limit">
                            <div class="form-text">Only applies to percentage discounts.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="usage_limit" class="form-label">Usage Limit</label>
                            <input type="number" min="1" class="form-control" id="usage_limit" name="usage_limit" value="<?= $coupon['usage_limit'] !== null ? (int)$coupon['usage_limit'] : '' ?>" placeholder="Leave empty for unlimited">
                            <div class="form-text">Maximum number of times this coupon can be used.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $coupon['start_date'] ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $coupon['end_date'] ?>" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-cog me-2 text-primary"></i>Settings</h6>
                </div>
                <div class="card-body">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1" <?= $coupon['status'] == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $coupon['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>

                    <hr>
                    <div class="small text-muted">
                        <p class="mb-1"><strong>Used:</strong> <?= (int)$coupon['used_count'] ?></p>
                        <p class="mb-0"><strong>Created:</strong> <?= format_date($coupon['created_at']) ?></p>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Coupon
                </button>
                <a href="<?= $base_url ?>admin/coupons" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('type')?.addEventListener('change', function() {
    const suffix = document.getElementById('valueSuffix');
    suffix.textContent = this.value === 'percentage' ? '%' : '<?= htmlentities($app_name ?? '$') ?>';
});
</script>
