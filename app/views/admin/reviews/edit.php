<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Review</h5>
        <p class="text-muted small mb-0">Moderate customer review</p>
    </div>
    <a href="<?= $base_url ?>admin/reviews" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Reviews
    </a>
</div>

<form action="<?= $base_url ?>admin/reviews/edit/<?= $review['id'] ?>" method="POST" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Review Details</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Product</label>
                            <div class="form-control-plaintext fw-medium"><?= sanitize($review['product_name']) ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Customer</label>
                            <div class="form-control-plaintext fw-medium"><?= sanitize($review['user_name']) ?></div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Rating</label>
                            <div class="form-control-plaintext">
                                <span class="text-warning" style="font-size: 1.25rem;">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-o text-muted' ?>"></i>
                                    <?php endfor; ?>
                                </span>
                                <span class="ms-2 text-muted">(<?= (int)$review['rating'] ?>/5)</span>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="<?= sanitize($review['title'] ?? '') ?>">
                        </div>
                        <div class="col-12">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="5"><?= sanitize($review['comment'] ?? '') ?></textarea>
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
                        <option value="0" <?= $review['status'] == 0 ? 'selected' : '' ?>>Pending</option>
                        <option value="1" <?= $review['status'] == 1 ? 'selected' : '' ?>>Approved</option>
                    </select>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Review
                </button>
                <a href="<?= $base_url ?>admin/reviews" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>
