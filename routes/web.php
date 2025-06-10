<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\StudioController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboard;
use App\Http\Controllers\Customer\StudioController as CustomerStudioController;
use App\Http\Controllers\Customer\BookingController as CustomerBookingController;
use App\Http\Controllers\Customer\PaymentController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Studios Management
    Route::resource('studios', StudioController::class);
    
    
    // Bookings Management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [AdminBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::patch('/bookings/{booking}/verify-payment', [AdminBookingController::class, 'verifyPayment'])->name('bookings.verify-payment');
    Route::patch('/bookings/{booking}/update-status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::resource('bookings', AdminBookingController::class);

    // Reports
    Route::get('/reports', [AdminBookingController::class, 'reports'])->name('reports');
});

Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', [CustomerDashboard::class, 'index'])->name('dashboard');
    
    // Studios
    Route::get('/studios', [CustomerStudioController::class, 'index'])->name('studios.index');
    Route::get('/studios/{studio}', [CustomerStudioController::class, 'show'])->name('studios.show');
    Route::get('/studios/{studio}/availability', [CustomerStudioController::class, 'checkAvailability']);
    
    // Bookings
    Route::get('/bookings', [CustomerBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create/{studio}', [CustomerBookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [CustomerBookingController::class, 'store'])->name('bookings.store');
    
    Route::get('/bookings/{booking}', [CustomerBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/upload-payment', [CustomerBookingController::class, 'uploadPayment'])->name('bookings.upload-payment');
    Route::get('/bookings/{booking}/pay', [PaymentController::class, 'pay'])->name('customer.bookings.pay');
});

// Gunakan api.php agar tidak kena CSRF
Route::post('/midtrans/callback', [\App\Http\Controllers\Payment\MidtransCallbackController::class, 'handle']);