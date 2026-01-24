<?php
/**
 * Clear Cache Script
 * استخدم هذا الملف لتنظيف الكاش على السيرفر المباشر
 *
 * Instructions:
 * 1. ارفع هذا الملف إلى مجلد public على السيرفر
 * 2. افتح الرابط: https://yourdomain.com/clear-cache.php
 * 3. احذف الملف فوراً بعد الاستخدام لأسباب أمنية
 */

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require_once __DIR__.'/../bootstrap/app.php';

    $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
    $kernel->bootstrap();

    echo "<h1>تنظيف الكاش - Cache Clearing</h1>";
    echo "<pre>";

    // Clear all caches
    Artisan::call('cache:clear');
    echo "✓ Cache cleared\n";

    Artisan::call('config:clear');
    echo "✓ Config cache cleared\n";

    Artisan::call('route:clear');
    echo "✓ Route cache cleared\n";

    Artisan::call('view:clear');
    echo "✓ View cache cleared\n";

    // Rebuild caches
    Artisan::call('config:cache');
    echo "✓ Config cached\n";

    Artisan::call('route:cache');
    echo "✓ Routes cached\n";

    Artisan::call('view:cache');
    echo "✓ Views cached\n";

    echo "\n";
    echo "===================================\n";
    echo "✓ تم تنظيف وإعادة بناء الكاش بنجاح!\n";
    echo "✓ Cache cleared and rebuilt successfully!\n";
    echo "===================================\n";
    echo "\n";
    echo "⚠️  احذف هذا الملف الآن لأسباب أمنية!\n";
    echo "⚠️  DELETE THIS FILE NOW FOR SECURITY!\n";

    echo "</pre>";

} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "<pre style='color: red;'>";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "</pre>";
}
