<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePostSize
{
    /**
     * Handle an incoming request.
     * Override Laravel's default ValidatePostSize to allow up to 1GB uploads.
     */
    public function handle(Request $request, Closure $next)
    {
        $max = $this->getPostMaxSize();

        // إذا كان حجم الطلب أكبر من الحد المسموح به في php.ini
        if ($max > 0 && $request->server('CONTENT_LENGTH') > $max) {
            throw new \Illuminate\Http\Exceptions\PostTooLargeException;
        }

        return $next($request);
    }

    /**
     * Determine the server 'post_max_size' as bytes.
     * Returns 0 if unlimited (-1 or not set).
     */
    protected function getPostMaxSize(): int
    {
        // نقرأ القيمة من php.ini الحالي
        $postMaxSize = ini_get('post_max_size');

        if (trim($postMaxSize) === '' || trim($postMaxSize) === '-1') {
            return 0; // بلا حد
        }

        $bytes = $this->convertToBytes($postMaxSize);

        return $bytes;
    }

    protected function convertToBytes(string $value): int
    {
        $value = trim($value);
        $unit  = strtolower(substr($value, -1));
        $bytes = (int) $value;

        switch ($unit) {
            case 'g': $bytes *= 1024;
            // no break
            case 'm': $bytes *= 1024;
            // no break
            case 'k': $bytes *= 1024;
        }

        return $bytes;
    }
}
