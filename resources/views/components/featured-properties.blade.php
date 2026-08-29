@if($properties->isNotEmpty())
    <section class="rc-fp-section" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}" aria-labelledby="rc-fp-title">
        <div class="rc-fp-decor rc-fp-decor--one" aria-hidden="true"></div>
        <div class="rc-fp-decor rc-fp-decor--two" aria-hidden="true"></div>

        <div class="container">
            <header class="rc-fp-header">
                <div class="rc-fp-header__text">
                    <span class="rc-fp-eyebrow">
                        <i class="fas fa-crown" aria-hidden="true"></i>
                        {{ $isEnglish ? 'Premium picks' : 'اختيارات مميزة' }}
                    </span>
                    <h2 id="rc-fp-title">{{ $title }}</h2>
                    <p>{{ $subtitle }}</p>
                </div>

                <a href="{{ $viewAllUrl }}" class="rc-fp-view-all">
                    <span>{{ $isEnglish ? 'View all' : 'عرض الكل' }}</span>
                    <i class="fas {{ $isEnglish ? 'fa-arrow-right' : 'fa-arrow-left' }}" aria-hidden="true"></i>
                </a>
            </header>

            <div class="rc-fp-grid">
                @foreach($properties as $aqar)
                    <article class="rc-fp-card">
                        <a href="{{ $aqar->featured_url }}" class="rc-fp-card__media" target="_blank"
                           aria-label="{{ $isEnglish ? 'View' : 'عرض' }} {{ $aqar->featured_title }}">
                            <img src="{{ $aqar->featured_image }}"
                                 alt="{{ $aqar->featured_title }}"
                                 loading="lazy"
                                 width="640" height="420">

                            <span class="rc-fp-card__gradient" aria-hidden="true"></span>

                            <span class="rc-fp-card__vip">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                {{ $isEnglish ? 'VIP' : 'مميز' }}
                            </span>

                            <span class="rc-fp-card__offer">{{ $aqar->featured_offer_name }}</span>

                            <span class="rc-fp-card__views">
                                <i class="fas fa-eye" aria-hidden="true"></i>
                                {{ number_format((int) $aqar->views) }}
                            </span>
                        </a>

                        <div class="rc-fp-card__body">
                            <h3 class="rc-fp-card__title">
                                <a href="{{ $aqar->featured_url }}" target="_blank">
                                    {{ \Illuminate\Support\Str::limit($aqar->featured_title, 55) }}
                                </a>
                            </h3>

                            <div class="rc-fp-card__location">
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                <span>
                                    {{ optional($aqar->governrateq)->governrate }}
                                    @if($aqar->districte)
                                        <bdi>، {{ $aqar->districte->district }}</bdi>
                                    @endif
                                </span>
                            </div>

                            <ul class="rc-fp-card__features">
                                <li>
                                    <img src="{{ asset('images/icons/room.png') }}" width="16" height="16" alt="">
                                    <span>{{ (int) $aqar->rooms }}</span>
                                    <small>{{ $isEnglish ? 'Rooms' : 'غرف' }}</small>
                                </li>
                                <li>
                                    <img src="{{ asset('images/icons/bath.png') }}" width="16" height="16" alt="">
                                    <span>{{ (int) $aqar->baths }}</span>
                                    <small>{{ $isEnglish ? 'Baths' : 'حمام' }}</small>
                                </li>
                                <li>
                                    <img src="{{ asset('images/icons/area.png') }}" width="16" height="16" alt="">
                                    <span>{{ number_format((float) $aqar->total_area) }}</span>
                                    <small>{{ $isEnglish ? 'm²' : 'م²' }}</small>
                                </li>
                            </ul>

                            <div class="rc-fp-card__footer">
                                <div class="rc-fp-card__price">
                                    @if($aqar->featured_has_price)
                                        <strong>{{ number_format((float) $aqar->featured_price) }}</strong>
                                        <span>{{ $isEnglish ? 'EGP' : 'ج.م' }}</span>
                                    @else
                                        <strong>{{ $isEnglish ? 'On request' : 'السعر عند التواصل' }}</strong>
                                    @endif
                                </div>

                                <a href="{{ $aqar->featured_url }}" target="_blank" class="rc-fp-card__cta">
                                    {{ $isEnglish ? 'Details' : 'عرض' }}
                                    <i class="fas {{ $isEnglish ? 'fa-arrow-right' : 'fa-arrow-left' }}" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .rc-fp-section {
            --rc-fp-navy: #042C4E;
            --rc-fp-blue: #0B5F9F;
            --rc-fp-blue-dark: #073F73;
            --rc-fp-orange: #F47D35;
            --rc-fp-green: #18C7A1;
            --rc-fp-ink: #102a43;
            --rc-fp-muted: #64748b;
            position: relative;
            overflow: hidden;
            padding: 70px 0 60px;
            color: var(--rc-fp-ink);
            background:
                radial-gradient(circle at 92% 8%, rgba(24, 199, 161, .10), transparent 32%),
                radial-gradient(circle at 6% 92%, rgba(244, 125, 53, .10), transparent 32%),
                linear-gradient(180deg, #f6f9fc 0%, #eef4fb 100%);
        }

        .rc-fp-section *,
        .rc-fp-section *::before,
        .rc-fp-section *::after {
            box-sizing: border-box;
        }

        .rc-fp-decor {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(2px);
            opacity: .5;
        }

        .rc-fp-decor--one {
            width: 340px;
            height: 340px;
            top: -140px;
            inset-inline-end: -120px;
            background: radial-gradient(circle, rgba(11, 95, 159, .16), transparent 65%);
        }

        .rc-fp-decor--two {
            width: 260px;
            height: 260px;
            bottom: -110px;
            inset-inline-start: -90px;
            background: radial-gradient(circle, rgba(244, 125, 53, .18), transparent 65%);
        }

        .rc-fp-section .container {
            position: relative;
            z-index: 2;
        }

        .rc-fp-header {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 34px;
        }

        .rc-fp-header__text {
            max-width: 760px;
        }

        .rc-fp-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            margin-bottom: 12px;
            border-radius: 999px;
            color: var(--rc-fp-orange);
            background: rgba(244, 125, 53, .10);
            font-size: 12px;
            font-weight: 900;
            letter-spacing: .3px;
        }

        .rc-fp-header h2 {
            margin: 0 0 10px;
            color: var(--rc-fp-navy);
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 900;
            line-height: 1.25;
        }

        .rc-fp-header p {
            margin: 0;
            color: var(--rc-fp-muted);
            font-size: 15px;
            line-height: 1.9;
            font-weight: 600;
        }

        .rc-fp-view-all {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            flex-shrink: 0;
            padding: 12px 22px;
            border-radius: 999px;
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-fp-blue), var(--rc-fp-navy));
            font-size: 14px;
            font-weight: 900;
            text-decoration: none !important;
            box-shadow: 0 15px 30px rgba(11, 95, 159, .28);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .rc-fp-view-all:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 38px rgba(11, 95, 159, .35);
            color: #fff !important;
        }

        .rc-fp-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 24px;
        }

        .rc-fp-card {
            position: relative;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 22px 45px rgba(6, 58, 102, .09);
            transition: transform .28s ease, box-shadow .28s ease;
        }

        .rc-fp-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px rgba(6, 58, 102, .18);
        }

        .rc-fp-card__media {
            position: relative;
            display: block;
            height: 225px;
            overflow: hidden;
            background: #e6eef7;
            text-decoration: none;
        }

        .rc-fp-card__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .55s ease;
            display: block;
        }

        .rc-fp-card:hover .rc-fp-card__media img {
            transform: scale(1.07);
        }

        .rc-fp-card__gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(4, 44, 78, 0) 45%, rgba(4, 44, 78, .55) 100%);
        }

        .rc-fp-card__vip,
        .rc-fp-card__offer,
        .rc-fp-card__views {
            position: absolute;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 900;
            line-height: 1;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .18);
        }

        .rc-fp-card__vip {
            top: 14px;
            inset-inline-start: 14px;
            color: #fff;
            background: linear-gradient(135deg, #F47D35, #E85F1C);
        }

        .rc-fp-card__vip i {
            font-size: 10px;
            color: #fff;
        }

        .rc-fp-card__offer {
            top: 14px;
            inset-inline-end: 14px;
            color: var(--rc-fp-blue-dark);
            background: rgba(255, 255, 255, .96);
        }

        .rc-fp-card__views {
            bottom: 14px;
            inset-inline-end: 14px;
            color: #fff;
            background: rgba(4, 44, 78, .82);
            backdrop-filter: blur(4px);
        }

        .rc-fp-card__body {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px;
        }

        .rc-fp-card__title {
            margin: 0;
            min-height: 46px;
            font-size: 17px;
            font-weight: 900;
            line-height: 1.5;
        }

        .rc-fp-card__title a {
            color: var(--rc-fp-navy) !important;
            text-decoration: none !important;
            transition: color .2s ease;
        }

        .rc-fp-card__title a:hover {
            color: var(--rc-fp-blue) !important;
        }

        .rc-fp-card__location {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--rc-fp-muted);
            font-size: 13px;
            font-weight: 600;
        }

        .rc-fp-card__location i {
            color: var(--rc-fp-orange);
            font-size: 13px;
        }

        .rc-fp-card__features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 6px;
            padding: 12px 8px;
            margin: 0;
            list-style: none;
            border-radius: 14px;
            background: linear-gradient(135deg, #f5f9fd, #eef4fb);
        }

        .rc-fp-card__features li {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: var(--rc-fp-ink);
            font-size: 13px;
            font-weight: 800;
        }

        .rc-fp-card__features img {
            width: 16px;
            height: 16px;
            object-fit: contain;
            margin-bottom: 2px;
            opacity: .85;
        }

        .rc-fp-card__features small {
            color: var(--rc-fp-muted);
            font-size: 10px;
            font-weight: 700;
        }

        .rc-fp-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 4px;
        }

        .rc-fp-card__price {
            display: flex;
            align-items: baseline;
            gap: 5px;
            color: var(--rc-fp-orange);
        }

        .rc-fp-card__price strong {
            font-size: 20px;
            font-weight: 900;
            line-height: 1;
        }

        .rc-fp-card__price span {
            color: var(--rc-fp-muted);
            font-size: 11px;
            font-weight: 700;
        }

        .rc-fp-card__cta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 9px 16px;
            border-radius: 12px;
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-fp-blue), var(--rc-fp-blue-dark));
            font-size: 13px;
            font-weight: 900;
            text-decoration: none !important;
            box-shadow: 0 10px 20px rgba(11, 95, 159, .25);
            transition: transform .22s ease, box-shadow .22s ease, background .25s ease;
        }

        .rc-fp-card__cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 26px rgba(11, 95, 159, .35);
            background: linear-gradient(135deg, var(--rc-fp-orange), #E85F1C);
            color: #fff !important;
        }

        @media (max-width: 991.98px) {
            .rc-fp-section { padding: 55px 0 50px; }
            .rc-fp-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
            .rc-fp-header { align-items: stretch; flex-direction: column; }
            .rc-fp-view-all { align-self: flex-start; }
        }

        @media (max-width: 575.98px) {
            .rc-fp-section { padding: 42px 0 40px; }
            .rc-fp-grid { grid-template-columns: 1fr; }
            .rc-fp-card__media { height: 210px; }
            .rc-fp-card__title { min-height: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-fp-card,
            .rc-fp-card__media img,
            .rc-fp-view-all,
            .rc-fp-card__cta {
                transition: none;
            }
        }
    </style>
@endif
