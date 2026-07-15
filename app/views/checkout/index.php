<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Secure checkout at ToolShop.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/checkout.css" rel="stylesheet">
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_CLIENT_ID ?>&currency=USD" data-sdk-integration-source="button-factory"></script>
</head>
<body>

<?php $header_scrolled = true; ?>
<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<section class="checkout-section">
    <div class="container">
        <div class="checkout-grid">
            <div class="checkout-main">
                <h1 class="checkout-title">Checkout</h1>

                <?php $success_msg = flash('success'); $error_msg = flash('error'); ?>
                <?php if ($success_msg): ?>
                    <div class="checkout-alert success"><?= htmlspecialchars($success_msg) ?></div>
                <?php endif; ?>
                <?php if ($error_msg): ?>
                    <div class="checkout-alert error"><?= htmlspecialchars($error_msg) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= $base_url ?>checkout/place-order" id="checkoutForm">
                    <?= csrf_field() ?>

                    <div class="checkout-card">
                        <h2 class="checkout-card-title">Shipping Information</h2>

                        <div class="checkout-field">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name" class="checkout-input" value="<?= htmlspecialchars($user['name']) ?>" required>
                        </div>

                        <div class="checkout-row">
                            <div class="checkout-field">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="checkout-input" value="<?= htmlspecialchars($user['email']) ?>" readonly>
                            </div>
                            <div class="checkout-field">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" name="phone" class="checkout-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required>
                            </div>
                        </div>

                        <div class="checkout-field">
                            <label for="address_line_1">Address Line 1</label>
                            <input type="text" id="address_line_1" name="address_line_1" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['address_line_1']) : '' ?>" required>
                        </div>

                        <div class="checkout-field">
                            <label for="address_line_2">Address Line 2 <span class="optional">(optional)</span></label>
                            <input type="text" id="address_line_2" name="address_line_2" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['address_line_2'] ?? '') : '' ?>">
                        </div>

                        <div class="checkout-row checkout-row-3">
                            <div class="checkout-field">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['city']) : '' ?>" required>
                            </div>
                            <div class="checkout-field">
                                <label for="province">Province</label>
                                <input type="text" id="province" name="province" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['province']) : '' ?>" required>
                            </div>
                            <div class="checkout-field">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['postal_code']) : '' ?>" required>
                            </div>
                        </div>

                        <div class="checkout-field">
                            <label for="country">Country</label>
                            <input type="text" id="country" name="country" class="checkout-input" value="<?= $default_address ? htmlspecialchars($default_address['country']) : '' ?>" required>
                        </div>
                    </div>

                    <div class="checkout-card">
                        <h2 class="checkout-card-title">Payment Method</h2>
                        <div class="payment-options">
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="stripe" checked required>
                                <i class="fas fa-credit-card"></i>
                                <span>Credit Card <small>(Visa, Mastercard, Amex)</small></span>
                            </label>
                            <div id="stripe-card-element" class="stripe-card-wrapper">
                                <div class="stripe-field">
                                    <label for="cardholder-name">Cardholder Name</label>
                                    <input type="text" id="cardholder-name" class="checkout-input" placeholder="John Doe" value="<?= htmlspecialchars($user['name']) ?>" required>
                                </div>
                                <div class="stripe-field">
                                    <label>Card Details</label>
                                    <div id="card-element"></div>
                                </div>
                                <div id="card-errors" class="stripe-error" role="alert"></div>
                            </div>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="PayPal">
                                <i class="fab fa-paypal"></i>
                                <span>PayPal</span>
                            </label>
                            <div id="paypal-button-container" class="paypal-button-wrapper"></div>
                            <label class="payment-option">
                                <input type="radio" name="payment_method" value="Cash on Delivery">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash on Delivery</span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="payment_intent_id" id="payment_intent_id" value="">
                    <button type="submit" class="checkout-place-order" id="placeOrderBtn">
                        <i class="fas fa-lock"></i> Place Order — $<?= number_format($subtotal, 2) ?>
                    </button>
                </form>
            </div>

            <div class="checkout-sidebar">
                <div class="checkout-summary-card">
                    <h3 class="checkout-summary-title">Order Summary</h3>

                    <div class="checkout-summary-items">
                        <?php foreach ($cart_items as $item): ?>
                        <div class="checkout-summary-item">
                            <div class="checkout-summary-item-img">
                                <?php if ($item['primary_image']): ?>
                                    <img src="<?= $uploads_url . htmlspecialchars($item['primary_image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                <?php else: ?>
                                    <div class="checkout-summary-placeholder"><i class="fas fa-box"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="checkout-summary-item-info">
                                <a href="<?= $base_url ?>products/<?= htmlspecialchars($item['slug']) ?>" class="checkout-summary-item-name"><?= htmlspecialchars($item['name']) ?></a>
                                <div class="checkout-summary-item-meta">Qty: <?= (int)$item['quantity'] ?></div>
                            </div>
                            <div class="checkout-summary-item-price">$<?= number_format($item['line_total'], 2) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="checkout-summary-divider"></div>

                    <div class="checkout-summary-line">
                        <span>Subtotal</span>
                        <span>$<?= number_format($subtotal, 2) ?></span>
                    </div>
                    <div class="checkout-summary-line">
                        <span>Shipping</span>
                        <span><?= $subtotal >= 100 ? 'Free' : '$9.99' ?></span>
                    </div>
                    <div class="checkout-summary-line">
                        <span>Tax (8%)</span>
                        <span>$<?= number_format($subtotal * 0.08, 2) ?></span>
                    </div>

                    <div class="checkout-summary-divider"></div>

                    <div class="checkout-summary-total">
                        <span>Total</span>
                        <strong>$<?= number_format($subtotal + ($subtotal >= 100 ? 0 : 9.99) + round($subtotal * 0.08, 2), 2) ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= $assets_url ?>js/home.js"></script>
<script>
var stripe = Stripe('<?= STRIPE_PUBLISHABLE_KEY ?>');
var elements = stripe.elements();
var style = {
    base: {
        fontSize: '16px',
        color: '#32325d',
        fontFamily: '"Inter", sans-serif',
        '::placeholder': { color: '#aab7c4' }
    },
    invalid: { color: '#dc3545' }
};
var card = elements.create('card', { style: style, hidePostalCode: true });
card.mount('#card-element');

<?php $grandTotal = $subtotal + ($subtotal >= 100 ? 0 : 9.99) + round($subtotal * 0.08, 2); ?>

card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

var paypalBtnContainer = document.getElementById('paypal-button-container');
var stripeWrapper = document.getElementById('stripe-card-element');
var paypalButtonsRendered = false;
paypalBtnContainer.style.display = 'none';

function renderPayPalButtons() {
    if (paypalButtonsRendered || typeof paypal === 'undefined') return;
    paypal.Buttons({
        createOrder: function() {
            var form = document.getElementById('checkoutForm');
            var formData = new FormData(form);
            var csrf = form.querySelector('input[name="_csrf_token"]').value;
            formData.append('_csrf_token', csrf);
            return fetch('<?= $base_url ?>checkout/create-paypal-order', {
                method: 'POST',
                body: formData
            }).then(function(r) { return r.json() }).then(function(data) {
                if (data.error) { alert(data.error); return; }
                return data.order_id;
            });
        },
        onApprove: function(data) {
            var form = document.getElementById('checkoutForm');
            var formData = new FormData(form);
            var csrf = form.querySelector('input[name="_csrf_token"]').value;
            formData.append('_csrf_token', csrf);
            formData.append('paypal_order_id', data.orderID);
            return fetch('<?= $base_url ?>checkout/capture-paypal-order', {
                method: 'POST',
                body: formData
            }).then(function(r) { return r.json() }).then(function(data) {
                if (data.error) { alert(data.error); return; }
                window.location.href = '<?= $base_url ?>customer/order/' + data.order_number;
            });
        },
        onError: function(err) {
            alert('PayPal payment failed. Please try again.');
        }
    }).render('#paypal-button-container');
    paypalButtonsRendered = true;
}

document.querySelectorAll('input[name="payment_method"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        if (this.value === 'stripe') {
            stripeWrapper.style.display = 'block';
            paypalBtnContainer.style.display = 'none';
        } else if (this.value === 'PayPal') {
            stripeWrapper.style.display = 'none';
            paypalBtnContainer.style.display = 'block';
            renderPayPalButtons();
        } else {
            stripeWrapper.style.display = 'none';
            paypalBtnContainer.style.display = 'none';
        }
    });
});

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    var selectedPayment = document.querySelector('input[name="payment_method"]:checked');
    if (!selectedPayment) return;
    if (selectedPayment.value === 'PayPal') {
        e.preventDefault();
        return;
    }
    if (selectedPayment.value !== 'stripe') {
        return;
    }
    e.preventDefault();
    var btn = document.getElementById('placeOrderBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing…';

    var formData = new FormData(this);
    formData.append('amount', Math.round(<?= $grandTotal ?> * 100));
    fetch('<?= $base_url ?>checkout/create-payment-intent', {
        method: 'POST',
        body: formData
    })
    .then(function(r) { return r.json() })
    .then(function(data) {
        if (data.error) {
            document.getElementById('card-errors').textContent = data.error;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock"></i> Place Order — $<?= number_format($grandTotal, 2) ?>';
            return;
        }
        return stripe.confirmCardPayment(data.client_secret, {
            payment_method: {
                card: card,
                billing_details: { name: document.getElementById('cardholder-name').value }
            }
        });
    })
    .then(function(result) {
        if (!result) return;
        if (result.error) {
            document.getElementById('card-errors').textContent = result.error.message;
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-lock"></i> Place Order — $<?= number_format($grandTotal, 2) ?>';
        } else {
            if (result.paymentIntent.status === 'succeeded') {
                document.getElementById('payment_intent_id').value = result.paymentIntent.id;
                var form = document.getElementById('checkoutForm');
                var hiddenMeans = document.createElement('input');
                hiddenMeans.type = 'hidden';
                hiddenMeans.name = 'payment_method';
                hiddenMeans.value = 'Credit Card';
                form.appendChild(hiddenMeans);
                form.submit();
            }
        }
    })
    .catch(function(err) {
        document.getElementById('card-errors').textContent = 'An unexpected error occurred.';
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-lock"></i> Place Order — $<?= number_format($grandTotal, 2) ?>';
    });
});
</script>
</body>
</html>
