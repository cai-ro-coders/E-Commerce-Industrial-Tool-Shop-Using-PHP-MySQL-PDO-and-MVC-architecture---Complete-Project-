<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Learn about ToolShop — your trusted source for premium industrial tools and equipment.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/about.css" rel="stylesheet">
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<section class="about-hero">
    <div class="about-hero-bg"></div>
    <div class="about-hero-overlay"></div>
    <div class="about-hero-content">
        <span class="about-hero-badge">About Us</span>
        <h1 class="about-hero-title">Built for the <span class="about-hero-highlight">Professionals</span></h1>
        <p class="about-hero-text">For over a decade, ToolShop has been supplying industry professionals with the highest quality tools and equipment. We partner with leading manufacturers worldwide to bring you tools you can trust.</p>
    </div>
</section>

<section class="about-story">
    <div class="container">
        <div class="about-story-grid">
            <div class="about-story-content">
                <span class="about-section-label">Our Story</span>
                <h2 class="about-section-title">From a Workshop to a <span class="about-highlight">Global Brand</span></h2>
                <p class="about-story-text">ToolShop started in a small workshop in Chicago with a simple mission: provide professionals with tools that don't let them down. What began as a local supplier has grown into a trusted name in the industrial tool industry, serving customers across the globe.</p>
                <p class="about-story-text">Every tool in our collection is rigorously tested to meet the highest standards of durability and performance. We don't just sell tools — we provide solutions that help tradespeople do their best work.</p>
                <div class="about-stats">
                    <div class="about-stat">
                        <span class="about-stat-number">15K+</span>
                        <span class="about-stat-label">Happy Customers</span>
                    </div>
                    <div class="about-stat">
                        <span class="about-stat-number">500+</span>
                        <span class="about-stat-label">Products</span>
                    </div>
                    <div class="about-stat">
                        <span class="about-stat-number">50+</span>
                        <span class="about-stat-label">Brands</span>
                    </div>
                    <div class="about-stat">
                        <span class="about-stat-number">99%</span>
                        <span class="about-stat-label">Satisfaction</span>
                    </div>
                </div>
            </div>
            <div class="about-story-image">
                <div class="about-story-image-border"></div>
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=600&q=80" alt="Professional tools" class="about-story-img">
            </div>
        </div>
    </div>
</section>

<section class="about-values">
    <div class="container">
        <div class="about-values-header">
            <span class="about-section-label">What We Stand For</span>
            <h2 class="about-section-title">Our <span class="about-highlight">Core Values</span></h2>
        </div>
        <div class="about-values-grid">
            <div class="about-value-card">
                <div class="about-value-icon"><i class="fas fa-medal"></i></div>
                <h3 class="about-value-title">Quality First</h3>
                <p class="about-value-text">We never compromise on quality. Every product is vetted by industry experts before it reaches our shelves.</p>
            </div>
            <div class="about-value-card">
                <div class="about-value-icon"><i class="fas fa-handshake"></i></div>
                <h3 class="about-value-title">Trust & Integrity</h3>
                <p class="about-value-text">Honest pricing, transparent policies, and a commitment to doing right by our customers and partners.</p>
            </div>
            <div class="about-value-card">
                <div class="about-value-icon"><i class="fas fa-leaf"></i></div>
                <h3 class="about-value-title">Sustainability</h3>
                <p class="about-value-text">We're committed to reducing our environmental footprint through sustainable sourcing and eco-friendly packaging.</p>
            </div>
            <div class="about-value-card">
                <div class="about-value-icon"><i class="fas fa-users"></i></div>
                <h3 class="about-value-title">Community</h3>
                <p class="about-value-text">We support the trades community through apprenticeships, training programs, and local partnerships.</p>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($brands)): ?>
<section class="about-brands">
    <div class="container">
        <div class="about-brands-header">
            <span class="about-section-label">Our Partners</span>
            <h2 class="about-section-title">Brands We <span class="about-highlight">Trust</span></h2>
        </div>
        <div class="about-brands-grid">
            <?php foreach ($brands as $brand): ?>
            <div class="about-brand-card">
                <?php if ($brand['logo']): ?>
                    <img src="<?= $uploads_url . htmlspecialchars($brand['logo']) ?>" alt="<?= htmlspecialchars($brand['name']) ?>" class="about-brand-logo">
                <?php else: ?>
                    <span class="about-brand-name"><?= htmlspecialchars($brand['name']) ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($reviews)): ?>
<section class="about-reviews">
    <div class="container">
        <div class="about-reviews-header">
            <span class="about-section-label">Testimonials</span>
            <h2 class="about-section-title">What Our <span class="about-highlight">Customers Say</span></h2>
        </div>
        <div class="about-reviews-grid">
            <?php foreach ($reviews as $review): ?>
            <div class="about-review-card">
                <div class="about-review-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star<?= $i <= $review['rating'] ? '' : '-o' ?>"></i>
                    <?php endfor; ?>
                </div>
                <p class="about-review-text">"<?= htmlspecialchars($review['comment']) ?>"</p>
                <div class="about-review-author">
                    <div class="about-review-avatar"><?= strtoupper(substr($review['user_name'], 0, 1)) ?></div>
                    <div>
                        <div class="about-review-name"><?= htmlspecialchars($review['user_name']) ?></div>
                        <div class="about-review-role">Verified Buyer</div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="about-cta">
    <div class="container">
        <div class="about-cta-content">
            <h2 class="about-cta-title">Ready to Equip Your Workshop?</h2>
            <p class="about-cta-text">Browse our collection of professional-grade tools and join thousands of satisfied customers.</p>
            <a href="<?= $base_url ?>collections/all" class="btn btn-primary">Shop Collection &rarr;</a>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= $assets_url ?>js/home.js"></script>
</body>
</html>
