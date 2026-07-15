<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - <?= sanitize($order['order_number']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #fff;
            color: #212529;
            padding: 40px;
        }
        .receipt-header {
            text-align: center;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .receipt-header h2 {
            margin-bottom: 4px;
            font-weight: 700;
        }
        .receipt-header p {
            margin-bottom: 2px;
            color: #6c757d;
        }
        .receipt-title {
            text-align: center;
            margin-bottom: 24px;
        }
        .receipt-title h4 {
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #6c757d;
        }
        .info-section {
            margin-bottom: 24px;
        }
        .info-section h6 {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }
        table {
            font-size: 0.9rem;
        }
        .table-items thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6c757d;
        }
        .table-totals td {
            border: none;
            padding: 4px 12px;
        }
        .table-totals tr:last-child td {
            font-size: 1.1rem;
            font-weight: 700;
            border-top: 2px solid #212529;
            padding-top: 8px;
        }
        .no-print {
            text-align: center;
            margin-bottom: 24px;
        }
        @media print {
            body { padding: 20px; }
            .no-print { display: none; }
            .page-break { page-break-after: always; }
            .badge { border: 1px solid #dee2e6; color: #212529 !important; background: #f8f9fa !important; }
        }
        .badge {
            font-weight: 500;
            font-size: 0.75rem;
            padding: 4px 10px;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="fas fa-print me-1"></i>Print Receipt
        </button>
        <a href="<?= $base_url ?>admin/orders/view/<?= $order['id'] ?>" class="btn btn-outline-secondary ms-2">
            <i class="fas fa-arrow-left me-1"></i>Back
        </a>
    </div>

    <div class="receipt-header">
        <h2><?= sanitize($settings['store_name'] ?? $app_name) ?></h2>
        <p><?= sanitize($settings['store_address'] ?? '') ?></p>
        <p><?= sanitize($settings['store_email'] ?? '') ?> | <?= sanitize($settings['store_phone'] ?? '') ?></p>
    </div>

    <div class="receipt-title">
        <h4>Payment Receipt</h4>
        <p class="mb-0 fs-5 fw-bold"><?= sanitize($order['order_number']) ?></p>
        <?= get_status_badge($order['order_status']) ?>
        <?= get_status_badge($order['payment_status']) ?>
    </div>

    <div class="row mb-4">
        <div class="col-6">
            <div class="info-section">
                <h6>Order Information</h6>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted ps-0" style="width: 100px;">Date:</td><td class="ps-0"><?= format_datetime($order['created_at']) ?></td></tr>
                    <tr><td class="text-muted ps-0">Payment:</td><td class="ps-0"><?= sanitize($order['payment_method'] ?: '-') ?></td></tr>
                    <tr><td class="text-muted ps-0">Status:</td><td class="ps-0"><?= $order['order_status'] ?> / <?= $order['payment_status'] ?></td></tr>
                </table>
            </div>
        </div>
        <div class="col-6">
            <div class="info-section">
                <h6>Customer</h6>
                <table class="table table-sm table-borderless">
                    <tr><td class="text-muted ps-0" style="width: 100px;">Name:</td><td class="ps-0"><?= sanitize($order['customer_name'] ?? 'Guest') ?></td></tr>
                    <tr><td class="text-muted ps-0">Email:</td><td class="ps-0"><?= sanitize($order['customer_email'] ?? '-') ?></td></tr>
                </table>
            </div>
            <?php if ($address): ?>
                <div class="info-section mt-2">
                    <h6>Shipping Address</h6>
                    <p class="mb-0"><?= sanitize($address['full_name']) ?><br>
                    <?= sanitize($address['address_line_1']) ?><br>
                    <?php if (!empty($address['address_line_2'])): ?><?= sanitize($address['address_line_2']) ?><br><?php endif; ?>
                    <?= sanitize($address['city']) ?>, <?= sanitize($address['province']) ?> <?= sanitize($address['postal_code']) ?><br>
                    <?= sanitize($address['country']) ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <table class="table table-items">
        <thead>
            <tr>
                <th style="width: 50%;">Product</th>
                <th style="width: 15%;">SKU</th>
                <th class="text-end" style="width: 12%;">Price</th>
                <th class="text-center" style="width: 8%;">Qty</th>
                <th class="text-end" style="width: 15%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= sanitize($item['product_name']) ?></td>
                    <td><code><?= sanitize($item['sku'] ?: '-') ?></code></td>
                    <td class="text-end"><?= format_price($item['price']) ?></td>
                    <td class="text-center"><?= (int)$item['quantity'] ?></td>
                    <td class="text-end"><?= format_price($item['total']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="table table-totals ms-auto" style="width: 300px;">
        <tr>
            <td class="text-end text-muted">Subtotal</td>
            <td class="text-end" style="width: 120px;"><?= format_price($order['subtotal']) ?></td>
        </tr>
        <?php if ($order['discount'] > 0): ?>
            <tr>
                <td class="text-end text-success">Discount</td>
                <td class="text-end text-success">-<?= format_price($order['discount']) ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <td class="text-end text-muted">Shipping</td>
            <td class="text-end"><?= $order['shipping_fee'] > 0 ? format_price($order['shipping_fee']) : 'Free' ?></td>
        </tr>
        <tr>
            <td class="text-end text-muted">Tax</td>
            <td class="text-end"><?= format_price($order['tax']) ?></td>
        </tr>
        <tr>
            <td class="text-end">Grand Total</td>
            <td class="text-end"><?= format_price($order['grand_total']) ?></td>
        </tr>
    </table>

    <?php if ($payment): ?>
        <div class="info-section mt-4">
            <h6>Payment Details</h6>
            <table class="table table-sm table-borderless" style="width: auto;">
                <tr><td class="text-muted ps-0" style="width: 120px;">Transaction ID:</td><td class="ps-0"><code><?= sanitize($payment['transaction_id'] ?: '-') ?></code></td></tr>
                <tr><td class="text-muted ps-0">Gateway:</td><td class="ps-0"><?= sanitize($payment['payment_gateway'] ?: '-') ?></td></tr>
                <tr><td class="text-muted ps-0">Amount:</td><td class="ps-0"><?= format_price($payment['amount']) ?></td></tr>
                <tr><td class="text-muted ps-0">Status:</td><td class="ps-0"><?= $payment['status'] ?></td></tr>
                <?php if (!empty($payment['paid_at'])): ?>
                    <tr><td class="text-muted ps-0">Paid At:</td><td class="ps-0"><?= format_datetime($payment['paid_at']) ?></td></tr>
                <?php endif; ?>
            </table>
        </div>
    <?php endif; ?>

    <div class="text-center text-muted mt-5 pt-3 border-top small">
        <p class="mb-0">Thank you for your business!</p>
        <p class="mb-0"><?= sanitize($settings['store_name'] ?? $app_name) ?></p>
    </div>

    <script>
        window.onload = function() {
            var params = new URLSearchParams(window.location.search);
            if (params.get('print') === '1') {
                window.print();
            }
        };
    </script>
</body>
</html>
