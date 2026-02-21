<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\aqar;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Company;
use App\Models\ContactForm;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');

        $filter = function ($query) use ($fromDate, $toDate) {
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }
        };

        $stats = [
            'aqars'        => aqar::when($fromDate || $toDate, $filter)->count(),
            'users'        => User::when($fromDate || $toDate, $filter)->count(),
            'complaints'   => Complaints::when($fromDate || $toDate, $filter)->count(),
            'companies'    => Company::when($fromDate || $toDate, $filter)->count(),
            'contactForms' => ContactForm::when($fromDate || $toDate, $filter)->count(),
        ];

        return view('home', compact('stats', 'fromDate', 'toDate'));
    }

    public function logout()
    {

        Auth::logout();
        return redirect()->route('login');

    }
}
