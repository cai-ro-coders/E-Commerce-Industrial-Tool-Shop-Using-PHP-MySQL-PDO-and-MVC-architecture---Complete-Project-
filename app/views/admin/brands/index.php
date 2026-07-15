<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1">Brands</h5>
        <p class="text-muted small mb-0">Manage your product brands</p>
    </div>
    <div>
        <a href="<?= $base_url ?>admin/brands/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Brand
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= $base_url ?>admin/brands" class="row g-2">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by name or description..." value="<?= sanitize($search) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php if (!empty($search)): ?>
                <div class="col-auto d-flex align-items-center">
                    <a href="<?= $base_url ?>admin/brands" class="btn btn-outline-secondary btn-sm">
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
                        <th style="width: 60px;">Logo</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th class="text-center">Products</th>
                        <th class="text-center">Status</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($brands)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-trademark fa-3x mb-3 d-block"></i>
                                <?php if (!empty($search)): ?>
                                    No brands found matching "<strong><?= sanitize($search) ?></strong>"
                                <?php else: ?>
                                    No brands yet. <a href="<?= $base_url ?>admin/brands/create" class="text-decoration-none">Add your first brand</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($brands as $brand): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($brand['logo'])): ?>
                                        <img src="<?= $uploads_url . $brand['logo'] ?>"
                                             alt="<?= sanitize($brand['name']) ?>"
                                             class="rounded"
                                             style="width: 48px; height: 48px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                             style="width: 48px; height: 48px;">
                                            <i class="fas fa-trademark text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="fw-medium"><?= sanitize($brand['name']) ?></span>
                                </td>
                                <td><code><?= sanitize($brand['slug']) ?></code></td>
                                <td class="text-center"><?= (int)$brand['products_count'] ?></td>
                                <td class="text-center"><?= get_status_badge($brand['status']) ?></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $base_url ?>admin/brands/edit/<?= $brand['id'] ?>"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="<?= $brand['id'] ?>"
                                                data-name="<?= sanitize($brand['name']) ?>">
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
                    of <?= $pagination['total'] ?> brands
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
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Brand</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete <strong id="deleteBrandName"></strong>?</p>
                    <p class="text-muted small mb-0 mt-1">This action cannot be undone.</p>
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
            document.getElementById('deleteBrandName').textContent = name;
            document.getElementById('deleteForm').action = '<?= $base_url ?>admin/brands/delete/' + id;
        });
    }
});
</script>
