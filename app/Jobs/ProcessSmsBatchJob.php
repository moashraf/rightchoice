<?php

namespace App\Jobs;

use App\Models\SmsBatch;
use App\Services\Sms\SmsBatchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Queue job to process an SMS batch asynchronously.
 *
 * This prevents large SMS sends from blocking the HTTP request.
 * The batch is created with status 'pending' in the controller,
 * then this job picks it up and sends each valid recipient.
 *
 * Retries up to 3 times with backoff on failure.
 */
class ProcessSmsBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * Backoff between retries (seconds).
     */
    public array $backoff = [30, 60, 120];

    /**
     * Job timeout in seconds.
     */
    public int $timeout = 600;

    private SmsBatch $batch;

    public function __construct(SmsBatch $batch)
    {
        $this->batch = $batch;
        $this->onQueue('sms');
    }

    public function handle(SmsBatchService $service): void
    {
        Log::info('[ProcessSmsBatchJob] Starting batch processing', [
            'batch_id'         => $this->batch->id,
            'total_recipients' => $this->batch->total_recipients,
        ]);

        $service->processBatch($this->batch);

        Log::info('[ProcessSmsBatchJob] Batch processing complete', [
            'batch_id'   => $this->batch->id,
            'total_sent' => $this->batch->fresh()->total_sent,
        ]);
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('[ProcessSmsBatchJob] Batch failed', [
            'batch_id' => $this->batch->id,
            'error'    => $exception->getMessage(),
        ]);

        $this->batch->update([
            'overall_status' => 'failed',
        ]);
    }
}
