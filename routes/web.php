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
    Route::get('/booking/{booking}/checkout', [BookingController::class, 'checkout'])->name('booking.checkout');
    Route::post('/booking/{booking}/payment', [BookingController::class, 'processPayment'])->name('booking.payment');
    Route::get('/booking/payment/success', function() {
        return view('payment-success');
    })->name('booking.payment.success');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
    
    // New booking action routes
    Route::get('/booking/{booking}/detail', [BookingController::class, 'show'])->name('booking.detail');
    Route::get('/booking/{booking}/pay-now', [BookingController::class, 'payNow'])->name('booking.pay-now');
    Route::get('/booking/{booking}/rating', [BookingController::class, 'showRatingForm'])->name('booking.rating');
    Route::post('/booking/{booking}/rating', [BookingController::class, 'submitRating'])->name('booking.rating.submit');
    Route::post('/booking/{booking}/complete', [BookingController::class, 'markAsCompleted'])->name('booking.complete');
    
    Route::get('/komunitas', [CommunityController::class, 'index'])->name('komunitas');

    Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifikasi');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Community routes
    Route::post('/komunitas/{community}/join', [CommunityController::class, 'join'])->name('community.join');
    Route::post('/komunitas/{community}/leave', [CommunityController::class, 'leave'])->name('community.leave');
    
    // PlayTogether routes
    Route::post('/play-together/{playTogether}/join', [CommunityController::class, 'joinPlayTogether'])->name('play-together.join');
    Route::post('/play-together/{playTogether}/leave', [CommunityController::class, 'leavePlayTogether'])->name('play-together.leave');
    
    // Tournament routes
    Route::post('/tournament/{tournament}/register', [CommunityController::class, 'registerTournament'])->name('tournament.register');
    Route::post('/tournament/{tournament}/unregister', [CommunityController::class, 'unregisterTournament'])->name('tournament.unregister');
    
    // Notification routes
    Route::post('/notifications/sample', [NotificationController::class, 'createSample'])->name('notifications.sample');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
});