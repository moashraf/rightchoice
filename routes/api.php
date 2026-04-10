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

/*
|--------------------------------------------------------------------------
| Authentication (Public)
|--------------------------------------------------------------------------
*/
Route::post('login',  [App\Http\Controllers\API\AuthAPIController::class, 'login']);
Route::post('logout', [App\Http\Controllers\API\AuthAPIController::class, 'logout']);

// Registration
Route::post('register',   [App\Http\Controllers\API\RegisterAPIController::class, 'register']);
Route::post('verify-otp', [App\Http\Controllers\API\RegisterAPIController::class, 'verifyOtp']);
Route::post('resend-otp', [App\Http\Controllers\API\RegisterAPIController::class, 'resendOtp']);

// Password Reset (Phone-based)
Route::post('password/request-otp', [App\Http\Controllers\API\PasswordResetAPIController::class, 'requestOtp']);
Route::post('password/verify-otp',  [App\Http\Controllers\API\PasswordResetAPIController::class, 'verifyResetOtp']);
Route::post('password/reset',       [App\Http\Controllers\API\PasswordResetAPIController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| Public Resources (CRUD)
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Search & Filter (Public)
|--------------------------------------------------------------------------
*/
Route::get('search',                 [App\Http\Controllers\API\SearchAPIController::class, 'search']);
Route::get('search/filters',        [App\Http\Controllers\API\SearchAPIController::class, 'filters']);
Route::get('search/property-types', [App\Http\Controllers\API\SearchAPIController::class, 'propertyTypes']);
Route::get('search/districts',      [App\Http\Controllers\API\SearchAPIController::class, 'districts']);

/*
|--------------------------------------------------------------------------
| Smart Search / AI (Public)
|--------------------------------------------------------------------------
*/
Route::post('smart-search',             [App\Http\Controllers\API\SmartSearchAPIController::class, 'search']);
Route::get('smart-search/suggestions',  [App\Http\Controllers\API\SmartSearchAPIController::class, 'suggestions']);

/*
|--------------------------------------------------------------------------
| Map (Public)
|--------------------------------------------------------------------------
*/
Route::get('map/aqars',              [App\Http\Controllers\API\MapAPIController::class, 'getAqars']);
Route::post('map/location',          [App\Http\Controllers\API\MapAPIController::class, 'storeLocation']);
Route::get('map/governorate-coords', [App\Http\Controllers\API\MapAPIController::class, 'getGovernorateCoords']);

/*
|--------------------------------------------------------------------------
| Authenticated User Routes (require Sanctum token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ── Profile ──────────────────────────────────────────────────────
    Route::get('profile',                 [App\Http\Controllers\API\ProfileAPIController::class, 'show']);
    Route::post('profile/update',         [App\Http\Controllers\API\ProfileAPIController::class, 'update']);
    Route::post('profile/change-password',[App\Http\Controllers\API\ProfileAPIController::class, 'changePassword']);

    // ── My Ads ───────────────────────────────────────────────────────
    Route::get('my-ads',                  [App\Http\Controllers\API\UserDashboardAPIController::class, 'myAds']);
    Route::delete('my-ads/{id}',          [App\Http\Controllers\API\UserDashboardAPIController::class, 'deleteMyAd']);

    // ── Wishlist ─────────────────────────────────────────────────────
    Route::get('my-wishlist',             [App\Http\Controllers\API\UserDashboardAPIController::class, 'myWishlist']);
    Route::get('my-wishlist-ids',         [App\Http\Controllers\API\UserDashboardAPIController::class, 'myWishlistIds']);
    Route::post('wishlist/add',           [App\Http\Controllers\API\UserDashboardAPIController::class, 'addToWishlist']);
    Route::post('wishlist/remove',        [App\Http\Controllers\API\UserDashboardAPIController::class, 'removeFromWishlist']);

    // ── Complaints ───────────────────────────────────────────────────
    Route::get('my-complaints',           [App\Http\Controllers\API\UserDashboardAPIController::class, 'myComplaints']);
    Route::post('complaints/submit',      [App\Http\Controllers\API\UserDashboardAPIController::class, 'submitComplaint']);
    Route::delete('my-complaints/{id}',   [App\Http\Controllers\API\UserDashboardAPIController::class, 'deleteComplaint']);

    // ── Notifications ────────────────────────────────────────────────
    Route::get('my-notifications',              [App\Http\Controllers\API\UserDashboardAPIController::class, 'myNotifications']);
    Route::post('notifications/{id}/read',      [App\Http\Controllers\API\UserDashboardAPIController::class, 'markNotificationRead']);

    // ── Points & Contact ─────────────────────────────────────────────
    Route::get('my-points',               [App\Http\Controllers\API\UserDashboardAPIController::class, 'myPoints']);
    Route::post('contact-aqar',           [App\Http\Controllers\API\UserDashboardAPIController::class, 'contactAqar']);

    // ── Payments ─────────────────────────────────────────────────────
    Route::get('my-payments',             [App\Http\Controllers\API\UserPaymentAPIController::class, 'index']);
    Route::get('my-payments/{id}',        [App\Http\Controllers\API\UserPaymentAPIController::class, 'show']);
    Route::post('my-payments/{id}/refund',[App\Http\Controllers\API\UserPaymentAPIController::class, 'requestRefund']);

    // ── Chat ─────────────────────────────────────────────────────────
    Route::get('chat/conversations',               [App\Http\Controllers\API\ChatAPIController::class, 'conversations']);
    Route::post('chat/start',                      [App\Http\Controllers\API\ChatAPIController::class, 'startConversation']);
    Route::post('chat/send',                       [App\Http\Controllers\API\ChatAPIController::class, 'sendMessage']);
    Route::get('chat/{conversationId}/messages',   [App\Http\Controllers\API\ChatAPIController::class, 'getMessages']);
    Route::delete('chat/message/{messageId}',      [App\Http\Controllers\API\ChatAPIController::class, 'deleteMessage']);
    Route::get('chat/unread-count',                [App\Http\Controllers\API\ChatAPIController::class, 'unreadCount']);

    // ── Friends ──────────────────────────────────────────────────────
    Route::get('friends',                          [App\Http\Controllers\API\FriendAPIController::class, 'index']);
    Route::post('friends/request',                 [App\Http\Controllers\API\FriendAPIController::class, 'sendRequest']);
    Route::post('friends/{friendshipId}/accept',   [App\Http\Controllers\API\FriendAPIController::class, 'acceptRequest']);
    Route::post('friends/{friendshipId}/decline',  [App\Http\Controllers\API\FriendAPIController::class, 'declineRequest']);
    Route::post('friends/remove',                  [App\Http\Controllers\API\FriendAPIController::class, 'removeFriend']);
    Route::get('friends/search',                   [App\Http\Controllers\API\FriendAPIController::class, 'searchUsers']);

    // ── Block ────────────────────────────────────────────────────────
    Route::get('blocked',                          [App\Http\Controllers\API\BlockAPIController::class, 'index']);
    Route::post('block',                           [App\Http\Controllers\API\BlockAPIController::class, 'block']);
    Route::post('unblock',                         [App\Http\Controllers\API\BlockAPIController::class, 'unblock']);

    // ── Report ───────────────────────────────────────────────────────
    Route::post('report',                          [App\Http\Controllers\API\ReportAPIController::class, 'store']);

    // ── Community / Posts ────────────────────────────────────────────
    Route::get('community/posts',                        [App\Http\Controllers\API\PostAPIController::class, 'index']);
    Route::post('community/posts',                       [App\Http\Controllers\API\PostAPIController::class, 'store']);
    Route::post('community/posts/{postId}/like',         [App\Http\Controllers\API\PostAPIController::class, 'toggleLike']);
    Route::post('community/posts/{postId}/comment',      [App\Http\Controllers\API\PostAPIController::class, 'addComment']);
    Route::get('community/posts/{postId}/comments',      [App\Http\Controllers\API\PostAPIController::class, 'getComments']);
    Route::delete('community/posts/{postId}',            [App\Http\Controllers\API\PostAPIController::class, 'destroy']);
    Route::delete('community/comments/{commentId}',      [App\Http\Controllers\API\PostAPIController::class, 'deleteComment']);

    // ── Account Deletion ─────────────────────────────────────────────
    Route::post('account/delete-request',          [App\Http\Controllers\API\AccountDeleteAPIController::class, 'store']);
    Route::get('account/delete-request/status',    [App\Http\Controllers\API\AccountDeleteAPIController::class, 'status']);
});

