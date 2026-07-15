<?php

namespace App\Controllers;

use App\Helpers\Database;

abstract class Controller
{
    protected $db;
    protected $data = [];

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->data['app_name'] = APP_NAME;
        $this->data['base_url'] = BASE_URL;
        $this->data['assets_url'] = ASSETS_URL;
        $this->data['uploads_url'] = UPLOADS_URL;
        $this->data['current_user'] = $this->getCurrentUser();
        $this->data['settings'] = $this->getSettings();
    }

    protected function getCurrentUser()
    {
        if (isset($_SESSION['user_id'])) {
            $sql = "SELECT * FROM users WHERE id = ?";
            return $this->db->fetch($sql, [$_SESSION['user_id']]);
        }
        return null;
    }

    protected function getSettings()
    {
        $settings = $this->db->fetchAll("SELECT `key`, `value` FROM settings");
        $result = [];
        foreach ($settings as $s) {
            $result[$s['key']] = $s['value'];
        }
        return $result;
    }

    protected function view($view, $data = [])
    {
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        
        $viewPath = dirname(__DIR__) . "/views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View not found: {$view}");
        }
        
        require $viewPath;
    }

    protected function render($view, $data = [], $layout = 'admin')
    {
        $this->data = array_merge($this->data, $data);
        $this->data['content_view'] = $view;
        
        extract($this->data);
        
        $layoutPath = dirname(__DIR__) . "/views/layouts/{$layout}.php";
        if (!file_exists($layoutPath)) {
            die("Layout not found: {$layout}");
        }
        
        require $layoutPath;
    }

    protected function json($data, $code = 200)
    {
        json_response($data, $code);
    }

    protected function redirect($url)
    {
        redirect($url);
    }

    protected function back()
    {
        back();
    }

    protected function validate($data, $rules)
    {
        $errors = [];
        foreach ($rules as $field => $ruleSet) {
            $ruleList = explode('|', $ruleSet);
            foreach ($ruleList as $rule) {
                if ($rule === 'required' && empty($data[$field])) {
                    $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' is required';
                }
                if (strpos($rule, 'min:') === 0) {
                    $min = explode(':', $rule)[1];
                    if (isset($data[$field]) && strlen($data[$field]) < $min) {
                        $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' must be at least ' . $min . ' characters';
                    }
                }
                if (strpos($rule, 'max:') === 0) {
                    $max = explode(':', $rule)[1];
                    if (isset($data[$field]) && strlen($data[$field]) > $max) {
                        $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' must not exceed ' . $max . ' characters';
                    }
                }
                if ($rule === 'email' && !empty($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                    $errors[$field][] = 'Invalid email format';
                }
                if ($rule === 'numeric' && isset($data[$field]) && !is_numeric($data[$field])) {
                    $errors[$field][] = ucfirst(str_replace('_', ' ', $field)) . ' must be numeric';
                }
            }
        }
        return $errors;
    }

    protected function generateSlug($string)
    {
        return generate_slug($string);
    }

    protected function uploadFile($file, $directory = 'images')
    {
        return upload_file($file, $directory);
    }

    protected function deleteFile($path)
    {
        delete_file($path);
    }
}
