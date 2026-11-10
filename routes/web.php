<?php

use App\Http\Controllers\Admin\AboutSectionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactSectionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeSectionController;
use App\Http\Controllers\Admin\HowToOrderSectionController;
use App\Http\Controllers\Admin\ProductSectionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\TestimonialSectionController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Custom Admin Portal & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Admin Panel Routes (Protected)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (all authenticated users)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // User Management (Super Admin only)
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserManagementController::class)->except(['show']);
        Route::patch('/users/{user}/toggle-active', [UserManagementController::class, 'toggleActive'])
            ->name('users.toggle-active');
        Route::post('/users/{user}/reset-password', [UserManagementController::class, 'resetPassword'])
            ->name('users.reset-password');
    });

    // Home Section Management
    Route::middleware('permission:manage_home_sections')->group(function () {
        Route::patch('/home-sections/{homeSection}/toggle-status', [HomeSectionController::class, 'toggleStatus'])
            ->name('home-sections.toggle-status');
        Route::resource('home-sections', HomeSectionController::class)->except(['show']);
    });

    // About Section Management
    Route::middleware('permission:manage_about_sections')->group(function () {
        Route::patch('/about-sections/{aboutSection}/toggle-status', [AboutSectionController::class, 'toggleStatus'])
            ->name('about-sections.toggle-status');
        Route::resource('about-sections', AboutSectionController::class)->except(['show']);
    });

    // Product Section Management
    Route::middleware('permission:manage_product_sections')->group(function () {
        Route::patch('/product-sections/{productSection}/toggle-status', [ProductSectionController::class, 'toggleStatus'])
            ->name('product-sections.toggle-status');
        Route::resource('product-sections', ProductSectionController::class)->except(['show']);
    });

    // How To Order Management
    Route::middleware('permission:manage_how_to_order')->group(function () {
        Route::patch('/how-to-orders/{howToOrder}/toggle-status', [HowToOrderSectionController::class, 'toggleStatus'])
            ->name('how-to-orders.toggle-status');
        Route::resource('how-to-orders', HowToOrderSectionController::class)->except(['show']);
    });

    // Testimonial Hub Management
    Route::middleware('permission:manage_testimonials')->group(function () {
        Route::get('/testimonials', [TestimonialSectionController::class, 'index'])
            ->name('testimonials.index');
        Route::post('/testimonials/header', [TestimonialSectionController::class, 'updateHeader'])
            ->name('testimonials.update-header');
        Route::patch('/testimonials/toggle-status', [TestimonialSectionController::class, 'toggleStatus'])
            ->name('testimonials.toggle-status');
        Route::post('/testimonials/batch-store', [TestimonialSectionController::class, 'batchStore'])
            ->name('testimonials.batch-store');
        Route::put('/testimonials/items/{testimonialItem}', [TestimonialSectionController::class, 'updateItem'])
            ->name('testimonials.update-item');
        Route::delete('/testimonials/items/{testimonialItem}', [TestimonialSectionController::class, 'destroyItem'])
            ->name('testimonials.destroy-item');
    });

    // Legacy Fallbacks & Compatibility
    Route::get('/testimonial-sections', function () {
        return redirect()->route('admin.testimonials.index');
    })->name('testimonial-sections.index');
    Route::get('/testimonial-sections/create', [TestimonialSectionController::class, 'create'])
        ->name('testimonial-sections.create');
    Route::get('/testimonial-sections/{testimonialSection}/edit', [TestimonialSectionController::class, 'edit'])
        ->name('testimonial-sections.edit');
    Route::post('/testimonial-sections', [TestimonialSectionController::class, 'store'])
        ->name('testimonial-sections.store');
    Route::put('/testimonial-sections/{testimonialSection}', [TestimonialSectionController::class, 'update'])
        ->name('testimonial-sections.update');
    Route::delete('/testimonial-sections/{testimonialSection}', [TestimonialSectionController::class, 'destroy'])
        ->name('testimonial-sections.destroy');
    Route::patch('/testimonial-sections/{testimonialSection}/toggle-status', [TestimonialSectionController::class, 'toggleStatus'])
        ->name('testimonial-sections.toggle-status');

    // Contact Section Management
    Route::middleware('permission:manage_contact_sections')->group(function () {
        Route::patch('/contact-sections/{contactSection}/toggle-status', [ContactSectionController::class, 'toggleStatus'])
            ->name('contact-sections.toggle-status');
        Route::resource('contact-sections', ContactSectionController::class)->except(['show']);
    });

    // Legacy Fallback & Compatibility
    Route::get('/contact-section', function () {
        return redirect()->route('admin.contact-sections.index');
    })->name('contact-section.index');
});
