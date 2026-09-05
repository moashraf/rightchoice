<?php

use App\Http\Controllers\AdminPrivacyPolicySectionController;
use App\Http\Controllers\PrivacyPolicyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Legal Routes
|--------------------------------------------------------------------------
| Public legal pages and their admin content management routes.
*/

Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware('setLocale')
    ->group(function () {
        Route::get('/privacy-policy', [PrivacyPolicyController::class, 'index'])
            ->name('privacy-policy');
    });

Route::prefix('sitemanagement')
    ->name('sitemanagement.')
    ->middleware(['admin-web', 'adminfCheckAdmin'])
    ->group(function () {
        Route::get('/privacy-policy-sections', [AdminPrivacyPolicySectionController::class, 'index'])
            ->name('privacy-policy-sections.index');

        Route::get('/privacy-policy-sections/{privacyPolicySection}/edit', [AdminPrivacyPolicySectionController::class, 'edit'])
            ->name('privacy-policy-sections.edit');

        Route::put('/privacy-policy-sections/{privacyPolicySection}', [AdminPrivacyPolicySectionController::class, 'update'])
            ->name('privacy-policy-sections.update');
    });
