@extends('layouts.admin')

@section('title', 'Category Tree View')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Category Tree</h1>
                    <p class="mt-2 text-sm text-gray-600">Drag and drop to reorder categories</p>
                </div>
                <div class="flex space-x-4">
                    <a href="{{ route('admin.product-categories.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        List View
                    </a>
                    <a href="{{ route('admin.product-categories.create') }}"
                        class="px-4 py-2 bg-gray-200 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        + Add Category
                    </a>
                </div>
            </div>

            <!-- Instructions Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">How to use</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Drag and drop categories to reorder them</li>
                                <li>Click on expand/collapse icons to show/hide subcategories</li>
                                <li>Changes are saved automatically when you drop a category</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category Tree -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <div id="category-tree" class="space-y-2">
                        @forelse($categories as $category)
                            @include('admin.product-categories.partials.tree-item', [
                                'category' => $category,
                                'level' => 0,
                            ])
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No categories found</p>
                                <a href="{{ route('admin.product-categories.create') }}"
                                    class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Create First Category
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Categories</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $categories->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Categories</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $categories->where('is_active', true)->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">With Subcategories</p>
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $categories->filter(fn($cat) => $cat->children->count() > 0)->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize sortable for each category level
                const trees = document.querySelectorAll('.sortable-list');

                trees.forEach(tree => {
                    new Sortable(tree, {
                        animation: 150,
                        handle: '.drag-handle',
                        ghostClass: 'bg-blue-100',
                        dragClass: 'opacity-50',
                        onEnd: function(evt) {
                            updateCategoryOrder(evt.to);
                        }
                    });
                });

                // Toggle subcategories
                document.querySelectorAll('.toggle-children').forEach(button => {
                    button.addEventListener('click', function() {
                        const categoryId = this.dataset.categoryId;
                        const childrenContainer = document.getElementById(`children-${categoryId}`);
                        const icon = this.querySelector('svg');

                        if (childrenContainer.classList.contains('hidden')) {
                            childrenContainer.classList.remove('hidden');
                            icon.style.transform = 'rotate(90deg)';
                        } else {
                            childrenContainer.classList.add('hidden');
                            icon.style.transform = 'rotate(0deg)';
                        }
                    });
                });
            });

            function updateCategoryOrder(container) {
                const items = container.querySelectorAll('.category-item');
                const categories = [];

                items.forEach((item, index) => {
                    categories.push({
                        id: item.dataset.categoryId,
                        order: index
                    });
                });

                // Send AJAX request to update order
                fetch('{{ route('admin.product-categories.update-order') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            categories: categories
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            showNotification('Order updated successfully', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to update order', 'error');
                    });
            }

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${
        type === 'success' ? 'bg-green-500' : 'bg-red-500'
    }`;
                notification.textContent = message;

                document.body.appendChild(notification);

                setTimeout(() => {
                    notification.remove();
                }, 3000);
            }
        </script>
    @endpush
@endsection
