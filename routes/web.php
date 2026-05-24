<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\FnbController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\ChatController;

// Webhook Midtrans (No CSRF needed, see bootstrap/app.php)
Route::post('/api/webhook/midtrans', [WebhookController::class, 'midtransHandler']);

// Public pages
Route::get('/', [HomeController::class , 'index'])->name('home');
Route::get('/rates', [RateController::class , 'index'])->name('rates');
Route::get('/fnb', [FnbController::class , 'index'])->name('fnb');
Route::get('/location', [HomeController::class , 'location'])->name('location');
Route::get('/promos', [PromoController::class , 'index'])->name('promos.index');

// Auth - Guest only
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class , 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class , 'login']);
    Route::get('/admin/login', [AuthController::class , 'showAdminLogin'])->name('admin.login');

    Route::get('/register', [AuthController::class , 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class , 'register']);

    // Google Login Routes
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);
});

// Auth - General Authenticated (Logout)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class , 'logout'])->name('logout');
    Route::post('/admin/logout', [AuthController::class , 'adminLogout'])->name('admin.logout');
    
    // Chat Synchronization
    Route::post('/chat/sync', [ChatController::class, 'sync'])->name('chat.sync');
    Route::post('/chat/send', [ChatController::class, 'send'])->name('chat.send');
    Route::post('/chat/{tableId}/read', [ChatController::class, 'markAsRead'])->name('chat.read');
});

// Admin Dashboard & Management (Requires 'admin' Middleware)
Route::middleware('admin')->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class , 'index'])->name('admin.dashboard');
    Route::get('/admin/meja', [MejaController::class, 'index'])->name('admin.meja.index');
    Route::get('/admin/history', [AdminDashboardController::class, 'history'])->name('admin.history');
    Route::get('/admin/history/export', [AdminDashboardController::class, 'exportPdf'])->name('admin.history.export');
    Route::get('/admin/notifications/check', [AdminDashboardController::class, 'checkNotifications'])->name('admin.notifications.check');
    Route::post('/admin/booking/{id}/confirm', [AdminDashboardController::class, 'confirmBooking'])->name('admin.booking.confirm');
    Route::post('/admin/booking/{id}/cancel', [AdminDashboardController::class, 'cancelBooking'])->name('admin.booking.cancel');
    Route::post('/admin/booking/{id}/end', [AdminDashboardController::class, 'endSession'])->name('admin.booking.end');
    Route::delete('/admin/booking/{id}', [AdminDashboardController::class, 'deleteBooking'])->name('admin.booking.delete');
    Route::post('/admin/booking/{id}/status', [AdminDashboardController::class, 'updateStatus'])->name('admin.booking.updateStatus');
    Route::post('/admin/booking/{id}/complete', [AdminDashboardController::class, 'completeBooking'])->name('admin.booking.complete');

    // Admin Menu Management
    Route::get('/admin/menu', [MenuController::class, 'index'])->name('admin.menu');
    Route::get('/admin/menu/baru', [MenuController::class, 'create'])->name('admin.menu.create');
    Route::post('/admin/menu', [MenuController::class, 'store'])->name('admin.menu.store');
    Route::get('/admin/menu/{menu}/edit', [MenuController::class, 'edit'])->name('admin.menu.edit');
    Route::put('/admin/menu/{menu}', [MenuController::class, 'update'])->name('admin.menu.update');
    Route::delete('/admin/menu/{menu}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    
    // Admin Meja Management
    Route::get('/admin/meja/baru', [MejaController::class, 'create'])->name('admin.meja.create');
    Route::post('/admin/meja', [MejaController::class, 'store'])->name('admin.meja.store');
    Route::get('/admin/meja/{table}/edit', [MejaController::class, 'edit'])->name('admin.meja.edit');
    Route::put('/admin/meja/{table}', [MejaController::class, 'update'])->name('admin.meja.update');
    Route::delete('/admin/meja/{table}', [MejaController::class, 'destroy'])->name('admin.meja.destroy');
    
    // Admin Profile & Stock
    Route::get('/admin/profile', [AdminDashboardController::class, 'profile'])->name('admin.profile');
    Route::post('/admin/profile', [AdminDashboardController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/admin/stock', [StockController::class, 'index'])->name('admin.stock.index');
    Route::post('/admin/stock', [StockController::class, 'store'])->name('admin.stock.store');
    Route::get('/admin/stock/export', [StockController::class, 'exportPdf'])->name('admin.stock.export');
});

// User Dashboard & Booking (Requires 'user' Middleware)
Route::middleware('user')->group(function () {
    // Dashboard User
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/dashboard/profile', [DashboardController::class, 'profile'])->name('user.profile');
    Route::post('/dashboard/profile', [DashboardController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/dashboard/meja', [DashboardController::class, 'meja'])->name('user.meja');
    Route::get('/dashboard/meja/konfirmasi', [DashboardController::class, 'konfirmasi'])->name('user.meja.konfirmasi');
    Route::get('/dashboard/fnb', [DashboardController::class, 'fnb'])->name('user.fnb');
    Route::get('/dashboard/history', [DashboardController::class , 'history'])->name('user.history');
    Route::get('/dashboard/fnb/konfirmasi', [DashboardController::class, 'fnbKonfirmasi'])->name('user.fnb.konfirmasi');
    Route::post('/dashboard/fnb/checkout', [DashboardController::class, 'fnbCheckout'])->name('user.fnb.checkout');
    Route::post('/dashboard/fnb/success', [DashboardController::class, 'fnbSuccess'])->name('user.fnb.success');
    Route::get('/dashboard/notifications/check', [DashboardController::class, 'checkNotifications'])->name('user.notifications.check');

    // Booking
    Route::get('/booking', [BookingController::class , 'create'])->name('booking.create');
    Route::get('/booking/pilih-meja', [BookingController::class , 'selectTable'])->name('booking.select-table');
    Route::post('/booking', [BookingController::class , 'store'])->name('booking.store');
    Route::post('/booking/success', [BookingController::class , 'bookingSuccess'])->name('booking.success');
});