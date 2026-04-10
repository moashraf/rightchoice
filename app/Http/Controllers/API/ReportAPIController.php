<?php

namespace App\Http\Controllers\API;

use App\Services\Chat\ReportService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * Report API Controller.
 */
class ReportAPIController extends AppBaseController
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * POST /api/report
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'reported_id'         => 'required|integer',
            'reported_type'       => 'required|string',
            'reported_content_id' => 'nullable|string',
            'reason'              => 'required|string|max:500',
            'details'             => 'nullable|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        try {
            $this->reportService->reportUser(
                $request->user()->id,
                (int) $request->reported_id,
                $request->reported_type,
                $request->reported_content_id,
                $request->reason,
                $request->details
            );

            return $this->sendSuccess('Report submitted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 422);
        }
    }
}

