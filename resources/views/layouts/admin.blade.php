<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Custom Styles -->
    <style>
        /* Custom Theme Colors */
        :root {
            --color-start: #446496;
            --color-end: #88A5DB;
            --color-background: #EBF1F6;
            --color-accent: #4A6FA5;
            --color-accent-light: #65A1EA;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--color-background);
            margin: 0;
            transition: background-color 0.3s ease;
        }

        .navbar {
            background: linear-gradient(90deg, var(--color-start), var(--color-end));
            position: sticky;
            top: 0;
            z-index: 10;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            color: #fff;
        }

        .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar-nav .nav-link.active {
            color: #ddd;
            font-weight: bold;
        }

        .sidebar {
            background-color: var(--color-accent);
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 250px;
            padding-top: 60px;
            z-index: 5;
        }

        .sidebar a {
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar a:hover {
            background-color: var(--color-accent-light);
        }

        .sidebar .active {
            background-color: var(--color-end);
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            background-color: #ffffff;
            min-height: 100vh;
        }

        .sidebar.collapsed {
            transform: translateX(-250px);
        }

        .main-content.collapsed {
            margin-left: 0;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: block;
                position: absolute;
                z-index: 9999;
                transform: translateX(-250px);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }
        }

        .sidebar-toggler {
            display: block;
            background-color: var(--color-accent);
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            text-align: left;
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 10000;
        }

        .footer {
            background-color: var(--color-accent);
            color: #fff;
        }
    </style>

    <!-- Bootstrap Bundle with Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard.index') }}"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-link text-white"><i class="fas fa-sign-out-alt"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
            <i class="fas fa-globe"></i> Home
        </a>
        <a class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}" href="{{ route('users.index') }}">
            <i class="fas fa-users"></i> Manage Users
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard.galleries.*') ? 'active' : '' }}" href="{{ route('dashboard.galleries.index') }}">
            <i class="fas fa-images"></i> Manage Galleries
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard.albums.*') ? 'active' : '' }}" href="{{ route('dashboard.albums.index') }}">
            <i class="fas fa-book"></i> Manage Albums
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard.infos.index') ? 'active' : '' }}" href="{{ route('dashboard.infos.index') }}">
            <i class="fas fa-info-circle"></i> Manage Info
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard.agendas.index') ? 'active' : '' }}" href="{{ route('dashboard.agendas.index') }}">
            <i class="fas fa-calendar-alt"></i> Manage Agendas
        </a>
        <a class="nav-link {{ request()->routeIs('dashboard.settings.*') ? 'active' : '' }}" href="{{ route('dashboard.settings.index') }}">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>

    <!-- Toggle Button for Sidebar -->
    <button class="sidebar-toggler d-md-none" type="button" onclick="toggleSidebar()">
        <span class="navbar-toggler-icon"></span> Menu
    </button>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer d-flex justify-content-center align-items-center py-3 mt-5">
        <small>&copy; <span id="currentYear"></span> Admin Dashboard</small>
    </footer>

    @stack('scripts')

    <script>
        // Toggle Sidebar function
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Automatically update the current year in the footer
        document.getElementById('currentYear').textContent = new Date().getFullYear();

                // SweetAlert2 for session messages
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
</body>

</html>
