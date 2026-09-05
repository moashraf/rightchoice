<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legal Routes
|--------------------------------------------------------------------------
| Public legal pages kept separate from the main web routes so they remain
| easy to review and update without mixing them with application features.
*/

Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware('setLocale')
    ->group(function () {
        Route::view('/privacy-policy', 'privacy-policy')
            ->name('privacy-policy');
    });
