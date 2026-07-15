<?php

namespace App\Controllers;

use App\Models\User;

class CustomerAuthController extends Controller
{
    public function loginForm()
    {
        if (is_logged_in()) {
            $this->redirect('customer/my-account');
        }
        $this->data['title'] = 'Customer Login';
        $this->view('customer/login');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/login');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('customer/login');
        }

        $rules = ['email' => 'required|email', 'password' => 'required'];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            set_old_input($_POST);
            $this->redirect('customer/login');
        }

        $email = sanitize($_POST['email']);
        $password = $_POST['password'];

        $user = new User();
        $record = $user->findBy('email', $email);

        if (!$record || !password_verify($password, $record['password'])) {
            flash('error', 'Invalid email or password');
            set_old_input($_POST);
            $this->redirect('customer/login');
        }

        if (isset($record['status']) && $record['status'] !== 'active' && $record['status'] != 1) {
            flash('error', 'Your account has been deactivated');
            $this->redirect('customer/login');
        }

        $_SESSION['user_id'] = $record['id'];
        $_SESSION['user_name'] = $record['name'];
        $_SESSION['user_email'] = $record['email'];
        $_SESSION['user_role'] = $record['role'];

        flash('success', 'Welcome back, ' . $record['name'] . '!');
        $this->redirect('customer/my-account');
    }

    public function registerForm()
    {
        if (is_logged_in()) {
            $this->redirect('customer/my-account');
        }
        $this->data['title'] = 'Create Account';
        $this->view('customer/register');
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer/register');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('customer/register');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'password_confirm' => 'required'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            set_old_input($_POST);
            $this->redirect('customer/register');
        }

        if ($_POST['password'] !== $_POST['password_confirm']) {
            flash('error', 'Passwords do not match');
            set_old_input($_POST);
            $this->redirect('customer/register');
        }

        $email = sanitize($_POST['email']);
        $existing = new User();
        if ($existing->findBy('email', $email)) {
            flash('error', 'An account with this email already exists');
            set_old_input($_POST);
            $this->redirect('customer/register');
        }

        $user = new User();
        $userId = $user->create([
            'name' => sanitize($_POST['name']),
            'email' => $email,
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'phone' => sanitize($_POST['phone'] ?? ''),
            'role' => 'customer',
            'status' => 1
        ]);

        if (!$userId) {
            flash('error', 'Failed to create account. Please try again.');
            $this->redirect('customer/register');
        }

        $_SESSION['user_id'] = $userId;
        $_SESSION['user_name'] = sanitize($_POST['name']);
        $_SESSION['user_email'] = $email;
        $_SESSION['user_role'] = 'customer';

        flash('success', 'Account created successfully! Welcome, ' . sanitize($_POST['name']) . '!');
        $this->redirect('customer/my-account');
    }
}
