<?php

use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// OAuth Routes for Social Platforms
Route::middleware(['web', 'auth'])->prefix('auth')->group(function () {
    Route::get('{platform}/redirect', [SocialAuthController::class, 'redirect'])
        ->name('social.redirect');

    Route::get('{platform}/callback', [SocialAuthController::class, 'callback'])
        ->name('social.callback');

    Route::post('disconnect/{account}', [SocialAuthController::class, 'disconnect'])
        ->name('social.disconnect');
});
