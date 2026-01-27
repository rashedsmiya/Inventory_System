<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->decimal('compare_price', 10, 2)->nullable();
        $table->decimal('cost', 10, 2)->nullable();
        $table->string('sku')->unique()->nullable();
        $table->string('barcode')->nullable();
        $table->integer('quantity')->default(0);
        $table->boolean('track_quantity')->default(true);
        $table->boolean('is_visible')->default(true);
        $table->boolean('is_featured')->default(false);
        $table->date('published_at')->nullable();
        $table->json('images')->nullable();
        $table->json('specifications')->nullable();
        $table->foreignId('created_by')->constrained('users');
        $table->foreignId('updated_by')->constrained('users');
        $table->softDeletes();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
