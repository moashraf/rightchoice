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

Route::get('/', 'App\Http\Controllers\SiteHomeController@home');
Route::get('/changeLang/{url}', 'App\Http\Controllers\PageController@changeLang')->name('changeLang');


Route::get('send-email', function () {
    // Mail::to('recipient@example.com')->send(new TestEmail());
    Mail::to('figoashraf@gmail.com')->send(new \App\Mail\MaiableClass('name'));
    return 'Email sent successfully!';
});


//Re optimized class loader:
Route::get('/optimize', function () {
    $exitCode = Artisan::call('optimize');
    return '<h1>Re optimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function () {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-clear-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
//Clear Config clear:
Route::get('/config-clear', function () {
    $exitCode = Artisan::call('config:clear');
    return '<h1>Clear Config cleared</h1>';
});
//clear cache
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});


/*
|--------------------------------------------------------------------------
| Admin Auth Routes (login / logout)
|--------------------------------------------------------------------------
*/
Route::middleware('admin-web')->group(function () {
    Route::get('/sitemanagement/login', [App\Http\Controllers\AdminfLoginController::class, 'adminfShowLoginForm'])->name('sitemanagement.login');
    Route::post('/sitemanagement/login', [App\Http\Controllers\AdminfLoginController::class, 'adminfLogin'])->name('sitemanagement.login.submit');
    Route::post('/sitemanagement/logout', [App\Http\Controllers\AdminfLoginController::class, 'adminfLogout'])->name('sitemanagement.logout');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
| All routes here require admin-web middleware + adminfCheckAdmin (role gate).
| Individual routes are further restricted with fine-grained `permission`
| middleware. The viewer role can access *.view permissions only; user role
| has no admin panel access; admin role has access to everything.
|--------------------------------------------------------------------------
*/
Route::prefix('sitemanagement')->name('sitemanagement.')->middleware(['admin-web', 'adminfCheckAdmin'])->group(function () {

    // ── Blogs ────────────────────────────────────────────────────────────
    Route::resource('blogs', App\Http\Controllers\AdminBlogController::class)
        ->middleware('permission:blogs.create')->only(['create', 'store']);
    Route::resource('blogs', App\Http\Controllers\AdminBlogController::class)
        ->middleware('permission:blogs.view')->only(['index', 'show']);
    Route::resource('blogs', App\Http\Controllers\AdminBlogController::class)
        ->middleware('permission:blogs.update')->only(['edit', 'update']);
    Route::resource('blogs', App\Http\Controllers\AdminBlogController::class)
        ->middleware('permission:blogs.delete')->only(['destroy']);

    Route::resource('sliders', App\Http\Controllers\AdminSliderController::class)
        ->middleware('permission:sliders.create')->only(['create', 'store']);
    Route::resource('sliders', App\Http\Controllers\AdminSliderController::class)
        ->middleware('permission:sliders.view')->only(['index', 'show']);
    Route::resource('sliders', App\Http\Controllers\AdminSliderController::class)
        ->middleware('permission:sliders.update')->only(['edit', 'update']);
    Route::resource('sliders', App\Http\Controllers\AdminSliderController::class)
        ->middleware('permission:sliders.delete')->only(['destroy']);

    // ── Ads (اعلانات خارجية) ─────────────────────────────────────────
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.create')->only(['create', 'store']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.view')->only(['index', 'show']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.update')->only(['edit', 'update']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.delete')->only(['destroy']);

    // ── Settings ─────────────────────────────────────────────────────────
    Route::resource('settingSites', App\Http\Controllers\AdminSettingSiteController::class)
        ->middleware('permission:settings.manage');

    Route::resource('requestPhotoSessions', App\Http\Controllers\AdminRequestPhotoSessionController::class);
    Route::resource('priceVips', App\Http\Controllers\AdminPriceVipController::class)
        ->middleware('permission:pricing.manage');
    Route::resource('pages', App\Http\Controllers\AdminPagesController::class);

    // ── Companies ────────────────────────────────────────────────────────
    Route::resource('companies', App\Http\Controllers\AdminCompanyController::class)
        ->middleware('permission:companies.create')->only(['create', 'store']);
    Route::resource('companies', App\Http\Controllers\AdminCompanyController::class)
        ->middleware('permission:companies.view')->only(['index', 'show']);
    Route::resource('companies', App\Http\Controllers\AdminCompanyController::class)
        ->middleware('permission:companies.update')->only(['edit', 'update']);
    Route::resource('companies', App\Http\Controllers\AdminCompanyController::class)
        ->middleware('permission:companies.delete')->only(['destroy']);

    Route::resource('mzayas', App\Http\Controllers\AdminMzayaController::class);
    Route::resource('priceingSales', App\Http\Controllers\AdminPriceingSaleController::class)
        ->middleware('permission:pricing.manage');
    Route::resource('adminServices', App\Http\Controllers\AdminServicesController::class)
        ->middleware('permission:settings.manage');

    // ── Location Data ────────────────────────────────────────────────────
    Route::resource('subareas', App\Http\Controllers\AdminSubareaController::class)
        ->middleware('permission:locations.manage');
    Route::resource('licenseTypes', App\Http\Controllers\AdminLicenseTypeController::class)
        ->middleware('permission:locations.manage');
    Route::resource('floors', App\Http\Controllers\AdminFloorController::class)
        ->middleware('permission:locations.manage');
    Route::resource('finishTypes', App\Http\Controllers\AdminFinishTypeController::class)
        ->middleware('permission:locations.manage');
    Route::resource('districts', App\Http\Controllers\AdminDistrictController::class)
        ->middleware('permission:locations.manage');
    Route::resource('governrates', App\Http\Controllers\AdminGovernrateController::class)
        ->middleware('permission:locations.manage');
    Route::resource('compounds', App\Http\Controllers\AdminCompoundController::class)
        ->middleware('permission:locations.view');
    Route::resource('callTimes', App\Http\Controllers\AdminCallTimeController::class)
        ->middleware('permission:settings.manage');
    Route::resource('aqarCategories', App\Http\Controllers\AdminAqarCategoryController::class)
        ->middleware('permission:locations.manage');
    Route::resource('offerTypes', App\Http\Controllers\AdminOfferTypeController::class)
        ->middleware('permission:settings.manage');

    // ── Notifications ────────────────────────────────────────────────────
    Route::resource('notifications', App\Http\Controllers\AdminNotificationController::class)
        ->middleware('permission:notifications.manage')->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('notifications', App\Http\Controllers\AdminNotificationController::class)
        ->middleware('permission:notifications.view')->only(['index', 'show']);

    // ── Contact Forms ────────────────────────────────────────────────────
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.view')->only(['create', 'store', 'edit', 'update']);
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.view')->only(['index', 'show']);
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.delete')->only(['destroy']);

    Route::resource('propertyTypes', App\Http\Controllers\AdminPropertyTypeController::class)
        ->middleware('permission:settings.manage');

    // ── Complaints ───────────────────────────────────────────────────────
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.update')->only(['edit', 'update']);
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.view')->only(['index', 'show']);
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.delete')->only(['destroy']);

    // ── Real Estate (Aqars) ──────────────────────────────────────────────
    Route::get('aqars/deleted', [App\Http\Controllers\AdminAqarController::class, 'deletedAqars'])->name('aqars.deleted')
        ->middleware('permission:aqars.delete');
    Route::post('aqars/{id}/restore', [App\Http\Controllers\AdminAqarController::class, 'restoreAqar'])->name('aqars.restore')
        ->middleware('permission:aqars.delete');
    Route::delete('aqars/{id}/force-delete', [App\Http\Controllers\AdminAqarController::class, 'forceDeleteAqar'])->name('aqars.forceDelete')
        ->middleware('permission:aqars.delete');
    Route::resource('aqars', App\Http\Controllers\AdminAqarController::class)
        ->middleware('permission:aqars.create')->only(['create', 'store']);
    Route::resource('aqars', App\Http\Controllers\AdminAqarController::class)
        ->middleware('permission:aqars.view')->only(['index', 'show']);
    Route::resource('aqars', App\Http\Controllers\AdminAqarController::class)
        ->middleware('permission:aqars.update')->only(['edit', 'update']);
    Route::resource('aqars', App\Http\Controllers\AdminAqarController::class)
        ->middleware('permission:aqars.delete')->only(['destroy']);
    Route::post('ajax-getpropertyByCat', [App\Http\Controllers\AdminAqarController::class, 'getPropertyByCat'])->name('aqars.getPropertyByCat');
    Route::post('ajax-getdistrictByGovernrate', [App\Http\Controllers\AdminAqarController::class, 'getDistrictByGovernrate'])->name('aqars.getDistrictByGovernrate');
    Route::post('ajax-getPhoneUser', [App\Http\Controllers\AdminAqarController::class, 'getPhoneUser'])->name('aqars.getPhoneUser');
    Route::get('RemoveImageAqar/{Images}', [App\Http\Controllers\AdminAqarController::class, 'removeImage'])->name('aqars.removeImage')
        ->middleware('permission:aqars.update');
    Route::post('refund-points/{viewer}', [App\Http\Controllers\AdminAqarController::class, 'refundPoints'])->name('aqars.refundPoints')
        ->middleware('permission:aqars.refund');

    // ── Users ────────────────────────────────────────────────────────────
    Route::get('users/deleted', [App\Http\Controllers\AdminUserController::class, 'deletedUsers'])->name('users.deleted')
        ->middleware('permission:users.delete');
    Route::post('users/{id}/restore', [App\Http\Controllers\AdminUserController::class, 'restoreUser'])->name('users.restore')
        ->middleware('permission:users.delete');
    Route::delete('users/{id}/force-delete', [App\Http\Controllers\AdminUserController::class, 'forceDeleteUser'])->name('users.forceDelete')
        ->middleware('permission:users.delete');
    Route::resource('users', App\Http\Controllers\AdminUserController::class)
        ->middleware('permission:users.create')->only(['create', 'store']);
    Route::resource('users', App\Http\Controllers\AdminUserController::class)
        ->middleware('permission:users.view')->only(['index', 'show']);
    Route::resource('users', App\Http\Controllers\AdminUserController::class)
        ->middleware('permission:users.update')->only(['edit', 'update']);
    Route::resource('users', App\Http\Controllers\AdminUserController::class)
        ->middleware('permission:users.delete')->only(['destroy']);
    Route::get('users/{user}/block', [App\Http\Controllers\AdminUserController::class, 'block'])->name('users.block')
        ->middleware('permission:users.block');
    Route::get('users/{user}/activate', [App\Http\Controllers\AdminUserController::class, 'activate'])->name('users.activate')
        ->middleware('permission:users.block');
    Route::get('users/{user}/delete', [App\Http\Controllers\AdminUserController::class, 'destroy'])->name('users.delete')
        ->middleware('permission:users.delete');
    Route::get('users/{user}/aqars', [App\Http\Controllers\AdminUserController::class, 'aqars'])->name('users.aqars')
        ->middleware('permission:users.view');
    Route::get('users/{user}/contact-forms', [App\Http\Controllers\AdminUserController::class, 'contactForms'])->name('users.contactForms')
        ->middleware('permission:users.view');
    Route::get('users/{user}/packages', [App\Http\Controllers\AdminUserController::class, 'packages'])->name('users.packages')
        ->middleware('permission:users.view');
    Route::get('users-export', [App\Http\Controllers\AdminUserController::class, 'exportUsers'])->name('users.exportUsers')
        ->middleware('permission:users.export');
    Route::post('users/{user}/add-points', [App\Http\Controllers\AdminUserController::class, 'addPoints'])->name('users.addPoints')
        ->middleware('permission:users.update');
    Route::get('users/{user}/get-points', [App\Http\Controllers\AdminUserController::class, 'getPoints'])->name('users.getPoints')
        ->middleware('permission:users.update');

    // ── Reports ──────────────────────────────────────────────────────────
    Route::get('reports', [App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index')
        ->middleware('permission:reports.view');
    Route::get('reports/invited-by-details', [App\Http\Controllers\AdminReportController::class, 'invitedByDetails'])->name('reports.invitedByDetails')
        ->middleware('permission:reports.view');

    // ── Account Delete Requests ──────────────────────────────────────────
    Route::get('accountDeleteRequests', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'index'])->name('accountDeleteRequests.index')
        ->middleware('permission:users.view');
    Route::post('accountDeleteRequests/{id}/approve', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'approve'])->name('accountDeleteRequests.approve')
        ->middleware('permission:users.delete');
    Route::post('accountDeleteRequests/{id}/reject', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'reject'])->name('accountDeleteRequests.reject')
        ->middleware('permission:users.delete');
    Route::post('accountDeleteRequests/{id}/restore', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'restore'])->name('accountDeleteRequests.restore')
        ->middleware('permission:users.delete');

    // ── Error Logs ─────────────────────────────────────────────────────
    Route::post('errorLogs/clear', [App\Http\Controllers\AdminErrorLogController::class, 'clearAll'])
        ->name('errorLogs.clearAll')
        ->middleware('role:admin');
    Route::resource('errorLogs', App\Http\Controllers\AdminErrorLogController::class)
        ->middleware('role:admin')->only(['index', 'show', 'destroy']);

    // ── Activity Logs ──────────────────────────────────────────────────
    Route::post('activityLogs/clear', [App\Http\Controllers\AdminActivityLogController::class, 'clearAll'])
        ->name('activityLogs.clearAll')
        ->middleware('role:admin');
    Route::resource('activityLogs', App\Http\Controllers\AdminActivityLogController::class)
        ->middleware('role:admin')->only(['index', 'show', 'destroy']);

    // ── Online Users ───────────────────────────────────────────────────
    Route::get('onlineUsers', [App\Http\Controllers\AdminOnlineUsersController::class, 'index'])
        ->name('onlineUsers.index')
        ->middleware('role:admin');
    Route::get('onlineUsers/{userId}', [App\Http\Controllers\AdminOnlineUsersController::class, 'show'])
        ->name('onlineUsers.show')
        ->middleware('role:admin');

    // ── SMS Messaging ────────────────────────────────────────────────────
    Route::get('sms', [App\Http\Controllers\AdminSmsController::class, 'index'])
        ->name('sms.index')
        ->middleware('permission:sms.view');
    Route::get('sms/create', [App\Http\Controllers\AdminSmsController::class, 'create'])
        ->name('sms.create')
        ->middleware('permission:sms.send');
    Route::post('sms', [App\Http\Controllers\AdminSmsController::class, 'store'])
        ->name('sms.store')
        ->middleware('permission:sms.send');
    Route::get('sms/{id}', [App\Http\Controllers\AdminSmsController::class, 'show'])
        ->name('sms.show')
        ->middleware('permission:sms.view');
    Route::post('sms/{id}/retry', [App\Http\Controllers\AdminSmsController::class, 'retryFailed'])
        ->name('sms.retry')
        ->middleware('permission:sms.send');
    // AJAX endpoints for SMS user selection
    Route::get('sms-search-users', [App\Http\Controllers\AdminSmsController::class, 'searchUsers'])
        ->name('sms.searchUsers')
        ->middleware('permission:sms.send');
    Route::post('sms-preview-recipients', [App\Http\Controllers\AdminSmsController::class, 'previewRecipients'])
        ->name('sms.previewRecipients')
        ->middleware('permission:sms.send');

    // ── WhatsApp Messaging ───────────────────────────────────────────────
    Route::get('whatsapp', [App\Http\Controllers\AdminWhatsappController::class, 'index'])
        ->name('whatsapp.index')
        ->middleware('permission:whatsapp.view');
    Route::get('whatsapp/create', [App\Http\Controllers\AdminWhatsappController::class, 'create'])
        ->name('whatsapp.create')
        ->middleware('permission:whatsapp.send');
    Route::post('whatsapp', [App\Http\Controllers\AdminWhatsappController::class, 'store'])
        ->name('whatsapp.store')
        ->middleware('permission:whatsapp.send');
    Route::get('whatsapp/{id}', [App\Http\Controllers\AdminWhatsappController::class, 'show'])
        ->name('whatsapp.show')
        ->middleware('permission:whatsapp.view');
    Route::post('whatsapp/{id}/retry', [App\Http\Controllers\AdminWhatsappController::class, 'retryFailed'])
        ->name('whatsapp.retry')
        ->middleware('permission:whatsapp.send');
    // AJAX endpoints for WhatsApp user selection
    Route::get('whatsapp-search-users', [App\Http\Controllers\AdminWhatsappController::class, 'searchUsers'])
        ->name('whatsapp.searchUsers')
        ->middleware('permission:whatsapp.send');
    Route::post('whatsapp-preview-recipients', [App\Http\Controllers\AdminWhatsappController::class, 'previewRecipients'])
        ->name('whatsapp.previewRecipients')
        ->middleware('permission:whatsapp.send');

    // ── Payment Management ────────────────────────────────────────────────
    Route::get('payments', [App\Http\Controllers\AdminPaymentController::class, 'index'])
        ->name('payments.index')
        ->middleware('permission:payments.view');
    Route::get('payments/reports', [App\Http\Controllers\AdminPaymentController::class, 'reports'])
        ->name('payments.reports')
        ->middleware('permission:payments.reports');
    Route::get('payments/refunds', [App\Http\Controllers\AdminPaymentController::class, 'refunds'])
        ->name('payments.refunds')
        ->middleware('permission:payments.refunds');
    Route::get('payments/user/{userId}', [App\Http\Controllers\AdminPaymentController::class, 'userPayments'])
        ->name('payments.userPayments')
        ->middleware('permission:payments.view');
    Route::get('payments/{id}', [App\Http\Controllers\AdminPaymentController::class, 'show'])
        ->name('payments.show')
        ->middleware('permission:payments.view');
    Route::post('payments/{id}/status', [App\Http\Controllers\AdminPaymentController::class, 'updateStatus'])
        ->name('payments.updateStatus')
        ->middleware('permission:payments.manage');
    Route::post('payments/{id}/note', [App\Http\Controllers\AdminPaymentController::class, 'addNote'])
        ->name('payments.addNote')
        ->middleware('permission:payments.manage');
    Route::post('payments/{id}/refund', [App\Http\Controllers\AdminPaymentController::class, 'initiateRefund'])
        ->name('payments.initiateRefund')
        ->middleware('permission:payments.refunds');
    Route::post('refunds/{refundId}/approve', [App\Http\Controllers\AdminPaymentController::class, 'approveRefund'])
        ->name('refunds.approve')
        ->middleware('permission:payments.refunds');
    Route::post('refunds/{refundId}/reject', [App\Http\Controllers\AdminPaymentController::class, 'rejectRefund'])
        ->name('refunds.reject')
        ->middleware('permission:payments.refunds');
    Route::post('refunds/{refundId}/mark-refunded', [App\Http\Controllers\AdminPaymentController::class, 'markRefunded'])
        ->name('refunds.markRefunded')
        ->middleware('permission:payments.refunds');

    // ── RBAC Management Panel (admin-only) ───────────────────────────────
    Route::get('rbac', [App\Http\Controllers\AdminRolesPermissionsController::class, 'index'])
        ->name('rbac.index')
        ->middleware('role:admin');

    Route::post('rbac/matrix', [App\Http\Controllers\AdminRolesPermissionsController::class, 'updateMatrix'])
        ->name('rbac.updateMatrix')
        ->middleware('role:admin');

    Route::post('rbac/roles', [App\Http\Controllers\AdminRolesPermissionsController::class, 'storeRole'])
        ->name('rbac.roles.store')
        ->middleware('role:admin');

    Route::delete('rbac/roles/{role}', [App\Http\Controllers\AdminRolesPermissionsController::class, 'destroyRole'])
        ->name('rbac.roles.destroy')
        ->middleware('role:admin');

    Route::post('rbac/permissions', [App\Http\Controllers\AdminRolesPermissionsController::class, 'storePermission'])
        ->name('rbac.permissions.store')
        ->middleware('role:admin');

    Route::delete('rbac/permissions/{permission}', [App\Http\Controllers\AdminRolesPermissionsController::class, 'destroyPermission'])
        ->name('rbac.permissions.destroy')
        ->middleware('role:admin');

    // ── Chat Reports Management ──────────────────────────────────────────
    Route::get('chatReports', [App\Http\Controllers\AdminChatReportController::class, 'index'])
        ->name('chatReports.index')
        ->middleware('permission:reports.view');
    Route::get('chatReports/{id}', [App\Http\Controllers\AdminChatReportController::class, 'show'])
        ->name('chatReports.show')
        ->middleware('permission:reports.view');
    Route::post('chatReports/{id}/review', [App\Http\Controllers\AdminChatReportController::class, 'review'])
        ->name('chatReports.review')
        ->middleware('permission:reports.view');
    Route::post('chatReports/{id}/block-user', [App\Http\Controllers\AdminChatReportController::class, 'blockUser'])
        ->name('chatReports.blockUser')
        ->middleware('permission:users.block');
});


/*   Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');  */

Route::get('/', function () {
    $locale = App::getLocale();
    return redirect('/' . $locale);
});


Route::get('/dashboard', function () {
    $locale = App::getLocale();
    // dd($locale);
    return redirect('/' . $locale . '/dashboard');
});


Route::group(['prefix' => '{locale?}'], function () {

    // ── Real Estate Map Page (public, no auth required) ──────────────
    Route::get('/map', [App\Http\Controllers\MapController::class, 'index'])->middleware('setLocale')->name('map.index');

    Route::group(['middleware' => 'CheackUser'], function () {
        Route::post('/redirectBack', 'App\Http\Controllers\PageController@redirectBack')->name('redirectBack');

        Route::get('/aqars/create', 'App\Http\Controllers\AqarController@create')->middleware(['setLocale']);
        Route::get('/governorates/search', 'App\Http\Controllers\AqarController@searchGovernorates')->middleware(['setLocale']);
        Route::get('/dashboard', function () {

            return View('dashboard');
        })->middleware(['setLocale']);


        Route::get('/callfary_api_card', 'App\Http\Controllers\DeveloperfawryPayment@callfary_api_card')->name('callfary_api_card')->middleware('setLocale');


        Route::get('/pricing-seller', 'App\Http\Controllers\PricController@index')->name('priceSeller')->middleware('setLocale');
        Route::get('/pricing-seller/{single}', 'App\Http\Controllers\PricController@show')->name('priceSingle')->middleware('setLocale');
        Route::get('/user_ads', 'App\Http\Controllers\PageController@user_ads')->name('user_ads');
        Route::get('/user_wishs', 'App\Http\Controllers\PageController@user_wishs')->name('user_wishs')->middleware(['setLocale']);
        Route::get('/user_complaints', 'App\Http\Controllers\PageController@user_complaints')->name('user_complaints')->middleware(['setLocale']);
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

        // ── User Payment History ──────────────────────────────────────────
        Route::get('/my-payments', [App\Http\Controllers\UserPaymentController::class, 'index'])->name('user.payments.index')->middleware('setLocale');
        Route::get('/my-payments/{id}', [App\Http\Controllers\UserPaymentController::class, 'show'])->name('user.payments.show')->middleware('setLocale');
        Route::post('/my-payments/{id}/refund', [App\Http\Controllers\UserPaymentController::class, 'requestRefund'])->name('user.payments.refund')->middleware('setLocale');

        // ── Chat & Social Routes ─────────────────────────────────────────
        Route::get('/chat', [App\Http\Controllers\ChatController::class, 'index'])->name('chat.index')->middleware('setLocale');
        Route::post('/chat/start', [App\Http\Controllers\ChatController::class, 'startConversation'])->name('chat.start')->middleware('setLocale');
        Route::post('/chat/send', [App\Http\Controllers\ChatController::class, 'sendMessage'])->name('chat.send')->middleware('setLocale');
        Route::get('/chat/{conversationId}/messages', [App\Http\Controllers\ChatController::class, 'getMessages'])->name('chat.messages')->middleware('setLocale');
        Route::delete('/chat/message/{messageId}', [App\Http\Controllers\ChatController::class, 'deleteMessage'])->name('chat.deleteMessage')->middleware('setLocale');
        Route::get('/chat/unread-count', [App\Http\Controllers\ChatController::class, 'unreadCount'])->name('chat.unreadCount')->middleware('setLocale');

        // ── Friends ──────────────────────────────────────────────────────
        Route::get('/friends', [App\Http\Controllers\FriendController::class, 'index'])->name('friends.index')->middleware('setLocale');
        Route::post('/friends/request', [App\Http\Controllers\FriendController::class, 'sendRequest'])->name('friends.request')->middleware('setLocale');
        Route::post('/friends/{friendshipId}/accept', [App\Http\Controllers\FriendController::class, 'acceptRequest'])->name('friends.accept')->middleware('setLocale');
        Route::post('/friends/{friendshipId}/decline', [App\Http\Controllers\FriendController::class, 'declineRequest'])->name('friends.decline')->middleware('setLocale');
        Route::post('/friends/remove', [App\Http\Controllers\FriendController::class, 'removeFriend'])->name('friends.remove')->middleware('setLocale');
        Route::get('/friends/search', [App\Http\Controllers\FriendController::class, 'searchUsers'])->name('friends.search')->middleware('setLocale');

        // ── Block ────────────────────────────────────────────────────────
        Route::get('/blocked', [App\Http\Controllers\BlockController::class, 'index'])->name('blocked.index')->middleware('setLocale');
        Route::post('/block', [App\Http\Controllers\BlockController::class, 'block'])->name('block.store')->middleware('setLocale');
        Route::post('/unblock', [App\Http\Controllers\BlockController::class, 'unblock'])->name('block.destroy')->middleware('setLocale');

        // ── Report ───────────────────────────────────────────────────────
        Route::post('/report', [App\Http\Controllers\ReportController::class, 'store'])->name('report.store')->middleware('setLocale');

        // ── Community / Posts ────────────────────────────────────────────
        Route::get('/community', [App\Http\Controllers\PostController::class, 'index'])->name('community.index')->middleware('setLocale');
        Route::post('/community/posts', [App\Http\Controllers\PostController::class, 'store'])->name('posts.store')->middleware('setLocale');
        Route::post('/community/posts/{postId}/like', [App\Http\Controllers\PostController::class, 'toggleLike'])->name('posts.like')->middleware('setLocale');
        Route::post('/community/posts/{postId}/comment', [App\Http\Controllers\PostController::class, 'addComment'])->name('posts.comment')->middleware('setLocale');
        Route::get('/community/posts/{postId}/comments', [App\Http\Controllers\PostController::class, 'getComments'])->name('posts.comments')->middleware('setLocale');
        Route::delete('/community/posts/{postId}', [App\Http\Controllers\PostController::class, 'destroy'])->name('posts.destroy')->middleware('setLocale');
        Route::delete('/community/comments/{commentId}', [App\Http\Controllers\PostController::class, 'deleteComment'])->name('comments.destroy')->middleware('setLocale');
    });

    Route::get('/login', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'create'])
        ->middleware(['guest:' . config('fortify.guard')])
        ->name('user.login')->middleware('setLocale');


    $limiter = config('fortify.limiters.login');

    Route::post('/login', [Laravel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'store'])
        ->middleware(array_filter([
            'guest:' . config('fortify.guard'),
            $limiter ? 'throttle:' . $limiter : null,
        ]))->middleware('setLocale');

    Route::post('/customLoginManual', 'App\Http\Controllers\PageController@customLoginManual')->name('customLoginManual')->middleware('setLocale');
    Route::get('/register', 'App\Http\Controllers\PageController@register')->name('user.register')->middleware('setLocale');
    Route::get('/verify-your-phone', 'App\Http\Controllers\PageController@otbPage')->name('otbPage')->middleware('setLocale');
    Route::get('/reset-your-password', 'App\Http\Controllers\PageController@otbReset')->name('otbReset')->middleware('setLocale');
    Route::get('/donePhoneVerf', 'App\Http\Controllers\PageController@donePhoneVerf')->name('donePhoneVerf')->middleware('setLocale');
    Route::post('/custom_register', 'App\Http\Controllers\PageController@custom_register')->name('custom_register')->middleware('setLocale');
    Route::get('/', 'App\Http\Controllers\SiteHomeController@home')->name('homeBlade')->middleware(['setLocale']);
    Route::get('/gcamp', 'App\Http\Controllers\SiteHomeController@home')->name('gcamp')->middleware(['setLocale']);
    Route::get('/aqars-{slug}', 'App\Http\Controllers\AqarController@mainAqar')->middleware('setLocale');
    Route::get('/all_aqar_for_sale', 'App\Http\Controllers\AqarController@all_aqar_for_sale')->middleware('setLocale');
    Route::get('/all_aqar_for_rent', 'App\Http\Controllers\AqarController@all_aqar_for_rent')->middleware('setLocale');

    Route::get('/aqar-finnance', 'App\Http\Controllers\AqarController@finnance')->name('aqar-finnance')->middleware('setLocale');
    Route::get('/aqars/update/{aqar}', 'App\Http\Controllers\AqarController@edit')->middleware('setLocale');

    Route::get('/aqars/{aqar}', 'App\Http\Controllers\AqarController@show')->middleware('setLocale');
    Route::get('/compare', 'App\Http\Controllers\AqarController@compare')->name('compare')->middleware('setLocale');


    // Route::get('/pricing-vip/{aqarSingle}', 'App\Http\Controllers\PricController@vip')->middleware('setLocale');
    // Route::get('/tamyeez_vip/{vipid}/{aqarSingle_id}', 'App\Http\Controllers\PricController@tamyeez_vip')->middleware('setLocale');

    Route::get('/search', 'App\Http\Controllers\AqarController@search')->name('search')->middleware('setLocale');
    Route::get('/filter', 'App\Http\Controllers\AqarController@filter')->name('filter')->middleware('setLocale');
    Route::get('/sorted', 'App\Http\Controllers\AqarController@sorting')->name('sort')->middleware('setLocale');
    Route::get('/aqar-added', 'App\Http\Controllers\AqarController@submited')->name('thankyou')->middleware('setLocale');

    // ── Apartment Designer (صمم شقتك بنفسك) ────────────────────────
    Route::get('/designer', function () { return view('designer.index'); })->name('designer.index')->middleware('setLocale');

    // ── Property Hunter Game ─────────────────────────────────────────
    Route::get('/game', function () { return view('game.index'); })->name('game.index')->middleware('setLocale');

    // ── Smart Search (AI Chat Assistant) ─────────────────────────────
    Route::get('/smart-search', [App\Http\Controllers\SmartSearchController::class, 'index'])->name('smart-search.index')->middleware('setLocale');
    Route::post('/smart-search/search', [App\Http\Controllers\SmartSearchController::class, 'search'])->name('smart-search.search')->middleware('setLocale');
    Route::get('/smart-search/suggestions', [App\Http\Controllers\SmartSearchController::class, 'suggestions'])->name('smart-search.suggestions')->middleware('setLocale');

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


//Route::post('/blogs/upload-file', 'App\Http\Controllers\blogsController@uploadFile')->name('blogs.upload.file');
Route::post('/add_company_post', 'App\Http\Controllers\CompanyController@store')->name('add_company_post');
Route::post('/price-subscribed', 'App\Http\Controllers\PricController@store')->name('price-subscribed');
Route::post('/price-free-subscribed', 'App\Http\Controllers\PricController@storeFree')->name('price-free-subscribed');
Route::post('/add-user-complain', 'App\Http\Controllers\AqarController@usercomplain')->name('add-user-complain');
Route::group(['middleware' => 'auth:sanctum'], function () {

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
Route::get('/aqar-finnance', 'App\Http\Controllers\AqarController@finnance');
Route::get('/aqars-{slug}', 'App\Http\Controllers\AqarController@mainAqar');
Route::post('/add-wish_list', 'App\Http\Controllers\AqarController@addwish_list')->name('add-wish_list');
Route::get('/get-wish_list_ids', 'App\Http\Controllers\AqarController@getWishListIds')->name('get-wish_list_ids');
Route::post('/remove-wish_list', 'App\Http\Controllers\AqarController@removewish_list')->name('remove-wish_list');
Route::post('/add-contactaqar', 'App\Http\Controllers\AqarController@addContact')->name('add-contactaqar');
Route::post('/ajx_main_img_edit_only', 'App\Http\Controllers\AqarController@ajx_main_img_edit_only')->name('ajx_main_img_edit_only');

Route::post('/contact-info', 'App\Http\Controllers\PagesController@store')->name('contact-info');

Route::get('/ourcompanies-{slug}', 'App\Http\Controllers\CompanyController@furn');
Route::get('/companies/{compan}', 'App\Http\Controllers\CompanyController@show');
Route::get('/ourcompanies-{slug}/filterby', 'App\Http\Controllers\CompanyController@sorting');

Route::get('/add-to-vip/{aqar_id}/{user_id}', 'App\Http\Controllers\PricController@add_to_vip');
//Route::get('dashboard', 'App\Http\Controllers\UserController@profile')->middleware('auth');
Route::post('api/fetch-states', [App\Http\Controllers\DropdownController::class, 'fetchState']);
Route::get('api/fetch-property-types', 'App\Http\Controllers\AqarController@fetchPropertyTypesByCat')->name('api.fetchPropertyTypes');

// ── Map API Endpoints ────────────────────────────────────────────────
Route::get('/api/map/aqars', [App\Http\Controllers\MapController::class, 'getAqars'])->name('api.map.aqars');
Route::post('/api/map/location', [App\Http\Controllers\MapController::class, 'storeLocation'])->name('api.map.storeLocation');
Route::get('/api/map/governorate-coords', [App\Http\Controllers\MapController::class, 'getGovernorateDefaultCoords'])->name('api.map.govCoords');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/phoneVerfication', 'App\Http\Controllers\PageController@verifyOtbPage')->name('verficationApply');

Route::post('/phoneVerficationReset', 'App\Http\Controllers\PageController@verifyOtbReset')->name('verficationReset');

Route::post('/phoneResetPassword', 'App\Http\Controllers\PageController@phoneResetPassword')->name('phoneResetPassword');


Route::group(['middleware' => 'CheackUser'], function () {

    Route::post('/updated-company/{company}', 'App\Http\Controllers\CompanyController@updatedProfileCompany');
    Route::post('/remove-user-company', 'App\Http\Controllers\CompanyController@removeuserCompany')->name('remove-user-company');
    Route::post('/remove-user-Ads', 'App\Http\Controllers\AqarController@removeuserAds')->name('remove-user-Ads');
    // Route::post('/add-user-complain', 'App\Http\Controllers\AqarController@usercomplain')->name('add-user-complain');
    Route::post('/change-user-notfi', 'App\Http\Controllers\PageController@ChangeStatus')->name('change-user-notfi');

    // Account Delete Request
    Route::post('/request-account-delete', 'App\Http\Controllers\AccountDeleteRequestController@store')->name('request-account-delete');

    // Delete Complaint
    Route::post('/user_complaints/{id}/delete', 'App\Http\Controllers\PageController@deleteComplaint')->name('user_complaints.delete');
});
Route::post('/updatedProfileUser', 'App\Http\Controllers\UpdateProfileUserController@UpdateProfileUser');
Route::post('/add-user-session', 'App\Http\Controllers\PageController@usersession')->name('add-user-session');

Route::post('/resend-otb', 'App\Http\Controllers\PageController@resendOTB')->name('resendOTB');


/*
|--------------------------------------------------------------------------
| Admin Blog Routes (migrated from ADMIN project)
|--------------------------------------------------------------------------
*/
