<?php

use App\Http\Controllers\AdminPrizeDrawController;
use App\Http\Controllers\SellFasterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Promotional Routes
|--------------------------------------------------------------------------
| Kept separate from web.php so promotional features stay easy to maintain.
| These routes are loaded by RouteServiceProvider with the web middleware.
*/

Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware('setLocale')
    ->group(function () {
        Route::get('/sell-faster', [SellFasterController::class, 'index'])
            ->name('sell-faster.index');

        Route::post('/sell-faster/subscribe/{pricing}', [SellFasterController::class, 'subscribe'])
            ->middleware('CheackUser')
            ->whereNumber('pricing')
            ->name('sell-faster.subscribe');
    });

Route::prefix('sitemanagement')
    ->name('sitemanagement.')
    ->middleware(['admin-web', 'adminfCheckAdmin', 'role:admin'])
    ->group(function () {
        Route::get('/prize-draw', [AdminPrizeDrawController::class, 'index'])
            ->name('prize-draw.index');

        Route::post('/prize-draw/draw', [AdminPrizeDrawController::class, 'draw'])
            ->name('prize-draw.draw');
    });
