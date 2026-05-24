<?php

use Illuminate\Support\Facades\Route;

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
*/
Route::prefix('sitemanagement')->name('sitemanagement.')->middleware(['admin-web', 'adminfCheckAdmin'])->group(function () {

    // ── Blogs ─────────────────────────────────────────────────────────────
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

    // ── Ads (اعلانات خارجية) ──────────────────────────────────────────────
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.create')->only(['create', 'store']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.view')->only(['index', 'show']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.update')->only(['edit', 'update']);
    Route::resource('ads', App\Http\Controllers\AdminAdsController::class)
        ->middleware('permission:ads.delete')->only(['destroy']);

    // ── Settings ──────────────────────────────────────────────────────────
    Route::resource('settingSites', App\Http\Controllers\AdminSettingSiteController::class)
        ->middleware('permission:settings.manage');

    // ── Meta Conversions API ───────────────────────────────────────────────
    Route::get('meta-conversions', [App\Http\Controllers\AdminMetaConversionsController::class, 'index'])
        ->name('meta-conversions.index')
        ->middleware('permission:settings.manage');
    Route::put('meta-conversions', [App\Http\Controllers\AdminMetaConversionsController::class, 'update'])
        ->name('meta-conversions.update')
        ->middleware('permission:settings.manage');
    Route::post('meta-conversions/test-event', [App\Http\Controllers\AdminMetaConversionsController::class, 'testEvent'])
        ->name('meta-conversions.test-event')
        ->middleware('permission:settings.manage');

    Route::resource('requestPhotoSessions', App\Http\Controllers\AdminRequestPhotoSessionController::class);

    // ── Images Management ──────────────────────────────────────────────────
    Route::get('images', [App\Http\Controllers\AdminImagesController::class, 'index'])->name('images.index');
    Route::delete('images/bulk-delete', [App\Http\Controllers\AdminImagesController::class, 'bulkDelete'])->name('images.bulk-delete');
    Route::delete('images/{id}', [App\Http\Controllers\AdminImagesController::class, 'destroy'])->name('images.destroy');

    Route::resource('priceVips', App\Http\Controllers\AdminPriceVipController::class)
        ->middleware('permission:pricing.manage');
    Route::resource('pages', App\Http\Controllers\AdminPagesController::class);

    // ── Companies ──────────────────────────────────────────────────────────
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

    // ── Location Data ──────────────────────────────────────────────────────
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

    // ── Notifications ──────────────────────────────────────────────────────
    Route::resource('notifications', App\Http\Controllers\AdminNotificationController::class)
        ->middleware('permission:notifications.manage')->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('notifications', App\Http\Controllers\AdminNotificationController::class)
        ->middleware('permission:notifications.view')->only(['index', 'show']);

    // ── Contact Forms ──────────────────────────────────────────────────────
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.view')->only(['create', 'store', 'edit', 'update']);
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.view')->only(['index', 'show']);
    Route::resource('contactForms', App\Http\Controllers\AdminContactFormController::class)
        ->middleware('permission:contact_forms.delete')->only(['destroy']);

    Route::resource('propertyTypes', App\Http\Controllers\AdminPropertyTypeController::class)
        ->middleware('permission:settings.manage');

    // ── Complaints ─────────────────────────────────────────────────────────
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.update')->only(['edit', 'update']);
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.view')->only(['index', 'show']);
    Route::resource('complaints', App\Http\Controllers\AdminComplaintsController::class)
        ->middleware('permission:complaints.delete')->only(['destroy']);

    // ── Real Estate (Aqars) ────────────────────────────────────────────────
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

    // ── Aqar Delete Reasons ────────────────────────────────────────────────
    Route::resource('aqar-delete-reasons', App\Http\Controllers\AdminAqarDeleteReasonController::class);

    // ── Users ──────────────────────────────────────────────────────────────
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
    Route::get('users/{user}/history', [App\Http\Controllers\AdminUserController::class, 'history'])->name('users.history')
        ->middleware('permission:users.view');
    Route::get('users-export', [App\Http\Controllers\AdminUserController::class, 'exportUsers'])->name('users.exportUsers')
        ->middleware('permission:users.export');
    Route::post('users/{user}/add-points', [App\Http\Controllers\AdminUserPointsController::class, 'addPoints'])->name('users.addPoints')
        ->middleware('permission:users.update');
    Route::get('users/{user}/get-points', [App\Http\Controllers\AdminUserPointsController::class, 'getPoints'])->name('users.getPoints')
        ->middleware('permission:users.update');

    // ── Reports ────────────────────────────────────────────────────────────
    Route::get('reports', [App\Http\Controllers\AdminReportController::class, 'index'])->name('reports.index')
        ->middleware('permission:reports.view');
    Route::get('reports/invited-by-details', [App\Http\Controllers\AdminReportController::class, 'invitedByDetails'])->name('reports.invitedByDetails')
        ->middleware('permission:reports.view');
    Route::get('reports/user-contacts', [App\Http\Controllers\AdminReportController::class, 'userContacts'])->name('reports.userContacts')
        ->middleware('permission:reports.view');
    Route::get('reports/subscriptions', [App\Http\Controllers\AdminReportController::class, 'subscriptions'])->name('reports.subscriptions')
        ->middleware('permission:reports.view');

    // ── Account Delete Requests ────────────────────────────────────────────
    Route::get('accountDeleteRequests', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'index'])->name('accountDeleteRequests.index')
        ->middleware('permission:users.view');
    Route::post('accountDeleteRequests/{id}/approve', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'approve'])->name('accountDeleteRequests.approve')
        ->middleware('permission:users.delete');
    Route::post('accountDeleteRequests/{id}/reject', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'reject'])->name('accountDeleteRequests.reject')
        ->middleware('permission:users.delete');
    Route::post('accountDeleteRequests/{id}/restore', [App\Http\Controllers\AdminAccountDeleteRequestController::class, 'restore'])->name('accountDeleteRequests.restore')
        ->middleware('permission:users.delete');

    // ── Error Logs ─────────────────────────────────────────────────────────
    Route::post('errorLogs/clear', [App\Http\Controllers\AdminErrorLogController::class, 'clearAll'])
        ->name('errorLogs.clearAll')
        ->middleware('role:admin');
    Route::resource('errorLogs', App\Http\Controllers\AdminErrorLogController::class)
        ->middleware('role:admin')->only(['index', 'show', 'destroy']);

    // ── Activity Logs ──────────────────────────────────────────────────────
    Route::post('activityLogs/clear', [App\Http\Controllers\AdminActivityLogController::class, 'clearAll'])
        ->name('activityLogs.clearAll')
        ->middleware('role:admin');
    Route::resource('activityLogs', App\Http\Controllers\AdminActivityLogController::class)
        ->middleware('role:admin')->only(['index', 'show', 'destroy']);

    // ── Online Users ───────────────────────────────────────────────────────
    Route::get('onlineUsers', [App\Http\Controllers\AdminOnlineUsersController::class, 'index'])
        ->name('onlineUsers.index')
        ->middleware('role:admin');
    Route::get('onlineUsers/{userId}', [App\Http\Controllers\AdminOnlineUsersController::class, 'show'])
        ->name('onlineUsers.show')
        ->middleware('role:admin');

    // ── SMS Messaging ──────────────────────────────────────────────────────
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
    Route::get('sms-search-users', [App\Http\Controllers\AdminSmsController::class, 'searchUsers'])
        ->name('sms.searchUsers')
        ->middleware('permission:sms.send');
    Route::post('sms-preview-recipients', [App\Http\Controllers\AdminSmsController::class, 'previewRecipients'])
        ->name('sms.previewRecipients')
        ->middleware('permission:sms.send');

    // ── WhatsApp Messaging ─────────────────────────────────────────────────
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
    Route::get('whatsapp-search-users', [App\Http\Controllers\AdminWhatsappController::class, 'searchUsers'])
        ->name('whatsapp.searchUsers')
        ->middleware('permission:whatsapp.send');
    Route::post('whatsapp-preview-recipients', [App\Http\Controllers\AdminWhatsappController::class, 'previewRecipients'])
        ->name('whatsapp.previewRecipients')
        ->middleware('permission:whatsapp.send');

    // ── Payment Management ─────────────────────────────────────────────────
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

    // ── RBAC Management Panel ──────────────────────────────────────────────
    Route::get('rbac', [App\Http\Controllers\AdminRolesPermissionsController::class, 'index'])
        ->name('rbac.index')->middleware('role:admin');
    Route::post('rbac/matrix', [App\Http\Controllers\AdminRolesPermissionsController::class, 'updateMatrix'])
        ->name('rbac.updateMatrix')->middleware('role:admin');
    Route::post('rbac/roles', [App\Http\Controllers\AdminRolesPermissionsController::class, 'storeRole'])
        ->name('rbac.roles.store')->middleware('role:admin');
    Route::delete('rbac/roles/{role}', [App\Http\Controllers\AdminRolesPermissionsController::class, 'destroyRole'])
        ->name('rbac.roles.destroy')->middleware('role:admin');
    Route::post('rbac/permissions', [App\Http\Controllers\AdminRolesPermissionsController::class, 'storePermission'])
        ->name('rbac.permissions.store')->middleware('role:admin');
    Route::delete('rbac/permissions/{permission}', [App\Http\Controllers\AdminRolesPermissionsController::class, 'destroyPermission'])
        ->name('rbac.permissions.destroy')->middleware('role:admin');

    // ── Chat Reports Management ────────────────────────────────────────────
    Route::get('chatReports', [App\Http\Controllers\AdminChatReportController::class, 'index'])
        ->name('chatReports.index')->middleware('permission:reports.view');
    Route::get('chatReports/{id}', [App\Http\Controllers\AdminChatReportController::class, 'show'])
        ->name('chatReports.show')->middleware('permission:reports.view');
    Route::post('chatReports/{id}/review', [App\Http\Controllers\AdminChatReportController::class, 'review'])
        ->name('chatReports.review')->middleware('permission:reports.view');
    Route::post('chatReports/{id}/block-user', [App\Http\Controllers\AdminChatReportController::class, 'blockUser'])
        ->name('chatReports.blockUser')->middleware('permission:users.block');
});

