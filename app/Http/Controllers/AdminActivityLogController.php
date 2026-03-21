<?php

namespace App\Http\Controllers;

use App\DataTables\AdminActivityLogDataTable;
use App\Models\ActivityLog;
use Flash;

class AdminActivityLogController extends AppBaseController
{
    /**
     * Display a listing of activity logs.
     */
    public function index(AdminActivityLogDataTable $dataTable)
    {
        return $dataTable->render('admin_activity_logs.index');
    }

    /**
     * Display a single activity log with full details.
     */
    public function show($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        return view('admin_activity_logs.show', compact('activityLog'));
    }

    /**
     * Remove a single activity log.
     */
    public function destroy($id)
    {
        $activityLog = ActivityLog::findOrFail($id);
        $activityLog->delete();

        Flash::success('تم حذف السجل بنجاح.');

        return redirect(route('sitemanagement.activityLogs.index'));
    }

    /**
     * Clear all activity logs.
     */
    public function clearAll()
    {
        ActivityLog::truncate();

        Flash::success('تم مسح جميع سجلات النشاطات بنجاح.');

        return redirect(route('sitemanagement.activityLogs.index'));
    }
}
