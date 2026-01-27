<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Regular Users
        User::factory(10)->create();

        // Create Product Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and gadgets'],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel'],
            ['name' => 'Books', 'description' => 'Books and publications'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and gardening'],
            ['name' => 'Sports', 'description' => 'Sports equipment and gear'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'name' => $category['name'],
                'slug' => \Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true,
                'order' => 0,
            ]);
        }

        // Create Sub-categories for Electronics
        $electronics = ProductCategory::where('name', 'Electronics')->first();
        $subCategories = [
            ['name' => 'Smartphones', 'parent_id' => $electronics->id],
            ['name' => 'Laptops', 'parent_id' => $electronics->id],
            ['name' => 'TVs', 'parent_id' => $electronics->id],
            ['name' => 'Cameras', 'parent_id' => $electronics->id],
        ];

        foreach ($subCategories as $subCategory) {
            ProductCategory::create([
                'name' => $subCategory['name'],
                'slug' => \Str::slug($subCategory['name']),
                'parent_id' => $subCategory['parent_id'],
                'is_active' => true,
                'order' => 0,
            ]);
        }

        // Create Sample Products
        $smartphones = ProductCategory::where('name', 'Smartphones')->first();
        $laptops = ProductCategory::where('name', 'Laptops')->first();

        Product::create([
            'name' => 'iPhone 14 Pro',
            'slug' => 'iphone-14-pro',
            'category_id' => $smartphones->id,
            'description' => 'Latest iPhone with advanced camera system',
            'price' => 999.99,
            'compare_price' => 1099.99,
            'cost' => 800.00,
            'sku' => 'IPH14PRO-128',
            'barcode' => '123456789012',
            'quantity' => 50,
            'track_quantity' => true,
            'is_visible' => true,
            'is_featured' => true,
            'published_at' => now(),
            'images' => ['products/iphone.jpg'],
            'specifications' => [
                'color' => 'Space Black',
                'storage' => '128GB',
                'screen_size' => '6.1 inches',
            ],
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Product::create([
            'name' => 'MacBook Pro 16"',
            'slug' => 'macbook-pro-16',
            'category_id' => $laptops->id,
            'description' => 'Powerful laptop for professionals',
            'price' => 2499.99,
            'compare_price' => 2699.99,
            'cost' => 2000.00,
            'sku' => 'MBP16-512',
            'barcode' => '987654321098',
            'quantity' => 25,
            'track_quantity' => true,
            'is_visible' => true,
            'is_featured' => true,
            'published_at' => now(),
            'images' => ['products/macbook.jpg'],
            'specifications' => [
                'processor' => 'M2 Pro',
                'ram' => '16GB',
                'storage' => '512GB SSD',
            ],
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Create more products
        Product::factory(20)->create();
    }
}
