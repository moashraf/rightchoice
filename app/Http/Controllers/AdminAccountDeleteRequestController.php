<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountDeleteRequest;
use App\Models\User;

class AdminAccountDeleteRequestController extends Controller
{
    /**
     * Display all account delete requests.
     */
    public function index(Request $request)
    {
        $query = AccountDeleteRequest::with(['user', 'user' => function($q){
            $q->withTrashed(); // show soft-deleted users too
        }])->latest();

        if ($request->filter_status) {
            $query->where('status', $request->filter_status);
        }

        if ($request->search_key) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->withTrashed()
                  ->where('name', 'like', '%' . $request->search_key . '%')
                  ->orWhere('MOP', 'like', '%' . $request->search_key . '%');
            });
        }

        $deleteRequests = $query->paginate($request->show ?? 10);

        return view('admin_account_delete_requests.index', compact('deleteRequests'));
    }

    /**
     * Approve a delete request (soft delete the user).
     */
    public function approve(Request $request, $id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);

        $deleteRequest->update([
            'status'     => 'approved',
            'admin_note' => $request->admin_note ?? null,
        ]);

        // Soft delete the user account
        $user = User::find($deleteRequest->user_id);
        if ($user) {
            $user->delete(); // SoftDeletes trait => sets deleted_at
        }

        flash('تم قبول طلب الحذف وتم تعطيل الحساب بنجاح (Soft Delete).')->success();

        return redirect(route('sitemanagement.accountDeleteRequests.index'));
    }

    /**
     * Restore a soft-deleted user (undo approve).
     */
    public function restore($id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);

        $user = User::withTrashed()->find($deleteRequest->user_id);
        if ($user && $user->trashed()) {
            $user->restore();
        }

        $deleteRequest->update([
            'status'     => 'rejected',
            'admin_note' => 'تم استعادة الحساب بواسطة الأدمن.',
        ]);

        flash('تم استعادة حساب المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.accountDeleteRequests.index'));
    }

    /**
     * Reject a delete request.
     */
    public function reject(Request $request, $id)
    {
        $deleteRequest = AccountDeleteRequest::findOrFail($id);

        $request->validate([
            'admin_note' => 'required|string|min:3|max:500',
        ], [
            'admin_note.required' => 'يجب كتابة سبب الرفض.',
        ]);

        $deleteRequest->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        flash('تم رفض طلب الحذف.')->success();

        return redirect(route('sitemanagement.accountDeleteRequests.index'));
    }
}
