<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AqarController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'App\Http\Controllers\SiteHomeController@home')->name('homeBlade');


Route::get('/changeLang/{url}','App\Http\Controllers\PageController@changeLang')->name('changeLang');


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Re optimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Re optimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware(['auth'])->group(function () {

Route::get('generator_builder', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@builder')->name('io_generator_builder');

Route::get('field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@fieldTemplate')->name('io_field_template');

Route::get('relation_field_template', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@relationFieldTemplate')->name('io_relation_field_template');

Route::post('generator_builder/generate', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generate')->name('io_generator_builder_generate');

Route::post('generator_builder/rollback', '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@rollback')->name('io_generator_builder_rollback');

Route::post(
    'generator_builder/generate-from-file',
    '\InfyOm\GeneratorBuilder\Controllers\GeneratorBuilderController@generateFromFile'
)->name('io_generator_builder_generate_from_file');

Route::resource('blogs', App\Http\Controllers\blogController::class);

Route::resource('offerTypes', App\Http\Controllers\offer_typeController::class);

Route::resource('propertyTypes', App\Http\Controllers\property_typeController::class);

Route::resource('aqarCategories', App\Http\Controllers\aqar_categoryController::class);

Route::resource('callTimes', App\Http\Controllers\call_timeController::class);

Route::resource('compounds', App\Http\Controllers\compoundController::class);

Route::resource('governrates', App\Http\Controllers\governrateController::class);

Route::resource('districts', App\Http\Controllers\districtController::class);

Route::resource('districtTests', App\Http\Controllers\district_testController::class);

Route::resource('finishTypes', App\Http\Controllers\finish_typeController::class);

Route::resource('floors', App\Http\Controllers\floorController::class);

Route::resource('licenseTypes', App\Http\Controllers\license_typeController::class);

Route::resource('subareas', App\Http\Controllers\subareaController::class);

Route::resource('services', App\Http\Controllers\servicesController::class);

Route::resource('priceingSales', App\Http\Controllers\priceing_saleController::class);

Route::resource('mzayas', App\Http\Controllers\mzayaController::class);

Route::resource('pages', App\Http\Controllers\PagesController::class);

Route::resource('aqars', AqarController::class);

Route::post('aqar-refund-points/{viewer}', [AqarController::class, 'refund_points'])->name('admin.refund_points');

Route::get('aqars/show', [AqarController::class, 'destroy']);



Route::GET('/RemoveImageAqar/{Images}',[AqarController::class, 'RemoveImgAqar']);

Route::POST('/ajax-getpropertyByCat',[AqarController::class, 'getpropertyByCat']);

Route::POST('/ajax-getdistrictByGovernrate',[AqarController::class, 'getdistrictByGovernrate']);

Route::POST('/ajax-getPhoneUser',[AqarController::class, 'getPhoneUser']);

Route::resource('images', App\Http\Controllers\ImagesController::class);

Route::resource('aqarMzayas', App\Http\Controllers\aqar_mzayaController::class);

Route::resource('companies', App\Http\Controllers\CompanyController::class);

Route::resource('priceVips', App\Http\Controllers\PriceVipController::class);

Route::resource('requestPhotoSessions', App\Http\Controllers\RequestPhotoSessionController::class);

Route::resource('sliders', App\Http\Controllers\SliderController::class);

Route::resource('userContactAqars', App\Http\Controllers\UserContactAqarController::class);

Route::resource('userPriceings', App\Http\Controllers\UserPriceingController::class);

Route::resource('wishes', App\Http\Controllers\wishController::class);

Route::resource('complaints', App\Http\Controllers\ComplaintsController::class);

Route::get('complaints/user/{user}', 'App\Http\Controllers\ComplaintsController@show_user')->name('complaintsUser');


Route::resource('contactForms', App\Http\Controllers\ContactFormController::class);

Route::resource('notifications', App\Http\Controllers\NotificationController::class);

Route::resource('settingSites', App\Http\Controllers\SettingSiteController::class);


Route::resource('advertising', App\Http\Controllers\adController::class);

// Route::resource('user', App\Http\Controllers\UserController::class);

/********************  Users ***************************/
Route::get('user/dataTable', 'App\Http\Controllers\UserController@dataTable');
Route::get('users/{user}/block', 'App\Http\Controllers\UserController@block');
Route::get('users/{user}/activate', 'App\Http\Controllers\UserController@activate');
Route::get('users/{user}/delete', 'App\Http\Controllers\UserController@destroy');
Route::get('user/{id}/show', 'App\Http\Controllers\UserController@show');
Route::get('user/{id}/aqars', 'App\Http\Controllers\UserController@aqars')->name('user.aqars');



Route::resource('user', 'App\Http\Controllers\UserController');
// Route::get('user/show/{id}', 'App\Http\Controllers\UserController@show')->name('show_userpage');

});
