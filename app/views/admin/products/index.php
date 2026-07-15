<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1">Products</h5>
        <p class="text-muted small mb-0">Manage your product catalog</p>
    </div>
    <div class="d-flex gap-2">
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="fas fa-download me-1"></i>Export
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= $base_url ?>admin/products/export/csv"><i class="fas fa-file-csv me-2 text-success"></i>Export CSV</a></li>
                <li><a class="dropdown-item" href="<?= $base_url ?>admin/products/export/json"><i class="fas fa-file-code me-2 text-primary"></i>Export JSON</a></li>
            </ul>
        </div>
        <a href="<?= $base_url ?>admin/products/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Product
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= $base_url ?>admin/products" class="row g-2">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by name or SKU..." value="<?= sanitize($search) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php if (!empty($search)): ?>
                <div class="col-auto d-flex align-items-center">
                    <a href="<?= $base_url ?>admin/products" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">Image</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th class="text-end">Price</th>
                        <th class="text-end">Sale Price</th>
                        <th class="text-center">Stock</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3 d-block"></i>
                                <?php if (!empty($search)): ?>
                                    No products found matching "<strong><?= sanitize($search) ?></strong>"
                                <?php else: ?>
                                    No products yet. <a href="<?= $base_url ?>admin/products/create" class="text-decoration-none">Add your first product</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($product['primary_image'])): ?>
                                        <img src="<?= $uploads_url . $product['primary_image'] ?>"
                                             alt="<?= $product['name'] ?>"
                                             class="rounded"
                                             style="width: 48px; height: 48px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                             style="width: 48px; height: 48px;">
                                            <i class="fas fa-box text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= $base_url ?>admin/products/view/<?= $product['id'] ?>" class="text-decoration-none fw-medium">
                                        <?= sanitize($product['name']) ?>
                                    </a>
                                    <br>
                                    <small class="text-muted"><?= sanitize($product['brand_name'] ?? '') ?></small>
                                </td>
                                <td><code><?= sanitize($product['sku'] ?: '-') ?></code></td>
                                <td><?= sanitize($product['category_name'] ?? '-') ?></td>
                                <td class="text-end"><?= $product['sale_price'] ? '<s class="text-muted small">' . format_price($product['price']) . '</s>' : format_price($product['price']) ?></td>
                                <td class="text-end"><?= $product['sale_price'] ? format_price($product['sale_price']) : '-' ?></td>
                                <td class="text-center">
                                    <?php if ($product['stock_quantity'] <= 0): ?>
                                        <span class="badge bg-danger">Out of Stock</span>
                                    <?php elseif ($product['stock_quantity'] <= $product['minimum_stock']): ?>
                                        <span class="badge bg-warning text-dark"><?= $product['stock_quantity'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $product['stock_quantity'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= get_status_badge($product['status']) ?></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $base_url ?>admin/products/view/<?= $product['id'] ?>"
                                           class="btn btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= $base_url ?>admin/products/edit/<?= $product['id'] ?>"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="<?= $product['id'] ?>"
                                                data-name="<?= sanitize($product['name']) ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if ($pagination['total_pages'] > 1): ?>
        <div class="card-footer bg-white border-top-0">
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    Showing <?= (($pagination['page'] - 1) * $pagination['per_page']) + 1 ?>
                    - <?= min($pagination['page'] * $pagination['per_page'], $pagination['total']) ?>
                    of <?= $pagination['total'] ?> products
                </small>
                <?= pagination_links($pagination) ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Product</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete <strong id="deleteProductName"></strong>?</p>
                    <p class="text-muted small mb-0 mt-1">This action cannot be undone. All associated images will be permanently removed.</p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.dataset.id;
            const name = button.dataset.name;
            document.getElementById('deleteProductName').textContent = name;
            document.getElementById('deleteForm').action = '<?= $base_url ?>admin/products/delete/' + id;
        });
    }
});
</script>
