<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicySection;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $sections = PrivacyPolicySection::query()
            ->active()
            ->ordered()
            ->get();

        return view('privacy-policy', compact('sections'));
    }
}
