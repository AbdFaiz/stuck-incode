<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Stack Overflow</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #6c757d;
        }

        .navbar .navbar-brand {
            color: #fff;
            font-size: 1.5rem;
        }

        .navbar-nav .nav-link {
            color: #fff;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            margin-top: 30px;
            text-align: center;
            color: #6c757d;
        }

        .form-section {
            padding: 20px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
        }

        .scrollable-sidebar {
            height: calc(100vh - 1rem);
            overflow-y: auto;
        }

        .scrollable-container {
            height: calc(100vh - 1rem);
            overflow-y: auto;
        }

        /* Sidebar fixed position */
        .sidebar-fixed {
            position: fixed;
            top: 1rem;
            bottom: 1rem;
            width: 100%;
            height: calc(100vh - 2rem);
            overflow-y: auto;
            z-index: 1000;
        }

        .content-scrollable {
            margin-left: 25%;
            padding: 1rem;
            height: calc(100vh - 2rem);
            overflow-y: auto;
        }

        .instruction-section {
            border-radius: 14px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('image/taktak.png') }}"style="height: 40px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Questions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tags</a>
                    </li>
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                    @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif

                    @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="mt-5 p-3 d-flex justify-content-center bg-primary text-white fw-semibold">
        Copyright &copy; Zet dan Fz
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>