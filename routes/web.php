<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\Training\TrainingController;
use App\Http\Controllers\Training\EnrollmentController;
use App\Http\Controllers\Payment\CheckoutController as PaymentCheckoutController;
use App\Http\Controllers\Payment\WebhookController as PaymentWebhookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PaymentSettingsController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\EnrollmentController as AdminEnrollmentController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);

Route::get('/quantum/{category?}', [PageController::class, 'quantum'])->name('quantum');

Route::get('/services/{category?}', [PageController::class, 'services'])->name('services');

Route::get('/products/{category?}', [PageController::class, 'products'])->name('products');

Route::get('/training/{category?}', [PageController::class, 'training'])->name('training');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/content/{slug}', [PageController::class, 'contentItemShow'])->name('content.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    // Trainings listing & detail for enrollment (marketing / app)
Route::get('/training/course/{slug}', [TrainingController::class, 'show'])->name('training.show');

// Enrollment - requires login (only for non-admin users)
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsNotAdmin::class])->group(function () {
    Route::post('/training/course/{slug}/enroll', [EnrollmentController::class, 'store'])->name('training.enroll');
});

// Payment returns
Route::get('/checkout/success', [PaymentCheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/failed', [PaymentCheckoutController::class, 'failed'])->name('checkout.failed');

// Webhooks (use POST from providers)
Route::post('/webhooks/stripe', [PaymentWebhookController::class, 'stripe'])->name('webhooks.stripe');
Route::post('/webhooks/razorpay', [PaymentWebhookController::class, 'razorpay'])->name('webhooks.razorpay');

// User Auth Routes (prevent admins from accessing)
Route::middleware([\App\Http\Middleware\EnsureUserIsNotAdmin::class])->group(function () {
    Route::get('/register-new-user', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// User Logout (accessible to all authenticated users)
Route::post('/logout', LogoutController::class)->name('logout');

// Authenticated User Routes (only for non-admin users)
Route::middleware(['auth', \App\Http\Middleware\EnsureUserIsNotAdmin::class])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/enrollments', [UserDashboardController::class, 'enrollments'])->name('enrollments');
    Route::get('/payments', [UserDashboardController::class, 'payments'])->name('payments');
});

// Language switching route
Route::get('/locale/{locale}', function (string $locale) {
    $supported = ['en', 'de'];
    if (!in_array($locale, $supported, true)) {
        abort(404);
    }
    session(['app_locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
})->name('locale.switch');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Login routes (public)
    Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminController::class, 'login']);
    
    // Protected admin routes
    Route::middleware([EnsureUserIsAdmin::class])->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        
        // Payment Settings
        Route::get('/payment-settings', [PaymentSettingsController::class, 'edit'])->name('payment-settings.edit');
        Route::put('/payment-settings', [PaymentSettingsController::class, 'update'])->name('payment-settings.update');
        
        // Payment Management
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/{id}', [AdminPaymentController::class, 'show'])->name('payments.show');
        Route::post('/payments/{id}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
        Route::post('/payments/{id}/refund', [AdminPaymentController::class, 'refund'])->name('payments.refund');
        
        // Enrollment Management
        Route::get('/enrollments', [AdminEnrollmentController::class, 'index'])->name('enrollments.index');
        Route::get('/enrollments/{id}', [AdminEnrollmentController::class, 'show'])->name('enrollments.show');
        Route::post('/enrollments/{id}/status', [AdminEnrollmentController::class, 'updateStatus'])->name('enrollments.updateStatus');
        Route::post('/enrollments/{id}/cancel', [AdminEnrollmentController::class, 'cancel'])->name('enrollments.cancel');
        
        // Placeholder routes for other admin pages
        Route::get('/services', [AdminController::class, 'services'])->name('services');
        Route::get('/products', [AdminController::class, 'products'])->name('products');
        Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/accounts', [AdminController::class, 'accounts'])->name('accounts');
        Route::get('/help', [AdminController::class, 'help'])->name('help');
        
        // Categories Routes
        Route::resource('categories', CategoryController::class)->except(['create', 'edit', 'show']);
        
        // Content Management Routes (Quantum, Services, Products, Training, Blog)
        Route::prefix('content')->name('content.')->group(function () {
            Route::get('/{type}', [ContentController::class, 'index'])->name('index');
            Route::post('/{type}', [ContentController::class, 'store'])->name('store');
            Route::put('/{type}/{id}', [ContentController::class, 'update'])->name('update');
            Route::delete('/{type}/{id}', [ContentController::class, 'destroy'])->name('destroy');
        });
        
        // Blog-specific create/edit routes (dedicated pages for better UX)
        Route::prefix('content/blog')->name('content.blog.')->group(function () {
            Route::get('/create', [ContentController::class, 'createBlog'])->name('create');
            Route::get('/{id}/edit', [ContentController::class, 'editBlog'])->name('edit');
        });

        // Editor Upload Routes (for blog custom editor)
        Route::post('/upload-file', [ContentController::class, 'uploadFile'])->name('upload-file');
        Route::post('/upload-images', [ContentController::class, 'uploadImages'])->name('upload-images');

        // Banners & Hero Section
        Route::resource('banners', BannerController::class)->except(['create', 'edit', 'show']);
        Route::post('hero-section', [BannerController::class, 'saveHero'])->name('hero.save');
        
        // Contact Messages Routes
        Route::resource('contacts', AdminContactController::class)->except(['create', 'edit']);
        Route::put('/contacts/{id}/status', [AdminContactController::class, 'update'])->name('contacts.update.status');

        // Notifications
        Route::get('/notifications-feed', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/{notification}/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllAsRead'])->name('notifications.read_all');
        
        // SEO Management Routes
        Route::get('/seo', [SeoController::class, 'index'])->name('seo.index');
        Route::put('/seo/{page}', [SeoController::class, 'update'])->name('seo.update');
        
        // Translation Management Routes
        Route::get('/translations', [\App\Http\Controllers\Admin\TranslationController::class, 'index'])->name('translations.index');
        Route::post('/translations/sync', [\App\Http\Controllers\Admin\TranslationController::class, 'sync'])->name('translations.sync');
        Route::get('/translations/{id}', [\App\Http\Controllers\Admin\TranslationController::class, 'show'])->name('translations.show');
        Route::put('/translations/{id}', [\App\Http\Controllers\Admin\TranslationController::class, 'update'])->name('translations.update');
    });
});
