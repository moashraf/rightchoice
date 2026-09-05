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
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'details' => ['required', 'string'],
            'sort_order' => ['required', 'integer', 'min:1', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $privacyPolicySection->update($validated);

        return redirect()
            ->route('sitemanagement.privacy-policy-sections.index')
            ->with('success', 'تم تحديث عنصر سياسة الخصوصية بنجاح.');
    }
}
