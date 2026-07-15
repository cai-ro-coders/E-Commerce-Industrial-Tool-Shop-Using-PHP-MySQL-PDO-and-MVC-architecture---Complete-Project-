<?php

namespace App\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        $this->data['title'] = 'Contact Us';

        $this->view('contact/index');
    }

    public function send()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('contact');
        }

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ];
        $errors = $this->validate($_POST, $rules);

        if (!empty($errors)) {
            flash('error', 'Please fill in all required fields');
            $this->redirect('contact');
        }

        $name = sanitize($_POST['name']);
        $email = sanitize($_POST['email']);
        $subject = sanitize($_POST['subject']);
        $message = sanitize($_POST['message']);

        $this->db->query(
            "CREATE TABLE IF NOT EXISTS contact_messages (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                is_read TINYINT(1) NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB"
        );
        $this->db->query(
            "INSERT INTO contact_messages (name, email, subject, message, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())",
            [$name, $email, $subject, $message]
        );

        flash('success', 'Thank you for your message. We will get back to you soon.');
        $this->redirect('contact');
    }
}
