<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicySection;
use Illuminate\Http\Request;

class AdminPrivacyPolicySectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminfCheckAdmin');
    }

    public function index()
    {
        $sections = PrivacyPolicySection::query()
            ->ordered()
            ->get();

        return view('admin_privacy_policy_sections.index', compact('sections'));
    }

    public function edit(PrivacyPolicySection $privacyPolicySection)
    {
        return view('admin_privacy_policy_sections.edit', compact('privacyPolicySection'));
    }

    public function update(Request $request, PrivacyPolicySection $privacyPolicySection)
    {
        $validated = $request->validate([
            'title_ar' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'subtitle_ar' => ['nullable', 'string', 'max:500'],
            'subtitle_en' => ['nullable', 'string', 'max:500'],
            'details_ar' => ['required', 'string'],
            'details_en' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $privacyPolicySection->update($validated);

        return redirect()
            ->route('sitemanagement.privacy-policy-sections.index')
            ->with('success', 'تم تحديث محتوى سياسة الخصوصية بالعربي والإنجليزي بنجاح.');
    }
}
