<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AqarDeleteReason;
use Illuminate\Support\Facades\Storage;
use Laracasts\Flash\Flash;

class AdminAqarDeleteReasonController extends Controller
{
    public function index()
    {
        $reasons = AqarDeleteReason::latest()->paginate(20);
        return view('admin_aqar_delete_reasons.index', compact('reasons'));
    }

    public function create()
    {
        return view('admin_aqar_delete_reasons.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image'    => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title_ar', 'title_en');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('delete_reasons', 'public');
        }

        AqarDeleteReason::create($data);

        Flash::success('تم إضافة السبب بنجاح.');
        return redirect()->route('sitemanagement.aqar-delete-reasons.index');
    }

    public function edit(AqarDeleteReason $aqarDeleteReason)
    {
        return view('admin_aqar_delete_reasons.edit', compact('aqarDeleteReason'));
    }

    public function update(Request $request, AqarDeleteReason $aqarDeleteReason)
    {
        $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image'    => 'nullable|image|max:2048',
        ]);

        $data = $request->only('title_ar', 'title_en');

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($aqarDeleteReason->image) {
                Storage::disk('public')->delete($aqarDeleteReason->image);
            }
            $data['image'] = $request->file('image')->store('delete_reasons', 'public');
        }

        $aqarDeleteReason->update($data);

        Flash::success('تم تحديث السبب بنجاح.');
        return redirect()->route('sitemanagement.aqar-delete-reasons.index');
    }

    public function destroy(AqarDeleteReason $aqarDeleteReason)
    {
        if ($aqarDeleteReason->image) {
            Storage::disk('public')->delete($aqarDeleteReason->image);
        }
        $aqarDeleteReason->delete();

        Flash::success('تم حذف السبب بنجاح.');
        return redirect()->route('sitemanagement.aqar-delete-reasons.index');
    }
}
