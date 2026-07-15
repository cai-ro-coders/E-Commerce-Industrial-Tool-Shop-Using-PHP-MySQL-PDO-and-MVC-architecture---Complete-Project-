<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Order details.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/account.css" rel="stylesheet">
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<!-- Hero Breadcrumb -->
<section class="account-hero">
    <div class="account-hero-bg"></div>
    <div class="account-hero-overlay"></div>
    <div class="account-hero-content">
        <h1 class="account-hero-title">Order #<?= htmlspecialchars($order['order_number']) ?></h1>
        <nav class="account-breadcrumb">
            <a href="<?= $base_url ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <a href="<?= $base_url ?>customer/my-account">My Account</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">Order #<?= htmlspecialchars($order['order_number']) ?></span>
        </nav>
    </div>
</section>

<section class="account-layout">
    <div class="container">
        <div style="max-width:800px;margin:0 auto">

            <a href="<?= $base_url ?>customer/my-account" class="order-back-link">&larr; Back to My Account</a>

            <!-- Order Header -->
            <div class="account-card" style="margin-bottom:20px">
                <div class="order-detail-header">
                    <div>
                        <div class="order-detail-number">Order #<?= htmlspecialchars($order['order_number']) ?></div>
                        <div class="order-detail-date">Placed on <?= date('F d, Y \a\t g:i A', strtotime($order['created_at'])) ?></div>
                    </div>
                    <span class="order-status status-<?= strtolower($order['order_status']) ?>"><?= htmlspecialchars($order['order_status']) ?></span>
                </div>
                <div class="order-detail-summary">
                    <div class="summary-item">
                        <span class="summary-label">Payment</span>
                        <span class="summary-value"><?= htmlspecialchars(ucfirst(str_replace('_', ' ', $order['payment_method']))) ?></span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Payment Status</span>
                        <span class="summary-value"><?= htmlspecialchars(ucfirst($order['payment_status'])) ?></span>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="account-card" style="margin-bottom:20px">
                <h3 class="order-section-title">Items</h3>
                <div class="order-items-list">
                    <?php foreach ($items as $item): ?>
                    <div class="order-item-row">
                        <div class="order-item-img">
                            <?php if ($item['primary_image']): ?>
                                <img src="<?= $uploads_url . htmlspecialchars($item['primary_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <?php else: ?>
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:20px"><i class="fas fa-box"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="order-item-info">
                            <a href="<?= $base_url ?>products/<?= htmlspecialchars($item['slug']) ?>" class="order-item-name"><?= htmlspecialchars($item['name']) ?></a>
                            <div class="order-item-meta">
                                <span>$<?= number_format($item['price'], 2) ?> x <?= (int)$item['quantity'] ?></span>
                            </div>
                        </div>
                        <div class="order-item-total">$<?= number_format($item['total'], 2) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Totals + Address -->
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">
                <div class="account-card">
                    <h3 class="order-section-title">Order Total</h3>
                    <div class="totals-list">
                        <div class="total-row"><span>Subtotal</span><span>$<?= number_format($order['subtotal'], 2) ?></span></div>
                        <?php if ($order['discount'] > 0): ?>
                        <div class="total-row"><span>Discount</span><span>-$<?= number_format($order['discount'], 2) ?></span></div>
                        <?php endif; ?>
                        <div class="total-row"><span>Shipping</span><span><?= $order['shipping_fee'] > 0 ? '$' . number_format($order['shipping_fee'], 2) : 'Free' ?></span></div>
                        <?php if ($order['tax'] > 0): ?>
                        <div class="total-row"><span>Tax</span><span>$<?= number_format($order['tax'], 2) ?></span></div>
                        <?php endif; ?>
                        <div class="total-row total-grand"><span>Grand Total</span><span>$<?= number_format($order['grand_total'], 2) ?></span></div>
                    </div>
                </div>
                <?php if ($address): ?>
                <div class="account-card">
                    <h3 class="order-section-title">Shipping Address</h3>
                    <div class="address-detail" style="font-weight:600;color:var(--color-dark)"><?= htmlspecialchars($address['full_name']) ?></div>
                    <div class="address-detail"><?= htmlspecialchars($address['address_line_1']) ?></div>
                    <?php if ($address['address_line_2']): ?><div class="address-detail"><?= htmlspecialchars($address['address_line_2']) ?></div><?php endif; ?>
                    <div class="address-detail"><?= htmlspecialchars($address['city']) ?>, <?= htmlspecialchars($address['province']) ?> <?= htmlspecialchars($address['postal_code']) ?></div>
                    <div class="address-detail"><?= htmlspecialchars($address['country']) ?></div>
                    <div class="address-detail"><?= htmlspecialchars($address['phone']) ?></div>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($order['notes']): ?>
            <div class="account-card" style="margin-top:20px">
                <h3 class="order-section-title">Order Notes</h3>
                <p style="color:#666;font-size:14px;line-height:1.6;margin:0"><?= nl2br(htmlspecialchars($order['notes'])) ?></p>
            </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<style>
.order-back-link {
    display:inline-block;
    color:var(--color-teal);
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    margin-bottom:20px;
    transition:color .2s
}
.order-back-link:hover { color:#006978 }
.order-detail-header {
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:16px
}
.order-detail-number {
    font-size:20px;
    font-weight:700;
    color:var(--color-dark);
    margin-bottom:4px
}
.order-detail-date {
    font-size:13px;
    color:#999
}
.order-detail-summary {
    display:flex;
    gap:32px;
    padding-top:16px;
    border-top:1px solid #f0f0f0
}
.summary-item {}
.summary-label {
    display:block;
    font-size:12px;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:.5px;
    color:#bbb;
    margin-bottom:2px
}
.summary-value {
    font-size:14px;
    font-weight:600;
    color:var(--color-dark)
}
.order-section-title {
    font-family:var(--font-heading);
    font-size:18px;
    font-weight:700;
    color:var(--color-dark);
    margin:0 0 16px
}
.order-items-list {
    display:flex;
    flex-direction:column;
    gap:12px
}
.order-item-row {
    display:flex;
    align-items:center;
    gap:16px
}
.order-item-img {
    width:60px;
    height:60px;
    border-radius:10px;
    overflow:hidden;
    flex-shrink:0;
    background:#f0f0f0
}
.order-item-img img { width:100%;height:100%;object-fit:cover }
.order-item-info { flex:1;min-width:0 }
.order-item-name {
    display:block;
    font-size:14px;
    font-weight:600;
    color:var(--color-dark);
    text-decoration:none;
    margin-bottom:2px
}
.order-item-name:hover { color:var(--color-teal) }
.order-item-meta { font-size:13px;color:#999 }
.order-item-total {
    font-size:16px;
    font-weight:700;
    color:var(--color-dark);
    white-space:nowrap
}
.totals-list { display:flex;flex-direction:column;gap:8px }
.total-row {
    display:flex;
    justify-content:space-between;
    font-size:14px;
    color:#666
}
.total-grand {
    font-size:16px;
    font-weight:700;
    color:var(--color-dark);
    padding-top:8px;
    border-top:1px solid #f0f0f0
}
@media (max-width:600px) {
    .order-detail-header { flex-direction:column;gap:12px }
    .order-detail-summary { flex-direction:column;gap:12px }
    div[style*="grid-template-columns:1fr 1fr"] { grid-template-columns:1fr !important }
}
</style>
</body>
</html>
