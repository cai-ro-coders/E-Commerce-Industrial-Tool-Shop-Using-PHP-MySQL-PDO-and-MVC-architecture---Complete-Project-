<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — Premium Industrial Tools</title>
    <meta name="description" content="Premium industrial tools and equipment for professionals.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
</head>

<body>

    <?php require dirname(__DIR__) . '/partials/header.php'; ?>

    <!-- ========== HERO ========== -->
    <section class="hero-section" id="hero">
        <div class="hero-bg"></div>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <span class="hero-badge">Premium Industrial Tools</span>
            <h1 class="hero-title">Built for the <br><span class="hero-highlight">Professionals</span></h1>
            <p class="hero-description">Discover top-tier industrial tools engineered for precision, durability, and performance. Trusted by tradespeople worldwide.</p>
            <div class="hero-actions">
                <a href="http://localhost:8888/devproject/eCommerce/collections/all" class="btn btn-primary">Shop Collection &rarr;</a>
            </div>
        </div>
        <div class="hero-scroll-indicator">
            <span>Scroll</span>
            <i class="fas fa-chevron-down"></i>
        </div>
    </section>

    <!-- ========== FEATURES ========== -->
    <section class="features-section">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card fade-up">
                    <div class="feature-icon"><i class="fas fa-truck"></i></div>
                    <h3 class="feature-title">Free Shipping</h3>
                    <p class="feature-text">On orders over $100</p>
                </div>
                <div class="feature-card fade-up">
                    <div class="feature-icon"><i class="fas fa-undo-alt"></i></div>
                    <h3 class="feature-title">Easy Returns</h3>
                    <p class="feature-text">30-day hassle-free returns</p>
                </div>
                <div class="feature-card fade-up">
                    <div class="feature-icon"><i class="fas fa-lock"></i></div>
                    <h3 class="feature-title">Secure Checkout</h3>
                    <p class="feature-text">SSL encrypted payments</p>
                </div>
                <div class="feature-card fade-up">
                    <div class="feature-icon"><i class="fas fa-headset"></i></div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-text">Expert help anytime</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SHOP BY CATEGORY ========== -->
    <section class="categories-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-subtitle">Categories</span>
                <h2 class="section-title">Shop by Category</h2>
            </div>
            <div class="categories-grid">
                <?php foreach ($categories as $cat): ?>
                    <a href="<?= $base_url ?>collections/<?= htmlspecialchars($cat['slug']) ?>" class="category-card fade-up">
                        <div class="category-image">
                            <?php if ($cat['image']): ?>
                                <img src="<?= $uploads_url . htmlspecialchars($cat['image']) ?>" alt="<?= htmlspecialchars($cat['name']) ?>">
                            <?php else: ?>
                                <div class="category-placeholder"><i class="fas fa-tools"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="category-info">
                            <h3 class="category-name"><?= htmlspecialchars($cat['name']) ?></h3>
                            <span class="category-cta">Shop Now &rarr;</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ========== TRENDING PRODUCTS ========== -->
    <section class="products-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-subtitle">Trending</span>
                <h2 class="section-title">Trending Products</h2>
            </div>
            <div class="products-grid">
                <?php foreach ($trending_products as $product): ?>
                    <div class="product-card fade-up">
                        <div class="product-image">
                            <a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>">
                                <?php if ($product['primary_image']): ?>
                                    <img src="<?= $uploads_url . htmlspecialchars($product['primary_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-img">
                                <?php else: ?>
                                    <div class="product-placeholder"><i class="fas fa-box"></i></div>
                                <?php endif; ?>
                            </a>
                            <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                <span class="product-badge sale">Sale</span>
                            <?php endif; ?>
                            <div class="product-actions">
                                <button class="product-action-btn wishlist-btn" title="Add to Wishlist"><i class="far fa-heart"></i></button>
                                <button class="product-action-btn quick-view-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                            </div>
                            <button class="product-add-cart">Add to Cart</button>
                        </div>
                        <div class="product-info">
                            <h3 class="product-name"><a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>"><?= htmlspecialchars($product['name']) ?></a></h3>
                            <div class="product-price">
                                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                    <span class="price-current">$<?= number_format($product['sale_price'], 2) ?></span>
                                    <span class="price-old">$<?= number_format($product['price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="price-current">$<?= number_format($product['price'], 2) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ========== PROMOTIONAL BANNER ========== -->
    <section class="promo-section">
        <div class="container">
            <div class="promo-grid">
                <div class="promo-content fade-up">
                    <span class="promo-subtitle">Professional Grade</span>
                    <h2 class="promo-title">Engineered for the <span class="promo-highlight">Toughest Jobs</span></h2>
                    <p class="promo-text">Every tool in our collection is rigorously tested to meet the highest standards of durability and performance. From the construction site to the workshop, trust our tools to deliver when it matters most.</p>
                    <div class="promo-stats">
                        <div class="promo-stat">
                            <span class="promo-stat-number">15K+</span>
                            <span class="promo-stat-label">Happy Customers</span>
                        </div>
                        <div class="promo-stat">
                            <span class="promo-stat-number">500+</span>
                            <span class="promo-stat-label">Products</span>
                        </div>
                        <div class="promo-stat">
                            <span class="promo-stat-number">99%</span>
                            <span class="promo-stat-label">Satisfaction</span>
                        </div>
                    </div>
                    <a href="<?= $base_url ?>collections/all" class="btn btn-primary">Explore Collection &rarr;</a>
                </div>
                <div class="promo-image fade-up">
                    <div class="promo-image-bg"></div>
                    <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600&q=80" alt="Professional tools" class="promo-img">
                </div>
            </div>
        </div>
    </section>

    <!-- ========== NEW ARRIVALS ========== -->
    <section class="arrivals-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-subtitle">New In</span>
                <h2 class="section-title">New Arrivals</h2>
            </div>
            <div class="arrivals-grid">
                <?php foreach ($new_arrivals as $product): ?>
                    <div class="arrival-card fade-up">
                        <div class="arrival-image">
                            <a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>">
                                <?php if ($product['primary_image']): ?>
                                    <img src="<?= $uploads_url . htmlspecialchars($product['primary_image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                                <?php else: ?>
                                    <div class="arrival-placeholder"><i class="fas fa-box"></i></div>
                                <?php endif; ?>
                            </a>
                            <span class="arrival-badge">New</span>
                        </div>
                        <div class="arrival-info">
                            <h3 class="arrival-name"><a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>"><?= htmlspecialchars($product['name']) ?></a></h3>
                            <div class="arrival-price">
                                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                    <span class="price-current">$<?= number_format($product['sale_price'], 2) ?></span>
                                    <span class="price-old">$<?= number_format($product['price'], 2) ?></span>
                                <?php else: ?>
                                    <span class="price-current">$<?= number_format($product['price'], 2) ?></span>
                                <?php endif; ?>
                            </div>
                            <button class="arrival-add">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ========== TOP DEALS ========== -->
    <section class="deals-section">
        <div class="container">
            <div class="deals-wrapper">
                <div class="deals-content fade-up">
                    <span class="deals-subtitle">Limited Time</span>
                    <h2 class="deals-title">Top Deals</h2>
                    <div class="deals-countdown" id="countdown">
                        <div class="countdown-block">
                            <span class="countdown-number" id="countdownDays">00</span>
                            <span class="countdown-label">Days</span>
                        </div>
                        <div class="countdown-block">
                            <span class="countdown-number" id="countdownHours">00</span>
                            <span class="countdown-label">Hours</span>
                        </div>
                        <div class="countdown-block">
                            <span class="countdown-number" id="countdownMinutes">00</span>
                            <span class="countdown-label">Mins</span>
                        </div>
                        <div class="countdown-block">
                            <span class="countdown-number" id="countdownSeconds">00</span>
                            <span class="countdown-label">Secs</span>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary">View All Deals &rarr;</a>
                </div>
                <div class="deals-product fade-up">
                    <?php if (!empty($featured_products[0])): ?>
                        <div class="deal-card">
                            <div class="deal-card-image">
                                <?php if ($featured_products[0]['primary_image']): ?>
                                    <img src="<?= $uploads_url . htmlspecialchars($featured_products[0]['primary_image']) ?>" alt="<?= htmlspecialchars($featured_products[0]['name']) ?>">
                                <?php endif; ?>
                                <span class="deal-discount">
                                    <?php
                                    $orig = (float)$featured_products[0]['price'];
                                    $sale = (float)$featured_products[0]['sale_price'];
                                    $pct = $orig > 0 ? round((1 - $sale / $orig) * 100) : 0;
                                    ?>
                                    -<?= $pct ?>% OFF
                                </span>
                            </div>
                            <div class="deal-card-info">
                                <h3 class="deal-card-name"><?= htmlspecialchars($featured_products[0]['name']) ?></h3>
                                <div class="deal-card-price">
                                    <span class="price-current">$<?= number_format($sale ?: $orig, 2) ?></span>
                                    <?php if ($sale && $sale < $orig): ?>
                                        <span class="price-old">$<?= number_format($orig, 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                <button class="deal-add-btn">Add to Cart &rarr;</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== FEATURED PRODUCTS ========== -->
    <section class="featured-banner-section">
        <div class="featured-banner-bg"></div>
        <div class="container">
            <div class="featured-banner-content fade-up">
                <span class="featured-banner-subtitle">Premium Collection</span>
                <h2 class="featured-banner-title">Professional Tool Kits</h2>
                <p class="featured-banner-text">Complete tool kits for every trade. Pre-selected by industry experts for maximum productivity.</p>
                <div class="featured-banner-actions">
                    <a href="#" class="btn btn-primary">Shop Featured &rarr;</a>
                    <a href="#" class="btn btn-outline">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== SHOP BY BRAND ========== -->
    <section class="brands-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-subtitle">Brands</span>
                <h2 class="section-title">Shop by Brand</h2>
            </div>
            <div class="brands-grid">
                <?php foreach ($brands as $brand): ?>
                    <a href="#" class="brand-card fade-up">
                        <?php if ($brand['logo']): ?>
                            <img src="<?= $uploads_url . htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['name']) ?>" class="brand-logo">
                        <?php else: ?>
                            <span class="brand-name"><?= htmlspecialchars($brand['name']) ?></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ========== CUSTOMER REVIEWS ========== -->
    <section class="reviews-section">
        <div class="container">
            <div class="section-header fade-up">
                <span class="section-subtitle">Testimonials</span>
                <h2 class="section-title">What Our Customers Say</h2>
            </div>
            <div class="reviews-slider" id="reviewsSlider">
                <div class="reviews-track" id="reviewsTrack">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="review-stars">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star<?= $i <= $review['rating'] ? ' active' : '' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="review-text">"<?= htmlspecialchars($review['comment']) ?>"</p>
                            <div class="review-author">
                                <div class="review-avatar"><?= strtoupper(substr($review['user_name'], 0, 1)) ?></div>
                                <div>
                                    <span class="review-name"><?= htmlspecialchars($review['user_name']) ?></span>
                                    <span class="review-role">Verified Buyer</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="reviews-dots" id="reviewsDots"></div>
                <button class="reviews-arrow reviews-arrow-prev" id="reviewsPrev"><i class="fas fa-chevron-left"></i></button>
                <button class="reviews-arrow reviews-arrow-next" id="reviewsNext"><i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </section>

    <?php require dirname(__DIR__) . '/partials/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="<?= $assets_url ?>js/home.js"></script>
</body>

</html>