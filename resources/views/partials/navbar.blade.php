<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental Motor')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f5f5f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            padding: 14px 0;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 700;
        }

        .btn-navbar {
            border-radius: 10px;
            padding: 6px 16px;
            transition: 0.3s;
            font-weight: 500;
        }

        .btn-navbar:hover {
            transform: translateY(-2px);
        }

        main {
            flex: 1;
        }

        footer {
            background: #212529;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .dark-mode {
            background-color: #121212 !important;
            color: white !important;
        }

        .dark-mode .card {
            background-color: #1e1e1e;
            color: white;
        }

        .dark-mode footer {
            background-color: black;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">

            <a class="navbar-brand text-warning" href="{{ route('home') }}">
                Rental Motor
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">

                <div class="d-flex align-items-center gap-2 flex-wrap">

                    @auth

                        <a href="{{ route('dashboard') }}"
                            class="btn btn-primary btn-sm btn-navbar">
                            Profil
                        </a>

                        <a href="{{ route('products') }}"
                            class="btn btn-warning btn-sm btn-navbar text-dark">
                            Produk
                        </a>

                        <a href="{{ route('profile.edit') }}"
                            class="btn btn-outline-light btn-sm btn-navbar">
                            {{ auth()->user()->name }}
                        </a>

                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit"
                                class="btn btn-danger btn-sm btn-navbar">
                                Logout
                            </button>
                        </form>

                    @else

                        <a href="{{ route('home') }}"
                            class="btn btn-secondary btn-sm btn-navbar">
                            Guest
                        </a>

                        <a href="{{ route('login') }}"
                            class="btn btn-warning btn-sm btn-navbar text-dark">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                            class="btn btn-outline-warning btn-sm btn-navbar">
                            Register
                        </a>


                    @endauth

                    <button class="btn btn-outline-warning btn-sm btn-navbar"
                        data-bs-toggle="modal"
                        data-bs-target="#wishlistModal"
                        onclick="tampilkanWishlist()">
                        Wishlist (<span id="wishlist-count">0</span>)
                    </button>

                    <button id="btn-theme"
                        class="btn btn-outline-light btn-sm btn-navbar">
                        Mode Gelap
                    </button>

                </div>

            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        © Sistem Manajemen Sewa Motor
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const btnTheme = document.getElementById('btn-theme');

        btnTheme.addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');

            if (document.body.classList.contains('dark-mode')) {
                btnTheme.innerText = 'Mode Terang';
            } else {
                btnTheme.innerText = 'Mode Gelap';
            }
        });
    </script>

</body>

</html>