# Laravel 10 & PHP 8.2 Upgrade Checklist
# قائمة التحقق من الترقية

## Pre-Upgrade / قبل الترقية
- [ ] Backup database / نسخ قاعدة البيانات احتياطياً
- [ ] Backup files / نسخ الملفات احتياطياً
- [ ] Test on development environment first / اختبر على بيئة التطوير أولاً
- [ ] Document current PHP version / توثيق إصدار PHP الحالي
- [ ] Document current Laravel version / توثيق إصدار Laravel الحالي

## PHP Requirements / متطلبات PHP
- [ ] Update XAMPP to PHP 8.2 / تحديث XAMPP إلى PHP 8.2
- [ ] Verify PHP 8.2 is active: `php -v`
- [ ] Check PHP extensions are enabled:
  - [ ] mbstring
  - [ ] openssl
  - [ ] pdo
  - [ ] tokenizer
  - [ ] xml
  - [ ] ctype
  - [ ] json
  - [ ] bcmath
  - [ ] fileinfo
  - [ ] gd

## Files Already Updated / الملفات التي تم تحديثها
✅ composer.json (main project)
✅ composer.json (admin project)
✅ app/Http/Kernel.php (main project)
✅ app/Http/Kernel.php (admin project)
✅ app/Http/Middleware/TrustProxies.php (main project)
✅ app/Http/Middleware/TrustProxies.php (admin project)
✅ phpunit.xml (main project)
✅ phpunit.xml (admin project)

## Installation Steps / خطوات التثبيت

### Method 1: Run the Batch Script / الطريقة 1: تشغيل ملف BAT
- [ ] Double-click `upgrade-laravel10.bat`
- [ ] Wait for completion / انتظر حتى يكتمل
- [ ] Check for errors / تحقق من الأخطاء

### Method 2: Run PowerShell Script / الطريقة 2: تشغيل PowerShell
- [ ] Open PowerShell as Administrator
- [ ] Run: `.\upgrade-laravel10.ps1`
- [ ] Wait for completion
- [ ] Check for errors

### Method 3: Manual Installation / الطريقة 3: التثبيت اليدوي

#### Main Project / المشروع الرئيسي
```bash
cd C:\xampp\htdocs\rightchoiceco
rm -rf vendor
rm composer.lock
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Admin Project / مشروع الأدمن
```bash
cd C:\xampp\htdocs\rightchoiceco\admin
rm -rf vendor
rm composer.lock
composer install --no-interaction --prefer-dist --optimize-autoloader
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Post-Upgrade Testing / الاختبار بعد الترقية

### Main Application / التطبيق الرئيسي
- [ ] Home page loads / الصفحة الرئيسية تعمل
- [ ] User registration / تسجيل المستخدمين
- [ ] User login / تسجيل الدخول
- [ ] User logout / تسجيل الخروج
- [ ] Password reset / إعادة تعيين كلمة المرور
- [ ] Email verification / التحقق من البريد الإلكتروني
- [ ] API endpoints / نقاط API
- [ ] File uploads / رفع الملفات
- [ ] Image processing / معالجة الصور
- [ ] Database queries / استعلامات قاعدة البيانات
- [ ] Search functionality / وظيفة البحث
- [ ] Forms submission / إرسال النماذج

### Admin Panel / لوحة الأدمن
- [ ] Admin login / تسجيل دخول الأدمن
- [ ] Dashboard loads / لوحة التحكم تعمل
- [ ] CRUD operations / عمليات CRUD
- [ ] DataTables work / جداول البيانات تعمل
- [ ] Forms work / النماذج تعمل
- [ ] File uploads work / رفع الملفات يعمل
- [ ] Reports generation / توليد التقارير
- [ ] Export functions / وظائف التصدير

### Performance / الأداء
- [ ] Page load times / أوقات تحميل الصفحات
- [ ] Database query speed / سرعة استعلامات قاعدة البيانات
- [ ] Memory usage / استخدام الذاكرة
- [ ] Error logs / سجلات الأخطاء

## Common Issues & Solutions / المشاكل الشائعة والحلول

### Issue: Composer install fails
**Solution:**
```bash
composer clear-cache
composer install --ignore-platform-reqs
```

### Issue: Class not found
**Solution:**
```bash
composer dump-autoload
php artisan clear-compiled
```

### Issue: Middleware errors
**Solution:**
- Check that `$routeMiddleware` is replaced with `$middlewareAliases` in Kernel.php
- Clear config: `php artisan config:clear`

### Issue: Database connection errors
**Solution:**
- Check .env file
- Verify database credentials
- Test connection: `php artisan migrate:status`

### Issue: Route errors
**Solution:**
```bash
php artisan route:clear
php artisan route:cache
```

### Issue: View errors
**Solution:**
```bash
php artisan view:clear
php artisan view:cache
```

### Issue: Permission denied
**Solution:**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
On Windows XAMPP, right-click folders > Properties > Security > Edit

## Additional Changes to Consider / تغييرات إضافية يجب مراعاتها

### 1. String & Float Helpers (Deprecated in Laravel 9, Removed in Laravel 10)
If using string helpers, install package:
```bash
composer require laravel/helpers
```
Or update to use `Illuminate\Support\Str` and `Illuminate\Support\Arr`

### 2. Date Casts Update
Old:
```php
protected $dates = ['published_at'];
```
New:
```php
protected $casts = [
    'published_at' => 'datetime',
];
```

### 3. Route Model Binding
Laravel 10 uses scoped binding by default. Update if needed.

### 4. Eloquent getAttribute & setAttribute
These methods now have return type hints. Update custom implementations.

### 5. Public Path Binding
If using custom public path, update in `public/index.php`

## Verification Commands / أوامر التحقق

```bash
# Check PHP version
php -v

# Check Laravel version
php artisan --version

# Check installed packages
composer show

# Run tests
php artisan test

# Check for outdated packages
composer outdated

# Security audit
composer audit
```

## Rollback Plan / خطة التراجع

If upgrade fails:
1. Restore database backup
2. Restore file backup
3. Run: `composer install` with old composer.lock
4. Clear caches

## Notes / ملاحظات

- Laravel 10 requires PHP 8.1 or 8.2
- Minimum stability should be "stable" not "dev"
- Some packages may not be compatible yet - check each package
- Test thoroughly before deploying to production
- Monitor error logs after upgrade

## Support Resources / موارد الدعم

- Laravel 10 Documentation: https://laravel.com/docs/10.x
- Laravel Upgrade Guide: https://laravel.com/docs/10.x/upgrade
- PHP 8.2 Documentation: https://www.php.net/releases/8.2/
- Laravel News: https://laravel-news.com/
- Laracasts: https://laracasts.com/

---

## Sign-off / التوقيع

- [ ] Upgrade completed successfully
- [ ] All tests passed
- [ ] Production deployment approved
- Completed by: _______________
- Date: _______________
- Verified by: _______________
