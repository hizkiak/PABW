<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaporBanjirController;

Route::get('/', function () {
    return redirect()->route('laporan.index');
});

Route::get('/laporan', [LaporBanjirController::class, 'index'])->name('laporan.index');
Route::get('/laporan/buat', [LaporBanjirController::class, 'create'])->name('laporan.create');

Route::match(['get', 'post'], '/laporan/simpan', [LaporBanjirController::class, 'store'])->name('laporan.store');