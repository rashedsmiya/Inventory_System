@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Dashboard</h1>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-calendar"></i> Today
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-calendar-week"></i> This Week
            </button>
            <button type="button" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-calendar-month"></i> This Month
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Total Users</h6>
                            <h2 class="card-title">{{ $stats['total_users'] }}</h2>
                        </div>
                        <i class="bi bi-people fs-1 opacity-50"></i>
                    </div>
                    <p class="card-text mb-0">
                        <small>{{ $stats['new_users_today'] }} new today</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Active Users</h6>
                            <h2 class="card-title">{{ $stats['active_users'] }}</h2>
                        </div>
                        <i class="bi bi-person-check fs-1 opacity-50"></i>
                    </div>
                    <p class="card-text mb-0">
                        <small>{{ number_format(($stats['active_users'] / max($stats['total_users'], 1)) * 100, 1) }}%
                            active</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Admins</h6>
                            <h2 class="card-title">{{ $stats['total_admins'] }}</h2>
                        </div>
                        <i class="bi bi-shield-check fs-1 opacity-50"></i>
                    </div>
                    <p class="card-text mb-0">
                        <small>Managing the system</small>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-subtitle mb-2">Products</h6>
                            <h2 class="card-title">{{ App\Models\Product::count() }}</h2>
                        </div>
                        <i class="bi bi-box fs-1 opacity-50"></i>
                    </div>
                    <p class="card-text mb-0">
                        <small>{{ App\Models\Product::where('is_visible', true)->count() }} visible</small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Users -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Users</h5>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Joined</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($user->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Admins -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Admins</h5>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Last Active</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($recent_admins as $admin)
                                    <tr>
                                        <td>{{ $admin->name }}</td>
                                        <td>
                                            @if ($admin->isSuperAdmin())
                                                <span class="badge bg-danger">Super Admin</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Admin</span>
                                            @endif
                                        </td>
                                        <td>{{ $admin->updated_at->diffForHumans() }}</td>
                                        <td>
                                            @if ($admin->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-person-plus"></i>
                                <span class="d-block mt-1">Add User</span>
                            </a>
                        </div>
                        @if (auth()->user()->isSuperAdmin())
                            <div class="col-md-3 col-6">
                                <a href="{{ route('admin.admins.create') }}" class="btn btn-outline-danger w-100">
                                    <i class="bi bi-shield-plus"></i>
                                    <span class="d-block mt-1">Add Admin</span>
                                </a>
                            </div>
                        @endif
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-plus-circle"></i>
                                <span class="d-block mt-1">Add Product</span>
                            </a>
                        </div>
                        <div class="col-md-3 col-6">
                            <a href="{{ route('admin.product-categories.create') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-tag"></i>
                                <span class="d-block mt-1">Add Category</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
