# دليل الترقية إلى Laravel 10 و PHP 8.2
# Upgrade Guide to Laravel 10 & PHP 8.2

## التغييرات المطلوبة (Required Changes)

### 1. متطلبات PHP (PHP Requirements)
- PHP 8.1 أو 8.2 مطلوب (PHP 8.1 or 8.2 required)
- تأكد من تحديث PHP على XAMPP (Make sure to update PHP in XAMPP)

### 2. الملفات المحدثة (Updated Files)

#### ✅ تم تحديث الملفات التالية (Following files have been updated):

1. **composer.json** (الرئيسي والأدمن / Main & Admin)
   - Laravel Framework: 8.x → 10.x
   - PHP: ^7.3|^8.0 → ^8.1|^8.2
   - PHPUnit: ^9.3 → ^10.0
   - تمت إزالة fideloper/proxy (Removed - now built into Laravel)
   - تمت إزالة fruitcake/laravel-cors (Removed - now built into Laravel)
   - تمت إزالة facade/ignition → spatie/laravel-ignition

2. **app/Http/Kernel.php** (الرئيسي والأدمن / Main & Admin)
   - `$routeMiddleware` → `$middlewareAliases`
   - تمت إزالة `\Fruitcake\Cors\HandleCors::class`

3. **app/Http/Middleware/TrustProxies.php** (الرئيسي والأدمن / Main & Admin)
   - `Fideloper\Proxy\TrustProxies` → `Illuminate\Http\Middleware\TrustProxies`

### 3. خطوات التثبيت (Installation Steps)

#### خطوة 1: تحديث PHP (Step 1: Update PHP)
```bash
# تأكد من أن PHP 8.2 مثبت على XAMPP
# Make sure PHP 8.2 is installed in XAMPP
php -v
```

#### خطوة 2: حذف vendor والتثبيت من جديد (Step 2: Delete vendor and reinstall)
```bash
# للمشروع الرئيسي (For main project)
cd C:\xampp\htdocs\rightchoiceco
rm -rf vendor
rm composer.lock
composer install

# للأدمن (For admin)
cd C:\xampp\htdocs\rightchoiceco\admin
rm -rf vendor
rm composer.lock
composer install
```

#### خطوة 3: تحديث ملفات الكونفج (Step 3: Update config files)
```bash
# للمشروع الرئيسي
cd C:\xampp\htdocs\rightchoiceco
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# للأدمن
cd C:\xampp\htdocs\rightchoiceco\admin
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 4. تغييرات إضافية قد تحتاجها (Additional Changes You May Need)

#### Livewire 3 Migration
Livewire has been upgraded to version 3. Key changes:
- Component class names changed from `Component` to fully qualified
- Wire directives syntax may need updates
- See: https://livewire.laravel.com/docs/upgrading

Common changes needed:
```php
// Old Livewire 2
protected $listeners = ['eventName'];

// New Livewire 3  
#[On('eventName')]
public function handleEvent() {}
```

#### CORS Configuration
في Laravel 10، CORS مدمج الآن. يجب التحقق من `config/cors.php`:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['*'],
'allowed_origins_patterns' => [],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => false,
```

#### Database Migrations
تحقق من الـ migrations خصوصاً:
- استخدام `foreignId()` بدلاً من `unsignedBigInteger()`
- تحديث أي `date` casts إلى format جديد

#### Model Changes
في Laravel 10:
```php
// Old
protected $dates = ['created_at'];

// New
protected $casts = [
    'created_at' => 'datetime',
];
```

### 5. اختبار التطبيق (Testing the Application)

بعد التحديث، اختبر:
1. ✅ تسجيل الدخول / Login
2. ✅ APIs
3. ✅ Routes الرئيسية / Main routes
4. ✅ Admin panel
5. ✅ Database connections
6. ✅ File uploads
7. ✅ Email functionality

### 6. مشاكل شائعة والحلول (Common Issues & Solutions)

#### مشكلة: Class not found
```bash
composer dump-autoload
```

#### مشكلة: Method not found
تحقق من التغييرات في Laravel 10 API

#### مشكلة: Middleware errors
تأكد من تحديث `$middlewareAliases` في Kernel.php

### 7. موارد إضافية (Additional Resources)

- Laravel 10 Upgrade Guide: https://laravel.com/docs/10.x/upgrade
- Laravel 10 Release Notes: https://laravel.com/docs/10.x/releases
- PHP 8.2 New Features: https://www.php.net/releases/8.2/en.php

---

## ملاحظات مهمة (Important Notes)

⚠️ **قبل التحديث على الإنتاج:**
1. خذ نسخة احتياطية من قاعدة البيانات (Backup database)
2. خذ نسخة احتياطية من الملفات (Backup files)
3. اختبر على بيئة تطوير أولاً (Test on development first)

✅ **بعد التحديث:**
1. راجع جميع الـ logs (Check all logs)
2. اختبر جميع الوظائف (Test all features)
3. راقب الأداء (Monitor performance)
