<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'creator', 'updater']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by status
        if ($request->has('status')) {
            switch ($request->status) {
                case 'visible':
                    $query->where('is_visible', true);
                    break;
                case 'hidden':
                    $query->where('is_visible', false);
                    break;
                case 'featured':
                    $query->where('is_featured', true);
                    break;
                case 'out_of_stock':
                    $query->where('quantity', '<=', 0);
                    break;
            }
        }

        // Sort
        $sort = $request->get('sort', 'created_at');
        $order = $request->get('order', 'desc');
        $query->orderBy($sort, $order);

        $products = $query->paginate(15);
        $categories = ProductCategory::active()->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = ProductCategory::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku',
            'barcode' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'track_quantity' => 'boolean',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
        ]);

        // Handle image upload
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(6),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'cost' => $request->cost,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'quantity' => $request->quantity,
            'track_quantity' => $request->boolean('track_quantity'),
            'is_visible' => $request->boolean('is_visible'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at,
            'images' => $images,
            'specifications' => $request->specifications,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load(['category', 'creator', 'updater']);
        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'cost' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'track_quantity' => 'boolean',
            'is_visible' => 'boolean',
            'is_featured' => 'boolean',
            'published_at' => 'nullable|date',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'specifications' => 'nullable|array',
        ]);

        // Handle image upload
        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                $images[] = $path;
            }
        }

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $image) {
                if (($key = array_search($image, $images)) !== false) {
                    Storage::disk('public')->delete($image);
                    unset($images[$key]);
                }
            }
            $images = array_values($images); // Re-index array
        }

        $product->update([
            'name' => $request->name,
            'slug' => $product->slug, // Keep original slug for SEO
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'cost' => $request->cost,
            'sku' => $request->sku,
            'barcode' => $request->barcode,
            'quantity' => $request->quantity,
            'track_quantity' => $request->boolean('track_quantity'),
            'is_visible' => $request->boolean('is_visible'),
            'is_featured' => $request->boolean('is_featured'),
            'published_at' => $request->published_at,
            'images' => $images,
            'specifications' => $request->specifications,
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete associated images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function toggleVisibility(Product $product)
    {
        $product->update(['is_visible' => !$product->is_visible]);

        $status = $product->is_visible ? 'published' : 'hidden';
        return redirect()->back()
            ->with('success', "Product {$status} successfully.");
    }

    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()
            ->with('success', "Product {$status} successfully.");
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0',
            'operation' => 'required|in:set,increment,decrement',
        ]);

        switch ($request->operation) {
            case 'set':
                $product->quantity = $request->quantity;
                break;
            case 'increment':
                $product->quantity += $request->quantity;
                break;
            case 'decrement':
                $product->quantity = max(0, $product->quantity - $request->quantity);
                break;
        }

        $product->save();

        return redirect()->back()
            ->with('success', 'Stock updated successfully.');
    }

    public function export(Request $request)
    {
        // Implement CSV/Excel export logic here
        return response()->json(['message' => 'Export feature to be implemented']);
    }

    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,visible,hidden,featured,unfeatured',
            'ids' => 'required|array',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();

        switch ($request->action) {
            case 'delete':
                foreach ($products as $product) {
                    $product->delete();
                }
                $message = 'Products deleted successfully.';
                break;

            case 'visible':
                Product::whereIn('id', $request->ids)->update(['is_visible' => true]);
                $message = 'Products published successfully.';
                break;

            case 'hidden':
                Product::whereIn('id', $request->ids)->update(['is_visible' => false]);
                $message = 'Products hidden successfully.';
                break;

            case 'featured':
                Product::whereIn('id', $request->ids)->update(['is_featured' => true]);
                $message = 'Products featured successfully.';
                break;

            case 'unfeatured':
                Product::whereIn('id', $request->ids)->update(['is_featured' => false]);
                $message = 'Products unfeatured successfully.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
