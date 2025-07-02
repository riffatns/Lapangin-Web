<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/starting-page', function () {
    return view('startingpage');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/pesanan', function () {
        return view('pesanan');
    })->name('pesanan');
    
    Route::get('/komunitas', function () {
        return view('komunitas');
    })->name('komunitas');

    Route::get('/notifikasi', function () {
        return view('notifikasi');
    })->name('notifikasi');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
});