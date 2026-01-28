@extends('layouts.app')

@section('title', 'Product Management')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Product Management</h1>
        <div>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#bulkModal">
                <i class="bi bi-collection"></i> Bulk Actions
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Search products..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="visible" {{ request('status') == 'visible' ? 'selected' : '' }}>Visible</option>
                        <option value="hidden" {{ request('status') == 'hidden' ? 'selected' : '' }}>Hidden</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                        <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Out of
                            Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="sort" class="form-select">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Newest</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="quantity" {{ request('sort') == 'quantity' ? 'selected' : '' }}>Stock</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <!-- Products Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th class="table-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <input type="checkbox" class="product-checkbox" value="{{ $product->id }}">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($product->images && count($product->images) > 0)
                                            <img src="{{ asset('storage/' . $product->images[0]) }}"
                                                alt="{{ $product->name }}" class="product-image me-3">
                                        @else
                                            <div
                                                class="product-image bg-light me-3 d-flex align-items-center justify-content-center">
                                                {{ strtoupper(substr($product->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <p class="text-muted mb-0 small">{{ Str::limit($product->description, 50) }}
                                            </p>
                                            <small class="text-muted">SKU: {{ $product->sku ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($product->category)
                                        <span class="badge bg-info">{{ $product->category->name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>${{ number_format($product->price, 2) }}</strong>
                                    @if ($product->compare_price)
                                        <br>
                                        <small class="text-muted text-decoration-line-through">
                                            ${{ number_format($product->compare_price, 2) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->track_quantity)
                                        <span class="badge bg-{{ $product->quantity > 0 ? 'success' : 'danger' }}">
                                            {{ $product->quantity }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Unlimited</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->is_visible)
                                        <span class="badge bg-success">Visible</span>
                                    @else
                                        <span class="badge bg-danger">Hidden</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->is_featured)
                                        <span class="badge bg-warning text-dark">Featured</span>
                                    @else
                                        <span class="badge bg-secondary">Regular</span>
                                    @endif
                                </td>
                                <td class="table-actions">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-info"
                                        title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.products.toggle-visibility', $product) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm btn-{{ $product->is_visible ? 'secondary' : 'success' }}"
                                            title="{{ $product->is_visible ? 'Hide' : 'Publish' }}">
                                            <i class="bi bi-{{ $product->is_visible ? 'eye-slash' : 'eye' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm btn-{{ $product->is_featured ? 'secondary' : 'warning' }}"
                                            title="{{ $product->is_featured ? 'Unfeature' : 'Feature' }}">
                                            <i class="bi bi-{{ $product->is_featured ? 'star' : 'star-fill' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        class="d-inline" onsubmit="return confirmDelete(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }}
                    products
                </div>
                <div>
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions Modal -->
    <div class="modal fade" id="bulkModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Actions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="bulkForm" method="POST" action="{{ route('admin.products.bulk-actions') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Selected Products: <span id="selectedCount">0</span></label>
                            <input type="hidden" name="ids" id="selectedIds">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Action</label>
                            <select name="action" class="form-select" required>
                                <option value="">Select Action</option>
                                <option value="delete">Delete Selected</option>
                                <option value="visible">Publish Selected</option>
                                <option value="hidden">Hide Selected</option>
                                <option value="featured">Mark as Featured</option>
                                <option value="unfeatured">Remove Featured</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Apply Action</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Select all checkbox
                $('#selectAll').change(function() {
                    $('.product-checkbox').prop('checked', this.checked);
                    updateSelectedCount();
                });

                // Update selected count
                function updateSelectedCount() {
                    const selected = $('.product-checkbox:checked');
                    $('#selectedCount').text(selected.length);

                    const ids = selected.map(function() {
                        return $(this).val();
                    }).get();

                    $('#selectedIds').val(JSON.stringify(ids));
                }

                $('.product-checkbox').change(updateSelectedCount);

                // Bulk form submission
                $('#bulkForm').submit(function(e) {
                    if (!$('#selectedIds').val()) {
                        e.preventDefault();
                        alert('Please select at least one product.');
                        return false;
                    }

                    const action = $('select[name="action"]').val();
                    if (!action) {
                        e.preventDefault();
                        alert('Please select an action.');
                        return false;
                    }

                    if (action === 'delete') {
                        if (!confirm('Are you sure you want to delete selected products?')) {
                            e.preventDefault();
                            return false;
                        }
                    }

                    return true;
                });
            });
        </script>
    @endpush
@endsection
