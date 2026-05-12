<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">Rental Motor</a>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">Dashboard</a>
                <a href="{{ route('products') }}" class="btn btn-outline-light btn-sm me-2">Produk</a>
                <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none me-3">
                    {{ auth()->user()->name }}
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-sm me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-outline-warning btn-sm">Register</a>
            @endauth
        </div>

        <div class="ms-auto">
            <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal"
                data-bs-target="#wishlistModal" onclick="tampilkanWishlist()">
                Wishlist (<span id="wishlist-count">0</span>)
            </button>

            <button id="btn-theme" class="btn btn-outline-light btn-sm">
                Mode Gelap
            </button>
        </div>
    </div>
</nav>
