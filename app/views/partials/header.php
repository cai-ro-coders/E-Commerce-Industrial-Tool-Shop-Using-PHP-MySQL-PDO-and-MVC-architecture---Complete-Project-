<?php

use App\Helpers\Database;

$db = Database::getInstance();
$allCategories = $db->fetchAll(
    "SELECT * FROM categories WHERE status = 1 ORDER BY name ASC"
);
$parentCategories = array_filter($allCategories, fn($c) => is_null($c['parent_id']));
$childCategories = [];
foreach ($allCategories as $c) {
    if (!is_null($c['parent_id'])) {
        $childCategories[$c['parent_id']][] = $c;
    }
}

$categoryIcons = [
    'power tools' => 'fa-bolt',
    'hand tools' => 'fa-wrench',
    'safety' => 'fa-hard-hat',
    'cutting' => 'fa-cut',
    'welding' => 'fa-fire',
    'storage' => 'fa-archive',
    'tool storage' => 'fa-archive',
    'measuring' => 'fa-ruler',
    'electrical' => 'fa-plug',
    'plumbing' => 'fa-faucet',
    'painting' => 'fa-paint-roller',
    'gardening' => 'fa-leaf',
    'outdoor' => 'fa-tree',
    'automotive' => 'fa-car',
    'fasteners' => 'fa-circle',
    'hardware' => 'fa-cog',
];

function getCategoryIcon($name, $icons)
{
    $lower = strtolower($name);
    foreach ($icons as $key => $icon) {
        if (strpos($lower, $key) !== false) {
            return $icon;
        }
    }
    return 'fa-tag';
}
?>

<!-- Announcement Bar -->
<div class="announcement-bar">
    <div class="announcement-content">
        <span class="announcement-text">Free Shipping on Orders Over $100</span>
        <span class="announcement-separator">|</span>
        <span class="announcement-text">Easy 30-Day Returns</span>
        <span class="announcement-separator">|</span>
        <span class="announcement-text">Professional Grade Tools</span>
    </div>
    <button class="announcement-close" aria-label="Close announcement">&times;</button>
</div>

<!-- Header -->
<header class="site-header<?= !empty($header_scrolled) ? ' scrolled' : '' ?>" id="siteHeader">
    <div class="header-inner">
        <div class="header-left">
            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= $base_url ?>" class="site-logo">
                <span class="logo-icon"><i class="fas fa-tools"></i></span>
                <span class="logo-text">ToolShop</span>
            </a>
        </div>

        <nav class="main-nav" id="mainNav">
            <ul class="nav-list">
                <li class="nav-item"><a href="<?= $base_url ?>" class="nav-link">Home</a></li>
                <li class="nav-item has-mega">
                    <a href="#" class="nav-link">All Categories <i class="fas fa-chevron-down nav-arrow"></i></a>
                    <div class="mega-menu">
                        <div class="mega-inner">
                            <div class="mega-col">
                                <h4 class="mega-title">
                                    <a href="<?= $base_url ?>collections/all">
                                        <i class="fas fa-th-large mega-category-icon"></i>
                                        All Products
                                    </a>
                                </h4>
                            </div>
                            <?php foreach ($parentCategories as $parent): ?>
                                <div class="mega-col">
                                    <h4 class="mega-title">
                                        <a href="<?= $base_url ?>collections/<?= htmlspecialchars($parent['slug']) ?>">
                                            <i class="fas <?= getCategoryIcon($parent['name'], $categoryIcons) ?> mega-category-icon"></i>
                                            <?= htmlspecialchars($parent['name']) ?>
                                        </a>
                                    </h4>
                                    <?php if (isset($childCategories[$parent['id']])): ?>
                                        <ul class="mega-links">
                                            <?php foreach ($childCategories[$parent['id']] as $child): ?>
                                                <li><a href="<?= $base_url ?>collections/<?= htmlspecialchars($child['slug']) ?>"><?= htmlspecialchars($child['name']) ?></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a href="<?= $base_url ?>about" class="nav-link">About</a></li>
                <li class="nav-item"><a href="<?= $base_url ?>contact" class="nav-link">Contact</a></li>
            </ul>
        </nav>

        <div class="header-right">
            <button class="header-icon" id="searchToggle" aria-label="Search">
                <i class="fas fa-search"></i>
            </button>
            <a href="<?= $base_url ?>customer/my-account?tab=wishlist" class="header-icon wishlist-icon" aria-label="Wishlist">
                <i class="far fa-heart"></i>
                <span class="icon-badge" id="wishlistBadge"><?= wishlist_count() ?></span>
            </a>
            <a href="<?= is_logged_in() ? $base_url . 'customer/my-account' : $base_url . 'customer/login' ?>" class="header-icon" aria-label="Account">
                <?php if (is_logged_in() && isset($_SESSION['user_name'])): ?>
                    <span class="header-avatar"><?= strtoupper(substr($_SESSION['user_name'], 0, 1)) ?></span>
                <?php else: ?>
                    <i class="far fa-user"></i>
                <?php endif; ?>
            </a>
            <button class="header-icon cart-icon" id="cartToggle" aria-label="Cart">
                <i class="fas fa-shopping-bag"></i>
                <span class="icon-badge" id="cartBadge"><?= cart_count() ?></span>
            </button>
        </div>
    </div>

    <!-- Search Dropdown -->
    <div class="search-dropdown" id="searchDropdown">
        <div class="search-dropdown-inner">
            <form class="search-dropdown-form" action="<?= $base_url ?>collections/all" method="GET">
                <div class="search-dropdown-input-wrap">
                    <i class="fas fa-search search-dropdown-icon"></i>
                    <input type="text" class="search-dropdown-input" id="searchInput" name="search" placeholder="What are you looking for?" autocomplete="off">
                    <button type="submit" class="search-dropdown-btn">Search</button>
                    <button type="button" class="search-dropdown-close" id="searchClose">&times;</button>
                </div>
            </form>
            <div class="search-dropdown-suggestions" id="searchSuggestions">
                <span class="search-dropdown-suggestions-title">Popular Categories</span>
                <div class="search-dropdown-tags">
                    <a href="<?= $base_url ?>collections/power-tools" class="search-dropdown-tag">Power Tools</a>
                    <a href="<?= $base_url ?>collections/hand-tools" class="search-dropdown-tag">Hand Tools</a>
                    <a href="<?= $base_url ?>collections/safety" class="search-dropdown-tag">Safety Equipment</a>
                    <a href="<?= $base_url ?>collections/cutting" class="search-dropdown-tag">Cutting Tools</a>
                    <a href="<?= $base_url ?>collections/welding" class="search-dropdown-tag">Welding</a>
                    <a href="<?= $base_url ?>collections/tool-storage" class="search-dropdown-tag">Tool Storage</a>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Cart Drawer -->
<div class="cart-overlay" id="cartOverlay"></div>
<div class="cart-drawer" id="cartDrawer">
    <div class="cart-drawer-header">
        <h3>Shopping Cart</h3>
        <button class="cart-drawer-close" id="cartDrawerClose">&times;</button>
    </div>
    <div class="cart-drawer-body" id="cartDrawerBody">
        <div class="cart-loader"><i class="fas fa-spinner fa-spin"></i></div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cartToggle = document.getElementById('cartToggle');
        var cartDrawer = document.getElementById('cartDrawer');
        var cartOverlay = document.getElementById('cartOverlay');
        var cartClose = document.getElementById('cartDrawerClose');

        function openCart() {
            cartDrawer.classList.add('open');
            cartOverlay.classList.add('open');
            document.body.style.overflow = 'hidden';
            loadCartItems();
        }

        function closeCart() {
            cartDrawer.classList.remove('open');
            cartOverlay.classList.remove('open');
            document.body.style.overflow = '';
        }

        function loadCartItems() {
            var body = document.getElementById('cartDrawerBody');
            var drawer = document.getElementById('cartDrawer');
            var oldFooter = drawer.querySelector('.cart-drawer-footer');
            if (oldFooter) oldFooter.remove();
            body.innerHTML = '<div class="cart-loader"><i class="fas fa-spinner fa-spin"></i></div>';
            fetch('<?= $base_url ?>cart/json')
                .then(function(r) {
                    return r.json()
                })
                .then(function(data) {
                    if (!data.items || data.items.length === 0) {
                        body.innerHTML = '<div class="cart-drawer-empty"><i class="fas fa-shopping-bag"></i><p>Your cart is empty</p></div>';
                        return;
                    }
                    var html = '';
                    data.items.forEach(function(item) {
                        var img = item.primary_image ?
                            '<img src="<?= $uploads_url ?>' + item.primary_image + '" alt="' + item.name + '">' :
                            '<div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#ccc;font-size:20px"><i class="fas fa-box"></i></div>';
                        html += '<div class="cart-drawer-item">' +
                            '<div class="cart-drawer-item-img">' + img + '</div>' +
                            '<div class="cart-drawer-item-info">' +
                            '<a href="<?= $base_url ?>products/' + item.slug + '" class="cart-drawer-item-name">' + item.name + '</a>' +
                            '<div class="cart-drawer-item-meta">$' + item.unit_price.toFixed(2) + ' x ' + item.quantity + '</div>' +
                            '</div>' +
                            '<div class="cart-drawer-item-total">$' + item.subtotal.toFixed(2) + '</div>' +
                            '<button class="cart-drawer-remove" data-product-id="' + item.product_id + '"><i class="fas fa-times"></i></button>' +
                            '</div>';
                    });
                    body.innerHTML = html;
                    var footer = document.createElement('div');
                    footer.className = 'cart-drawer-footer';
                    footer.innerHTML = '<div class="cart-drawer-subtotal"><span>Subtotal</span><strong>$' + data.total.toFixed(2) + '</strong></div>' +
                        '<a href="<?= $base_url ?>customer/my-account?tab=cart" class="cart-drawer-checkout">View Cart & Checkout</a>';
                    drawer.appendChild(footer);

                    body.querySelectorAll('.cart-drawer-remove').forEach(function(btn) {
                        btn.addEventListener('click', function() {
                            fetch('<?= $base_url ?>cart/remove', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                },
                                body: 'product_id=' + this.dataset.productId + '&_csrf_token=<?= htmlspecialchars(csrf_token()) ?>'
                            }).then(function(r) {
                                return r.json()
                            }).then(function(data) {
                                if (data.error) return;
                                loadCartItems();
                                var badge = document.getElementById('cartBadge');
                                if (badge) badge.textContent = data.count;
                            });
                        });
                    });
                });
        }

        if (cartToggle) cartToggle.addEventListener('click', openCart);
        if (cartClose) cartClose.addEventListener('click', closeCart);
        if (cartOverlay) cartOverlay.addEventListener('click', closeCart);

        // ===== SEARCH DROPDOWN =====
        var searchToggle = document.getElementById('searchToggle');
        var searchDropdown = document.getElementById('searchDropdown');
        var searchClose = document.getElementById('searchClose');
        var searchInput = document.getElementById('searchInput');

        function openSearch() {
            searchDropdown.classList.add('active');
            setTimeout(function() {
                if (searchInput) searchInput.focus();
            }, 150);
        }

        function closeSearch() {
            if (searchDropdown) searchDropdown.classList.remove('active');
        }

        if (searchToggle) {
            searchToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                if (searchDropdown.classList.contains('active')) {
                    closeSearch();
                } else {
                    openSearch();
                }
            });
        }

        if (searchClose) {
            searchClose.addEventListener('click', closeSearch);
        }

        document.addEventListener('click', function(e) {
            if (searchDropdown && searchDropdown.classList.contains('active')) {
                if (!searchDropdown.contains(e.target) && e.target !== searchToggle && !searchToggle.contains(e.target)) {
                    closeSearch();
                }
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (searchDropdown && searchDropdown.classList.contains('active')) {
                    closeSearch();
                }
            }
        });
    });
</script>

<!-- Mobile Menu -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<div class="mobile-menu-panel" id="mobileMenuPanel">
    <div class="mobile-menu-header">
        <span class="mobile-menu-title">Menu</span>
        <button class="mobile-menu-close" id="mobileMenuClose">&times;</button>
    </div>
    <ul class="mobile-nav-list">
        <li><a href="<?= $base_url ?>">Home</a></li>
        <li><a href="#">Products</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Sales</a></li>
        <li><a href="<?= $base_url ?>about">About</a></li>
        <li><a href="<?= $base_url ?>contact">Contact</a></li>
    </ul>
</div>

<!-- Account Dropdown -->
<div class="account-dropdown" id="accountDropdown">
    <div class="account-dropdown-header">
        <i class="far fa-user-circle account-dropdown-icon"></i>
        <?php if ($current_user): ?>
            <div>
                <div class="account-dropdown-name"><?= htmlspecialchars($current_user['name']) ?></div>
                <div class="account-dropdown-email"><?= htmlspecialchars($current_user['email']) ?></div>
            </div>
        <?php else: ?>
            <div>
                <div class="account-dropdown-name">Welcome</div>
                <div class="account-dropdown-email">Sign in to your account</div>
            </div>
        <?php endif; ?>
    </div>
    <div class="account-dropdown-body">
        <?php if ($current_user): ?>
            <a href="#" class="account-dropdown-item"><i class="fas fa-user me-2"></i>My Account</a>
            <a href="#" class="account-dropdown-item"><i class="fas fa-box me-2"></i>My Orders</a>
            <a href="#" class="account-dropdown-item"><i class="far fa-heart me-2"></i>Wishlist</a>
            <div class="account-dropdown-divider"></div>
            <a href="<?= $base_url ?>logout" class="account-dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
        <?php else: ?>
            <a href="<?= $base_url ?>customer/login" class="account-dropdown-item"><i class="fas fa-sign-in-alt me-2"></i>Sign In</a>
            <a href="#" class="account-dropdown-item"><i class="fas fa-user-plus me-2"></i>Register</a>
        <?php endif; ?>
    </div>
</div>