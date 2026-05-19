@extends('layouts.main')

@section('title', 'Register')
@section('body_class', 'login-page')
@section('hide_navbar', '1')
@section('hide_footer', '1')

@section('content')
    <div class="login-container">
        <div class="login-card">
            <h2>Register</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
                    @error('name')
                        <small class="text-danger d-block text-start">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <small class="text-danger d-block text-start">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <small class="text-danger d-block text-start">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                @if(config('services.recaptcha.enabled'))
                    <div class="mb-3 d-flex justify-content-center">
                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    </div>
                    @error('g-recaptcha-response')
                        <small class="text-danger d-block mb-3">{{ $message }}</small>
                    @enderror
                @endif

                <button type="submit" class="btn btn-warning">Register</button>
                <a href="{{ route('login') }}" class="btn btn-link">Login</a>
                <a href="{{ route('home') }}" class="btn btn-link">Kembali ke Beranda</a>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    @if(config('services.recaptcha.enabled'))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endpush
