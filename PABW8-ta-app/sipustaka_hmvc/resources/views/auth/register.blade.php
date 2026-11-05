<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.partials.head')
</head>

<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card shadow-sm border-0 p-4 my-4"
        style="width: 100%; max-width: 430px;">

        <div class="text-center mb-4">

            <div class="auth-logo mx-auto mb-3">
                <i class="bi bi-person-plus"></i>
            </div>

            <h4 class="fw-bold">Buat Akun SiPustaka</h4>

            <p class="text-muted">
                Daftarkan diri untuk menggunakan layanan perpustakaan.
            </p>

        </div>

        <form action="{{ route('register.store') }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">Nama Lengkap</label>

                <input type="text" name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}"
                    placeholder="Masukkan nama lengkap"
                    required>

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Email</label>

                <input type="email" name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="Masukkan email"
                    required>

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Password</label>

                <input type="password" name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter"
                    required>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Konfirmasi Password</label>

                <input type="password" name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password"
                    required>

            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-person-check me-1"></i>
                Daftar
            </button>

        </form>

        <div class="text-center mt-4">

            <span class="text-muted">Sudah memiliki akun?</span>

            <a href="{{ route('login') }}" class="text-decoration-none">
                Login
            </a>

        </div>

    </div>

</div>

@include('layouts.partials.scripts')

</body>
</html>