<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('peminjaman', function(Blueprint $t){$t->id();$t->string('nama_peminjam');$t->string('judul_buku');$t->date('tanggal_pinjam');$t->date('tanggal_kembali')->nullable();$t->string('status')->default('Dipinjam');$t->string('bukti_path')->nullable();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();$t->timestamps();}); } public function down(): void { Schema::dropIfExists('peminjaman'); } };
