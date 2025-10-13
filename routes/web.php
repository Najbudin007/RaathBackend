<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\JobRoleController;
use App\Http\Controllers\Admin\MetricsController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\PortfolioCategoryController;
use App\Http\Controllers\Admin\TempleController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\YatraController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\MembershipPlanController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\SponsorshipTierController;
use App\Http\Controllers\Admin\BudgetBreakdownController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard redirect
Route::get('dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('admin.home');

// Admin routes group
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

    Route::resources([
        'users' => UserController::class,
        'categories' => CategoryController::class,
        'products' => ProductController::class,
        'projects' => ProjectController::class,
        'yatras' => YatraController::class,
        'gallery' => GalleryController::class,
        'team' => TeamMemberController::class,
        'memberships' => MembershipPlanController::class,
        'cms-pages' => PageController::class,
        'subscribers' => SubscriberController::class,
        'donations' => DonationController::class,
        'sponsorship-tiers' => SponsorshipTierController::class,
        'budget-breakdowns' => BudgetBreakdownController::class,
        'documents' => DocumentController::class,
        'orders' => OrderController::class,
        'banners' => BannerController::class,
        'settings' => SettingController::class,
        'blogs' => BlogController::class,
        'services' => ServiceController::class,
        'blog_categories' => BlogCategoryController::class,
        'clients' => ClientController::class,
        'job_roles' => JobRoleController::class,
        'service_categories' => ServiceCategoryController::class,
        'careers' => CareerController::class,
        'tags' => TagController::class,
        'metrics' => MetricsController::class,
        'portfolio_categories' => PortfolioCategoryController::class,
        'portfolios' => PortfolioController::class,
        'teams' => TeamController::class,
        'books' => BookController::class,
        'temples' => TempleController::class,
        'media' => MediaController::class,
        'departments' => DepartmentController::class,
        'branches' => BranchController::class,
        'home_sliders' => HomeSliderController::class,
    ]);

    Route::get('subscriptions', SubscriptionController::class)->name('subscription');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('upload-file', FileController::class);

    Route::get('/medias', [MediaController::class, 'index'])->name('medias.index');
    Route::get('/folders/{folder?}', [MediaController::class, 'getFolders']);
    Route::get('/files/{folder?}', [MediaController::class, 'getFiles']);

    Route::get('google-analytics', [AnalyticsController::class, 'dashboard'])->name('google-analytics');
    
    // Additional user routes
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    
    // Additional category routes
    Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Additional product routes
    Route::post('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::post('products/{product}/toggle-featured', [ProductController::class, 'toggleFeatured'])->name('products.toggle-featured');
    Route::post('products/{product}/remove-image', [ProductController::class, 'removeImage'])->name('products.remove-image');
    
    // Additional project routes
    Route::post('projects/{project}/toggle-featured', [ProjectController::class, 'toggleFeatured'])->name('projects.toggle-featured');
    Route::post('projects/{project}/update-status', [ProjectController::class, 'updateStatus'])->name('projects.update-status');
    Route::post('projects/{project}/remove-image', [ProjectController::class, 'removeImage'])->name('projects.remove-image');
    Route::post('projects/{project}/remove-document', [ProjectController::class, 'removeDocument'])->name('projects.remove-document');
    
    // Additional yatra routes
    Route::post('yatras/{yatra}/toggle-featured', [YatraController::class, 'toggleFeatured'])->name('yatras.toggle-featured');
    Route::post('yatras/{yatra}/update-status', [YatraController::class, 'updateStatus'])->name('yatras.update-status');
    
    // Additional gallery routes
    Route::post('gallery/{gallery}/toggle-status', [GalleryController::class, 'toggleStatus'])->name('gallery.toggle-status');
    Route::post('gallery/{gallery}/toggle-featured', [GalleryController::class, 'toggleFeatured'])->name('gallery.toggle-featured');
    Route::post('gallery/bulk-upload', [GalleryController::class, 'bulkUpload'])->name('gallery.bulk-upload');
    
    // Additional team routes
    Route::post('team/{team}/toggle-status', [TeamMemberController::class, 'toggleStatus'])->name('team.toggle-status');
    
    // Additional membership routes
    Route::post('memberships/{membership}/toggle-status', [MembershipPlanController::class, 'toggleStatus'])->name('memberships.toggle-status');
    
    // Additional page routes
    Route::post('cms-pages/{cmsPage}/toggle-status', [PageController::class, 'toggleStatus'])->name('cms-pages.toggle-status');
    
    // Additional subscriber routes
    Route::post('subscribers/{subscriber}/toggle-status', [SubscriberController::class, 'toggleStatus'])->name('subscribers.toggle-status');
    Route::get('subscribers/export', [SubscriberController::class, 'export'])->name('subscribers.export');
    
    // Additional donation routes
    Route::post('donations/{donation}/update-status', [DonationController::class, 'updateStatus'])->name('donations.update-status');
    
    // Additional sponsorship tier routes
    Route::post('sponsorship-tiers/{sponsorshipTier}/toggle-status', [SponsorshipTierController::class, 'toggleStatus'])->name('sponsorship-tiers.toggle-status');
    
    // Additional order routes
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

require __DIR__ . '/auth.php';
