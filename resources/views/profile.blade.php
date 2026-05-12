@extends('layouts.main')

@section('title', 'Edit Profile')

@section('content')
    <div class="hero-section text-center">
        <div>
            <h1 class="display-4">Edit Profile</h1>
            <p class="lead">Perbarui informasi akun dan gambar profile.</p>
        </div>
    </div>

    <div class="container mt-5 mb-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="text-center mb-4">
                    @if(auth()->user()->profile_photo)
                        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" class="rounded-circle" width="130" height="130" style="object-fit: cover;" alt="{{ auth()->user()->name }}">
                    @else
                        <i class="bi bi-person-circle statistik-icon statistik-icon-motor"></i>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Profile</label>
                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                    @error('profile_photo')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('dashboard') }}" class="btn btn-danger">Kembali</a>
            </form>
        </div>
    </div>

    @include('partials.wishlist-modal')
@endsection
