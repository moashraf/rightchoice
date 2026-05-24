<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\aqar;
use App\Models\User;
use App\Models\Complaints;
use App\Models\Company;
use App\Models\ContactForm;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Notification;
use App\Models\UserContactAqar;
use App\Models\UserPriceing;
use App\Models\RequestPhotoSession;
use App\Models\PriceVip;
use App\Models\Viewer;
use App\Models\Pricing;

class AdminReportController extends Controller
{
    private const NOT_INVITED_FILTER = '__not_invited__';

    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');

        $filter = function ($query) use ($fromDate, $toDate) {
            if ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            }
            if ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            }
        };

        // ===== إحصائيات المستخدمين =====
        $stats = [
            'users'          => User::whereNull('deleted_at')->when($fromDate || $toDate, $filter)->count(),
            'users_active'   => User::whereNull('deleted_at')->where('status', 1)->when($fromDate || $toDate, $filter)->count(),
            'users_inactive' => User::whereNull('deleted_at')->where('status', 0)->when($fromDate || $toDate, $filter)->count(),
            'users_blocked'  => User::whereNull('deleted_at')->where('status', 2)->when($fromDate || $toDate, $filter)->count(),
        ];

        // ===== إحصائيات عامة (من الأدمين القديم) =====
        $stats['aqars']        = aqar::whereNull('deleted_at')->when($fromDate || $toDate, $filter)->count();
        $stats['complaints']   = Complaints::when($fromDate || $toDate, $filter)->count();
        $stats['companies']    = Company::when($fromDate || $toDate, $filter)->count();
        $stats['contactForms'] = ContactForm::when($fromDate || $toDate, $filter)->count();

        // ===== تقارير جديدة =====
        $stats['blogs']         = Blog::when($fromDate || $toDate, $filter)->count();
        $stats['sliders']       = Slider::when($fromDate || $toDate, $filter)->count();
        $stats['notifications'] = Notification::when($fromDate || $toDate, $filter)->count();
        $stats['photoSessions'] = RequestPhotoSession::when($fromDate || $toDate, $filter)->count();
        $stats['userContacts']  = UserContactAqar::when($fromDate || $toDate, $filter)->count();
        $stats['usersContacted'] = UserContactAqar::when($fromDate || $toDate, $filter)
            ->distinct('user_id')
            ->count('user_id');
        $stats['subscriptions'] = UserPriceing::when($fromDate || $toDate, $filter)->count();

        // عقارات نشطة / في الانتظار / متوقفة
        $stats['aqars_active']   = aqar::whereNull('deleted_at')->where('status', 1)->when($fromDate || $toDate, $filter)->count();
        $stats['aqars_pending']  = aqar::whereNull('deleted_at')->where('status', 0)->when($fromDate || $toDate, $filter)->count();
        $stats['aqars_inactive'] = aqar::whereNull('deleted_at')->where('status', 2)->when($fromDate || $toDate, $filter)->count();

        // عقارات VIP
        $stats['aqars_vip'] = aqar::whereNull('deleted_at')->where('vip', 1)->when($fromDate || $toDate, $filter)->count();

        // ===== إحصائيات الدعوات =====
        $invitedByStats = User::select(
                'invited_by',
                DB::raw('count(*) as total'),
                DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count'),
                DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_count'),
                DB::raw('SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as blocked_count'),
                DB::raw('SUM(CASE WHEN (SELECT COUNT(*) FROM aqar WHERE aqar.user_id = users.id AND aqar.deleted_at IS NULL) > 0 THEN 1 ELSE 0 END) as with_aqars_count'),
                DB::raw('SUM(CASE WHEN (SELECT COUNT(*) FROM aqar WHERE aqar.user_id = users.id AND aqar.deleted_at IS NULL) = 0 THEN 1 ELSE 0 END) as without_aqars_count')
            )
            ->whereNull('deleted_at')
            ->whereNotNull('invited_by')
            ->whereRaw("TRIM(invited_by) != ''")
            ->when($fromDate || $toDate, $filter)
            ->groupBy('invited_by')
            ->orderByDesc('total')
            ->get();

        // المستخدمون غير المدعوين (invited_by فارغ أو null)
        $notInvitedStats = User::selectRaw("
                count(*) as total,
                SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count,
                SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_count,
                SUM(CASE WHEN status = 2 THEN 1 ELSE 0 END) as blocked_count,
                SUM(CASE WHEN (SELECT COUNT(*) FROM aqar WHERE aqar.user_id = users.id AND aqar.deleted_at IS NULL) > 0 THEN 1 ELSE 0 END) as with_aqars_count,
                SUM(CASE WHEN (SELECT COUNT(*) FROM aqar WHERE aqar.user_id = users.id AND aqar.deleted_at IS NULL) = 0 THEN 1 ELSE 0 END) as without_aqars_count
            ")
            ->whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('invited_by')
                  ->orWhereRaw("TRIM(COALESCE(invited_by, '')) = ''");
            })
            ->when($fromDate || $toDate, $filter)
            ->first();

        $notInvitedCount = $notInvitedStats->total ?? 0;

        // ===== إحصائيات أنواع المستخدمين =====
        $userTypeStats = User::select('TYPE', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->whereNotNull('TYPE')
            ->when($fromDate || $toDate, $filter)
            ->groupBy('TYPE')
            ->orderByDesc('total')
            ->get();

        // ===== عقارات حسب نوع العرض (بيع/إيجار) =====
        $aqarsByOfferType = DB::table('aqar')
            ->join('offer_type', 'aqar.offer_type', '=', 'offer_type.id')
            ->select('offer_type.type_offer as offer_name', DB::raw('count(aqar.id) as total'))
            ->whereNull('aqar.deleted_at')
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('offer_type.type_offer')
            ->orderByDesc('total')
            ->get();

        // ===== عقارات حسب المحافظة =====
        $aqarsByGovernrate = DB::table('aqar')
            ->join('governrate', 'aqar.governrate_id', '=', 'governrate.id')
            ->select('governrate.id as gov_id', 'governrate.governrate as gov_name', DB::raw('count(aqar.id) as total'))
            ->whereNull('aqar.deleted_at')
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('governrate.id', 'governrate.governrate')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        // ===== عقارات حسب المحافظة والمنطقة (district) =====
        $aqarsBySubArea = DB::table('aqar')
            ->join('governrate', 'aqar.governrate_id', '=', 'governrate.id')
            ->join('district', 'aqar.district_id', '=', 'district.id')
            ->select(
                'governrate.id as gov_id',
                'district.district as area_name',
                DB::raw('count(aqar.id) as total')
            )
            ->whereNull('aqar.deleted_at')
            ->whereNotNull('aqar.district_id')
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('governrate.id', 'district.district')
            ->orderByDesc('total')
            ->get()
            ->groupBy('gov_id');

        // ===== أكثر المستخدمين نشاطاً (عدد العقارات النشطة فقط) =====
        $topUsersByAqars = DB::table('aqar')
            ->join('users', 'aqar.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.MOP', DB::raw('count(aqar.id) as total'))
            ->whereNull('aqar.deleted_at')
            ->where('aqar.status', 1)
            ->whereNull('users.deleted_at')
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('users.id', 'users.name', 'users.MOP')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // ===== المستخدمون الذين أضافوا عقارات =====
        $usersWithAqars = User::whereNull('deleted_at')
            ->whereHas('aqars', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->when($fromDate || $toDate, $filter)
            ->count();

        // ===== المستخدمون الذين لم يضيفوا أي عقار =====
        $usersWithoutAqars = User::whereNull('deleted_at')
            ->whereDoesntHave('aqars', function ($q) {
                $q->whereNull('deleted_at');
            })
            ->when($fromDate || $toDate, $filter)
            ->count();

        return view('admin_reports.index', compact(
            'stats', 'fromDate', 'toDate', 'invitedByStats', 'notInvitedCount', 'notInvitedStats',
            'userTypeStats', 'aqarsByOfferType', 'aqarsByGovernrate', 'aqarsBySubArea', 'topUsersByAqars',
            'usersWithAqars', 'usersWithoutAqars'
        ))->with('notInvitedFilterValue', self::NOT_INVITED_FILTER);
    }

    public function subscriptions(Request $request)
    {
        $fromDate  = $request->input('from_date');
        $toDate    = $request->input('to_date');
        $search    = $request->input('search');
        $status    = $request->input('status');
        $pricingId = $request->input('pricing_id');

        $baseQuery = UserPriceing::with(['user', 'pricing'])
            ->when($fromDate, function ($query) use ($fromDate) {
                $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query) use ($toDate) {
                $query->whereDate('created_at', '<=', $toDate);
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('statues', $status);
            })
            ->when($pricingId, function ($query) use ($pricingId) {
                $query->where('pricing_id', $pricingId);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhere('MOP', 'like', '%' . $search . '%');
                    })->orWhereHas('pricing', function ($pricingQuery) use ($search) {
                        $pricingQuery->where('type', 'like', '%' . $search . '%')
                            ->orWhere('type_en', 'like', '%' . $search . '%');
                    });
                });
            });

        $summaryQuery = clone $baseQuery;

        $subscriptions = $baseQuery
            ->orderByDesc('id')
            ->paginate(25)
            ->appends($request->all());

        $summary = [
            'total'          => (clone $summaryQuery)->count(),
            'active'         => (clone $summaryQuery)->where('statues', 1)->count(),
            'inactive'       => (clone $summaryQuery)->where('statues', 0)->count(),
            'unique_users'   => (clone $summaryQuery)->distinct('user_id')->count('user_id'),
            'current_points' => (clone $summaryQuery)->sum('current_points'),
        ];

        $packages = Pricing::orderBy('id')->get();

        return view('admin_reports.subscriptions', compact(
            'subscriptions', 'summary', 'packages', 'fromDate', 'toDate', 'search', 'status', 'pricingId'
        ));
    }

    public function invitedByDetails(Request $request)
    {
        $invitedBy = $request->input('invited_by');
        $fromDate  = $request->input('from_date');
        $toDate    = $request->input('to_date');
        $isNotInvitedFilter = $invitedBy === self::NOT_INVITED_FILTER;

        $users = User::query()
            ->whereNull('deleted_at')
            ->when($isNotInvitedFilter, function ($q) {
                $q->where(function ($sub) {
                    $sub->whereNull('invited_by')
                        ->orWhereRaw("TRIM(COALESCE(invited_by, '')) = ''");
                });
            })
            ->when(!$isNotInvitedFilter && filled($invitedBy), function ($q) use ($invitedBy) {
                $q->where('invited_by', $invitedBy);
            })
            ->when($fromDate, function ($q) use ($fromDate) {
                $q->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($q) use ($toDate) {
                $q->whereDate('created_at', '<=', $toDate);
            })
            ->orderByDesc('id')
            ->paginate(20)
            ->appends($request->all());

        // Summary of all invited_by values
        $invitedByStats = User::select('invited_by', DB::raw('count(*) as total'))
            ->whereNull('deleted_at')
            ->whereNotNull('invited_by')
            ->whereRaw("TRIM(invited_by) != ''")
            ->when($fromDate, function ($q) use ($fromDate) {
                $q->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($q) use ($toDate) {
                $q->whereDate('created_at', '<=', $toDate);
            })
            ->groupBy('invited_by')
            ->orderByDesc('total')
            ->get();

        $notInvitedCount = User::whereNull('deleted_at')
            ->where(function ($q) {
                $q->whereNull('invited_by')
                    ->orWhereRaw("TRIM(COALESCE(invited_by, '')) = ''");
            })
            ->when($fromDate, function ($q) use ($fromDate) {
                $q->whereDate('created_at', '>=', $fromDate);
            })
            ->when($toDate, function ($q) use ($toDate) {
                $q->whereDate('created_at', '<=', $toDate);
            })
            ->count();

        return view('admin_reports.invited_by_details', compact(
            'users', 'invitedBy', 'fromDate', 'toDate', 'invitedByStats', 'notInvitedCount'
        ))->with('notInvitedFilterValue', self::NOT_INVITED_FILTER);
    }

    public function userContacts(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate   = $request->input('to_date');
        $search   = $request->input('search');

        // Get users who have contacted aqars, with filter
        $usersQuery = User::whereNull('deleted_at')
            ->whereHas('contact', function ($q) use ($fromDate, $toDate) {
                if ($fromDate) $q->whereDate('created_at', '>=', $fromDate);
                if ($toDate)   $q->whereDate('created_at', '<=', $toDate);
            })
            ->when($search, function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('MOP', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->with([
                'contact' => function ($q) use ($fromDate, $toDate) {
                    if ($fromDate) $q->whereDate('created_at', '>=', $fromDate);
                    if ($toDate)   $q->whereDate('created_at', '<=', $toDate);
                    $q->orderByDesc('created_at');
                },
                'contact.all_aqat_viw',
                'contact.all_aqat_viw.user',
                'contact.all_aqat_viw.governrateq',
                'contact.all_aqat_viw.offerTypes',
                'userpricing.pricing',
            ])
            ->orderByDesc(
                DB::table('usercontactaqar')
                    ->select('created_at')
                    ->whereColumn('user_id', 'users.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->paginate(15)
            ->appends($request->all());

        return view('admin_reports.user_contacts', compact('usersQuery', 'fromDate', 'toDate', 'search'));
    }
}
