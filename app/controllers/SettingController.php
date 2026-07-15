<?php

namespace App\Controllers;

class SettingController extends Controller
{
    public function index()
    {
        require_admin();

        $settings = $this->db->fetchAll("SELECT * FROM settings ORDER BY `group` ASC, `key` ASC");

        $groups = [];
        foreach ($settings as $s) {
            $groups[$s['group']][] = $s;
        }

        $this->data['title'] = 'Settings';
        $this->data['groups'] = $groups;

        $this->render('admin/settings/index');
    }

    public function update()
    {
        require_admin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('admin/settings');
        }

        $token = $_POST['_csrf_token'] ?? '';
        if (!verify_csrf($token)) {
            flash('error', 'Invalid security token');
            $this->redirect('admin/settings');
        }

        if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
            $upload = $this->uploadFile($_FILES['site_logo'], 'settings');
            if ($upload['success']) {
                $existingLogo = $this->db->fetch("SELECT `value` FROM settings WHERE `key` = 'site_logo'");
                if ($existingLogo && $existingLogo['value']) {
                    $this->deleteFile($existingLogo['value']);
                }
                $this->db->update("UPDATE settings SET `value` = ?, updated_at = NOW() WHERE `key` = 'site_logo'", [$upload['filename']]);
                if ($this->db->query("SELECT ROW_COUNT()")->fetch()['ROW_COUNT()'] == 0) {
                    $this->db->insert("INSERT INTO settings (`key`, `group`, `value`, created_at, updated_at) VALUES ('site_logo', 'general', ?, NOW(), NOW())", [$upload['filename']]);
                }
            } else {
                flash('error', $upload['error']);
                $this->back();
            }
        }

        $settings = $_POST['settings'] ?? [];
        foreach ($settings as $key => $value) {
            $key = trim($key);
            if (empty($key)) continue;
            $value = sanitize($value);

            $existing = $this->db->fetch("SELECT id FROM settings WHERE `key` = ?", [$key]);
            if ($existing) {
                $this->db->update("UPDATE settings SET `value` = ?, updated_at = NOW() WHERE `key` = ?", [$value, $key]);
            } else {
                $this->db->insert("INSERT INTO settings (`key`, `group`, `value`, created_at, updated_at) VALUES (?, 'general', ?, NOW(), NOW())", [$key, $value]);
            }
        }

        flash('success', 'Settings updated successfully');
        $this->redirect('admin/settings');
    }
}
