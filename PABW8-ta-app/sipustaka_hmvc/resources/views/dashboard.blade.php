
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="mb-4">

    <h3 class="fw-bold">Dashboard SiPustaka</h3>

    <p class="text-muted">
        Selamat datang, {{ auth()->user()->name }}.
        Anda login sebagai {{ auth()->user()->role->label() }}.
    </p>

</div>

<div class="row g-3">

    {{-- Kartu Data Buku --}}
    <div class="col-md-4">

        <div class="card p-3 h-100">

            <div class="d-flex align-items-center gap-3">

                <div class="icon-box blue">
                    <i class="bi bi-book"></i>
                </div>

                <div>
                    <h6 class="text-muted mb-1">Data Buku</h6>
                    <h5 class="fw-bold mb-0">Koleksi Perpustakaan</h5>
                </div>

            </div>

            <p class="text-muted small mt-3">
                Lihat dan kelola koleksi buku perpustakaan.
            </p>

            <a href="{{ route('buku.index') }}"
                class="btn btn-outline-primary btn-sm mt-auto">

                Lihat Data Buku
                <i class="bi bi-arrow-right ms-1"></i>

            </a>

        </div>

    </div>

    {{-- Kartu Peminjaman --}}
    <div class="col-md-4">

        <div class="card p-3 h-100">

            <div class="d-flex align-items-center gap-3">

                <div class="icon-box green">
                    <i class="bi bi-journal-check"></i>
                </div>

                <div>
                    <h6 class="text-muted mb-1">Peminjaman</h6>
                    <h5 class="fw-bold mb-0">Data Peminjaman</h5>
                </div>

            </div>

            <p class="text-muted small mt-3">
                Informasi transaksi peminjaman buku.
            </p>

            <a href="{{ route('peminjaman.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                Lihat Peminjaman <i class="bi bi-arrow-right ms-1"></i>
            </a>

        </div>

    </div>

    {{-- Kartu Manajemen User khusus Admin --}}
    @if (auth()->user()->isAdmin())

        <div class="col-md-4">

            <div class="card p-3 h-100">

                <div class="d-flex align-items-center gap-3">

                    <div class="icon-box gray">
                        <i class="bi bi-people"></i>
                    </div>

                    <div>
                        <h6 class="text-muted mb-1">Pengguna</h6>
                        <h5 class="fw-bold mb-0">Manajemen User</h5>
                    </div>

                </div>

                <p class="text-muted small mt-3">
                    Kelola akun dan hak akses pengguna.
                </p>

                <a href="{{ route('usermanagement.index') }}" class="btn btn-outline-primary btn-sm mt-auto">
                    Kelola Pengguna <i class="bi bi-arrow-right ms-1"></i>
                </a>

            </div>

        </div>

    @endif

</div>

{{-- Informasi Sistem --}}
<div class="card mt-4 p-4">

    <h5 class="fw-bold">Informasi Sistem</h5>

    <p class="text-muted mb-0">
        SiPustaka merupakan sistem informasi perpustakaan
        untuk mengelola data buku, peminjaman, dan pengguna
        berdasarkan hak akses masing-masing.
    </p>

</div>

@endsection
