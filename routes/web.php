<?php

use App\Models\aqar;
use Illuminate\Support\Facades\Route;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
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


//clear cache
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});




Route::get('send-email', function () {
   // Mail::to('recipient@example.com')->send(new TestEmail());
    Mail::to('figoashraf@gmail.com')->send(new \App\Mail\MaiableClass('name'));
    return 'Email sent successfully!';
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
Route::get('/config-clear-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
//Clear Config clear:
Route::get('/config-clear', function() {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});

/*   Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {


        return view('dashboard');
    })->name('dashboard');  */

     Route::get('/', function() {
    $locale = App::getLocale();
           // dd($locale);
    return redirect('/'.$locale);
        });


    Route::get('/dashboard', function() {
    $locale = App::getLocale();
           // dd($locale);
    return redirect('/'.$locale.'/dashboard');
        });


Route::group(['prefix' => '{locale?}'], function (){
         Route::group(['middleware' => 'CheackUser'], function () {
            Route::post('/redirectBack', 'App\Http\Controllers\PageController@redirectBack')->name('redirectBack');

            Route::get('/aqars/create', 'App\Http\Controllers\AqarController@create')->middleware(['setLocale']);
            Route::get('/dashboard', function() {

            return View('dashboard');
        })->middleware(['setLocale']);






    Route::get('/callfary_api_card', 'App\Http\Controllers\DeveloperfawryPayment@callfary_api_card')->name('callfary_api_card')->middleware('setLocale');



    Route::get('/pricing-seller', 'App\Http\Controllers\PricController@index')->name('priceSeller')->middleware('setLocale');
    Route::get('/pricing-seller/{single}', 'App\Http\Controllers\PricController@show')->name('priceSingle')->middleware('setLocale');
        Route::get('/user_ads', 'App\Http\Controllers\PageController@user_ads')->name('user_ads');
        Route::get('/user_wishs', 'App\Http\Controllers\PageController@user_wishs')->name('user_wishs')->middleware(['setLocale']);
        /*   Route::get('/add_company', 'App\Http\Controllers\CompanyController@create')->middleware('setLocale');
        Route::get('/user_companies', 'App\Http\Controllers\CompanyController@userComp')->middleware('setLocale');
        */
        Route::get('/update_companies/{company}', 'App\Http\Controllers\CompanyController@updateCompany')->middleware('setLocale');
        Route::get('/fawryCallback', 'App\Http\Controllers\PricController@fawryCallback')->middleware('setLocale');
        Route::get('/tmyezz_fawryCallback', 'App\Http\Controllers\PricController@tmyezz_fawryCallback')->middleware('setLocale');


      //  Route::post('/post_fawry_code_send', 'App\Http\Controllers\PricController@getNumber')->middleware('setLocale')->name('post_fawry_code_send');



      //  Route::post('/add-user-session', 'App\Http\Controllers\PageController@usersession')->name('add-user-session')->middleware('setLocale');
        Route::get('/notification', 'App\Http\Controllers\PageController@notification')->name('nots')->middleware(['setLocale']);
        Route::get('/user_point_count_history', 'App\Http\Controllers\PageController@user_point_count_history')->name('user_point_count_history')->middleware(['setLocale']);
        });

    Route::get('/login', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'create'])
            ->middleware(['guest:'.config('fortify.guard')])
            ->name('login')->middleware('setLocale');


                $limiter = config('fortify.limiters.login');

    Route::post('/login', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:'.config('fortify.guard'),
            $limiter ? 'throttle:'.$limiter : null,
        ]))->middleware('setLocale');



    Route::post('/customLoginManual', 'App\Http\Controllers\PageController@customLoginManual')->name('customLoginManual')->middleware('setLocale');
    Route::get('/register', 'App\Http\Controllers\PageController@register')->name('register')->middleware('setLocale');
    Route::get('/verify-your-phone', 'App\Http\Controllers\PageController@otbPage')->name('otbPage')->middleware('setLocale');
    Route::get('/reset-your-password', 'App\Http\Controllers\PageController@otbReset')->name('otbReset')->middleware('setLocale');

    Route::get('/donePhoneVerf','App\Http\Controllers\PageController@donePhoneVerf')->name('donePhoneVerf')->middleware('setLocale');

    Route::post('/custom_register', 'App\Http\Controllers\PageController@custom_register')->name('custom_register')->middleware('setLocale');


   Route::get('/', 'App\Http\Controllers\SiteHomeController@home')->name('homeBlade')->middleware(['setLocale']);
   Route::get('/aqars-{slug}', 'App\Http\Controllers\AqarController@mainAqar')->middleware('setLocale');
   Route::get('/all_aqar_for_sale', 'App\Http\Controllers\AqarController@all_aqar_for_sale')->middleware('setLocale');
   Route::get('/all_aqar_for_rent', 'App\Http\Controllers\AqarController@all_aqar_for_rent')->middleware('setLocale');



   Route::get('/aqar-finnance', 'App\Http\Controllers\AqarController@finnance')->name('aqar-finnance')->middleware('setLocale');
   Route::get('/aqars/update/{aqar}', 'App\Http\Controllers\AqarController@edit')->middleware('setLocale');

   Route::get('/aqars/{aqar}', 'App\Http\Controllers\AqarController@show')->middleware('setLocale')->middleware('setLocale');


 // Route::get('/pricing-vip/{aqarSingle}', 'App\Http\Controllers\PricController@vip')->middleware('setLocale');
 // Route::get('/tamyeez_vip/{vipid}/{aqarSingle_id}', 'App\Http\Controllers\PricController@tamyeez_vip')->middleware('setLocale');

   Route::get('/search', 'App\Http\Controllers\AqarController@search')->name('search')->middleware('setLocale');
   Route::get('/filter', 'App\Http\Controllers\AqarController@filter')->name('filter')->middleware('setLocale');
    Route::get('/sorted', 'App\Http\Controllers\AqarController@sorting')->name('sort')->middleware('setLocale');
   Route::get('/aqar-added', 'App\Http\Controllers\AqarController@submited')->name('thankyou')->middleware('setLocale');



    Route::get('/terms-conditions', 'App\Http\Controllers\PagesController@index')->middleware('setLocale');
    Route::get('/contact-us', 'App\Http\Controllers\PagesController@contact')->middleware('setLocale');
    Route::get('/about-us', 'App\Http\Controllers\PagesController@about')->middleware('setLocale');




    Route::get('/blogs', 'App\Http\Controllers\blogsController@index')->name('blogs')->middleware('setLocale');

    Route::get('/blogs/{slug}', 'App\Http\Controllers\blogsController@show')->name('blog')->middleware('setLocale');




    //Route::get('/user_wishs', 'App\Http\Controllers\PageController@user_wishs')->name('user_wishs')->middleware('setLocale');




        Route::get('/ourcompanies-{slug}', 'App\Http\Controllers\CompanyController@furn')->middleware('setLocale');
        Route::get('/companies/{compan}', 'App\Http\Controllers\CompanyController@show')->middleware('setLocale');
        Route::get('/ourcompanies-{slug}/filterby', 'App\Http\Controllers\CompanyController@sorting')->middleware('setLocale')->name('filterBy');

        Route::get('/add_company', 'App\Http\Controllers\CompanyController@create')->middleware('setLocale');



});
Route::post('/add_company_post', 'App\Http\Controllers\CompanyController@store')->name('add_company_post');
Route::post('/price-subscribed', 'App\Http\Controllers\PricController@store')->name('price-subscribed');
Route::post('/price-free-subscribed', 'App\Http\Controllers\PricController@storeFree')->name('price-free-subscribed');
        Route::post('/add-user-complain', 'App\Http\Controllers\AqarController@usercomplain')->name('add-user-complain');



//Route::post('/custom_register', 'App\Http\Controllers\PageController@custom_register')->name('custom_register');

// goo
Route::group(['middleware' => 'auth:sanctum' ], function ()
{
//Route::get('/add_company', 'App\Http\Controllers\CompanyController@create');
/*Route::post('/add_company_post', 'App\Http\Controllers\CompanyController@store')->name('add_company_post');*/



Route::post('/updated-aqar/{aqar}', 'App\Http\Controllers\AqarController@updatedAqar');

Route::get('/remove-image/{img}', 'App\Http\Controllers\AqarController@destroyImages');

//Route::get('/pricing-seller', 'App\Http\Controllers\PricController@index')->name('priceSeller');
//Route::get('/pricing-seller/{single}', 'App\Http\Controllers\PricController@show')->name('priceSingle');
Route::get('/aqar/{aqarid}/toVip', 'App\Http\Controllers\PricController@ChangeUpdated');




});
//Route::get('/register_user', 'App\Http\Controllers\Auth\RegisterController@index_main');

Route::post('/aqars', 'App\Http\Controllers\AqarController@store')->name('aqars.upload');
//Route::get('/aqars-cash', 'App\Http\Controllers\AqarController@cash');
//Route::get('/aqars-installment', 'App\Http\Controllers\AqarController@installment');
//Route::get('/aqars-rent-new', 'App\Http\Controllers\AqarController@rentNew');
//Route::get('/aqars-rent-finish', 'App\Http\Controllers\AqarController@rentFinish');

Route::get('/aqar-finnance', 'App\Http\Controllers\AqarController@finnance')->name('aqar-finnance');



Route::get('/aqars-{slug}', 'App\Http\Controllers\AqarController@mainAqar');

Route::post('/add-wish_list', 'App\Http\Controllers\AqarController@addwish_list')->name('add-wish_list');
Route::post('/remove-wish_list', 'App\Http\Controllers\AqarController@removewish_list')->name('remove-wish_list');

Route::post('/add-contactaqar', 'App\Http\Controllers\AqarController@addContact')->name('add-contactaqar');



Route::post('/ajx_main_img_edit_only', 'App\Http\Controllers\AqarController@ajx_main_img_edit_only')->name('ajx_main_img_edit_only');



//Route::get('/search', 'App\Http\Controllers\AqarController@index')->name('search');



//Route::get('/blogs', 'App\Http\Controllers\blogsController@index')->name('blogs');

//Route::get('/blogs/{slug}', 'App\Http\Controllers\blogsController@show')->name('blog');




//Route::get('/aqars/{aqar}', 'App\Http\Controllers\AqarController@show');
//Route::get('/terms-conditions', 'App\Http\Controllers\PagesController@index');
//Route::get('/contact-us', 'App\Http\Controllers\PagesController@contact');
Route::post('/contact-info', 'App\Http\Controllers\PagesController@store')->name('contact-info');
//Route::get('/about-us', 'App\Http\Controllers\PagesController@about');


// Route::get('/companies-furnitures', 'App\Http\Controllers\CompanyController@furn');
// Route::get('/companies-finish', 'App\Http\Controllers\CompanyController@finish');
// Route::get('/companies-home-sale', 'App\Http\Controllers\CompanyController@homeSale');
// Route::get('/companies-electronics', 'App\Http\Controllers\CompanyController@electronics');
Route::get('/ourcompanies-{slug}', 'App\Http\Controllers\CompanyController@furn');
Route::get('/companies/{compan}', 'App\Http\Controllers\CompanyController@show');
Route::get('/ourcompanies-{slug}/filterby', 'App\Http\Controllers\CompanyController@sorting');


//Route::get('/filter', 'App\Http\Controllers\AqarController@filter')->name('filter');
//Route::get('/sorted', 'App\Http\Controllers\AqarController@sorting')->name('sort');
//Route::get('/aqar-added', 'App\Http\Controllers\AqarController@submited')->name('thankyou');

Route::get('/add-to-vip/{aqar_id}/{user_id}', 'App\Http\Controllers\PricController@add_to_vip');

//Route::get('dashboard', 'App\Http\Controllers\UserController@profile')->middleware('auth');




Route::post('api/fetch-states', [App\Http\Controllers\DropdownController::class, 'fetchState']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/customLogin', 'App\Http\Controllers\HomeController@customLogin')->name('customLogin');




// goo
    Route::post('/phoneVerfication', 'App\Http\Controllers\PageController@verifyOtbPage')->name('verficationApply');

    Route::post('/phoneVerficationReset', 'App\Http\Controllers\PageController@verifyOtbReset')->name('verficationReset');

    Route::post('/phoneResetPassword','App\Http\Controllers\PageController@phoneResetPassword')->name('phoneResetPassword');



    Route::group(['middleware' => 'CheackUser'], function () {

        Route::post('/updated-company/{company}', 'App\Http\Controllers\CompanyController@updatedProfileCompany');
        Route::post('/remove-user-company', 'App\Http\Controllers\CompanyController@removeuserCompany')->name('remove-user-company');
        Route::post('/remove-user-Ads', 'App\Http\Controllers\AqarController@removeuserAds')->name('remove-user-Ads');
       // Route::post('/add-user-complain', 'App\Http\Controllers\AqarController@usercomplain')->name('add-user-complain');
        Route::post('/change-user-notfi', 'App\Http\Controllers\PageController@ChangeStatus')->name('change-user-notfi');
        });
        Route::post('/updatedProfileUser', 'App\Http\Controllers\UpdateProfileUserController@UpdateProfileUser');
        Route::post('/add-user-session', 'App\Http\Controllers\PageController@usersession')->name('add-user-session');

        Route::post('/resend-otb', 'App\Http\Controllers\PageController@resendOTB')->name('resendOTB');

