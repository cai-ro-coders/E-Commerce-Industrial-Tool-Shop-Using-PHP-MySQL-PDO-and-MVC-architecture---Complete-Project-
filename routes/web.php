<?php

use Routes\Router;

Router::get('/', ['HomeController', 'index']);
Router::get('/about', ['AboutController', 'index']);
Router::get('/contact', ['ContactController', 'index']);
Router::post('/contact/send', ['ContactController', 'send']);
Router::get('/collections/all', ['CollectionController', 'all']);
Router::get('/collections/{slug}', ['CollectionController', 'show']);
Router::get('/products/{slug}', ['CatalogController', 'show']);
Router::get('/login', ['AuthController', 'loginForm']);
Router::post('/login', ['AuthController', 'login']);
Router::get('/logout', ['AuthController', 'logout']);
Router::getPost('/forgot-password', ['AuthController', 'forgotPassword']);
Router::getPost('/reset-password/{token}', ['AuthController', 'resetPassword']);
Router::get('/customer/login', ['CustomerAuthController', 'loginForm']);
Router::post('/customer/login', ['CustomerAuthController', 'login']);
Router::get('/customer/register', ['CustomerAuthController', 'registerForm']);
Router::post('/customer/register', ['CustomerAuthController', 'register']);
Router::get('/customer/my-account', ['CustomerAccountController', 'index']);
Router::post('/customer/my-account/edit', ['CustomerAccountController', 'updateDetails']);
Router::get('/customer/order/{order_number}', ['CustomerAccountController', 'showOrder']);
Router::post('/customer/address/save', ['CustomerAccountController', 'saveAddress']);
Router::post('/customer/notifications/read', ['CustomerAccountController', 'markNotificationsRead']);
Router::post('/wishlist/toggle', ['CatalogController', 'toggleWishlist']);
Router::post('/cart/add', ['CatalogController', 'addToCart']);
Router::post('/cart/remove', ['CatalogController', 'removeFromCart']);
Router::get('/cart/json', ['CatalogController', 'cartJson']);
Router::get('/checkout', ['CheckoutController', 'index']);
Router::post('/checkout/place-order', ['CheckoutController', 'placeOrder']);
Router::post('/checkout/create-payment-intent', ['CheckoutController', 'createPaymentIntent']);
Router::post('/checkout/create-paypal-order', ['CheckoutController', 'createPayPalOrder']);
Router::post('/checkout/capture-paypal-order', ['CheckoutController', 'capturePayPalOrder']);

Router::group('/admin', function () {
    Router::get('/dashboard', ['DashboardController', 'index']);
    
    Router::get('/profile', ['ProfileController', 'index']);
    Router::post('/profile', ['ProfileController', 'update']);
    Router::getPost('/change-password', ['ProfileController', 'changePassword']);
    
    Router::get('/products', ['ProductController', 'index']);
    Router::get('/products/create', ['ProductController', 'create']);
    Router::post('/products/store', ['ProductController', 'store']);
    Router::get('/products/edit/{id}', ['ProductController', 'edit']);
    Router::post('/products/update/{id}', ['ProductController', 'update']);
    Router::get('/products/view/{id}', ['ProductController', 'show']);
    Router::post('/products/delete/{id}', ['ProductController', 'delete']);
    Router::get('/products/export/{type}', ['ProductController', 'export']);
    
    Router::get('/orders', ['OrderController', 'index']);
    Router::get('/orders/view/{id}', ['OrderController', 'show']);
    Router::getPost('/orders/edit/{id}', ['OrderController', 'edit']);
    Router::post('/orders/delete/{id}', ['OrderController', 'delete']);
    Router::get('/orders/print/{id}', ['OrderController', 'printReceipt']);
    Router::get('/orders/export/csv', ['OrderController', 'exportCsv']);
    
    Router::get('/customers', ['CustomerController', 'index']);
    Router::get('/customers/create', ['CustomerController', 'create']);
    Router::post('/customers/store', ['CustomerController', 'store']);
    Router::get('/customers/edit/{id}', ['CustomerController', 'edit']);
    Router::post('/customers/update/{id}', ['CustomerController', 'update']);
    Router::get('/customers/view/{id}', ['CustomerController', 'show']);
    Router::post('/customers/delete/{id}', ['CustomerController', 'delete']);
    
    Router::get('/categories', ['CategoryController', 'index']);
    Router::get('/categories/create', ['CategoryController', 'create']);
    Router::post('/categories/store', ['CategoryController', 'store']);
    Router::get('/categories/edit/{id}', ['CategoryController', 'edit']);
    Router::post('/categories/update/{id}', ['CategoryController', 'update']);
    Router::post('/categories/delete/{id}', ['CategoryController', 'delete']);
    
    Router::get('/brands', ['BrandController', 'index']);
    Router::get('/brands/create', ['BrandController', 'create']);
    Router::post('/brands/store', ['BrandController', 'store']);
    Router::get('/brands/edit/{id}', ['BrandController', 'edit']);
    Router::post('/brands/update/{id}', ['BrandController', 'update']);
    Router::post('/brands/delete/{id}', ['BrandController', 'delete']);
    
    Router::get('/coupons', ['CouponController', 'index']);
    Router::get('/coupons/create', ['CouponController', 'create']);
    Router::post('/coupons/store', ['CouponController', 'store']);
    Router::get('/coupons/edit/{id}', ['CouponController', 'edit']);
    Router::post('/coupons/update/{id}', ['CouponController', 'update']);
    Router::post('/coupons/delete/{id}', ['CouponController', 'delete']);
    
    Router::get('/settings', ['SettingController', 'index']);
    Router::post('/settings/update', ['SettingController', 'update']);
    
    Router::get('/reviews', ['ReviewController', 'index']);
    Router::getPost('/reviews/edit/{id}', ['ReviewController', 'edit']);
    Router::post('/reviews/delete/{id}', ['ReviewController', 'delete']);
});
