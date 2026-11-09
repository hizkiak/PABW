<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daftars', function (Blueprint $table) {
            $table->string('berkas')->nullable()->after('no_hp');
            $table->string('nama_berkas')->nullable()->after('berkas');
        });
    }

    public function down(): void
    {
        Schema::table('daftars', function (Blueprint $table) {
            $table->dropColumn(['berkas', 'nama_berkas']);
        });
    }
};
