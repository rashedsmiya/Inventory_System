@extends('layouts.admin')

@section('title', 'View User')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">
                        &larr; Back to Users
                    </a>
                    <a href="{{ route('admin.users.edit', $user) }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit User
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information Card -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <!-- User Header -->
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div
                                        class="h-20 w-20 rounded-full bg-white flex items-center justify-center text-blue-600 font-bold text-3xl shadow-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-6">
                                    <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                                    <p class="text-blue-100">{{ $user->email }}</p>
                                    <div class="mt-2 flex items-center space-x-2">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $user->role === 'admin' ? 'bg-purple-200 text-purple-800' : 'bg-white text-blue-600' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full
                                        {{ $user->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Information -->
                        <div class="px-6 py-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h3>

                            <dl class="grid grid-cols-1 gap-4">
                                <!-- User ID -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">User ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->id }}</dd>
                                </div>

                                <!-- Full Name -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                                </div>

                                <!-- Email Address -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 flex items-center">
                                        {{ $user->email }}
                                        @if ($user->email_verified_at)
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Verified
                                            </span>
                                        @else
                                            <span
                                                class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Not Verified
                                            </span>
                                        @endif
                                    </dd>
                                </div>

                                <!-- Role -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Role</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Status -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>

                                <!-- Created At -->
                                <div class="border-b border-gray-200 pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Account Created</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->created_at->format('F d, Y \a\t g:i A') }}
                                        <span class="text-gray-500">({{ $user->created_at->diffForHumans() }})</span>
                                    </dd>
                                </div>

                                <!-- Updated At -->
                                <div class="pb-3">
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $user->updated_at->format('F d, Y \a\t g:i A') }}
                                        <span class="text-gray-500">({{ $user->updated_at->diffForHumans() }})</span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with Actions and Stats -->
                <div class="lg:col-span-1">
                    <!-- Quick Actions Card -->
                    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('admin.users.edit', $user) }}"
                                class="flex items-center w-full px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-md hover:bg-blue-100">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Edit User
                            </a>

                            @if (!$user->email_verified_at)
                                <button
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-md hover:bg-green-100"
                                    onclick="alert('This would send a verification email')">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    Send Verification Email
                                </button>
                            @endif

                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-md hover:bg-red-100">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete User
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Activity Stats Card -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Account Stats</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Days Active</span>
                                <span class="text-lg font-semibold text-gray-900">
                                    {{ $user->created_at->diffInDays(now()) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Account Age</span>
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $user->created_at->diffForHumans(null, true) }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Email Status</span>
                                <span
                                    class="text-sm font-medium {{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
