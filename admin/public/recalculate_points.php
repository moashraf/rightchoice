<?php
///**
// * =====================================================
// *  سكريبت إعادة حساب points_avail لجميع العقارات
// *  يعمل بشكل مستقل بدون Artisan
// *  المسار: admin/public/recalculate_points.php
// *  الاستخدام: http://localhost:7070/recalculate_points.php
// *             أو: php recalculate_points.php (CLI)
// * =====================================================
// */
//
//
//// ── إعدادات قاعدة البيانات (تُقرأ من .env) ───────────
//$envPath = __DIR__ . '/../.env';
//$db = loadEnv($envPath);
//
//$host     = $db['DB_HOST']     ?? '127.0.0.1';
//$port     = $db['DB_PORT']     ?? '3306';
//$dbName   = $db['DB_DATABASE'] ?? '';
//$username = $db['DB_USERNAME'] ?? 'root';
//$password = $db['DB_PASSWORD'] ?? '';
//
//// ── الاتصال بـ MySQL ──────────────────────────────────
//try {
//    $pdo = new PDO(
//        "mysql:host={$host};port={$port};dbname={$dbName};charset=utf8mb4",
//        $username,
//        $password,
//        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
//    );
//} catch (PDOException $e) {
//    die("❌ فشل الاتصال بقاعدة البيانات: " . $e->getMessage());
//}
//
//// ── جلب جميع العقارات (بما فيها المحذوفة) ────────────
//$stmt = $pdo->query("SELECT id, offer_type, total_price, monthly_rent FROM aqar");
//$aqars = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//$total   = count($aqars);
//$updated = 0;
//$skipped = 0;
//$errors  = [];
//
//outputLine("==============================================");
//outputLine(" إعادة حساب points_avail للعقارات");
//outputLine("==============================================");
//outputLine("إجمالي العقارات: {$total}");
//outputLine("----------------------------------------------");
//
//// ── إعداد الـ UPDATE مرة واحدة ───────────────────────
//$updateStmt = $pdo->prepare("UPDATE aqar SET points_avail = :points_avail WHERE id = :id");
//
//foreach ($aqars as $aqar) {
//    $id          = $aqar['id'];
//    $offerType   = (int)$aqar['offer_type'];
//    $totalPrice  = (float)$aqar['total_price'];
//    $monthlyRent = (float)$aqar['monthly_rent'];
//
//    // offer_type 1 = بيع، 2 = تجاري، 5 = تمليك → pointCalculate
//    if (in_array($offerType, [1, 2, 5])) {
//        if ($totalPrice <= 0) {
//            $skipped++;
//            outputLine("⚠️  تخطي ID={$id} (total_price = 0)");
//            continue;
//        }
//        $points_avail = pointCalculate($totalPrice);
//    } else {
//        // إيجار → pointCalculateRent
//        if ($monthlyRent <= 0) {
//            $skipped++;
//            outputLine("⚠️  تخطي ID={$id} (monthly_rent = 0)");
//            continue;
//        }
//        $points_avail = pointCalculateRent($monthlyRent);
//    }
//
//    try {
//        $updateStmt->execute([':points_avail' => $points_avail, ':id' => $id]);
//        $updated++;
//        outputLine("✅ ID={$id} → points_avail = {$points_avail}");
//    } catch (PDOException $e) {
//        $errors[] = "ID={$id}: " . $e->getMessage();
//    }
//}
//
//outputLine("----------------------------------------------");
//outputLine("✅ تم التحديث : {$updated}");
//outputLine("⚠️  تم التخطي : {$skipped}");
//outputLine("❌ أخطاء       : " . count($errors));
//outputLine("==============================================");
//
//if (!empty($errors)) {
//    outputLine("تفاصيل الأخطاء:");
//    foreach ($errors as $err) {
//        outputLine("  - " . $err);
//    }
//}
//
//outputLine("✔ انتهى السكريبت بنجاح.");
//
//// ════════════════════════════════════════════════════
////  دوال مساعدة
//// ════════════════════════════════════════════════════
//
///**
// * حساب النقاط للبيع   (price ÷ 100,000)
// */
//function pointCalculate(float $price): float
//{
//    return (float) number_format($price / 100000, 2, '.', '');
//}
//
///**
// * حساب النقاط للإيجار (price ÷ 500)
// */
//function pointCalculateRent(float $price): float
//{
//    return (float) number_format($price / 500, 2, '.', '');
//}
//
///**
// * طباعة سطر نصي (يدعم CLI والمتصفح)
// */
//function outputLine(string $text): void
//{
//    if (php_sapi_name() === 'cli') {
//        echo $text . PHP_EOL;
//    } else {
//        echo htmlspecialchars($text) . "<br>\n";
//    }
//}
//
///**
// * قراءة ملف .env وإرجاعه كـ array مفتاح => قيمة
// */
//function loadEnv(string $path): array
//{
//    $result = [];
//    if (!file_exists($path)) {
//        return $result;
//    }
//    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
//    foreach ($lines as $line) {
//        $line = trim($line);
//        if ($line === '' || str_starts_with($line, '#')) {
//            continue;
//        }
//        if (strpos($line, '=') !== false) {
//            [$key, $value] = explode('=', $line, 2);
//            $result[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
//        }
//    }
//    return $result;
//}
