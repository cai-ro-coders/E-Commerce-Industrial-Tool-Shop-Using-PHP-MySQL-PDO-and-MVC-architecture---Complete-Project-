<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Edit Order</h5>
        <p class="text-muted small mb-0"><?= sanitize($order['order_number']) ?></p>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/orders/view/<?= $order['id'] ?>" class="btn btn-outline-info btn-sm">
            <i class="fas fa-eye me-1"></i>View
        </a>
        <a href="<?= $base_url ?>admin/orders" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back to Orders
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0"><i class="fas fa-receipt me-2 text-primary"></i>Order Summary</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <small class="text-muted d-block">Order Number</small>
                <strong><?= sanitize($order['order_number']) ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Date</small>
                <strong><?= format_datetime($order['created_at']) ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Total</small>
                <strong><?= format_price($order['grand_total']) ?></strong>
            </div>
            <div class="col-md-3">
                <small class="text-muted d-block">Current Status</small>
                <strong><?= get_status_badge($order['order_status']) ?> <?= get_status_badge($order['payment_status']) ?></strong>
            </div>
        </div>
    </div>
</div>

<form action="<?= $base_url ?>admin/orders/edit/<?= $order['id'] ?>" method="POST">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items (Read Only)</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>SKU</th>
                                    <th class="text-end">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td class="fw-medium"><?= sanitize($item['product_name']) ?></td>
                                        <td><code><?= sanitize($item['sku'] ?: '-') ?></code></td>
                                        <td class="text-end"><?= format_price($item['price']) ?></td>
                                        <td class="text-center"><?= (int)$item['quantity'] ?></td>
                                        <td class="text-end"><?= format_price($item['total']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold">Grand Total</td>
                                    <td class="text-end fw-bold"><?= format_price($order['grand_total']) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0"><i class="fas fa-cog me-2 text-primary"></i>Order Settings</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="order_status" class="form-label">Order Status</label>
                        <select class="form-select" id="order_status" name="order_status">
                            <option value="Pending" <?= $order['order_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Processing" <?= $order['order_status'] === 'Processing' ? 'selected' : '' ?>>Processing</option>
                            <option value="Shipped" <?= $order['order_status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
                            <option value="Delivered" <?= $order['order_status'] === 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                            <option value="Cancelled" <?= $order['order_status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            <option value="Returned" <?= $order['order_status'] === 'Returned' ? 'selected' : '' ?>>Returned</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Payment Status</label>
                        <select class="form-select" id="payment_status" name="payment_status">
                            <option value="Pending" <?= $order['payment_status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Paid" <?= $order['payment_status'] === 'Paid' ? 'selected' : '' ?>>Paid</option>
                            <option value="Failed" <?= $order['payment_status'] === 'Failed' ? 'selected' : '' ?>>Failed</option>
                            <option value="Refunded" <?= $order['payment_status'] === 'Refunded' ? 'selected' : '' ?>>Refunded</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4" placeholder="Order notes..."><?= sanitize($order['notes'] ?? '') ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Order
                        </button>
                        <a href="<?= $base_url ?>admin/orders" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
