<?php

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/autoload.php';
require_once __DIR__ . '/app/helpers/functions.php';

session_start();

use Routes\Router;

require_once __DIR__ . '/routes/web.php';

$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';
Router::dispatch($url);
