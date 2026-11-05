@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8">

        <a href="{{ route('buku.index') }}"
            class="text-decoration-none small">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Data Buku

        </a>

        <h4 class="fw-bold mt-3 mb-4">
            Tambah Buku
        </h4>

        <div class="card">

            <div class="card-body p-4">

                <form action="{{ route('buku.store') }}" method="POST">

                    @csrf

                    @include('buku::partials.form')

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('buku.index') }}"
                            class="btn btn-light">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            Simpan Buku
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection