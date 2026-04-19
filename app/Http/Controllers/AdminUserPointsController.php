<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserPriceing;

class AdminUserPointsController extends Controller
{
    /**
     * GET  sitemanagement/users/{user}/get-points
     * جلب أحدث نقاط المستخدم من قاعدة البيانات (AJAX)
     */
    public function getPoints($user)
    {
        $userModel = User::findOrFail($user);
        $record    = UserPriceing::where('user_id', $userModel->id)->latest()->first();

        return response()->json([
            'success'        => true,
            'current_points' => $record ? $record->current_points : 0,
            'start_points'   => $record ? $record->start_points   : 0,
            'sub_points'     => $record ? $record->sub_points      : 0,
            'user_name'      => $userModel->name,
        ]);
    }

    /**
     * POST  sitemanagement/users/{user}/add-points
     * إضافة نقاط إضافية للمستخدم (AJAX)
     */
    public function addPoints(Request $request, $user)
    {
        $request->validate([
            'extra_points' => 'required|integer|min:1',
        ]);

        $userModel = User::findOrFail($user);
        $record    = UserPriceing::where('user_id', $userModel->id)->latest()->first();

        if ($record) {
            $record->current_points += (int) $request->extra_points;
            $record->start_points   += (int) $request->extra_points;
            $record->save();
            $newPoints = $record->current_points;
        } else {
            $newPoints = (int) $request->extra_points;
            UserPriceing::create([
                'user_id'        => $userModel->id,
                'pricing_id'     => 2,
                'start_points'   => $newPoints,
                'current_points' => $newPoints,
                'sub_points'     => 0,
                'statues'        => 1,
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => 'تم إضافة النقاط بنجاح',
                'new_points' => $newPoints,
            ]);
        }

        flash('تم إضافة النقاط بنجاح.')->success();
        return redirect()->back();
    }
}

