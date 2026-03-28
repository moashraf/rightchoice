<?php

namespace App\Contracts;

use App\Services\Whatsapp\WhatsappSendResult;

interface WhatsappProviderInterface
{
    public function getName(): string;
    public function send(string $mobile, string $message): WhatsappSendResult;
}
