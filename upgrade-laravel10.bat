@echo off
echo ======================================
echo Laravel 10 and PHP 8.2 Upgrade Script
echo ======================================
echo.

REM Check PHP Version
echo Checking PHP version...
php -v
echo.

REM Upgrade Main Project
echo ======================================
echo Upgrading Main Project...
echo ======================================
cd /d C:\xampp\htdocs\rightchoiceco

echo Removing vendor directory and composer.lock...
if exist vendor rmdir /s /q vendor
if exist composer.lock del /f composer.lock

echo Running composer install...
composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed for main project!
    pause
    exit /b 1
)

echo Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled

echo Optimizing...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ======================================
echo Upgrading Admin Project...
echo ======================================
cd /d C:\xampp\htdocs\rightchoiceco\admin

echo Removing vendor directory and composer.lock...
if exist vendor rmdir /s /q vendor
if exist composer.lock del /f composer.lock

echo Running composer install...
composer install --no-interaction --prefer-dist --optimize-autoloader
if %errorlevel% neq 0 (
    echo ERROR: Composer install failed for admin project!
    pause
    exit /b 1
)

echo Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled

echo Optimizing...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ======================================
echo Upgrade Complete!
echo ======================================
echo.
echo Please test the following:
echo - Login functionality
echo - API endpoints
echo - Admin panel
echo - Database connections
echo - File uploads
echo.
pause
