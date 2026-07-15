<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    public function loginForm()
    {
        if (is_logged_in()) {
            $this->redirect('admin/dashboard');
        }
        $this->data['title'] = 'Login';
        $this->render('auth/login', [], 'auth');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token. Please try again.');
            $this->redirect('login');
        }

        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            set_old_input($_POST);
            $this->redirect('login');
        }

        $email = sanitize($_POST['email']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);

        $user = new User();
        $record = $user->findBy('email', $email);

        if (!$record || !password_verify($password, $record['password'])) {
            flash('error', 'Invalid email or password');
            set_old_input($_POST);
            $this->redirect('login');
        }

        if (isset($record['status']) && $record['status'] !== 'active' && $record['status'] != 1) {
            flash('error', 'Your account has been deactivated');
            $this->redirect('login');
        }

        $_SESSION['user_id'] = $record['id'];
        $_SESSION['user_name'] = $record['name'];
        $_SESSION['user_email'] = $record['email'];
        $_SESSION['user_role'] = $record['role'];

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
            $user->update($record['id'], [
                'remember_token' => $token
            ]);
            setcookie('remember_token', $token, time() + 86400 * 30, '/', '', false, true);
            setcookie('remember_user_id', $record['id'], time() + 86400 * 30, '/', '', false, true);
        }

        flash('success', 'Welcome back, ' . $record['name'] . '!');
        $this->redirect('admin/dashboard');
    }

    public function logout()
    {
        $role = $_SESSION['user_role'] ?? '';
        $name = $_SESSION['user_name'] ?? '';

        if (isset($_SESSION['user_id'])) {
            $user = new User();
            $user->update($_SESSION['user_id'], ['remember_token' => null]);
        }

        $_SESSION = [];
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        setcookie('remember_user_id', '', time() - 3600, '/');

        session_start();
        $_SESSION['_flash']['success'] = $name ? 'Goodbye, ' . $name . '!' : 'You have been logged out successfully';

        $this->redirect($role === 'customer' ? 'customer/login' : 'login');
    }

    public function forgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
            if (!verify_csrf($token)) {
                flash('error', 'Invalid security token');
                $this->redirect('forgot-password');
            }

            $rules = ['email' => 'required|email'];
            $errors = $this->validate($_POST, $rules);

            if (!empty($errors)) {
                flash('error', 'Please enter a valid email address');
                $this->redirect('forgot-password');
            }

            $email = sanitize($_POST['email']);
            $user = new User();
            $record = $user->findBy('email', $email);

            if ($record) {
                $resetToken = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
                $user->update($record['id'], [
                    'reset_token' => $resetToken,
                    'reset_token_expires' => $expires
                ]);
            }

            flash('success', 'If the email exists in our system, a password reset link has been generated. Please check your email.');
            $this->redirect('forgot-password');
        }

        $this->data['title'] = 'Forgot Password';
        $this->render('auth/forgot', [], 'auth');
    }

    public function resetPassword($token)
    {
        $user = new User();
        $record = $user->findBy('reset_token', $token);

        if (!$record || !isset($record['reset_token_expires'])) {
            flash('error', 'Invalid or missing reset token');
            $this->redirect('login');
        }

        if (strtotime($record['reset_token_expires']) < time()) {
            flash('error', 'Reset token has expired. Please request a new one.');
            $this->redirect('forgot-password');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf = $_POST['_csrf_token'] ?? '';
            if (!verify_csrf($csrf)) {
                flash('error', 'Invalid security token');
                $this->redirect('reset-password/' . $token);
            }

            $rules = [
                'password' => 'required|min:8',
                'password_confirm' => 'required'
            ];
            $errors = $this->validate($_POST, $rules);

            if (!empty($errors)) {
                $msg = reset($errors)[0];
                flash('error', $msg);
                $this->redirect('reset-password/' . $token);
            }

            if ($_POST['password'] !== $_POST['password_confirm']) {
                flash('error', 'Passwords do not match');
                $this->redirect('reset-password/' . $token);
            }

            $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $user->update($record['id'], [
                'password' => $hashed,
                'reset_token' => null,
                'reset_token_expires' => null
            ]);

            flash('success', 'Your password has been reset successfully. Please login with your new password.');
            $this->redirect('login');
        }

        $this->data['title'] = 'Reset Password';
        $this->data['token'] = $token;
        $this->render('auth/reset', [], 'auth');
    }
}
