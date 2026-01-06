@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Tambahkan min-vh-100 dan align-items-center agar posisi di tengah vertikal --}}
    <div class="row justify-content-center align-items-center min-vh-100" style="margin-top: -50px;"> 
        <div class="col-md-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    
                    {{-- Judul Login --}}
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">{{ __('Login System') }}</h3>
                        <p class="text-muted">Silakan masuk untuk melanjutkan</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                   name="password" required autocomplete="current-password" placeholder="********">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Remember Me & Forgot Password --}}
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a class="btn btn-link text-decoration-none small" href="{{ route('password.request') }}">
                                    {{ __('Lupa Password?') }}
                                </a>
                            @endif
                        </div>

                        {{-- Tombol Login Full Width --}}
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3">
                                {{ __('Masuk') }}
                            </button>
                        </div>

                        {{-- Register Link (Opsional) --}}
                        @if (Route::has('register'))
                        <div class="text-center mt-3">
                            <span class="text-muted">Belum punya akun?</span>
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">Daftar disini</a>
                        </div>
                        @endif

                    </form>
                </div>
            </div>
            
            {{-- Footer kecil (Opsional) --}}
            <div class="text-center mt-3 text-muted small">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection