<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('profile', function () {
    return view('profile');
})->name('HalamanProfile');

Route::get('about', function () {
    return view('about');
});

Route::get('formulir', function () {
    return view('formulir');
})->name('masuk.page');

Route::post('post', [DataController::class, 'inputdata'])->name('post.page');
