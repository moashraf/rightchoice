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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('blogs', App\Http\Controllers\API\blogAPIController::class);

Route::resource('offer_types', App\Http\Controllers\API\offer_typeAPIController::class);

Route::resource('property_types', App\Http\Controllers\API\property_typeAPIController::class);

Route::resource('aqar_categories', App\Http\Controllers\API\aqar_categoryAPIController::class);

Route::resource('call_times', App\Http\Controllers\API\call_timeAPIController::class);

Route::resource('compounds', App\Http\Controllers\API\compoundAPIController::class);

Route::resource('governrates', App\Http\Controllers\API\governrateAPIController::class);

Route::resource('districts', App\Http\Controllers\API\districtAPIController::class);

Route::resource('district_tests', App\Http\Controllers\API\district_testAPIController::class);

Route::resource('finish_types', App\Http\Controllers\API\finish_typeAPIController::class);

Route::resource('floors', App\Http\Controllers\API\floorAPIController::class);

Route::resource('license_types', App\Http\Controllers\API\license_typeAPIController::class);

Route::resource('subareas', App\Http\Controllers\API\subareaAPIController::class);

Route::resource('services', App\Http\Controllers\API\servicesAPIController::class);

Route::resource('priceing_sales', App\Http\Controllers\API\priceing_saleAPIController::class);

Route::resource('mzayas', App\Http\Controllers\API\mzayaAPIController::class);

Route::resource('pages', App\Http\Controllers\API\PagesAPIController::class);

Route::resource('aqars', App\Http\Controllers\API\aqarAPIController::class);

Route::resource('images', App\Http\Controllers\API\ImagesAPIController::class);

Route::resource('aqar_mzayas', App\Http\Controllers\API\aqar_mzayaAPIController::class);

Route::resource('companies', App\Http\Controllers\API\CompanyAPIController::class);

Route::resource('price_vips', App\Http\Controllers\API\PriceVipAPIController::class);

Route::resource('request_photo_sessions', App\Http\Controllers\API\RequestPhotoSessionAPIController::class);

Route::resource('sliders', App\Http\Controllers\API\SliderAPIController::class);

Route::resource('user_contact_aqars', App\Http\Controllers\API\UserContactAqarAPIController::class);

Route::resource('user_priceings', App\Http\Controllers\API\UserPriceingAPIController::class);

Route::resource('wishes', App\Http\Controllers\API\wishAPIController::class);

Route::resource('complaints', App\Http\Controllers\API\ComplaintsAPIController::class);

Route::resource('contact_forms', App\Http\Controllers\API\ContactFormAPIController::class);

Route::resource('notifications', App\Http\Controllers\API\NotificationAPIController::class);

Route::resource('setting_sites', App\Http\Controllers\API\SettingSiteAPIController::class);