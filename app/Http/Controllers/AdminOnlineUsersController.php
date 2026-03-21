<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminOnlineUsersController extends AppBaseController
{
    /**
     * Display currently online (active session) users.
     *
     * A user is considered "online" if their session's last_activity
     * is within the last N minutes (default: session lifetime from config).
     */
    public function index()
    {
        $sessionLifetime = config('session.lifetime', 120); // minutes

        $cutoff = Carbon::now()->subMinutes($sessionLifetime)->timestamp;

        // Get all active sessions that belong to authenticated users
        $activeSessions = DB::table('sessions')
            ->where('last_activity', '>=', $cutoff)
            ->whereNotNull('user_id')
            ->orderBy('last_activity', 'desc')
            ->get();

        // Unique user IDs
        $userIds = $activeSessions->pluck('user_id')->unique()->values();

        // Load users
        $users = User::whereIn('id', $userIds)->get()->keyBy('id');

        // Build a collection with user + session info
        $onlineUsers = $activeSessions->map(function ($session) use ($users) {
            $user = $users->get($session->user_id);
            if (!$user) return null;

            return (object) [
                'user_id'       => $session->user_id,
                'name'          => $user->name,
                'email'         => $user->email,
                'phone'         => $user->MOP ?? '-',
                'ip_address'    => $session->ip_address ?? '-',
                'user_agent'    => $session->user_agent ?? '-',
                'last_activity' => Carbon::createFromTimestamp($session->last_activity),
                'user'          => $user,
            ];
        })->filter()->unique('user_id')->values();

        $totalOnline = $onlineUsers->count();

        // Also count guest sessions (no user_id)
        $guestSessions = DB::table('sessions')
            ->where('last_activity', '>=', $cutoff)
            ->whereNull('user_id')
            ->count();

        return view('admin_online_users.index', compact('onlineUsers', 'totalOnline', 'guestSessions'));
    }

    /**
     * Show detailed information about a specific online user's session & IP.
     */
    public function show($userId)
    {
        $user = User::findOrFail($userId);

        $sessionLifetime = config('session.lifetime', 120);
        $cutoff = Carbon::now()->subMinutes($sessionLifetime)->timestamp;

        // All active sessions for this user
        $sessions = DB::table('sessions')
            ->where('user_id', $userId)
            ->where('last_activity', '>=', $cutoff)
            ->orderBy('last_activity', 'desc')
            ->get()
            ->map(function ($session) {
                $session->last_activity_carbon = Carbon::createFromTimestamp($session->last_activity);
                // Parse user agent for readable device/browser info
                $session->device = $this->parseUserAgent($session->user_agent ?? '');
                return $session;
            });

        // All unique IPs this user has ever used (from sessions table)
        $allIps = DB::table('sessions')
            ->where('user_id', $userId)
            ->whereNotNull('ip_address')
            ->select('ip_address', DB::raw('MAX(last_activity) as last_seen'), DB::raw('COUNT(*) as session_count'))
            ->groupBy('ip_address')
            ->orderByDesc('last_seen')
            ->get()
            ->map(function ($ip) {
                $ip->last_seen_carbon = Carbon::createFromTimestamp($ip->last_seen);
                return $ip;
            });

        // Recent activity logs for this user (from activity_log table)
        $recentActivity = DB::table('activity_log')
            ->where('causer_id', $userId)
            ->where('causer_type', 'App\\Models\\User')
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        // Other users sharing the same IPs (fraud/multi-account detection)
        $userIpAddresses = $sessions->pluck('ip_address')->filter()->unique()->values();
        $sharedIpUsers = collect();
        if ($userIpAddresses->isNotEmpty()) {
            $sharedSessionUserIds = DB::table('sessions')
                ->whereIn('ip_address', $userIpAddresses)
                ->where('user_id', '!=', $userId)
                ->whereNotNull('user_id')
                ->distinct()
                ->pluck('user_id');

            if ($sharedSessionUserIds->isNotEmpty()) {
                $sharedIpUsers = User::whereIn('id', $sharedSessionUserIds)->get();
            }
        }

        return view('admin_online_users.show', compact(
            'user', 'sessions', 'allIps', 'recentActivity', 'sharedIpUsers', 'userIpAddresses'
        ));
    }

    /**
     * Parse user-agent string into a readable device/browser summary.
     */
    private function parseUserAgent(string $ua): object
    {
        $browser = 'غير معروف';
        $os = 'غير معروف';
        $device = 'كمبيوتر';

        // Browser detection
        if (str_contains($ua, 'Edg/'))           $browser = 'Microsoft Edge';
        elseif (str_contains($ua, 'OPR/'))       $browser = 'Opera';
        elseif (str_contains($ua, 'Chrome/'))    $browser = 'Google Chrome';
        elseif (str_contains($ua, 'Firefox/'))   $browser = 'Firefox';
        elseif (str_contains($ua, 'Safari/') && !str_contains($ua, 'Chrome')) $browser = 'Safari';
        elseif (str_contains($ua, 'MSIE') || str_contains($ua, 'Trident/')) $browser = 'Internet Explorer';

        // OS detection
        if (str_contains($ua, 'Windows'))        $os = 'Windows';
        elseif (str_contains($ua, 'Macintosh'))  $os = 'macOS';
        elseif (str_contains($ua, 'Linux'))      $os = 'Linux';
        elseif (str_contains($ua, 'Android'))    $os = 'Android';
        elseif (str_contains($ua, 'iPhone'))     $os = 'iOS (iPhone)';
        elseif (str_contains($ua, 'iPad'))       $os = 'iOS (iPad)';

        // Device type
        if (str_contains($ua, 'Mobile') || str_contains($ua, 'Android') || str_contains($ua, 'iPhone'))
            $device = 'موبايل';
        elseif (str_contains($ua, 'Tablet') || str_contains($ua, 'iPad'))
            $device = 'تابلت';

        return (object) compact('browser', 'os', 'device');
    }
}
