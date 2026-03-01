<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Authentication routes
Route::post('login',  [App\Http\Controllers\API\AuthAPIController::class, 'login']);
Route::post('logout', [App\Http\Controllers\API\AuthAPIController::class, 'logout']);

// Resource routes
Route::apiResource('blogs',                    App\Http\Controllers\API\blogAPIController::class);
Route::apiResource('offer_types',              App\Http\Controllers\API\offer_typeAPIController::class);
Route::apiResource('property_types',           App\Http\Controllers\API\property_typeAPIController::class);
Route::apiResource('aqar_categories',          App\Http\Controllers\API\aqar_categoryAPIController::class);
Route::apiResource('call_times',               App\Http\Controllers\API\call_timeAPIController::class);
Route::apiResource('compounds',                App\Http\Controllers\API\compoundAPIController::class);
Route::apiResource('governrates',              App\Http\Controllers\API\governrateAPIController::class);
Route::apiResource('districts',                App\Http\Controllers\API\districtAPIController::class);
Route::apiResource('district_tests',           App\Http\Controllers\API\district_testAPIController::class);
Route::apiResource('finish_types',             App\Http\Controllers\API\finish_typeAPIController::class);
Route::apiResource('floors',                   App\Http\Controllers\API\floorAPIController::class);
Route::apiResource('license_types',            App\Http\Controllers\API\license_typeAPIController::class);
Route::apiResource('subareas',                 App\Http\Controllers\API\subareaAPIController::class);
Route::apiResource('services',                 App\Http\Controllers\API\servicesAPIController::class);
Route::apiResource('priceing_sales',           App\Http\Controllers\API\priceing_saleAPIController::class);
Route::apiResource('mzayas',                   App\Http\Controllers\API\mzayaAPIController::class);
Route::apiResource('pages',                    App\Http\Controllers\API\PagesAPIController::class);
Route::apiResource('aqars',                    App\Http\Controllers\API\aqarAPIController::class);
Route::apiResource('images',                   App\Http\Controllers\API\ImagesAPIController::class);
Route::apiResource('aqar_mzayas',              App\Http\Controllers\API\aqar_mzayaAPIController::class);
Route::apiResource('companies',                App\Http\Controllers\API\CompanyAPIController::class);
Route::apiResource('price_vips',               App\Http\Controllers\API\PriceVipAPIController::class);
Route::apiResource('request_photo_sessions',   App\Http\Controllers\API\RequestPhotoSessionAPIController::class);
Route::apiResource('sliders',                  App\Http\Controllers\API\SliderAPIController::class);
Route::apiResource('user_contact_aqars',       App\Http\Controllers\API\UserContactAqarAPIController::class);
Route::apiResource('user_priceings',           App\Http\Controllers\API\UserPriceingAPIController::class);
Route::apiResource('wishes',                   App\Http\Controllers\API\wishAPIController::class);
Route::apiResource('complaints',               App\Http\Controllers\API\ComplaintsAPIController::class);
Route::apiResource('contact_forms',            App\Http\Controllers\API\ContactFormAPIController::class);
Route::apiResource('notifications',            App\Http\Controllers\API\NotificationAPIController::class);
Route::apiResource('setting_sites',            App\Http\Controllers\API\SettingSiteAPIController::class);

