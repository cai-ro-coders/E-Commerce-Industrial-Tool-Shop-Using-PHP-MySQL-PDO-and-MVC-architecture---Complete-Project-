<img src="https://raw.githubusercontent.com/cai-ro-coders/E-Commerce-Industrial-Tool-Shop-Using-PHP-MySQL-PDO-and-MVC-architecture---Complete-Project-/refs/heads/main/ecommerce1.png" alt="Cairocoders Ednalan">
<img src="https://raw.githubusercontent.com/cai-ro-coders/E-Commerce-Industrial-Tool-Shop-Using-PHP-MySQL-PDO-and-MVC-architecture---Complete-Project-/refs/heads/main/ecommerce2.png" alt="Cairocoders Ednalan">
<img src="https://raw.githubusercontent.com/cai-ro-coders/E-Commerce-Industrial-Tool-Shop-Using-PHP-MySQL-PDO-and-MVC-architecture---Complete-Project-/refs/heads/main/ecommerce3.png" alt="Cairocoders Ednalan">

E Commerce Industrial Tool Shop Using PHP MySQL PDO and MVC architecture - Complete Project 

Build a Complete Admin E-Commerce Industrial Tool Shop
MVC Architecture PHP, MySQL, Bootstrap 5, HTML5, CSS3, JavaScript, jQuery, AJAX, PDO for database operations 
follow modern PHP best practices using PDO and MVC architecture
MySQL database : 
database name : ecommercedb
username : root
password : root


E-Commerce Industrial Tool Shop Database Schema

users
    `role` enum('admin','customer', 'staff') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',

categories
    id (PK)
    parent_id (FK → categories.id, nullable)
    name
    slug
    image
    description
    status
    created_at
    updated_at
brands
    id (PK)
    name
    slug
    logo
    description
    status
    created_at
    updated_at
products
    id (PK)
    category_id (FK → categories.id)
    brand_id (FK → brands.id)
    sku (unique)
    name
    slug
    short_description
    description
    price
    sale_price
    cost_price
    weight
    dimensions
    stock_quantity
    minimum_stock
    featured
    status
    created_at
    updated_at
product_images
    id (PK)
    product_id (FK → products.id)
    image
    is_primary
    sort_order
    created_at
    updated_at
product_specifications
    id (PK)
    product_id (FK → products.id)
    attribute_name
    attribute_value
    created_at
    updated_at
addresses
    id (PK)
    user_id (FK → users.id)
    full_name
    phone
    address_line_1
    address_line_2
    city
    province
    postal_code
    country
    is_default
    created_at
    updated_at
carts
    id (PK)
    user_id (FK → users.id)
    created_at
    updated_at
cart_items
    id (PK)
    cart_id (FK → carts.id)
    product_id (FK → products.id)
    quantity
    price
    created_at
    updated_at
wishlists
    id (PK)
    user_id (FK → users.id)
    product_id (FK → products.id)
    created_at
    updated_at
orders
    id (PK)
    user_id (FK → users.id)
    order_number
    subtotal
    discount
    shipping_fee
    tax
    grand_total
    payment_method
    payment_status
    order_status
    shipping_address_id (FK → addresses.id)
    notes
    created_at
    updated_at
Order Status
    Pending
    Processing
    Shipped
    Delivered
    Cancelled
    Returned
Payment Status
    Pending
    Paid
    Failed
    Refunded
order_items
    id (PK)
    order_id (FK → orders.id)
    product_id (FK → products.id)
    product_name
    sku
    quantity
    price
    total
    created_at
    updated_at
payments
    id (PK)
    order_id (FK → orders.id)
    transaction_id
    payment_gateway
    amount
    currency
    status
    paid_at
    created_at
    updated_at
reviews
    id (PK)
    product_id (FK → products.id)
    user_id (FK → users.id)
    rating
    title
    comment
    status
    created_at
    updated_at
coupons
    id (PK)
    code
    type
    value
    minimum_order
    maximum_discount
    usage_limit
    used_count
    start_date
    end_date
    status
    created_at
    updated_at
Coupon Types
    percentage
    fixed
coupon_usages
    id (PK)
    coupon_id (FK → coupons.id)
    user_id (FK → users.id)
    order_id (FK → orders.id)
    discount_amount
    created_at
    updated_at
inventory_logs
    id (PK)
    product_id (FK → products.id)
    type
    quantity
    reference
    remarks
    created_at
    updated_at
Inventory Types
    stock_in
    stock_out
    adjustment
    return
settings
    id (PK)
    key
    value
    created_at
    updated_at
Common Settings
    site_name
    site_logo
    support_email
    support_phone
    currency
    tax_rate
    shipping_fee
settings
    id (PK)
    key
    group
    value
    created_at
    updated_at
data
    1
        key: stripe_publishable_key
        group: payment
        value: pk_test
    2
        key: stripe_secret_key
        group: payment
        value: sk_test
    3
        key: paypal_client_id
        group: payment
        value: test
    4
        key: paypal_client_secret
        group: payment
        value: test
site_name
site_logo
support_email
support_phone
currency
tax_rate
shipping_fee

Relationships Overview
Category
 └── hasMany Products

Brand
 └── hasMany Products

Product
 ├── belongsTo Category
 ├── belongsTo Brand
 ├── hasMany ProductImages
 ├── hasMany ProductSpecifications
 ├── hasMany Reviews
 └── hasMany OrderItems

User
 ├── hasMany Addresses
 ├── hasMany Orders
 ├── hasMany Reviews
 ├── hasMany Wishlist
 └── hasOne Cart

Order
 ├── belongsTo User
 ├── hasMany OrderItems
 ├── hasOne Payment
 └── belongsTo Address

Theme:

Modern
Professional
Mobile Friendly
Folder Structure

Generate complete MVC folder structure:

project/
│
├── app/
│   ├── controllers/
│   ├── models/
│   ├── views/
│   └── helpers/
│
├── config/
├── public/
├── assets/
│   ├── css/
│   ├── js/
│   ├── images/
│   └── uploads/
│
├── database/
├── routes/
├── vendor/
└── index.php

Develop a responsive web application with a modern dashboard and clean user interface.

Authentication & Authorization
Features
Secure Login
Logout
Forgot Password
Change Password
User Profile Management
Role-Based Access Control
Password hashing using password_hash()
CSRF protection
Session management
SQL injection protection using PDO prepared statements
Input validation and sanitization
Dashboard

Create an attractive Bootstrap dashboard showing:

Features:
Display real-time statistics:
Total Revenue
Today Order
Yesterday Orders
Total Order
Weekly Sales
Sales Analytic
Best Selling Products
Recent Order in table with photo of product
Use charts (Chart.js) for dashboard stats

Products Management Module

Features:
Products (Manage your products inventory)
-export (export to CSV, export to json)
View all Products (paginated, searchable)
Add Products (new page, upload photo)
Edit Products details (update photo)
View Product (Product Details page, photo large left right information with edit button)
Delete Products (delete photo)  

Orders Management Module

Features:
Manage customer orders - Download all orders in csv file
View all Orders (paginated, searchable)
Edit Order
Orders details
Order Tracking
Delete Orders
print receipt

Customers Management Module

Features:
View all Customers (paginated, searchable)
Create new Customers
Edit Customers details
view (new page Customer Order List table)
Delete Customers

Category Management Module

Features:
View all categories (paginated, searchable)
Create new categories
Edit categories details
Delete categories

Brands Management Module

Features:
View all brands (paginated, searchable)
Create new brands
Edit brands details
Delete brands

Coupons Management Module

Features:
View all coupons (paginated, searchable)
Create new coupons
Edit coupons details
Delete coupons

Settings Management Module

Features:
View all settings (paginated, searchable)
Create new settings
Edit settings details
Delete settings

Reviews Management Module

Features:
View all reviews (paginated, searchable)
Edit reviews details
Delete reviews
==============================================
Create a premium E-Commerce Industrial Tool Shop homepage http://localhost:8888/devproject/eCommerce/

- Sticky transparent header
- Announcement bar
- Mega menu navigation
- Search overlay
- Wishlist
- Sign in account icon
- Cart drawer

Use a warm luxury color palette:

#2b1d16
#5a3928
#005969
#ffffff
#f8f6f3

Typography:
- Playfair Display for headings
- Inter for body

Sections:
Navigation Structure
Top Navigation
    Home
    Products
    Shop
    Sales
    About
    Contact
Right Side Icons
    Search
    Wishlist
    Account
    Cart
Search
    Full screen overlay
    Live product suggestions
    Search by category
Wishlist
    Heart icon
    Hover counter
    Saved products
Sign In
    Login
    Register
    Account dashboard
Cart
    Slide drawer
    Product preview
    Quantity controls
    Checkout CTA
Mega Menu
Dropdown animation: opacity, translateY, 300ms duration.

1. Full width hero section
   - large image
   - luxury headline
   - two CTA buttons
   - animated fade-up entrance

2. Feature icons row
   - Free Shipping
   - Easy Returns
   - Secure Checkout

3. Shop By Category
   - 6 category cards
   - image zoom hover

4. Trending Products
   - 4 column product grid
   - wishlist
   - quick view
   - hover image swap

5. Promotional Banner
   - split layout
   - premium storytelling section

6. New Arrivals
   - modern ecommerce cards

7. Top Deals
   - countdown timer
   - featured product card
   - add to cart
   - variant selector

8. Featured Products
   - luxury banner
   - CTA buttons

9. SHOP BY BRAND

10. Customer Reviews
   - auto sliding testimonials

11. Large Footer
   - 4 columns
   - newsletter
   - social icons

Animations:
- smooth fade-up on scroll
- image zoom hover
- sticky shrinking header
- cart drawer slide
- mega menu dropdown animation
- button hover transitions

search icon opens a full-width dropdown with:
- "What are you looking for?" placeholder text
- Search icon inside the input
- Search button to submit
- X icon to close the dropdown
- Closes on Escape key or clicking outside
==================================================
Create collections page http://localhost:8888/devproject/eCommerce/collections/power-tools power-tools is slug database category

1 Design Style:
    Clean modern e-commerce UI
    Minimal but premium aesthetic
    White/light gray background
    Subtle shadows and soft borders
    Rounded corners (10px–16px)
    Spacious layout with excellent whitespace
    Professional typography hierarchy
    Smooth hover animations and transitions

    Main Layout Structure:

    Use a two-column layout
    Left sidebar for filters
    Right content area for products

 2  Sidebar Filter Section:
    Include:

    Product categories
    Price range slider
    Brand filters
    Ratings filter

    Sidebar Design:

    White cards with soft shadow
    Sticky sidebar on desktop
    Accordion sections
    Thin dividers
    Modern checkbox styling
    Minimal icon usage

    Top Toolbar Section:
    Include:

    Product count text
    Sorting dropdown
    Grid/list toggle buttons
    Search input optional
    Clean horizontal alignment
    Subtle bottom border

    Product Grid:

    3 or 4-column responsive card layout
    Equal card heights
    Consistent spacing and alignment
    Masonry-like visual rhythm without actual masonry

3 Product Card Design:
    Each card should include:

    Product image
    Hover image swap
    Sale badge / discount badge
    Wishlist icon
    Quick view button
    Product category
    Product title
    Star ratings
    Current price
    Old price
    Add to cart button

    Card UI:

    Rounded corners
    Soft shadow
    Hover lift animation
    Image zoom on hover
    Buttons fade in on hover
    Clean typography
    Modern ecommerce interactions
4. url link http://localhost:8888/devproject/eCommerce/collections/{slug} product slug    
5. Hero Breadcrumb Section
    Create a large breadcrumb banner section with:
    Full-width background image 
    Dark overlay for readability
    Centered page title
    Breadcrumb navigation underneath
    Large vertical spacing (250–400px height)
    Parallax scrolling effect
    Background image slightly blurred or dimmed 
===================================================
Create a product page details http://localhost:8888/devproject/eCommerce/deWalt-20V-max deWalt-20V-max is slug from products database 
1. Hero Breadcrumb Section

Create a large breadcrumb banner section with:

Full-width background image 
Dark overlay for readability
Centered page title
Breadcrumb navigation underneath
Large vertical spacing (250–400px height)
Parallax scrolling effect
Background image slightly blurred or dimmed

2. Product Showcase Section
Two-column responsive layout
Large product gallery on the left
Product information panel on the right
Sticky product image gallery behavior on scroll
Vertical thumbnail gallery beside main image
Smooth image switching interaction
Light zoom-on-hover effect
Large clean product imagery with soft gray background container

3. Product Information Area
Include:
Product category label
Large bold product title
Rating stars with review count
Pricing layout with sale price + original price
Short product description paragraph
Quantity selector with plus/minus buttons
Large primary “Add to Cart” button
Secondary “Buy Now” button
Wishlist and compare icons
SKU/meta information
Social sharing icons

4. Product Details Tabs Section
Tabbed content layout with:
Description
Additional Information
Reviews

Tab Design:

Minimal horizontal tab navigation
Active tab underline animation
Smooth content transitions
Large readable content spacing

5. Related Products Section
Grid layout with 4 related products
Card-based design
Hover image swap effect
Floating action buttons on hover
Product badges like “Sale” or “New”
Consistent product card spacing
Minimal typography hierarchy

Create a customer login signup page for customer http://localhost:8888/devproject/eCommerce/customer/login
http://localhost:8888/devproject/eCommerce/customer/register with header and footer 

Create a customer my account http://localhost:8888/devproject/eCommerce/customer/my-account
with landing-navigation and landing-footer 
-my details 
-notifications
-my order 
-wishlist
-billing address 
-my cart 

Create checkout page http://localhost:8888/devproject/eCommerce/checkout
Create About page http://localhost:8888/devproject/eCommerce/about

for this page http://localhost:8888/devproject/eCommerce/checkout
integrate Stripe payment in test mode.
1. Install Stripe PHP package
2. Install Stripe.js for frontend
3. Integrate Stripe payment

for this page http://localhost:8888/devproject/eCommerce/checkout
integrate Paypal payment in test mode.
1. Install paypal package 

Create Contact page http://localhost:8888/devproject/eCommerce/contact
