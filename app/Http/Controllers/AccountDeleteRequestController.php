<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountDeleteRequest;
use Illuminate\Support\Facades\Auth;

class AccountDeleteRequestController extends Controller
{
    /**
     * Store a new account delete request from the authenticated user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|min:10|max:1000',
        ], [
            'reason.required' => 'يجب كتابة سبب طلب حذف الحساب.',
            'reason.min'      => 'يجب أن يكون السبب 10 أحرف على الأقل.',
            'reason.max'      => 'لا يمكن أن يتجاوز السبب 1000 حرف.',
        ]);

        $user = Auth::user();

        // Check if user already has a pending request
        $existing = AccountDeleteRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()->with('delete_request_error', 'لديك بالفعل طلب حذف قيد الانتظار، يرجى الانتظار حتى يتم مراجعته.');
        }

        AccountDeleteRequest::create([
            'user_id' => auth()->id(),
            'reason'  => $request->reason,
            'status'  => 'pending',
        ]);

        return redirect()->back()->with('delete_request_success', 'تم إرسال طلب حذف الحساب بنجاح. سيتم مراجعته من قبل الإدارة.');
    }
}
