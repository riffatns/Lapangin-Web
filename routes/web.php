<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;

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
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/pesanan', [BookingController::class, 'index'])->name('pesanan');
    
    // Venue routes
    Route::get('/venue/{venue}', [DashboardController::class, 'show'])->name('venue.show');
    Route::get('/venue/{venue}/booking-data', [DashboardController::class, 'getBookingData'])->name('venue.booking-data');
    Route::post('/venue/{venue}/book', [BookingController::class, 'store'])->name('venue.book');
    
    // Booking routes
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    
    Route::get('/komunitas', [CommunityController::class, 'index'])->name('komunitas');

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Community routes
    Route::post('/komunitas/{community}/join', [CommunityController::class, 'join'])->name('community.join');
    Route::post('/komunitas/{community}/leave', [CommunityController::class, 'leave'])->name('community.leave');
    
    // Notification routes
    Route::post('/notifications/sample', [NotificationController::class, 'createSample'])->name('notifications.sample');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
});