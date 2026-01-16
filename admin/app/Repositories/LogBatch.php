<?php

namespace App\Repositories;

use Closure;
use Ramsey\Uuid\Uuid;

class LogBatch
{
    public  $uuid = null;

    public $transactions = 0;

    protected function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setBatch(string $uuid): void
    {
        $this->uuid = $uuid;
        $this->transactions = 1;
    }


    public function startBatch(): void
    {
        if (! $this->isOpen()) {
            $this->uuid = $this->generateUuid();
        }

        $this->transactions++;
    }

    public function isOpen(): bool
    {
        return $this->transactions > 0;
    }

    public function endBatch(): void
    {
        $this->transactions = max(0, $this->transactions - 1);

        if ($this->transactions === 0) {
            $this->uuid = null;
        }
    }
}
