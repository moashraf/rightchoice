<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\IpGeoLocationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminOnlineUsersController extends AppBaseController
{
    public function __construct(private IpGeoLocationService $geo)
    {
        $this->middleware('adminfCheckAdmin');
    }

    /**
     * Display currently online users from the website (sessions) and the app (API tokens).
     */
    public function index()
    {
        $sessionLifetime = (int) config('session.lifetime', 120);
        $cutoff = Carbon::now()->subMinutes($sessionLifetime);
        $cutoffTs = $cutoff->timestamp;

        $webSessions = DB::table('sessions')
            ->where('last_activity', '>=', $cutoffTs)
            ->whereNotNull('user_id')
            ->orderBy('last_activity', 'desc')
            ->get();

        $apiTokens = collect();
        if (Schema::hasTable('personal_access_tokens')) {
            $tokenQuery = DB::table('personal_access_tokens')
                ->where('tokenable_type', User::class)
                ->where(function ($q) use ($cutoff) {
                    $q->where('last_used_at', '>=', $cutoff)
                        ->orWhere(function ($q2) use ($cutoff) {
                            $q2->whereNull('last_used_at')
                                ->where('created_at', '>=', $cutoff);
                        });
                })
                ->orderByDesc('last_used_at');

            $apiTokens = $tokenQuery->get();
        }

        $userIds = $webSessions->pluck('user_id')
            ->merge($apiTokens->pluck('tokenable_id'))
            ->unique()
            ->filter()
            ->values();

        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        $ips = $webSessions->pluck('ip_address')
            ->merge($apiTokens->pluck('ip_address'))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $locations = $this->geo->lookupMany($ips);

        $groupedWeb = $webSessions->groupBy('user_id');
        $groupedApi = $apiTokens->groupBy('tokenable_id');

        $onlineUsers = $userIds->map(function ($userId) use ($users, $groupedWeb, $groupedApi, $locations) {
            $user = $users->get($userId);
            if (!$user) {
                return null;
            }

            $sessions = $groupedWeb->get($userId, collect());
            $tokens = $groupedApi->get($userId, collect());

            $latestWeb = $sessions->first();
            $latestApi = $tokens->sortByDesc(function ($token) {
                return $token->last_used_at ?: $token->created_at;
            })->first();

            $webActivity = $latestWeb ? Carbon::createFromTimestamp($latestWeb->last_activity) : null;
            $apiActivity = $latestApi
                ? Carbon::parse($latestApi->last_used_at ?: $latestApi->created_at)
                : null;

            $lastActivity = collect([$webActivity, $apiActivity])->filter()->sortDesc()->first();

            $sources = [];
            $devices = [];
            $userIps = collect();

            foreach ($sessions as $session) {
                $device = $this->parseUserAgent($session->user_agent ?? '');
                $sources[] = $device->sourceWeb;
                $devices[] = $device->device . ' / ' . $device->os;
                if (!empty($session->ip_address)) {
                    $userIps->push($session->ip_address);
                }
            }

            foreach ($tokens as $token) {
                $device = $this->parseUserAgent($token->user_agent ?? '');
                $sources[] = 'التطبيق';
                $devices[] = $device->device . ' / ' . $device->os;
                if (!empty($token->ip_address)) {
                    $userIps->push($token->ip_address);
                }
            }

            $primaryIp = $userIps->first()
                ?: ($latestWeb?->ip_address)
                ?: ($latestApi?->ip_address);

            $location = $primaryIp ? ($locations[$primaryIp] ?? null) : null;

            return (object) [
                'user_id'       => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'phone'         => $user->MOP ?? '-',
                'ip_address'    => $primaryIp ?: '-',
                'user_agent'    => $latestApi?->user_agent ?: $latestWeb?->user_agent ?: '-',
                'last_activity' => $lastActivity ?? now(),
                'sources'       => collect($sources)->unique()->values()->all(),
                'devices'       => collect($devices)->unique()->values()->all(),
                'location'      => $location,
                'from_app'      => $tokens->isNotEmpty(),
                'from_web'      => $sessions->isNotEmpty(),
                'session_count' => $sessions->count(),
                'token_count'   => $tokens->count(),
                'user'          => $user,
            ];
        })->filter()->sortByDesc('last_activity')->values();

        $totalOnline = $onlineUsers->count();
        $appOnline = $onlineUsers->where('from_app', true)->count();
        $webOnline = $onlineUsers->where('from_web', true)->count();

        $guestSessions = DB::table('sessions')
            ->where('last_activity', '>=', $cutoffTs)
            ->whereNull('user_id')
            ->count();

        return view('admin_online_users.index', compact(
            'onlineUsers',
            'totalOnline',
            'guestSessions',
            'appOnline',
            'webOnline'
        ));
    }

    public function show($userId)
    {
        $user = User::findOrFail($userId);

        $sessionLifetime = (int) config('session.lifetime', 120);
        $cutoff = Carbon::now()->subMinutes($sessionLifetime);
        $cutoffTs = $cutoff->timestamp;

        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->where('last_activity', '>=', $cutoffTs)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                $session->last_activity_carbon = Carbon::createFromTimestamp($session->last_activity);
                $session->device = $this->parseUserAgent($session->user_agent ?? '');
                $session->channel = 'web';
                return $session;
            });

        $apiTokens = collect();
        if (Schema::hasTable('personal_access_tokens')) {
            $apiTokens = DB::table('personal_access_tokens')
                ->where('tokenable_type', User::class)
                ->where('tokenable_id', $userId)
                ->where(function ($q) use ($cutoff) {
                    $q->where('last_used_at', '>=', $cutoff)
                        ->orWhere(function ($q2) use ($cutoff) {
                            $q2->whereNull('last_used_at')
                                ->where('created_at', '>=', $cutoff);
                        });
                })
                ->orderByDesc('last_used_at')
                ->get()
                ->map(function ($token) {
                    $token->last_activity_carbon = Carbon::parse($token->last_used_at ?: $token->created_at);
                    $token->device = $this->parseUserAgent($token->user_agent ?? '');
                    $token->channel = 'api';
                    return $token;
                });
        }

        $allIps = DB::table('sessions')
            ->where('user_id', $userId)
            ->whereNotNull('ip_address')
            ->select('ip_address', DB::raw('MAX(last_activity) as last_seen'), DB::raw('COUNT(*) as session_count'))
            ->groupBy('ip_address')
            ->get();

        if (Schema::hasColumn('personal_access_tokens', 'ip_address')) {
            $tokenIps = DB::table('personal_access_tokens')
                ->where('tokenable_type', User::class)
                ->where('tokenable_id', $userId)
                ->whereNotNull('ip_address')
                ->select('ip_address', DB::raw('UNIX_TIMESTAMP(MAX(COALESCE(last_used_at, created_at))) as last_seen'), DB::raw('COUNT(*) as session_count'))
                ->groupBy('ip_address')
                ->get();

            $allIps = $allIps->concat($tokenIps)
                ->groupBy('ip_address')
                ->map(function ($rows) {
                    return (object) [
                        'ip_address'    => $rows->first()->ip_address,
                        'session_count' => $rows->sum('session_count'),
                        'last_seen'     => $rows->max('last_seen'),
                    ];
                })
                ->values();
        }

        $allIps = $allIps->sortByDesc('last_seen')->values()->map(function ($ip) {
            $ip->last_seen_carbon = Carbon::createFromTimestamp($ip->last_seen);
            return $ip;
        });

        $locations = $this->geo->lookupMany(
            collect($sessions->pluck('ip_address'))
                ->merge($apiTokens->pluck('ip_address'))
                ->merge($allIps->pluck('ip_address'))
                ->filter()
                ->unique()
                ->values()
                ->all()
        );

        $sessions->each(function ($session) use ($locations) {
            $session->location = $locations[$session->ip_address ?? ''] ?? null;
        });
        $apiTokens->each(function ($token) use ($locations) {
            $token->location = $locations[$token->ip_address ?? ''] ?? null;
        });
        $allIps->each(function ($ip) use ($locations) {
            $ip->location = $locations[$ip->ip_address ?? ''] ?? null;
        });

        $recentActivity = DB::table('activity_log')
            ->where('causer_id', $userId)
            ->where('causer_type', 'App\\Models\\User')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        $userIpAddresses = collect($sessions->pluck('ip_address'))
            ->merge($apiTokens->pluck('ip_address'))
            ->filter()
            ->unique()
            ->values();

        $sharedIpUsers = collect();
        if ($userIpAddresses->isNotEmpty()) {
            $sharedSessionUserIds = DB::table('sessions')
                ->whereIn('ip_address', $userIpAddresses)
                ->where('user_id', '!=', $userId)
                ->whereNotNull('user_id')
                ->distinct()
                ->pluck('user_id');

            if (Schema::hasColumn('personal_access_tokens', 'ip_address')) {
                $sharedTokenUserIds = DB::table('personal_access_tokens')
                    ->whereIn('ip_address', $userIpAddresses)
                    ->where('tokenable_id', '!=', $userId)
                    ->where('tokenable_type', User::class)
                    ->distinct()
                    ->pluck('tokenable_id');
                $sharedSessionUserIds = $sharedSessionUserIds->merge($sharedTokenUserIds)->unique();
            }

            if ($sharedSessionUserIds->isNotEmpty()) {
                $sharedIpUsers = User::whereIn('id', $sharedSessionUserIds)->get();
            }
        }

        return view('admin_online_users.show', compact(
            'user',
            'sessions',
            'apiTokens',
            'allIps',
            'recentActivity',
            'sharedIpUsers',
            'userIpAddresses',
            'locations'
        ));
    }

    /**
     * Parse user-agent into device/browser and whether it looks like the mobile app.
     */
    private function parseUserAgent(string $ua): object
    {
        $browser = 'غير معروف';
        $os = 'غير معروف';
        $device = 'كمبيوتر';
        $isApp = false;

        $appHints = ['Dart/', 'Flutter', 'okhttp', 'CFNetwork', 'RightChoice', 'Dalvik/', 'Alamofire'];
        foreach ($appHints as $hint) {
            if (stripos($ua, $hint) !== false) {
                $isApp = true;
                $browser = 'تطبيق الموبايل';
                break;
            }
        }

        if (!$isApp) {
            if (str_contains($ua, 'Edg/')) {
                $browser = 'Microsoft Edge';
            } elseif (str_contains($ua, 'OPR/')) {
                $browser = 'Opera';
            } elseif (str_contains($ua, 'Chrome/')) {
                $browser = 'Google Chrome';
            } elseif (str_contains($ua, 'Firefox/')) {
                $browser = 'Firefox';
            } elseif (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome')) {
                $browser = 'Safari';
            } elseif (str_contains($ua, 'MSIE') || str_contains($ua, 'Trident/')) {
                $browser = 'Internet Explorer';
            } elseif ($ua === '') {
                $browser = 'غير معروف';
            }
        }

        if (str_contains($ua, 'Windows')) {
            $os = 'Windows';
        } elseif (str_contains($ua, 'Macintosh')) {
            $os = 'macOS';
        } elseif (str_contains($ua, 'Linux') && !str_contains($ua, 'Android')) {
            $os = 'Linux';
        } elseif (str_contains($ua, 'Android')) {
            $os = 'Android';
        } elseif (str_contains($ua, 'iPhone')) {
            $os = 'iOS (iPhone)';
        } elseif (str_contains($ua, 'iPad')) {
            $os = 'iOS (iPad)';
        }

        if ($isApp) {
            $device = 'تطبيق';
        } elseif (str_contains($ua, 'Mobile') || str_contains($ua, 'Android') || str_contains($ua, 'iPhone')) {
            $device = 'موبايل';
        } elseif (str_contains($ua, 'Tablet') || str_contains($ua, 'iPad')) {
            $device = 'تابلت';
        }

        $sourceWeb = $device === 'موبايل' || $device === 'تابلت'
            ? 'الموقع (موبايل)'
            : 'الموقع (ديسكتوب)';

        return (object) compact('browser', 'os', 'device', 'isApp', 'sourceWeb');
    }
}
