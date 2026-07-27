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
