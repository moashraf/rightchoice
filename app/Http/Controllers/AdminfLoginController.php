<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller for admin-specific login.
 * Separates admin authentication from regular user login.
 */
class AdminfLoginController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function adminfShowLoginForm()
    {
        if (Auth::check() && Auth::user()->isAdmin) {
            return redirect()->route('admin.blogs.index');
        }

        return view('admin_auth.login');
    }

    /**
     * Handle admin login attempt.
     */
    public function adminfLogin(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        // Find the user first to check if they are admin
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'User not found.',
            ])->withInput($request->only('email'));
        }

        if (!$user->isAdmin) {
            return back()->withErrors([
                'email' => 'This account does not have admin access.',
            ])->withInput($request->only('email'));
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/blogs');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    /**
     * Handle admin logout.
     */
    public function adminfLogout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
