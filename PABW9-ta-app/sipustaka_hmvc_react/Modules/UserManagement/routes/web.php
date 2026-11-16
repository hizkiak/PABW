<?php
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Http\Controllers\UserController;
Route::middleware('role:admin')->group(function () {
    Route::resource('/pengguna', UserController::class)->parameters(['pengguna'=>'user'])->except(['create','show','edit']);
});
