<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chat\ReportRequest;
use App\Services\Chat\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected ReportService $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Submit a report.
     */
    public function store(ReportRequest $request)
    {
        $user = auth()->user();

        try {
            $this->reportService->reportUser(
                $user->id,
                (int) $request->reported_id,
                $request->reported_type,
                $request->reported_content_id,
                $request->reason,
                $request->details
            );

            return response()->json([
                'success' => true,
                'message' => trans('langsite.report_submitted'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 422);
        }
    }
}
