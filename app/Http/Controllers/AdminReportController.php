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

class AdminReportController extends Controller
{
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
            'users'          => User::when($fromDate || $toDate, $filter)->count(),
            'users_active'   => User::where('status', 1)->when($fromDate || $toDate, $filter)->count(),
            'users_inactive' => User::where('status', 0)->when($fromDate || $toDate, $filter)->count(),
            'users_blocked'  => User::where('status', 2)->when($fromDate || $toDate, $filter)->count(),
        ];

        // ===== إحصائيات عامة (من الأدمين القديم) =====
        $stats['aqars']        = aqar::when($fromDate || $toDate, $filter)->count();
        $stats['complaints']   = Complaints::when($fromDate || $toDate, $filter)->count();
        $stats['companies']    = Company::when($fromDate || $toDate, $filter)->count();
        $stats['contactForms'] = ContactForm::when($fromDate || $toDate, $filter)->count();

        // ===== تقارير جديدة =====
        $stats['blogs']         = Blog::when($fromDate || $toDate, $filter)->count();
        $stats['sliders']       = Slider::when($fromDate || $toDate, $filter)->count();
        $stats['notifications'] = Notification::when($fromDate || $toDate, $filter)->count();
        $stats['photoSessions'] = RequestPhotoSession::when($fromDate || $toDate, $filter)->count();
        $stats['userContacts']  = UserContactAqar::when($fromDate || $toDate, $filter)->count();
        $stats['subscriptions'] = UserPriceing::when($fromDate || $toDate, $filter)->count();

        // عقارات نشطة / في الانتظار / متوقفة
        $stats['aqars_active']   = aqar::where('status', 1)->when($fromDate || $toDate, $filter)->count();
        $stats['aqars_pending']  = aqar::where('status', 0)->when($fromDate || $toDate, $filter)->count();
        $stats['aqars_inactive'] = aqar::where('status', 2)->when($fromDate || $toDate, $filter)->count();

        // عقارات VIP
        $stats['aqars_vip'] = aqar::where('vip', 1)->when($fromDate || $toDate, $filter)->count();

        // ===== إحصائيات الدعوات =====
        $invitedByStats = User::select('invited_by', DB::raw('count(*) as total'))
            ->whereNotNull('invited_by')
            ->where('invited_by', '!=', '')
            ->when($fromDate || $toDate, $filter)
            ->groupBy('invited_by')
            ->orderByDesc('total')
            ->get();

        // ===== إحصائيات أنواع المستخدمين =====
        $userTypeStats = User::select('TYPE', DB::raw('count(*) as total'))
            ->whereNotNull('TYPE')
            ->when($fromDate || $toDate, $filter)
            ->groupBy('TYPE')
            ->orderByDesc('total')
            ->get();

        // ===== عقارات حسب نوع العرض (بيع/إيجار) =====
        $aqarsByOfferType = DB::table('aqar')
            ->join('offer_type', 'aqar.offer_type', '=', 'offer_type.id')
            ->select('offer_type.type_offer as offer_name', DB::raw('count(aqar.id) as total'))
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
            ->select('governrate.governrate as gov_name', DB::raw('count(aqar.id) as total'))
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('governrate.governrate')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        // ===== أكثر المستخدمين نشاطاً (عدد العقارات) =====
        $topUsersByAqars = DB::table('aqar')
            ->join('users', 'aqar.user_id', '=', 'users.id')
            ->select('users.name', 'users.MOP', DB::raw('count(aqar.id) as total'))
            ->when($fromDate || $toDate, function ($query) use ($fromDate, $toDate) {
                if ($fromDate) $query->whereDate('aqar.created_at', '>=', $fromDate);
                if ($toDate)   $query->whereDate('aqar.created_at', '<=', $toDate);
            })
            ->groupBy('users.name', 'users.MOP')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin_reports.index', compact(
            'stats', 'fromDate', 'toDate', 'invitedByStats', 'userTypeStats',
            'aqarsByOfferType', 'aqarsByGovernrate', 'topUsersByAqars'
        ));
    }
}
