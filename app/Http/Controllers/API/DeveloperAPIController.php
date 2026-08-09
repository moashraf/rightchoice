<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeveloperAPIController extends AppBaseController
{
    /**
     * GET /api/developers
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'keywords' => 'nullable|string|max:150',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $keywords = trim((string) $request->input('keywords', ''));

        $query = User::query()
            ->select([
                'id',
                'name',
                'email',
                'MOP',
                'TYPE',
                'status',
                'Job_title',
                'Commercial_Register',
                'name_of_real_estate_developer',
                'profile_image',
                'created_at',
            ])
            ->where('TYPE', 3)
            ->where('status', 1)
            ->withCount([
                'aqars as aqars_count' => function ($query) {
                    $query->where('status', 1);
                },
            ])
            ->whereHas('aqars', function ($query) {
                $query->where('status', 1);
            });

        if ($keywords !== '') {
            $query->where(function ($query) use ($keywords) {
                $query->where('name', 'like', '%' . $keywords . '%')
                    ->orWhere('name_of_real_estate_developer', 'like', '%' . $keywords . '%')
                    ->orWhere('Commercial_Register', 'like', '%' . $keywords . '%')
                    ->orWhere('email', 'like', '%' . $keywords . '%');
            });
        }

        $developers = $query
            ->orderByDesc('aqars_count')
            ->orderByDesc('id')
            ->paginate((int) $request->input('per_page', 12))
            ->appends($request->query());

        return $this->sendResponse(
            $developers->toArray(),
            'تم استرجاع قائمة المطورين العقاريين بنجاح.'
        );
    }

    /**
     * GET /api/developers/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'keywords' => 'nullable|string|max:150',
            'per_page' => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $developer = User::query()
            ->select([
                'id',
                'name',
                'email',
                'MOP',
                'TYPE',
                'status',
                'Job_title',
                'Commercial_Register',
                'name_of_real_estate_developer',
                'profile_image',
                'created_at',
            ])
            ->where('id', $id)
            ->where('TYPE', 3)
            ->where('status', 1)
            ->first();

        if (!$developer) {
            return $this->sendError('المطور العقاري غير موجود.', 404);
        }

        $developer->loadCount([
            'aqars as aqars_count' => function ($query) {
                $query->where('status', 1);
            },
        ]);

        $keywords = trim((string) $request->input('keywords', ''));

        $aqarsQuery = $developer->aqars()
            ->where('status', 1)
            ->with([
                'mainImage',
                'firstImage',
                'governrateq',
                'districte',
                'subAreaa',
                'offerTypes',
                'propertyType',
            ]);

        if ($keywords !== '') {
            $aqarsQuery->where(function ($query) use ($keywords) {
                $query->where('title', 'like', '%' . $keywords . '%')
                    ->orWhere('slug', 'like', '%' . $keywords . '%')
                    ->orWhere('description', 'like', '%' . $keywords . '%');
            });
        }

        $aqars = $aqarsQuery
            ->latest('id')
            ->paginate((int) $request->input('per_page', 9))
            ->appends($request->query());

        return $this->sendResponse([
            'developer' => $developer->toArray(),
            'aqars' => $aqars->toArray(),
        ], 'تم استرجاع تفاصيل المطور العقاري بنجاح.');
    }
}
