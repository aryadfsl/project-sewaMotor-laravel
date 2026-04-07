<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen Rental Motor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Rental Motor</a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                @if(session()->has('user'))
                <span class="text-white me-3">
                    {{ session('user') }}
                </span>
                <a href="{{ route('logout') }}" class="btn btn-danger btn-sm">
                    Logout
                </a>
                @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                    Login
                </a>
                @endif
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

    <div class="hero-section text-center">
        <div>
            <h1 class="display-4">Sistem Manajemen Rental Motor</h1>
            <p class="lead">Kelola data motor dan transaksi penyewaan dengan sistem modern.</p>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-box statistik-icon statistik-icon-motor"></i>
                        <h5 class="mt-2">Total Motor</h5>
                        <h2>85</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-check-circle statistik-icon statistik-icon-tersedia"></i>
                        <h5 class="mt-2">Motor Tersedia</h5>
                        <h2>100</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text statistik-icon statistik-icon-transaksi"></i>
                        <h5 class="mt-2">Total Transaksi</h5>
                        <h2>12</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <h3 class="mb-4">Daftar Motor Tersedia</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">Tambah
            Produk</button>
        <div class="row" id="container-barang">
            @foreach ($products as $item)
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-tittle mt-2">{{ $item->product_name }}</h5>
                        <span class="badge bg-secondary mb-2">{{ $item->category->category_name }}</span>
                        @if($item->brand)
                        <span class="badge bg-secondary mb-2">{{ $item->brand->nama_brand }}</span>
                        @endif
                        <p class="card-text text-danger">
                            Rp{{ number_format($item->product_price, 0, ',', '.') }}
                        </p>
                        <p class="card-text">Stok: {{ $item->product_stock }} </p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-detail w-50 me-2">Beli</button>
                            <button class="btn btn-outline-danger btn-wishlist w-50">♥ Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="modal fade" id="wishlistModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Daftar Wishlist Saya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <ul class="list-group" id="daftar-wishlist"></ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-danger" onclick="hapusWishlist()">Kosongkan</button>
                </div>

            </div>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        <h3 class="mb-4">Tambah Motor</h3>

        <div class="card p-4">
            <form>
                <div class="mb-3">
                    <label class="form-label">Nama Motor</label>
                    <input type="text" class="form-control" placeholder="Masukkan nama motor" />
                    <div class="invalid-feedback">Nama motor wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Sewa per Hari</label>
                    <input type="text" class="form-control" placeholder="Masukkan harga" />
                    <div class="invalid-feedback">Masukkan harga yang valid.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Plat Nomor</label>
                    <input type="text" class="form-control" placeholder="Masukkan plat nomor" />
                    <div class="invalid-feedback">Plat nomor wajib diisi.</div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kategori</label>
                    <select class="form-select">
                        <option>Sport</option>
                        <option>Trail</option>
                        <option>Harioan</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="tambahProdukModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="tambahProdukModalLabel">Tambah Produk</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" required>
                        </div>

                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($category as $cat)
                                <option value="{{ $cat->category_id }}">{{ $cat->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="brand_id" class="form-label">Brand</label>
                            <select class="form-control" id="brand_id" name="brand_id" required>
                                <option value="">Pilih Brand</option>
                                @foreach ($brands as $brand)
                                <option value="{{ $brand->brand_id }}">{{ $brand->nama_brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Harga Produk</label>
                            <input type="number" class="form-control" id="product_price" name="product_price" required>
                        </div>

                        <div class="mb-3">
                            <label for="product_stock" class="form-label">Stok Produk</label>
                            <input type="number" class="form-control" id="product_stock" name="product_stock" required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                Kembali
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Simpan Produk
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="footer-full bg-dark text-white text-center py-3 mt-5">
        <p>&copy; Sistem Manajemen Sewa Motor</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>