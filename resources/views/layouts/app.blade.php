<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    @yield('tittle')
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/css/landing.css','resources/js/app.js'])
    <!-- Preline UI -->
    <link href="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body">
    <!-- DataTables CSS & JS CDN -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Navbar -->
    @yield('navbar')
    <!-- Sidebar -->
    @yield('sidebar')
    <!-- Main Content -->
    @yield('content')
    <!-- Footer -->
    @yield('footer')

    <!-- Preline UI JS (for interactive components if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/preline@2.0.3/dist/preline.min.js"></script>

    <!-- Preline UI CDN -->
    <script src="https://unpkg.com/preline@latest/dist/preline.js"></script>

    </body>
</html>
