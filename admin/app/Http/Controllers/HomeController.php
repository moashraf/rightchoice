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
    public function index()
    {
        $stats = [
            'aqars'        => aqar::count(),
            'users'        => User::count(),
            'complaints'   => Complaints::count(),
            'companies'    => Company::count(),
            'contactForms' => ContactForm::count(),
        ];

        return view('home', compact('stats'));
    }

    public function logout()
    {

        Auth::logout();
        return redirect()->route('login');

    }
}
