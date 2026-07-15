<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1"><?= sanitize($product['name']) ?></h5>
        <p class="text-muted small mb-0">Product details and information</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/products/edit/<?= $product['id'] ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>Edit Product
        </a>
        <a href="<?= $base_url ?>admin/products" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Products
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                <?php
                $primaryImage = null;
                foreach ($images as $img) {
                    if ($img['is_primary']) {
                        $primaryImage = $img;
                        break;
                    }
                }
                if (!$primaryImage && !empty($images)) {
                    $primaryImage = $images[0];
                }
                ?>
                <?php if ($primaryImage): ?>
                    <img src="<?= $uploads_url . $primaryImage['image'] ?>"
                         alt="<?= sanitize($product['name']) ?>"
                         class="w-100 rounded-top"
                         style="max-height: 400px; object-fit: contain; background: #f8f9fa;">
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center rounded-top bg-light"
                         style="height: 300px;">
                        <div class="text-center text-muted">
                            <i class="fas fa-box fa-4x mb-2"></i>
                            <p class="mb-0 small">No Image Available</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if (count($images) > 1): ?>
                <div class="card-footer bg-white">
                    <div class="row g-2">
                        <?php foreach ($images as $img): ?>
                            <?php if (!$primaryImage || $img['id'] !== $primaryImage['id']): ?>
                                <div class="col-3">
                                    <img src="<?= $uploads_url . $img['image'] ?>"
                                         alt="Product image"
                                         class="img-thumbnail cursor-pointer"
                                         style="height: 70px; width: 100%; object-fit: cover; cursor: pointer;"
                                         onclick="this.closest('.row').querySelector('.main-image').src = this.src.replace('/thumbs/', '/');">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Quick Info</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width: 120px;">SKU</td>
                            <td><code><?= sanitize($product['sku'] ?: '-') ?></code></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Category</td>
                            <td><?= sanitize($product['category_name'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Brand</td>
                            <td><?= sanitize($product['brand_name'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td><?= get_status_badge($product['status']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Featured</td>
                            <td>
                                <?php if ($product['featured']): ?>
                                    <span class="badge bg-success">Yes</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">No</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Slug</td>
                            <td><code><?= sanitize($product['slug']) ?></code></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-dollar-sign me-2 text-primary"></i>Pricing & Inventory</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Regular Price</small>
                            <strong class="fs-5"><?= format_price($product['price']) ?></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Sale Price</small>
                            <strong class="fs-5"><?= $product['sale_price'] ? format_price($product['sale_price']) : '-' ?></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Cost Price</small>
                            <strong class="fs-5"><?= $product['cost_price'] ? format_price($product['cost_price']) : '-' ?></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Stock Quantity</small>
                            <strong class="fs-5">
                                <?php if ($product['stock_quantity'] <= 0): ?>
                                    <span class="text-danger"><?= $product['stock_quantity'] ?></span>
                                <?php elseif ($product['stock_quantity'] <= $product['minimum_stock']): ?>
                                    <span class="text-warning"><?= $product['stock_quantity'] ?></span>
                                <?php else: ?>
                                    <span class="text-success"><?= $product['stock_quantity'] ?></span>
                                <?php endif; ?>
                            </strong>
                            <small class="text-muted d-block">Min: <?= $product['minimum_stock'] ?></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Weight</small>
                            <strong class="fs-5"><?= $product['weight'] ? $product['weight'] . ' kg' : '-' ?></strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded bg-light">
                            <small class="text-muted d-block">Dimensions</small>
                            <strong class="fs-5"><?= sanitize($product['dimensions'] ?: '-') ?></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($product['short_description'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-align-left me-2 text-primary"></i>Short Description</h6>
                </div>
                <div class="card-body">
                    <p class="mb-0"><?= nl2br(sanitize($product['short_description'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($product['description'])): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-file-alt me-2 text-primary"></i>Full Description</h6>
                </div>
                <div class="card-body">
                    <div class="product-description"><?= $product['description'] ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($specs)): ?>
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-list me-2 text-primary"></i>Specifications</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 40%;">Attribute</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($specs as $spec): ?>
                                    <tr>
                                        <td class="fw-medium"><?= sanitize($spec['attribute_name']) ?></td>
                                        <td><?= sanitize($spec['attribute_value']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Timestamps</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <small class="text-muted d-block">Created At</small>
                        <strong><?= format_datetime($product['created_at']) ?></strong>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted d-block">Updated At</small>
                        <strong><?= format_datetime($product['updated_at']) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
