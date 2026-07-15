<?php

namespace App\Controllers;

use Stripe\Stripe;
use Stripe\PaymentIntent;

class CheckoutController extends Controller
{
    public function index()
    {
        require_login();

        $userId = $_SESSION['user_id'];

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.name, p.slug, p.price, p.sale_price, p.stock_quantity,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?
             ORDER BY ci.id ASC",
            [$userId]
        );

        if (empty($cartItems)) {
            $this->redirect('customer/my-account?tab=cart');
        }

        $subtotal = 0;
        foreach ($cartItems as &$item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $item['unit_price'] = $price;
            $item['line_total'] = round($price * (int)$item['quantity'], 2);
            $subtotal += $item['line_total'];
        }
        unset($item);

        $user = $this->db->fetch("SELECT * FROM users WHERE id = ?", [$userId]);

        $addresses = $this->db->fetchAll(
            "SELECT * FROM addresses WHERE user_id = ? ORDER BY is_default DESC, id ASC",
            [$userId]
        );

        $defaultAddress = null;
        foreach ($addresses as $addr) {
            if ($addr['is_default']) {
                $defaultAddress = $addr;
                break;
            }
        }
        if (!$defaultAddress && !empty($addresses)) {
            $defaultAddress = $addresses[0];
        }

        $this->data['title'] = 'Checkout';
        $this->data['cart_items'] = $cartItems;
        $this->data['subtotal'] = $subtotal;
        $this->data['user'] = $user;
        $this->data['addresses'] = $addresses;
        $this->data['default_address'] = $defaultAddress;

        $this->view('checkout/index');
    }

    public function createPaymentIntent()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request'], 405);
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            $this->json(['error' => 'Invalid security token'], 403);
        }

        $userId = $_SESSION['user_id'];

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.price, p.sale_price
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );

        if (empty($cartItems)) {
            $this->json(['error' => 'Your cart is empty'], 400);
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $subtotal += $price * (int)$item['quantity'];
        }

        $shipping = $subtotal < 100 ? 9.99 : 0;
        $tax = round($subtotal * 0.08, 2);
        $grandTotal = round($subtotal + $shipping + $tax, 2);

        try {
            Stripe::setApiKey(STRIPE_SECRET_KEY);
            $intent = PaymentIntent::create([
                'amount' => (int)round($grandTotal * 100),
                'currency' => 'usd',
                'metadata' => ['user_id' => (string)$userId],
            ]);
            $this->json(['client_secret' => $intent->client_secret]);
        } catch (\Exception $e) {
            $this->json(['error' => 'Payment service error. Please try again.'], 500);
        }
    }

    public function placeOrder()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('checkout');
        }

        $userId = $_SESSION['user_id'];

        $paymentIntentId = sanitize($_POST['payment_intent_id'] ?? '');
        if (!empty($paymentIntentId)) {
            try {
                Stripe::setApiKey(STRIPE_SECRET_KEY);
                $intent = PaymentIntent::retrieve($paymentIntentId);
                if ($intent->status !== 'succeeded') {
                    flash('error', 'Payment was not successful. Please try again.');
                    $this->redirect('checkout');
                }
            } catch (\Exception $e) {
                flash('error', 'Payment verification failed. Please try again.');
                $this->redirect('checkout');
            }
        }

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.name, p.sku, p.price, p.sale_price
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );

        if (empty($cartItems)) {
            flash('error', 'Your cart is empty');
            $this->redirect('checkout');
        }

        $rules = [
            'full_name' => 'required',
            'phone' => 'required',
            'address_line_1' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
            'payment_method' => 'required',
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            $this->redirect('checkout');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $subtotal += $price * (int)$item['quantity'];
        }

        $shipping = 0;
        if ($subtotal < 100) {
            $shipping = 9.99;
        }
        $tax = round($subtotal * 0.08, 2);
        $grandTotal = round($subtotal + $shipping + $tax, 2);

        $addressId = null;
        $existingAddr = $this->db->fetch(
            "SELECT id FROM addresses WHERE user_id = ? AND full_name = ? AND address_line_1 = ? AND city = ? AND province = ? AND postal_code = ? AND country = ?",
            [$userId, sanitize($_POST['full_name']), sanitize($_POST['address_line_1']), sanitize($_POST['city']), sanitize($_POST['province']), sanitize($_POST['postal_code']), sanitize($_POST['country'])]
        );
        if ($existingAddr) {
            $addressId = $existingAddr['id'];
        } else {
            $this->db->query(
                "INSERT INTO addresses (user_id, full_name, phone, address_line_1, address_line_2, city, province, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                [$userId, sanitize($_POST['full_name']), sanitize($_POST['phone']), sanitize($_POST['address_line_1']), sanitize($_POST['address_line_2'] ?? ''), sanitize($_POST['city']), sanitize($_POST['province']), sanitize($_POST['postal_code']), sanitize($_POST['country'])]
            );
            $addressId = $this->db->lastInsertId();
        }

        $orderNumber = 'ORD-' . strtoupper(uniqid());
        $paymentStatus = !empty($paymentIntentId) ? 'Paid' : 'Pending';
        $this->db->query(
            "INSERT INTO orders (order_number, user_id, grand_total, subtotal, shipping_fee, tax, order_status, payment_status, payment_method, shipping_address_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?, NOW(), NOW())",
            [$orderNumber, $userId, $grandTotal, $subtotal, $shipping, $tax, $paymentStatus, sanitize($_POST['payment_method']), $addressId]
        );
        $orderId = $this->db->lastInsertId();

        if (!empty($paymentIntentId)) {
            $this->db->query(
                "INSERT INTO payments (order_id, transaction_id, payment_gateway, amount, currency, status, paid_at, created_at, updated_at) VALUES (?, ?, 'stripe', ?, 'USD', 'Paid', NOW(), NOW(), NOW())",
                [$orderId, $paymentIntentId, $grandTotal]
            );
        }

        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $total = round($price * (int)$item['quantity'], 2);
            $this->db->query(
                "INSERT INTO order_items (order_id, product_id, product_name, sku, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['name'], $item['sku'], (int)$item['quantity'], $price, $total]
            );
        }

        $cart = $this->db->fetch("SELECT id FROM carts WHERE user_id = ?", [$userId]);
        if ($cart) {
            $this->db->query("DELETE FROM cart_items WHERE cart_id = ?", [$cart['id']]);
        }

        flash('success', 'Your order has been placed successfully! Order #: ' . $orderNumber);
        $this->redirect('customer/order/' . $orderNumber);
    }

    private function payPalAccessToken()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, PAYPAL_MODE === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com/v1/oauth2/token'
            : 'https://api-m.paypal.com/v1/oauth2/token');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, PAYPAL_CLIENT_ID . ':' . PAYPAL_SECRET);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            return null;
        }

        $data = json_decode($result, true);
        return $data['access_token'] ?? null;
    }

    private function payPalRequest($endpoint, $data, $accessToken)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, (PAYPAL_MODE === 'sandbox'
            ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com') . $endpoint);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken,
        ]);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } else {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        }
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        return ['code' => $httpCode, 'body' => json_decode($result, true), 'curl_error' => $error];
    }

    public function createPayPalOrder()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request'], 405);
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            $this->json(['error' => 'Invalid security token'], 403);
        }

        $userId = $_SESSION['user_id'];

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.price, p.sale_price
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );

        if (empty($cartItems)) {
            $this->json(['error' => 'Your cart is empty'], 400);
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $subtotal += $price * (int)$item['quantity'];
        }
        $shipping = $subtotal < 100 ? 9.99 : 0;
        $tax = round($subtotal * 0.08, 2);
        $grandTotal = round($subtotal + $shipping + $tax, 2);

        $accessToken = $this->payPalAccessToken();
        if (!$accessToken) {
            $this->json(['error' => 'PayPal authentication failed'], 500);
        }

        $orderData = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => number_format($grandTotal, 2, '.', ''),
                    'breakdown' => [
                        'item_total' => [
                            'currency_code' => 'USD',
                            'value' => number_format($subtotal, 2, '.', ''),
                        ],
                        'shipping' => [
                            'currency_code' => 'USD',
                            'value' => number_format($shipping, 2, '.', ''),
                        ],
                        'tax_total' => [
                            'currency_code' => 'USD',
                            'value' => number_format($tax, 2, '.', ''),
                        ],
                    ],
                ],
            ]],
        ];

        $result = $this->payPalRequest('/v2/checkout/orders', $orderData, $accessToken);

        if ($result['code'] !== 201) {
            $msg = 'Failed to create PayPal order';
            if (isset($result['body']['message'])) $msg .= ': ' . $result['body']['message'];
            $this->json(['error' => $msg], 500);
        }

        $this->json(['order_id' => $result['body']['id']]);
    }

    public function capturePayPalOrder()
    {
        require_login();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['error' => 'Invalid request'], 405);
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            $this->json(['error' => 'Invalid security token'], 403);
        }

        $paypalOrderId = sanitize($_POST['paypal_order_id'] ?? '');
        if (empty($paypalOrderId)) {
            $this->json(['error' => 'Missing PayPal order ID'], 400);
        }

        $accessToken = $this->payPalAccessToken();
        if (!$accessToken) {
            $this->json(['error' => 'PayPal authentication failed'], 500);
        }

        $result = $this->payPalRequest(
            '/v2/checkout/orders/' . $paypalOrderId . '/capture',
            [],
            $accessToken
        );

        if ($result['code'] !== 201) {
            $msg = 'Failed to capture PayPal order';
            if (isset($result['body']['message'])) $msg .= ': ' . $result['body']['message'];
            if (isset($result['body']['details'][0]['description'])) $msg .= ': ' . $result['body']['details'][0]['description'];
            $this->json(['error' => $msg], 500);
        }

        $capture = $result['body'];
        if (($capture['status'] ?? '') !== 'COMPLETED') {
            $this->json(['error' => 'PayPal payment was not completed'], 400);
        }

        $userId = $_SESSION['user_id'];

        $cartItems = $this->db->fetchAll(
            "SELECT ci.*, p.name, p.sku, p.price, p.sale_price
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );

        if (empty($cartItems)) {
            $this->json(['error' => 'Your cart is empty'], 400);
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $subtotal += $price * (int)$item['quantity'];
        }
        $shipping = $subtotal < 100 ? 9.99 : 0;
        $tax = round($subtotal * 0.08, 2);
        $grandTotal = round($subtotal + $shipping + $tax, 2);

        $addressId = null;
        $fullName = sanitize($_POST['full_name'] ?? '');
        $phone = sanitize($_POST['phone'] ?? '');
        $addr1 = sanitize($_POST['address_line_1'] ?? '');
        $addr2 = sanitize($_POST['address_line_2'] ?? '');
        $city = sanitize($_POST['city'] ?? '');
        $province = sanitize($_POST['province'] ?? '');
        $postal = sanitize($_POST['postal_code'] ?? '');
        $country = sanitize($_POST['country'] ?? '');

        if ($fullName && $addr1 && $city) {
            $existingAddr = $this->db->fetch(
                "SELECT id FROM addresses WHERE user_id = ? AND full_name = ? AND address_line_1 = ? AND city = ? AND province = ? AND postal_code = ? AND country = ?",
                [$userId, $fullName, $addr1, $city, $province, $postal, $country]
            );
            if ($existingAddr) {
                $addressId = $existingAddr['id'];
            } else {
                $this->db->query(
                    "INSERT INTO addresses (user_id, full_name, phone, address_line_1, address_line_2, city, province, postal_code, country) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [$userId, $fullName, $phone, $addr1, $addr2, $city, $province, $postal, $country]
                );
                $addressId = $this->db->lastInsertId();
            }
        }

        $orderNumber = 'ORD-' . strtoupper(uniqid());
        $this->db->query(
            "INSERT INTO orders (order_number, user_id, grand_total, subtotal, shipping_fee, tax, order_status, payment_status, payment_method, shipping_address_id, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, 'Pending', 'Paid', 'PayPal', ?, NOW(), NOW())",
            [$orderNumber, $userId, $grandTotal, $subtotal, $shipping, $tax, $addressId]
        );
        $orderId = $this->db->lastInsertId();

        $this->db->query(
            "INSERT INTO payments (order_id, transaction_id, payment_gateway, amount, currency, status, paid_at, created_at, updated_at) VALUES (?, ?, 'paypal', ?, 'USD', 'Paid', NOW(), NOW(), NOW())",
            [$orderId, $paypalOrderId, $grandTotal]
        );

        foreach ($cartItems as $item) {
            $price = ($item['sale_price'] && $item['sale_price'] < $item['price']) ? $item['sale_price'] : $item['price'];
            $total = round($price * (int)$item['quantity'], 2);
            $this->db->query(
                "INSERT INTO order_items (order_id, product_id, product_name, sku, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?, ?)",
                [$orderId, $item['product_id'], $item['name'], $item['sku'], (int)$item['quantity'], $price, $total]
            );
        }

        $cart = $this->db->fetch("SELECT id FROM carts WHERE user_id = ?", [$userId]);
        if ($cart) {
            $this->db->query("DELETE FROM cart_items WHERE cart_id = ?", [$cart['id']]);
        }

        $this->json(['success' => true, 'order_number' => $orderNumber]);
    }
}
