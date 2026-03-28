<?php

namespace App\Services\Chat;

use App\Models\Chat\Report;

class ReportService
{
    public function reportUser(
        int $reporterId,
        int $reportedId,
        string $type,
        ?string $contentId,
        string $reason,
        ?string $details
    ): Report {
        if ($reporterId === $reportedId) {
            throw new \Exception('لا يمكنك الإبلاغ عن نفسك');
        }

        return Report::create([
            'reporter_id' => $reporterId,
            'reported_id' => $reportedId,
            'reported_type' => $type,
            'reported_content_id' => $contentId,
            'reason' => $reason,
            'details' => $details,
            'status' => 'pending',
        ]);
    }

    public function getReports(string $status = 'pending', int $perPage = 20)
    {
        $query = Report::query();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function reviewReport(string $reportId, int $adminId, string $status, ?string $notes): Report
    {
        $report = Report::findOrFail($reportId);

        $report->update([
            'status' => $status,
            'admin_notes' => $notes,
            'reviewed_by' => $adminId,
            'reviewed_at' => now()->toISOString(),
        ]);

        return $report;
    }

    public function getPendingCount(): int
    {
        return Report::where('status', 'pending')->count();
    }
}
