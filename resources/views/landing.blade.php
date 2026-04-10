<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Sistem Manajemen jual Motor</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Beli Motor</a>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                @if(session()->has('user'))
                <span class="text-white me-3">
                    Hai {{ session('user') }}
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="btn btn-warning btn-sm">
                    Login
                </a>
                @endif
            </div>

            <div class="ms-auto">
                <button class="btn btn-outline-warning btn-sm me-2" data-bs-toggle="modal"
                    data-bs-target="#wishlistModal">
                    Wishlist (<span id="wishlist-count">{{ session('wishlist') ? count(session('wishlist')) : 0 }}</span>)
                </button>

                <button id="btn-theme" class="btn btn-outline-light btn-sm">
                    Mode Gelap
                </button>
            </div>
        </div>
    </nav>

    <div class="hero-section text-center">
        <div>
            <h1 class="display-4">Sistem Manajemen jual Motor</h1>
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
        
        <div class="row justify-content-start" id="container-barang">
            @forelse($products as $product)
            <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex justify-content-center">
                <div class="card h-100 shadow-sm" style="border-radius:12px; min-width:340px; max-width:370px; width:100%;">
                    <div class="card-body d-flex flex-column">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid mb-3" style="width:100%;max-height:170px;object-fit:contain;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.03);background:#fff;">
                        @else
                            <div style="width:100%;height:170px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;border-radius:8px;margin-bottom:1rem;">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif
                        <h5 class="fw-bold mb-1" style="font-size:1.1rem;">{{ $product->name }}</h5>
                        @if($product->categories && count($product->categories))
                            @foreach($product->categories as $category)
                                <span class="badge bg-secondary mb-2" style="font-size:0.85em;">{{ $category->name }}</span>
                            @endforeach
                        @endif
                        <p class="text-danger mb-1 mt-2" style="font-size:1.05rem;font-weight:500;">Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="mb-3" style="font-size:0.98rem;">Stok: {{ $product->stock }}</p>
                        <div class="d-flex gap-2 mt-auto">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-primary w-100">Beli</button>
                            </form>
                            <form action="{{ route('wishlist.add', $product->id) }}" method="POST" class="w-100">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger w-100">Wishlist</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">Belum ada produk tersedia.</div>
            </div>
            @endforelse
        </div>

        <div class="modal fade" id="wishlistModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Daftar Wishlist Saya</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <ul class="list-group" id="daftar-wishlist">
                            @forelse($wishlistProducts as $item)
                                <li class="list-group-item py-3 px-2">
                                    <div class="d-flex align-items-center gap-3">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" style="width:48px;height:48px;object-fit:cover;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.07);">
                                        @else
                                            <div style="width:48px;height:48px;background:#f0f0f0;display:flex;align-items:center;justify-content:center;border-radius:8px;">
                                                <span class="text-muted">No Image</span>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <div class="fw-bold mb-1" style="font-size:1.08em;">{{ $item->name }}</div>
                                            <div class="text-danger mb-1" style="font-size:1.02em;">Rp{{ number_format($item->price, 0, ',', '.') }}</div>
                                            <div class="text-muted mb-1" style="font-size:0.97em;">Stok: {{ $item->stock }}</div>
                                            @if($item->categories && count($item->categories))
                                                <div class="mb-1">
                                                    @foreach($item->categories as $cat)
                                                        <span class="badge bg-secondary" style="font-size:0.82em;">{{ $cat->name }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                        <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="ms-auto" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm px-3">Hapus</button>
                                        </form>
                                    </div>
                                </li>
                            @empty
                                <li class="list-group-item text-muted">Wishlist kosong</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <form action="{{ route('wishlist.clear') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">Kosongkan</button>
                        </form>
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
                        <label class="form-label">Harga Beli</label>
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

        <footer class="footer-full bg-dark text-white text-center py-3 mt-5">
            <p>&copy; Sistem Manajemen jual Motor</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('js/script.js') }}"></script>

</body>

</html>