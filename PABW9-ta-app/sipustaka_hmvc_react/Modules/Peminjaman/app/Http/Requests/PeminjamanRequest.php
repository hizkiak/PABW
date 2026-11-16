<?php
namespace Modules\Peminjaman\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class PeminjamanRequest extends FormRequest
{
    public function authorize(): bool { return $this->user() !== null; }
    public function rules(): array { return ['nama_peminjam'=>'required|string|max:150','judul_buku'=>'required|string|max:200','tanggal_pinjam'=>'required|date','tanggal_kembali'=>'nullable|date|after_or_equal:tanggal_pinjam','status'=>'required|in:Dipinjam,Dikembalikan','bukti'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048']; }
}
