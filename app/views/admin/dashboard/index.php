<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="mb-1">Dashboard</h5>
        <p class="text-muted small mb-0">Overview of your store performance</p>
    </div>
    <span class="text-muted small"><i class="fas fa-calendar-alt me-1"></i><?= date('l, F d, Y') ?></span>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Revenue</p>
                        <h5 class="mb-0"><?= format_price($total_revenue) ?></h5>
                        <small class="text-muted"><?= format_price($total_revenue_today) ?> today</small>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                        <i class="fas fa-dollar-sign fa-lg text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Today Orders</p>
                        <h5 class="mb-0"><?= $today_orders ?></h5>
                        <small class="text-muted">Yesterday: <?= $yesterday_orders ?></small>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3">
                        <i class="fas fa-shopping-cart fa-lg text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Orders</p>
                        <h5 class="mb-0"><?= $total_orders ?></h5>
                        <small class="text-muted"><?= $total_categories ?> Categories</small>
                    </div>
                    <div class="rounded-circle bg-info bg-opacity-10 p-3">
                        <i class="fas fa-box fa-lg text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small mb-1">Total Products</p>
                        <h5 class="mb-0"><?= $total_products ?></h5>
                        <small class="text-muted"><?= $total_customers ?> Customers</small>
                    </div>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                        <i class="fas fa-boxes fa-lg text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="mb-0"><i class="fas fa-chart-line me-2 text-primary"></i>Weekly Sales</h6>
            </div>
            <div class="card-body">
                <canvas id="weeklySalesChart" height="100"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 pt-3 pb-0">
                <h6 class="mb-0"><i class="fas fa-chart-pie me-2 text-primary"></i>Best Sellers</h6>
            </div>
            <div class="card-body">
                <canvas id="bestSellersChart" height="180"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
        <h6 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Recent Orders</h6>
        <a href="<?= $base_url ?>admin/orders" class="btn btn-outline-primary btn-sm">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 50px;"></th>
                        <th>Order#</th>
                        <th>Customer</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_orders)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No orders found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($recent_orders as $order): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($order['product_image'])): ?>
                                        <img src="<?= $uploads_url . $order['product_image'] ?>"
                                             alt="Product"
                                             class="rounded"
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-box text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= $base_url ?>admin/orders/view/<?= $order['order_number'] ?>" class="text-decoration-none fw-medium">
                                        <?= $order['order_number'] ?>
                                    </a>
                                </td>
                                <td><?= $order['customer_name'] ?></td>
                                <td><?= $order['total_items'] ?? '-' ?></td>
                                <td><?= format_price($order['grand_total']) ?></td>
                                <td><?= get_status_badge($order['order_status']) ?></td>
                                <td class="text-nowrap small"><?= format_datetime($order['created_at']) ?></td>
                                <td class="text-end">
                                    <a href="<?= $base_url ?>admin/orders/view/<?= $order['order_number'] ?>"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif";

    const weeklySales = <?= json_encode($weekly_sales) ?>;
    const bestSellers = <?= json_encode($best_sellers) ?>;

    if (weeklySales.length) {
        new Chart(document.getElementById('weeklySalesChart'), {
            type: 'line',
            data: {
                labels: weeklySales.map(s => {
                    const d = new Date(s.date + 'T00:00:00');
                    return d.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' });
                }),
                datasets: [{
                    label: 'Revenue',
                    data: weeklySales.map(s => parseFloat(s.total)),
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0d6efd',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }

    if (bestSellers.length) {
        const colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'];
        new Chart(document.getElementById('bestSellersChart'), {
            type: 'doughnut',
            data: {
                labels: bestSellers.map(p => p.name),
                datasets: [{
                    data: bestSellers.map(p => parseInt(p.total_qty)),
                    backgroundColor: colors.slice(0, bestSellers.length),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            boxWidth: 10,
                            padding: 12,
                            font: { size: 11 }
                        }
                    }
                },
                cutout: '65%'
            }
        });
    }
});
</script>
