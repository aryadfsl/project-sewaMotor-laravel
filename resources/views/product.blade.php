@extends('layouts.main')

@section('title', 'Daftar Motor Tersedia')

@section('content')
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
                        <h2>{{ $products->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-check-circle statistik-icon statistik-icon-tersedia"></i>
                        <h5 class="mt-2">Motor Tersedia</h5>
                        <h2>{{ $products->sum('product_stock') }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-text statistik-icon statistik-icon-transaksi"></i>
                        <h5 class="mt-2">Role Login</h5>
                        <h2 class="text-capitalize">{{ auth()->user()->role }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <h3 class="mb-4">Daftar Motor Tersedia</h3>

        @if(auth()->user()->role === 'admin')
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahProdukModal">
                Tambah Produk
            </button>
        @endif

        <div class="row" id="container-barang">
            @foreach ($products as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->product_name }}">
                        @else
                            <img src="{{ asset('assets/harley1.jpg') }}" class="card-img-top" alt="{{ $item->product_name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title mt-2">{{ $item->product_name }}</h5>
                            <span class="badge bg-secondary mb-2">{{ $item->category->category_name }}</span>
                            @if($item->brand)
                                <span class="badge bg-secondary mb-2">{{ $item->brand->nama_brand }}</span>
                            @endif
                            <p class="card-text text-danger harga-text">
                                Harga: Rp {{ number_format($item->product_price, 0, ',', '.') }} / Hari
                            </p>
                            <p class="card-text stok-text">Stok: {{ $item->product_stock }}</p>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-primary btn-detail w-50 me-2">Sewa</button>
                                <button class="btn btn-outline-danger btn-wishlist w-50">Wishlist</button>
                            </div>

                            @if(auth()->user()->role === 'admin')
                                <div class="d-flex justify-content-between mt-3">
                                    <button class="btn btn-warning w-50 me-2" data-bs-toggle="modal" data-bs-target="#editProdukModal{{ $item->product_id }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('products.destroy', $item->product_id) }}" method="POST" class="w-50" onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">Hapus</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role === 'admin')
                    <div class="modal fade" id="editProdukModal{{ $item->product_id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Edit Produk</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <form action="{{ route('products.update', $item->product_id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        @include('partials.product-form', ['product' => $item])
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle me-1"></i>Simpan Produk
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    @include('partials.wishlist-modal')

    @if(auth()->user()->role === 'admin')
        <div class="modal fade" id="tambahProdukModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="tambahProdukModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahProdukModalLabel">Tambah Produk</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            @include('partials.product-form', ['product' => null])
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-1"></i>Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
