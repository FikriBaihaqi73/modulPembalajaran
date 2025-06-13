<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SantriController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\ModuleCategoryController as MentorModuleCategoryController;
use App\Http\Controllers\Mentor\ModuleController as MentorModuleController;
use App\Http\Controllers\Mentor\SantriController as MentorSantriController;
use App\Http\Controllers\Mentor\MentorProfileController;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('santri.home');
})->name('santri.home');

Route::get('/about', function () {
    return view('santri.about');
})->name('santri.about');

Route::get('/modules', function () {
    return view('santri.modul');
})->name('santri.modules');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Home Route (after successful login)
Route::get('/home', function () {
    return view('welcome');
})->middleware('auth');

// Admin Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-details', [ProfileController::class, 'updateProfileDetails'])->name('profile.updateDetails');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::resource('/santri', SantriController::class)->names('santri');
    Route::resource('/mentor', MentorController::class)->names('mentor');
});

// Mentor Routes
Route::middleware(['auth'])->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [MentorProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update-details', [MentorProfileController::class, 'updateProfileDetails'])->name('profile.updateDetails');
    Route::post('/profile/update-password', [MentorProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::resource('/module-categories', MentorModuleCategoryController::class)->names('module-categories');
    Route::resource('/modules', MentorModuleController::class)->names('modules');
    Route::post('/modules/upload-image', [MentorModuleController::class, 'uploadImage'])->name('modules.uploadImage');
    Route::resource('/santri', MentorSantriController::class)->names('santri');
});
