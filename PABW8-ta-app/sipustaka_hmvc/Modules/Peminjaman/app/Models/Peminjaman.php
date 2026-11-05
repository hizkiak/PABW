<?php

namespace Modules\Peminjaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'nama_peminjam',
        'judul_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'bukti',
    ];

    protected function casts(): array
    {
        return ['tanggal_pinjam' => 'date', 'tanggal_kembali' => 'date'];
    }

    public function user()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'user_id'
        );
    }
}
