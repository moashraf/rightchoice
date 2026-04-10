<?php

namespace App\Http\Controllers\API;

use App\Models\AccountDeleteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Account Delete Request API Controller.
 */
class AccountDeleteAPIController extends AppBaseController
{
    /**
     * POST /api/account/delete-request
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|min:10|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $userId = $request->user()->id;

        $existing = AccountDeleteRequest::where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return $this->sendError('You already have a pending delete request', 400);
        }

        AccountDeleteRequest::create([
            'user_id' => $userId,
            'reason'  => $request->reason,
            'status'  => 'pending',
        ]);

        return $this->sendSuccess('Account delete request submitted successfully');
    }

    /**
     * GET /api/account/delete-request/status
     */
    public function status(Request $request): JsonResponse
    {
        $deleteRequest = AccountDeleteRequest::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        if (!$deleteRequest) {
            return $this->sendResponse(['has_request' => false], 'No delete request found');
        }

        return $this->sendResponse([
            'has_request' => true,
            'status'      => $deleteRequest->status,
            'reason'      => $deleteRequest->reason,
            'created_at'  => $deleteRequest->created_at->toDateTimeString(),
        ], 'Delete request status retrieved');
    }
}

