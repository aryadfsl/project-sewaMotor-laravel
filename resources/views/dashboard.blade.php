@extends('layouts.main')

@section('title', 'Profile')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center g-4">

        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 h-100">
                
                <div class="card-body text-center p-5">

                    @if(auth()->user()->profile_photo)
                        <img 
                            src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                            class="rounded-circle shadow mb-4"
                            width="140"
                            height="140"
                            style="object-fit: cover; border: 4px solid #f1f1f1;"
                            alt="{{ auth()->user()->name }}"
                        >
                    @else
                        <i class="bi bi-person-circle display-1 text-secondary mb-3"></i>
                    @endif

                    <h3 class="fw-bold mb-1">
                        {{ auth()->user()->name }}
                    </h3>

                    <p class="text-muted mb-3">
                        {{ auth()->user()->email }}
                    </p>

                    <span class="badge bg-dark px-3 py-2 rounded-pill text-uppercase">
                        {{ auth()->user()->role }}
                    </span>

                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card border-0 shadow-lg rounded-4 h-100">

                <div class="card-body p-5">

                    <h2 class="fw-bold mb-4">
                        Informasi Profile
                    </h2>

                    <div class="mb-4">
                        <label class="text-muted small">
                            Nama User
                        </label>

                        <div class="fs-5 fw-semibold">
                            {{ auth()->user()->name }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small">
                            Email
                        </label>

                        <div class="fs-5 fw-semibold">
                            {{ auth()->user()->email }}
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="text-muted small">
                            Role
                        </label>

                        <div class="fs-5 fw-semibold text-capitalize">
                            {{ auth()->user()->role }}
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">

                        <a href="{{ route('profile.edit') }}" 
                           class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i>
                            Edit Profile
                        </a>

                        <a href="{{ route('products') }}" 
                           class="btn btn-warning px-4 py-2 rounded-3 shadow-sm">
                            <i class="bi bi-box-seam me-2"></i>
                            Lihat Produk
                        </a>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@include('partials.wishlist-modal')

@endsection