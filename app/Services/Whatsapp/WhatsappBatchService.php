<?php

namespace App\Services\Whatsapp;

use App\Contracts\WhatsappProviderInterface;
use App\Enums\WhatsappBatchStatusEnum;
use App\Enums\WhatsappSendStatusEnum;
use App\Enums\WhatsappSendTypeEnum;
use App\Models\WhatsappBatch;
use App\Models\WhatsappBatchRecipient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WhatsappBatchService
{
    private WhatsappProviderInterface $provider;

    public function __construct(WhatsappProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    public function createBatch(string $messageTemplate, string $sendType, ?array $selectedUserIds = null): WhatsappBatch
    {
        return DB::transaction(function () use ($messageTemplate, $sendType, $selectedUserIds) {
            $batch = WhatsappBatch::create([
                'created_by_user_id' => Auth::guard('admin')->id(),
                'send_type'          => $sendType,
                'message_template'   => $messageTemplate,
                'overall_status'     => WhatsappBatchStatusEnum::PENDING,
                'provider_name'      => $this->provider->getName(),
            ]);

            $usersQuery = User::query()->select(['id', 'name', 'MOP']);

            if ($sendType === WhatsappSendTypeEnum::SELECTED_USERS && !empty($selectedUserIds)) {
                $usersQuery->whereIn('id', $selectedUserIds);
            }

            $totalRecipients = 0;
            $totalValid      = 0;
            $totalInvalid    = 0;

            $usersQuery->chunk(500, function ($users) use ($batch, $messageTemplate, &$totalRecipients, &$totalValid, &$totalInvalid) {
                $recipientRows = [];

                foreach ($users as $user) {
                    $totalRecipients++;

                    $validation = WhatsappPhoneValidator::validate($user->MOP);

                    $personalizedMessage = WhatsappMessagePersonalizer::personalize($messageTemplate, [
                        'name' => $user->name,
                    ]);

                    $sendStatus = $validation['valid']
                        ? WhatsappSendStatusEnum::PENDING
                        : WhatsappSendStatusEnum::INVALID_NUMBER;

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

                WhatsappBatchRecipient::insert($recipientRows);
            });

            $batch->update([
                'total_recipients'      => $totalRecipients,
                'total_valid_numbers'   => $totalValid,
                'total_invalid_numbers' => $totalInvalid,
            ]);

            return $batch->fresh();
        });
    }

    public function processBatch(WhatsappBatch $batch): void
    {
        $batch->update(['overall_status' => WhatsappBatchStatusEnum::PROCESSING]);

        $query = $batch->recipients()
                       ->where('validation_status', 'valid')
                       ->where('send_status', WhatsappSendStatusEnum::PENDING);

        $query->chunk(100, function ($recipients) {
            foreach ($recipients as $recipient) {
                $this->sendToRecipient($recipient);
            }
        });

        $batch->recalculateTotals();
    }

    public function sendToRecipient(WhatsappBatchRecipient $recipient): void
    {
        try {
            $recipient->updateStatus(WhatsappSendStatusEnum::SENDING, 'بدء الإرسال');

            $internationalMobile = WhatsappPhoneValidator::toInternational($recipient->normalized_mobile);

            $result = $this->provider->send(
                $internationalMobile,
                $recipient->personalized_message
            );

            if ($result->success) {
                $recipient->update([
                    'provider_message_id' => $result->messageId,
                    'provider_response'   => $result->rawResponse,
                ]);
                $recipient->updateStatus(
                    WhatsappSendStatusEnum::SENT,
                    'تم الإرسال بنجاح',
                    $result->rawResponse
                );
            } else {
                $recipient->update([
                    'provider_response' => $result->rawResponse,
                    'failure_reason'    => $result->failureReason,
                ]);
                $recipient->updateStatus(
                    WhatsappSendStatusEnum::FAILED,
                    $result->failureReason,
                    $result->rawResponse
                );
            }

        } catch (\Throwable $e) {
            Log::error('[WhatsappBatchService] Send error', [
                'recipient_id' => $recipient->id,
                'batch_id'     => $recipient->batch_id,
                'error'        => $e->getMessage(),
            ]);

            $recipient->update([
                'failure_reason' => 'Exception: ' . $e->getMessage(),
            ]);
            $recipient->updateStatus(
                WhatsappSendStatusEnum::FAILED,
                'خطأ غير متوقع: ' . $e->getMessage()
            );
        }
    }

    public function retryFailed(WhatsappBatch $batch): int
    {
        $failedRecipients = $batch->recipients()
            ->where('send_status', WhatsappSendStatusEnum::FAILED)
            ->where('validation_status', 'valid')
            ->get();

        $count = 0;
        foreach ($failedRecipients as $recipient) {
            $recipient->update([
                'send_status'    => WhatsappSendStatusEnum::PENDING,
                'failure_reason' => null,
            ]);
            $this->sendToRecipient($recipient);
            $count++;
        }

        $batch->recalculateTotals();

        return $count;
    }

    public static function previewRecipientCounts(string $sendType, ?array $selectedUserIds = null): array
    {
        $query = User::query()->select(['id', 'MOP']);

        if ($sendType === WhatsappSendTypeEnum::SELECTED_USERS && !empty($selectedUserIds)) {
            $query->whereIn('id', $selectedUserIds);
        }

        $total   = 0;
        $valid   = 0;
        $invalid = 0;

        $query->chunk(500, function ($users) use (&$total, &$valid, &$invalid) {
            foreach ($users as $user) {
                $total++;
                if (WhatsappPhoneValidator::isValid($user->MOP)) {
                    $valid++;
                } else {
                    $invalid++;
                }
            }
        });

        return compact('total', 'valid', 'invalid');
    }
}
