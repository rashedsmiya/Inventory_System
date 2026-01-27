<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $categories = ProductCategory::all();

        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'category_id' => $categories->random()->id,
            'description' => $this->faker->paragraph(3),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'compare_price' => $this->faker->optional(0.3)->randomFloat(2, 20, 1200),
            'cost' => $this->faker->randomFloat(2, 5, 800),
            'sku' => $this->faker->unique()->bothify('SKU-#####'),
            'barcode' => $this->faker->ean13,
            'quantity' => $this->faker->numberBetween(0, 100),
            'track_quantity' => $this->faker->boolean(80),
            'is_visible' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'images' => $this->faker->optional()->randomElements([
                'products/sample1.jpg',
                'products/sample2.jpg',
                'products/sample3.jpg',
            ], $this->faker->numberBetween(1, 3)),
            'specifications' => [
                'color' => $this->faker->colorName,
                'weight' => $this->faker->randomFloat(2, 0.1, 10),
                'dimensions' => $this->faker->randomElement(['10x5x2', '15x8x3', '20x10x5']),
            ],
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
