<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Brand</h5>
        <p class="text-muted small mb-0"><?= sanitize($brand['name']) ?></p>
    </div>
    <a href="<?= $base_url ?>admin/brands" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i>Back to Brands
    </a>
</div>

<form action="<?= $base_url ?>admin/brands/update/<?= $brand['id'] ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Brand Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= sanitize($brand['name']) ?>" required>
                        </div>

                        <div class="col-12">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= sanitize($brand['slug']) ?>">
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" placeholder="Brief description of this brand"><?= sanitize($brand['description']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-image me-2 text-primary"></i>Logo</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($brand['logo'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Current Logo</label>
                            <div class="rounded border overflow-hidden" style="max-width: 200px;">
                                <img src="<?= $uploads_url . $brand['logo'] ?>"
                                     alt="<?= sanitize($brand['name']) ?>"
                                     class="w-100"
                                     style="max-height: 150px; object-fit: cover;">
                            </div>
                        </div>
                    <?php endif; ?>

                    <label for="logo" class="form-label"><?= !empty($brand['logo']) ? 'Replace Logo' : 'Brand Logo' ?></label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/jpeg,image/png,image/gif,image/webp">
                    <div class="form-text"><?= !empty($brand['logo']) ? 'Leave empty to keep existing logo.' : 'Recommended: 400x400px.' ?></div>
                    <div class="mt-2" id="logoPreview"></div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-cog me-2 text-primary"></i>Settings</h6>
                </div>
                <div class="card-body">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="1" <?= $brand['status'] == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= $brand['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Brand
                </button>
                <a href="<?= $base_url ?>admin/brands" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>

<script>
document.getElementById('name')?.addEventListener('input', function() {
    const slug = document.getElementById('slug');
    if (!slug.dataset.modified) {
        slug.value = this.value.toLowerCase().replace(/[^a-z0-9\s-]/g, '').replace(/\s+/g, '-').replace(/-+/g, '-').trim();
    }
});

document.getElementById('slug')?.addEventListener('input', function() {
    this.dataset.modified = this.value !== '';
});

document.getElementById('logo')?.addEventListener('change', function(e) {
    const preview = document.getElementById('logoPreview');
    preview.innerHTML = '';
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            preview.innerHTML = '<img src="' + ev.target.result + '" class="img-thumbnail" style="max-height: 150px; object-fit: cover;">';
        };
        reader.readAsDataURL(file);
    }
});
</script>
