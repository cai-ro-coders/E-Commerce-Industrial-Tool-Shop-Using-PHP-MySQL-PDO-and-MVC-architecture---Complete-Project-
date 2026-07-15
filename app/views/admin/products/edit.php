<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Product</h5>
        <p class="text-muted small mb-0"><?= sanitize($product['name']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/products/view/<?= $product['id'] ?>" class="btn btn-outline-info btn-sm">
            <i class="fas fa-eye me-1"></i>View
        </a>
        <a href="<?= $base_url ?>admin/products" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </div>
</div>

<form action="<?= $base_url ?>admin/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Basic Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= sanitize($product['name']) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label for="sku" class="form-label">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="<?= sanitize($product['sku']) ?>" placeholder="Auto-generated if empty">
                        </div>

                        <div class="col-md-6">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" class="form-control" id="slug" name="slug" value="<?= sanitize($product['slug']) ?>">
                        </div>

                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= $product['category_id'] == $cat['id'] ? 'selected' : '' ?>>
                                        <?= sanitize($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-select" id="brand_id" name="brand_id">
                                <option value="">Select Brand</option>
                                <?php foreach ($brands as $brand): ?>
                                    <option value="<?= $brand['id'] ?>" <?= $product['brand_id'] == $brand['id'] ? 'selected' : '' ?>>
                                        <?= sanitize($brand['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="2" maxlength="500"><?= sanitize($product['short_description']) ?></textarea>
                            <div class="form-text">Brief product summary (max 500 characters)</div>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control" id="description" name="description" rows="6"><?= $product['description'] ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-images me-2 text-primary"></i>Images</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($images)): ?>
                        <div class="row g-2 mb-3">
                            <?php foreach ($images as $img): ?>
                                <div class="col-4 col-md-3 position-relative image-item" data-id="<?= $img['id'] ?>">
                                    <div class="rounded border overflow-hidden" style="height: 120px;">
                                        <img src="<?= $uploads_url . $img['image'] ?>"
                                             alt="Product image"
                                             class="w-100 h-100"
                                             style="object-fit: cover;">
                                    </div>
                                    <?php if ($img['is_primary']): ?>
                                        <span class="badge bg-primary position-absolute top-0 start-0 m-1">Primary</span>
                                    <?php endif; ?>
                                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                            onclick="removeImage(this, <?= $img['id'] ?>)">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    <input type="hidden" name="delete_images[]" class="delete-image-input" value="" disabled>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="primary_image" class="form-label">Replace Primary Image</label>
                            <input type="file" class="form-control" id="primary_image" name="primary_image" accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Leave empty to keep existing primary image.</div>
                            <div class="mt-2" id="primaryPreview"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="additional_images" class="form-label">Add More Images</label>
                            <input type="file" class="form-control" id="additional_images" name="additional_images[]" multiple accept="image/jpeg,image/png,image/gif,image/webp">
                            <div class="form-text">Select additional images to add.</div>
                            <div class="mt-2 row g-2" id="additionalPreview"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Specifications</h6>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addSpecRow()">
                        <i class="fas fa-plus me-1"></i>Add Row
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0" id="specsTable">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Attribute Name</th>
                                    <th style="width: 40%;">Attribute Value</th>
                                    <th style="width: 20%;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="specsBody">
                                <?php if (!empty($specs)): ?>
                                    <?php foreach ($specs as $spec): ?>
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="specs[<?= $spec['id'] ?>][attribute_name]" value="<?= sanitize($spec['attribute_name']) ?>" placeholder="Attribute name">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="specs[<?= $spec['id'] ?>][attribute_value]" value="<?= sanitize($spec['attribute_value']) ?>" placeholder="Attribute value">
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mt-2 mb-0"><i class="fas fa-info-circle me-1"></i>Add product specifications like "Weight", "Dimensions", "Material", etc.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-tag me-2 text-primary"></i>Pricing</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" value="<?= $product['price'] ?>" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="sale_price" class="form-label">Sale Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="sale_price" name="sale_price" value="<?= $product['sale_price'] ?>">
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="cost_price" class="form-label">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" class="form-control" id="cost_price" name="cost_price" value="<?= $product['cost_price'] ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-boxes me-2 text-primary"></i>Inventory</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="stock_quantity" class="form-label">Stock Quantity</label>
                            <input type="number" min="0" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= $product['stock_quantity'] ?>">
                        </div>
                        <div class="col-12">
                            <label for="minimum_stock" class="form-label">Minimum Stock</label>
                            <input type="number" min="0" class="form-control" id="minimum_stock" name="minimum_stock" value="<?= $product['minimum_stock'] ?>">
                            <div class="form-text">Low stock warning threshold</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-weight me-2 text-primary"></i>Shipping</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" min="0" class="form-control" id="weight" name="weight" value="<?= $product['weight'] ?>" placeholder="e.g. 1.5">
                        </div>
                        <div class="col-12">
                            <label for="dimensions" class="form-label">Dimensions</label>
                            <input type="text" class="form-control" id="dimensions" name="dimensions" value="<?= sanitize($product['dimensions']) ?>" placeholder="e.g. 10x10x10 cm">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-cog me-2 text-primary"></i>Settings</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1" <?= $product['featured'] ? 'checked' : '' ?>>
                                <label class="form-check-label" for="featured">Featured Product</label>
                            </div>
                            <div class="form-text">Show this product in featured sections.</div>
                        </div>
                        <div class="col-12">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="active" <?= $product['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= $product['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i>Update Product
                </button>
                <a href="<?= $base_url ?>admin/products" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </div>
    </div>
</form>

<?php include __DIR__ . '/_specs_row.php'; ?>

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

document.getElementById('primary_image')?.addEventListener('change', function(e) {
    const preview = document.getElementById('primaryPreview');
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

document.getElementById('additional_images')?.addEventListener('change', function(e) {
    const preview = document.getElementById('additionalPreview');
    preview.innerHTML = '';
    Array.from(e.target.files).forEach(function(file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            const col = document.createElement('div');
            col.className = 'col-4';
            col.innerHTML = '<img src="' + ev.target.result + '" class="img-thumbnail" style="height: 80px; width: 100%; object-fit: cover;">';
            preview.appendChild(col);
        };
        reader.readAsDataURL(file);
    });
});

function removeImage(btn, imageId) {
    const item = btn.closest('.image-item');
    const input = item.querySelector('.delete-image-input');
    input.disabled = false;
    input.value = imageId;
    item.style.opacity = '0.4';
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-undo"></i>';
    btn.onclick = function() { restoreImage(this, imageId); };
}

function restoreImage(btn, imageId) {
    const item = btn.closest('.image-item');
    const input = item.querySelector('.delete-image-input');
    input.disabled = true;
    input.value = '';
    item.style.opacity = '1';
    btn.innerHTML = '<i class="fas fa-times"></i>';
    btn.onclick = function() { removeImage(this, imageId); };
}
</script>
