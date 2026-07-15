<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h5 class="mb-1"><?= sanitize($customer['name']) ?></h5>
        <p class="text-muted small mb-0">Customer details and order history</p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/customers/edit/<?= $customer['id'] ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>Edit Customer
        </a>
        <a href="<?= $base_url ?>admin/customers" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Customers
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Customer Info</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width: 100px;">Name</td>
                            <td class="fw-medium"><?= sanitize($customer['name']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><a href="mailto:<?= sanitize($customer['email']) ?>" class="text-decoration-none"><?= sanitize($customer['email']) ?></a></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Phone</td>
                            <td><?= sanitize($customer['phone'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td><?= get_status_badge($customer['status']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Registered</td>
                            <td><?= format_datetime($customer['created_at']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Last Updated</td>
                            <td><?= format_datetime($customer['updated_at']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-shopping-cart me-2 text-primary"></i>Order History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order#</th>
                                <th>Date</th>
                                <th class="text-center">Items</th>
                                <th class="text-end">Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-end" style="width: 80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fas fa-shopping-cart fa-3x mb-3 d-block"></i>
                                        This customer has not placed any orders yet.
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
                                        <td><?= format_date($order['created_at']) ?></td>
                                        <td class="text-center"><?= (int)$order['items_count'] ?></td>
                                        <td class="text-end"><?= format_price($order['grand_total']) ?></td>
                                        <td class="text-center"><?= get_status_badge($order['order_status']) ?></td>
                                        <td class="text-end">
                                            <a href="<?= $base_url ?>admin/orders/view/<?= $order['id'] ?>" class="btn btn-sm btn-outline-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
