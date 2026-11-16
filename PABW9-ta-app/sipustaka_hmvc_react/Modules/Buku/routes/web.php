<?php
use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;
Route::middleware('role:admin')->group(function () {
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});
Route::get('/katalog', [BukuController::class, 'index'])->name('katalog.index');
