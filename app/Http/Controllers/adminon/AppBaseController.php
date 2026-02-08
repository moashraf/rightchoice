<?php

namespace App\Http\Controllers;

/**
 * @SWG\Swagger(
 *   basePath="/api/v1",
 *   @SWG\Info(
 *     title="Laravel Generator APIs",
 *     version="1.0.0",
 *   )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    public function sendResponse($result, $message)
    {
        return response()->json([
            'success' => true,
            'data' => $result,
            'message' => $message
        ], 200);
    }

    public function sendError($error, $code = 404)
    {
        return response()->json([
            'success' => false,
            'message' => $error
        ], $code);
    }

    public function sendSuccess($message)
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
