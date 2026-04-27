<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AccountController; 
use App\Http\Middleware\CheckAdmin  ;
use App\Http\Controllers\AdminController;
Route::get('/', [HomeController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware('auth')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'add']);
    Route::get('/cart', [CartController::class, 'index']);
    // Route xem lịch sử mua hàng
    Route::get('/my-orders', [CheckoutController::class, 'myOrders']);

    Route::get('/profile', [AccountController::class, 'index']);
    Route::post('/profile/update', [AccountController::class, 'update']);
}); 

Route::post('/checkout', [CheckoutController::class, 'index']);

// Route xử lý khi khách bấm nút Đặt Hàng
Route::post('/place-order', [CheckoutController::class, 'placeOrder']);

// Route hiển thị trang Hóa đơn (có kèm ID đơn hàng)
Route::get('/receipt/{id}', [CheckoutController::class, 'receipt']);

// Route xem danh sách thông báo
Route::get('/notifications', [AccountController::class, 'notifications']);

// KHU VỰC DÀNH RIÊNG CHO ADMIN
Route::middleware(['auth', CheckAdmin::class])->prefix('admin')->group(function () {
    // Xem trang tổng quan
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    
    // Xử lý gửi thông báo hàng loạt
    Route::post('/send-notification', [AdminController::class, 'sendNotification']);

    // Quản lý Danh mục
    Route::get('/categories', [AdminController::class, 'categoryIndex']);
    Route::post('/categories/store', [AdminController::class, 'categoryStore']);
    Route::get('/categories/edit/{id}', [AdminController::class, 'categoryEdit']);
    Route::post('/categories/update/{id}', [AdminController::class, 'categoryUpdate']);
    Route::get('/categories/delete/{id}', [AdminController::class, 'categoryDelete']);

    // Quản lý Sản phẩm
    Route::get('/products', [AdminController::class, 'productIndex']);
    Route::post('/products/store', [AdminController::class, 'productStore']);
    Route::get('/products/delete/{id}', [AdminController::class, 'productDelete']);
    // Sửa sản phẩm
    Route::get('/products/edit/{id}', [AdminController::class, 'productEdit']);
    Route::post('/products/update/{id}', [AdminController::class, 'productUpdate']);

    // Quản lý Khách hàng
    Route::get('/users', [AdminController::class, 'userIndex']);
    Route::get('/users/delete/{id}', [AdminController::class, 'userDelete']);

    Route::get('/orders', [AdminController::class, 'orderIndex']);
    Route::get('/orders/detail/{id}', [AdminController::class, 'orderDetail']);
    Route::post('/orders/update-status/{id}', [AdminController::class, 'orderUpdateStatus']);
});