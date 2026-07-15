<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div class="d-flex align-items-center gap-3">
        <h5 class="mb-0">Order <?= sanitize($order['order_number']) ?></h5>
        <?= get_status_badge($order['order_status']) ?>
        <?= get_status_badge($order['payment_status']) ?>
    </div>
    <div class="d-flex gap-2">
        <a href="<?= $base_url ?>admin/orders/edit/<?= $order['id'] ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-edit me-1"></i>Edit
        </a>
        <a href="<?= $base_url ?>admin/orders/print/<?= $order['id'] ?>" class="btn btn-outline-secondary btn-sm" target="_blank">
            <i class="fas fa-print me-1"></i>Print
        </a>
        <a href="<?= $base_url ?>admin/orders" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Order Info</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width: 100px;">Date</td>
                            <td><?= format_datetime($order['created_at']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment</td>
                            <td><?= sanitize($order['payment_method'] ?: '-') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Subtotal</td>
                            <td><?= format_price($order['subtotal']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Discount</td>
                            <td><?= $order['discount'] > 0 ? '-' . format_price($order['discount']) : '-' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Shipping</td>
                            <td><?= $order['shipping_fee'] > 0 ? format_price($order['shipping_fee']) : 'Free' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tax</td>
                            <td><?= format_price($order['tax']) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-bold">Grand Total</td>
                            <td class="fw-bold"><?= format_price($order['grand_total']) ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php if (!empty($order['notes'])): ?>
                    <hr>
                    <small class="text-muted d-block mb-1">Notes</small>
                    <p class="mb-0 small"><?= nl2br(sanitize($order['notes'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-user me-2 text-primary"></i>Customer Info</h6>
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                        <tr>
                            <td class="text-muted" style="width: 80px;">Name</td>
                            <td class="fw-medium"><?= sanitize($order['customer_name'] ?? 'Guest') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Email</td>
                            <td><a href="mailto:<?= sanitize($order['customer_email']) ?>" class="text-decoration-none"><?= sanitize($order['customer_email'] ?? '-') ?></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0"><i class="fas fa-truck me-2 text-primary"></i>Shipping Address</h6>
            </div>
            <div class="card-body">
                <?php if ($address): ?>
                    <p class="mb-1 fw-medium"><?= sanitize($address['full_name']) ?></p>
                    <p class="mb-1"><?= sanitize($address['address_line_1']) ?></p>
                    <?php if (!empty($address['address_line_2'])): ?>
                        <p class="mb-1"><?= sanitize($address['address_line_2']) ?></p>
                    <?php endif; ?>
                    <p class="mb-1">
                        <?= sanitize($address['city']) ?>,
                        <?= sanitize($address['province']) ?>
                        <?= sanitize($address['postal_code']) ?>
                    </p>
                    <p class="mb-1"><?= sanitize($address['country']) ?></p>
                    <?php if (!empty($address['phone'])): ?>
                        <p class="mb-0"><i class="fas fa-phone me-1 text-muted"></i><?= sanitize($address['phone']) ?></p>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted mb-0">No shipping address on file.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mt-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0"><i class="fas fa-box me-2 text-primary"></i>Order Items</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 60px;">Image</th>
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
                            <td>
                                <?php if (!empty($item['product_image'])): ?>
                                    <img src="<?= $uploads_url . $item['product_image'] ?>"
                                         alt="<?= sanitize($item['product_name']) ?>"
                                         class="rounded"
                                         style="width: 48px; height: 48px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                         style="width: 48px; height: 48px;">
                                        <i class="fas fa-box text-secondary"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
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
                        <td colspan="5" class="text-end fw-medium">Subtotal</td>
                        <td class="text-end"><?= format_price($order['subtotal']) ?></td>
                    </tr>
                    <?php if ($order['discount'] > 0): ?>
                        <tr>
                            <td colspan="5" class="text-end fw-medium text-success">Discount</td>
                            <td class="text-end text-success">-<?= format_price($order['discount']) ?></td>
                        </tr>
                    <?php endif; ?>
                    <tr>
                        <td colspan="5" class="text-end fw-medium">Shipping</td>
                        <td class="text-end"><?= $order['shipping_fee'] > 0 ? format_price($order['shipping_fee']) : 'Free' ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end fw-medium">Tax</td>
                        <td class="text-end"><?= format_price($order['tax']) ?></td>
                    </tr>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Grand Total</td>
                        <td class="text-end fw-bold fs-5"><?= format_price($order['grand_total']) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php if ($payment): ?>
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0"><i class="fas fa-credit-card me-2 text-primary"></i>Payment Info</h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <small class="text-muted d-block">Transaction ID</small>
                    <strong><code><?= sanitize($payment['transaction_id'] ?: '-') ?></code></strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Gateway</small>
                    <strong><?= sanitize($payment['payment_gateway'] ?: '-') ?></strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Amount</small>
                    <strong><?= format_price($payment['amount']) ?></strong>
                </div>
                <div class="col-md-3">
                    <small class="text-muted d-block">Status</small>
                    <strong><?= get_status_badge($payment['status']) ?></strong>
                </div>
            </div>
            <?php if (!empty($payment['paid_at'])): ?>
                <div class="mt-2">
                    <small class="text-muted d-block">Paid At</small>
                    <strong><?= format_datetime($payment['paid_at']) ?></strong>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
