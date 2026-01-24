# دليل إصلاح مشاكل الموديلات على السيرفر المباشر
# Models Fix Guide for Live Server

## المشكلة | Problem
```
Target class [App\Models\blog] does not exist.
```

هذا الخطأ يحدث لأن أسماء الكلاسات في PHP حساسة لحالة الأحرف (Case-Sensitive)

## الملفات التي تم إصلاحها | Fixed Files

### Admin Panel Models (admin/app/Models/):
✅ Blog.php - `class blog` → `class Blog` (اسم الملف والكلاس صحيح)
✅ aqar.php → **Aqar.php** - `class aqar` → `class Aqar`
✅ aqar_category.php → **AqarCategory.php** - `class aqar_category` → `class AqarCategory`
✅ aqar_mzaya.php → **AqarMzaya.php** - `class aqar_mzaya` → `class AqarMzaya`
✅ archive.php → **Archive.php** - `class archive` → `class Archive`
✅ call_time.php → **CallTime.php** - `class call_time` → `class CallTime`
✅ Compound.php - `class compound` → `class Compound` (اسم الملف صحيح)
✅ District.php - `class district` → `class District` (اسم الملف صحيح)
✅ district_test.php → **DistrictTest.php** - `class district_test` → `class DistrictTest`
✅ Finish_type.php - `class finish_type` → `class FinishType` (اسم الملف صحيح)

### Main App Models (app/Models/):
✅ aqar.php → **Aqar.php** - `class aqar` → `class Aqar`
✅ aqar_category.php → **AqarCategory.php** - `class aqar_category` → `class AqarCategory`
✅ aqar_mzaya.php → **AqarMzaya.php** - `class aqar_mzaya` → `class AqarMzaya`
✅ archive.php → **Archive.php** - `class archive` → `class Archive`
✅ call_time.php → **CallTime.php** - `class call_time` → `class CallTime`
✅ district_test.php → **DistrictTest.php** - `class district_test` → `class DistrictTest`
✅ license_type.php → **LicenseType.php** - `class license_type` → `class LicenseType`
✅ offer_type.php → **OfferType.php** - `class offer_type` → `class OfferType`
✅ priceing_sale.php → **PriceingSale.php** - `class priceing_sale` → `class PriceingSale`
✅ property_type.php → **PropertyType.php** - `class property_type` → `class PropertyType`

⚠️ **مهم جداً:** تم إعادة تسمية الملفات لتتطابق مع أسماء الكلاسات (PSR-4 Standard)

---

## خطوات التطبيق على السيرفر المباشر | Live Server Deployment Steps

### الطريقة الأولى: باستخدام SSH Terminal

```bash
# 1. الدخول إلى مجلد المشروع
cd /home/username/public_html

# 2. تنظيف جميع أنواع الكاش
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 3. إعادة بناء الكاش
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. إعادة تحميل Autoload
composer dump-autoload

# 5. نفس الخطوات لمجلد Admin
cd admin
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload
```

### الطريقة الثانية: باستخدام File Manager (بدون SSH)

#### الخطوة 1: رفع الملفات المعدلة
1. افتح **File Manager** في cPanel
2. ⚠️ **مهم جداً:** يجب إعادة تسمية الملفات بنفس الأسماء الجديدة عند الرفع:

**في المجلد `app/Models/`:**
- ❌ احذف: `aqar.php` → ✅ ارفع: `Aqar.php`
- ❌ احذف: `aqar_category.php` → ✅ ارفع: `AqarCategory.php`
- ❌ احذف: `aqar_mzaya.php` → ✅ ارفع: `AqarMzaya.php`
- ❌ احذف: `archive.php` → ✅ ارفع: `Archive.php`
- ❌ احذف: `call_time.php` → ✅ ارفع: `CallTime.php`
- ❌ احذف: `district_test.php` → ✅ ارفع: `DistrictTest.php`
- ❌ احذف: `license_type.php` → ✅ ارفع: `LicenseType.php`
- ❌ احذف: `offer_type.php` → ✅ ارفع: `OfferType.php`
- ❌ احذف: `priceing_sale.php` → ✅ ارفع: `PriceingSale.php`
- ❌ احذف: `property_type.php` → ✅ ارفع: `PropertyType.php`

**في المجلد `admin/app/Models/`:**
- ❌ احذف: `aqar.php` → ✅ ارفع: `Aqar.php`
- ❌ احذف: `aqar_category.php` → ✅ ارفع: `AqarCategory.php`
- ❌ احذف: `aqar_mzaya.php` → ✅ ارفع: `AqarMzaya.php`
- ❌ احذف: `archive.php` → ✅ ارفع: `Archive.php`
- ❌ احذف: `call_time.php` → ✅ ارفع: `CallTime.php`
- ❌ احذف: `district_test.php` → ✅ ارفع: `DistrictTest.php`
- ✅ استبدل: `Blog.php`, `Compound.php`, `District.php`, `Finish_type.php`

3. تأكد من استبدال الملفات القديمة

#### الخطوة 2: استخدام ملف clear-cache.php
تم إنشاء ملفين لتنظيف الكاش:

**للموقع الرئيسي:**
- ارفع الملف `public/clear-cache.php` إلى مجلد `public_html/public/`
- افتح الرابط: `https://yourdomain.com/clear-cache.php`
- احذف الملف فوراً بعد الاستخدام

**للوحة الإدارة:**
- ارفع الملف `admin/public/clear-cache.php` إلى مجلد `public_html/admin/public/`
- افتح الرابط: `https://yourdomain.com/admin/public/clear-cache.php`
- احذف الملف فوراً بعد الاستخدام

---

## الطريقة الثالثة: إنشاء ملف مخصص لتنفيذ الأوامر

أنشئ ملف باسم `run-commands.php` في مجلد `public`:

```php
<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$commands = [
    'cache:clear',
    'config:clear',
    'route:clear',
    'view:clear',
    'config:cache',
    'route:cache',
    'view:cache',
];

foreach ($commands as $command) {
    Artisan::call($command);
    echo "✓ {$command} executed\n";
}
echo "\n✓ All commands completed successfully!";
```

---

## التحقق من نجاح العملية | Verification

بعد تطبيق الخطوات، تحقق من:

1. ✅ عدم ظهور خطأ `Target class [App\Models\xxx] does not exist`
2. ✅ جميع الصفحات تعمل بشكل صحيح
3. ✅ لوحة الإدارة تعمل بدون مشاكل

---

## صلاحيات الملفات | File Permissions

تأكد من أن الصلاحيات صحيحة:

```bash
# للملفات
chmod 644 app/Models/*.php
chmod 644 admin/app/Models/*.php

# للمجلدات
chmod 755 storage -R
chmod 755 bootstrap/cache -R
```

---

## ملاحظات مهمة | Important Notes

⚠️ **تحذير أمني:** احذف ملفات `clear-cache.php` فوراً بعد استخدامها

⚠️ **النسخ الاحتياطي:** قم بأخذ نسخة احتياطية من الموقع قبل تطبيق التغييرات

✅ **التوافقية:** هذه التغييرات متوافقة مع Laravel 8/9/10

---

## الدعم الفني | Technical Support

إذا واجهت أي مشاكل:
1. تحقق من ملفات الـ logs: `storage/logs/laravel.log`
2. تأكد من أن composer.json محدث
3. قم بتشغيل `composer dump-autoload` مرة أخرى

---

تاريخ التحديث: 24 يناير 2026
