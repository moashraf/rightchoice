<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Response;

/**
 * Class AuthAPIController
 * @package App\Http\Controllers\API
 */

class AuthAPIController extends AppBaseController
{
    /**
     * Login user and create token
     * POST /login
     *
     * @param Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return $this->sendError('Invalid credentials', 401);
        }

        // Check if user is active
        if ($user->status != 1) {
            return $this->sendError('Your account is inactive', 403);
        }

        // Create token - using simple token generation
        $token = base64_encode(random_bytes(32));

        $result = [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->MOP,
                'type' => $user->TYPE,
                'isAdmin' => $user->isAdmin,
                'status' => $user->status,
            ],
            'token' => $token,
        ];

        return $this->sendResponse($result, 'User logged in successfully');
    }

    /**
     * Logout user
     * POST /logout
     *
     * @param Request $request
     *
     * @return Response
     */
    public function logout(Request $request)
    {
        // Handle logout logic here if needed
        return $this->sendSuccess('User logged out successfully');
    }
}
