<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }} Frontend</title>

    <!-- Bootstrap 5 CSS -->
    @vite(['resources/css/bootstrap.min.css'])

    <!-- Bootstrap Icons -->
    @vite(['resources/css/bootstrap-icons.css'])


    <!-- DataTables -->
    @vite(['resources/css/dataTables.bootstrap5.min.css'])

    <!-- Select2 -->
    @vite(['resources/css/select2.min.css'])

    <!-- Custom CSS -->
    @vite(['resources/css/index.css'])

    @stack('styles')
</head>

<body>



    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->

        <!-- Page Content -->
        <div class="container-fluid p-4">

            @yield('content')

        </div>
    </div>


    @stack('scripts')

</body>

</html>
