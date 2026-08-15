<?php

namespace App\Http\Controllers;

use App\Models\UserPriceing;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AdminPrizeDrawController extends Controller
{
    /**
     * Display the spinning wheel with the currently eligible subscribers.
     */
    public function index(): View
    {
        $participants = $this->eligibleSubscriptions()
            ->map(function (UserPriceing $subscription) {
                return [
                    'id' => (int) $subscription->user_id,
                    'name' => $subscription->user->name ?: 'مستخدم #' . $subscription->user_id,
                    'package' => trim(strip_tags((string) $subscription->pricing->type)),
                ];
            })
            ->values();

        return view('admin_prize_draw.index', compact('participants'));
    }

    /**
     * Select one eligible paid subscriber with equal probability per user.
     *
     * The selection happens on the server. The browser only animates the
     * wheel to the winner returned by this endpoint.
     */
    public function draw(): JsonResponse
    {
        $eligibleSubscriptions = $this->eligibleSubscriptions();

        if ($eligibleSubscriptions->isEmpty()) {
            return response()->json([
                'message' => 'لا يوجد مستخدمون مشتركون في باقات مدفوعة ومفعلة حالياً.',
            ], 422);
        }

        $winnerIndex = random_int(0, $eligibleSubscriptions->count() - 1);
        /** @var UserPriceing $winnerSubscription */
        $winnerSubscription = $eligibleSubscriptions->get($winnerIndex);

        Log::info('Paid subscriber prize draw winner selected', [
            'winner_user_id' => $winnerSubscription->user_id,
            'pricing_id' => $winnerSubscription->pricing_id,
            'eligible_users_count' => $eligibleSubscriptions->count(),
            'admin_id' => Auth::guard('admin')->id(),
        ]);

        return response()->json([
            'winner' => [
                'id' => (int) $winnerSubscription->user_id,
                'name' => $winnerSubscription->user->name ?: 'مستخدم #' . $winnerSubscription->user_id,
                'package' => trim(strip_tags((string) $winnerSubscription->pricing->type)),
            ],
            'eligible_count' => $eligibleSubscriptions->count(),
        ]);
    }

    /**
     * Return one active paid subscription per eligible user.
     *
     * The free starter package (price = 0) is intentionally excluded so the
     * prize draw rewards users who actually subscribed to a paid package.
     */
    private function eligibleSubscriptions(): Collection
    {
        return UserPriceing::query()
            ->with([
                'user:id,name,TYPE',
                'pricing:id,type,price',
            ])
            ->where('statues', 1)
            ->whereHas('pricing', function ($query) {
                $query->where('price', '>', 0);
            })
            ->whereHas('user', function ($query) {
                $query->where(function ($userQuery) {
                    $userQuery->whereNull('TYPE')->orWhere('TYPE', '!=', 4);
                });
            })
            ->orderByDesc('id')
            ->get()
            ->unique('user_id')
            ->values();
    }
}
