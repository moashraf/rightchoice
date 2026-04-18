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
            'reported_type'       => 'required|string|in:user,post,comment,aqar',
            'reported_content_id' => 'nullable|string',
            'reason'              => 'required|string|max:500',
            'details'             => 'nullable|string|max:2000',
        ], [
            'reported_id.required'   => 'حقل معرف المُبلَّغ عنه مطلوب.',
            'reported_id.integer'    => 'معرف المُبلَّغ عنه يجب أن يكون رقمًا صحيحًا.',
            'reported_type.required' => 'حقل نوع البلاغ مطلوب.',
            'reported_type.in'       => 'نوع البلاغ يجب أن يكون: user أو post أو comment أو aqar.',
            'reason.required'        => 'حقل سبب البلاغ مطلوب.',
            'reason.string'          => 'سبب البلاغ يجب أن يكون نصاً.',
            'reason.max'             => 'سبب البلاغ يجب ألا يتجاوز 500 حرف.',
            'details.string'         => 'تفاصيل البلاغ يجب أن تكون نصاً.',
            'details.max'            => 'تفاصيل البلاغ يجب ألا تتجاوز 2000 حرف.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
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

