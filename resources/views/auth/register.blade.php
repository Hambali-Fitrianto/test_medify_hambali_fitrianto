@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Layout Center Vertikal & Horizontal --}}
    <div class="row justify-content-center align-items-center min-vh-100" style="margin-top: -50px;">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">

                    {{-- Judul Register --}}
                    <div class="text-center mb-4">
                        <h3 class="fw-bold text-primary">{{ __('Buat Akun Baru') }}</h3>
                        <p class="text-muted">Isi formulir di bawah ini untuk mendaftar</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Input Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">{{ __('Nama Lengkap') }}</label>
                            <input id="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Masukkan nama Anda">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">{{ __('Alamat Email') }}</label>
                            <input id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- Input Password --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label fw-semibold">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password" placeholder="********">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password-confirm" class="form-label fw-semibold">{{ __('Konfirmasi Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-lg" 
                                       name="password_confirmation" required autocomplete="new-password" placeholder="********">
                            </div>
                        </div>

                        {{-- Tombol Register --}}
                        <div class="d-grid mb-3 mt-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3">
                                {{ __('Daftar Sekarang') }}
                            </button>
                        </div>

                        {{-- Link ke Login --}}
                        <div class="text-center mt-3">
                            <span class="text-muted">Sudah punya akun?</span>
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">Login disini</a>
                        </div>

                    </form>
                </div>
            </div>

             {{-- Footer kecil --}}
             <div class="text-center mt-3 text-muted small">
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </div>
        </div>
    </div>
</div>
@endsection