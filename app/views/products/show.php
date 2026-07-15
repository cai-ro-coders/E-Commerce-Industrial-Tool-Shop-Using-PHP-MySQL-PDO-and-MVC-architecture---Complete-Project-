<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($product['short_description'] ?? $product['name']) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/collections.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/product.css" rel="stylesheet">
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<!-- Hero Breadcrumb -->
<section class="product-hero">
    <div class="product-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1920&q=80')"></div>
    <div class="product-hero-overlay"></div>
    <div class="product-hero-content">
        <h1 class="product-hero-title"><?= htmlspecialchars($product['name']) ?></h1>
        <nav class="product-breadcrumb">
            <a href="<?= $base_url ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <?php if ($product['category_name']): ?>
            <a href="<?= $base_url ?>collections/<?= htmlspecialchars($product['category_slug']) ?>"><?= htmlspecialchars($product['category_name']) ?></a>
            <span class="breadcrumb-sep">/</span>
            <?php endif; ?>
            <span class="breadcrumb-current"><?= htmlspecialchars($product['name']) ?></span>
        </nav>
    </div>
</section>

<!-- Product Showcase -->
<section class="product-showcase">
    <div class="container">
        <div class="product-showcase-grid">

            <!-- Gallery -->
            <div class="product-gallery" id="productGallery">
                <div class="gallery-thumbs" id="galleryThumbs">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $idx => $img): ?>
                        <button class="gallery-thumb <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                            <img src="<?= $uploads_url . htmlspecialchars($img['image']) ?>" alt="Thumbnail <?= $idx + 1 ?>">
                        </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="gallery-main" id="galleryMain">
                    <?php if (!empty($images)): ?>
                        <?php foreach ($images as $idx => $img): ?>
                        <div class="gallery-slide <?= $idx === 0 ? 'active' : '' ?>" data-index="<?= $idx ?>">
                            <div class="gallery-zoom" data-image="<?= $uploads_url . htmlspecialchars($img['image']) ?>">
                                <img src="<?= $uploads_url . htmlspecialchars($img['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="gallery-slide active" data-index="0">
                            <div class="gallery-placeholder">
                                <i class="fas fa-box"></i>
                                <span>No image available</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <button class="gallery-nav gallery-prev" id="galleryPrev"><i class="fas fa-chevron-left"></i></button>
                    <button class="gallery-nav gallery-next" id="galleryNext"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <?php if ($product['category_name']): ?>
                <a href="<?= $base_url ?>collections/<?= htmlspecialchars($product['category_slug']) ?>" class="product-category-label">
                    <?= htmlspecialchars($product['category_name']) ?>
                </a>
                <?php endif; ?>

                <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

                <div class="product-rating">
                    <?php $avg = round($reviewStats['avg_rating']); ?>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= $avg ? '' : '-o' ?>"></i>
                    <?php endfor; ?>
                    <span class="rating-score"><?= number_format($reviewStats['avg_rating'], 1) ?></span>
                    <span class="rating-count">(<?= (int)$reviewStats['total_reviews'] ?> review<?= (int)$reviewStats['total_reviews'] !== 1 ? 's' : '' ?>)</span>
                </div>

                <div class="product-price-block">
                    <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                        <span class="product-price-sale">$<?= number_format($product['sale_price'], 2) ?></span>
                        <span class="product-price-original">$<?= number_format($product['price'], 2) ?></span>
                        <span class="product-discount-badge">-<?= round((1 - $product['sale_price'] / $product['price']) * 100) ?>%</span>
                    <?php else: ?>
                        <span class="product-price-current">$<?= number_format($product['price'], 2) ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($product['short_description']): ?>
                <p class="product-short-desc"><?= htmlspecialchars($product['short_description']) ?></p>
                <?php endif; ?>

                <div class="product-actions-row">
                    <div class="quantity-selector">
                        <button class="qty-btn qty-minus" id="qtyMinus"><i class="fas fa-minus"></i></button>
                        <input type="number" class="qty-input" id="qtyInput" value="1" min="1" max="<?= $product['stock_quantity'] ?>">
                        <button class="qty-btn qty-plus" id="qtyPlus"><i class="fas fa-plus"></i></button>
                    </div>
                    <button class="btn-add-cart" id="addToCartBtn">
                        <i class="fas fa-shopping-bag"></i> Add to Cart
                    </button>
                    <button class="btn-buy-now">
                        <i class="fas fa-bolt"></i> Buy Now
                    </button>
                </div>

                <div class="product-secondary-actions">
                    <button class="product-action-icon wishlist-btn <?= $in_wishlist ? 'active' : '' ?>" data-product-id="<?= $product['id'] ?>" title="Add to Wishlist">
                        <i class="<?= $in_wishlist ? 'fas' : 'far' ?> fa-heart"></i> <span><?= $in_wishlist ? 'In Wishlist' : 'Wishlist' ?></span>
                    </button>
                    <button class="product-action-icon" title="Compare">
                        <i class="fas fa-exchange-alt"></i> Compare
                    </button>
                </div>

                <div class="product-meta">
                    <?php if ($product['sku']): ?>
                    <div class="meta-row"><span class="meta-label">SKU:</span> <span><?= htmlspecialchars($product['sku']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($product['brand_name']): ?>
                    <div class="meta-row"><span class="meta-label">Brand:</span> <span><?= htmlspecialchars($product['brand_name']) ?></span></div>
                    <?php endif; ?>
                    <?php if ($product['stock_quantity'] > 0): ?>
                    <div class="meta-row"><span class="meta-label">Stock:</span> <span class="stock-in">In Stock (<?= $product['stock_quantity'] ?> available)</span></div>
                    <?php else: ?>
                    <div class="meta-row"><span class="meta-label">Stock:</span> <span class="stock-out">Out of Stock</span></div>
                    <?php endif; ?>
                </div>

                <div class="product-share">
                    <span class="share-label">Share:</span>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-link"><i class="fab fa-twitter"></i></a>
                    <a href="https://wa.me/?text=<?= urlencode($product['name'] . ' - ' . $_SERVER['REQUEST_URI']) ?>" target="_blank" class="share-link"><i class="fab fa-whatsapp"></i></a>
                    <a href="mailto:?subject=<?= urlencode($product['name']) ?>&body=<?= urlencode($_SERVER['REQUEST_URI']) ?>" class="share-link"><i class="fas fa-envelope"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Tabs -->
<section class="product-tabs-section">
    <div class="container">
        <div class="product-tabs">
            <div class="tabs-nav">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="specifications">Additional Information</button>
                <button class="tab-btn" data-tab="reviews">Reviews (<?= (int)$reviewStats['total_reviews'] ?>)</button>
            </div>
            <div class="tabs-content">
                <!-- Description -->
                <div class="tab-panel active" id="tab-description">
                    <div class="tab-inner">
                        <?= $product['description'] ? nl2br(htmlspecialchars($product['description'])) : '<p>No description available for this product.</p>' ?>
                    </div>
                </div>
                <!-- Specifications -->
                <div class="tab-panel" id="tab-specifications">
                    <div class="tab-inner">
                        <?php if (!empty($specs)): ?>
                        <table class="specs-table">
                            <?php foreach ($specs as $spec): ?>
                            <tr>
                                <td class="spec-name"><?= htmlspecialchars($spec['attribute_name']) ?></td>
                                <td class="spec-value"><?= htmlspecialchars($spec['attribute_value']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                        <?php else: ?>
                        <p>No additional information available.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Reviews -->
                <div class="tab-panel" id="tab-reviews">
                    <div class="tab-inner">
                        <?php if (!empty($reviews)): ?>
                        <div class="reviews-list">
                            <?php foreach ($reviews as $review): ?>
                            <div class="review-item">
                                <div class="review-header">
                                    <div class="review-user">
                                        <div class="review-avatar"><?= strtoupper(substr($review['user_name'], 0, 1)) ?></div>
                                        <div>
                                            <div class="review-name"><?= htmlspecialchars($review['user_name']) ?></div>
                                            <div class="review-date"><?= date('M d, Y', strtotime($review['created_at'])) ?></div>
                                        </div>
                                    </div>
                                    <div class="review-stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-o' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="review-text"><?= htmlspecialchars($review['comment']) ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p>No reviews yet. Be the first to review this product.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($related_products)): ?>
<section class="related-products-section">
    <div class="container">
        <h2 class="section-title">Related Products</h2>
        <div class="related-products-grid">
            <?php foreach ($related_products as $rp): ?>
            <div class="product-card-collection">
                <div class="product-card-image">
                    <a href="<?= $base_url ?>products/<?= htmlspecialchars($rp['slug']) ?>">
                        <?php if ($rp['primary_image']): ?>
                            <img src="<?= $uploads_url . htmlspecialchars($rp['primary_image']) ?>" alt="<?= htmlspecialchars($rp['name']) ?>" class="product-card-img">
                        <?php else: ?>
                            <div class="product-card-placeholder"><i class="fas fa-box"></i></div>
                        <?php endif; ?>
                    </a>
                    <?php if ($rp['sale_price'] && $rp['sale_price'] < $rp['price']): ?>
                        <span class="product-card-badge sale-badge">-<?= round((1 - $rp['sale_price'] / $rp['price']) * 100) ?>%</span>
                    <?php endif; ?>
                    <div class="product-card-actions">
                        <button class="prod-action-btn" title="Add to Wishlist"><i class="far fa-heart"></i></button>
                        <button class="prod-action-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="product-card-body">
                    <span class="product-card-brand"><?= htmlspecialchars($rp['brand_name'] ?? '') ?></span>
                    <h3 class="product-card-title">
                        <a href="<?= $base_url ?>products/<?= htmlspecialchars($rp['slug']) ?>"><?= htmlspecialchars($rp['name']) ?></a>
                    </h3>
                    <div class="product-card-rating">
                        <?php $rpAvg = round($rp['avg_rating']); ?>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star<?= $i <= $rpAvg ? '' : '-o' ?>"></i>
                        <?php endfor; ?>
                        <span class="rating-count">(<?= (int)$rp['review_count'] ?>)</span>
                    </div>
                    <div class="product-card-price">
                        <?php if ($rp['sale_price'] && $rp['sale_price'] < $rp['price']): ?>
                            <span class="price-current">$<?= number_format($rp['sale_price'], 2) ?></span>
                            <span class="price-old">$<?= number_format($rp['price'], 2) ?></span>
                        <?php else: ?>
                            <span class="price-current">$<?= number_format($rp['price'], 2) ?></span>
                        <?php endif; ?>
                    </div>
                    <button class="product-card-add">Add to Cart</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gallery
    const thumbs = document.querySelectorAll('.gallery-thumb');
    const slides = document.querySelectorAll('.gallery-slide');
    const prev = document.getElementById('galleryPrev');
    const next = document.getElementById('galleryNext');
    let current = 0;

    function showSlide(index) {
        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;
        slides.forEach(s => s.classList.remove('active'));
        thumbs.forEach(t => t.classList.remove('active'));
        slides[index].classList.add('active');
        if (thumbs[index]) thumbs[index].classList.add('active');
        current = index;
    }

    thumbs.forEach(t => t.addEventListener('click', () => showSlide(parseInt(t.dataset.index))));
    if (prev) prev.addEventListener('click', () => showSlide(current - 1));
    if (next) next.addEventListener('click', () => showSlide(current + 1));

    // Quantity
    const qtyInput = document.getElementById('qtyInput');
    const qtyMinus = document.getElementById('qtyMinus');
    const qtyPlus = document.getElementById('qtyPlus');
    if (qtyMinus) qtyMinus.addEventListener('click', () => { qtyInput.value = Math.max(1, parseInt(qtyInput.value) - 1); });
    if (qtyPlus) qtyPlus.addEventListener('click', () => { qtyInput.value = Math.min(parseInt(qtyInput.max), parseInt(qtyInput.value) + 1); });

    // Tabs
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabPanels = document.querySelectorAll('.tab-panel');
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            tabBtns.forEach(b => b.classList.remove('active'));
            tabPanels.forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('tab-' + btn.dataset.tab).classList.add('active');
        });
    });

    // Zoom on hover
    document.querySelectorAll('.gallery-zoom').forEach(zoom => {
        zoom.addEventListener('mousemove', (e) => {
            const rect = zoom.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width * 100;
            const y = (e.clientY - rect.top) / rect.height * 100;
            zoom.querySelector('img').style.transformOrigin = x + '% ' + y + '%';
            zoom.querySelector('img').style.transform = 'scale(1.8)';
        });
        zoom.addEventListener('mouseleave', (e) => {
            zoom.querySelector('img').style.transform = 'scale(1)';
        });
    });

    // Wishlist toggle
    document.querySelector('.wishlist-btn')?.addEventListener('click', function() {
        var btn = this;
        fetch('<?= $base_url ?>wishlist/toggle', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'product_id=' + btn.dataset.productId + '&_csrf_token=<?= htmlspecialchars(csrf_token()) ?>'
        }).then(function(r) { return r.json() }).then(function(data) {
            if (data.error) { alert(data.error); return }
            var icon = btn.querySelector('i');
            var text = btn.querySelector('span');
            var badge = document.getElementById('wishlistBadge');
            var count = parseInt(badge.textContent) || 0;
            if (data.action === 'added') {
                icon.className = 'fas fa-heart';
                text.textContent = 'In Wishlist';
                btn.classList.add('active');
                badge.textContent = count + 1;
            } else {
                icon.className = 'far fa-heart';
                text.textContent = 'Wishlist';
                btn.classList.remove('active');
                badge.textContent = Math.max(0, count - 1);
            }
        });
    });

    // Add to Cart
    document.getElementById('addToCartBtn')?.addEventListener('click', function() {
        var qty = document.getElementById('qtyInput').value;
        fetch('<?= $base_url ?>cart/add', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'product_id=<?= $product['id'] ?>&quantity=' + qty + '&_csrf_token=<?= htmlspecialchars(csrf_token()) ?>'
        }).then(function(r) { return r.json() }).then(function(data) {
            if (data.error) { alert(data.error); return }
            var badge = document.getElementById('cartBadge');
            if (badge) badge.textContent = data.count;
        });
    });
});
</script>
</body>
</html>
