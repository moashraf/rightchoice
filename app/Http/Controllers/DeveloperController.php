<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DeveloperController extends Controller
{
    /**
     * عرض كل المطورين العقاريين (TYPE = 3) مع بحث.
     */
    public function index(Request $request, $locale = null)
    {
        $q = trim((string) $request->input('keywords'));

        $developers = User::query()
            ->where('TYPE', 3)
            ->where('status', 1)
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                      ->orWhere('Employee_Name', 'like', "%{$q}%")
                      ->orWhere('Commercial_Register', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })

            ->orderByDesc('id')
            ->paginate(12)
            ->appends($request->except('page'));

        return view('developers.index', [
            'developers' => $developers,
            'q'          => $q,
        ]);
    }

    /**
     * عرض صفحة مطور واحد + عقاراته مع بحث داخل عقاراته.
     */
    public function show(Request $request, $locale, $id)
    {
        $user = User::where('id', $id)
            ->where('TYPE', 3)
            ->where('status', 1)
            ->firstOrFail();

        $q = trim((string) $request->input('keywords'));

        $allAqars = $user->aqars()
            ->where('status', 1)
            ->with(['mainImage', 'firstImage', 'governrateq', 'districte', 'offerTypes'])
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where(function ($w) use ($q) {
                    $w->where('title', 'like', "%{$q}%")
                      ->orWhere('slug', 'like', "%{$q}%")
                      ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->appends($request->except('page'));

        return view('developers.show', [
            'user'     => $user,
            'allAqars' => $allAqars,
            'q'        => $q,
        ]);
    }
}

