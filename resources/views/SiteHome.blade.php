@include('SiteHomeOriginal')

@php
    $featuredIsEnglish = App::isLocale('en');

    $featuredPropertiesMeta = $vipAqars->map(function ($property) use ($featuredIsEnglish) {
        $isRent = in_array((int) $property->offer_type, [3, 4], true);
        $hasInstallment = !$isRent && (
            (float) $property->downpayment > 0 ||
            (float) $property->installment_value > 0 ||
            (int) $property->installment_time > 0
        );

        $propertyType = optional($property->propertyType)->property_type;
        $offerType = $property->offerTypes;

        $offerLabel = $featuredIsEnglish
            ? (optional($offerType)->type_offer_en ?: optional($offerType)->type_offer ?: 'Property offer')
            : (optional($offerType)->type_offer ?: 'عرض عقاري');

        if ($isRent) {
            if ((float) $property->monthly_rent > 0) {
                $paymentLabel = $featuredIsEnglish ? 'Monthly rent' : 'إيجار شهري';
                $priceValue = (float) $property->monthly_rent;
                $priceCaption = $featuredIsEnglish ? 'Monthly rent' : 'الإيجار الشهري';
            } elseif ((float) $property->daily_rent > 0) {
                $paymentLabel = $featuredIsEnglish ? 'Daily rent' : 'إيجار يومي';
                $priceValue = (float) $property->daily_rent;
                $priceCaption = $featuredIsEnglish ? 'Daily rent' : 'الإيجار اليومي';
            } else {
                $paymentLabel = $featuredIsEnglish ? 'For rent' : 'للإيجار';
                $priceValue = 0;
                $priceCaption = $featuredIsEnglish ? 'Rent' : 'الإيجار';
            }

            $paymentTone = 'rent';
            $paymentDetail = $featuredIsEnglish ? 'Ready for rent' : 'متاح للإيجار';
        } elseif ($hasInstallment) {
            $paymentLabel = $featuredIsEnglish ? 'Installments available' : 'تقسيط متاح';
            $paymentTone = 'installment';
            $priceValue = (float) $property->total_price;
            $priceCaption = $featuredIsEnglish ? 'Property price' : 'سعر العقار';

            $installmentDetails = collect();

            if ((float) $property->downpayment > 0) {
                $installmentDetails->push(
                    ($featuredIsEnglish ? 'Down payment ' : 'مقدم ') .
                    number_format((float) $property->downpayment) .
                    ($featuredIsEnglish ? ' EGP' : ' ج.م')
                );
            }

            if ((float) $property->installment_value > 0) {
                $installmentDetails->push(
                    ($featuredIsEnglish ? 'Installment ' : 'قسط ') .
                    number_format((float) $property->installment_value) .
                    ($featuredIsEnglish ? ' EGP' : ' ج.م')
                );
            }

            $paymentDetail = $installmentDetails->isNotEmpty()
                ? $installmentDetails->implode(' • ')
                : ($featuredIsEnglish ? 'Flexible installment plan' : 'نظام تقسيط مرن');
        } else {
            $paymentLabel = $featuredIsEnglish ? 'Cash' : 'كاش';
            $paymentTone = 'cash';
            $priceValue = (float) $property->total_price;
            $priceCaption = $featuredIsEnglish ? 'Property price' : 'سعر العقار';
            $paymentDetail = $featuredIsEnglish ? 'Cash payment' : 'دفع كاش';
        }

        $location = collect([
            optional($property->governrateq)->governrate,
            optional($property->districte)->district,
        ])->filter()->implode('، ');

        return [
            'url' => URL::to(Config::get('app.locale') . '/aqars/' . $property->slug),
            'property_type' => $propertyType ?: ($featuredIsEnglish ? 'Property' : 'عقار'),
            'offer_type' => $offerLabel,
            'payment_label' => $paymentLabel,
            'payment_tone' => $paymentTone,
            'payment_detail' => $paymentDetail,
            'price_caption' => $priceCaption,
            'price_label' => $priceValue > 0
                ? number_format($priceValue) . ($featuredIsEnglish ? ' EGP' : ' ج.م')
                : '',
            'location' => $location,
        ];
    })->values();

    $featuredCopy = [
        'direction' => $featuredIsEnglish ? 'ltr' : 'rtl',
        'kicker' => $featuredIsEnglish ? 'Handpicked opportunities' : 'فرص مختارة بعناية',
        'title' => $featuredIsEnglish ? 'Featured properties worth exploring' : 'إعلانات مميزة تستحق المشاهدة',
        'description' => $featuredIsEnglish
            ? 'Quickly compare property use, offer type and payment method before opening the listing.'
            : 'اعرف نوع العقار وطريقة العرض والدفع من أول نظرة، واختار الفرصة المناسبة ليك بسهولة.',
        'count_label' => $featuredIsEnglish ? 'featured listings' : 'إعلان مميز',
        'selected_label' => $featuredIsEnglish ? 'Featured opportunity' : 'فرصة مميزة',
        'view_details' => $featuredIsEnglish ? 'View details' : 'شاهد التفاصيل',
    ];
@endphp

<script id="rc-featured-properties-meta" type="application/json">{!! $featuredPropertiesMeta->toJson(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>

<style>
    /* Active-slide animation layer */
    .rc-hero-slide::before {
        animation: none !important;
        transform: scale(1.02);
        will-change: transform;
    }

    .rc-hero-slide.slick-active::before {
        animation: rcActiveHeroZoom 8s cubic-bezier(.2, .7, .25, 1) both !important;
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-badge,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-title,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-subtitle,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-description,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-features,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-actions,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-benefits-bar {
        opacity: 0;
        will-change: opacity, transform;
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-badge,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-title,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-subtitle,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-description,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-features,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-hero-actions,
    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-benefits-bar {
        transform: translate3d(0, 30px, 0);
    }

    .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card {
        transform: translate3d(-45px, 0, 0) scale(.985);
    }

    [dir="ltr"] .rc-hero-slider.slick-initialized .rc-hero-slide .rc-search-card {
        transform: translate3d(45px, 0, 0) scale(.985);
    }

    .rc-hero-slide.slick-active .rc-hero-badge,
    .rc-hero-slide.slick-active .rc-hero-title,
    .rc-hero-slide.slick-active .rc-hero-subtitle,
    .rc-hero-slide.slick-active .rc-hero-description,
    .rc-hero-slide.slick-active .rc-hero-features,
    .rc-hero-slide.slick-active .rc-hero-actions,
    .rc-hero-slide.slick-active .rc-benefits-bar {
        animation: rcHeroRevealUp .72s cubic-bezier(.22, 1, .36, 1) both !important;
    }

    .rc-hero-slide.slick-active .rc-search-card {
        animation: rcHeroCardRevealRtl .82s cubic-bezier(.22, 1, .36, 1) both !important;
    }

    [dir="ltr"] .rc-hero-slide.slick-active .rc-search-card {
        animation-name: rcHeroCardRevealLtr !important;
    }

    .rc-hero-slide.slick-active .rc-hero-badge { animation-delay: .08s !important; }
    .rc-hero-slide.slick-active .rc-hero-title { animation-delay: .16s !important; }
    .rc-hero-slide.slick-active .rc-hero-subtitle { animation-delay: .25s !important; }
    .rc-hero-slide.slick-active .rc-hero-description { animation-delay: .34s !important; }
    .rc-hero-slide.slick-active .rc-hero-features { animation-delay: .43s !important; }
    .rc-hero-slide.slick-active .rc-hero-actions { animation-delay: .54s !important; }
    .rc-hero-slide.slick-active .rc-search-card { animation-delay: .20s !important; }
    .rc-hero-slide.slick-active .rc-benefits-bar { animation-delay: .68s !important; }

    .rc-hero-slider.slick-initialized .rc-feature-item,
    .rc-hero-slider.slick-initialized .rc-benefit {
        opacity: 0;
        transform: translate3d(0, 12px, 0) scale(.97);
    }

    .rc-hero-slide.slick-active .rc-feature-item,
    .rc-hero-slide.slick-active .rc-benefit {
        animation: rcHeroItemPop .5s cubic-bezier(.2, .8, .2, 1) both;
    }

    .rc-hero-slide.slick-active .rc-feature-item:nth-child(1) { animation-delay: .52s; }
    .rc-hero-slide.slick-active .rc-feature-item:nth-child(2) { animation-delay: .60s; }
    .rc-hero-slide.slick-active .rc-feature-item:nth-child(3) { animation-delay: .68s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(1) { animation-delay: .78s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(2) { animation-delay: .85s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(3) { animation-delay: .92s; }
    .rc-hero-slide.slick-active .rc-benefit:nth-child(4) { animation-delay: .99s; }

    .rc-hero-slide.slick-active .rc-primary-cta {
        animation: rcHeroCtaPulse 2.8s 1.2s ease-in-out infinite;
    }

    /* ================= Featured properties redesign ================= */
    .rc-featured-section {
        --rc-featured-blue: #176da1;
        --rc-featured-blue-dark: #0b3658;
        --rc-featured-green: #13b98f;
        --rc-featured-gold: #f7b83d;
        position: relative;
        isolation: isolate;
        overflow: hidden;
        padding: 76px 0 82px !important;
        background:
            radial-gradient(circle at 9% 8%, rgba(19, 185, 143, .16), transparent 29%),
            radial-gradient(circle at 92% 24%, rgba(247, 184, 61, .14), transparent 27%),
            linear-gradient(180deg, #f7fbff 0%, #eef6fb 100%);
    }

    .rc-featured-section::before,
    .rc-featured-section::after {
        content: '';
        position: absolute;
        z-index: -1;
        border-radius: 50%;
        pointer-events: none;
    }

    .rc-featured-section::before {
        width: 360px;
        height: 360px;
        top: -220px;
        right: -125px;
        border: 70px solid rgba(23, 109, 161, .055);
    }

    .rc-featured-section::after {
        width: 280px;
        height: 280px;
        bottom: -205px;
        left: -90px;
        border: 58px solid rgba(19, 185, 143, .07);
    }

    .rc-featured-section > .container {
        position: relative;
        z-index: 2;
    }

    .rc-featured-section .rc-featured-heading-column {
        flex: 0 0 100%;
        max-width: 100%;
    }

    .rc-featured-heading {
        position: relative;
        max-width: 760px;
        margin: 0 auto 30px !important;
        text-align: center;
    }

    .rc-featured-kicker {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        margin-bottom: 14px;
        padding: 8px 15px;
        color: var(--rc-featured-blue);
        border: 1px solid rgba(23, 109, 161, .17);
        border-radius: 999px;
        background: rgba(255, 255, 255, .78);
        box-shadow: 0 10px 28px rgba(11, 54, 88, .08);
        font-size: 13px;
        font-weight: 800;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .rc-featured-kicker svg {
        color: var(--rc-featured-gold);
        filter: drop-shadow(0 3px 6px rgba(247, 184, 61, .28));
    }

    .rc-featured-heading h2 {
        margin: 0 0 12px;
        color: var(--rc-featured-blue-dark);
        font-family: 'Cairo', sans-serif;
        font-size: clamp(31px, 3.2vw, 48px);
        font-weight: 900;
        line-height: 1.28;
        letter-spacing: -.5px;
    }

    .rc-featured-heading p {
        max-width: 680px;
        margin: 0 auto;
        color: #617286;
        font-size: 15px;
        line-height: 1.95;
    }

    .rc-featured-count {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 16px;
        color: #416177;
        font-size: 12px;
        font-weight: 700;
    }

    .rc-featured-count strong {
        display: inline-grid;
        min-width: 33px;
        height: 33px;
        place-items: center;
        padding: 0 9px;
        color: #fff;
        border-radius: 999px;
        background: linear-gradient(135deg, var(--rc-featured-green), #079c76);
        box-shadow: 0 9px 20px rgba(19, 185, 143, .24);
        font-size: 14px;
    }

    .rc-featured-section .property-slide .slick-list {
        padding: 16px 0 35px;
    }

    .rc-featured-section .property-slide .single-items {
        padding: 0 10px;
    }

    .rc-featured-card {
        position: relative;
        height: 100%;
        overflow: hidden;
        border: 1px solid rgba(23, 109, 161, .10) !important;
        border-radius: 23px !important;
        background: rgba(255, 255, 255, .98) !important;
        box-shadow: 0 18px 48px rgba(12, 50, 78, .105) !important;
        transform: translateZ(0);
        transition: transform .38s cubic-bezier(.2, .75, .25, 1), box-shadow .38s ease, border-color .38s ease;
        animation: rcFeaturedCardIn .7s var(--rc-card-delay, 0ms) cubic-bezier(.22, 1, .36, 1) both;
    }

    .rc-featured-rtl .rc-featured-card {
        direction: rtl;
        text-align: right;
    }

    .rc-featured-ltr .rc-featured-card {
        direction: ltr;
        text-align: left;
    }

    .rc-featured-card:hover {
        border-color: rgba(19, 185, 143, .36) !important;
        box-shadow: 0 28px 70px rgba(12, 50, 78, .18) !important;
        transform: translateY(-9px);
    }

    .rc-featured-card .listing-img-wrapper {
        position: relative;
        height: 252px;
        overflow: hidden;
        border-radius: 22px 22px 0 0;
        background: #dfeaf1;
    }

    .rc-featured-card .list-img-slide,
    .rc-featured-card .click,
    .rc-featured-card .click > div,
    .rc-featured-card .listing-img-wrapper a {
        display: block;
        width: 100%;
        height: 100%;
    }

    .rc-featured-card .listing-img-wrapper::after {
        content: '';
        position: absolute;
        inset: 0;
        z-index: 2;
        pointer-events: none;
        background: linear-gradient(180deg, rgba(5, 31, 49, .05) 28%, rgba(5, 31, 49, .78) 100%);
    }

    .rc-featured-card .listing-img-wrapper img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
        transform: scale(1.01);
        transition: transform .65s cubic-bezier(.2, .75, .25, 1), filter .5s ease;
    }

    .rc-featured-card:hover .listing-img-wrapper img {
        filter: saturate(1.08) contrast(1.035);
        transform: scale(1.085);
    }

    .rc-featured-badges {
        position: absolute;
        top: 14px;
        right: 14px;
        left: 14px;
        z-index: 5;
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
        pointer-events: none;
    }

    .rc-featured-ltr .rc-featured-badges {
        justify-content: flex-start;
    }

    .rc-featured-badge {
        display: inline-flex;
        min-height: 31px;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 6px 10px;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .27);
        border-radius: 999px;
        box-shadow: 0 8px 18px rgba(4, 23, 38, .18);
        font-size: 11px;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
        backdrop-filter: blur(9px);
        -webkit-backdrop-filter: blur(9px);
    }

    .rc-badge-property {
        background: rgba(11, 54, 88, .86);
    }

    .rc-badge-offer {
        background: rgba(23, 109, 161, .90);
    }

    .rc-badge-payment-installment {
        color: #342100;
        border-color: rgba(255, 255, 255, .5);
        background: rgba(247, 184, 61, .94);
    }

    .rc-badge-payment-cash {
        background: rgba(19, 185, 143, .92);
    }

    .rc-badge-payment-rent {
        background: rgba(139, 76, 196, .91);
    }

    .rc-featured-badge svg {
        width: 14px;
        height: 14px;
        flex: 0 0 14px;
    }

    .rc-featured-card .rc-view-badge {
        top: auto !important;
        right: auto !important;
        bottom: 14px !important;
        left: 14px !important;
        z-index: 5 !important;
        margin: 0 !important;
    }

    .rc-featured-card .rc-view-badge .views-2 {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        min-height: 31px;
        padding: 6px 11px;
        color: #fff;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 999px;
        background: rgba(5, 31, 49, .68);
        box-shadow: none;
        font-size: 11px;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .rc-featured-card .listing-detail-wrapper {
        padding: 21px 21px 9px;
    }

    .rc-card-eyebrow {
        display: flex;
        align-items: center;
        gap: 7px;
        min-height: 20px;
        margin-bottom: 8px;
        color: #678096;
        font-size: 11px;
        font-weight: 700;
    }

    .rc-card-eyebrow svg {
        width: 15px;
        height: 15px;
        color: var(--rc-featured-green);
        flex: 0 0 15px;
    }

    .rc-featured-card .listing-name {
        min-height: 56px;
        margin: 0 !important;
        line-height: 1.72;
    }

    .rc-featured-card .listing-name a {
        color: #142f44 !important;
        font-family: 'Cairo', sans-serif;
        font-size: 16px;
        font-weight: 900;
        transition: color .25s ease;
    }

    .rc-featured-card:hover .listing-name a {
        color: var(--rc-featured-blue) !important;
    }

    .rc-featured-card .listing-short-detail-flex {
        margin: 0 21px;
        padding: 15px 16px;
        border: 1px solid rgba(23, 109, 161, .09);
        border-radius: 14px;
        background: linear-gradient(135deg, #f4f9fc, #fbfdff);
    }

    .rc-featured-card .listing-card-info-price {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        width: 100%;
        margin: 0 !important;
        color: var(--rc-featured-blue-dark) !important;
        font-family: 'Cairo', sans-serif;
        font-size: 18px;
        font-weight: 900;
    }

    .rc-featured-card .listing-card-info-price small {
        color: #7890a3;
        font-size: 10px;
        font-weight: 700;
    }

    .rc-featured-payment-note {
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 10px 22px 0;
        color: #567085;
        font-size: 11px;
        font-weight: 700;
    }

    .rc-featured-payment-note span:first-child {
        display: inline-grid;
        width: 26px;
        height: 26px;
        flex: 0 0 26px;
        place-items: center;
        color: var(--rc-featured-green);
        border-radius: 8px;
        background: rgba(19, 185, 143, .095);
    }

    .rc-featured-payment-note svg {
        width: 15px;
        height: 15px;
    }

    .rc-featured-card .price-features-wrapper {
        margin-top: 13px;
        padding: 13px 21px;
        border-top: 1px solid #edf2f5;
        border-bottom: 1px solid #edf2f5;
        background: #fff;
    }

    .rc-featured-card .list-fx-features {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 7px;
    }

    .rc-featured-card .listing-card-info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        min-width: 0;
        color: #536d80;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .rc-featured-card .inc-fleat-icon {
        display: inline-flex;
        align-items: center;
        opacity: .78;
    }

    .rc-featured-card .listing-detail-footer {
        display: flex;
        min-height: 64px;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 12px 21px !important;
        border: 0 !important;
        background: #fff !important;
    }

    .rc-featured-card .foot-location {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6d8292;
        font-size: 11px;
        font-weight: 700;
    }

    .rc-featured-card .foot-location img {
        opacity: .75;
    }

    .rc-featured-cta {
        display: inline-flex !important;
        min-height: 38px;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 8px 13px !important;
        color: #fff !important;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--rc-featured-blue), #0e527d);
        box-shadow: 0 9px 19px rgba(23, 109, 161, .19);
        font-size: 11px;
        font-weight: 800;
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .rc-featured-cta:hover {
        color: #fff !important;
        box-shadow: 0 12px 24px rgba(23, 109, 161, .28);
        transform: translateY(-2px);
    }

    .rc-featured-cta svg {
        width: 15px;
        height: 15px;
    }

    .rc-featured-section .property-slide .slick-arrow {
        width: 46px;
        height: 46px;
        z-index: 8;
        border: 1px solid rgba(23, 109, 161, .14);
        border-radius: 50%;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 13px 30px rgba(11, 54, 88, .12);
        transition: transform .25s ease, background .25s ease, box-shadow .25s ease;
    }

    .rc-featured-section .property-slide .slick-arrow:hover {
        background: var(--rc-featured-green);
        box-shadow: 0 15px 34px rgba(19, 185, 143, .25);
        transform: scale(1.06);
    }

    .rc-featured-section .property-slide .slick-dots {
        bottom: -6px;
    }

    .rc-featured-section .property-slide .slick-dots li button::before {
        color: rgba(23, 109, 161, .32);
        font-size: 9px;
        opacity: 1;
    }

    .rc-featured-section .property-slide .slick-dots li.slick-active button::before {
        color: var(--rc-featured-green);
    }

    @keyframes rcActiveHeroZoom {
        from { transform: scale(1.02); }
        to { transform: scale(1.095); }
    }

    @keyframes rcHeroRevealUp {
        from { opacity: 0; transform: translate3d(0, 30px, 0); }
        to { opacity: 1; transform: translate3d(0, 0, 0); }
    }

    @keyframes rcHeroCardRevealRtl {
        from { opacity: 0; transform: translate3d(-45px, 0, 0) scale(.985); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroCardRevealLtr {
        from { opacity: 0; transform: translate3d(45px, 0, 0) scale(.985); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroItemPop {
        from { opacity: 0; transform: translate3d(0, 12px, 0) scale(.97); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @keyframes rcHeroCtaPulse {
        0%, 100% { box-shadow: 0 13px 32px rgba(19, 200, 155, .24); }
        50% { box-shadow: 0 16px 42px rgba(19, 200, 155, .42); }
    }

    @keyframes rcFeaturedCardIn {
        from { opacity: 0; transform: translate3d(0, 26px, 0) scale(.985); }
        to { opacity: 1; transform: translate3d(0, 0, 0) scale(1); }
    }

    @media (max-width: 991.98px) {
        .rc-featured-section {
            padding: 60px 0 68px !important;
        }

        .rc-featured-card .listing-img-wrapper {
            height: 238px;
        }
    }

    @media (max-width: 575.98px) {
        .rc-featured-section {
            padding: 48px 0 58px !important;
        }

        .rc-featured-heading {
            margin-bottom: 20px !important;
        }

        .rc-featured-heading h2 {
            font-size: 29px;
        }

        .rc-featured-heading p {
            font-size: 13px;
            line-height: 1.8;
        }

        .rc-featured-section .property-slide .single-items {
            padding: 0 5px;
        }

        .rc-featured-card .listing-img-wrapper {
            height: 225px;
        }

        .rc-featured-badges {
            top: 10px;
            right: 10px;
            left: 10px;
            gap: 5px;
        }

        .rc-featured-badge {
            min-height: 28px;
            padding: 5px 8px;
            font-size: 10px;
        }

        .rc-featured-card .listing-detail-wrapper {
            padding: 18px 17px 8px;
        }

        .rc-featured-card .listing-short-detail-flex {
            margin: 0 17px;
        }

        .rc-featured-payment-note {
            margin-right: 18px;
            margin-left: 18px;
        }

        .rc-featured-card .price-features-wrapper,
        .rc-featured-card .listing-detail-footer {
            padding-right: 17px !important;
            padding-left: 17px !important;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .rc-hero-slider .rc-hero-slide *,
        .rc-hero-slide::before,
        .rc-hero-slide.slick-active::before,
        .rc-featured-card,
        .rc-featured-card *,
        .rc-featured-card:hover {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<script>
    (function () {
        'use strict';

        const metaElement = document.getElementById('rc-featured-properties-meta');
        const copy = {!! json_encode($featuredCopy, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!};

        if (!metaElement) {
            return;
        }

        let featuredMeta = [];

        try {
            featuredMeta = JSON.parse(metaElement.textContent || '[]');
        } catch (error) {
            console.error('Unable to parse featured property metadata.', error);
            return;
        }

        const escapeHtml = function (value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        };

        const normalizePath = function (value) {
            try {
                return new URL(value, window.location.origin).pathname.replace(/\/+$/, '');
            } catch (error) {
                return String(value || '').replace(/\/+$/, '');
            }
        };

        const featuredByPath = new Map(
            featuredMeta.map(function (item) {
                return [normalizePath(item.url), item];
            })
        );

        const buildingIcon = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 21h16M6 21V7l6-4 6 4v14" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 10h1M14 10h1M9 14h1M14 14h1M9 18h1M14 18h1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
        const tagIcon = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 13 13 20 4 11V4h7l9 9Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><circle cx="8.5" cy="8.5" r="1.3" fill="currentColor"/></svg>';
        const walletIcon = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 7.5h14a2 2 0 0 1 2 2V18H6a2 2 0 0 1-2-2V7.5Z" stroke="currentColor" stroke-width="1.8"/><path d="M4.5 7.5 15 4v3.5M16 12h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/><circle cx="16" cy="12" r=".9" fill="currentColor"/></svg>';
        const pinIcon = '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="10" r="2.4" stroke="currentColor" stroke-width="1.8"/></svg>';
        const arrowIcon = copy.direction === 'rtl'
            ? '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m14 6-6 6 6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
            : '<svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m10 6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
        const starIcon = '<svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="m12 2.8 2.72 5.5 6.08.88-4.4 4.28 1.04 6.05L12 16.65 6.56 19.5l1.04-6.05-4.4-4.28 6.08-.88L12 2.8Z"/></svg>';

        const getFeaturedSlider = function () {
            return document.querySelector('.property-slide');
        };

        const enhanceHeading = function (section) {
            const heading = section.querySelector('.sec-heading');

            if (!heading || heading.dataset.rcFeaturedEnhanced === '1') {
                return;
            }

            heading.dataset.rcFeaturedEnhanced = '1';
            heading.classList.add('rc-featured-heading');

            const column = heading.closest('[class*="col-"]');
            if (column) {
                column.classList.add('rc-featured-heading-column');
            }

            heading.innerHTML =
                '<span class="rc-featured-kicker">' + starIcon + escapeHtml(copy.kicker) + '</span>' +
                '<h2>' + escapeHtml(copy.title) + '</h2>' +
                '<p>' + escapeHtml(copy.description) + '</p>' +
                '<span class="rc-featured-count"><strong>' + featuredMeta.length + '</strong>' + escapeHtml(copy.count_label) + '</span>';
        };

        const enhanceCard = function (card, index) {
            if (!card || card.dataset.rcFeaturedEnhanced === '1') {
                return;
            }

            const propertyLink = card.querySelector('.listing-name a[href*="/aqars/"]') || card.querySelector('a[href*="/aqars/"]');
            const item = propertyLink ? featuredByPath.get(normalizePath(propertyLink.href)) : null;

            if (!item) {
                return;
            }

            card.dataset.rcFeaturedEnhanced = '1';
            card.classList.add('rc-featured-card');
            card.style.setProperty('--rc-card-delay', Math.min(index % 5, 4) * 80 + 'ms');

            card.querySelectorAll('.views').forEach(function (view) {
                if (view.querySelector('.views-1')) {
                    view.remove();
                } else if (view.querySelector('.views-2')) {
                    view.classList.add('rc-view-badge');
                }
            });

            const imageWrapper = card.querySelector('.listing-img-wrapper');
            if (imageWrapper && !imageWrapper.querySelector('.rc-featured-badges')) {
                const badges = document.createElement('div');
                badges.className = 'rc-featured-badges';
                badges.innerHTML =
                    '<span class="rc-featured-badge rc-badge-property">' + buildingIcon + escapeHtml(item.property_type) + '</span>' +
                    '<span class="rc-featured-badge rc-badge-offer">' + tagIcon + escapeHtml(item.offer_type) + '</span>' +
                    '<span class="rc-featured-badge rc-badge-payment-' + escapeHtml(item.payment_tone) + '">' + walletIcon + escapeHtml(item.payment_label) + '</span>';
                imageWrapper.appendChild(badges);
            }

            const titleWrapper = card.querySelector('.listing-short-detail');
            if (titleWrapper && !titleWrapper.querySelector('.rc-card-eyebrow')) {
                const eyebrow = document.createElement('div');
                eyebrow.className = 'rc-card-eyebrow';
                eyebrow.innerHTML = pinIcon + '<span>' + escapeHtml(item.location || copy.selected_label) + '</span>';
                titleWrapper.insertBefore(eyebrow, titleWrapper.firstChild);
            }

            const price = card.querySelector('.listing-card-info-price');
            if (price && item.price_label) {
                price.innerHTML =
                    '<small>' + escapeHtml(item.price_caption) + '</small>' +
                    '<span>' + escapeHtml(item.price_label) + '</span>';
            }

            const priceWrapper = card.querySelector('.listing-short-detail-flex');
            if (priceWrapper && !card.querySelector('.rc-featured-payment-note')) {
                const paymentNote = document.createElement('div');
                paymentNote.className = 'rc-featured-payment-note';
                paymentNote.innerHTML = '<span>' + walletIcon + '</span><span>' + escapeHtml(item.payment_detail) + '</span>';
                priceWrapper.insertAdjacentElement('afterend', paymentNote);
            }

            const detailsLink = card.querySelector('.listing-detail-footer .prt-view');
            if (detailsLink) {
                detailsLink.classList.add('rc-featured-cta');
                detailsLink.innerHTML = '<span>' + escapeHtml(copy.view_details) + '</span>' + arrowIcon;
            }

            const image = card.querySelector('.listing-img-wrapper img');
            const title = propertyLink ? propertyLink.textContent.trim() : '';
            if (image && title && (!image.alt || image.alt === 'main')) {
                image.alt = title;
            }
        };

        const enhanceFeaturedSection = function () {
            const slider = getFeaturedSlider();

            if (!slider) {
                return;
            }

            const section = slider.closest('section');
            if (!section) {
                return;
            }

            section.classList.add('rc-featured-section');
            section.classList.add(copy.direction === 'rtl' ? 'rc-featured-rtl' : 'rc-featured-ltr');
            enhanceHeading(section);

            slider.querySelectorAll('.property-listing').forEach(function (card, index) {
                enhanceCard(card, index);
            });

            if (!slider.dataset.rcFeaturedObserver) {
                slider.dataset.rcFeaturedObserver = '1';

                const observer = new MutationObserver(function () {
                    slider.querySelectorAll('.property-listing').forEach(function (card, index) {
                        enhanceCard(card, index);
                    });
                });

                observer.observe(slider, {
                    childList: true,
                    subtree: true,
                });
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', enhanceFeaturedSection, { once: true });
        } else {
            enhanceFeaturedSection();
        }

        window.addEventListener('load', enhanceFeaturedSection, { once: true });
        window.setTimeout(enhanceFeaturedSection, 450);
    })();
</script>
