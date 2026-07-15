<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Manage your ToolShop account.">
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
        <h1 class="account-hero-title">My Account</h1>
        <nav class="account-breadcrumb">
            <a href="<?= $base_url ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <span class="breadcrumb-current">My Account</span>
        </nav>
    </div>
</section>

<!-- Account Layout -->
<section class="account-layout">
    <div class="container">
        <div class="account-grid">

            <!-- Sidebar -->
            <aside class="account-sidebar" id="accountSidebar">
                <div class="account-user-card">
                    <div class="account-avatar"><?= strtoupper(substr($user['name'], 0, 1)) ?></div>
                    <div class="account-user-info">
                        <div class="account-user-name"><?= htmlspecialchars($user['name']) ?></div>
                        <div class="account-user-email"><?= htmlspecialchars($user['email']) ?></div>
                    </div>
                </div>
                <nav class="account-nav">
                    <button class="account-nav-btn active" data-section="details"><i class="fas fa-user"></i> My Details</button>
                    <button class="account-nav-btn" data-section="orders"><i class="fas fa-box"></i> My Orders <span class="nav-badge"><?= $order_count ?></span></button>
                    <button class="account-nav-btn" data-section="wishlist"><i class="far fa-heart"></i> Wishlist <span class="nav-badge"><?= $wishlist_count ?></span></button>
                    <button class="account-nav-btn" data-section="cart"><i class="fas fa-shopping-bag"></i> My Cart <span class="nav-badge"><?= $cart_count ?></span></button>
                    <button class="account-nav-btn" data-section="addresses"><i class="fas fa-map-marker-alt"></i> Billing Address</button>
                    <button class="account-nav-btn" data-section="notifications"><i class="fas fa-bell"></i> Notifications<?php if ($unread_count > 0): ?><span class="nav-badge"><?= $unread_count ?></span><?php endif; ?></button>
                    <a href="<?= $base_url ?>logout" class="account-nav-btn logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </nav>
            </aside>

            <!-- Content -->
            <div class="account-content">

                <!-- My Details -->
                <div class="account-section active" id="section-details">
                    <h2 class="account-section-title">My Details</h2>
                    <div class="account-card">
                        <div class="detail-grid">
                            <div class="detail-item">
                                <span class="detail-label">Full Name</span>
                                <span class="detail-value"><?= htmlspecialchars($user['name']) ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Email Address</span>
                                <span class="detail-value"><?= htmlspecialchars($user['email']) ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Phone</span>
                                <span class="detail-value"><?= htmlspecialchars($user['phone'] ?? 'Not set') ?></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Member Since</span>
                                <span class="detail-value"><?= date('F d, Y', strtotime($user['created_at'])) ?></span>
                            </div>
                        </div>
                        <button class="account-edit-btn" onclick="document.getElementById('editModal').classList.add('open')">Edit Details</button>
                    </div>
                </div>

                <!-- Orders -->
                <div class="account-section" id="section-orders">
                    <h2 class="account-section-title">My Orders</h2>
                    <?php if (!empty($orders)): ?>
                        <div class="orders-list">
                            <?php foreach ($orders as $order): ?>
                            <div class="order-card">
                                <div class="order-header">
                                    <div>
                                        <span class="order-number"><?= htmlspecialchars($order['order_number']) ?></span>
                                        <span class="order-date"><?= date('M d, Y', strtotime($order['created_at'])) ?></span>
                                    </div>
                                    <span class="order-status status-<?= strtolower($order['order_status']) ?>"><?= htmlspecialchars($order['order_status']) ?></span>
                                </div>
                                <div class="order-body">
                                    <span class="order-total">$<?= number_format($order['grand_total'], 2) ?></span>
                                    <a href="<?= $base_url ?>customer/order/<?= htmlspecialchars($order['order_number']) ?>" class="order-view-btn">View Details</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="account-empty">
                            <i class="fas fa-box-open"></i>
                            <p>No orders yet</p>
                            <a href="<?= $base_url ?>collections/all" class="btn-primary-account">Start Shopping</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Wishlist -->
                <div class="account-section" id="section-wishlist">
                    <h2 class="account-section-title">Wishlist</h2>
                    <?php if (!empty($wishlist_items)): ?>
                        <div class="wishlist-grid">
                            <?php foreach ($wishlist_items as $item): ?>
                            <div class="wishlist-card">
                                <div class="wishlist-img">
                                    <?php if ($item['primary_image']): ?>
                                        <img src="<?= $uploads_url . htmlspecialchars($item['primary_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <?php else: ?>
                                        <div class="wishlist-placeholder"><i class="fas fa-box"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="wishlist-info">
                                    <a href="<?= $base_url ?>products/<?= htmlspecialchars($item['slug']) ?>" class="wishlist-name"><?= htmlspecialchars($item['name']) ?></a>
                                    <div class="wishlist-price">
                                        <?php if ($item['sale_price'] && $item['sale_price'] < $item['price']): ?>
                                            <span class="price-current">$<?= number_format($item['sale_price'], 2) ?></span>
                                            <span class="price-old">$<?= number_format($item['price'], 2) ?></span>
                                        <?php else: ?>
                                            <span class="price-current">$<?= number_format($item['price'], 2) ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button class="wishlist-remove" data-product-id="<?= $item['product_id'] ?>" title="Remove"><i class="fas fa-times"></i></button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="account-empty">
                            <i class="far fa-heart"></i>
                            <p>Your wishlist is empty</p>
                            <a href="<?= $base_url ?>collections/all" class="btn-primary-account">Browse Products</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Cart -->
                <div class="account-section" id="section-cart">
                    <h2 class="account-section-title">My Cart</h2>
                    <?php if (!empty($cart_items)): 
                        $subtotal = 0;
                        foreach ($cart_items as $item) {
                            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
                            $subtotal += $price * (int)$item['quantity'];
                        }
                    ?>
                        <div class="cart-list">
                            <?php foreach ($cart_items as $item): 
                                $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
                            ?>
                            <div class="cart-row">
                                <div class="cart-row-img">
                                    <?php if ($item['primary_image']): ?>
                                        <img src="<?= $uploads_url . htmlspecialchars($item['primary_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <?php else: ?>
                                        <div class="cart-placeholder"><i class="fas fa-box"></i></div>
                                    <?php endif; ?>
                                </div>
                                <div class="cart-row-info">
                                    <a href="<?= $base_url ?>products/<?= htmlspecialchars($item['slug']) ?>" class="cart-row-name"><?= htmlspecialchars($item['name']) ?></a>
                                    <div class="cart-row-price">
                                        <span class="price-current">$<?= number_format($price, 2) ?></span>
                                    </div>
                                </div>
                                <div class="cart-row-qty">Qty: <?= (int)$item['quantity'] ?></div>
                                <div class="cart-row-total">$<?= number_format($price * (int)$item['quantity'], 2) ?></div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="cart-summary">
                            <div class="cart-summary-row">
                                <span>Subtotal</span>
                                <strong>$<?= number_format($subtotal, 2) ?></strong>
                            </div>
                            <a href="<?= $base_url ?>checkout" class="cart-checkout-btn">Proceed to Checkout &rarr;</a>
                        </div>
                    <?php else: ?>
                        <div class="account-empty">
                            <i class="fas fa-shopping-bag"></i>
                            <p>Your cart is empty</p>
                            <a href="<?= $base_url ?>collections/all" class="btn-primary-account">Shop Now</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Addresses -->
                <div class="account-section" id="section-addresses">
                    <h2 class="account-section-title">Billing Address</h2>
                    <?php if (!empty($addresses)): ?>
                        <div class="addresses-grid">
                            <?php foreach ($addresses as $addr): ?>
                            <div class="address-card <?= $addr['is_default'] ? 'default' : '' ?>">
                                <?php if ($addr['is_default']): ?><span class="address-badge">Default</span><?php endif; ?>
                                <div class="address-name"><?= htmlspecialchars($addr['full_name']) ?></div>
                                <div class="address-detail"><?= htmlspecialchars($addr['address_line_1']) ?></div>
                                <?php if ($addr['address_line_2']): ?><div class="address-detail"><?= htmlspecialchars($addr['address_line_2']) ?></div><?php endif; ?>
                                <div class="address-detail"><?= htmlspecialchars($addr['city']) ?>, <?= htmlspecialchars($addr['province']) ?> <?= htmlspecialchars($addr['postal_code']) ?></div>
                                <div class="address-detail"><?= htmlspecialchars($addr['country']) ?></div>
                                <div class="address-detail"><?= htmlspecialchars($addr['phone']) ?></div>
                                <div class="address-actions">
                                    <button class="address-edit-btn" onclick="openAddressModal(<?= htmlspecialchars(json_encode($addr)) ?>)">Edit</button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="account-empty">
                            <i class="fas fa-map-marker-alt"></i>
                            <p>No addresses saved</p>
                            <button class="btn-primary-account" onclick="openAddressModal()">Add Address</button>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Notifications -->
                <div class="account-section" id="section-notifications">
                    <h2 class="account-section-title">Notifications</h2>
                    <div class="account-card">
                        <?php if (!empty($notifications)): ?>
                            <div class="notifications-list">
                                <?php foreach ($notifications as $notif): ?>
                                    <div class="notification-item <?= $notif['is_read'] ? '' : 'unread' ?>" data-id="<?= $notif['id'] ?>">
                                        <div class="notification-icon">
                                            <?php if ($notif['order_status'] === 'Shipped'): ?>
                                                <i class="fas fa-truck"></i>
                                            <?php elseif ($notif['order_status'] === 'Delivered'): ?>
                                                <i class="fas fa-check-circle"></i>
                                            <?php elseif ($notif['order_status'] === 'Cancelled' || $notif['order_status'] === 'Returned'): ?>
                                                <i class="fas fa-exclamation-circle"></i>
                                            <?php elseif ($notif['order_status'] === 'Processing'): ?>
                                                <i class="fas fa-cog"></i>
                                            <?php else: ?>
                                                <i class="fas fa-bell"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-title"><?= htmlspecialchars($notif['title']) ?></div>
                                            <div class="notification-message"><?= htmlspecialchars($notif['message']) ?></div>
                                            <div class="notification-time"><?= date('M j, Y g:i A', strtotime($notif['created_at'])) ?></div>
                                        </div>
                                        <?php if (!empty($notif['order_number'])): ?>
                                            <a href="<?= $base_url ?>customer/order/<?= htmlspecialchars($notif['order_number']) ?>" class="notification-link">View Order</a>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="account-muted">No notifications yet. We'll notify you about order updates, promotions, and more.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<!-- Edit Details Modal -->
<div class="modal-overlay" id="editModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3>Edit Details</h3>
            <button class="modal-close" onclick="document.getElementById('editModal').classList.remove('open')">&times;</button>
        </div>
        <form method="POST" action="<?= $base_url ?>customer/my-account/edit">
            <?= csrf_field() ?>
            <div class="modal-body">
                <div class="auth-field">
                    <label for="edit_name">Full Name</label>
                    <input type="text" id="edit_name" name="name" class="auth-input" style="padding-left:14px" value="<?= htmlspecialchars($user['name']) ?>" required>
                </div>
                <div class="auth-field">
                    <label for="edit_email">Email Address</label>
                    <input type="email" id="edit_email" name="email" class="auth-input" style="padding-left:14px" value="<?= htmlspecialchars($user['email']) ?>" required>
                </div>
                <div class="auth-field">
                    <label for="edit_phone">Phone</label>
                    <input type="text" id="edit_phone" name="phone" class="auth-input" style="padding-left:14px" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-cancel" onclick="document.getElementById('editModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="modal-btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<!-- Address Modal -->
<div class="modal-overlay" id="addressModal" onclick="if(event.target===this)this.classList.remove('open')">
    <div class="modal-dialog">
        <div class="modal-header">
            <h3 id="addressModalTitle">Add Address</h3>
            <button class="modal-close" onclick="document.getElementById('addressModal').classList.remove('open')">&times;</button>
        </div>
        <form method="POST" action="<?= $base_url ?>customer/address/save">
            <?= csrf_field() ?>
            <input type="hidden" id="addr_id" name="id">
            <div class="modal-body">
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="addr_full_name">Full Name</label>
                        <input type="text" id="addr_full_name" name="full_name" class="auth-input" style="padding-left:14px" required>
                    </div>
                    <div class="auth-field">
                        <label for="addr_phone">Phone</label>
                        <input type="text" id="addr_phone" name="phone" class="auth-input" style="padding-left:14px" required>
                    </div>
                </div>
                <div class="auth-field">
                    <label for="addr_line1">Address Line 1</label>
                    <input type="text" id="addr_line1" name="address_line_1" class="auth-input" style="padding-left:14px" required>
                </div>
                <div class="auth-field">
                    <label for="addr_line2">Address Line 2 <span class="optional">(optional)</span></label>
                    <input type="text" id="addr_line2" name="address_line_2" class="auth-input" style="padding-left:14px">
                </div>
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="addr_city">City</label>
                        <input type="text" id="addr_city" name="city" class="auth-input" style="padding-left:14px" required>
                    </div>
                    <div class="auth-field">
                        <label for="addr_province">Province</label>
                        <input type="text" id="addr_province" name="province" class="auth-input" style="padding-left:14px" required>
                    </div>
                </div>
                <div class="auth-row">
                    <div class="auth-field">
                        <label for="addr_postal">Postal Code</label>
                        <input type="text" id="addr_postal" name="postal_code" class="auth-input" style="padding-left:14px" required>
                    </div>
                    <div class="auth-field">
                        <label for="addr_country">Country</label>
                        <input type="text" id="addr_country" name="country" class="auth-input" style="padding-left:14px" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="modal-btn-cancel" onclick="document.getElementById('addressModal').classList.remove('open')">Cancel</button>
                <button type="submit" class="modal-btn-save">Save Address</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var navBtns = document.querySelectorAll('.account-nav-btn');
    var sections = document.querySelectorAll('.account-section');
    navBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (btn.classList.contains('logout')) return;
            navBtns.forEach(function(b) { b.classList.remove('active'); });
            sections.forEach(function(s) { s.classList.remove('active'); });
            btn.classList.add('active');
            document.getElementById('section-' + btn.dataset.section).classList.add('active');
            if (btn.dataset.section === 'notifications') {
                var badge = btn.querySelector('.nav-badge');
                if (badge) {
                    fetch('<?= $base_url ?>customer/notifications/read', { method: 'POST', headers: {'Content-Type': 'application/x-www-form-urlencoded'}, body: '_csrf_token=<?= htmlspecialchars(csrf_token()) ?>' });
                    badge.remove();
                }
            }
        });
    });
    var addrModal = document.getElementById('addressModal');
    window.openAddressModal = function(addr) {
        document.getElementById('addressModalTitle').textContent = addr ? 'Edit Address' : 'Add Address';
        document.getElementById('addr_id').value = addr ? addr.id : '';
        document.getElementById('addr_full_name').value = addr ? addr.full_name : '';
        document.getElementById('addr_phone').value = addr ? addr.phone : '';
        document.getElementById('addr_line1').value = addr ? addr.address_line_1 : '';
        document.getElementById('addr_line2').value = addr ? (addr.address_line_2 || '') : '';
        document.getElementById('addr_city').value = addr ? addr.city : '';
        document.getElementById('addr_province').value = addr ? addr.province : '';
        document.getElementById('addr_postal').value = addr ? addr.postal_code : '';
        document.getElementById('addr_country').value = addr ? addr.country : '';
        addrModal.classList.add('open');
    };
    document.querySelectorAll('.wishlist-remove').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var card = this.closest('.wishlist-card');
            fetch('<?= $base_url ?>wishlist/toggle', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'product_id=' + this.dataset.productId + '&_csrf_token=<?= htmlspecialchars(csrf_token()) ?>'
            }).then(function(r) { return r.json() }).then(function(data) {
                if (data.error) { alert(data.error); return }
                card.remove();
                var badge = document.getElementById('wishlistBadge');
                if (badge) badge.textContent = Math.max(0, parseInt(badge.textContent) - 1);
            });
        });
    });
    var params = new URLSearchParams(window.location.search);
    if (params.get('tab') === 'wishlist') {
        var wishlistBtn = document.querySelector('.account-nav-btn[data-section="wishlist"]');
        if (wishlistBtn) wishlistBtn.click();
    }
    if (params.get('tab') === 'cart') {
        var cartBtn = document.querySelector('.account-nav-btn[data-section="cart"]');
        if (cartBtn) cartBtn.click();
    }
});
</script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= $assets_url ?>js/home.js"></script>
</body>
</html>
