<?php

namespace App\Http\Controllers\API;

use App\Models\User;
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

