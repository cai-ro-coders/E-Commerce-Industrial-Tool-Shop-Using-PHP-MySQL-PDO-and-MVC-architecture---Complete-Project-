<?php

namespace Routes;

class Router
{
    private static $routes = [];
    private static $currentGroup = '';

    public static function group($prefix, $callback)
    {
        $previousGroup = self::$currentGroup;
        self::$currentGroup .= $prefix;
        $callback();
        self::$currentGroup = $previousGroup;
    }

    public static function get($path, $handler)
    {
        self::addRoute('GET', $path, $handler);
    }

    public static function post($path, $handler)
    {
        self::addRoute('POST', $path, $handler);
    }

    public static function getPost($path, $handler)
    {
        self::addRoute('GET', $path, $handler);
        self::addRoute('POST', $path, $handler);
    }

    private static function addRoute($method, $path, $handler)
    {
        $fullPath = self::$currentGroup . $path;
        self::$routes[] = [
            'method' => $method,
            'path' => $fullPath,
            'handler' => $handler
        ];
    }

    public static function dispatch($url)
    {
        $url = parse_url($url, PHP_URL_PATH);
        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        
        if ($basePath && strpos($url, $basePath) === 0) {
            $url = substr($url, strlen($basePath));
        }
        
        $url = '/' . trim($url, '/');
        if ($url === '/') {
            $url = '/';
        }
        
        $method = $_SERVER['REQUEST_METHOD'];
        $matched = false;

        foreach (self::$routes as $route) {
            $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $url, $matches)) {
                $matched = true;
                array_shift($matches);
                
                $handler = $route['handler'];
                
                if (is_array($handler)) {
                    list($controller, $action) = $handler;
                    $controllerClass = "\\App\\Controllers\\{$controller}";
                    
                    if (!class_exists($controllerClass)) {
                        die("Controller not found: {$controllerClass}");
                    }
                    
                    $controllerInstance = new $controllerClass();
                    
                    if (!method_exists($controllerInstance, $action)) {
                        die("Action not found: {$controller}::{$action}");
                    }
                    
                    call_user_func_array([$controllerInstance, $action], $matches);
                } elseif (is_callable($handler)) {
                    call_user_func_array($handler, $matches);
                }
                
                break;
            }
        }

        if (!$matched) {
            http_response_code(404);
            require dirname(__DIR__) . '/app/views/errors/404.php';
        }
    }
}
