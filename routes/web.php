<?php

use App\Http\Controllers\authController;
use Illuminate\Support\Facades\Route;

// Halaman Login
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Proses Login dan Logout
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');})->name('admin.dashboard');
});

Route::middleware(['role:guru'])->group(function () {
    Route::get('/guru/dashboard', function () {
        return view('guru.dashboard');})->name('guru.dashboard');
});

Route::middleware(['role:waka'])->group(function () {
    Route::get('/waka/dashboard', function () {
        return view('waka.dashboard');})->name('waka.dashboard');
});




