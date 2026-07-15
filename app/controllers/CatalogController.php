<?php

namespace App\Controllers;

class CatalogController extends Controller
{
    public function show($slug)
    {
        $product = $this->db->fetch(
            "SELECT p.*, c.name as category_name, c.slug as category_slug, b.name as brand_name
             FROM products p
             LEFT JOIN categories c ON p.category_id = c.id
             LEFT JOIN brands b ON p.brand_id = b.id
             WHERE p.slug = ? AND p.status = 1",
            [$slug]
        );

        if (!$product) {
            $this->redirect('');
        }

        $images = $this->db->fetchAll(
            "SELECT * FROM product_images WHERE product_id = ? ORDER BY sort_order ASC",
            [$product['id']]
        );

        $specs = $this->db->fetchAll(
            "SELECT * FROM product_specifications WHERE product_id = ? ORDER BY id ASC",
            [$product['id']]
        );

        $reviewStats = $this->db->fetch(
            "SELECT COALESCE(AVG(rating), 0) as avg_rating, COUNT(*) as total_reviews
             FROM reviews WHERE product_id = ? AND status = 1",
            [$product['id']]
        );

        $reviews = $this->db->fetchAll(
            "SELECT r.*, u.name as user_name
             FROM reviews r
             LEFT JOIN users u ON r.user_id = u.id
             WHERE r.product_id = ? AND r.status = 1
             ORDER BY r.created_at DESC",
            [$product['id']]
        );

        $relatedProducts = $this->db->fetchAll(
            "SELECT p.*, b.name as brand_name,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image,
                    COALESCE(AVG(r.rating), 0) as avg_rating, COUNT(r.id) as review_count
             FROM products p
             LEFT JOIN brands b ON p.brand_id = b.id
             LEFT JOIN reviews r ON p.id = r.product_id AND r.status = 1
             WHERE p.category_id = ? AND p.id != ? AND p.status = 1
             GROUP BY p.id
             ORDER BY RAND()
             LIMIT 4",
            [$product['category_id'], $product['id']]
        );

        $this->data['title'] = $product['name'] . ' — Industrial Tool Shop';
        $this->data['product'] = $product;
        $this->data['images'] = $images;
        $this->data['specs'] = $specs;
        $this->data['reviewStats'] = $reviewStats;
        $this->data['reviews'] = $reviews;
        $this->data['related_products'] = $relatedProducts;

        $inWishlist = false;
        if (is_logged_in()) {
            $w = $this->db->fetch(
                "SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?",
                [$_SESSION['user_id'], $product['id']]
            );
            $inWishlist = (bool)$w;
        }
        $this->data['in_wishlist'] = $inWishlist;

        $this->view('products/show');
    }

    public function toggleWishlist()
    {
        if (!is_logged_in()) {
            $this->json(['error' => 'Please login to add items to your wishlist'], 401);
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        if (!$productId) {
            $this->json(['error' => 'Invalid product'], 400);
        }

        $userId = $_SESSION['user_id'];

        $existing = $this->db->fetch(
            "SELECT id FROM wishlists WHERE user_id = ? AND product_id = ?",
            [$userId, $productId]
        );

        if ($existing) {
            $this->db->query("DELETE FROM wishlists WHERE id = ?", [$existing['id']]);
            $this->json(['action' => 'removed', 'message' => 'Removed from wishlist']);
        } else {
            $this->db->query(
                "INSERT INTO wishlists (user_id, product_id) VALUES (?, ?)",
                [$userId, $productId]
            );
            $this->json(['action' => 'added', 'message' => 'Added to wishlist']);
        }
    }

    public function addToCart()
    {
        if (!is_logged_in()) {
            $this->json(['error' => 'Please login to add items to your cart'], 401);
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $qty = max(1, (int)($_POST['quantity'] ?? 1));

        if (!$productId) {
            $this->json(['error' => 'Invalid product'], 400);
        }

        $product = $this->db->fetch(
            "SELECT id, stock_quantity FROM products WHERE id = ? AND status = 1",
            [$productId]
        );
        if (!$product) {
            $this->json(['error' => 'Product not found'], 404);
        }

        $userId = $_SESSION['user_id'];

        $cart = $this->db->fetch(
            "SELECT id FROM carts WHERE user_id = ?",
            [$userId]
        );

        if (!$cart) {
            $this->db->query(
                "INSERT INTO carts (user_id) VALUES (?)",
                [$userId]
            );
            $cartId = $this->db->lastInsertId();
        } else {
            $cartId = $cart['id'];
        }

        $existing = $this->db->fetch(
            "SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?",
            [$cartId, $productId]
        );

        if ($existing) {
            $newQty = $existing['quantity'] + $qty;
            if ($newQty > $product['stock_quantity']) {
                $this->json(['error' => 'Not enough stock available'], 400);
            }
            $this->db->query(
                "UPDATE cart_items SET quantity = ? WHERE id = ?",
                [$newQty, $existing['id']]
            );
        } else {
            if ($qty > $product['stock_quantity']) {
                $this->json(['error' => 'Not enough stock available'], 400);
            }
            $this->db->query(
                "INSERT INTO cart_items (cart_id, product_id, quantity, price) VALUES (?, ?, ?, ?)",
                [$cartId, $productId, $qty, 0]
            );
        }

        $totalQty = $this->db->fetch(
            "SELECT COALESCE(SUM(quantity), 0) as c FROM cart_items WHERE cart_id = ?",
            [$cartId]
        )['c'];

        $this->json(['action' => 'added', 'count' => (int)$totalQty, 'message' => 'Added to cart']);
    }

    public function cartJson()
    {
        if (!is_logged_in()) {
            $this->json(['items' => [], 'count' => 0, 'total' => 0]);
        }

        $userId = $_SESSION['user_id'];

        $items = $this->db->fetchAll(
            "SELECT ci.id, ci.product_id, ci.quantity, ci.price,
                    p.name, p.slug, p.price as product_price, p.sale_price,
                    (SELECT image FROM product_images WHERE product_id = p.id AND is_primary = 1 LIMIT 1) as primary_image
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             JOIN products p ON ci.product_id = p.id
             WHERE c.user_id = ?
             ORDER BY ci.id ASC",
            [$userId]
        );

        $count = 0;
        $total = 0;
        foreach ($items as &$item) {
            $count += (int)$item['quantity'];
            $unitPrice = ($item['sale_price'] && $item['sale_price'] < $item['product_price']) ? $item['sale_price'] : $item['product_price'];
            $item['unit_price'] = (float)$unitPrice;
            $item['subtotal'] = round((float)$unitPrice * (int)$item['quantity'], 2);
            $total += $item['subtotal'];
        }
        unset($item);

        $this->json(['items' => $items, 'count' => $count, 'total' => round($total, 2)]);
    }

    public function removeFromCart()
    {
        if (!is_logged_in()) {
            $this->json(['error' => 'Please login'], 401);
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        if (!$productId) {
            $this->json(['error' => 'Invalid product'], 400);
        }

        $userId = $_SESSION['user_id'];
        $this->db->query(
            "DELETE ci FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             WHERE ci.product_id = ? AND c.user_id = ?",
            [$productId, $userId]
        );

        $count = $this->db->fetch(
            "SELECT COALESCE(SUM(ci.quantity), 0) as c
             FROM cart_items ci
             JOIN carts c ON ci.cart_id = c.id
             WHERE c.user_id = ?",
            [$userId]
        )['c'];

        $this->json(['action' => 'removed', 'count' => (int)$count]);
    }
}
