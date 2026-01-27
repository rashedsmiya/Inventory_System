@extends('admin.layouts.app')

@section('title', 'Product Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Product Categories</h1>
        <div>
            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Category
            </a>
            <a href="{{ route('admin.product-categories.tree') }}" class="btn btn-outline-info">
                <i class="bi bi-diagram-3"></i> Tree View
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search categories..."
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </form>

            <!-- Categories Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Products</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th class="table-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if ($category->description)
                                        <p class="text-muted mb-0 small">{{ Str::limit($category->description, 50) }}</p>
                                    @endif
                                </td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    @if ($category->parent)
                                        <span class="badge bg-info">{{ $category->parent->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Root</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-primary">{{ $category->products_count ?? $category->products()->count() }}</span>
                                </td>
                                <td>
                                    @if ($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $category->order }}</td>
                                <td class="table-actions">
                                    <a href="{{ route('admin.product-categories.edit', $category) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.product-categories.toggle-status', $category) }}"
                                        method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="btn btn-sm btn-{{ $category->is_active ? 'warning' : 'success' }}"
                                            title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="bi bi-{{ $category->is_active ? 'x-circle' : 'check-circle' }}"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.product-categories.destroy', $category) }}"
                                        method="POST" class="d-inline" onsubmit="return confirmDelete(event)">
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
                                <td colspan="8" class="text-center">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }}
                    categories
                </div>
                <div>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Parent Category Modal -->
    <div class="modal fade" id="parentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Parent Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <select class="form-select" id="parentSelect">
                        <option value="">No Parent (Root Category)</option>
                        @foreach ($allCategories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="applyParent">Apply</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#applyParent').click(function() {
                    const categoryId = $(this).data('category-id');
                    const parentId = $('#parentSelect').val();

                    $.ajax({
                        url: `/admin/product-categories/${categoryId}/parent`,
                        method: 'PATCH',
                        data: {
                            parent_id: parentId
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                });

                $('.btn-parent').click(function() {
                    const categoryId = $(this).data('id');
                    $('#applyParent').data('category-id', categoryId);
                });
            });
        </script>
    @endpush
@endsection
