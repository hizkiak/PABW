@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h4 class="fw-bold mb-1">Data Buku</h4>
        <p class="text-muted mb-0">
            Daftar koleksi buku perpustakaan SiPustaka.
        </p>
    </div>

    @if (auth()->user()->isAdmin())
        <a href="{{ route('buku.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Buku
        </a>
    @endif

</div>

{{-- Pencarian --}}
<div class="card mb-3">

    <div class="card-body">

        <form action="{{ route('buku.index') }}" method="GET">

            <div class="row g-2">

                <div class="col-md-10">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari judul, penulis, atau penerbit..."
                        value="{{ $search }}"
                    >

                </div>

                <div class="col-md-2 d-grid">

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i>
                        Cari
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

{{-- Tabel Buku --}}
<div class="card">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="fw-semibold mb-0">Koleksi Perpustakaan</h6>

        <span class="badge text-bg-primary">
            {{ $bukus->total() }} Buku
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th width="60">No.</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>

                    @if (auth()->user()->isAdmin())
                        <th width="150">Aksi</th>
                    @endif
                </tr>
            </thead>

            <tbody>

                @forelse ($bukus as $index => $buku)

                    <tr>

                        <td>
                            {{ $bukus->firstItem() + $index }}
                        </td>

                        <td class="fw-semibold">
                            {{ $buku->judul }}
                        </td>

                        <td>
                            {{ $buku->penulis }}
                        </td>

                        <td>
                            {{ $buku->penerbit }}
                        </td>

                        <td>
                            {{ $buku->tahun_terbit }}
                        </td>

                        <td>
                            <span class="badge {{ $buku->stok > 0 ? 'text-bg-success' : 'text-bg-danger' }}">
                                {{ $buku->stok }}
                            </span>
                        </td>

                        @if (auth()->user()->isAdmin())

                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route('buku.edit', $buku) }}"
                                        class="btn btn-sm btn-warning"
                                        title="Edit buku">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('buku.destroy', $buku) }}"
                                        method="POST"
                                        data-confirm="Apakah Anda yakin ingin menghapus buku ini?"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            title="Hapus buku">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        @endif

                    </tr>

                @empty

                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 7 : 6 }}">

                            <div class="empty-state">

                                <i class="bi bi-book"></i>

                                <p class="mt-2 mb-0">
                                    @if ($search)
                                        Buku dengan kata kunci tersebut tidak ditemukan.
                                    @else
                                        Belum ada data buku.
                                    @endif
                                </p>

                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination --}}
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <small class="text-muted">
                Menampilkan {{ $bukus->firstItem() ?? 0 }}
                sampai {{ $bukus->lastItem() ?? 0 }}
                dari {{ $bukus->total() }} data
            </small>

            {{ $bukus->links('pagination::bootstrap-5') }}

        </div>

    </div>

</div>

@endsection