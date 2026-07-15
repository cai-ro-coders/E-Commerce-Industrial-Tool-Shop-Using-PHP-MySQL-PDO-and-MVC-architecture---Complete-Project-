<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?> — ToolShop</title>
    <meta name="description" content="Get in touch with ToolShop. We'd love to hear from you.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/home.css" rel="stylesheet">
    <link href="<?= $assets_url ?>css/contact.css" rel="stylesheet">
</head>
<body>

<?php require dirname(__DIR__) . '/partials/header.php'; ?>

<section class="contact-hero">
    <div class="contact-hero-bg"></div>
    <div class="contact-hero-overlay"></div>
    <div class="contact-hero-content">
        <h1 class="contact-hero-title">Get in Touch</h1>
        <p class="contact-hero-sub">We'd love to hear from you. Reach out with questions, feedback, or partnership inquiries.</p>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-info">
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3>Visit Us</h3>
                    <p>123 Industrial Blvd, Suite 100<br>Toronto, ON M5V 1A1<br>Canada</p>
                </div>
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                    <h3>Call Us</h3>
                    <p><?= htmlspecialchars($settings['support_phone'] ?? '+1 (555) 123-4567') ?><br>Mon–Fri, 8AM–6PM EST</p>
                </div>
                <div class="contact-info-card">
                    <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                    <h3>Email Us</h3>
                    <p><?= htmlspecialchars($settings['support_email'] ?? 'support@toolshop.com') ?><br>We respond within 24 hours</p>
                </div>
            </div>

            <div class="contact-form-wrapper">
                <?php $success_msg = flash('success'); $error_msg = flash('error'); ?>
                <?php if ($success_msg): ?>
                    <div class="contact-alert success"><?= htmlspecialchars($success_msg) ?></div>
                <?php endif; ?>
                <?php if ($error_msg): ?>
                    <div class="contact-alert error"><?= htmlspecialchars($error_msg) ?></div>
                <?php endif; ?>

                <form method="POST" action="<?= $base_url ?>contact/send" class="contact-form">
                    <?= csrf_field() ?>
                    <div class="contact-form-row">
                        <div class="contact-field">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" class="contact-input" placeholder="John Doe" required>
                        </div>
                        <div class="contact-field">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" class="contact-input" placeholder="john@example.com" required>
                        </div>
                    </div>
                    <div class="contact-field">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="contact-input" placeholder="How can we help?" required>
                    </div>
                    <div class="contact-field">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="contact-textarea" rows="6" placeholder="Tell us more about your inquiry..." required></textarea>
                    </div>
                    <button type="submit" class="contact-submit">Send Message <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php require dirname(__DIR__) . '/partials/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="<?= $assets_url ?>js/home.js"></script>
</body>
</html>
