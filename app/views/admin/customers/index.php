<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1">Customers</h5>
        <p class="text-muted small mb-0">Manage your customer accounts</p>
    </div>
    <div>
        <a href="<?= $base_url ?>admin/customers/create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i>Add Customer
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= $base_url ?>admin/customers" class="row g-2">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by name, email or phone..." value="<?= sanitize($search) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php if (!empty($search)): ?>
                <div class="col-auto d-flex align-items-center">
                    <a href="<?= $base_url ?>admin/customers" class="btn btn-outline-secondary btn-sm">
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th class="text-center">Orders</th>
                        <th class="text-center">Status</th>
                        <th>Registered</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($customers)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                <?php if (!empty($search)): ?>
                                    No customers found matching "<strong><?= sanitize($search) ?></strong>"
                                <?php else: ?>
                                    No customers yet. <a href="<?= $base_url ?>admin/customers/create" class="text-decoration-none">Add your first customer</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td>
                                    <a href="<?= $base_url ?>admin/customers/view/<?= $customer['id'] ?>" class="text-decoration-none fw-medium">
                                        <?= sanitize($customer['name']) ?>
                                    </a>
                                </td>
                                <td><?= sanitize($customer['email']) ?></td>
                                <td><?= sanitize($customer['phone'] ?: '-') ?></td>
                                <td class="text-center"><?= (int)$customer['orders_count'] ?></td>
                                <td class="text-center"><?= get_status_badge($customer['status']) ?></td>
                                <td><?= format_date($customer['created_at']) ?></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $base_url ?>admin/customers/view/<?= $customer['id'] ?>"
                                           class="btn btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= $base_url ?>admin/customers/edit/<?= $customer['id'] ?>"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="<?= $customer['id'] ?>"
                                                data-name="<?= sanitize($customer['name']) ?>">
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
                    of <?= $pagination['total'] ?> customers
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
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Customer</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete <strong id="deleteCustomerName"></strong>?</p>
                    <p class="text-muted small mb-0 mt-1">This action cannot be undone. All associated orders, addresses, and reviews will be permanently removed.</p>
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
            document.getElementById('deleteCustomerName').textContent = name;
            document.getElementById('deleteForm').action = '<?= $base_url ?>admin/customers/delete/' + id;
        });
    }
});
</script>
