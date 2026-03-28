<?php

namespace App\Http\Controllers;

use App\DataTables\SmsBatchDataTable;
use App\DataTables\SmsBatchRecipientDataTable;
use App\Enums\SmsSendStatusEnum;
use App\Enums\SmsSendTypeEnum;
use App\Http\Requests\SendSmsRequest;
use App\Jobs\ProcessSmsBatchJob;
use App\Models\SmsBatch;
use App\Models\User;
use App\Services\Sms\MessagePersonalizer;
use App\Services\Sms\SmsBatchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;

/**
 * Admin SMS controller – handles sending, reporting, and batch management.
 *
 * Provides pages for:
 *   1. Composing and sending bulk SMS (create/store)
 *   2. Viewing SMS batch history/reports (index)
 *   3. Viewing batch details and per-recipient results (show)
 *   4. Retrying failed messages
 *   5. AJAX endpoints for user search and recipient preview
 */
class AdminSmsController extends Controller
{
    private SmsBatchService $smsBatchService;

    public function __construct(SmsBatchService $smsBatchService)
    {
        $this->smsBatchService = $smsBatchService;
    }

    // ─── SMS Reports / History ──────────────────────────────────────────

    /**
     * List all SMS batches (reports page) with DataTable.
     */
    public function index(SmsBatchDataTable $dataTable)
    {
        return $dataTable->render('admin_sms.index');
    }

    // ─── SMS Sending Page ───────────────────────────────────────────────

    /**
     * Show the SMS composing/sending form.
     */
    public function create()
    {
        $placeholders = MessagePersonalizer::PLACEHOLDERS;
        $totalUsers   = User::count();

        return view('admin_sms.create', compact('placeholders', 'totalUsers'));
    }

    /**
     * Process the SMS send form: create batch + dispatch queue job.
     */
    public function store(SendSmsRequest $request)
    {
        $validated = $request->validated();

        // Create the batch with recipients
        $batch = $this->smsBatchService->createBatch(
            $validated['message_template'],
            $validated['send_type'],
            $validated['user_ids'] ?? null
        );

        // Check if there are any valid recipients
        if ($batch->total_valid_numbers === 0) {
            Flash::warning('لا يوجد أرقام صالحة للإرسال. تم إنشاء الدفعة مع تسجيل الأرقام غير الصالحة.');
            return redirect(route('sitemanagement.sms.show', $batch->id));
        }

        // Dispatch the queue job for async processing (or process sync if queue is sync)
        ProcessSmsBatchJob::dispatch($batch);

        Flash::success(
            "تم إنشاء دفعة الرسائل بنجاح! "
            . "إجمالي المستلمين: {$batch->total_recipients} | "
            . "أرقام صالحة: {$batch->total_valid_numbers} | "
            . "أرقام غير صالحة: {$batch->total_invalid_numbers}"
        );

        return redirect(route('sitemanagement.sms.show', $batch->id));
    }

    // ─── Batch Details ──────────────────────────────────────────────────

    /**
     * Show a single batch's details with recipient-level DataTable.
     */
    public function show($id, SmsBatchRecipientDataTable $dataTable)
    {
        $batch = SmsBatch::with('createdBy')->findOrFail($id);

        // Summary stats for the header cards
        $stats = [
            'total'     => $batch->total_recipients,
            'valid'     => $batch->total_valid_numbers,
            'invalid'   => $batch->total_invalid_numbers,
            'sent'      => $batch->total_sent,
            'delivered' => $batch->total_delivered,
            'failed'    => $batch->total_failed,
            'pending'   => $batch->recipients()
                                ->whereIn('send_status', [SmsSendStatusEnum::PENDING, SmsSendStatusEnum::QUEUED, SmsSendStatusEnum::SENDING])
                                ->count(),
        ];

        // Configure the DataTable to filter by this batch
        $dataTable->setBatchId($id);

        return $dataTable->render('admin_sms.show', compact('batch', 'stats'));
    }

    // ─── Retry Failed ───────────────────────────────────────────────────

    /**
     * Retry sending to failed recipients in a batch.
     */
    public function retryFailed($id)
    {
        $batch = SmsBatch::findOrFail($id);

        $retriedCount = $this->smsBatchService->retryFailed($batch);

        if ($retriedCount === 0) {
            Flash::info('لا توجد رسائل فاشلة لإعادة إرسالها.');
        } else {
            Flash::success("تمت إعادة إرسال {$retriedCount} رسالة.");
        }

        return redirect(route('sitemanagement.sms.show', $batch->id));
    }

    // ─── AJAX Endpoints ─────────────────────────────────────────────────

    /**
     * AJAX: Search users for the user selection table.
     */
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

    /**
     * AJAX: Preview recipient counts before sending.
     */
    public function previewRecipients(Request $request): JsonResponse
    {
        $sendType    = $request->input('send_type', 'all_users');
        $userIds     = $request->input('user_ids', []);

        $counts = SmsBatchService::previewRecipientCounts($sendType, $userIds);

        return response()->json($counts);
    }
}
