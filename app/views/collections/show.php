<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <meta name="description" content="Shop <?= $category ? htmlspecialchars($category['name']) : 'All Products' ?> at Industrial Tool Shop.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/collections.css" rel="stylesheet">
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<!-- Hero Breadcrumb -->
<section class="collection-hero">
    <div class="collection-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=1920&q=80')"></div>
    <div class="collection-hero-overlay"></div>
    <div class="collection-hero-content">
        <h1 class="collection-hero-title"><?= $category ? htmlspecialchars($category['name']) : 'All Products' ?></h1>
        <nav class="collection-breadcrumb">
            <a href="<?= $base_url ?>">Home</a>
            <span class="breadcrumb-sep">/</span>
            <?php if (!empty($search_query)): ?>
                <span class="breadcrumb-current">Search: &quot;<?= htmlspecialchars($search_query) ?>&quot;</span>
            <?php else: ?>
                <span class="breadcrumb-current"><?= $category ? htmlspecialchars($category['name']) : 'All Products' ?></span>
            <?php endif; ?>
        </nav>
        <?php if (!empty($search_query)): ?>
            <p class="collection-hero-sub"><?= count($products) ?> result<?= count($products) !== 1 ? 's' : '' ?> for &quot;<?= htmlspecialchars($search_query) ?>&quot;</p>
        <?php endif; ?>
    </div>
</section>

<!-- Main Layout -->
<div class="collection-layout">
    <div class="container">
        <div class="collection-wrapper">

            <!-- Sidebar -->
            <aside class="collection-sidebar" id="collectionSidebar">
                <div class="sidebar-inner">

                    <!-- Categories -->
                    <div class="sidebar-card">
                        <div class="sidebar-accordion active">
                            <button class="sidebar-accordion-header">
                                <span>Categories</span>
                                <i class="fas fa-chevron-up accordion-icon"></i>
                            </button>
                            <div class="sidebar-accordion-body">
                                <ul class="sidebar-categories">
                                    <li>
                                        <a href="<?= $base_url ?>collections/all"
                                           class="sidebar-category-link <?= !$category ? 'active' : '' ?>">
                                            All Products
                                        </a>
                                    </li>
                                    <?php foreach ($categories as $cat): ?>
                                        <li>
                                            <a href="<?= $base_url ?>collections/<?= htmlspecialchars($cat['slug']) ?>"
                                               class="sidebar-category-link <?= $category && $cat['id'] === $category['id'] ? 'active' : '' ?>">
                                                <?= htmlspecialchars($cat['name']) ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div class="sidebar-card">
                        <div class="sidebar-accordion active">
                            <button class="sidebar-accordion-header">
                                <span>Price Range</span>
                                <i class="fas fa-chevron-up accordion-icon"></i>
                            </button>
                            <div class="sidebar-accordion-body">
                                <div class="price-range">
                                    <div class="price-range-slider">
                                        <input type="range" class="price-range-input" id="priceMin"
                                               min="<?= floor($price_range['min_price'] ?? 0) ?>"
                                               max="<?= ceil($price_range['max_price'] ?? 1000) ?>"
                                               value="<?= max($min_price_filter, floor($price_range['min_price'] ?? 0)) ?>"
                                               step="1">
                                        <input type="range" class="price-range-input" id="priceMax"
                                               min="<?= floor($price_range['min_price'] ?? 0) ?>"
                                               max="<?= ceil($price_range['max_price'] ?? 1000) ?>"
                                               value="<?= min($max_price_filter < 99999 ? $max_price_filter : ceil($price_range['max_price'] ?? 1000), ceil($price_range['max_price'] ?? 1000)) ?>"
                                               step="1">
                                        <div class="price-range-track">
                                            <div class="price-range-fill" id="priceRangeFill"></div>
                                        </div>
                                    </div>
                                    <div class="price-range-values">
                                        <span>$<span id="priceMinLabel"><?= number_format(max($min_price_filter, floor($price_range['min_price'] ?? 0))) ?></span></span>
                                        <span>$<span id="priceMaxLabel"><?= number_format(min($max_price_filter < 99999 ? $max_price_filter : ceil($price_range['max_price'] ?? 1000), ceil($price_range['max_price'] ?? 1000))) ?></span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Brands -->
                    <div class="sidebar-card">
                        <div class="sidebar-accordion active">
                            <button class="sidebar-accordion-header">
                                <span>Brands</span>
                                <i class="fas fa-chevron-up accordion-icon"></i>
                            </button>
                            <div class="sidebar-accordion-body">
                                <div class="sidebar-checkbox-group">
                                    <?php foreach ($brands as $brand): ?>
                                        <label class="sidebar-checkbox">
                                            <input type="checkbox" name="brand" value="<?= $brand['id'] ?>"
                                                   class="sidebar-checkbox-input brand-filter"
                                                <?= in_array((string)$brand['id'], $active_brands) ? 'checked' : '' ?>>
                                            <span class="sidebar-checkbox-mark"></span>
                                            <span class="sidebar-checkbox-label"><?= htmlspecialchars($brand['name']) ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rating -->
                    <div class="sidebar-card">
                        <div class="sidebar-accordion active">
                            <button class="sidebar-accordion-header">
                                <span>Rating</span>
                                <i class="fas fa-chevron-up accordion-icon"></i>
                            </button>
                            <div class="sidebar-accordion-body">
                                <div class="sidebar-checkbox-group">
                                    <?php for ($i = 4; $i >= 1; $i--): ?>
                                        <label class="sidebar-checkbox">
                                            <input type="checkbox" name="rating" value="<?= $i ?>"
                                                   class="sidebar-checkbox-input rating-filter">
                                            <span class="sidebar-checkbox-mark"></span>
                                            <span class="sidebar-checkbox-label">
                                                <?php for ($j = 1; $j <= 5; $j++): ?>
                                                    <i class="fas fa-star<?= $j <= $i ? '' : '-o' ?>" style="color:#f1c40f;font-size:13px"></i>
                                                <?php endfor; ?>
                                                <span style="margin-left:6px;color:#999;font-size:13px">&amp; up</span>
                                            </span>
                                        </label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="sidebar-clear-btn" id="applyFilters">Apply Filters</button>
                    <button class="sidebar-clear-btn" id="clearFilters">Clear All Filters</button>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="collection-main">

                <!-- Toolbar -->
                <div class="collection-toolbar">
                    <div class="toolbar-left">
                        <span class="toolbar-count"><?= count($products) ?> Product<?= count($products) !== 1 ? 's' : '' ?></span>
                        <button class="toolbar-filter-toggle" id="filterToggle">
                            <i class="fas fa-sliders-h"></i> Filters
                        </button>
                    </div>
                    <div class="toolbar-right">
                        <div class="toolbar-view-toggle">
                            <button class="view-btn active" data-view="grid" title="Grid View"><i class="fas fa-th"></i></button>
                            <button class="view-btn" data-view="list" title="List View"><i class="fas fa-list"></i></button>
                        </div>
                        <div class="toolbar-sort">
                            <select class="sort-select" id="sortSelect">
                                <option value="newest" <?= $current_sort === 'newest' ? 'selected' : '' ?>>Newest</option>
                                <option value="price-asc" <?= $current_sort === 'price-asc' ? 'selected' : '' ?>>Price: Low to High</option>
                                <option value="price-desc" <?= $current_sort === 'price-desc' ? 'selected' : '' ?>>Price: High to Low</option>
                                <option value="name-asc" <?= $current_sort === 'name-asc' ? 'selected' : '' ?>>Name: A-Z</option>
                                <option value="name-desc" <?= $current_sort === 'name-desc' ? 'selected' : '' ?>>Name: Z-A</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div class="products-grid-collection" id="productsGrid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card-collection">
                            <div class="product-card-image">
                                <a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>">
                                    <?php if ($product['primary_image']): ?>
                                        <img src="<?= $uploads_url . htmlspecialchars($product['primary_image']) ?>"
                                             alt="<?= htmlspecialchars($product['name']) ?>"
                                             class="product-card-img">
                                    <?php else: ?>
                                        <div class="product-card-placeholder"><i class="fas fa-box"></i></div>
                                    <?php endif; ?>
                                </a>
                                <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                    <span class="product-card-badge sale-badge">
                                        -<?= round((1 - $product['sale_price'] / $product['price']) * 100) ?>%
                                    </span>
                                <?php endif; ?>
                                <div class="product-card-actions">
                                    <button class="prod-action-btn wishlist-btn" title="Add to Wishlist"><i class="far fa-heart"></i></button>
                                    <button class="prod-action-btn quick-view-btn" title="Quick View"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="product-card-body">
                                <span class="product-card-brand"><?= htmlspecialchars($product['brand_name'] ?? '') ?></span>
                                <h3 class="product-card-title">
                                    <a href="<?= $base_url ?>products/<?= htmlspecialchars($product['slug']) ?>"><?= htmlspecialchars($product['name']) ?></a>
                                </h3>
                                <div class="product-card-rating">
                                    <?php $avg = round($product['avg_rating']); ?>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i <= $avg ? '' : '-o' ?>" style="color:#f1c40f;font-size:13px"></i>
                                    <?php endfor; ?>
                                    <span class="rating-count">(<?= (int)$product['review_count'] ?>)</span>
                                </div>
                                <div class="product-card-price">
                                    <?php if ($product['sale_price'] && $product['sale_price'] < $product['price']): ?>
                                        <span class="price-current">$<?= number_format($product['sale_price'], 2) ?></span>
                                        <span class="price-old">$<?= number_format($product['price'], 2) ?></span>
                                    <?php else: ?>
                                        <span class="price-current">$<?= number_format($product['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                <button class="product-card-add">Add to Cart</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (isset($pagination) && $pagination['total_pages'] > 1): ?>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 py-4 mt-2 border-top">
                    <div class="text-muted small">
                        Showing <?= (($pagination['page'] - 1) * $pagination['per_page']) + 1 ?>
                        - <?= min($pagination['page'] * $pagination['per_page'], $pagination['total']) ?>
                        of <?= $pagination['total'] ?> products
                    </div>
                    <nav>
                        <ul class="pagination pagination-md mb-0">
                            <?php if ($pagination['page'] > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] - 1])) ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                            <?php if ($pagination['page'] > 3): ?>
                            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>">1</a></li>
                            <?php if ($pagination['page'] > 4): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php for ($i = max(1, $pagination['page'] - 2); $i <= min($pagination['total_pages'], $pagination['page'] + 2); $i++): ?>
                            <li class="page-item <?= $i === $pagination['page'] ? 'active' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
                            </li>
                            <?php endfor; ?>
                            <?php if ($pagination['page'] < $pagination['total_pages'] - 2): ?>
                            <?php if ($pagination['page'] < $pagination['total_pages'] - 3): ?>
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['total_pages']])) ?>"><?= $pagination['total_pages'] ?></a></li>
                            <?php endif; ?>
                            <?php if ($pagination['page'] < $pagination['total_pages']): ?>
                            <li class="page-item">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination['page'] + 1])) ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
                <?php endif; ?>

                <?php if (empty($products)): ?>
                    <div class="collection-empty">
                        <i class="fas fa-box-open collection-empty-icon"></i>
                        <h3>No products found</h3>
                        <p>Try adjusting your filters or browse other categories.</p>
                        <a href="<?= $base_url ?>" class="btn btn-primary">Back to Home</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= $assets_url ?>js/collections.js"></script>
</body>
</html>
