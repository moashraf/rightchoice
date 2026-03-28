<?php

namespace App\Http\Controllers;

use App\DataTables\WhatsappBatchDataTable;
use App\DataTables\WhatsappBatchRecipientDataTable;
use App\Enums\WhatsappSendStatusEnum;
use App\Enums\WhatsappSendTypeEnum;
use App\Http\Requests\SendWhatsappRequest;
use App\Jobs\ProcessWhatsappBatchJob;
use App\Models\WhatsappBatch;
use App\Models\User;
use App\Services\Whatsapp\WhatsappMessagePersonalizer;
use App\Services\Whatsapp\WhatsappBatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

class AdminWhatsappController extends Controller
{
    private WhatsappBatchService $whatsappBatchService;

    public function __construct(WhatsappBatchService $whatsappBatchService)
    {
        $this->whatsappBatchService = $whatsappBatchService;
    }

    public function index(WhatsappBatchDataTable $dataTable)
    {
        return $dataTable->render('admin_whatsapp.index');
    }

    public function create()
    {
        $placeholders = WhatsappMessagePersonalizer::PLACEHOLDERS;
        $totalUsers   = User::count();

        return view('admin_whatsapp.create', compact('placeholders', 'totalUsers'));
    }

    public function store(SendWhatsappRequest $request)
    {
        $validated = $request->validated();

        $batch = $this->whatsappBatchService->createBatch(
            $validated['message_template'],
            $validated['send_type'],
            $validated['user_ids'] ?? null
        );

        if ($batch->total_valid_numbers === 0) {
            Flash::warning('لا يوجد أرقام صالحة للإرسال. تم إنشاء الدفعة مع تسجيل الأرقام غير الصالحة.');
            return redirect(route('sitemanagement.whatsapp.show', $batch->id));
        }

        ProcessWhatsappBatchJob::dispatch($batch);

        Flash::success(
            "تم إنشاء دفعة رسائل واتساب بنجاح! "
            . "إجمالي المستلمين: {$batch->total_recipients} | "
            . "أرقام صالحة: {$batch->total_valid_numbers} | "
            . "أرقام غير صالحة: {$batch->total_invalid_numbers}"
        );

        return redirect(route('sitemanagement.whatsapp.show', $batch->id));
    }

    public function show($id, WhatsappBatchRecipientDataTable $dataTable)
    {
        $batch = WhatsappBatch::with('createdBy')->findOrFail($id);

        $stats = [
            'total'     => $batch->total_recipients,
            'valid'     => $batch->total_valid_numbers,
            'invalid'   => $batch->total_invalid_numbers,
            'sent'      => $batch->total_sent,
            'delivered' => $batch->total_delivered,
            'failed'    => $batch->total_failed,
            'pending'   => $batch->recipients()
                                ->whereIn('send_status', [WhatsappSendStatusEnum::PENDING, WhatsappSendStatusEnum::QUEUED, WhatsappSendStatusEnum::SENDING])
                                ->count(),
        ];

        $dataTable->setBatchId($id);

        return $dataTable->render('admin_whatsapp.show', compact('batch', 'stats'));
    }

    public function retryFailed($id)
    {
        $batch = WhatsappBatch::findOrFail($id);

        $retriedCount = $this->whatsappBatchService->retryFailed($batch);

        if ($retriedCount === 0) {
            Flash::info('لا توجد رسائل فاشلة لإعادة إرسالها.');
        } else {
            Flash::success("تمت إعادة إرسال {$retriedCount} رسالة عبر واتساب.");
        }

        return redirect(route('sitemanagement.whatsapp.show', $batch->id));
    }

    public function searchUsers(Request $request): JsonResponse
    {
        $search = $request->input('search', '');
        $page   = $request->input('page', 1);
        $limit  = 20;

        $query = User::query()->select(['id', 'name', 'email', 'MOP']);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('MOP', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name')
                       ->paginate($limit, ['*'], 'page', $page);

        return response()->json($users);
    }

    public function previewRecipients(Request $request): JsonResponse
    {
        $sendType = $request->input('send_type', 'all_users');
        $userIds  = $request->input('user_ids', []);

        $counts = WhatsappBatchService::previewRecipientCounts($sendType, $userIds);

        return response()->json($counts);
    }
}
