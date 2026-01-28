@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
    <div class="container-fluid px-4 py-4">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-2">{{ $product->name }}</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                                <li class="breadcrumb-item active">{{ $product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                            <i class="bi bi-pencil"></i> Edit Product
                        </a>
                    </div>
                </div>

                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <!-- Product Information Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Product Information</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Product Name</strong>
                                    </div>
                                    <div class="col-md-9">
                                        {{ $product->name }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Slug</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <code>{{ $product->slug }}</code>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Category</strong>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($product->category)
                                            <span class="badge bg-primary">{{ $product->category->name }}</span>
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Description</strong>
                                    </div>
                                    <div class="col-md-9">
                                        {{ $product->description ?? 'No description' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">SKU</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <code>{{ $product->sku }}</code>
                                    </div>
                                </div>

                                @if ($product->barcode)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong class="text-muted">Barcode</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <code>{{ $product->barcode }}</code>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Pricing Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Pricing</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Price</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <h4 class="mb-0">${{ number_format($product->price, 2) }}</h4>
                                    </div>
                                </div>

                                @if ($product->compare_price)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong class="text-muted">Compare Price</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <span class="text-decoration-line-through text-muted">
                                                ${{ number_format($product->compare_price, 2) }}
                                            </span>
                                            @if ($product->compare_price > $product->price)
                                                <span class="badge bg-success ms-2">
                                                    {{ round((($product->compare_price - $product->price) / $product->compare_price) * 100) }}%
                                                    OFF
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if ($product->cost)
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <strong class="text-muted">Cost</strong>
                                        </div>
                                        <div class="col-md-9">
                                            ${{ number_format($product->cost, 2) }}
                                            @if ($product->cost < $product->price)
                                                <span class="badge bg-info ms-2">
                                                    Margin: ${{ number_format($product->price - $product->cost, 2) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Inventory Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Inventory</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Quantity</strong>
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="mb-0">
                                            {{ $product->quantity }}
                                            @if ($product->quantity <= 10)
                                                <span class="badge bg-warning text-dark">Low Stock</span>
                                            @elseif($product->quantity > 10 && $product->quantity <= 50)
                                                <span class="badge bg-info">In Stock</span>
                                            @else
                                                <span class="badge bg-success">Well Stocked</span>
                                            @endif
                                        </h5>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <strong class="text-muted">Track Quantity</strong>
                                    </div>
                                    <div class="col-md-9">
                                        @if ($product->track_quantity)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle"></i> Enabled
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-x-circle"></i> Disabled
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Specifications Card -->
                        @if ($product->specifications)
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Specifications</h5>
                                </div>
                                <div class="card-body">
                                    @foreach ($product->specifications as $key => $value)
                                        <div class="row mb-3">
                                            <div class="col-md-3">
                                                <strong class="text-muted">{{ ucfirst($key) }}</strong>
                                            </div>
                                            <div class="col-md-9">
                                                {{ is_array($value) ? json_encode($value) : $value }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Sidebar -->
                    <div class="col-lg-4">
                        <!-- Status Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Status</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong class="text-muted d-block mb-2">Visibility</strong>
                                    @if ($product->is_visible)
                                        <span class="badge bg-success fs-6">
                                            <i class="bi bi-eye"></i> Visible
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">
                                            <i class="bi bi-eye-slash"></i> Hidden
                                        </span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <strong class="text-muted d-block mb-2">Featured</strong>
                                    @if ($product->is_featured)
                                        <span class="badge bg-warning text-dark fs-6">
                                            <i class="bi bi-star-fill"></i> Featured
                                        </span>
                                    @else
                                        <span class="badge bg-secondary fs-6">
                                            <i class="bi bi-star"></i> Not Featured
                                        </span>
                                    @endif
                                </div>

                                @if ($product->published_at)
                                    <div class="mb-3">
                                        <strong class="text-muted d-block mb-2">Published</strong>
                                        <div class="text-dark">
                                            {{ \Carbon\Carbon::parse($product->published_at)->format('M d, Y') }}
                                        </div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($product->published_at)->diffForHumans() }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Metadata Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Metadata</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <strong class="text-muted d-block mb-1">Product ID</strong>
                                    <code>#{{ $product->id }}</code>
                                </div>

                                <div class="mb-3">
                                    <strong class="text-muted d-block mb-1">Created By</strong>
                                    @if ($product->creator)
                                        <div>{{ $product->creator->name }}</div>
                                        <small
                                            class="text-muted">{{ $product->created_at->format('M d, Y g:i A') }}</small>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <strong class="text-muted d-block mb-1">Last Updated By</strong>
                                    @if ($product->updater)
                                        <div>{{ $product->updater->name }}</div>
                                        <small
                                            class="text-muted">{{ $product->updated_at->format('M d, Y g:i A') }}</small>
                                    @else
                                        <span class="text-muted">Unknown</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Actions Card -->
                        <div class="card mb-4">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Actions</h5>
                            </div>
                            <div class="card-body d-grid gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Edit Product
                                </a>

                                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                                    <i class="bi bi-printer"></i> Print Details
                                </button>

                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Delete Product
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
