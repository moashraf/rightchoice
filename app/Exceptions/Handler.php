<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use App\Models\ErrorLog;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Exception types that should NOT be logged to error_logs table.
     */
    protected $dontLogToDb = [
        ValidationException::class,
        NotFoundHttpException::class,
        \Illuminate\Auth\AuthenticationException::class,
        \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            $this->logErrorToDatabase($e);
        });
    }

    /**
     * Log exception to the error_logs database table.
     */
    protected function logErrorToDatabase(Throwable $e): void
    {
        // Don't log certain exception types
        foreach ($this->dontLogToDb as $type) {
            if ($e instanceof $type) {
                return;
            }
        }

        try {
            $message = mb_substr($e->getMessage(), 0, 65535);
            $file    = $e->getFile();
            $line    = $e->getLine();

            // Capture the URL where the error occurred
            $url = null;
            try {
                $url = request()->fullUrl();
            } catch (\Throwable $urlEx) {
                // URL may not be available in console context
            }

            $existing = ErrorLog::where('message', $message)
                ->where('file', $file)
                ->where('line', $line)
                ->first();

            if ($existing) {
                $existing->increment('count');
                $existing->update([
                    'last_occurred_at' => now(),
                    'url'              => $url ?? $existing->url,
                ]);
            } else {
                ErrorLog::create([
                    'type'              => get_class($e),
                    'message'           => $message,
                    'file'              => $file,
                    'line'              => $line,
                    'trace'             => $e->getTraceAsString(),
                    'url'               => $url,
                    'count'             => 1,
                    'first_occurred_at' => now(),
                    'last_occurred_at'  => now(),
                ]);
            }
        } catch (\Throwable $ex) {
            // Silently fail to avoid infinite loop
        }
    }







}
