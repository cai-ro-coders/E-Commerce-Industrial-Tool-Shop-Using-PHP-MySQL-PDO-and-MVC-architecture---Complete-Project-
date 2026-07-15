<!-- ========== FOOTER ========== -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-newsletter">
            <div class="newsletter-content">
                <h3 class="newsletter-title">Join Our Newsletter</h3>
                <p class="newsletter-text">Get exclusive deals, new arrivals, and industry insights delivered to your inbox.</p>
            </div>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email" required>
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>
        <div class="footer-grid">
            <div class="footer-col">
                <h4 class="footer-col-title">About ToolShop</h4>
                <p class="footer-about-text">Your trusted source for premium industrial tools and equipment. We supply professionals with the highest quality tools from leading manufacturers worldwide.</p>
                <div class="footer-social">
                    <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-link" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?= $base_url ?>">Home</a></li>
                    <li><a href="#">Shop All</a></li>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Best Sellers</a></li>
                    <li><a href="#">Sales & Deals</a></li>
                    <li><a href="<?= $base_url ?>about">About Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Support</h4>
                <ul class="footer-links">
                    <li><a href="<?= $base_url ?>contact">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Exchanges</a></li>
                    <li><a href="#">Warranty Information</a></li>
                    <li><a href="#">Size Guide</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4 class="footer-col-title">Contact</h4>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> 123 Industrial Blvd, Suite 100<br>Chicago, IL 60601</li>
                    <li><i class="fas fa-phone"></i> <?= htmlspecialchars($settings['support_phone'] ?? '+1 (555) 123-4567') ?></li>
                    <li><i class="fas fa-envelope"></i> <?= htmlspecialchars($settings['support_email'] ?? 'support@toolshop.com') ?></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> <?= htmlspecialchars($app_name) ?>. All rights reserved.</p>
            <div class="footer-payments">
                <i class="fab fa-cc-visa"></i>
                <i class="fab fa-cc-mastercard"></i>
                <i class="fab fa-cc-amex"></i>
                <i class="fab fa-cc-paypal"></i>
                <i class="fab fa-cc-discover"></i>
            </div>
        </div>
    </div>
</footer>
