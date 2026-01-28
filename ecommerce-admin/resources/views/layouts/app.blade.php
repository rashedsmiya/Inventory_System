<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }} Admin</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <!-- Custom CSS -->
    @vite(['resources/css/index.css'])
    @stack('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3 text-white bg-dark text-center mb-4">
            <h5 class="text-white mb-0">{{ config('app.name') }}</h5>
            <small class=" text-gray-300">Administration Panel</small>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>

            <!-- User Management -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>

            <!-- Admin Management -->
            @if (auth()->user()->isSuperAdmin())
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}"
                        href="{{ route('admin.admins.index') }}">
                        <i class="bi bi-shield-check"></i> Admins
                    </a>
                </li>
            @endif

            <!-- Product Management -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                    href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box"></i> Products
                </a>
            </li>

            <!-- Product Categories -->
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}"
                    href="{{ route('admin.product-categories.index') }}">
                    <i class="bi bi-tags"></i> Categories
                </a>
            </li>

            <li class="nav-item mt-4">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="bi bi-house-door"></i> Back to Site
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark navbar-admin">
            <div class="container-fluid">
                <button class="btn btn-dark d-lg-none" type="button" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>

                <div class="d-flex align-items-center">
                    <h6 class="text-white mb-0">Welcome, {{ auth()->user()->name }}</h6>
                </div>

                <div class="navbar-nav">
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.view') }}">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid p-4">

            @yield('content')

        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- DataTables -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('mainContent').classList.toggle('expanded');
        });

        // Initialize DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                pageLength: 25,
                responsive: true,
                order: [
                    [0, 'desc']
                ]
            });

            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });

        // Confirm delete
        function confirmDelete(event) {
            if (!confirm('Are you sure you want to delete this item?')) {
                event.preventDefault();
                return false;
            }
            return true;
        }

        // Toast notification
        @if (session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if (session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        function showToast(type, message) {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            const container = document.createElement('div');
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.appendChild(toast);
            document.body.appendChild(container);

            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', function() {
                container.remove();
            });
        }
    </script>

    @stack('scripts')
</body>

</html>
