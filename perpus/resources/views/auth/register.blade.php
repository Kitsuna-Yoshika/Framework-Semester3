@extends('layouts.app')

@section('content')
<div class="container auth-container">
    <div class="card shadow-lg border-0 mt-4">
        <div class="card-header bg-gradient text-black text-center">
            <h4 class="mb-0 fw-bold">Buat Akun Baru</h4>
            <small class="text-black-50">Isi data berikut untuk mendaftar ke perpustakaan</small>
        </div>
        <div class="card-body p-4 p-md-5">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }} <br>
                    @if(session('password_generated'))
                        <strong>Password:</strong> {{ session('password_generated') }}
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" id="registerForm" class="w-100">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">NIM</label>
                    <input type="text" name="nim" class="form-control form-control-lg @error('nim') is-invalid @enderror"
                           placeholder="Contoh : U.000.00.0000" value="{{ old('nim') }}" 
                           id="nimInput" oninput="checkNimPrefix()" required>
                    @error('nim')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 
                 <div id="anggotaFields" style="display: none;">
                     <div class="mb-3">
                        <label class="form-label fw-semibold">Program Studi <span class="text-danger">*</span></label>
                        <select name="prodi" class="form-select @error('prodi') is-invalid @enderror">
                             <option value="">-- Pilih Program Studi --</option>
                             <option value="Teknik Informatika" {{ old('prodi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                             <option value="Sistem Informasi" {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                             <option value="Ilmu Komunikasi" {{ old('prodi') == 'Ilmu Komunikasi' ? 'selected' : '' }}>Ilmu Komunikasi</option>
                         </select>
                         @error('prodi')
                             <div class="invalid-feedback">{{ $message }}</div>
                         @enderror
                         <small class="form-text text-muted">Wajib diisi untuk menjadi anggota perpustakaan</small>
                     </div>
                 </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" placeholder="Contoh@email.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold d-block">Opsi Password</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="password_option" 
                               id="generatePassword" value="generate" checked onchange="togglePasswordField()">
                        <label class="form-check-label fw-semibold" for="generatePassword">
                            Generate Password Otomatis
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="password_option" 
                               id="setPassword" value="set" onchange="togglePasswordField()">
                        <label class="form-check-label fw-semibold" for="setPassword">
                            Set Password Sendiri
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="passwordField" style="display: none;">
                    <label class="form-label fw-semibold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" 
                               class="form-control form-control-lg @error('password') is-invalid @enderror" 
                               id="passwordInput" 
                               minlength="8">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassVisibility()">👁</button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">Minimal 8 karakter</small>
                </div>

                <button type="submit" class="btn btn-primary btn-lg w-100 mt-2">Daftar Sekarang</button>

            </form>

            <script>
                function checkNimPrefix() {
                    const nimInput = document.getElementById('nimInput');
                    const nimValue = nimInput.value.trim().toUpperCase();
                    const anggotaFields = document.getElementById('anggotaFields');
                    const prodiSelect = anggotaFields.querySelector('select[name="prodi"]');
                    
                    // Cek jika NIM dimulai dengan U
                    if (nimValue.startsWith('U.')) {
                        anggotaFields.style.display = 'block';
                        prodiSelect.setAttribute('required', 'required');
                    } else {
                        anggotaFields.style.display = 'none';
                        prodiSelect.removeAttribute('required');
                        prodiSelect.value = '';
                    }
                }

                function togglePasswordField() {
                    const generateRadio = document.getElementById('generatePassword');
                    const passwordField = document.getElementById('passwordField');
                    const passwordInput = document.getElementById('passwordInput');
                    
                    if (generateRadio.checked) {
                        passwordField.style.display = 'none';
                        passwordInput.removeAttribute('required');
                        passwordInput.value = '';
                    } else {
                        passwordField.style.display = 'block';
                        passwordInput.setAttribute('required', 'required');
                    }
                }

                function togglePassVisibility() {
                    const p = document.getElementById('passwordInput');
                    p.type = p.type === "password" ? "text" : "password";
                }

                // Jalankan saat halaman dimuat (untuk old value)
                document.addEventListener('DOMContentLoaded', function() {
                    checkNimPrefix();
                });
            </script>

            <div class="mt-3 text-center">
                <p class="mb-0">Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>
@endsection