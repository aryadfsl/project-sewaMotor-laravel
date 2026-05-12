@extends('layouts.main')

@section('title', 'Sistem Manajemen Rental Motor')

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
                        <h5 class="mt-2">Brand Motor</h5>
                        <h2>{{ $products->pluck('brand_id')->filter()->unique()->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <div class="position-relative mb-3">
            <h3 class="mb-4 text-center">Daftar motor</h3>
            <a href="{{ route('products') }}" class="text-decoration-none text-dark fw-semibold position-absolute end-0 top-50 translate-middle-y" style="right:0;">
                Lihat semua produk >>>
            </a>
        </div>

        <div class="row justify-content-center" id="container-barang">
            @forelse ($products as $item)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->product_name }}">
                        @else
                            <img src="{{ asset('assets/harley1.jpg') }}" class="card-img-top" alt="{{ $item->product_name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title mt-2">{{ $item->product_name }}</h5>
                            @if($item->category)
                                <span class="badge bg-secondary mb-2">{{ $item->category->category_name }}</span>
                            @endif
                            @if($item->brand)
                                <span class="badge bg-secondary mb-2">{{ $item->brand->nama_brand }}</span>
                            @endif
                            <p class="card-text text-danger harga-text">
                                Harga: Rp {{ number_format($item->product_price, 0, ',', '.') }} / Hari
                            </p>
                            <p class="card-text stok-text">Stok: {{ $item->product_stock }}</p>
                            <div class="d-flex justify-content-between">
                                @guest
                                    <a href="{{ route('register') }}" class="btn btn-primary w-50 me-2">Sewa</a>
                                @else
                                    <button class="btn btn-primary btn-detail w-50 me-2">Sewa</button>
                                @endguest
                                <button class="btn btn-outline-danger btn-wishlist w-50">Wishlist</button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada data motor.
                    </div>
                </div>
            @endforelse
        </div>

        @include('partials.wishlist-modal')
    </div>
@endsection
