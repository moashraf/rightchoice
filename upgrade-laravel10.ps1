# Laravel 10 and PHP 8.2 Upgrade Script (PowerShell)
Write-Host "======================================" -ForegroundColor Cyan
Write-Host "Laravel 10 and PHP 8.2 Upgrade Script" -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Cyan
Write-Host ""

# Check PHP Version
Write-Host "Checking PHP version..." -ForegroundColor Yellow
php -v
Write-Host ""

# Upgrade Main Project
Write-Host "======================================" -ForegroundColor Cyan
Write-Host "Upgrading Main Project..." -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Cyan
Set-Location -Path "C:\xampp\htdocs\rightchoiceco"

Write-Host "Removing vendor directory and composer.lock..." -ForegroundColor Yellow
if (Test-Path "vendor") { Remove-Item -Recurse -Force "vendor" }
if (Test-Path "composer.lock") { Remove-Item -Force "composer.lock" }

Write-Host "Running composer install..." -ForegroundColor Yellow
composer install --no-interaction --prefer-dist --optimize-autoloader
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Composer install failed for main project!" -ForegroundColor Red
    pause
    exit 1
}

Write-Host "Clearing caches..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled

Write-Host "Optimizing..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host ""
Write-Host "======================================" -ForegroundColor Cyan
Write-Host "Upgrading Admin Project..." -ForegroundColor Cyan
Write-Host "======================================" -ForegroundColor Cyan
Set-Location -Path "C:\xampp\htdocs\rightchoiceco\admin"

Write-Host "Removing vendor directory and composer.lock..." -ForegroundColor Yellow
if (Test-Path "vendor") { Remove-Item -Recurse -Force "vendor" }
if (Test-Path "composer.lock") { Remove-Item -Force "composer.lock" }

Write-Host "Running composer install..." -ForegroundColor Yellow
composer install --no-interaction --prefer-dist --optimize-autoloader
if ($LASTEXITCODE -ne 0) {
    Write-Host "ERROR: Composer install failed for admin project!" -ForegroundColor Red
    pause
    exit 1
}

Write-Host "Clearing caches..." -ForegroundColor Yellow
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan clear-compiled

Write-Host "Optimizing..." -ForegroundColor Yellow
php artisan config:cache
php artisan route:cache
php artisan view:cache

Write-Host ""
Write-Host "======================================" -ForegroundColor Green
Write-Host "Upgrade Complete!" -ForegroundColor Green
Write-Host "======================================" -ForegroundColor Green
Write-Host ""
Write-Host "Please test the following:" -ForegroundColor Yellow
Write-Host "- Login functionality"
Write-Host "- API endpoints"
Write-Host "- Admin panel"
Write-Host "- Database connections"
Write-Host "- File uploads"
Write-Host ""
pause
