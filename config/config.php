<?php

define('DB_HOST', 'localhost');
define('DB_NAME', 'ecommercedb');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_CHARSET', 'utf8mb4');

define('BASE_URL', 'http://localhost:8888/devproject/eCommerce/');
define('ASSETS_URL', BASE_URL . 'public/assets/');
define('UPLOADS_URL', BASE_URL . 'public/uploads/');

define('APP_NAME', 'Industrial Tool Shop');
define('APP_DEBUG', true);

define('TIMEZONE', 'America/Toronto');

define('STRIPE_PUBLISHABLE_KEY', 'test');
define('STRIPE_SECRET_KEY', 'test');

define('PAYPAL_CLIENT_ID', 'test');
define('PAYPAL_SECRET', 'test');
define('PAYPAL_MODE', 'sandbox');
date_default_timezone_set(TIMEZONE);

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
