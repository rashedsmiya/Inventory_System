<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'description',
        'price',
        'compare_price',
        'cost',
        'sku',
        'barcode',
        'quantity',
        'track_quantity',
        'is_visible',
        'is_featured',
        'published_at',
        'images',
        'specifications',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_price' => 'decimal:2',
        'cost' => 'decimal:2',
        'quantity' => 'integer',
        'track_quantity' => 'boolean',
        'is_visible' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'date',
        'images' => 'array',
        'specifications' => 'array',
    ];

    // Category relationship
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    // Creator relationship
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Updater relationship
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Scope for visible products
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope for in-stock products
    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    // Check if product is in stock
    public function inStock()
    {
        return !$this->track_quantity || $this->quantity > 0;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_price && $this->compare_price > $this->price) {
            return round((($this->compare_price - $this->price) / $this->compare_price) * 100);
        }
        return 0;
    }

    // Generate slug
    public static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Str::slug($product->name);
            }
            if (auth()->check()) {
                $product->created_by = auth()->id();
                $product->updated_by = auth()->id();
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name')) {
                $product->slug = \Str::slug($product->name);
            }
            if (auth()->check()) {
                $product->updated_by = auth()->id();
            }
        });
    }
}
