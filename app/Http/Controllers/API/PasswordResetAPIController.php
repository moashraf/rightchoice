<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\SmsService;

/**
 * Phone-based Password Reset API.
 */
class PasswordResetAPIController extends AppBaseController
{
    /**
     * Request password reset OTP.
     * POST /api/password/request-otp
     */
    public function requestOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|min:10|max:11',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('MOP', $request->phone)->first();

        if (!$user) {
            return $this->sendError('User not found with this phone number', 404);
        }

        $otpCode = random_int(1000, 9999);
        $user->update(['phone_sms_otp' => $otpCode]);

        SmsService::sendOtp($user->MOP, $otpCode);

        return $this->sendResponse([
            'user_id'  => $user->id,
            'otp_sent' => true,
        ], 'OTP sent to your phone');
    }

    /**
     * Verify the reset OTP.
     * POST /api/password/verify-otp
     */
    public function verifyResetOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'otp'     => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::find($request->user_id);

        if ($user->phone_sms_otp != $request->otp) {
            return $this->sendError('Invalid OTP code', 400);
        }

        return $this->sendSuccess('OTP verified successfully');
    }

    /**
     * Reset the password after OTP verification.
     * POST /api/password/reset
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone'    => 'required|string|min:10|max:11',
            'otp'      => 'required',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $user = User::where('MOP', $request->phone)->first();

        if (!$user) {
            return $this->sendError('User not found', 404);
        }

        if ($user->phone_sms_otp != $request->otp) {
            return $this->sendError('Invalid OTP code', 400);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return $this->sendSuccess('Password reset successfully');
    }
}

