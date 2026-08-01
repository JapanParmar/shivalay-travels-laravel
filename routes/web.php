<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Middleware\AdminAuth;

// ─────────────────────────────────────────────────────────────────
// PUBLIC FRONT-END ROUTES
// ─────────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index']);
Route::get('/sitemap.xml', [HomeController::class, 'sitemap']);
Route::get('/robots.txt', [HomeController::class, 'robots']);
Route::get('/api/captcha', [HomeController::class, 'getCaptcha']);
Route::post('/api/admin/inquiries', [HomeController::class, 'submitInquiry']);
Route::post('/api/admin/bookings', [HomeController::class, 'submitBooking']);

// ─────────────────────────────────────────────────────────────────
// ADMIN AUTHENTICATION ROUTES
// ─────────────────────────────────────────────────────────────────
Route::get('/admin', function () {
    if (session()->has('admin_authenticated')) {
        return redirect('/admin/dashboard');
    }
    return redirect('/admin/login');
});

Route::get('/admin/login', [AdminAuthController::class, 'showLogin']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout']);

Route::get('/admin/verify-otp', [AdminAuthController::class, 'showVerifyOtp']);
Route::post('/admin/verify-otp', [AdminAuthController::class, 'verifyOtp']);
Route::post('/admin/resend-verify-otp', [AdminAuthController::class, 'resendVerifyOtp']);
Route::get('/admin/forgot-password', [AdminAuthController::class, 'showForgotPassword']);
Route::post('/admin/forgot-password', [AdminAuthController::class, 'forgotPassword']);
Route::get('/admin/reset-password', [AdminAuthController::class, 'showResetPassword']);
Route::post('/admin/reset-password', [AdminAuthController::class, 'resetPassword']);

// ─────────────────────────────────────────────────────────────────
// SECURE ADMIN ROUTES  (protected by AdminAuth middleware)
// ─────────────────────────────────────────────────────────────────
Route::middleware(AdminAuth::class)->group(function () {

    // Dashboard & Analytics
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/analytics', [AdminController::class, 'analytics']);

    // Bookings Management
    Route::get('/admin/bookings', [AdminController::class, 'bookings']);
    Route::post('/admin/bookings', [AdminController::class, 'storeBooking']);
    Route::post('/admin/bookings/update/{id}', [AdminController::class, 'updateBooking']);
    Route::post('/admin/bookings/status/{id}', [AdminController::class, 'updateBookingStatus']);
    Route::get('/admin/bookings/delete/{id}', [AdminController::class, 'deleteBooking']);

    // Inquiries Management
    Route::get('/admin/inquiries', [AdminController::class, 'inquiries']);
    Route::post('/admin/inquiries/update/{id}', [AdminController::class, 'updateInquiry']);
    Route::get('/admin/inquiries/delete/{id}', [AdminController::class, 'deleteInquiry']);

    // Settings Management
    Route::get('/admin/settings', [AdminController::class, 'settings']);
    Route::post('/admin/settings', [AdminController::class, 'updateSettings']);

    // Cities Route Management
    Route::get('/admin/cities', [AdminController::class, 'cities']);
    Route::post('/admin/cities', [AdminController::class, 'storeCity']);
    Route::post('/admin/cities/popular/{id}', [AdminController::class, 'toggleCityPopular']);
    Route::get('/admin/cities/delete/{id}', [AdminController::class, 'deleteCity']);

    // User & Agent Management
    Route::get('/admin/users', [AdminController::class, 'users']);
    Route::post('/admin/users', [AdminController::class, 'storeUser']);
    Route::post('/admin/users/role/{id}', [AdminController::class, 'updateUserRole']);
    Route::post('/admin/users/status/{id}', [AdminController::class, 'toggleUserStatus']);
    Route::get('/admin/users/delete/{id}', [AdminController::class, 'deleteUser']);

    // Content Management (Developer-only)
    Route::get('/admin/destinations', [AdminController::class, 'destinations']);
    Route::post('/admin/destinations', [AdminController::class, 'storeDestination']);
    Route::get('/admin/destinations/delete/{id}', [AdminController::class, 'deleteDestination']);

    Route::get('/admin/guides', [AdminController::class, 'guides']);
    Route::post('/admin/guides', [AdminController::class, 'storeGuide']);
    Route::get('/admin/guides/delete/{id}', [AdminController::class, 'deleteGuide']);

    Route::get('/admin/hotels', [AdminController::class, 'hotels']);
    Route::post('/admin/hotels', [AdminController::class, 'storeHotel']);
    Route::get('/admin/hotels/delete/{id}', [AdminController::class, 'deleteHotel']);

    Route::get('/admin/villas', [AdminController::class, 'villas']);
    Route::post('/admin/villas', [AdminController::class, 'storeVilla']);
    Route::get('/admin/villas/delete/{id}', [AdminController::class, 'deleteVilla']);

    Route::get('/admin/testimonials', [AdminController::class, 'testimonials']);
    Route::post('/admin/testimonials', [AdminController::class, 'storeTestimonial']);
    Route::get('/admin/testimonials/delete/{id}', [AdminController::class, 'deleteTestimonial']);

    // JSON API endpoints for admin UI
    Route::get('/api/admin/bookings', [AdminController::class, 'apiGetBookings']);
    Route::get('/api/admin/inquiries', [AdminController::class, 'apiGetInquiries']);
    Route::put('/api/admin/inquiries/{id}', [AdminController::class, 'apiUpdateInquiry']);
    Route::delete('/api/admin/inquiries/{id}', [AdminController::class, 'apiDeleteInquiry']);
    Route::get('/api/admin/settings', [AdminController::class, 'apiGetSettings']);
    Route::post('/api/admin/settings', [AdminController::class, 'apiUpdateSettings']);

    // File upload
    Route::post('/api/upload', [AdminController::class, 'uploadImage']);
});

// Temporary utility route for Render Free Tier migrations
Route::get('/run-migrations', function() {
    try {
        $output = "";
        
        // Clear configuration cache so Laravel reads the fresh Render Environment variables at runtime
        \Illuminate\Support\Facades\Artisan::call('config:clear');
        $output .= "Config Cache Cleared: " . trim(\Illuminate\Support\Facades\Artisan::output()) . "\n";
        
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
        $output .= "Application Cache Cleared: " . trim(\Illuminate\Support\Facades\Artisan::output()) . "\n\n";
        
        // Let's run migrations
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output .= "Migrations Run:\n" . \Illuminate\Support\Facades\Artisan::output() . "\n";
        
        if (request()->has('seed')) {
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            $output .= "Seeding Run:\n" . \Illuminate\Support\Facades\Artisan::output() . "\n";
        }
        
        return '<pre style="background:#111;color:#eee;padding:20px;border-radius:6px;font-family:monospace;">' . $output . '</pre>';
    } catch (\Exception $e) {
        return '<pre style="background:#400;color:#fdd;padding:20px;border-radius:6px;font-family:monospace;">Error: ' . $e->getMessage() . "\n\nTrace:\n" . $e->getTraceAsString() . '</pre>';
    }
});

// Diagnostic route to see what configuration is actually active
Route::get('/debug-db', function() {
    // Clear config cache first to get fresh environment values
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    
    return [
        'default_connection' => config('database.default'),
        'pgsql_config' => [
            'host' => config('database.connections.pgsql.host'),
            'port' => config('database.connections.pgsql.port'),
            'database' => config('database.connections.pgsql.database'),
            'username' => config('database.connections.pgsql.username'),
            'url_has_value' => !empty(config('database.connections.pgsql.url')),
            'url_preview' => substr(config('database.connections.pgsql.url'), 0, 30) . '...',
        ],
        'env_DB_CONNECTION' => env('DB_CONNECTION'),
        'env_DB_URL_exists' => !empty(env('DB_URL')),
        'env_DATABASE_URL_exists' => !empty(env('DATABASE_URL')),
    ];
});

