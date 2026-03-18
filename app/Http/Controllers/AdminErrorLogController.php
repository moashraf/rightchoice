<?php

namespace App\Http\Controllers;

use App\DataTables\AdminErrorLogDataTable;
use App\Models\ErrorLog;
use Flash;

class AdminErrorLogController extends AppBaseController
{
    /**
     * Display a listing of error logs.
     */
    public function index(AdminErrorLogDataTable $dataTable)
    {
        return $dataTable->render('admin_error_logs.index');
    }

    /**
     * Display a single error log with full trace.
     */
    public function show($id)
    {
        $errorLog = ErrorLog::findOrFail($id);
        return view('admin_error_logs.show', compact('errorLog'));
    }

    /**
     * Remove a single error log.
     */
    public function destroy($id)
    {
        $errorLog = ErrorLog::findOrFail($id);
        $errorLog->delete();

        Flash::success('تم حذف الخطأ بنجاح.');

        return redirect(route('sitemanagement.errorLogs.index'));
    }

    /**
     * Clear all error logs.
     */
    public function clearAll()
    {
        ErrorLog::truncate();

        Flash::success('تم مسح جميع الأخطاء بنجاح.');

        return redirect(route('sitemanagement.errorLogs.index'));
    }
}
