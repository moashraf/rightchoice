@echo off
REM Admin Laravel 10 Quick Test Script
REM سكريبت اختبار سريع لمشروع Admin مع Laravel 10

echo ================================================
echo   Admin Laravel 10 - Quick Test
echo ================================================
echo.

cd /d C:\xampp\htdocs\rightchoiceco\admin

echo [1/5] Checking PHP Version...
php -v | findstr "PHP"
echo.

echo [2/5] Checking Laravel Version...
php -r "require 'vendor/autoload.php'; $app = require_once 'bootstrap/app.php'; echo 'Laravel ' . $app->version() . PHP_EOL;"
echo.

echo [3/5] Clearing all caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
echo ✓ Caches cleared
echo.

echo [4/5] Checking for errors...
php artisan list >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    echo ✓ Laravel commands are working
) else (
    echo ✗ Error detected - check logs
)
echo.

echo [5/5] Generating optimized files...
php artisan config:cache
php artisan route:cache
echo ✓ Optimization complete
echo.

echo ================================================
echo   Test Complete!
echo ================================================
echo.
echo To start the server, run:
echo   php artisan serve
echo.
echo Or visit: http://localhost/rightchoiceco/admin/public
echo.

pause
