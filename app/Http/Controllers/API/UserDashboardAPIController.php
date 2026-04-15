<?php

namespace App\Http\Controllers\API;

use App\Models\aqar;
use App\Models\wish;
use App\Models\Notification;
use App\Models\UserPriceing;
use App\Models\UserContactAqar;
use App\Models\FawryPayment;
use App\Models\Complaints;
use App\Services\Chat\PostService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * User Dashboard API — my ads, wishlist, complaints, notifications, points.
 */
class UserDashboardAPIController extends AppBaseController
{


    /**
     * GET /api/my-posts
     * Returns all posts (community posts) created by the authenticated user.
     */
    public function myPosts(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = (int) $request->get('per_page', 15);

        $posts = $this->postService->getUserPosts($user->id, $perPage);

        $data = $posts->getCollection()->map(function ($post) use ($user) {
            $author = $post->getUser();
            return [
                'id'             => (string) $post->_id,
                'content'        => $post->content,
                'images'         => $post->images ?? [],
                'user_id'        => $post->user_id,
                'user_name'      => $author ? $author->name : 'Deleted User',
                'user_image'     => $author ? $author->profile_image_url : null,
                'likes_count'    => $post->likes_count ?? 0,
                'comments_count' => $post->comments_count ?? 0,
                'is_liked'       => $post->isLikedBy($user->id),
                'created_at'     => $post->created_at->toDateTimeString(),
            ];
        });

        return $this->sendResponse([
            'posts'      => $data,
            'pagination' => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'total'        => $posts->total(),
            ],
        ], 'My posts retrieved successfully');
    }

    /**
     * GET /api/my-ads
     */


     protected function resolveUserId(Request $request): ?int
{
    return $request->get('user_id')
        ?? $request->route('user_id')
        ?? auth()->id();
}


/**
 * GET /api/user-ads
 * Required query param: user_id
 */

public function getUserAdsByUserId(Request $request, int $user_id): JsonResponse
{
    $validator = Validator::make(
        [
            'user_id'  => $user_id,
            'per_page' => $request->get('per_page'),
        ],
        [
            'user_id'  => 'required|integer|exists:users,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]
    );

    if ($validator->fails()) {
        return $this->sendError(
            'Validation failed. Please check your input.',
            422,
            $validator->errors()
        );
    }

    $aqars = aqar::where('user_id', $user_id)
        ->with(['images', 'governrateq', 'districte', 'offerTypes'])
        ->latest()
        ->paginate($request->get('per_page', 15));

    return $this->sendResponse(
        $aqars->toArray(),
        'User ads retrieved successfully.'
    );
}


 /**
 * GET /api/users/{user_id}/wishlist
 */
public function getUserWishlistByUserId(Request $request, int $user_id): JsonResponse
{
    $validator = Validator::make(
        [
            'user_id'  => $user_id,
            'per_page' => $request->get('per_page'),
        ],
        [
            'user_id'  => 'required|integer|exists:users,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]
    );

    if ($validator->fails()) {
        return $this->sendError(
            'Validation failed. Please check your input.',
            422,
            $validator->errors()
        );
    }

    $wishlist = wish::where('user_id', $user_id)
        ->with('aqarInfo')
        ->paginate($request->get('per_page', 15));

    return $this->sendResponse(
        $wishlist->toArray(),
        'Wishlist retrieved successfully.'
    );
}


    public function myAds(Request $request): JsonResponse
    {
        $user = $request->user();
        $userId = $this->resolveUserId($request);

         $aqars = aqar::where('user_id', $userId)
            ->with(['images', 'governrateq', 'districte', 'offerTypes'])
            ->latest()
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($aqars->toArray(), 'User ads retrieved successfully');
    }

    /**
     * POST /api/my-aqar-posts
     * Returns all aqar (property) listings created by a given user
     * that are regular posts (vip = 0), not VIP/featured.
     */
    public function myAqarPosts(Request $request): JsonResponse
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $aqars = aqar::where('user_id', $request->user_id)
            ->where('vip', 0)
            ->with([
                'images',
                'aqarLocation',
                'governrateq',
                'districte',
                'subAreaa',
                'callTimes',
                'offerTypes',
                'categoryRel',
                'finishType',
                'mzaya',
                'propertyType',
            ])
            ->latest()
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($aqars->toArray(), 'User aqar posts retrieved successfully');
    }

    /**
     * DELETE /api/my-ads/{id}
     */
    public function deleteMyAd(int $id): JsonResponse
    {
        $aqar = aqar::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$aqar) {
            return $this->sendError('Ad not found or does not belong to you.', 404);
        }

        $aqar->delete();

        return $this->sendSuccess('Ad deleted successfully.');
    }

    /**
     * GET /api/my-wishlist
     */
    public function myWishlist(Request $request): JsonResponse
    {
         $user = $request->user();

        $wishlist = wish::where('user_id', $user->id)
            ->with('aqarInfo')
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($wishlist->toArray(), 'Wishlist retrieved successfully.');
    }

/**
 * POST /api/wishlist/add-by-user
 */
public function addToWishlistByUserId(Request $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        'user_id'  => 'required|integer|exists:users,id',
        'aqars_id' => 'required|integer|exists:aqar,id',
    ]);

    if ($validator->fails()) {
        return $this->sendError(
            'Validation failed. Please check your input.',
            422,
            $validator->errors()
        );
    }

    $exists = wish::where('user_id', $request->user_id)
        ->where('aqars_id', $request->aqars_id)
        ->first();

    if ($exists) {
        return $this->sendError('This item is already in the wishlist.', 400);
    }

    $wishlist = wish::create([
        'user_id'  => $request->user_id,
        'aqars_id' => $request->aqars_id,
    ]);

    return $this->sendResponse(
        $wishlist->toArray(),
        'Item added to wishlist successfully.'
    );
}
    /**
     * GET /api/my-wishlist-ids
     */
    public function myWishlistIds(Request $request): JsonResponse
    {
        $ids = wish::where('user_id', $request->user()->id)
            ->pluck('aqars_id')
            ->toArray();

        return $this->sendResponse(['ids' => $ids], 'Wishlist IDs retrieved successfully.');
    }

    /**
     * POST /api/wishlist/add
     */
    public function addToWishlist(Request $request): JsonResponse
    {
        $user = $request->user();
        $user_id=null;
if ($user && $user->id){
 $user_id= $user->id;
}else{
     $user_id= $request->get('user_id') ?? $request->route('user_id') ;
}
        $exists = wish::where('user_id', $user_id)
            ->where('aqars_id', $request->aqars_id)
            ->first();

        if ($exists) {
            return $this->sendError('This item is already in your wishlist.', 400);
        }

        $user->wishlist()->create(['aqars_id' => $request->aqars_id]);

        return $this->sendSuccess('Item added to wishlist successfully.');
    }

    /**
     * POST /api/wishlist/remove
     */
    public function removeFromWishlist(Request $request): JsonResponse
    {
        $deleted = wish::where('user_id', $request->user()->id)
            ->where('aqars_id', $request->aqars_id)
            ->delete();

        if (!$deleted) {
            return $this->sendError('Item not found in your wishlist.', 404);
        }

        return $this->sendSuccess('Item removed from wishlist successfully.');
    }

    /**
     * GET /api/my-complaints
     */
    public function myComplaints(Request $request): JsonResponse
    {
        $complaints = Complaints::where('user_id', $request->user()->id)
            ->with('aqarinfo')
            ->orderBy('id', 'desc')
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($complaints->toArray(), 'Complaints retrieved successfully.');
    }

    /**
     * POST /api/complaints/submit
     */
    public function submitComplaint(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => 'required|string',
            'item_id' => 'required|integer|exists:aqar,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed. Please check your input.', 422, $validator->errors());
        }

        Complaints::create([
            'user_id'  => $request->user()->id,
            'aqars_id' => $request->item_id,
            'message'  => $request->message,
        ]);

        return $this->sendSuccess('Complaint submitted successfully.');
    }

    /**
     * DELETE /api/my-complaints/{id}
     */
    public function deleteComplaint(int $id): JsonResponse
    {
        $complaint = Complaints::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$complaint) {
            return $this->sendError('Complaint not found or does not belong to you.', 404);
        }

        $complaint->delete();

        return $this->sendSuccess('Complaint deleted successfully.');
    }

    /**
     * GET /api/my-notifications
     */
    public function myNotifications(Request $request): JsonResponse
    {
        $notifications = Notification::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse($notifications->toArray(), 'Notifications retrieved successfully.');
    }

    /**
     * POST /api/notifications/{id}/read
     */
    public function markNotificationRead(int $id): JsonResponse
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$notification) {
            return $this->sendError('Notification not found or does not belong to you.', 404);
        }

        $notification->update(['status' => 1]);

        return $this->sendSuccess('Notification marked as read.');
    }

    /**
     * GET /api/my-points
     */
    public function myPoints(Request $request): JsonResponse
    {
        $user = $request->user();

        $points = 0;
        if ($user->userpricin && $user->userpricin->current_points >= 0) {
            $points = $user->userpricin->current_points;
        }

        $history = UserPriceing::with('pricing')
            ->where('user_id', $user->id)
            ->get();

        $contactHistory = UserContactAqar::with('all_aqat_viw')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->paginate($request->get('per_page', 15));

        return $this->sendResponse([
            'current_points'  => $points,
            'points_history'  => $history->toArray(),
            'contact_history' => $contactHistory->toArray(),
        ], 'Points retrieved successfully.');
    }

    /**
     * POST /api/contact-aqar
     */
    public function contactAqar(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'aqars_id' => 'required|integer|exists:aqar,id',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed. Please check your input.', 422, $validator->errors());
        }

        $user = $request->user();
        $aqar = aqar::findOrFail($request->aqars_id);

        $checkPoint = UserPriceing::where('user_id', $user->id)->orderBy('id', 'DESC')->first();
        $existingContact = UserContactAqar::where('aqars_id', $request->aqars_id)
            ->where('user_id', $user->id)->get();

        if ($checkPoint && count($existingContact) <= 0) {
            if ($checkPoint->current_points == 0 || $aqar->points_avail > $checkPoint->current_points) {
                return $this->sendError('Not enough points. Please renew your package.', 400);
            }

            $pointsUsed = $aqar->points_avail;
            $subPoint = $pointsUsed + $checkPoint->sub_points;
            $currentPoint = $checkPoint->start_points - $subPoint;

            $checkPoint->update([
                'sub_points'     => $subPoint,
                'current_points' => $currentPoint,
            ]);

            UserContactAqar::create([
                'user_id'  => $user->id,
                'aqars_id' => $request->aqars_id,
            ]);
        }

        return $this->sendResponse([
            'phone' => $aqar->user->MOP ?? null,
        ], 'Contact retrieved successfully.');
    }
}
