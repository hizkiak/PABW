<!DOCTYPE html>
<html lang="id">

<head>
    @include('layouts.partials.head')
</head>

<body>

<div class="container min-vh-100 d-flex align-items-center justify-content-center">

    <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 430px;">

        <div class="text-center mb-4">

            <div class="auth-logo mx-auto mb-3">
                <i class="bi bi-book-half"></i>
            </div>

            <h4 class="fw-bold">SiPustaka</h4>

            <p class="text-muted">
                Silakan login untuk melanjutkan
            </p>

        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.store') }}" method="POST">

            @csrf

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

                <div class="input-group">

                    <input type="password" name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required>

                    <button type="button" class="btn btn-outline-secondary"
                        data-toggle-password="password">

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>

            <div class="form-check mb-3">

                <input type="checkbox" name="remember"
                    class="form-check-input" id="remember">

                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>

            </div>

            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1"></i>
                Login
            </button>

        </form>

        <div class="text-center mt-4">

            <span class="text-muted">Belum memiliki akun?</span>

            <a href="{{ route('register') }}" class="text-decoration-none">
                Daftar sekarang
            </a>

        </div>

    </div>

</div>

@include('layouts.partials.scripts')

</body>
</html>