<?php

namespace App\Services\Sms;

use App\Contracts\SmsProviderInterface;
use App\Enums\SmsBatchStatusEnum;
use App\Enums\SmsSendStatusEnum;
use App\Enums\SmsSendTypeEnum;
use App\Models\SmsBatch;
use App\Models\SmsBatchRecipient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Core SMS batch service — orchestrates the full sending flow.
 *
 * Responsibilities:
 *   1. Create batch + recipient records
 *   2. Validate phone numbers
 *   3. Personalize messages
 *   4. Dispatch sending (sync or via queue)
 *   5. Update statuses and totals
 */
class SmsBatchService
{
    private SmsProviderInterface $provider;

    public function __construct(SmsProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Create an SMS batch with recipients and prepare them for sending.
     *
     * @param string     $messageTemplate  The SMS template with placeholders
     * @param string     $sendType         'all_users' or 'selected_users'
     * @param array|null $selectedUserIds  User IDs when sendType is 'selected_users'
     * @return SmsBatch  The newly created batch
     */
    public function createBatch(string $messageTemplate, string $sendType, ?array $selectedUserIds = null): SmsBatch
    {
        return DB::transaction(function () use ($messageTemplate, $sendType, $selectedUserIds) {
            // 1. Create the batch header
            $batch = SmsBatch::create([
                'created_by_user_id' => Auth::guard('admin')->id(),
                'send_type'          => $sendType,
                'message_template'   => $messageTemplate,
                'overall_status'     => SmsBatchStatusEnum::PENDING,
                'provider_name'      => $this->provider->getName(),
            ]);

            // 2. Build the user query
            $usersQuery = User::query()->select(['id', 'name', 'MOP']);

            if ($sendType === SmsSendTypeEnum::SELECTED_USERS && !empty($selectedUserIds)) {
                $usersQuery->whereIn('id', $selectedUserIds);
            }

            // 3. Process users in chunks to avoid memory issues
            $totalRecipients    = 0;
            $totalValid         = 0;
            $totalInvalid       = 0;

            $usersQuery->chunk(500, function ($users) use ($batch, $messageTemplate, &$totalRecipients, &$totalValid, &$totalInvalid) {
                $recipientRows = [];

                foreach ($users as $user) {
                    $totalRecipients++;

                    // Validate the phone number
                    $validation = PhoneValidator::validate($user->MOP);

                    // Personalize the message for this user
                    $personalizedMessage = MessagePersonalizer::personalize($messageTemplate, [
                        'name' => $user->name,
                    ]);

                    // Determine initial send status based on validation
                    $sendStatus = $validation['valid']
                        ? SmsSendStatusEnum::PENDING
                        : SmsSendStatusEnum::INVALID_NUMBER;

                    if ($validation['valid']) {
                        $totalValid++;
                    } else {
                        $totalInvalid++;
                    }

                    $recipientRows[] = [
                        'batch_id'             => $batch->id,
                        'user_id'              => $user->id,
                        'recipient_name'       => $user->name,
                        'recipient_mobile'     => $user->MOP,
                        'normalized_mobile'    => $validation['normalized'],
                        'personalized_message' => $personalizedMessage,
                        'validation_status'    => $validation['valid'] ? 'valid' : 'invalid',
                        'validation_reason'    => $validation['reason'],
                        'send_status'          => $sendStatus,
                        'failure_reason'       => $validation['valid'] ? null : $validation['reason'],
                        'created_at'           => now(),
                        'updated_at'           => now(),
                    ];
                }

                // Bulk insert recipients for performance
                SmsBatchRecipient::insert($recipientRows);
            });

            // 4. Update batch totals
            $batch->update([
                'total_recipients'     => $totalRecipients,
                'total_valid_numbers'  => $totalValid,
                'total_invalid_numbers'=> $totalInvalid,
            ]);

            return $batch->fresh();
        });
    }

    /**
     * Send SMS messages for all valid recipients in a batch.
     *
     * This method is designed to be called synchronously or from a queued job.
     * It processes valid recipients in chunks and updates statuses as it goes.
     *
     * @param SmsBatch $batch The batch to process
     */
    public function processBatch(SmsBatch $batch): void
    {
        // Mark batch as processing
        $batch->update(['overall_status' => SmsBatchStatusEnum::PROCESSING]);

        // Only send to recipients with valid numbers and pending status
        $query = $batch->recipients()
                       ->where('validation_status', 'valid')
                       ->where('send_status', SmsSendStatusEnum::PENDING);

        $query->chunk(100, function ($recipients) {
            foreach ($recipients as $recipient) {
                $this->sendToRecipient($recipient);
            }
        });

        // Recalculate batch totals after processing
        $batch->recalculateTotals();
    }

    /**
     * Send SMS to a single recipient and update its status.
     *
     * @param SmsBatchRecipient $recipient
     */
    public function sendToRecipient(SmsBatchRecipient $recipient): void
    {
        try {
            // Mark as sending
            $recipient->updateStatus(SmsSendStatusEnum::SENDING, 'بدء الإرسال');

            // Call the provider
            $result = $this->provider->send(
                $recipient->normalized_mobile,
                $recipient->personalized_message
            );

            if ($result->success) {
                // Update to sent
                $recipient->update([
                    'provider_message_id' => $result->messageId,
                    'provider_response'   => $result->rawResponse,
                ]);
                $recipient->updateStatus(
                    SmsSendStatusEnum::SENT,
                    'تم الإرسال بنجاح',
                    $result->rawResponse
                );
            } else {
                // Update to failed
                $recipient->update([
                    'provider_response' => $result->rawResponse,
                    'failure_reason'    => $result->failureReason,
                ]);
                $recipient->updateStatus(
                    SmsSendStatusEnum::FAILED,
                    $result->failureReason,
                    $result->rawResponse
                );
            }

        } catch (\Throwable $e) {
            // Catch any unexpected error so it doesn't break the whole batch
            Log::error('[SmsBatchService] Send error', [
                'recipient_id' => $recipient->id,
                'batch_id'     => $recipient->batch_id,
                'error'        => $e->getMessage(),
            ]);

            $recipient->update([
                'failure_reason' => 'Exception: ' . $e->getMessage(),
            ]);
            $recipient->updateStatus(
                SmsSendStatusEnum::FAILED,
                'خطأ غير متوقع: ' . $e->getMessage()
            );
        }
    }

    /**
     * Retry sending to failed recipients in a batch.
     *
     * @param SmsBatch $batch
     * @return int Number of recipients retried
     */
    public function retryFailed(SmsBatch $batch): int
    {
        $failedRecipients = $batch->recipients()
            ->where('send_status', SmsSendStatusEnum::FAILED)
            ->where('validation_status', 'valid')
            ->get();

        $count = 0;
        foreach ($failedRecipients as $recipient) {
            // Reset to pending before retry
            $recipient->update([
                'send_status'    => SmsSendStatusEnum::PENDING,
                'failure_reason' => null,
            ]);
            $this->sendToRecipient($recipient);
            $count++;
        }

        // Recalculate totals after retry
        $batch->recalculateTotals();

        return $count;
    }

    /**
     * Get a count preview of recipients before actually creating a batch.
     *
     * @param string     $sendType
     * @param array|null $selectedUserIds
     * @return array{total: int, valid: int, invalid: int}
     */
    public static function previewRecipientCounts(string $sendType, ?array $selectedUserIds = null): array
    {
        $query = User::query()->select(['id', 'MOP']);

        if ($sendType === SmsSendTypeEnum::SELECTED_USERS && !empty($selectedUserIds)) {
            $query->whereIn('id', $selectedUserIds);
        }

        $total   = 0;
        $valid   = 0;
        $invalid = 0;

        $query->chunk(500, function ($users) use (&$total, &$valid, &$invalid) {
            foreach ($users as $user) {
                $total++;
                if (PhoneValidator::isValid($user->MOP)) {
                    $valid++;
                } else {
                    $invalid++;
                }
            }
        });

        return compact('total', 'valid', 'invalid');
    }
}
