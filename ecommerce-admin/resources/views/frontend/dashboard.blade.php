@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">Welcome back, {{ $user->name }}!</h1>
            </div>
        </div>

        <div class="row">
            <!-- Profile Summary Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user"></i> Profile Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Member Since:</strong> {{ $user->created_at->format('M d, Y') }}</p>

                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary mt-2">
                            <i class="fas fa-edit"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt"></i> Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="{{ route('home') }}" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-bag"></i> Browse Products
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-shopping-cart"></i> View Cart
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-box"></i> My Orders
                            </a>
                            <a href="#" class="list-group-item list-group-item-action">
                                <i class="fas fa-heart"></i> Wishlist
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Stats Card -->
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line"></i> Account Stats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="mb-0">0</h3>
                                    <small class="text-muted">Total Orders</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3">
                                    <h3 class="mb-0">0</h3>
                                    <small class="text-muted">Wishlist Items</small>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="border rounded p-3">
                                    <h3 class="mb-0">$0.00</h3>
                                    <small class="text-muted">Total Spent</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history"></i> Recent Activity
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i> No recent activity to display.
                        </div>
                        <!-- You can add a table or list of recent orders/activities here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
