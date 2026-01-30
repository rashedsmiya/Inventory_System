<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\DashboardController;


Route::middleware(['auth'])->group(function () {
    // Your existing profile routes...

    // Add these new routes
    Route::put('/profile/basic', [ProfileController::class, 'updateBasic'])->name('profile.update-basic');
    Route::put('/profile/personal', [ProfileController::class, 'updatePersonal'])->name('profile.update-personal');
    Route::put('/profile/address', [ProfileController::class, 'updateAddress'])->name('profile.update-address');
    Route::get('/profile/view', [ProfileController::class, 'viewProfile'])->name('profile.view');
});


Route::get('/', function () {
    return view('welcome');
});


// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/home', [HomeController::class, 'index'])->name('home');

// Admin Routes Group
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Management (Super Admin Only)
    Route::middleware(['super_admin'])->prefix('admins')->name('admins.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('destroy');
        Route::patch('/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/admins/{admin}/edit', [AdminController::class, 'edit']);
        Route::put('/admins/{admin}', [AdminController::class, 'update']);
        Route::delete('/admins/{admin}', [AdminController::class, 'destroy']);
        Route::post('/admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus']);

    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    // Product Management
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/admin/product-categories/{productCategory}', [ProductCategoryController::class, 'show'])
    ->name('admin.product-categories.show');
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        Route::patch('/{product}/toggle-visibility', [ProductController::class, 'toggleVisibility'])->name('toggle-visibility');
        Route::patch('/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::patch('/{product}/update-stock', [ProductController::class, 'updateStock'])->name('update-stock');
        Route::get('/export', [ProductController::class, 'export'])->name('export');
        Route::post('/bulk-actions', [ProductController::class, 'bulkActions'])->name('bulk-actions');
    });

    // Product Categories
    Route::prefix('product-categories')->name('product-categories.')->group(function () {
        Route::post('/admin/product-categories/update-order', [ProductCategoryController::class, 'updateOrder'])
        ->name('admin.product-categories.update-order');
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/tree', [ProductCategoryController::class, 'tree'])->name('tree');
        Route::post('/update-order', [ProductCategoryController::class, 'updateOrder'])->name('update-order');
        Route::get('/{productCategory}/edit', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/{productCategory}', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/{productCategory}', [ProductCategoryController::class, 'destroy'])->name('destroy');
        Route::patch('/{productCategory}/toggle-status', [ProductCategoryController::class, 'toggleStatus'])->name('toggle-status');
    });
});

require __DIR__.'/auth.php';
