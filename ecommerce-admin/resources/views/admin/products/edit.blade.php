@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="container-fluid px-4 py-4">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h1 class="h3 mb-2">Edit Product</h1>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a>
                                    </li>
                                    <li class="breadcrumb-item"><a
                                            href="{{ route('admin.products.show', $product) }}">{{ $product->name }}</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.products.show', $product) }}" class="btn btn-outline-secondary">
                                <i class="bi bi-x-lg"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i> Save Changes
                            </button>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Main Content -->
                        <div class="col-lg-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Product Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Product Name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $product->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Slug -->
                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                                            required>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">URL-friendly version of the name</div>
                                    </div>

                                    <!-- Category -->
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Category <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">Select a category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                            rows="4">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Pricing</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Price -->
                                        <div class="col-md-4 mb-3">
                                            <label for="price" class="form-label">Price <span
                                                    class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                                    name="price" value="{{ old('price', $product->price) }}"
                                                    step="0.01" min="0" required>
                                                @error('price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Compare Price -->
                                        <div class="col-md-4 mb-3">
                                            <label for="compare_price" class="form-label">Compare Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('compare_price') is-invalid @enderror"
                                                    id="compare_price" name="compare_price"
                                                    value="{{ old('compare_price', $product->compare_price) }}"
                                                    step="0.01" min="0">
                                                @error('compare_price')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Original price before discount</div>
                                        </div>

                                        <!-- Cost -->
                                        <div class="col-md-4 mb-3">
                                            <label for="cost" class="form-label">Cost</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number"
                                                    class="form-control @error('cost') is-invalid @enderror"
                                                    id="cost" name="cost"
                                                    value="{{ old('cost', $product->cost) }}" step="0.01"
                                                    min="0">
                                                @error('cost')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="form-text">Cost per item</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Inventory</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- SKU -->
                                        <div class="col-md-6 mb-3">
                                            <label for="sku" class="form-label">SKU <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                                id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                                                required>
                                            @error('sku')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Barcode -->
                                        <div class="col-md-6 mb-3">
                                            <label for="barcode" class="form-label">Barcode</label>
                                            <input type="text"
                                                class="form-control @error('barcode') is-invalid @enderror" id="barcode"
                                                name="barcode" value="{{ old('barcode', $product->barcode) }}">
                                            @error('barcode')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <!-- Quantity -->
                                        <div class="col-md-6 mb-3">
                                            <label for="quantity" class="form-label">Quantity <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('quantity') is-invalid @enderror"
                                                id="quantity" name="quantity"
                                                value="{{ old('quantity', $product->quantity) }}" min="0"
                                                required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Track Quantity -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label d-block">Track Quantity</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="track_quantity"
                                                    name="track_quantity" value="1"
                                                    {{ old('track_quantity', $product->track_quantity) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="track_quantity">
                                                    Enable inventory tracking
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specifications -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Specifications</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Color -->
                                        <div class="col-md-4 mb-3">
                                            <label for="spec_color" class="form-label">Color</label>
                                            <input type="text" class="form-control" id="spec_color"
                                                name="specifications[color]"
                                                value="{{ old('specifications.color', $product->specifications['color'] ?? '') }}">
                                        </div>

                                        <!-- Weight -->
                                        <div class="col-md-4 mb-3">
                                            <label for="spec_weight" class="form-label">Weight</label>
                                            <input type="text" class="form-control" id="spec_weight"
                                                name="specifications[weight]"
                                                value="{{ old('specifications.weight', $product->specifications['weight'] ?? '') }}"
                                                placeholder="e.g., 2.5 kg">
                                        </div>

                                        <!-- Dimensions -->
                                        <div class="col-md-4 mb-3">
                                            <label for="spec_dimensions" class="form-label">Dimensions</label>
                                            <input type="text" class="form-control" id="spec_dimensions"
                                                name="specifications[dimensions]"
                                                value="{{ old('specifications.dimensions', $product->specifications['dimensions'] ?? '') }}"
                                                placeholder="e.g., 20x10x5 cm">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="col-lg-4">
                            <!-- Status -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Status</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Visibility -->
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_visible"
                                                name="is_visible" value="1"
                                                {{ old('is_visible', $product->is_visible) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_visible">
                                                <strong>Visible</strong>
                                                <div class="form-text">Product will be visible on the storefront</div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Featured -->
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_featured"
                                                name="is_featured" value="1"
                                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                <strong>Featured</strong>
                                                <div class="form-text">Show in featured products section</div>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Published Date -->
                                    <div class="mb-3">
                                        <label for="published_at" class="form-label">Publish Date</label>
                                        <input type="datetime-local"
                                            class="form-control @error('published_at') is-invalid @enderror"
                                            id="published_at" name="published_at"
                                            value="{{ old('published_at', $product->published_at ? \Carbon\Carbon::parse($product->published_at)->format('Y-m-d\TH:i') : '') }}">
                                        @error('published_at')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Leave empty for immediate publishing</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="card mb-4">
                                <div class="card-header bg-white">
                                    <h5 class="card-title mb-0">Product Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <small class="text-muted">Product ID:</small>
                                        <div><code>#{{ $product->id }}</code></div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Created:</small>
                                        <div>{{ $product->created_at->format('M d, Y') }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Last Updated:</small>
                                        <div>{{ $product->updated_at->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="card">
                                <div class="card-body d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-lg"></i> Save Changes
                                    </button>
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="btn btn-outline-secondary">
                                        <i class="bi bi-x-lg"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            // Auto-generate slug from name
            document.getElementById('name').addEventListener('input', function() {
                const name = this.value;
                const slug = name.toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/--+/g, '-')
                    .trim();
                document.getElementById('slug').value = slug;
            });
        </script>
    @endpush
@endsection
