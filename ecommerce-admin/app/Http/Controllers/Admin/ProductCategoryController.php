<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductCategory::with('parent');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status == 'active');
        }

        // Filter root categories
        if ($request->has('type') && $request->type == 'root') {
            $query->whereNull('parent_id');
        }

        // Sort
        $sort = $request->get('sort', 'order');
        $order = $request->get('order', 'asc');
        $query->orderBy($sort, $order);

        $categories = $query->paginate(20);

        // Get all categories for parent selection
        $allCategories = ProductCategory::where('id', '!=', $request->get('id'))->get();

        return view('admin.product-categories.index', compact('categories', 'allCategories'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('admin.product-categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'slug' => 'nullable|string|max:255|unique:product_categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        $category = ProductCategory::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->boolean('is_active'),
            'order' => $request->order ?? 0,
        ]);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(ProductCategory $productCategory)
    {
        $categories = ProductCategory::where('id', '!=', $productCategory->id)->get();
        return view('admin.product-categories.edit', compact('productCategory', 'categories'));
    }

    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $productCategory->id,
            'slug' => 'nullable|string|max:255|unique:product_categories,slug,' . $productCategory->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'is_active' => 'boolean',
            'order' => 'nullable|integer',
        ]);

        // Prevent setting parent as itself
        if ($request->parent_id == $productCategory->id) {
            return redirect()->back()
                ->with('error', 'Category cannot be its own parent.');
        }

        // Prevent circular reference
        if ($request->parent_id) {
            $parent = ProductCategory::find($request->parent_id);
            if ($this->isCircularReference($productCategory, $parent)) {
                return redirect()->back()
                    ->with('error', 'Circular reference detected.');
            }
        }

        $productCategory->update([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
            'description' => $request->description,
            'parent_id' => $request->parent_id,
            'is_active' => $request->boolean('is_active'),
            'order' => $request->order ?? $productCategory->order,
        ]);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with products. Move products first.');
        }

        // Check if category has subcategories
        if ($productCategory->children()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete category with subcategories. Delete subcategories first.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(ProductCategory $productCategory)
    {
        $productCategory->update(['is_active' => !$productCategory->is_active]);

        $status = $productCategory->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Category {$status} successfully.");
    }

    private function isCircularReference($category, $potentialParent)
    {
        // Check if setting parent would create circular reference
        $current = $potentialParent;
        while ($current) {
            if ($current->id === $category->id) {
                return true;
            }
            $current = $current->parent;
        }
        return false;
    }

    public function tree()
    {
        $categories = ProductCategory::with('children')->whereNull('parent_id')->orderBy('order')->get();
        return view('admin.product-categories.tree', compact('categories'));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'categories' => 'required|array',
        ]);

        foreach ($request->categories as $index => $categoryData) {
            ProductCategory::where('id', $categoryData['id'])->update([
                'order' => $index,
                'parent_id' => $categoryData['parent_id'] ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
