<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Web</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- AOS (Animate On Scroll) CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tambahkan favicon jika ada -->
    <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">

    <!-- Custom CSS (Inline Style) -->
    <style>
        /* Warna sesuai dengan tema Flutter */

        /* Variabel Warna */
        :root {
            --color-start: {{ $settings->color_start ?? '#446496' }};
            --color-end: {{ $settings->color_end ?? '#88A5DB' }};
            --color-background: {{ $settings->color_background ?? '#EBF1F6' }};
            --color-accent: #4A6FA5;
            /* Color(74, 111, 165) */
            --color-accent-light: #65A1EA;
            /* Color(101, 161, 234) */
        }

        body {
            background-color: var(--color-background);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 35px;
        }

        /* Navbar dengan Gradient Background */
        .navbar {
            background: linear-gradient(135deg, var(--color-start), var(--color-end)) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            font-weight: 600;
            font-size: 24px;
            letter-spacing: 1.1px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
            color: #fff;
        }

        .navbar .nav-link {
            font-weight: 500;
            font-size: 16px;
            margin-right: 10px;
            position: relative;
            overflow: hidden;
            color: #fff;
        }

        .navbar .nav-link.active {
            text-decoration: underline;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .navbar .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        .navbar-brand img {
            width: 50px;
            height: 50px;
        }

        @media (max-width: 768px) {
            .navbar-brand img {
                width: 40px;
                height: 40px;
            }
        }


        /* Button Styles */
        .btn-outline-light {
            border-color: #fff;
            color: #fff;
        }

        .btn-outline-light:hover {
            background-color: #fff;
            color: var(--color-accent);
        }

        /* Dropdown Menu */
        .dropdown-menu {
            background-color: rgba(255, 255, 255, 0.9);
        }

        .dropdown-item:hover {
            background-color: var(--color-background);
            color: var(--color-accent);
        }

        /* Footer dengan Glassmorphic Effect */
        .footer {
            background: linear-gradient(135deg, var(--color-start), var(--color-end));
            color: #fff;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            margin-top: auto;
        }


        .footer .text-muted {
            color: #fff !important;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar .nav-link {
                font-size: 14px;
            }

            .navbar .navbar-brand {
                font-size: 20px;
            }
        }

        /* Animasi untuk elemen saat halaman dimuat */
        .animate-on-load {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s forwards;
    animation-delay: 0.5s; /* Opsional, untuk sinkronisasi dengan placeholder loading */
}

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }

            from {
                opacity: 0;
                transform: translateY(20px);
            }
        }

        main {
    margin-top: 70px; /* Adjust based on your navbar's height */
}

#loading-placeholder {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: var(--color-background);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}


    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Navbar dengan Gradient Background -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <!-- Logo atau Judul -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('storage/' . ($settings->logo ?? 'images/logo2.png')) }}" 
                     alt="Logo" 
                     width="40" 
                     height="40" 
                     class="me-2">
                <span>{{ $settings->school_name ?? 'SMKN 4 Bogor' }}</span>
            </a>

            <!-- Toggle Button untuk Mobile View -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Navigasi -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left Side Menu -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Menu Items -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}"><i class="fas fa-home me-1"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery.*') ? 'active' : '' }}"
                            href="{{ route('gallery.index') }}"><i class="fas fa-images me-1"></i>Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('albums.*') ? 'active' : '' }}"
                            href="{{ route('albums.index') }}"><i class="fas fa-photo-video me-1"></i>Albums</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('info.index') ? 'active' : '' }}"
                            href="{{ route('info.index') }}"><i class="fas fa-info-circle me-1"></i>Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('agenda.index') ? 'active' : '' }}"
                            href="{{ route('agenda.index') }}"><i class="fas fa-calendar-alt me-1"></i>Agenda</a>
                    </li>
                    @auth
                    @if (Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.index') ? 'active' : '' }}"
                            href="{{ route('dashboard.index') }}"><i
                                class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                    @endif
                    @endauth
                </ul>

                <!-- Right Side Menu -->
                <ul class="navbar-nav">
                    @auth
                    <!-- Dropdown Profile -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" id="navbarDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('user.profile') }}"><i
                                        class="fas fa-user me-1"></i>My Profile</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST"
                                    class="dropdown-item p-0 m-0">
                                    @csrf
                                    <button
                                        class="btn btn-link text-decoration-none w-100 text-start"><i
                                            class="fas fa-sign-out-alt me-1"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <!-- Tombol Login -->
                    <li class="nav-item">
                        <a class="btn btn-outline-light" href="{{ route('login') }}"><i
                                class="fas fa-sign-in-alt me-1"></i>Login</a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div id="loading-placeholder">
    <div class="container">
        <div class="row">
            @for ($i = 0; $i < 8; $i++)
                <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                    <div class="skeleton-card">
                        <div class="skeleton-image"></div>
                        <div class="skeleton-text"></div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</div>

<!-- Main Content -->
<main id="page-content" class="container my-5 animate-on-load" style="flex: 1;">
    @yield('content')
</main>




    <!-- Footer dengan Gradient Background -->
    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <span class="text-muted">Copyright 2024 SMKN 4 Bogor. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS (Animate On Scroll) JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>

    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.3/gsap.min.js"></script>

    <!-- Inisialisasi AOS -->
    <script>
    window.addEventListener('load', function() {
        document.getElementById('loading-placeholder').style.display = 'none';
    });
</script>


    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    </script>

    <!-- Inisialisasi Animasi GSAP -->
    <script>
        gsap.from('.navbar', {
            duration: 1,
            y: -100,
            opacity: 0,
            ease: 'bounce'
        });
        gsap.from('.footer', {
            duration: 1,
            y: 100,
            opacity: 0,
            ease: 'power4.out'
        });
    </script>

    <!-- Tambahkan JS Custom jika diperlukan -->
    @stack('scripts')
</body>

</html>