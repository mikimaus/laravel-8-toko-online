<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\BrandController;
use App\Http\Controllers\backend\BackupController;
use App\Http\Controllers\backend\ProductController;
use App\Http\Controllers\backend\ProfileController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\CategoryController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\SubCategoryController;
use App\Http\Controllers\backend\SubSubCategoryController;


Route::get('/dashboard', DashboardController::class)->name('dashboard');
// Role and User
Route::resource('/roles', RoleController::class);
Route::resource('/users', UserController::class);

// Backups routes
Route::resource('/backups', BackupController::class)->only('index', 'store', 'destroy');
Route::get('/backups/{file_name}', [BackupController::class, 'download'])->name('backups.download');
Route::delete('backups', [BackupController::class, 'clean'])->name('backups.clean');

// Profile routes
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

// Security routes
Route::get('profile/security', [ProfileController::class, 'changePassword'])->name('profile.password.change');
Route::post('profile/security', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

// Pages routes
Route::resource('pages', PageController::class);

// Settings routes
Route::group(['as' => 'settings.', 'prefix' => 'settings'], function () {
    Route::get('general', [SettingController::class, 'index'])->name('index');
    Route::patch('general', [SettingController::class, 'update'])->name('update');

    Route::get('appearance', [SettingController::class, 'appearance'])->name('appearance.index');
    Route::patch('appearance', [SettingController::class, 'updateAppearance'])->name('appearance.update');

    Route::get('mail', [SettingController::class, 'mail'])->name('mail.index');
    Route::patch('mail', [SettingController::class, 'updateMailSettings'])->name('mail.update');

    Route::get('socialite', [SettingController::class, 'socialite'])->name('socialite.index');
    Route::patch('socialite', [SettingController::class, 'updateSocialiteSettings'])->name('socialite.update');

    Route::get('database', [SettingController::class, 'database'])->name('database.index');
    Route::patch('database', [SettingController::class, 'updateDatabaseSettings'])->name('database.update');
});

// Catalog
Route::resource('/brands', BrandController::class)->except('show');
Route::resource('/categories', CategoryController::class)->except('show');
Route::resource('/subcategories', SubCategoryController::class)->except('show');
Route::resource('/subsubcategories', SubSubCategoryController::class)->except('show');
Route::post('/append/subcategory',[SubSubCategoryController::class, 'category']);

// Product
Route::resource('/products', ProductController::class)->except('show');
Route::post('/append/product/subcategory',[ProductController::class, 'category']);
Route::post('/append/product/subsubcategory',[ProductController::class, 'subcategory']);