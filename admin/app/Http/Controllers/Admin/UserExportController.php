<?php

namespace App\Http\Controllers\Admin;

use App\Exports\LastUsersExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class UserExportController extends Controller
{
    public function __construct()
    {
       // $this->middleware(['auth', 'can:export-users']);
    }

    public function exportLast1000(Request $request)
    {
        $filters = [
            'search_key'    => $request->input('search_key'),
            'filter_status' => $request->input('filter_status'),
            'filter_type'   => $request->input('filter_type'),
            'sortBy'        => $request->input('sortBy'),
        ];

        $now      = Carbon::now()->format('Y-m-d_H-i');
        $fileName = "users_export_{$now}.xlsx";

        return Excel::download(new LastUsersExport($filters), $fileName);
    }
}
