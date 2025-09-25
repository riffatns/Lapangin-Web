<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EmailVerificationController;

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
    
    // Email Verification Routes
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])
        ->name('verification.notice');
    
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'send'])
        ->middleware('throttle:6,1')
        ->name('verification.send');
    
    // Community routes
    Route::post('/komunitas/{community}/join', [CommunityController::class, 'join'])->name('community.join');
    Route::post('/komunitas/{community}/leave', [CommunityController::class, 'leave'])->name('community.leave');
    
    // Enhanced PlayTogether routes
    Route::prefix('play-together')->name('play-together.')->group(function () {
        Route::get('/', [App\Http\Controllers\PlayTogetherController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\PlayTogetherController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\PlayTogetherController::class, 'store'])->name('store');
        Route::get('/my-events', [App\Http\Controllers\PlayTogetherController::class, 'myEvents'])->name('my-events');
        Route::get('/{id}', [App\Http\Controllers\PlayTogetherController::class, 'show'])->name('show');
        
        // Participant actions
        Route::post('/{id}/join', [App\Http\Controllers\PlayTogetherController::class, 'join'])->name('join');
        Route::post('/{id}/leave', [App\Http\Controllers\PlayTogetherController::class, 'leave'])->name('leave');
        
        // Organizer actions
        Route::post('/{id}/participants/{participantId}/approve', [App\Http\Controllers\PlayTogetherController::class, 'approveParticipant'])->name('approve-participant');
        Route::post('/{id}/participants/{participantId}/reject', [App\Http\Controllers\PlayTogetherController::class, 'rejectParticipant'])->name('reject-participant');
        
        // Chat routes
        Route::prefix('{id}/chat')->name('chat.')->group(function () {
            Route::get('/', [App\Http\Controllers\PlayTogetherChatController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\PlayTogetherChatController::class, 'store'])->name('store');
            Route::get('/load-more', [App\Http\Controllers\PlayTogetherChatController::class, 'loadMore'])->name('load-more');
            Route::post('/mark-read', [App\Http\Controllers\PlayTogetherChatController::class, 'markAsRead'])->name('mark-read');
            Route::get('/unread-count', [App\Http\Controllers\PlayTogetherChatController::class, 'getUnreadCount'])->name('unread-count');
        });
        
        // Payment routes
        Route::get('/{id}/payment', [App\Http\Controllers\PlayTogetherPaymentController::class, 'payment'])->name('payment');
        Route::post('/{id}/payment/upload', [App\Http\Controllers\PlayTogetherPaymentController::class, 'uploadPaymentProof'])->name('payment.upload');
        
        Route::prefix('{id}/payments')->name('payments.')->group(function () {
            Route::get('/', [App\Http\Controllers\PlayTogetherPaymentController::class, 'index'])->name('index');
            Route::get('/summary', [App\Http\Controllers\PlayTogetherPaymentController::class, 'getPaymentSummary'])->name('summary');
            Route::get('/{paymentId}', [App\Http\Controllers\PlayTogetherPaymentController::class, 'show'])->name('show');
            Route::post('/{paymentId}/mark-paid', [App\Http\Controllers\PlayTogetherPaymentController::class, 'markAsPaid'])->name('mark-paid');
            Route::post('/{paymentId}/upload-proof', [App\Http\Controllers\PlayTogetherPaymentController::class, 'uploadProof'])->name('upload-proof');
            Route::post('/{paymentId}/verify', [App\Http\Controllers\PlayTogetherPaymentController::class, 'verifyPayment'])->name('verify');
            Route::post('/{paymentId}/remind', [App\Http\Controllers\PlayTogetherPaymentController::class, 'sendReminder'])->name('remind');
        });
    });
    
    // Legacy PlayTogether routes (for backward compatibility)
    Route::post('/play-together/{playTogether}/join', [CommunityController::class, 'joinPlayTogether'])->name('legacy.play-together.join');
    Route::post('/play-together/{playTogether}/leave', [CommunityController::class, 'leavePlayTogether'])->name('legacy.play-together.leave');
    
    // Tournament routes
    Route::post('/tournament/{tournament}/register', [CommunityController::class, 'registerTournament'])->name('tournament.register');
    Route::post('/tournament/{tournament}/unregister', [CommunityController::class, 'unregisterTournament'])->name('tournament.unregister');
    
    // Notification routes
    Route::post('/notifications/sample', [NotificationController::class, 'createSample'])->name('notifications.sample');
    Route::post('/notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
});