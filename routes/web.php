<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Frontend Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\ModuleController as FrontendModuleController;
use App\Http\Controllers\Frontend\SantriProfileController;
use App\Http\Controllers\Frontend\NotificationController as FrontendNotificationController;
use App\Http\Controllers\Santri\ModuleDownloadController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MajorController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\UserController;

// Mentor Controllers
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\ModuleCategoryController as MentorModuleCategoryController;
use App\Http\Controllers\Mentor\ModuleController as MentorModuleController;
use App\Http\Controllers\Mentor\SantriController as MentorSantriController;
use App\Http\Controllers\Mentor\MentorProfileController;
use App\Http\Controllers\Mentor\ReviewReplyController;
use App\Http\Controllers\Mentor\NotificationController as MentorNotificationController;
use App\Http\Controllers\Mentor\AnnouncementController as MentorAnnouncementController;

Route::get('/', function () {
    return view('santri.home');
})->name('santri.home');

Route::get('/about', function () {
    return view('santri.about');
})->name('santri.about');

// Route::get('/modules', function () {
//     return view('santri.modul');
// })->name('santri.modules');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home Route (after successful login)
Route::get('/home', function () {
    return view('welcome');
})->middleware('auth');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-details', [ProfileController::class, 'updateProfileDetails'])->name('profile.updateDetails');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::resource('santri', SantriController::class)->names('santri');
    Route::resource('mentor', MentorController::class)->names('mentor');
    Route::get('modules', [ModuleController::class, 'index'])->name('modules.index');
    Route::get('modules/{module}', [ModuleController::class, 'show'])->name('modules.show');

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [AdminNotificationController::class, 'index'])->name('index');
        Route::post('{id}/mark-as-read', [AdminNotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('mark-all-as-read', [AdminNotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('{id}', [AdminNotificationController::class, 'destroy'])->name('destroy');
        Route::post('{id}/mark-as-unread', [AdminNotificationController::class, 'markAsUnread'])->name('markAsUnread');
    });

    // User Management Routes
    Route::resource('users', UserController::class);
    Route::resource('majors', MajorController::class);
    Route::resource('announcements', AnnouncementController::class);
});

// Mentor Routes
Route::middleware(['auth', 'mentor'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [MentorProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-details', [MentorProfileController::class, 'updateProfileDetails'])->name('profile.updateDetails');
    Route::post('/profile/update-password', [MentorProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::resource('module-categories', MentorModuleCategoryController::class)->names('module-categories');
    Route::post('module-categories/{module_category}/toggle-visibility', [MentorModuleCategoryController::class, 'toggleVisibility'])->name('module-categories.toggleVisibility');
    Route::resource('modules', MentorModuleController::class)->names('modules');
    Route::post('modules/upload-image', [MentorModuleController::class, 'uploadImage'])->name('modules.uploadImage');
    Route::post('modules/{module}/toggle-visibility', [MentorModuleController::class, 'toggleVisibility'])->name('modules.toggleVisibility');
    Route::resource('santri', MentorSantriController::class)->names('santri');
    Route::get('module-progress', [App\Http\Controllers\Mentor\ModuleProgressController::class, 'index'])->name('module-progress.index');
    Route::get('module-progress/{module}', [App\Http\Controllers\Mentor\ModuleProgressController::class, 'show'])->name('module-progress.show');
    Route::post('reviews/{review}/replies', [ReviewReplyController::class, 'store'])->name('reviews.replies.store');

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [MentorNotificationController::class, 'index'])->name('index');
        Route::post('{id}/mark-as-read', [MentorNotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('mark-all-as-read', [MentorNotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('{id}', [MentorNotificationController::class, 'destroy'])->name('destroy');
        Route::post('{id}/mark-as-unread', [MentorNotificationController::class, 'markAsUnread'])->name('markAsUnread');
    });

    // Announcement Management Routes
    Route::resource('announcements', MentorAnnouncementController::class);
});

// Santri Routes
Route::prefix('santri')->name('santri.')->group(function () {
    Route::get('/modules', [FrontendModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/completed', [FrontendModuleController::class, 'completedModules'])->name('modules.completed');
    Route::get('/modules/{module}', [FrontendModuleController::class, 'show'])->name('modules.show');
    Route::post('/modules/{module}/toggle-completion', [FrontendModuleController::class, 'toggleCompletion'])->name('modules.toggleCompletion');
    Route::post('/modules/{module}/review', [FrontendModuleController::class, 'storeReview'])->name('modules.storeReview');
    Route::put('/modules/{module}/review/{review}', [FrontendModuleController::class, 'updateReview'])->name('modules.updateReview');
    Route::delete('/modules/{module}/review/{review}', [FrontendModuleController::class, 'destroyReview'])->name('modules.destroyReview');

    // Notification Routes
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [FrontendNotificationController::class, 'index'])->name('index');
        Route::post('{id}/mark-as-read', [FrontendNotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::post('mark-all-as-read', [FrontendNotificationController::class, 'markAllAsRead'])->name('markAllAsRead');
        Route::delete('{id}', [FrontendNotificationController::class, 'destroy'])->name('destroy');
        Route::post('{id}/mark-as-unread', [FrontendNotificationController::class, 'markAsUnread'])->name('markAsUnread');
    });

    // New download routes
    Route::get('/modules/{module}/download-pdf', [ModuleDownloadController::class, 'downloadSingleModulePdf'])->name('modules.download.pdf');
    Route::get('/modules/category/{categoryName}/download-zip', [ModuleDownloadController::class, 'downloadModulesByCategoryZip'])->name('modules.download.category.zip');

    Route::get('/profile', [SantriProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-details', [SantriProfileController::class, 'updateDetails'])->name('profile.updateDetails');
    Route::post('/profile/update-password', [SantriProfileController::class, 'updatePassword'])->name('profile.updatePassword');
});
