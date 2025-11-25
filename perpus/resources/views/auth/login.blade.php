@extends('layouts.app')

@section('content')
<div class="container auth-container">
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-header bg-gradient text-black text-center">
            <h4 class="mb-0 fw-bold">Selamat Datang Kembali</h4>
            <small class="text-black-50">Masukkan kredensial Anda untuk melanjutkan</small>
        </div>

        <div class="card-body p-4 p-md-5">

            <form method="POST" action="{{ route('login.post') }}" class="w-100">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIM atau Email</label>
                    <input type="text" name="identifier" class="form-control form-control-lg" value="{{ old('identifier') }}" placeholder="Contoh: U.123.45.6789" required>
                    @error('identifier')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold d-flex justify-content-between">
                        <span>Password</span>
                        <a href="#" class="small text-decoration-none">Lupa password?</a>
                    </label>

                    <div class="input-group">
                        <input type="password" name="password" class="form-control form-control-lg" id="pass" placeholder="Masukkan password" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePass()">👁</button>
                    </div>

                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary btn-lg w-100 mt-2">Masuk</button>
            </form>

            <div class="mt-3 text-center">
                <p class="mb-0">Belum punya akun? <a href="{{ route('register') }}" class="fw-semibold">Daftar sekarang</a></p>
            </div>

            <script>
                function togglePass() {
                    const p = document.getElementById('pass');
                    p.type = p.type === "password" ? "text" : "password";
                }
            </script>

        </div>
    </div>
</div>
@endsection