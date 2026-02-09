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
        $now = Carbon::now()->format('Y-m-d_H-i');
        $fileName = "users_last_1000_{$now}.xlsx";
        return Excel::download(new LastUsersExport, $fileName);
    }
}
