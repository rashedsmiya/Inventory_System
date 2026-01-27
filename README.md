# Inventory_System

# Laravel Admin Panel - Quick Reference

## 📋 Project Overview

A complete Laravel admin panel with:
- ✅ Admin Management (with roles)
- ✅ User Management
- ✅ Product Categories
- ✅ Products (with images and variants)

## 🚀 Quick Setup (5 Minutes)

```bash
# 1. Create Laravel project
composer create-project laravel/laravel admin-panel
cd admin-panel

# 2. Copy all files from the provided structure

# 3. Configure .env
DB_DATABASE=laravel_admin
DB_USERNAME=root
DB_PASSWORD=

# 4. Create database
mysql -u root -p
CREATE DATABASE laravel_admin;
exit;

# 5. Run migrations and seed
php artisan migrate
php artisan db:seed --class=AdminSeeder

# 6. Link storage
php artisan storage:link

# 7. Start server
php artisan serve
```

## 🔑 Default Login

- **Email:** admin@example.com
- **Password:** password
- **URL:** http://localhost:8000/admin/dashboard

## 📁 File Checklist

Copy these files to your Laravel project:

### Models (app/Models/)
- ✅ Admin.php
- ✅ User.php
- ✅ ProductCategory.php
- ✅ Product.php

### Controllers (app/Http/Controllers/Admin/)
- ✅ AdminController.php
- ✅ UserController.php
- ✅ ProductCategoryController.php
- ✅ ProductController.php
- ✅ DashboardController.php

### Middleware (app/Http/Middleware/)
- ✅ AdminAuthenticate.php

### Migrations (database/migrations/)
- ✅ 2024_01_01_000001_create_admins_table.php
- ✅ 2024_01_01_000002_create_users_table.php
- ✅ 2024_01_01_000003_create_product_categories_table.php
- ✅ 2024_01_01_000004_create_products_table.php

### Routes
- ✅ routes/admin.php

### Config
- ✅ config/auth.php (update with admin guard)

### Seeders
- ✅ database/seeders/AdminSeeder.php

## 🛣️ Available Routes

### Admin Panel Routes (Prefix: /admin)

**Dashboard**
- GET `/admin/dashboard` - Dashboard with statistics

**Admin Management**
- GET `/admin/admins` - List all admins
- GET `/admin/admins/create` - Create form
- POST `/admin/admins` - Store admin
- GET `/admin/admins/{id}/edit` - Edit form
- PUT `/admin/admins/{id}` - Update admin
- DELETE `/admin/admins/{id}` - Delete admin

**User Management**
- GET `/admin/users` - List users
- GET `/admin/users/create` - Create form
- POST `/admin/users` - Store user
- GET `/admin/users/{id}/edit` - Edit form
- PUT `/admin/users/{id}` - Update user
- DELETE `/admin/users/{id}` - Delete user

**Category Management**
- GET `/admin/categories` - List categories
- GET `/admin/categories/create` - Create form
- POST `/admin/categories` - Store category
- GET `/admin/categories/{id}/edit` - Edit form
- PUT `/admin/categories/{id}` - Update category
- DELETE `/admin/categories/{id}` - Delete category

**Product Management**
- GET `/admin/products` - List products
- GET `/admin/products/create` - Create form
- POST `/admin/products` - Store product
- GET `/admin/products/{id}/edit` - Edit form
- PUT `/admin/products/{id}` - Update product
- DELETE `/admin/products/{id}` - Delete product

## 💾 Database Schema

**admins**
- id, name, email, password, role, is_active, timestamps

**users**
- id, name, email, phone, password, is_active, email_verified_at, timestamps

**product_categories**
- id, name, slug, description, image, is_active, order, timestamps

**products**
- id, category_id, name, slug, description, price, sale_price, sku, stock, image, images (json), is_active, is_featured, timestamps

## 🎨 Features Included

### Admin Features
✅ Role-based access (admin, super_admin)
✅ Active/inactive status
✅ Self-deletion prevention
✅ Secure password hashing

### User Features
✅ CRUD operations
✅ Active/inactive status
✅ Email verification tracking
✅ Phone number support

### Category Features
✅ CRUD operations
✅ Auto slug generation
✅ Image upload
✅ Active/inactive status
✅ Custom ordering

### Product Features
✅ Full CRUD operations
✅ Category relationship
✅ Price & sale price
✅ SKU management
✅ Stock tracking
✅ Single & multiple images
✅ Featured products
✅ Auto slug generation

## 🔐 Security Features

✅ Password hashing
✅ Separate admin authentication guard
✅ Middleware protection
✅ CSRF protection
✅ Validation rules
✅ File upload validation
✅ SQL injection protection (Eloquent)

## 📝 Model Methods

### Admin Model
```php
$admin->isSuperAdmin(); // Check if super admin
$admin->isActive(); // Check if active
```

### Product Model
```php
$product->category(); // Get category
$product->getCurrentPrice(); // Get current/sale price
$product->isOnSale(); // Check if on sale
$product->isInStock(); // Check stock availability
```

### ProductCategory Model
```php
$category->products(); // All products
$category->activeProducts(); // Only active products
```

## 🧪 Testing Commands

### Create Test Category
```php
php artisan tinker
\App\Models\ProductCategory::create([
    'name' => 'Electronics',
    'slug' => 'electronics',
    'is_active' => true
]);
```

### Create Test Product
```php
\App\Models\Product::create([
    'category_id' => 1,
    'name' => 'Test Product',
    'slug' => 'test-product',
    'price' => 99.99,
    'sku' => 'TEST-001',
    'stock' => 10,
    'is_active' => true
]);
```

### Create Test User
```php
\App\Models\User::create([
    'name' => 'Test User',
    'email' => 'user@test.com',
    'password' => bcrypt('password'),
    'is_active' => true
]);
```

## 🎯 Next Steps

To complete the admin panel:

1. **Create Blade Views** - Build the UI
2. **Add Login System** - Implement authentication
3. **Style with CSS** - Use Bootstrap/Tailwind
4. **Add JavaScript** - Interactivity & AJAX
5. **Implement Search** - Filter functionality
6. **Add Pagination** - Better data management
7. **File Upload UI** - Image preview & drag-drop
8. **Notifications** - Success/error messages
9. **Export Data** - CSV/Excel export
10. **Activity Logs** - Track admin actions

## 🐛 Troubleshooting

**Class not found?**
```bash
composer dump-autoload
```

**Storage errors?**
```bash
chmod -R 775 storage bootstrap/cache
php artisan storage:link
```

**Route errors?**
```bash
php artisan route:clear
php artisan config:clear
```

**Migration errors?**
```bash
php artisan migrate:fresh --seed
```

## 📚 Documentation

- [Laravel Docs](https://laravel.com/docs)
- [Laravel Eloquent](https://laravel.com/docs/eloquent)
- [Laravel Validation](https://laravel.com/docs/validation)
- [Laravel File Storage](https://laravel.com/docs/filesystem)

## ⚡ Performance Tips

```bash
# Production optimization
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --optimize-autoloader --no-dev
```

## 🎉 You're Ready!

Your Laravel admin panel backend is complete. Now you just need to create the frontend views to make it fully functional!
