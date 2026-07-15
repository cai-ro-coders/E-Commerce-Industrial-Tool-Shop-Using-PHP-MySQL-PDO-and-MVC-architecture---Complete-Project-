<?php

namespace App\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $user = new User();
        $record = $user->find($userId);

        if (!$record) {
            flash('error', 'User not found');
            $this->redirect('login');
        }

        $this->data['title'] = 'My Profile';
        $this->data['profile'] = $record;
        $this->render('admin/profile/index');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/profile');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/profile');
        }

        $userId = $_SESSION['user_id'] ?? 0;
        $user = new User();
        $record = $user->find($userId);

        if (!$record) {
            flash('error', 'User not found');
            $this->redirect('login');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email'
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            $msg = reset($errors)[0];
            flash('error', $msg);
            $this->back();
        }

        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $phone = sanitize($_POST['phone'] ?? '');

        $existing = $user->findBy('email', $email);
        if ($existing && $existing['id'] != $userId) {
            flash('error', 'Email is already in use by another account');
            $this->back();
        }

        $data = [
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['avatar'], 'avatars');
            if ($upload['success']) {
                if (!empty($record['avatar'])) {
                    $this->deleteFile($record['avatar']);
                }
                $data['avatar'] = $upload['filename'];
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $user->update($userId, $data);
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        flash('success', 'Profile updated successfully');
        $this->redirect('admin/profile');
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf_token'] ?? '';
            if (!verify_csrf($token)) {
                flash('error', 'Invalid security token');
                $this->redirect('admin/change-password');
            }

            $rules = [
                'current_password' => 'required',
                'new_password' => 'required|min:8',
                'confirm_password' => 'required'
            ];
            $errors = $this->validate($_POST, $rules);

            if (!empty($errors)) {
                $msg = reset($errors)[0];
                flash('error', $msg);
                $this->redirect('admin/change-password');
            }

            $userId = $_SESSION['user_id'] ?? 0;
            $user = new User();
            $record = $user->find($userId);

            if (!$record) {
                flash('error', 'User not found');
                $this->redirect('login');
            }

            if (!password_verify($_POST['current_password'], $record['password'])) {
                flash('error', 'Current password is incorrect');
                $this->redirect('admin/change-password');
            }

            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                flash('error', 'New passwords do not match');
                $this->redirect('admin/change-password');
            }

            if ($_POST['current_password'] === $_POST['new_password']) {
                flash('error', 'New password must be different from current password');
                $this->redirect('admin/change-password');
            }

            $hashed = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            $user->update($userId, ['password' => $hashed]);

            flash('success', 'Password changed successfully');
            $this->redirect('admin/change-password');
        }

        $this->data['title'] = 'Change Password';
        $this->render('admin/profile/change_password');
    }
}
