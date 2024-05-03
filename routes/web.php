<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HandbooksController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/categories', [CategoriesController::class, 'index'])
    ->name('categories.index');
Route::get('/categories/{slug}', [CategoriesController::class, 'show'])
    ->name('categories.show');
Route::get('/categories/price/{slug}', [CategoriesController::class, 'sortByPrice'])
    ->name('categories.price');
Route::get('/categories/distance/{slug}', [CategoriesController::class, 'sortByDistance'])
    ->name('categories.distance');
Route::get('/categories/rating/{slug}', [CategoriesController::class, 'sortByRating'])
    ->name('categories.rating');


Route::get('/handbooks', [HandbooksController::class, 'index'])
    ->name('handbooks.index');
Route::get('/handbooks/{id}', [HandbooksController::class, 'show'])
    ->name('handbooks.show');
Route::post('/reviews', [ReviewController::class, 'store'])
    ->name('reviews.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])
    ->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])
    ->name('logout');

//Password reset routes
Route::middleware('guest:users')->group(function () {
    Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])
        ->name('forget.password.form');
    Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])
        ->name('forget.password');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])
        ->name('reset.password.form');
    Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])
        ->name('reset.password');
});

// Account Confirmation Routes
Route::get('/confirm/{token}', [AuthController::class, 'confirm'])
    ->name('confirm');
Route::get('/need-confirm', [AuthController::class, 'showConfirmForm'])
    ->name('confirm.form');

// Authenticated User Routes
Route::middleware('auth:users')->group(function () {
    Route::get('/profile', [PersonalController::class, 'profile'])
        ->name('profile');
    Route::put('/profile', [PersonalController::class, 'updateProfile'])
        ->name('profile.update');
    Route::post('/profile/change-password', [PersonalController::class, 'updatePassword'])
        ->name('password.update');

    Route::prefix('/profile/handbooks')->name('profile.handbooks.')->group(function () {
        Route::get('create', [PersonalController::class, 'createHandbookForm'])
            ->name('create');
        Route::post('create', [HandbooksController::class, 'store'])
            ->name('store');
        Route::get('update/{handbook}', [PersonalController::class, 'updateHandbookForm'])
            ->name('show');
        Route::post('update/{handbook}', [PersonalController::class, 'updateHandbook'])
            ->name('update');
    });
});

//Search Routes
Route::post('/search', [SearchController::class, 'searchAutocomplete'])->name('search.autocomplete');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/all-services', [SearchController::class, 'allServices'])
->name('all-services');

Route::get('/policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
Route::get('/site-map', [SiteMapController::class, 'show'])->name('site-map.show');


//Mobile API routes
Route::prefix('api')->group(function () {
    Route::get('/categories', [CategoriesController::class, 'apiList'])->name('api.categories.index');
    Route::get('/categories/{slug}', [CategoriesController::class, 'apiShow'])->name('api.categories.show');

    Route::get('/handbooks', [HandbooksController::class, 'apiList'])->name('api.handbooks.index');
    Route::get('/handbooks/{slug}', [HandbooksController::class, 'apiShow'])->name('api.handbooks.show');
});

Route::get('/set-city/{city}', [CityController::class, 'setCity'])->name('set-city');
Route::post('/set-region/{region}', [CityController::class, 'setRegion'])->name('set-region');
Route::post('/back-to-region', [CityController::class, 'backToRegion'])->name('back-to-region');
Route::get('/geolocate-city', [CityController::class, 'geolocateExample']);