<div class="category-item border border-gray-200 rounded-lg mb-2 bg-white" data-category-id="{{ $category->id }}"
    style="margin-left: {{ $level * 30 }}px;">

    <div class="flex items-center p-3 hover:bg-gray-50">
        <!-- Drag Handle -->
        <div class="drag-handle cursor-move mr-3 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z">
                </path>
            </svg>
        </div>

        <!-- Toggle Button (if has children) -->
        @if ($category->children->count() > 0)
            <button type="button" class="toggle-children mr-2 text-gray-500 hover:text-gray-700 focus:outline-none"
                data-category-id="{{ $category->id }}">
                <svg class="w-5 h-5 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        @else
            <div class="w-5 mr-2"></div>
        @endif

        <!-- Category Icon -->
        <div class="flex-shrink-0 mr-3">
            @if ($category->icon)
                <span class="text-2xl">{{ $category->icon }}</span>
            @else
                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                </div>
            @endif
        </div>

        <!-- Category Info -->
        <div class="flex-1 min-w-0">
            <div class="flex items-center">
                <h3 class="text-sm font-medium text-gray-900 truncate">{{ $category->name }}</h3>

                <!-- Badges -->
                <div class="ml-2 flex items-center space-x-2">
                    <span
                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>

                    @if ($category->children->count() > 0)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                            {{ $category->children->count() }} {{ Str::plural('child', $category->children->count()) }}
                        </span>
                    @endif
                </div>
            </div>

            @if ($category->description)
                <p class="text-xs text-gray-500 truncate mt-1">{{ $category->description }}</p>
            @endif

            @if ($category->slug)
                <p class="text-xs text-gray-400 mt-1">
                    <span class="font-mono">{{ $category->slug }}</span>
                </p>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center space-x-2 ml-4">
            <a href="{{ route('admin.product-categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800"
                title="Edit">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>

            <form action="{{ route('admin.product-categories.destroy', $category) }}" method="POST" class="inline"
                onsubmit="return confirm('Are you sure you want to delete this category?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Children (Subcategories) -->
    @if ($category->children->count() > 0)
        <div id="children-{{ $category->id }}" class="sortable-list pl-8 pr-3 pb-3">
            @foreach ($category->children as $child)
                @include('admin.product-categories.partials.tree-item', [
                    'category' => $child,
                    'level' => $level + 1,
                ])
            @endforeach
        </div>
    @endif
</div>
