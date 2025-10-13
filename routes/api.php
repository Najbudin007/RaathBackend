<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMembershipController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\YatraController;
use App\Http\Controllers\SponsorshipTierController;
use App\Http\Controllers\BudgetBreakdownController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\MembershipApplicationController;
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

// API Welcome Route
Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to RaathBackend API',
        'version' => '1.0.0',
        'documentation' => 'See README_FRONTEND.md for API documentation',
        'endpoints' => [
            'projects' => '/api/projects',
            'yatras' => '/api/yatras',
            'gallery' => '/api/gallery',
            'team' => '/api/team',
            'products' => '/api/products',
            'memberships' => '/api/memberships',
            'auth' => [
                'register' => 'POST /api/auth/register',
                'login' => 'POST /api/auth/login',
                'profile' => 'GET /api/auth/profile (requires auth)'
            ]
        ]
    ]);
});

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
Route::get('projects/rath-making', [ProjectController::class, 'rathMaking']);
Route::get('projects/{project}', [ProjectController::class, 'show']);
Route::get('team', [TeamMemberController::class, 'index']);
Route::get('pages/{slug}', [PageController::class, 'showBySlug']);
Route::get('memberships', [MembershipPlanController::class, 'index']);
Route::get('memberships/benefits-comparison', [MembershipPlanController::class, 'benefitsComparison']);

// Yatra routes (public)
Route::get('yatras', [YatraController::class, 'index']);
Route::get('yatras/next', [YatraController::class, 'nextYatra']);
Route::get('yatras/upcoming', [YatraController::class, 'upcomingYatras']);
Route::get('yatras/{yatra}', [YatraController::class, 'show']);

// Gallery routes (public)
Route::get('gallery', [GalleryController::class, 'index']);
Route::get('gallery/featured', [GalleryController::class, 'featured']);
Route::get('gallery/{gallery}', [GalleryController::class, 'show']);

// Document routes (public)
Route::get('documents', [DocumentController::class, 'index']);
Route::get('documents/{document}', [DocumentController::class, 'show']);
Route::get('documents/{document}/download', [DocumentController::class, 'download']);

// Subscriber routes (public)
Route::post('subscribe', [SubscriberController::class, 'subscribe']);
Route::post('unsubscribe', [SubscriberController::class, 'unsubscribe']);

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
        Route::post('apply', [UserMembershipController::class, 'apply']);
        Route::post('renew', [UserMembershipController::class, 'renew']);
        Route::delete('cancel', [UserMembershipController::class, 'cancel']);
        Route::get('history', [UserMembershipController::class, 'history']);
        Route::get('application-status', [UserMembershipController::class, 'applicationStatus']);
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
        
        // Yatra management
        Route::post('admin/yatras', [YatraController::class, 'store']);
        Route::put('admin/yatras/{yatra}', [YatraController::class, 'update']);
        Route::delete('admin/yatras/{yatra}', [YatraController::class, 'destroy']);
        
        // Gallery management
        Route::post('admin/gallery', [GalleryController::class, 'store']);
        Route::put('admin/gallery/{gallery}', [GalleryController::class, 'update']);
        Route::delete('admin/gallery/{gallery}', [GalleryController::class, 'destroy']);
        
        // Subscriber management
        Route::get('admin/subscribers', [SubscriberController::class, 'index']);
        Route::get('admin/subscribers/statistics', [SubscriberController::class, 'statistics']);
        
        // Membership Application management
        Route::get('admin/membership-applications', [MembershipApplicationController::class, 'index']);
        Route::get('admin/membership-applications/statistics', [MembershipApplicationController::class, 'statistics']);
        Route::get('admin/membership-applications/{application}', [MembershipApplicationController::class, 'show']);
        Route::post('admin/membership-applications/{application}/approve', [MembershipApplicationController::class, 'approve']);
        Route::post('admin/membership-applications/{application}/reject', [MembershipApplicationController::class, 'reject']);
        
        // Sponsorship Tier management
        Route::apiResource('admin/sponsorship-tiers', SponsorshipTierController::class);
        
        // Budget Breakdown management
        Route::apiResource('admin/budget-breakdowns', BudgetBreakdownController::class);
        
        // Document management
        Route::apiResource('admin/documents', DocumentController::class);
    });
});
