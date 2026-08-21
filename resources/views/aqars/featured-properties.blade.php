<x-layout>
    @section('title', $isEnglish ? 'Featured Properties' : 'العقارات المميزة')

    <main class="rc-featured-page" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}">
        <section class="rc-featured-hero">
            <div class="container rc-featured-hero__inner">
                <div class="rc-featured-hero__copy">
                    <span class="rc-featured-hero__eyebrow">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        {{ $isEnglish ? 'Carefully selected opportunities' : 'فرص مختارة بعناية' }}
                    </span>
                    <h1>{{ $isEnglish ? 'Featured Properties' : 'العقارات المميزة' }}</h1>
                    <p>
                        {{ $isEnglish
                            ? 'Browse the best currently featured properties and contact owners directly.'
                            : 'تصفح أفضل العقارات المميزة حاليًا وتواصل مباشرة مع المالك بدون وسيط.' }}
                    </p>
                </div>

                <div class="rc-featured-hero__stat">
                    <strong>{{ number_format($featuredAqars->total()) }}</strong>
                    <span>{{ $isEnglish ? 'Featured properties' : 'عقار مميز' }}</span>
                </div>
            </div>
        </section>

        <section class="container rc-featured-results" aria-labelledby="featured-properties-title">
            <div class="rc-featured-results__heading">
                <div>
                    <span>{{ $isEnglish ? 'Active featured listings' : 'إعلانات مميزة فعالة' }}</span>
                    <h2 id="featured-properties-title">
                        {{ $isEnglish ? 'Find your next property' : 'اختر عقارك المناسب' }}
                    </h2>
                </div>
                <p>
                    {{ $isEnglish
                        ? 'Only published properties with an active promotion are shown here.'
                        : 'يتم عرض العقارات المنشورة التي ما زال تمييزها ساريًا فقط.' }}
                </p>
            </div>

            @if($featuredAqars->isNotEmpty())
                <div class="rc-featured-grid">
                    @foreach($featuredAqars as $aqar)
                        <article class="rc-featured-card">
                            <a href="{{ $aqar->featured_url }}" class="rc-featured-card__media" target="_blank"
                               aria-label="{{ $isEnglish ? 'View' : 'عرض' }} {{ $aqar->featured_title }}">
                                <img src="{{ $aqar->featured_image }}" alt="{{ $aqar->featured_title }}" width="640" height="420" loading="lazy">

                                <span class="rc-featured-card__badge">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    {{ $isEnglish ? 'Featured' : 'مميز' }}
                                </span>
                                <span class="rc-featured-card__offer">{{ $aqar->featured_offer_name }}</span>
                                <span class="rc-featured-card__views">
                                    <i class="fas fa-eye" aria-hidden="true"></i>
                                    {{ number_format((int) $aqar->views) }}
                                </span>
                            </a>

                            <div class="rc-featured-card__body">
                                <div class="rc-featured-card__reference">
                                    <span>{{ $aqar->featured_offer_name }}</span>
                                    <small>#{{ $aqar->id }}</small>
                                </div>

                                <h3>
                                    <a href="{{ $aqar->featured_url }}" target="_blank">{{ $aqar->featured_title }}</a>
                                </h3>

                                <div class="rc-featured-card__price">
                                    @if($aqar->featured_has_price)
                                        <strong>{{ number_format((float) $aqar->featured_price) }}</strong>
                                        <span>{{ $isEnglish ? 'EGP' : 'جنيه مصري' }}</span>
                                    @else
                                        <strong>{{ $isEnglish ? 'Contact for price' : 'السعر عند التواصل' }}</strong>
                                    @endif
                                </div>

                                <div class="rc-featured-card__features">
                                    <span>
                                        <img src="{{ asset('images/icons/area.png') }}" width="17" height="17" alt="">
                                        {{ number_format((float) $aqar->total_area) }} {{ $isEnglish ? 'm²' : 'م²' }}
                                    </span>
                                    <span>
                                        <img src="{{ asset('images/icons/room.png') }}" width="17" height="17" alt="">
                                        {{ (int) $aqar->rooms }} {{ $isEnglish ? 'Rooms' : 'غرف' }}
                                    </span>
                                    <span>
                                        <img src="{{ asset('images/icons/bath.png') }}" width="17" height="17" alt="">
                                        {{ (int) $aqar->baths }} {{ $isEnglish ? 'Baths' : 'حمام' }}
                                    </span>
                                </div>

                                <div class="rc-featured-card__footer">
                                    <div class="rc-featured-card__location">
                                        <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                        <span>
                                            {{ optional($aqar->governrateq)->governrate }}
                                            @if($aqar->districte)
                                                <bdi>، {{ $aqar->districte->district }}</bdi>
                                            @endif
                                        </span>
                                    </div>

                                    <a href="{{ $aqar->featured_url }}" target="_blank" class="rc-featured-card__action">
                                        {{ $isEnglish ? 'View details' : 'عرض التفاصيل' }}
                                        <i class="fas {{ $isEnglish ? 'fa-arrow-right' : 'fa-arrow-left' }}" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($featuredAqars->hasPages())
                    <div class="rc-featured-pagination">
                        {{ $featuredAqars->links() }}
                    </div>
                @endif
            @else
                <div class="rc-featured-empty">
                    <span><i class="far fa-star" aria-hidden="true"></i></span>
                    <h2>{{ $isEnglish ? 'No featured properties currently' : 'لا توجد عقارات مميزة حاليًا' }}</h2>
                    <p>
                        {{ $isEnglish
                            ? 'New featured opportunities will appear here as soon as they become available.'
                            : 'ستظهر هنا الفرص العقارية المميزة فور توفرها.' }}
                    </p>
                    <a href="{{ URL::to(Config::get('app.locale') . '/all_aqar_for_sale') }}">
                        {{ $isEnglish ? 'Browse all properties' : 'تصفح كل العقارات' }}
                    </a>
                </div>
            @endif
        </section>
    </main>

    <style>
        .rc-featured-page {
            --rc-blue: #0b5f9f;
            --rc-blue-dark: #063a66;
            --rc-orange: #f47d35;
            --rc-ink: #102a43;
            --rc-muted: #64748b;
            min-height: 70vh;
            background: #f6f9fc;
            color: var(--rc-ink);
            padding-bottom: 70px;
        }

        .rc-featured-page *, .rc-featured-page *::before, .rc-featured-page *::after {
            box-sizing: border-box;
        }

        .rc-featured-hero {
            position: relative;
            overflow: hidden;
            padding: 70px 0;
            color: #fff;
            background:
                radial-gradient(circle at 12% 15%, rgba(244, 125, 53, .34), transparent 30%),
                linear-gradient(135deg, #042c4e, #0b5f9f);
        }

        .rc-featured-hero::after {
            content: '';
            position: absolute;
            width: 320px;
            height: 320px;
            inset-inline-end: -90px;
            top: -150px;
            border: 65px solid rgba(255,255,255,.07);
            border-radius: 50%;
        }

        .rc-featured-hero__inner {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 35px;
        }

        .rc-featured-hero__copy { max-width: 720px; }
        .rc-featured-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: #ffd5b9;
            font-size: 14px;
            font-weight: 800;
        }

        .rc-featured-hero h1 {
            margin: 0 0 14px;
            color: #fff;
            font-size: clamp(34px, 5vw, 56px);
            font-weight: 900;
        }

        .rc-featured-hero p {
            max-width: 650px;
            margin: 0;
            color: rgba(255,255,255,.82);
            font-size: 17px;
            line-height: 1.9;
        }

        .rc-featured-hero__stat {
            min-width: 155px;
            padding: 22px;
            text-align: center;
            border: 1px solid rgba(255,255,255,.22);
            border-radius: 24px;
            background: rgba(255,255,255,.1);
            backdrop-filter: blur(10px);
        }

        .rc-featured-hero__stat strong { display: block; color: #fff; font-size: 40px; font-weight: 900; }
        .rc-featured-hero__stat span { color: rgba(255,255,255,.8); font-size: 13px; font-weight: 700; }

        .rc-featured-results { padding-top: 55px; }
        .rc-featured-results__heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 25px;
            margin-bottom: 28px;
        }

        .rc-featured-results__heading span { color: var(--rc-orange); font-size: 13px; font-weight: 900; }
        .rc-featured-results__heading h2 { margin: 6px 0 0; font-size: 30px; font-weight: 900; }
        .rc-featured-results__heading p { max-width: 470px; margin: 0; color: var(--rc-muted); line-height: 1.8; }

        .rc-featured-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .rc-featured-card {
            overflow: hidden;
            border: 1px solid #e5edf5;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(6, 58, 102, .08);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .rc-featured-card:hover { transform: translateY(-6px); box-shadow: 0 22px 48px rgba(6, 58, 102, .15); }
        .rc-featured-card__media { position: relative; display: block; height: 235px; overflow: hidden; background: #eaf0f6; }
        .rc-featured-card__media img { width: 100%; height: 100%; object-fit: cover; transition: transform .45s ease; }
        .rc-featured-card:hover .rc-featured-card__media img { transform: scale(1.045); }

        .rc-featured-card__badge, .rc-featured-card__offer, .rc-featured-card__views {
            position: absolute;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
        }

        .rc-featured-card__badge { top: 14px; inset-inline-start: 14px; color: #fff; background: var(--rc-orange); }
        .rc-featured-card__offer { top: 14px; inset-inline-end: 14px; color: var(--rc-blue-dark); background: rgba(255,255,255,.94); }
        .rc-featured-card__views { bottom: 13px; inset-inline-end: 13px; color: #fff; background: rgba(4,44,78,.78); }
        .rc-featured-card__body { padding: 20px; }

        .rc-featured-card__reference { display: flex; justify-content: space-between; gap: 12px; color: var(--rc-muted); font-size: 12px; font-weight: 700; }
        .rc-featured-card h3 { min-height: 54px; margin: 10px 0 12px; font-size: 19px; font-weight: 900; line-height: 1.45; }
        .rc-featured-card h3 a { color: var(--rc-ink); text-decoration: none; }
        .rc-featured-card h3 a:hover { color: var(--rc-blue); }

        .rc-featured-card__price { display: flex; align-items: baseline; gap: 7px; margin-bottom: 16px; color: var(--rc-orange); }
        .rc-featured-card__price strong { font-size: 23px; font-weight: 900; }
        .rc-featured-card__price span { color: var(--rc-muted); font-size: 11px; font-weight: 700; }

        .rc-featured-card__features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
            padding: 13px 0;
            border-block: 1px solid #edf2f7;
        }

        .rc-featured-card__features span { display: flex; align-items: center; justify-content: center; gap: 5px; color: #52677a; font-size: 11px; font-weight: 800; }
        .rc-featured-card__features img { object-fit: contain; }
        .rc-featured-card__footer { padding-top: 16px; }
        .rc-featured-card__location { display: flex; align-items: center; gap: 7px; min-height: 24px; margin-bottom: 14px; color: var(--rc-muted); font-size: 12px; }
        .rc-featured-card__location i { color: var(--rc-orange); }

        .rc-featured-card__action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 11px 16px;
            border-radius: 12px;
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-blue), var(--rc-blue-dark));
            font-size: 13px;
            font-weight: 900;
            text-decoration: none !important;
        }

        .rc-featured-pagination { display: flex; justify-content: center; margin-top: 38px; }
        .rc-featured-empty { padding: 70px 20px; text-align: center; border: 1px dashed #cddbe8; border-radius: 24px; background: #fff; }
        .rc-featured-empty > span { display: inline-grid; place-items: center; width: 74px; height: 74px; margin-bottom: 18px; border-radius: 50%; color: var(--rc-orange); background: #fff2e9; font-size: 30px; }
        .rc-featured-empty h2 { margin-bottom: 10px; font-weight: 900; }
        .rc-featured-empty p { margin-bottom: 22px; color: var(--rc-muted); }
        .rc-featured-empty a { display: inline-block; padding: 11px 22px; border-radius: 12px; color: #fff; background: var(--rc-blue); font-weight: 800; text-decoration: none; }

        @media (max-width: 991.98px) {
            .rc-featured-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 767.98px) {
            .rc-featured-hero { padding: 48px 0; }
            .rc-featured-hero__inner, .rc-featured-results__heading { align-items: stretch; flex-direction: column; }
            .rc-featured-hero__stat { align-self: flex-start; min-width: 135px; }
            .rc-featured-results { padding-top: 38px; }
            .rc-featured-results__heading h2 { font-size: 25px; }
            .rc-featured-grid { grid-template-columns: 1fr; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-featured-card, .rc-featured-card__media img { transition: none; }
        }
    </style>
</x-layout>
