<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Static Pages
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/pricing', fn () => view('pages.pricing'))->name('pricing');
Route::get('/faq', fn () => view('pages.faq'))->name('faq');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');
Route::get('/terms', fn () => view('pages.terms'))->name('terms');
Route::get('/privacy', fn () => view('pages.privacy'))->name('privacy');

// Custom Auth Routes (Premium Design)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// OAuth Routes for Social Platforms
Route::middleware(['web', 'auth'])->prefix('auth')->group(function () {
    Route::get('{platform}/redirect', [SocialAuthController::class, 'redirect'])
        ->name('social.redirect');

    Route::get('{platform}/callback', [SocialAuthController::class, 'callback'])
        ->name('social.callback');

    Route::post('disconnect/{account}', [SocialAuthController::class, 'disconnect'])
        ->name('social.disconnect');
});


