<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\aqar;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Profile & Password management API.
 */
class ProfileAPIController extends AppBaseController
{
    // ...existing code...

    /**
     * POST /api/profile/full
     * عرض البيانات الشخصية الكاملة للمستخدم المسجّل مع pagination
     */
    public function fullProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page'        => 'nullable|integer|min:1|max:100',
            'ads_per_page'    => 'nullable|integer|min:1|max:100',
        ], [
            'per_page.integer'     => 'per_page يجب أن يكون رقماً صحيحاً',
            'per_page.min'         => 'per_page يجب أن يكون على الأقل 1',
            'per_page.max'         => 'per_page يجب ألا يتجاوز 100',
            'ads_per_page.integer' => 'ads_per_page يجب أن يكون رقماً صحيحاً',
            'ads_per_page.min'     => 'ads_per_page يجب أن يكون على الأقل 1',
            'ads_per_page.max'     => 'ads_per_page يجب ألا يتجاوز 100',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة', 422, $validator->errors()->toArray());
        }

        $user       = $request->user();
        $perPage    = $request->input('per_page', 15);
        $adsPerPage = $request->input('ads_per_page', 15);

        // البيانات الشخصية الكاملة
        $user->load([
            'companiess',
            'userpricing.pricing',
            'userpricin',
            'wishlist.aqarInfo',
            'notification',
        ]);

        // إعلانات المستخدم مع كل التفاصيل
        $ads = aqar::where('user_id', $user->id)
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
            ->paginate($adsPerPage);

        return $this->sendResponse([
            'personal_info' => [
                'id'                  => $user->id,
                'name'                => $user->name,
                'email'               => $user->email,
                'phone'               => $user->MOP,
                'age'                 => $user->AGE,
                'type'                => $user->TYPE,
                'type_label'          => $user->getUserType(),
                'status'              => $user->status,
                'status_label'        => $user->getStatus(),
                'job_title'           => $user->Job_title,
                'employee_name'       => $user->Employee_Name,
                'tax_card'            => $user->Tax_card,
                'commercial_register' => $user->Commercial_Register,
                'profile_image'       => $user->profile_image_url,
                'is_online'           => $user->isOnline(),
                'created_at'          => $user->created_at,
            ],
            'companies'             => $user->companiess,
            'current_package'       => $user->userpricin,
            'pricing_history'       => $user->userpricing,
            'notifications_count'   => $user->notification->count(),
            'ads'                   => $ads->toArray(),
        ], 'تم جلب البيانات الشخصية الكاملة بنجاح');
    }

    /**
     * GET /api/profile
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return $this->sendResponse([
            'id'                  => $user->id,
            'name'                => $user->name,
            'email'               => $user->email,
            'phone'               => $user->MOP,
            'type'                => $user->TYPE,
            'age'                 => $user->AGE,
            'profile_image'       => $user->profile_image_url,
            'status'              => $user->status,
            'Employee_Name'       => $user->Employee_Name,
            'Job_title'           => $user->Job_title,
            'Tax_card'            => $user->Tax_card,
            'Commercial_Register' => $user->Commercial_Register,
        ], 'Profile retrieved successfully');
    }

    /**
     * POST /api/profile/update
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'                => 'required|max:255',
            'email'               => "required|email|unique:users,email,{$user->id}",
            'MOP'                 => "required|min:11|numeric|unique:users,MOP,{$user->id}",
            'AGE'                 => 'nullable|integer',
            'TYPE'                => 'nullable|integer',
            'Employee_Name'       => ($request->TYPE == 3 ? 'required' : 'nullable'),
            'Job_title'           => ($request->TYPE == 3 ? 'required' : 'nullable'),
            'Tax_card'            => ($request->TYPE == 3 ? 'required' : 'nullable'),
            'Commercial_Register' => ($request->TYPE == 3 ? 'required' : 'nullable'),
            'img'                 => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $request->only(['name', 'email', 'MOP', 'AGE', 'TYPE', 'Employee_Name', 'Job_title', 'Tax_card', 'Commercial_Register']);

        if ($request->hasFile('img')) {
            $data['profile_image'] = _uploadFileWeb($request->img, 'user/');
        }

        $user->update($data);

        return $this->sendResponse($user->fresh()->only([
            'id', 'name', 'email', 'MOP', 'AGE', 'TYPE', 'profile_image',
            'Employee_Name', 'Job_title', 'Tax_card', 'Commercial_Register',
        ]), 'Profile updated successfully');
    }

    /**
     * POST /api/profile/change-password
     */
    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|min:6',
            'password'     => 'required|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->sendError('Old password is incorrect', 400);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->sendSuccess('Password changed successfully');
    }
}

