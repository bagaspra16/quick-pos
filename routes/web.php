<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('menu/{barcode}', [MenuController::class, 'tableMenu'])->name('menu.table');
Route::post('menu/{barcode}/order', [MenuController::class, 'placeOrder'])->name('menu.placeOrder');
Route::get('menu/{barcode}/status', [MenuController::class, 'checkOrderStatus'])->name('menu.status');

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', ProductController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Tables
    Route::resource('tables', TableController::class);
    Route::get('tables/{table}/qrcode', [TableController::class, 'showQrCode'])->name('tables.qrcode');
    Route::get('tables/{table}/print-qrcode', [TableController::class, 'printQrCode'])->name('tables.print-qrcode');
    
    // Orders
    Route::resource('orders', OrderController::class)->except(['edit', 'update', 'destroy']);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('order-items/{item}/status', [OrderController::class, 'updateItemStatus'])->name('orderItems.updateStatus');
    
    // Payments
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('orders/{order}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('orders/{order}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::get('payments/{payment}/receipt', [PaymentController::class, 'printReceipt'])->name('payments.receipt');
    
    // Profile
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// Add notification API route
Route::get('/api/notifications', [App\Http\Controllers\Api\NotificationController::class, 'index'])->name('api.notifications');
