<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

/**
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ], 200);
    }

    public function sendError($error, $code = 404): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $error,
        ], $code);
    }

    public function sendSuccess($message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }
}
