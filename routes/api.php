<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMembershipController;
use App\Http\Controllers\MembershipPlanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// Public content routes
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);
Route::get('projects', [ProjectController::class, 'index']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
Route::get('team', [TeamMemberController::class, 'index']);
Route::get('pages/{slug}', [PageController::class, 'showBySlug']);
Route::get('memberships', [MembershipPlanController::class, 'index']);

// Public donation route (can be used by non-authenticated users)
Route::post('donations', [DonationController::class, 'store']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
    });

    // User routes
    Route::prefix('user')->group(function () {
        Route::put('profile', [UserController::class, 'updateProfile']);
    });

    // Membership routes
    Route::prefix('memberships')->group(function () {
        Route::post('join', [UserMembershipController::class, 'join']);
        Route::post('renew', [UserMembershipController::class, 'renew']);
        Route::delete('cancel', [UserMembershipController::class, 'cancel']);
        Route::get('history', [UserMembershipController::class, 'history']);
    });

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('add', [CartController::class, 'addToCart']);
        Route::put('items/{cartItem}', [CartController::class, 'updateItem']);
        Route::delete('items/{cartItem}', [CartController::class, 'removeItem']);
        Route::delete('clear', [CartController::class, 'clear']);
    });

    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'checkout']);
        Route::get('{order}', [OrderController::class, 'show']);
    });

    // Donation routes
    Route::prefix('donations')->group(function () {
        Route::get('my', [DonationController::class, 'myDonations']);
        Route::get('{donation}', [DonationController::class, 'show']);
    });

    // Notification routes
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('unread-count', [NotificationController::class, 'unreadCount']);
        Route::put('mark-all-read', [NotificationController::class, 'markAllAsRead']);
        Route::put('{notification}/read', [NotificationController::class, 'markAsRead']);
    });

    // Transaction routes
    Route::prefix('transactions')->group(function () {
        Route::get('/', [TransactionController::class, 'index']);
        Route::post('/', [TransactionController::class, 'store']);
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        Route::get('admin/donations', [DonationController::class, 'index']);
        Route::get('admin/orders', [OrderController::class, 'adminIndex']);
        Route::get('admin/transactions', [TransactionController::class, 'adminIndex']);
        Route::get('admin/transactions/statistics', [TransactionController::class, 'statistics']);
        Route::post('notifications/send', [NotificationController::class, 'send']);
    });
});
