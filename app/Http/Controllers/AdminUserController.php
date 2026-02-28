<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserPriceing;
use App\Exports\LastUsersExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query();

        if ($request->sortBy == 0)
            $users->orderBy('id', 'DESC');
        else
            $users->orderBy('id', 'ASC');

        if ($request->search_key)
            $users->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_key . '%')
                  ->orWhere('MOP', 'like', '%' . $request->search_key . '%')
                  ->orWhere('invited_by', 'like', '%' . $request->search_key . '%');
            });

        if ($request->filter_status != null)
            $users->where('status', $request->filter_status);

        if ($request->filter_type)
            $users->where('TYPE', $request->filter_type);

        $users = $users->paginate($request->show ?? 10);

        return view('admin_users.index', compact('users'));
    }

    public function create()
    {
        return view('admin_users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|min:3|max:90',
            'email'    => 'required|email|max:90|unique:users',
            'MOP'      => 'required|min:10|max:11|unique:users',
            'password' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        // upload profile image
        if ($request->has('img') && !is_null($request->img)) {
            $request->merge(['profile_image' => _uploadFileWeb($request->img, 'user/')]);
        }

        $request->merge(['phone_sms_otp' => 123456]);
        $request->merge(['password' => bcrypt($request->password)]);

        User::create($request->all());

        flash('تم حفظ المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.users.index'));
    }

    public function show($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        return view('admin_users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $all_point_of_user = UserPriceing::where('user_id', '=', $user->id)->latest()->first();

        return view('admin_users.edit', compact('user', 'all_point_of_user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $all_point_of_user = UserPriceing::where('user_id', '=', $user->id)->latest()->first();

        if ($request->current_points > 1) {
            if ($all_point_of_user == null) {
                $object = new UserPriceing;
                $object->start_points   = $request->current_points;
                $object->current_points = $request->current_points;
                $object->pricing_id     = 2;
                $object->user_id        = $user->id;
                $object->sub_points     = 0;
                $object->save();
            } else {
                $all_point_of_user->start_points   = $request->current_points;
                $all_point_of_user->current_points = $request->current_points;
                $all_point_of_user->sub_points     = 0;
                $all_point_of_user->save();
            }
        }

        $user->phone_verfied_sms_status = $request->phone_verfied_sms_status;
        $user->save();

        $user->update($request->except(['_token', '_method', 'current_points']));

        flash('تم تحديث المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.users.index'));
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $user->delete();

        flash('تم حذف المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.users.index'));
    }

    public function block($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 2]);

        flash('تم حظر المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.users.index'));
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);

        if ($user->status != 2) {
            flash('لا يمكن تفعيل المستخدم لانه لم يدخل الرساله.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $user->update(['status' => 1]);

        flash('تم تفعيل المستخدم بنجاح.')->success();

        return redirect(route('sitemanagement.users.index'));
    }

    public function aqars($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $aqars = $user->aqars;

        return view('admin_users.aqars', compact('user', 'aqars'));
    }

    public function contactForms($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $contactForms = \App\Models\UserContactAqar::where('user_id', $user->id)
            ->with('all_aqat_viw')
            ->get();

        return view('admin_users.contact_forms', compact('user', 'contactForms'));
    }

    public function packages($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            flash('المستخدم غير موجود.')->error();
            return redirect(route('sitemanagement.users.index'));
        }

        $packages = UserPriceing::where('user_id', $user->id)
            ->with('pricing')
            ->get();

        return view('admin_users.packages', compact('user', 'packages'));
    }

    public function exportUsers(Request $request)
    {
        $filters = $request->only(['search_key', 'filter_status', 'filter_type', 'sortBy']);
        $filename = 'users_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new LastUsersExport($filters), $filename);
    }
}
