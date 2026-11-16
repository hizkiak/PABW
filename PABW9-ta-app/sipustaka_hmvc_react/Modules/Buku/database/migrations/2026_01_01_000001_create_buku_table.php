<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up(): void { Schema::create('buku', function(Blueprint $t){$t->id();$t->string('judul');$t->string('penulis');$t->string('penerbit');$t->unsignedSmallInteger('tahun_terbit');$t->unsignedInteger('stok')->default(0);$t->timestamps();}); } public function down(): void { Schema::dropIfExists('buku'); } };
