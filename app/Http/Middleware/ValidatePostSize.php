<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePostSize
{
    /**
     * Handle an incoming request.
     * تم تعطيل التحقق من حجم الطلب للسماح برفع ملفات كبيرة حتى 1GB
     * الحد يتحكم فيه php.ini و .htaccess على السيرفر مباشرة
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
