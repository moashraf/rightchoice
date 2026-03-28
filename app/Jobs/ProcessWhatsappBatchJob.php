<?php

namespace App\Jobs;

use App\Models\WhatsappBatch;
use App\Services\Whatsapp\WhatsappBatchService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessWhatsappBatchJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public array $backoff = [30, 60, 120];
    public int $timeout = 600;

    private WhatsappBatch $batch;

    public function __construct(WhatsappBatch $batch)
    {
        $this->batch = $batch;
        $this->onQueue(config('whatsapp.queue', 'whatsapp'));
    }

    public function handle(WhatsappBatchService $service): void
    {
        Log::info('[ProcessWhatsappBatchJob] Starting batch processing', [
            'batch_id'         => $this->batch->id,
            'total_recipients' => $this->batch->total_recipients,
        ]);

        $service->processBatch($this->batch);

        Log::info('[ProcessWhatsappBatchJob] Batch processing complete', [
            'batch_id'   => $this->batch->id,
            'total_sent' => $this->batch->fresh()->total_sent,
        ]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('[ProcessWhatsappBatchJob] Batch failed', [
            'batch_id' => $this->batch->id,
            'error'    => $exception->getMessage(),
        ]);

        $this->batch->update([
            'overall_status' => 'failed',
        ]);
    }
}
