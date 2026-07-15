<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1">Orders</h5>
        <p class="text-muted small mb-0">Manage customer orders</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/orders/export-csv" class="btn btn-outline-success btn-sm">
            <i class="fas fa-file-csv me-1"></i>Export CSV
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="<?= $base_url ?>admin/orders" class="row g-2">
            <div class="col-md-6 col-lg-4">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search by order number or customer name..." value="<?= sanitize($search) ?>">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <?php if (!empty($search)): ?>
                <div class="col-auto d-flex align-items-center">
                    <a href="<?= $base_url ?>admin/orders" class="btn btn-outline-secondary btn-sm">
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
                        <th>Order#</th>
                        <th>Customer</th>
                        <th class="text-center">Items</th>
                        <th class="text-end">Total</th>
                        <th class="text-center">Payment</th>
                        <th class="text-center">Status</th>
                        <th>Date</th>
                        <th class="text-end" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                <?php if (!empty($search)): ?>
                                    No orders found matching "<strong><?= sanitize($search) ?></strong>"
                                <?php else: ?>
                                    No orders yet.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>
                                    <a href="<?= $base_url ?>admin/orders/view/<?= $order['id'] ?>" class="text-decoration-none fw-medium">
                                        <?= sanitize($order['order_number']) ?>
                                    </a>
                                </td>
                                <td><?= sanitize($order['customer_name'] ?? 'Guest') ?></td>
                                <td class="text-center"><?= (int)$order['items_count'] ?></td>
                                <td class="text-end"><?= format_price($order['grand_total']) ?></td>
                                <td class="text-center"><?= get_status_badge($order['payment_status']) ?></td>
                                <td class="text-center"><?= get_status_badge($order['order_status']) ?></td>
                                <td><?= format_date($order['created_at']) ?></td>
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= $base_url ?>admin/orders/view/<?= $order['id'] ?>"
                                           class="btn btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= $base_url ?>admin/orders/edit/<?= $order['id'] ?>"
                                           class="btn btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Delete"
                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                data-id="<?= $order['id'] ?>"
                                                data-order="<?= sanitize($order['order_number']) ?>">
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
                    of <?= $pagination['total'] ?> orders
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
                <h6 class="modal-title"><i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Order</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="deleteForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <p class="mb-0">Are you sure you want to delete order <strong id="deleteOrderNumber"></strong>?</p>
                    <p class="text-muted small mb-0 mt-1">This action cannot be undone. All order items and associated data will be permanently removed.</p>
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
            const order = button.dataset.order;
            document.getElementById('deleteOrderNumber').textContent = order;
            document.getElementById('deleteForm').action = '<?= $base_url ?>admin/orders/delete/' + id;
        });
    }
});
</script>
