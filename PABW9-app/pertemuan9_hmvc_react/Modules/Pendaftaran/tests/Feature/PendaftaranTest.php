<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Pendaftaran\Models\Daftar;

test('tamu dialihkan ke login saat membuka pendaftaran', function () {
    $response = $this->get('/pendaftaran');

    $response->assertRedirect('/login');
});

test('user biasa dapat membuka halaman pendaftaran', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/pendaftaran');

    $response->assertStatus(200);
});

test('pendaftaran data mengembalikan json daftar pendaftar', function () {
    $user = User::factory()->create();
    Daftar::factory()->count(3)->create();

    $response = $this->actingAs($user)->getJson('/pendaftaran/data');

    $response->assertStatus(200)->assertJsonCount(3);
});

test('pendaftar dapat ditambah beserta berkas', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('dokumen.pdf', 500, 'application/pdf');

    $response = $this->actingAs($user)->postJson('/pendaftaran', [
        'nama' => 'Siti Rahma',
        'asal_sekolah' => 'SMA 1 Bandung',
        'prodi_tujuan' => 'Informatika',
        'email' => 'siti@example.com',
        'no_hp' => '081234567890',
        'berkas' => $file,
    ]);

    $response->assertStatus(200)->assertJson(['success' => 'Data berhasil disimpan.']);
    $this->assertDatabaseHas('daftars', ['email' => 'siti@example.com']);
});

test('validasi berkas gagal jika format tidak sesuai', function () {
    Storage::fake('public');
    $user = User::factory()->create();
    $file = UploadedFile::fake()->create('arsip.zip', 500, 'application/zip');

    $response = $this->actingAs($user)->postJson('/pendaftaran', [
        'nama' => 'Siti Rahma',
        'asal_sekolah' => 'SMA 1 Bandung',
        'prodi_tujuan' => 'Informatika',
        'email' => 'siti@example.com',
        'no_hp' => '081234567890',
        'berkas' => $file,
    ]);

    $response->assertStatus(422)->assertJsonValidationErrors(['berkas']);
});