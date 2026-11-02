<?php

use App\Http\Controllers\KontakController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('kontaks.index'); // Halaman awal langsung ke daftar kontak
});

// CRUD Kontak dengan upload foto
Route::resource('kontaks', KontakController::class);