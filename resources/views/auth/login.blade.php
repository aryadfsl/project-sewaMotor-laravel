@extends('layouts.main')

@section('title', 'Login')
@section('body_class', 'login-page')
@section('hide_navbar', '1')
@section('hide_footer', '1')

@section('content')
    <div class="login-container">
        <div class="login-card">
            <h2>Login</h2>
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <small class="text-danger d-block text-start">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required />
                    @error('password')
                        <small class="text-danger d-block text-start">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-check mb-3 text-start">
                    <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <button type="submit" class="btn btn-warning">Login</button>
                <a href="{{ route('register') }}" class="btn btn-link">Register</a>
                <a href="{{ route('home') }}" class="btn btn-link">Kembali ke Beranda</a>
            </form>
        </div>
    </div>
@endsection
