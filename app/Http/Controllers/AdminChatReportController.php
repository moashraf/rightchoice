<?php

namespace App\Http\Controllers;

use App\Services\Chat\ReportService;
use App\Services\Chat\BlockService;
use Illuminate\Http\Request;

class AdminChatReportController extends Controller
{
    protected ReportService $reportService;
    protected BlockService $blockService;

    public function __construct(ReportService $reportService, BlockService $blockService)
    {
        $this->reportService = $reportService;
        $this->blockService = $blockService;
    }

    /**
     * Show all reports (admin).
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $reports = $this->reportService->getReports($status, 20);

        // Enrich with user data
        $reports->getCollection()->each(function ($report) {
            $report->reporter = \App\Models\User::find($report->reporter_id);
            $report->reported = \App\Models\User::find($report->reported_id);
        });

        $pendingCount = $this->reportService->getPendingCount();

        return view('admin_chat_reports.index', compact('reports', 'status', 'pendingCount'));
    }

    /**
     * Show single report details.
     */
    public function show(string $id)
    {
        $report = \App\Models\Chat\Report::findOrFail($id);
        $report->reporter = \App\Models\User::find($report->reporter_id);
        $report->reported = \App\Models\User::find($report->reported_id);

        if ($report->reviewed_by) {
            $report->reviewer = \App\Models\User::find($report->reviewed_by);
        }

        return view('admin_chat_reports.show', compact('report'));
    }

    /**
     * Review a report (approve/dismiss).
     */
    public function review(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:reviewed,dismissed',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $admin = auth()->guard('admin')->user() ?? auth()->user();

        $this->reportService->reviewReport(
            $id,
            $admin->id,
            $request->status,
            $request->admin_notes
        );

        return redirect()->route('sitemanagement.chatReports.index')
            ->with('success', 'تم مراجعة البلاغ بنجاح');
    }

    /**
     * Block user from admin (after reviewing report).
     */
    public function blockUser(Request $request, string $reportId)
    {
        $report = \App\Models\Chat\Report::findOrFail($reportId);

        try {
            $this->blockService->blockUser(0, $report->reported_id, 'تم الحظر بواسطة الإدارة - بلاغ #' . $reportId);
        } catch (\Exception $e) {
            // User may already be blocked
        }

        // Mark user status as blocked in MySQL
        $user = \App\Models\User::find($report->reported_id);
        if ($user) {
            $user->update(['status' => 0]);
        }

        return redirect()->route('sitemanagement.chatReports.show', $reportId)
            ->with('success', 'تم حظر المستخدم بنجاح');
    }
}
