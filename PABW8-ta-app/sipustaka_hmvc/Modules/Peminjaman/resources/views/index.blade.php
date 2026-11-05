
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')

<div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

    <div>
        <h4 class="fw-bold mb-1">Data Peminjaman</h4>
        <p class="text-muted mb-0">
            Kelola transaksi peminjaman dan pengembalian buku.
        </p>
    </div>

    <button type="button" class="btn btn-primary" id="btnTambah">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Peminjaman
    </button>

</div>

{{-- Notifikasi AJAX --}}
<div id="alertContainer"></div>

{{-- Tabel Peminjaman --}}
<div class="card">

    <div class="card-header py-3 d-flex justify-content-between align-items-center">

        <h6 class="fw-semibold mb-0">Daftar Peminjaman</h6>

        <span class="badge text-bg-primary" id="totalData">
            {{ $peminjamans->count() }} Data
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Lampiran</th>
                    <th width="120">Aksi</th>
                </tr>
            </thead>

            <tbody id="peminjamanTable">

                @forelse ($peminjamans as $index => $peminjaman)

                    <tr id="row-{{ $peminjaman->id }}">

                        <td>{{ $index + 1 }}</td>

                        <td>{{ $peminjaman->nama_peminjam }}</td>

                        <td>{{ $peminjaman->judul_buku }}</td>

                        <td>{{ $peminjaman->tanggal_pinjam->format('d-m-Y') }}</td>

                        <td>{{ $peminjaman->tanggal_kembali->format('d-m-Y') }}</td>

                        <td>
                            <span class="badge {{ $peminjaman->status === 'Dipinjam' ? 'text-bg-warning' : 'text-bg-success' }}">
                                {{ $peminjaman->status }}
                            </span>
                        </td>

                        <td>
                            @if ($peminjaman->bukti)
                                <a href="{{ asset('storage/' . $peminjaman->bukti) }}"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-file-earmark"></i>
                                    Lihat
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <button type="button"
                                class="btn btn-sm btn-warning btn-edit"
                                data-id="{{ $peminjaman->id }}"
                                data-nama="{{ $peminjaman->nama_peminjam }}"
                                data-judul="{{ $peminjaman->judul_buku }}"
                                data-pinjam="{{ $peminjaman->tanggal_pinjam->format('Y-m-d') }}"
                                data-kembali="{{ $peminjaman->tanggal_kembali->format('Y-m-d') }}"
                                data-status="{{ $peminjaman->status }}">

                                <i class="bi bi-pencil-square"></i>

                            </button>

                            <button type="button"
                                class="btn btn-sm btn-danger btn-hapus"
                                data-id="{{ $peminjaman->id }}">

                                <i class="bi bi-trash"></i>

                            </button>
                        </td>

                    </tr>

                @empty

                    <tr id="emptyRow">
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-journal-x"></i>
                                <p class="mt-2 mb-0">
                                    Belum ada data peminjaman.
                                </p>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- Modal Form Peminjaman --}}
<div class="modal fade" id="peminjamanModal" tabindex="-1"
    aria-labelledby="peminjamanModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form id="peminjamanForm" enctype="multipart/form-data">

                @csrf

                <input type="hidden" id="peminjamanId">

                <div class="modal-header">

                    <h5 class="modal-title fw-bold" id="peminjamanModalLabel">
                        Tambah Peminjaman
                    </h5>

                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>

                </div>

                <div class="modal-body">

                    <div id="formAlert"></div>

                    <div class="mb-3">

                        <label class="form-label">Nama Peminjam</label>

                        <input type="text" name="nama_peminjam"
                            id="nama_peminjam" class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Judul Buku</label>

                        <input type="text" name="judul_buku"
                            id="judul_buku" class="form-control">

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Tanggal Pinjam</label>

                            <input type="date" name="tanggal_pinjam"
                                id="tanggal_pinjam" class="form-control">

                            <div class="invalid-feedback"></div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">Tanggal Kembali</label>

                            <input type="date" name="tanggal_kembali"
                                id="tanggal_kembali" class="form-control">

                            <div class="invalid-feedback"></div>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Status Peminjaman</label>

                        <select name="status" id="status" class="form-select">

                            <option value="Dipinjam">Dipinjam</option>

                            <option value="Dikembalikan">Dikembalikan</option>

                        </select>

                        <div class="invalid-feedback"></div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            File Lampiran
                        </label>

                        <input type="file" name="bukti" id="bukti"
                            class="form-control"
                            accept=".jpg,.jpeg,.png,.pdf">

                        <div class="invalid-feedback"></div>

                        <small class="text-muted">
                            Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-light"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary"
                        id="btnSimpan">

                        <i class="bi bi-save me-1"></i>
                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
$(document).ready(function () {

    // Pengaturan CSRF untuk seluruh request AJAX.
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    });

    const modalElement = document.getElementById('peminjamanModal');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    const form = $('#peminjamanForm');

    let isEdit = false;

    // Mencegah HTML dari data pengguna dimasukkan secara langsung.
    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }

    // Menampilkan notifikasi.
    function showAlert(message, type = 'success') {
        $('#alertContainer').html(`
            <div class="alert alert-${type} alert-dismissible fade show alert-autohide">
                ${escapeHtml(message)}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
    }

    // Membersihkan error validasi.
    function clearErrors() {
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');
        $('#formAlert').empty();
    }

    // Menampilkan error validasi dari response HTTP 422.
    function showErrors(errors) {
        clearErrors();

        $.each(errors, function (field, messages) {
            const input = form.find(`[name="${field}"]`);

            input.addClass('is-invalid');
            input.siblings('.invalid-feedback').text(messages[0]);
        });
    }

    // Format tanggal untuk tampilan tabel.
    function formatDate(date) {
        if (!date) return '-';

        const parts = date.split('-');

        if (parts.length !== 3) return escapeHtml(date);

        return `${parts[2]}-${parts[1]}-${parts[0]}`;
    }

    // Membuat baris tabel dari data server.
    function createRow(item, number) {

        const badge = item.status === 'Dipinjam'
            ? 'text-bg-warning'
            : 'text-bg-success';

        const fileLink = item.bukti
            ? `<a href="${escapeHtml('/storage/' + item.bukti)}"
                    target="_blank"
                    class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark"></i> Lihat
               </a>`
            : '-';

        return `
            <tr id="row-${item.id}">

                <td>${number}</td>

                <td>${escapeHtml(item.nama_peminjam)}</td>

                <td>${escapeHtml(item.judul_buku)}</td>

                <td>${formatDate(item.tanggal_pinjam)}</td>

                <td>${formatDate(item.tanggal_kembali)}</td>

                <td>
                    <span class="badge ${badge}">
                        ${escapeHtml(item.status)}
                    </span>
                </td>

                <td>${fileLink}</td>

                <td>
                    <button type="button"
                        class="btn btn-sm btn-warning btn-edit"
                        data-id="${item.id}"
                        data-nama="${escapeHtml(item.nama_peminjam)}"
                        data-judul="${escapeHtml(item.judul_buku)}"
                        data-pinjam="${item.tanggal_pinjam}"
                        data-kembali="${item.tanggal_kembali}"
                        data-status="${escapeHtml(item.status)}">

                        <i class="bi bi-pencil-square"></i>
                    </button>

                    <button type="button"
                        class="btn btn-sm btn-danger btn-hapus"
                        data-id="${item.id}">

                        <i class="bi bi-trash"></i>
                    </button>
                </td>

            </tr>
        `;
    }

    // Memperbarui nomor dan jumlah data pada tabel.
    function refreshTableNumbers() {
        $('#peminjamanTable tr').not('#emptyRow').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });

        const total = $('#peminjamanTable tr').not('#emptyRow').length;

        $('#totalData').text(total + ' Data');
    }

    // Memuat daftar melalui endpoint JSON agar operasi tampil juga memakai AJAX.
    function loadData() {
        $.get('/peminjaman/data')
            .done(function (response) {
                const rows = response.data || [];
                if (rows.length === 0) {
                    $('#peminjamanTable').html(`
                        <tr id="emptyRow"><td colspan="8" class="text-center py-4">Belum ada data peminjaman.</td></tr>
                    `);
                } else {
                    $('#peminjamanTable').html(rows.map((item, index) => createRow(item, index + 1)).join(''));
                }
                refreshTableNumbers();
            })
            .fail(function () {
                showAlert('Daftar peminjaman gagal dimuat.', 'danger');
            });
    }

    loadData();

    // Tombol tambah.
    $('#btnTambah').on('click', function () {
        isEdit = false;

        form[0].reset();
        clearErrors();

        $('#peminjamanId').val('');
        $('#bukti').prop('required', false);

        $('#peminjamanModalLabel').text('Tambah Peminjaman');
        $('#btnSimpan').html('<i class="bi bi-save me-1"></i> Simpan');

        modal.show();
    });

    // Tombol edit.
    $(document).on('click', '.btn-edit', function () {

        isEdit = true;

        clearErrors();
        form[0].reset();

        $('#peminjamanId').val($(this).data('id'));
        $('#nama_peminjam').val($(this).attr('data-nama'));
        $('#judul_buku').val($(this).attr('data-judul'));
        $('#tanggal_pinjam').val($(this).attr('data-pinjam'));
        $('#tanggal_kembali').val($(this).attr('data-kembali'));
        $('#status').val($(this).attr('data-status'));

        // File tidak wajib ketika mengedit.
        $('#bukti').prop('required', false);

        $('#peminjamanModalLabel').text('Edit Peminjaman');

        $('#btnSimpan').html(
            '<i class="bi bi-save me-1"></i> Simpan Perubahan'
        );

        modal.show();
    });

    // Submit form tambah/edit.
    form.on('submit', function (event) {

        event.preventDefault();

        clearErrors();

        const id = $('#peminjamanId').val();

        const url = isEdit
            ? `/peminjaman/${id}`
            : '/peminjaman';

        const formData = new FormData(this);

        let method = 'POST';

        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        $('#btnSimpan').prop('disabled', true)
            .html('<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...');

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {

                modal.hide();

                form[0].reset();

                if (isEdit) {
                    const oldRow = $('#row-' + response.data.id);
                    const number = oldRow.find('td:first').text();

                    oldRow.replaceWith(createRow(response.data, number));

                    showAlert(response.message);
                } else {
                    $('#emptyRow').remove();

                    const total = $('#peminjamanTable tr').length + 1;

                    $('#peminjamanTable').append(
                        createRow(response.data, total)
                    );

                    showAlert(response.message);
                }

                refreshTableNumbers();
            },

            error: function (xhr) {

                if (xhr.status === 422) {
                    showErrors(xhr.responseJSON.errors);
                } else {
                    const message = xhr.responseJSON?.message
                        || 'Terjadi kesalahan pada server.';

                    $('#formAlert').html(`
                        <div class="alert alert-danger">
                            ${escapeHtml(message)}
                        </div>
                    `);
                }
            },

            complete: function () {
                $('#btnSimpan').prop('disabled', false).html(
                    '<i class="bi bi-save me-1"></i> Simpan'
                );
            }
        });
    });

    // Tombol hapus.
    $(document).on('click', '.btn-hapus', async function () {

        const id = $(this).data('id');

        const confirmed = await window.confirmDelete(
            'Apakah Anda yakin ingin menghapus data peminjaman ini?'
        );

        if (!confirmed) return;

        $.ajax({
            url: `/peminjaman/${id}`,
            type: 'DELETE',

            success: function (response) {

                $('#row-' + id).remove();

                const total = $('#peminjamanTable tr').not('#emptyRow').length;

                if (total === 0) {
                    $('#peminjamanTable').html(`
                        <tr id="emptyRow">
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="bi bi-journal-x"></i>
                                    <p class="mt-2 mb-0">
                                        Belum ada data peminjaman.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    `);
                }

                refreshTableNumbers();

                showAlert(response.message);
            },

            error: function (xhr) {
                showAlert(
                    xhr.responseJSON?.message || 'Gagal menghapus data.',
                    'danger'
                );
            }
        });
    });

});
</script>

@endpush
