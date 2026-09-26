<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicUserProfileController extends Controller
{
    public function show($locale, int $id)
    {
        $user = $this->findUser($id);
        $properties = $this->properties($user)->paginate(12);

        return view('users.public-profile', compact('user', 'properties'));
    }

    public function apiShow(Request $request, int $id): JsonResponse
    {
        $user = $this->findUser($id);
        $properties = $this->properties($user)
            ->paginate(min(50, max(1, (int) $request->query('per_page', 12))));

        return response()->json([
            'success' => true,
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'profile_url' => route('users.public.show', ['locale' => 'ar', 'id' => $user->id]),
                    'profile_image_url' => $user->profile_image
                        ? url('/images/' . $user->profile_image)
                        : url('/images/default-avatar.png'),
                ],
                'properties' => $properties->through(fn ($property) => [
                    'id' => $property->id,
                    'title' => $property->title,
                    'slug' => $property->slug,
                    'image_url' => $property->mainImage || $property->firstImage
                        ? url('/images/' . ($property->mainImage ?? $property->firstImage)->img_url)
                        : asset('images/FBO.png'),
                    'url' => url('/ar/aqars/' . $property->slug),
                    'total_price' => $property->total_price,
                    'monthly_rent' => $property->monthly_rent,
                    'offer_type' => $property->offerTypes?->type_offer,
                ])->toArray(),
            ],
            'message' => 'تم استرجاع الملف الشخصي والعقارات المنشورة بنجاح.',
        ]);
    }

    private function findUser(int $id): User
    {
        return User::query()->whereKey($id)
            ->whereIn('TYPE', [1, 2])
            ->where('status', 1)
            ->firstOrFail();
    }

    private function properties(User $user)
    {
        return $user->aqars()->where('status', 1)
            ->with(['mainImage', 'firstImage', 'offerTypes'])
            ->orderByDesc('display_priority')->latest('id');
    }
}
