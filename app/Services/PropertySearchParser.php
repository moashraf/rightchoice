<?php

namespace App\Services;

use App\Models\Governrate;
use App\Models\District;
use App\Models\SubArea;
use App\Models\Compound;
use App\Models\Category;
use App\Models\TypeOfProp;
use App\Models\OfferTypes;
use App\Models\Finish_type;
use App\Models\Mzaya;

class PropertySearchParser
{
    protected $filters = [];
    protected $followUpQuestions = [];
    protected $detectedIntents = [];

    /**
     * Property type mappings (Arabic keywords → DB property_type IDs will be resolved dynamically)
     */
    protected $propertyTypeKeywords = [
        'شقة' => 'شقة',
        'شقه' => 'شقة',
        'شقق' => 'شقة',
        'apartment' => 'شقة',
        'فيلا' => 'فيلا',
        'فلل' => 'فيلا',
        'villa' => 'فيلا',
        'دوبلكس' => 'دوبلكس',
        'duplex' => 'دوبلكس',
        'بنتهاوس' => 'بنتهاوس',
        'penthouse' => 'بنتهاوس',
        'استوديو' => 'استوديو',
        'studio' => 'استوديو',
        'مكتب' => 'مكتب',
        'مكاتب' => 'مكتب',
        'office' => 'مكتب',
        'محل' => 'محل',
        'محلات' => 'محل',
        'shop' => 'محل',
        'ارض' => 'ارض',
        'أرض' => 'ارض',
        'اراضي' => 'ارض',
        'أراضي' => 'ارض',
        'land' => 'ارض',
        'عماره' => 'عمارة',
        'عمارة' => 'عمارة',
        'عماره' => 'عمارة',
        'building' => 'عمارة',
        'شاليه' => 'شاليه',
        'chalet' => 'شاليه',
        'توين هاوس' => 'توين هاوس',
        'تاون هاوس' => 'تاون هاوس',
        'townhouse' => 'تاون هاوس',
    ];

    /**
     * Offer type mappings
     */
    protected $offerTypeKeywords = [
        // Cash sale
        'كاش' => 1,
        'cash' => 1,
        'نقدي' => 1,
        'للبيع كاش' => 1,
        // Installment
        'تقسيط' => 2,
        'بالتقسيط' => 2,
        'اقساط' => 2,
        'أقساط' => 2,
        'installment' => 2,
        // Rent new law
        'ايجار' => 3,
        'إيجار' => 3,
        'للايجار' => 3,
        'للإيجار' => 3,
        'rent' => 3,
        'اجار' => 3,
        // Rent furnished
        'مفروش' => 4,
        'مفروشة' => 4,
        'مفروشه' => 4,
        'furnished' => 4,
        // Finance
        'تمويل' => 5,
        'تمويل عقاري' => 5,
        'finance' => 5,
        'بنك' => 5,
    ];

    /**
     * Finish type keywords
     */
    protected $finishTypeKeywords = [
        'سوبر لوكس' => 'سوبر لوكس',
        'سوبرلوكس' => 'سوبر لوكس',
        'super lux' => 'سوبر لوكس',
        'لوكس' => 'لوكس',
        'lux' => 'لوكس',
        'نص تشطيب' => 'نصف تشطيب',
        'نصف تشطيب' => 'نصف تشطيب',
        'semi finished' => 'نصف تشطيب',
        'بدون تشطيب' => 'بدون تشطيب',
        'علي الطوب' => 'بدون تشطيب',
        'على الطوب' => 'بدون تشطيب',
        'على المحاره' => 'بدون تشطيب',
        'علي المحاره' => 'بدون تشطيب',
        'unfinished' => 'بدون تشطيب',
        'الترا سوبر لوكس' => 'الترا سوبر لوكس',
        'ultra' => 'الترا سوبر لوكس',
        'متشطبة' => 'سوبر لوكس',
        'متشطبه' => 'سوبر لوكس',
        'تشطيب كامل' => 'سوبر لوكس',
    ];

    /**
     * Parse natural language text into structured search filters.
     */
    public function parse(string $text): array
    {
        $text = $this->normalizeText($text);
        $this->filters = [];
        $this->followUpQuestions = [];
        $this->detectedIntents = [];

        // Extract all filter dimensions
        $this->extractOfferType($text);
        $this->extractPropertyType($text);
        $this->extractBudget($text);
        $this->extractRooms($text);
        $this->extractBaths($text);
        $this->extractArea($text);
        $this->extractFinishType($text);
        $this->extractLocation($text);
        $this->extractKeywords($text);

        // Generate follow-up questions for vague queries
        $this->generateFollowUps();

        return [
            'filters' => $this->filters,
            'followUpQuestions' => $this->followUpQuestions,
            'detectedIntents' => $this->detectedIntents,
        ];
    }

    /**
     * Normalize Arabic text for consistent matching.
     */
    protected function normalizeText(string $text): string
    {
        // Normalize Arabic characters
        $text = str_replace(['أ', 'إ', 'آ'], 'ا', $text);
        $text = str_replace('ة', 'ه', $text);
        // Keep both ي and ى as-is for matching, normalize later per-case
        $text = mb_strtolower($text);
        $text = trim($text);
        return $text;
    }

    /**
     * Normalize Arabic for DB matching (ي↔ى).
     */
    protected function normalizeArabicForSearch(string $text): array
    {
        $v1 = str_replace('ى', 'ي', $text);
        $v2 = str_replace('ي', 'ى', $text);
        return array_unique([$text, $v1, $v2]);
    }

    /**
     * Extract offer type (sale/rent/installment/finance).
     */
    protected function extractOfferType(string $text): void
    {
        // Check multi-word patterns first (longer matches)
        $sortedKeywords = $this->offerTypeKeywords;
        uksort($sortedKeywords, function ($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });

        foreach ($sortedKeywords as $keyword => $typeId) {
            if (mb_strpos($text, $keyword) !== false) {
                $this->filters['saletype'] = $typeId;
                $this->detectedIntents[] = 'offer_type';

                // Special: if "مفروش" found, it's rent furnished (4)
                if ($typeId == 4) {
                    $this->filters['saletype'] = 4;
                }
                return;
            }
        }

        // Contextual inference
        if (mb_strpos($text, 'للبيع') !== false || mb_strpos($text, 'اشتري') !== false || mb_strpos($text, 'شراء') !== false) {
            $this->filters['saletype'] = 'ALL1';
            $this->detectedIntents[] = 'offer_type';
        } elseif (mb_strpos($text, 'اجار') !== false || mb_strpos($text, 'استاجر') !== false) {
            $this->filters['saletype'] = 'ALL2';
            $this->detectedIntents[] = 'offer_type';
        }
    }

    /**
     * Extract property type (apartment/villa/etc).
     */
    protected function extractPropertyType(string $text): void
    {
        // Check multi-word patterns first
        $sortedKeywords = $this->propertyTypeKeywords;
        uksort($sortedKeywords, function ($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });

        foreach ($sortedKeywords as $keyword => $typeName) {
            if (mb_strpos($text, $keyword) !== false) {
                // Find the property type ID from DB
                $variants = $this->normalizeArabicForSearch($typeName);
                $propType = TypeOfProp::where(function ($q) use ($variants) {
                    foreach ($variants as $v) {
                        $q->orWhere('property_type', 'like', "%{$v}%");
                    }
                })->first();

                if ($propType) {
                    $this->filters['Propertytype'] = $propType->id;
                    // Also set category from the property type
                    if ($propType->cat_id) {
                        $this->filters['licat'] = $propType->cat_id;
                    }
                }
                $this->detectedIntents[] = 'property_type';
                return;
            }
        }
    }

    /**
     * Extract budget/price from text.
     * Handles: "3 مليون", "500 الف", "من 2 مليون الى 4 مليون", "ميزانيتي 3 مليون"
     */
    protected function extractBudget(string $text): void
    {
        // Price range pattern: من X الى/لـ Y
        $rangePattern = '/(?:من|min)\s*([\d,.]+)\s*(مليون|مليار|الف|ألف|million|k)?\s*(?:الى|لـ|ل|الي|إلى|-|to)\s*([\d,.]+)\s*(مليون|مليار|الف|ألف|million|k)?/u';
        if (preg_match($rangePattern, $text, $matches)) {
            $minVal = $this->parseNumber($matches[1]);
            $minMultiplier = $this->getMultiplier($matches[2] ?? '');
            $maxVal = $this->parseNumber($matches[3]);
            $maxMultiplier = $this->getMultiplier($matches[4] ?? ($matches[2] ?? ''));

            $this->filters['minPrice'] = $minVal * $minMultiplier;
            $this->filters['maxPrice'] = $maxVal * $maxMultiplier;
            $this->detectedIntents[] = 'budget';
            return;
        }

        // Single budget: ميزانيتي/بسعر/حوالي + number
        $budgetPatterns = [
            '/(?:ميزانيت[يه]|بميزانيه|بميزانية|budget)\s*([\d,.]+)\s*(مليون|مليار|الف|ألف|million|k)?/u',
            '/(?:بسعر|سعر[هه]ا?|حوالي|تقريبا|بحدود|ب)\s*([\d,.]+)\s*(مليون|مليار|الف|ألف|million|k)?/u',
            '/(?:ما?\s*يزيد\s*عن|لا?\s*يتجاوز|اقل من|أقل من|under|max|less than)\s*([\d,.]+)\s*(مليون|مليار|الف|ألف|million|k)?/u',
        ];

        foreach ($budgetPatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $val = $this->parseNumber($matches[1]);
                $multiplier = $this->getMultiplier($matches[2] ?? '');
                $price = $val * $multiplier;

                // Set as max price with 20% below as min for "around" semantics
                $this->filters['maxPrice'] = $price;
                $this->filters['minPrice'] = (int)($price * 0.8);
                $this->detectedIntents[] = 'budget';
                return;
            }
        }

        // Standalone number with multiplier (e.g., "3 مليون")
        $standalonePrice = '/([\d,.]+)\s*(مليون|مليار)/u';
        if (preg_match($standalonePrice, $text, $matches)) {
            $val = $this->parseNumber($matches[1]);
            $multiplier = $this->getMultiplier($matches[2]);
            $price = $val * $multiplier;

            $this->filters['maxPrice'] = $price;
            $this->filters['minPrice'] = (int)($price * 0.8);
            $this->detectedIntents[] = 'budget';
        }
    }

    /**
     * Extract number of rooms.
     * Handles: "3 غرف", "غرفتين", "لعيله 4 افراد"
     */
    protected function extractRooms(string $text): void
    {
        // Direct room count: X غرف/غرفه/rooms
        $roomPatterns = [
            '/([\d]+)\s*(?:غرف[هة]?|غرفه|rooms?|bedroom|bed)/u',
            '/(?:غرف[هة]?|غرفه)\s*([\d]+)/u',
        ];

        foreach ($roomPatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $rooms = (int)$matches[1];
                $this->filters['minRooms'] = $rooms;
                $this->filters['maxRooms'] = $rooms;
                $this->detectedIntents[] = 'rooms';
                return;
            }
        }

        // Arabic number words
        $wordNumbers = [
            'غرفه واحده' => 1, 'غرفه واحدة' => 1, 'غرفة واحده' => 1, 'غرفة واحدة' => 1,
            'غرفتين' => 2, 'غرفتان' => 2,
            'ثلاث غرف' => 3, '3 غرف' => 3, 'ثلاثه غرف' => 3,
            'اربع غرف' => 4, 'أربع غرف' => 4, '4 غرف' => 4, 'اربعه غرف' => 4,
            'خمس غرف' => 5, '5 غرف' => 5,
        ];

        foreach ($wordNumbers as $phrase => $count) {
            if (mb_strpos($text, $phrase) !== false) {
                $this->filters['minRooms'] = $count;
                $this->filters['maxRooms'] = $count;
                $this->detectedIntents[] = 'rooms';
                return;
            }
        }

        // Family size → room estimation
        $familyPattern = '/(?:عيل[هة]|اسره|أسره|عائل[هة]|family)\s*([\d]+)\s*(?:افراد|أفراد|فرد|members?|people)?/u';
        if (preg_match($familyPattern, $text, $matches)) {
            $familySize = (int)$matches[1];
            // Estimate rooms: 2 people per room, minimum 2 rooms
            $estimatedRooms = max(2, (int)ceil($familySize / 2));
            $this->filters['minRooms'] = $estimatedRooms;
            $this->detectedIntents[] = 'rooms';
            return;
        }

        // Also try: لعيله X
        $familyPattern2 = '/لعيل[هة]\s*([\d]+)/u';
        if (preg_match($familyPattern2, $text, $matches)) {
            $familySize = (int)$matches[1];
            $estimatedRooms = max(2, (int)ceil($familySize / 2));
            $this->filters['minRooms'] = $estimatedRooms;
            $this->detectedIntents[] = 'rooms';
        }
    }

    /**
     * Extract number of bathrooms.
     */
    protected function extractBaths(string $text): void
    {
        $bathPatterns = [
            '/([\d]+)\s*(?:حمام|حمامات|bath|bathroom)/u',
            '/(?:حمام|حمامات)\s*([\d]+)/u',
        ];

        foreach ($bathPatterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                $baths = (int)$matches[1];
                $this->filters['minBaths'] = $baths;
                $this->filters['maxBaths'] = $baths;
                $this->detectedIntents[] = 'baths';
                return;
            }
        }

        $wordBaths = [
            'حمامين' => 2, 'حمامان' => 2,
            'ثلاث حمامات' => 3, '3 حمامات' => 3,
        ];

        foreach ($wordBaths as $phrase => $count) {
            if (mb_strpos($text, $phrase) !== false) {
                $this->filters['minBaths'] = $count;
                $this->filters['maxBaths'] = $count;
                $this->detectedIntents[] = 'baths';
                return;
            }
        }
    }

    /**
     * Extract total area (m²).
     */
    protected function extractArea(string $text): void
    {
        // Area range
        $rangePattern = '/(?:من|min)\s*([\d]+)\s*(?:متر|م|m)?\s*(?:الى|لـ|ل|الي|إلى|-|to)\s*([\d]+)\s*(?:متر|م²|م|m|sqm|meter)/u';
        if (preg_match($rangePattern, $text, $matches)) {
            $this->filters['minArea'] = (int)$matches[1];
            $this->filters['maxArea'] = (int)$matches[2];
            $this->detectedIntents[] = 'area';
            return;
        }

        // Single area: X متر / X م²
        $areaPattern = '/([\d]+)\s*(?:متر|م²|م|m|sqm|meter)/u';
        if (preg_match($areaPattern, $text, $matches)) {
            $area = (int)$matches[1];
            // Only treat as area if >= 30 (to avoid matching small numbers like "3 م")
            if ($area >= 30) {
                $this->filters['minArea'] = (int)($area * 0.9);
                $this->filters['maxArea'] = (int)($area * 1.1);
                $this->detectedIntents[] = 'area';
            }
        }

        // Descriptive area
        $descriptiveArea = [
            'صغيره' => ['minArea' => 50, 'maxArea' => 100],
            'صغيرة' => ['minArea' => 50, 'maxArea' => 100],
            'متوسطه' => ['minArea' => 100, 'maxArea' => 180],
            'متوسطة' => ['minArea' => 100, 'maxArea' => 180],
            'كبيره' => ['minArea' => 180, 'maxArea' => 350],
            'كبيرة' => ['minArea' => 180, 'maxArea' => 350],
            'واسعه' => ['minArea' => 200, 'maxArea' => 500],
            'واسعة' => ['minArea' => 200, 'maxArea' => 500],
        ];

        foreach ($descriptiveArea as $word => $range) {
            if (mb_strpos($text, $word) !== false && !in_array('area', $this->detectedIntents)) {
                $this->filters['minArea'] = $range['minArea'];
                $this->filters['maxArea'] = $range['maxArea'];
                $this->detectedIntents[] = 'area';
                return;
            }
        }
    }

    /**
     * Extract finish type.
     */
    protected function extractFinishType(string $text): void
    {
        // Check multi-word patterns first (longer matches)
        $sortedKeywords = $this->finishTypeKeywords;
        uksort($sortedKeywords, function ($a, $b) {
            return mb_strlen($b) - mb_strlen($a);
        });

        foreach ($sortedKeywords as $keyword => $finishName) {
            if (mb_strpos($text, $keyword) !== false) {
                $variants = $this->normalizeArabicForSearch($finishName);
                $finish = Finish_type::where(function ($q) use ($variants) {
                    foreach ($variants as $v) {
                        $q->orWhere('finish_type', 'like', "%{$v}%");
                    }
                })->first();

                if ($finish) {
                    $this->filters['finishtype2'] = $finish->id;
                    $this->detectedIntents[] = 'finish_type';
                }
                return;
            }
        }

        // "استلام فوري" implies finished
        if (mb_strpos($text, 'استلام فوري') !== false || mb_strpos($text, 'تسليم فوري') !== false) {
            $this->detectedIntents[] = 'immediate_delivery';
        }
    }

    /**
     * Extract location (governorate, district, subarea, compound).
     */
    protected function extractLocation(string $text): void
    {
        // Try compound first (most specific)
        $this->extractCompound($text);

        // Try governorate
        $this->extractGovernorate($text);

        // Try district
        $this->extractDistrict($text);

        // Try subarea
        $this->extractSubArea($text);
    }

    protected function extractCompound(string $text): void
    {
        $compounds = Compound::all();
        foreach ($compounds as $compound) {
            $names = $this->normalizeArabicForSearch($compound->compound);
            if ($compound->compound_en) {
                $names[] = mb_strtolower($compound->compound_en);
            }

            foreach ($names as $name) {
                if (!empty($name) && mb_strpos($text, mb_strtolower($name)) !== false) {
                    $this->filters['compound'] = $compound->id;
                    $this->detectedIntents[] = 'compound';
                    return;
                }
            }
        }
    }

    protected function extractGovernorate(string $text): void
    {
        $governrates = Governrate::all();
        foreach ($governrates as $gov) {
            $names = $this->normalizeArabicForSearch($this->normalizeText($gov->governrate));
            if ($gov->governrate_en) {
                $names[] = mb_strtolower($gov->governrate_en);
            }

            foreach ($names as $name) {
                if (!empty($name) && mb_strlen($name) > 2 && mb_strpos($text, $name) !== false) {
                    $this->filters['location1'] = $gov->id;
                    $this->detectedIntents[] = 'governorate';
                    return;
                }
            }
        }
    }

    protected function extractDistrict(string $text): void
    {
        $districts = District::all();
        $bestMatch = null;
        $bestLen = 0;

        foreach ($districts as $dist) {
            $names = $this->normalizeArabicForSearch($this->normalizeText($dist->district));
            if ($dist->district_en) {
                $names[] = mb_strtolower($dist->district_en);
            }

            foreach ($names as $name) {
                if (!empty($name) && mb_strlen($name) > 2 && mb_strpos($text, $name) !== false) {
                    if (mb_strlen($name) > $bestLen) {
                        $bestLen = mb_strlen($name);
                        $bestMatch = $dist;
                    }
                }
            }
        }

        if ($bestMatch) {
            $this->filters['location2'] = $bestMatch->id;
            // Auto-set governorate if not already set
            if (!isset($this->filters['location1']) && $bestMatch->govern_id) {
                $this->filters['location1'] = $bestMatch->govern_id;
            }
            $this->detectedIntents[] = 'district';
        }
    }

    protected function extractSubArea(string $text): void
    {
        $areas = SubArea::all();
        $bestMatch = null;
        $bestLen = 0;

        foreach ($areas as $area) {
            $names = $this->normalizeArabicForSearch($this->normalizeText($area->area));
            if ($area->area_en) {
                $names[] = mb_strtolower($area->area_en);
            }

            foreach ($names as $name) {
                if (!empty($name) && mb_strlen($name) > 2 && mb_strpos($text, $name) !== false) {
                    if (mb_strlen($name) > $bestLen) {
                        $bestLen = mb_strlen($name);
                        $bestMatch = $area;
                    }
                }
            }
        }

        if ($bestMatch) {
            $this->filters['area'] = $bestMatch->area;
            $this->detectedIntents[] = 'subarea';
        }
    }

    /**
     * Extract remaining keywords that weren't captured by other filters.
     */
    protected function extractKeywords(string $text): void
    {
        // Remove filler words and already-matched patterns
        $fillerWords = [
            'عايز', 'عاوز', 'عايزه', 'عاوزه', 'محتاج', 'محتاجه', 'بدور', 'ابحث', 'دور',
            'على', 'عن', 'في', 'من', 'الى', 'لي', 'انا', 'أنا', 'يا', 'ياريت',
            'لو', 'سمحت', 'ممكن', 'اريد', 'أريد', 'ابغى', 'need', 'want', 'looking',
            'for', 'find', 'search', 'me', 'please', 'a', 'an', 'the', 'i',
            'هل', 'فيه', 'فين', 'وين', 'كام', 'قد', 'ايه', 'شو',
            'حلوه', 'حلوة', 'كويسه', 'كويسة', 'مناسبه', 'مناسبة',
        ];

        // Mzaya (features) keywords to detect
        $mzayaKeywords = [
            'مصعد' => 'مصعد', 'اسانسير' => 'مصعد', 'elevator' => 'مصعد',
            'حديقه' => 'حديقة', 'حديقة' => 'حديقة', 'جنينه' => 'حديقة', 'garden' => 'حديقة',
            'جراج' => 'جراج', 'garage' => 'جراج', 'parking' => 'جراج',
            'حمام سباحه' => 'حمام سباحة', 'بسين' => 'حمام سباحة', 'pool' => 'حمام سباحة', 'swimming' => 'حمام سباحة',
            'امن' => 'أمن', 'أمن' => 'أمن', 'حراسه' => 'أمن', 'security' => 'أمن',
            'تكييف' => 'تكييف', 'مكيفه' => 'تكييف', 'ac' => 'تكييف',
            'بلكونه' => 'بلكونة', 'بلكونة' => 'بلكونة', 'تراس' => 'تراس', 'balcony' => 'بلكونة',
        ];

        $detectedMzaya = [];
        foreach ($mzayaKeywords as $keyword => $mzayaName) {
            if (mb_strpos($text, $keyword) !== false) {
                $variants = $this->normalizeArabicForSearch($mzayaName);
                $mzaya = Mzaya::where(function ($q) use ($variants) {
                    foreach ($variants as $v) {
                        $q->orWhere('mzaya_type', 'like', "%{$v}%");
                    }
                })->first();

                if ($mzaya && !in_array($mzaya->id, $detectedMzaya)) {
                    $detectedMzaya[] = $mzaya->id;
                }
            }
        }

        if (!empty($detectedMzaya)) {
            $this->filters['mzaya'] = $detectedMzaya;
            $this->detectedIntents[] = 'features';
        }
    }

    /**
     * Generate follow-up questions for missing crucial info.
     */
    protected function generateFollowUps(): void
    {
        $intentCount = count(array_unique($this->detectedIntents));

        // If very few intents detected, the query is too vague
        if ($intentCount === 0) {
            $this->followUpQuestions = [
                'ar' => [
                    'إيه نوع العقار اللي بتدور عليه؟ (شقة، فيلا، محل...)',
                    'عايز تشتري ولا تأجر؟',
                    'في منطقة معينة؟',
                    'ميزانيتك كام تقريبًا؟',
                ],
                'en' => [
                    'What type of property are you looking for? (apartment, villa, shop...)',
                    'Are you looking to buy or rent?',
                    'Any specific location?',
                    'What is your approximate budget?',
                ],
            ];
            return;
        }

        $questions_ar = [];
        $questions_en = [];

        if (!in_array('offer_type', $this->detectedIntents)) {
            $questions_ar[] = 'عايز تشتري (كاش/تقسيط) ولا تأجر؟';
            $questions_en[] = 'Buy (cash/installment) or rent?';
        }

        if (!in_array('budget', $this->detectedIntents)) {
            $questions_ar[] = 'ميزانيتك كام تقريبًا؟';
            $questions_en[] = 'What is your approximate budget?';
        }

        if (!in_array('governorate', $this->detectedIntents) && !in_array('district', $this->detectedIntents) && !in_array('subarea', $this->detectedIntents) && !in_array('compound', $this->detectedIntents)) {
            $questions_ar[] = 'في منطقة معينة؟';
            $questions_en[] = 'Any specific location?';
        }

        if (!in_array('rooms', $this->detectedIntents) && !in_array('area', $this->detectedIntents)) {
            $questions_ar[] = 'محتاج كام غرفة؟ أو مساحة معينة؟';
            $questions_en[] = 'How many rooms? Or specific area size?';
        }

        if (!empty($questions_ar)) {
            $this->followUpQuestions = [
                'ar' => $questions_ar,
                'en' => $questions_en,
            ];
        }
    }

    /**
     * Parse a number string (handles commas and dots).
     */
    protected function parseNumber(string $num): float
    {
        $num = str_replace([',', '،'], '', $num);
        return (float)$num;
    }

    /**
     * Get numeric multiplier from Arabic/English word.
     */
    protected function getMultiplier(string $word): int
    {
        $word = trim(mb_strtolower($word));
        $multipliers = [
            'مليون' => 1000000,
            'مليار' => 1000000000,
            'الف' => 1000,
            'ألف' => 1000,
            'million' => 1000000,
            'k' => 1000,
        ];

        return $multipliers[$word] ?? 1;
    }
}
