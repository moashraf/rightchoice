<x-layout>
    <!-- ============================ Hero Banner Start ================================== -->
    <section class="rc-hero" dir="{{ App::isLocale('en') ? 'ltr' : 'rtl' }}">
        <div class="hero-slide-1 rc-hero-slider">
            @if(!empty($slider))
                @foreach($slider as $slid)
                    <div class="image-cover hero-banner single-items rc-hero-slide"
                         style="--rc-hero-image: url('{{ URL::to('/').'/'.$slid->image }}');">
                        <div class="rc-hero-overlay"></div>
                        <div class="rc-hero-glow rc-hero-glow-one"></div>
                        <div class="rc-hero-glow rc-hero-glow-two"></div>

                        <div class="container rc-hero-container">
                            <div class="row align-items-center rc-hero-row">
                                <!-- Search card -->
                                <div class="col-xl-5 col-lg-5 col-md-12 order-2 order-lg-1">
                                    <form action="{{ URL::to(Config::get('app.locale').'/search') }}"
                                          method="GET"
                                          class="rc-search-card">
                                        <div class="rc-search-heading">
                                            <span class="rc-search-heading-line"></span>
                                            <div>
                                                    <span class="rc-search-kicker">
                                                        {{ App::isLocale('en') ? 'Find your next property' : 'ابحث عن عقارك' }}
                                                    </span>
                                                <h2>{{ App::isLocale('en') ? 'Start your search now' : 'ابدأ البحث الآن' }}</h2>
                                            </div>
                                        </div>

                                        <div class="rc-field rc-field-keyword">

                                            <div class="rc-input-wrap">
                                                <input id="hero-keywords-{{ $loop->index }}"
                                                       name="keywords"
                                                       type="text"
                                                       class="form-control"
                                                       placeholder="{{ App::isLocale('en') ? 'Search by city, area or property' : 'ابحث بالمدينة أو المنطقة أو نوع العقار' }}">
                                                <span class="rc-input-icon" aria-hidden="true">
                                                        <svg width="21" height="21" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" stroke="currentColor" stroke-width="1.8"/>
                                                            <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                        </svg>
                                                    </span>
                                            </div>
                                        </div>

                                        <div class="row rc-search-grid">
                                            <div class="col-md-4 col-sm-12">
                                                <div class="rc-field">
                                                    <label for="hero-offer-{{ $loop->index }}">{{ trans('langsite.offer_type') }}</label>
                                                    <div class="rc-select-wrap">
                                                        <select name="offerType"
                                                                id="hero-offer-{{ $loop->index }}"
                                                                class="form-control">
                                                            <option value="">{{ App::isLocale('en') ? 'All offers' : 'كل العروض' }}</option>
                                                            @foreach ($offers as $off)
                                                                <option value="{{ $off->id }}">
                                                                    @if(App::isLocale('en'))
                                                                        {{ $off->type_offer_en }}
                                                                    @else
                                                                        {{ $off->type_offer }}
                                                                    @endif
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="rc-field">
                                                    <label for="hero-min-price-{{ $loop->index }}">
                                                        {{ App::isLocale('en') ? 'Minimum price' : 'أقل سعر' }}
                                                    </label>
                                                    <input id="hero-min-price-{{ $loop->index }}"
                                                           type="number"
                                                           min="0"
                                                           name="minPrice"
                                                           class="form-control"
                                                           placeholder="{{ App::isLocale('en') ? 'From' : 'من' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-sm-6">
                                                <div class="rc-field">
                                                    <label for="hero-max-price-{{ $loop->index }}">
                                                        {{ App::isLocale('en') ? 'Maximum price' : 'أعلى سعر' }}
                                                    </label>
                                                    <input id="hero-max-price-{{ $loop->index }}"
                                                           type="number"
                                                           min="0"
                                                           name="maxPrice"
                                                           class="form-control"
                                                           placeholder="{{ App::isLocale('en') ? 'To' : 'إلى' }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="rc-search-actions">
                                            <button type="submit" class="btn rc-search-submit">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M11 19a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z" stroke="currentColor" stroke-width="2"/>
                                                    <path d="m21 21-4.35-4.35" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                </svg>
                                                <span>{{ trans('langsite.search') }}</span>
                                            </button>

                                            <button type="reset" class="btn rc-search-reset">
                                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M4 4v6h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M20 11a8 8 0 0 0-13.66-5.66L4 10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                    <path d="M20 20v-6h-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M4 13a8 8 0 0 0 13.66 5.66L20 14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                </svg>
                                                <span>{{ App::isLocale('en') ? 'Reset' : 'إعادة تعيين' }}</span>
                                            </button>
                                        </div>

                                        <div class="rc-search-trust">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M12 3 5 6v5c0 4.6 2.98 8.88 7 10 4.02-1.12 7-5.4 7-10V6l-7-3Z" stroke="currentColor" stroke-width="1.8"/>
                                                <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <span>{{ App::isLocale('en') ? 'Direct contact with property owners' : 'تواصل مباشر وآمن مع أصحاب العقارات' }}</span>
                                        </div>
                                    </form>
                                </div>

                                <!-- Hero content -->
                                <div class="col-xl-7 col-lg-7 col-md-12 order-1 order-lg-2">
                                    <div class="rc-hero-content">
                                            <span class="rc-hero-badge">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M3 11.5 12 4l9 7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5.5 10.5V20h13v-9.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                    <path d="M9.5 20v-6h5v6" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                </svg>
                                                {{ App::isLocale('en') ? 'Property deals without intermediaries' : 'بيع وشراء العقارات بدون وسيط' }}
                                            </span>

                                        <h3 class="rc-hero-title">
                                            @if(App::isLocale('en'))
                                                {{ !empty($slid->title_en) ? $slid->title_en : 'Buy and sell property directly' }}
                                            @else
                                                {{ !empty($slid->title) ? $slid->title : 'بيع واشتري عقارك مباشرة' }}
                                            @endif
                                            <span>{{ App::isLocale('en') ? 'without commission' : 'بدون وسيط' }}</span>
                                        </h3>

                                        <p class="rc-hero-subtitle">
                                            @if(App::isLocale('en'))
                                                {{ !empty($slid->sub_title_en) ? $slid->sub_title_en : 'Connect directly with sellers and buyers in one trusted place.' }}
                                            @else
                                                {{ !empty($slid->sub_title) ? $slid->sub_title : 'نوصل البائع بالمشتري مباشرة في مكان واحد موثوق وسهل.' }}
                                            @endif
                                        </p>

                                        <p class="rc-hero-description">
                                            @if(App::isLocale('en'))
                                                {{ !empty($slid->description_en) ? $slid->description_en : 'Browse verified listings or publish your property for free and receive offers directly.' }}
                                            @else
                                                {{ !empty($slid->description) ? $slid->description : 'اعرض عقارك أو ابحث عن أفضل الفرص العقارية وتواصل مباشرة بدون عمولات إضافية.' }}
                                            @endif
                                        </p>

                                        <div class="rc-hero-features">
                                            <div class="rc-feature-item">
                                                    <span class="rc-feature-icon">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                            <path d="M8 10h.01M12 10h.01M16 10h.01" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                                        </svg>
                                                    </span>
                                                <span>
                                                        <strong>{{ App::isLocale('en') ? 'Direct contact' : 'تواصل مباشر' }}</strong>
                                                        <small>{{ App::isLocale('en') ? 'Seller to buyer' : 'بين البائع والمشتري' }}</small>
                                                    </span>
                                            </div>

                                            <div class="rc-feature-item">
                                                    <span class="rc-feature-icon">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path d="M19 5 5 19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                            <circle cx="7" cy="7" r="2" stroke="currentColor" stroke-width="1.8"/>
                                                            <circle cx="17" cy="17" r="2" stroke="currentColor" stroke-width="1.8"/>
                                                        </svg>
                                                    </span>
                                                <span>
                                                        <strong>{{ App::isLocale('en') ? 'No commission' : 'بدون عمولة' }}</strong>
                                                        <small>{{ App::isLocale('en') ? 'Save time and money' : 'وفر وقتك ومالك' }}</small>
                                                    </span>
                                            </div>

                                            <div class="rc-feature-item">
                                                    <span class="rc-feature-icon">
                                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                            <path d="M12 3 5 6v5c0 4.6 2.98 8.88 7 10 4.02-1.12 7-5.4 7-10V6l-7-3Z" stroke="currentColor" stroke-width="1.8"/>
                                                            <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                                <span>
                                                        <strong>{{ App::isLocale('en') ? 'Trusted listings' : 'إعلانات موثوقة' }}</strong>
                                                        <small>{{ App::isLocale('en') ? 'Clear property details' : 'تفاصيل عقارية واضحة' }}</small>
                                                    </span>
                                            </div>
                                        </div>

                                        <div class="rc-hero-actions">
                                            <a href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_sale') }}"
                                               class="btn rc-primary-cta">
                                                <span>{{ App::isLocale('en') ? 'Browse properties' : 'تصفح العقارات' }}</span>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path d="M3 11.5 12 4l9 7.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M5.5 10.5V20h13v-9.5" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                    <path d="M9.5 20v-6h5v6" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                            <a href="{{ URL::to(Config::get('app.locale').'/aqars/create') }}"
                                               class="btn rc-secondary-cta">
                                                <span>{{ App::isLocale('en') ? 'Add your property free' : 'أضف عقارك مجاناً' }}</span>
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                                                    <path d="M12 8v8M8 12h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

{{--                            <div class="rc-benefits-bar">--}}
{{--                                <div class="rc-benefit">--}}
{{--                                        <span class="rc-benefit-icon">--}}
{{--                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">--}}
{{--                                                <path d="M12 21s7-3.5 7-10V6l-7-3-7 3v5c0 6.5 7 10 7 10Z" stroke="currentColor" stroke-width="1.7"/>--}}
{{--                                                <path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                    <span><strong>{{ App::isLocale('en') ? 'Easy and secure' : 'سهولة وأمان' }}</strong><small>{{ App::isLocale('en') ? 'A clear property experience' : 'تجربة عقارية واضحة' }}</small></span>--}}
{{--                                </div>--}}
{{--                                <div class="rc-benefit">--}}
{{--                                        <span class="rc-benefit-icon">--}}
{{--                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">--}}
{{--                                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.7"/>--}}
{{--                                                <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.7"/>--}}
{{--                                                <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                    <span><strong>{{ App::isLocale('en') ? 'Buyer meets seller' : 'البائع يقابل المشتري' }}</strong><small>{{ App::isLocale('en') ? 'Without an intermediary' : 'بدون طرف وسيط' }}</small></span>--}}
{{--                                </div>--}}
{{--                                <div class="rc-benefit">--}}
{{--                                        <span class="rc-benefit-icon">--}}
{{--                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">--}}
{{--                                                <path d="M4 21h16M6 21V7l6-4 6 4v14" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>--}}
{{--                                                <path d="M9 10h1M14 10h1M9 14h1M14 14h1M9 18h1M14 18h1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                    <span><strong>{{ App::isLocale('en') ? 'Various properties' : 'عقارات متنوعة' }}</strong><small>{{ App::isLocale('en') ? 'Sale and rent listings' : 'للبيع وللإيجار' }}</small></span>--}}
{{--                                </div>--}}
{{--                                <div class="rc-benefit">--}}
{{--                                        <span class="rc-benefit-icon">--}}
{{--                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">--}}
{{--                                                <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z" stroke="currentColor" stroke-width="1.7"/>--}}
{{--                                                <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.7"/>--}}
{{--                                            </svg>--}}
{{--                                        </span>--}}
{{--                                    <span><strong>{{ App::isLocale('en') ? 'Across Egypt' : 'كل محافظات مصر' }}</strong><small>{{ App::isLocale('en') ? 'Search by your location' : 'ابحث حسب موقعك' }}</small></span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </section>

    <style>
        /* ================= Modern responsive hero slider ================= */
        .rc-hero {
            --rc-green: #13c89b;
            --rc-green-dark: #08a77e;
            --rc-orange: #ff7a1a;
            --rc-navy: #071e38;
            --rc-white: #ffffff;
            position: relative;
            background: var(--rc-navy);
            overflow: hidden;
            padding: 0px 0 0px 0px;
        }

        .rc-hero-slider,
        .rc-hero-slider .slick-list,
        .rc-hero-slider .slick-track {
            min-height: 635px;
        }

        .rc-hero-slide {
            position: relative;
            min-height: 760px;
            padding: 70px 0 36px;
            background-image: var(--rc-hero-image) !important;
            background-repeat: no-repeat !important;
            background-position: center !important;
            background-size: cover !important;
            overflow: hidden;
            isolation: isolate;
        }

        .rc-hero-slide::before {
            content: '';
            position: absolute;
            inset: -2%;
            z-index: -3;
            background-image: var(--rc-hero-image);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            animation: rcHeroZoom 14s ease-in-out infinite alternate;
        }

        .rc-hero-overlay {
            position: absolute;
            inset: 0;
            z-index: -2;
            background:
                linear-gradient(90deg, rgba(3, 18, 35, .92) 0%, rgba(4, 26, 48, .82) 42%, rgba(5, 25, 44, .55) 72%, rgba(2, 13, 26, .68) 100%),
                linear-gradient(0deg, rgba(3, 18, 33, .88) 0%, rgba(3, 18, 33, .08) 42%, rgba(3, 18, 33, .25) 100%);
        }

        [dir="ltr"] .rc-hero-overlay {
            background:
                linear-gradient(270deg, rgba(3, 18, 35, .92) 0%, rgba(4, 26, 48, .82) 42%, rgba(5, 25, 44, .55) 72%, rgba(2, 13, 26, .68) 100%),
                linear-gradient(0deg, rgba(3, 18, 33, .88) 0%, rgba(3, 18, 33, .08) 42%, rgba(3, 18, 33, .25) 100%);
        }

        .rc-hero-glow {
            position: absolute;
            z-index: -1;
            border-radius: 50%;
            filter: blur(6px);
            pointer-events: none;
        }

        .rc-hero-glow-one {
            width: 360px;
            height: 360px;
            top: -170px;
            right: -120px;
            background: rgba(19, 200, 155, .13);
            animation: rcHeroFloat 7s ease-in-out infinite;
        }

        .rc-hero-glow-two {
            width: 280px;
            height: 280px;
            bottom: -150px;
            left: -100px;
            background: rgba(0, 124, 204, .20);
            animation: rcHeroFloat 9s ease-in-out infinite reverse;
        }

        .rc-hero-container {
            position: relative;
            z-index: 2;
        }

        .rc-hero-row {
            min-height: 535px;
        }

        .rc-hero-content {
            max-width: 690px;
            color: var(--rc-white);
            padding-inline-start: 32px;
            animation: rcHeroContentIn .9s ease both;
        }

        .rc-hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 9px 16px;
            margin-bottom: 20px;
            color: #d9fff5;
            font-size: 14px;
            font-weight: 700;
            border: 1px solid rgba(19, 200, 155, .46);
            border-radius: 999px;
            background: rgba(19, 200, 155, .12);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .rc-hero-title {
            margin: 0 0 18px;
            color: #fff;
            font-family: 'Cairo', sans-serif;
            font-size: clamp(42px, 4.35vw, 72px);
            font-weight: 900;
            font-size: 36px;
            text-align: right;
            line-height: 1.22;
            letter-spacing: -.8px;
            text-shadow: 0 7px 30px rgba(0, 0, 0, .32);
        }

        .rc-hero-title span {
            display: block;
            color: var(--rc-green);
            text-shadow: 0 8px 28px rgba(19, 200, 155, .14);
        }

        .rc-hero-subtitle {
            margin: 0 0 8px;
            color: rgba(255, 255, 255, .96);
            font-size: clamp(19px, 1.55vw, 25px);
            font-weight: 700;
            line-height: 1.75;
        }

        .rc-hero-description {
            max-width: 650px;
            margin: 0 0 24px;
            color: rgba(255, 255, 255, .74);
            font-size: 16px;
            line-height: 1.95;
        }

        .rc-hero-features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 0;
            margin: 0 0 28px;
            padding: 18px 0;
            border-top: 1px solid rgba(255, 255, 255, .12);
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .rc-feature-item {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 15px;
            border-inline-end: 1px solid rgba(255, 255, 255, .14);
        }

        .rc-feature-item:first-child {
            padding-inline-start: 0;
        }

        .rc-feature-item:last-child {
            border-inline-end: 0;
        }

        .rc-feature-icon {
            display: inline-flex;
            width: 44px;
            height: 44px;
            align-items: center;
            justify-content: center;
            flex: 0 0 44px;
            color: var(--rc-green);
            border: 1px solid rgba(19, 200, 155, .52);
            border-radius: 50%;
            background: rgba(7, 30, 56, .62);
            box-shadow: 0 0 0 7px rgba(19, 200, 155, .05);
        }

        .rc-feature-item > span:last-child {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .rc-feature-item strong {
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
        }

        .rc-feature-item small {
            color: rgba(255, 255, 255, .63);
            font-size: 11px;
            white-space: nowrap;
        }

        .rc-hero-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .rc-hero-actions .btn {
            min-height: 56px;
            padding: 0 25px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            border-radius: 10px;
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
            font-weight: 800;
            transition: transform .3s ease, box-shadow .3s ease, background .3s ease;
        }

        .rc-primary-cta {
            color: #fff !important;
            border: 1px solid var(--rc-green) !important;
            background: linear-gradient(135deg, var(--rc-green), var(--rc-green-dark)) !important;
            box-shadow: 0 13px 32px rgba(19, 200, 155, .24);
        }

        .rc-secondary-cta {
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, .62) !important;
            background: rgba(5, 27, 51, .42) !important;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .rc-hero-actions .btn:hover {
            color: #fff !important;
            transform: translateY(-3px);
        }

        .rc-primary-cta:hover {
            box-shadow: 0 17px 38px rgba(19, 200, 155, .34);
        }

        .rc-secondary-cta:hover {
            background: rgba(255, 255, 255, .12) !important;
        }

        .rc-search-card {
            text-align: right;
            position: relative;
            padding: 28px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .28);
            border-radius: 20px;
            background: linear-gradient(145deg, rgba(16, 28, 43, .86), rgba(16, 23, 34, .74));
            box-shadow: 0 28px 70px rgba(0, 0, 0, .30);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            animation: rcSearchCardIn .9s .12s ease both;
        }

        .rc-search-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            background: linear-gradient(135deg, rgba(255, 255, 255, .08), transparent 44%);
        }

        .rc-search-heading {
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 20px;
        }

        .rc-search-heading-line {
            width: 4px;
            height: 33px;
            flex: 0 0 4px;
            margin-top: 3px;
            border-radius: 999px;
            background: var(--rc-green);
            box-shadow: 0 0 18px rgba(19, 200, 155, .42);
        }

        .rc-search-kicker {
            display: block;
            margin-bottom: 3px;
            color: rgba(255, 255, 255, .66);
            font-size: 12px;
            font-weight: 600;
        }

        .rc-search-heading h2 {
            margin: 0;
            color: #fff;
            font-size: 21px;
            font-weight: 800;
        }

        .rc-field {
            position: relative;
            margin-bottom: 15px;
        }

        .rc-field label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, .85);
            font-size: 12px;
            font-weight: 700;
        }

        .rc-input-wrap,
        .rc-select-wrap {
            position: relative;
        }

        .rc-search-card .form-control {
            width: 100%;
            min-height: 54px;
            padding: 10px 15px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 9px;
            background: rgba(255, 255, 255, .075);
            box-shadow: none;
            font-family: 'Cairo', sans-serif;
            font-size: 13px;
            transition: border-color .25s ease, background .25s ease, box-shadow .25s ease;
        }

        .rc-field-keyword .form-control {
            padding-inline-end: 48px;
        }

        .rc-search-card .form-control::placeholder {
            color: rgba(255, 255, 255, .48);
        }

        .rc-search-card .form-control:focus {
            color: #fff;
            border-color: rgba(19, 200, 155, .86);
            background: rgba(255, 255, 255, .11);
            box-shadow: 0 0 0 3px rgba(19, 200, 155, .12);
        }

        .rc-search-card select.form-control option {
            color: #13243a;
            background: #fff;
        }

        .rc-input-icon {
            position: absolute;
            top: 50%;
            inset-inline-end: 16px;
            display: inline-flex;
            color: rgba(255, 255, 255, .75);
            transform: translateY(-50%);
            pointer-events: none;
        }

        .rc-search-grid {
            margin-right: -7px;
            margin-left: -7px;
        }

        .rc-search-grid > [class*="col-"] {
            padding-right: 7px;
            padding-left: 7px;
        }

        .rc-search-actions {
            display: grid;
            grid-template-columns: 1.35fr 1fr;
            gap: 12px;
            margin-top: 6px;
        }

        .rc-search-actions .btn {
            min-height: 54px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 9px;
            font-family: 'Cairo', sans-serif;
            font-size: 14px;
            font-weight: 800;
            transition: transform .25s ease, box-shadow .25s ease, background .25s ease;
        }

        .rc-search-submit {
            color: #fff !important;
            border: 1px solid var(--rc-green) !important;
            background: linear-gradient(135deg, var(--rc-green), var(--rc-green-dark)) !important;
            box-shadow: 0 12px 28px rgba(19, 200, 155, .21);
        }

        .rc-search-reset {
            color: #fff !important;
            border: 1px solid rgba(255, 255, 255, .55) !important;
            background: transparent !important;
        }

        .rc-search-actions .btn:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        .rc-search-reset:hover {
            background: rgba(255, 255, 255, .10) !important;
        }

        .rc-search-trust {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 16px;
            color: rgba(255, 255, 255, .62);
            font-size: 11px;
        }

        .rc-search-trust svg {
            color: var(--rc-green);
        }

        .rc-benefits-bar {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin-top: 28px;
            padding: 18px 24px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 16px;
            background: rgba(6, 25, 45, .72);
            box-shadow: 0 18px 45px rgba(0, 0, 0, .18);
            backdrop-filter: blur(13px);
            -webkit-backdrop-filter: blur(13px);
            animation: rcBenefitsIn .9s .28s ease both;
        }

        .rc-benefit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 48px;
            padding: 0 16px;
            border-inline-end: 1px solid rgba(255, 255, 255, .13);
        }

        .rc-benefit:last-child {
            border-inline-end: 0;
        }

        .rc-benefit-icon {
            display: inline-flex;
            color: var(--rc-green);
        }

        .rc-benefit > span:last-child {
            display: flex;
            flex-direction: column;
        }

        .rc-benefit strong {
            text-align: right;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
        }

        .rc-benefit small {
            text-align: right;
            color: rgba(255, 255, 255, .57);
            font-size: 10px;
        }

        .rc-hero-slider .slick-arrow {
            width: 48px;
            height: 48px;
            z-index: 9;
            border: 1px solid rgba(255, 255, 255, .36);
            border-radius: 50%;
            background: rgba(4, 23, 43, .62);
            backdrop-filter: blur(9px);
            -webkit-backdrop-filter: blur(9px);
            transition: background .25s ease, border-color .25s ease, transform .25s ease;
        }

        .rc-hero-slider .slick-prev {
            left: 26px;
        }

        .rc-hero-slider .slick-next {
            right: 26px;
        }

        .rc-hero-slider .slick-arrow:hover {
            border-color: var(--rc-green);
            background: var(--rc-green);
            transform: translateY(-50%) scale(1.05);
        }

        .rc-hero-slider .slick-dots {
            bottom: 15px;
            z-index: 10;
        }

        .rc-hero-slider .slick-dots li {
            width: 10px;
            height: 10px;
            margin: 0 5px;
        }

        .rc-hero-slider .slick-dots li button {
            width: 10px;
            height: 10px;
            padding: 0;
        }

        .rc-hero-slider .slick-dots li button::before {
            width: 10px;
            height: 10px;
            color: transparent;
            border-radius: 10px;
            background: rgba(255, 255, 255, .75);
            opacity: 1;
            content: '';
            transition: width .25s ease, background .25s ease;
        }

        .rc-hero-slider .slick-dots li.slick-active,
        .rc-hero-slider .slick-dots li.slick-active button,
        .rc-hero-slider .slick-dots li.slick-active button::before {
            width: 28px;
        }

        .rc-hero-slider .slick-dots li.slick-active button::before {
            background: var(--rc-green);
        }

        @keyframes rcHeroZoom {
            from { transform: scale(1); }
            to { transform: scale(1.065); }
        }

        @keyframes rcHeroFloat {
            0%, 100% { transform: translate3d(0, 0, 0); }
            50% { transform: translate3d(0, -18px, 0); }
        }

        @keyframes rcHeroContentIn {
            from { opacity: 0; transform: translateY(28px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes rcSearchCardIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        [dir="ltr"] .rc-search-card {
            animation-name: rcSearchCardInLtr;
        }

        @keyframes rcSearchCardInLtr {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes rcBenefitsIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1199.98px) {
            .rc-hero-slider,
            .rc-hero-slider .slick-list,
            .rc-hero-slider .slick-track,
            .rc-hero-slide {
                min-height: 635px;
            }

            .rc-hero-slide {
                padding-top: 55px;
            }

            .rc-hero-content {
                padding-inline-start: 18px;
            }

            .rc-search-card {
                padding: 23px;
            }

            .rc-feature-item {
                padding: 0 9px;
                gap: 8px;
            }

            .rc-feature-icon {
                width: 40px;
                height: 40px;
                flex-basis: 40px;
            }
        }

        @media (max-width: 991.98px) {
            .rc-hero-slider,
            .rc-hero-slider .slick-list,
            .rc-hero-slider .slick-track,
            .rc-hero-slide {
                min-height: auto;
            }

            .rc-hero-slide {
                padding: 70px 0 62px;
            }

            .rc-hero-row {
                min-height: auto;
            }

            .rc-hero-content {
                max-width: 760px;
                margin: 0 auto 35px;
                padding: 0;
                text-align: center;
            }

            .rc-hero-badge,
            .rc-hero-actions {
                justify-content: center;
            }

            .rc-hero-description {
                margin-right: auto;
                margin-left: auto;
            }

            .rc-feature-item {
                justify-content: center;
                text-align: start;
            }

            .rc-search-card {
                max-width: 720px;
                margin: 0 auto;
            }

            .rc-benefits-bar {
                max-width: 720px;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0;
                margin-right: auto;
                margin-left: auto;
            }

            .rc-benefit:nth-child(2) {
                border-inline-end: 0;
            }

            .rc-benefit:nth-child(-n+2) {
                padding-bottom: 14px;
                margin-bottom: 14px;
                border-bottom: 1px solid rgba(255, 255, 255, .12);
            }

            .rc-hero-slider .slick-arrow {
                display: none !important;
            }
        }

        @media (max-width: 767.98px) {
            .rc-hero-slide {
                padding: 46px 0 55px;
                background-position: 62% center !important;
            }

            .rc-hero-overlay {
                background: linear-gradient(180deg, rgba(3, 18, 35, .75) 0%, rgba(3, 18, 35, .92) 45%, rgba(3, 18, 35, .97) 100%);
            }

            [dir="ltr"] .rc-hero-overlay {
                background: linear-gradient(180deg, rgba(3, 18, 35, .75) 0%, rgba(3, 18, 35, .92) 45%, rgba(3, 18, 35, .97) 100%);
            }

            .rc-hero-title {
                font-size: clamp(33px, 10vw, 47px);
                line-height: 1.28;
            }

            .rc-hero-subtitle {
                font-size: 18px;
            }

            .rc-hero-description {
                font-size: 14px;
                line-height: 1.8;
            }

            .rc-hero-features {
                grid-template-columns: 1fr;
                gap: 12px;
                padding: 16px 0;
            }

            .rc-feature-item,
            .rc-feature-item:first-child {
                justify-content: flex-start;
                max-width: 270px;
                margin: 0 auto;
                padding: 0;
                border-inline-end: 0;
            }

            .rc-feature-item strong,
            .rc-feature-item small {
                white-space: normal;
            }

            .rc-hero-actions {
                flex-direction: column;
                align-items: stretch;
                max-width: 420px;
                margin: 0 auto;
            }

            .rc-hero-actions .btn {
                width: 100%;
            }

            .rc-search-card {
                padding: 22px 17px;
                border-radius: 16px;
            }

            .rc-search-heading h2 {
                font-size: 19px;
            }

            .rc-search-grid > [class*="col-"] {
                width: 100%;
                flex: 0 0 100%;
                max-width: 100%;
            }

            .rc-search-actions {
                grid-template-columns: 1fr;
            }

            .rc-benefits-bar {
                grid-template-columns: 1fr;
                padding: 15px 18px;
            }

            .rc-benefit,
            .rc-benefit:nth-child(2),
            .rc-benefit:nth-child(-n+2) {
                justify-content: flex-start;
                padding: 12px 0;
                margin: 0;
                border-inline-end: 0;
                border-bottom: 1px solid rgba(255, 255, 255, .11);
            }

            .rc-benefit:last-child {
                border-bottom: 0;
            }

            .rc-hero-slider .slick-dots {
                bottom: 9px;
            }
        }

        @media (max-width: 420px) {
            .rc-hero-slide {
                padding-top: 36px;
            }

            .rc-hero-badge {
                font-size: 12px;
                padding: 8px 12px;
            }

            .rc-hero-title {
                font-size: 32px;
            }

            .rc-search-card .form-control {
                min-height: 51px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-hero-slide::before,
            .rc-hero-glow,
            .rc-hero-content,
            .rc-search-card,
            .rc-benefits-bar {
                animation: none !important;
            }
        }
    </style>
    <!-- ============================ Hero Banner End ================================== -->
    <!-- ============================ Featured Properties Start ================================== -->
    <section class="featured-properties" dir="ltr">
        <div class="featured-properties__decoration featured-properties__decoration--one" aria-hidden="true"></div>
        <div class="featured-properties__decoration featured-properties__decoration--two" aria-hidden="true"></div>

        <div class="container featured-properties__container">
            <header class="featured-properties__header">

                <a class="featured-properties__all-link"
                   href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_sale') }}">
                    <span>{{ App::isLocale('en') ? 'View all properties' : 'عرض كل العقارات' }}</span>
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                </a>


                <div>
                    <span class="featured-properties__eyebrow">
                        <i class="fas fa-star" aria-hidden="true"></i>
                        {{ App::isLocale('en') ? 'Hand-picked opportunities' : 'فرص مختارة بعناية' }}
                    </span>
                    <h2>{{ trans('langsite.Special_ads') }}</h2>
                    <p>
                        {{ App::isLocale('en')
                            ? 'Explore distinctive properties and contact owners directly without intermediaries.'
                            : 'اكتشف عقارات مميزة بتفاصيل واضحة وتواصل مباشرة مع المالك بدون وسيط.' }}
                    </p>
                </div>


            </header>

            <div class="property-slide featured-properties__slider">
                @forelse ($vipAqars as $aqarVip)
                    @php
                        $propertyUrl = URL::to(Config::get('app.locale').'/aqars/'.$aqarVip->slug);
                        $isExpired = \Carbon\Carbon::now()->diffInYears($aqarVip->created_at) >= 1;
                        $isForRent = in_array((int) $aqarVip->offer_type, [3, 4], true);
                        $price = $isForRent ? $aqarVip->monthly_rent : $aqarVip->total_price;
                        $isInstallment = !$isForRent && (
                            (float) $aqarVip->downpayment > 0
                            || (int) $aqarVip->installment_time > 0
                            || (float) $aqarVip->installment_value > 0
                        );

                        $offerLabel = optional($aqarVip->offerTypes)->type_offer
                            ?: ($isForRent ? 'إيجار' : 'بيع');
                        $categoryLabel = optional($aqarVip->categoryRel)->category_name;
                        $propertyTypeLabel = optional($aqarVip->propertyType)->property_type;

                        if ($aqarVip->mainImage) {
                            $propertyImage = URL::to('/').'/images/'.$aqarVip->mainImage->img_url;
                        } elseif ($aqarVip->firstImage) {
                            $propertyImage = URL::to('/').'/images/'.$aqarVip->firstImage->img_url;
                        } else {
                            $propertyImage = URL::to('/').'/images/FBO.png';
                        }
                    @endphp

                    <article class="single-items featured-property">
                        <div class="featured-property__card">
                            <a class="featured-property__media"
                               href="{{ $propertyUrl }}"
                               target="_blank"
                               rel="noopener"
                               aria-label="{{ $aqarVip->title }}">
                                <img src="{{ $propertyImage }}"
                                     alt="{{ $aqarVip->title }}"
                                     loading="lazy">

                                <span class="featured-property__image-overlay" aria-hidden="true"></span>

                                <div class="featured-property__top-badges">
                                    @if ($isExpired)
                                        <span class="featured-property__badge featured-property__badge--unavailable">
                                            {{ App::isLocale('en') ? 'Unavailable' : 'غير متاح' }}
                                        </span>
                                    @else
                                        <span class="featured-property__badge featured-property__badge--featured">
                                            <i class="fas fa-star" aria-hidden="true"></i>
                                            {{ App::isLocale('en') ? 'Featured' : 'مميز' }}
                                        </span>
                                    @endif

                                    <span class="featured-property__views">
                                        <i class="far fa-eye" aria-hidden="true"></i>
                                        {{ number_format((int) $aqarVip->views) }}
                                    </span>
                                </div>

                                <div class="featured-property__classification">
                                    <span class="featured-property__type featured-property__type--offer">
                                        {{ $offerLabel }}
                                    </span>

                                    @unless ($isForRent)
                                        <span class="featured-property__type featured-property__type--payment">
                                            {{ $isInstallment
                                                ? (App::isLocale('en') ? 'Installments' : 'تقسيط')
                                                : (App::isLocale('en') ? 'Cash' : 'كاش') }}
                                        </span>
                                    @endunless

                                    @if ($categoryLabel)
                                        <span class="featured-property__type">{{ $categoryLabel }}</span>
                                    @endif
                                </div>
                            </a>

                            <div class="featured-property__body">
                                @if ($propertyTypeLabel)
                                    <span class="featured-property__property-type">
                                        <i class="far fa-building" aria-hidden="true"></i>
                                        {{ $propertyTypeLabel }}
                                    </span>
                                @endif

                                <h3 class="featured-property__title">
                                    <a href="{{ $propertyUrl }}" target="_blank" rel="noopener">
                                        {{ $aqarVip->title }}
                                    </a>
                                </h3>

                                <div class="featured-property__location">
                                    <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                    <span>
                                        @if ($aqarVip->governrateq)
                                            {{ $aqarVip->governrateq->governrate }}
                                        @endif
                                        @if ($aqarVip->districte)
                                            <span class="featured-property__separator">،</span>
                                            {{ $aqarVip->districte->district }}
                                        @endif
                                    </span>
                                </div>

                                <div class="featured-property__price">
                                    <strong>{{ number_format((float) $price) }}</strong>
                                    <span>{{ trans('langsite.egyptian_pound') }}</span>
                                    @if ($isForRent)
                                        <small>/ {{ App::isLocale('en') ? 'month' : 'شهرياً' }}</small>
                                    @endif
                                </div>

                                <div class="featured-property__features">
                                    <div class="featured-property__feature">
                                        <img src="{{ asset('images/icons/area.png') }}" alt="" loading="lazy">
                                        <span>{{ $aqarVip->total_area ?: '—' }} م²</span>
                                    </div>
                                    <div class="featured-property__feature">
                                        <img src="{{ asset('images/icons/room.png') }}" alt="" loading="lazy">
                                        <span>{{ $aqarVip->rooms ?: '—' }} {{ App::isLocale('en') ? 'rooms' : 'غرف' }}</span>
                                    </div>
                                    <div class="featured-property__feature">
                                        <img src="{{ asset('images/icons/bath.png') }}" alt="" loading="lazy">
                                        <span>{{ $aqarVip->baths ?: '—' }} {{ App::isLocale('en') ? 'baths' : 'حمام' }}</span>
                                    </div>
                                </div>

                                <a class="featured-property__details"
                                   href="{{ $propertyUrl }}"
                                   target="_blank"
                                   rel="noopener">
                                    <span>{{ App::isLocale('en') ? 'Property details' : 'تفاصيل العقار' }}</span>
                                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="featured-properties__empty">
                        <i class="far fa-building" aria-hidden="true"></i>
                        <p>{{ App::isLocale('en') ? 'No featured properties are available now.' : 'لا توجد عقارات مميزة متاحة حالياً.' }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <style>
        .featured-properties {
            --featured-primary: #0f6ea8;
            --featured-primary-dark: #084d78;
            --featured-accent: #18b98b;
            --featured-ink: #10243e;
            --featured-muted: #6f7d8f;
            position: relative;
            padding: 22px 0;
            overflow: hidden;
            background:
                radial-gradient(circle at 10% 0%, rgba(24, 185, 139, .09), transparent 28%),
                linear-gradient(180deg, #f7fbfe 0%, #ffffff 100%);
        }

        .featured-properties__container {
            position: relative;
            z-index: 2;
        }

        .featured-properties__decoration {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(1px);
        }

        .featured-properties__decoration--one {
            width: 260px;
            height: 260px;
            top: -150px;
            inset-inline-end: -80px;
            background: rgba(15, 110, 168, .07);
        }

        .featured-properties__decoration--two {
            width: 180px;
            height: 180px;
            bottom: -100px;
            inset-inline-start: 3%;
            border: 36px solid rgba(24, 185, 139, .06);
        }

        .featured-properties__header {
            text-align: right;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 38px;
        }

        .featured-properties__header > div {
            max-width: 670px;
        }

        .featured-properties__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            color: var(--featured-primary);
            font-size: 13px;
            font-weight: 800;
        }

        .featured-properties__eyebrow i {
            color: #f6b914;
        }

        .featured-properties__header h2 {
            margin: 0 0 12px;
            color: var(--featured-ink);
            font-family: 'Cairo', sans-serif;
            font-size: clamp(30px, 3.2vw, 44px);
            font-weight: 800;
            line-height: 1.3;
        }

        .featured-properties__header p {
            margin: 0;
            color: var(--featured-muted);
            font-size: 15px;
            line-height: 1.9;
        }

        .featured-properties__all-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            flex: 0 0 auto;
            padding: 13px 20px;
            color: var(--featured-primary) !important;
            border: 1px solid rgba(15, 110, 168, .22);
            border-radius: 12px;
            background: #fff;
            font-weight: 800;
            box-shadow: 0 8px 25px rgba(16, 36, 62, .06);
            transition: color .25s ease, background .25s ease, transform .25s ease;
        }

        .featured-properties__all-link:hover {
            color: #fff !important;
            background: var(--featured-primary);
            transform: translateY(-2px);
        }

        /*
         * Slick is initialized globally without rtl: true.
         * Keep its track LTR so slides stay visible, then restore the
         * language direction inside each property card.
         */
        .featured-properties__slider,
        .featured-properties__slider .slick-list,
        .featured-properties__slider .slick-track {
            direction: ltr;
        }

        .featured-properties__slider {
            margin: 0 -10px;
        }

        .featured-property {
            padding: 10px;
        }

        .featured-property__card {
            direction: rtl;
            opacity: 1;
            height: 100%;
            overflow: hidden;
            border: 1px solid #e6edf3;
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 14px 40px rgba(16, 36, 62, .08);
            transition: border-color .35s ease, box-shadow .35s ease, transform .35s ease;
        }

        [dir="ltr"] .featured-property__card {
            direction: ltr;
        }

        .featured-property__card:hover {
            border-color: rgba(15, 110, 168, .28);
            box-shadow: 0 24px 55px rgba(16, 36, 62, .15);
            transform: translateY(-8px);
        }

        .featured-property__media {
            position: relative;
            display: block;
            height: 235px;
            overflow: hidden;
            background: #eaf0f5;
        }

        .featured-property__media > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .65s cubic-bezier(.2, .7, .2, 1);
        }

        .featured-property__card:hover .featured-property__media > img {
            transform: scale(1.075);
        }

        .featured-property__image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 23, 40, .08) 30%, rgba(5, 23, 40, .72) 100%);
        }

        .featured-property__top-badges,
        .featured-property__classification {
            position: absolute;
            inset-inline: 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .featured-property__top-badges {
            top: 14px;
        }

        .featured-property__classification {
            bottom: 14px;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .featured-property__badge,
        .featured-property__views,
        .featured-property__type {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 30px;
            padding: 5px 10px;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, .25);
            border-radius: 999px;
            background: rgba(7, 27, 47, .72);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            font-size: 11px;
            font-weight: 800;
        }

        .featured-property__badge--featured {
            background: linear-gradient(135deg, #f5bd22, #e59a00);
        }

        .featured-property__badge--unavailable {
            background: rgba(188, 43, 55, .9);
        }

        .featured-property__type--offer {
            background: var(--featured-primary);
        }

        .featured-property__type--payment {
            background: var(--featured-accent);
        }

        .featured-property__body {
            text-align: right;
            padding: 20px;
        }

        .featured-property__property-type {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            margin-bottom: 9px;
            color: var(--featured-primary);
            font-size: 12px;
            font-weight: 800;
        }

        .featured-property__title {
            height: 3.1em;
            overflow: hidden;
            margin: 0 0 8px;
            font-size: 19px;
            font-weight: 800;
            line-height: 1.55;
        }

        .featured-property__title a {
            display: -webkit-box;
            overflow: hidden;
            color: var(--featured-ink);
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            transition: color .2s ease;
        }

        .featured-property__title a:hover {
            color: var(--featured-primary);
        }

        .featured-property__location {
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 25px;
            margin-bottom: 15px;
            color: var(--featured-muted);
            font-size: 12px;
        }

        .featured-property__location i {
            color: var(--featured-accent);
        }

        .featured-property__price {
            display: flex;
            align-items: baseline;
            gap: 5px;
            margin-bottom: 17px;
            color: var(--featured-primary);
        }

        .featured-property__price strong {
            font-size: 25px;
            font-weight: 900;
            letter-spacing: -.4px;
        }

        .featured-property__price span {
            font-size: 12px;
            font-weight: 800;
        }

        .featured-property__price small {
            color: var(--featured-muted);
            font-size: 10px;
        }

        .featured-property__features {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
            padding: 14px 0;
            border-top: 1px solid #edf1f5;
            border-bottom: 1px solid #edf1f5;
        }

        .featured-property__feature {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 0;
            color: #526174;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .featured-property__feature + .featured-property__feature {
            border-inline-start: 1px solid #edf1f5;
        }

        .featured-property__feature img {
            width: 15px;
            height: 15px;
            object-fit: contain;
        }

        .featured-property__details {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 16px;
            padding: 12px 15px;
            color: #fff !important;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--featured-primary), var(--featured-primary-dark));
            font-size: 13px;
            font-weight: 800;
            transition: box-shadow .25s ease, transform .25s ease;
        }

        .featured-property__details:hover {
            box-shadow: 0 10px 24px rgba(15, 110, 168, .25);
            transform: translateY(-2px);
        }

        .featured-properties__empty {
            padding: 55px 20px;
            text-align: center;
            color: var(--featured-muted);
        }

        .featured-properties__empty i {
            display: block;
            margin-bottom: 12px;
            color: var(--featured-primary);
            font-size: 38px;
        }

        .featured-properties__slider .slick-arrow {
            width: 42px;
            height: 42px;
            z-index: 5;
            border: 0;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 8px 24px rgba(16, 36, 62, .16);
        }

        .featured-properties__slider .slick-prev { background: #196aa2; left: -12px; }
        .featured-properties__slider .slick-next { background: #196aa2; right: -12px; }

        @media (max-width: 767.98px) {
            .featured-properties {
                padding: 64px 0;
            }

            .featured-properties__header {
                display: block;
                margin-bottom: 25px;
                text-align: center;
            }

            .featured-properties__header p {
                font-size: 13px;
            }

            .featured-properties__all-link {
                margin-top: 18px;
            }

            .featured-property__media {
                height: 220px;
            }

            .featured-properties__slider .slick-arrow {
                display: none !important;
            }
        }

        @media (max-width: 420px) {
            .featured-property__body {
                padding: 17px;
            }

            .featured-property__features {
                gap: 4px;
            }

            .featured-property__feature {
                font-size: 10px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .featured-property__card,
            .featured-property__media > img {
                transition: none !important;
            }
        }
    </style>
    <!-- ============================ Featured Properties End ================================== -->


    <!-- ============================ Register CTA Section (Guest Only) ================================== -->
    @guest
        <section class="register-cta-section" dir="rtl">
            <div class="register-cta-overlay"></div>
            <div class="container position-relative" style="z-index:2;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 col-md-10 text-center">
                        <div class="register-cta-content">
{{--                            <div class="register-cta-icon-wrap animate-bounce-in">--}}
{{--                                <div class="register-cta-icon">--}}
{{--                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ffffff" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <h2 class="register-cta-title animate-fade-up">
                                سجّل الآن <span class="register-cta-highlight">مجاناً</span>
                            </h2>
                            <p class="register-cta-desc animate-fade-up-delay">
                                انضم إلى آلاف المستخدمين واستمتع بالبحث عن أفضل العقارات، إضافة إعلاناتك، وإدارة مفضلتك بكل سهولة
                            </p>
{{--                            <div class="register-cta-features animate-fade-up-delay2">--}}
{{--                                <div class="register-cta-feature">--}}
{{--                                    <div class="register-cta-feature-icon">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>--}}
{{--                                    </div>--}}
{{--                                    <span>إضافة إعلانات مجانية</span>--}}
{{--                                </div>--}}
{{--                                <div class="register-cta-feature">--}}
{{--                                    <div class="register-cta-feature-icon">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>--}}
{{--                                    </div>--}}
{{--                                    <span>حفظ العقارات المفضلة</span>--}}
{{--                                </div>--}}
{{--                                <div class="register-cta-feature">--}}
{{--                                    <div class="register-cta-feature-icon">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>--}}
{{--                                    </div>--}}
{{--                                    <span>تواصل مباشر مع المُعلنين</span>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <a href="{{ URL::to(Config::get('app.locale').'/register') }}{{ session('invited_by') ? '?invited_by=' . urlencode(session('invited_by')) : '' }}" class="register-cta-btn animate-fade-up-delay3">
                                <span>سجّل الآن مجاناً</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" style="margin-right:8px;"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative shapes -->
            <div class="register-cta-shape register-cta-shape-1"></div>
            <div class="register-cta-shape register-cta-shape-2"></div>
        </section>


    @else
        <section class="register-cta-section" dir="rtl">
            <div class="register-cta-overlay"></div>
            <div class="container position-relative" style="z-index:2;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 col-md-10 text-center">
                        <div class="register-cta-content">
                            <div class="register-cta-icon-wrap animate-bounce-in">
                                <div class="register-cta-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ffffff" viewBox="0 0 24 24">
                                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="register-cta-title animate-fade-up">
                                أضف عقارك الآن وابدأ
                                <span class="register-cta-highlight">
                                       <br>
                                استقبال العروض فوراً
                                </span>
                            </h2>
                            <p class="register-cta-desc animate-fade-up-delay">
                                حوّل عقارك إلى فرصة استثمارية اليوم
                                <br>
                                أنشئ إعلانك بخطوات بسيطة ودع العملاء يصلون إليك مباشرة.    </p>
                            <div class="register-cta-features animate-fade-up-delay2">
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>إضافة إعلانات مجانية</span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>
                                    تحكم كامل في تفاصيل إعلانك
                                    </span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>تواصل مباشر مع المُعلنين</span>
                                </div>
                            </div>
                            <a href="{{ URL::to(Config::get('app.locale').'/aqars/create') }}" class="register-cta-btn animate-fade-up-delay3">
                                <span> جرّب إضافة عقارك   مجاناً</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" style="margin-right:8px;">
                                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative shapes -->
            <div class="register-cta-shape register-cta-shape-1"></div>
            <div class="register-cta-shape register-cta-shape-2"></div>
        </section>


    @endguest
    <style>
        /* ===== Register CTA Section ===== */
        .register-cta-section {
            position: relative;
            padding: 30px 0;
            background: linear-gradient(135deg, #196aa2 0%, #0d4a73 50%, #196aa2 100%);
            background-size: 200% 200%;
            animation: registerGradientShift 8s ease infinite;
            overflow: hidden;
        }
        @keyframes registerGradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .register-cta-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }
        /* Decorative floating shapes */
        .register-cta-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 1;
        }
        .register-cta-shape-1 {
            width: 300px; height: 300px;
            background: #ffffff;
            top: -80px; left: -80px;
            animation: registerFloat 6s ease-in-out infinite;
        }
        .register-cta-shape-2 {
            width: 200px; height: 200px;
            background: #ffffff;
            bottom: -60px; right: -40px;
            animation: registerFloat 8s ease-in-out infinite reverse;
        }
        @keyframes registerFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        /* Content */
        .register-cta-content {
            position: relative;
            z-index: 2;
        }
        /* Icon */
        .register-cta-icon-wrap {
            margin-bottom: 24px;
        }
        .register-cta-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            margin: 0 auto;
        }
        /* Title */
        .register-cta-title {
            font-family: 'Cairo', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .register-cta-highlight {
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        /* Description */
        .register-cta-desc {
            font-family: 'Cairo', sans-serif;
            font-size: 1.15rem;
            color: rgba(255,255,255,0.85);
            max-width: 600px;
            margin: 0 auto 32px;
            line-height: 1.8;
        }
        /* Features */
        .register-cta-features {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }
        .register-cta-feature {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .register-cta-feature:hover {
            background: rgba(255,255,255,0.22);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .register-cta-feature span {
            font-family: 'Cairo', sans-serif;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .register-cta-feature-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px; height: 30px;
            border-radius: 50%;
            background: #ffffff;
            flex-shrink: 0;
        }
        /* Button */
        .register-cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 48px;
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            color: #0d4a73 !important;
            font-family: 'Cairo', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            border-radius: 50px;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 30px rgba(255,215,0,0.3);
            position: relative;
            overflow: hidden;
        }
        .register-cta-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; right: 0; bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s ease;
        }
        .register-cta-btn:hover::before {
            left: 100%;
        }
        .register-cta-btn:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 14px 40px rgba(255,215,0,0.45);
            color: #0d4a73 !important;
            text-decoration: none !important;
        }
        /* Animations */
        .animate-bounce-in {
            animation: registerBounceIn 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) both;
        }
        @keyframes registerBounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-fade-up {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.3s;
        }
        .animate-fade-up-delay {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.5s;
        }
        .animate-fade-up-delay2 {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.7s;
        }
        .animate-fade-up-delay3 {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.9s;
        }
        @keyframes registerFadeUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Responsive */
        @media (max-width: 768px) {
            .register-cta-section { padding: 50px 0; }
            .register-cta-title { font-size: 1.8rem; }
            .register-cta-desc { font-size: 1rem; }
            .register-cta-features { gap: 12px; }
            .register-cta-feature { padding: 8px 14px; }
            .register-cta-feature span { font-size: 0.85rem; }
            .register-cta-btn { padding: 14px 36px; font-size: 1.05rem; }
            .register-cta-icon { width: 70px; height: 70px; }
            .register-cta-icon svg { width: 36px; height: 36px; }
            .register-cta-shape-1 { width: 180px; height: 180px; }
            .register-cta-shape-2 { width: 120px; height: 120px; }
        }
        @media (max-width: 480px) {
            .register-cta-title { font-size: 1.5rem; }
            .register-cta-features { flex-direction: column; align-items: center; }
        }
    </style>

    <!-- ============================ Register CTA Section End ================================== -->

    <!-- ============================ All Property ================================== -->
    <section class="bg-light">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2 class="headingTitle">	{{ trans('langsite.Properties_for_sale')}} </h2>

                    </div>
                </div>
            </div>


            <div class="row list-layout">
                @foreach ($saleAqars as $saleAqar)

                    <!-- Single Property Start -->

                    <div class="col-lg-6 col-md-12">

                        <div class="property-listing property-1">

                            <div class="listing-img-wrapper">
                                <!-- <a target="_blank" href="single-property-2.html"> -->

                                <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}">
                                    @if($saleAqar->mainImage)
                                        <img src="{{ URL::to('/').'/images/'.$saleAqar->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                    @else

                                        @if($saleAqar->firstImage)<img
                                            src="{{ URL::to('/').'/images/'.$saleAqar->firstImage->img_url}}"
                                            class="img-fluid mx-auto" alt="" loading="lazy" />
                                        @else
                                            <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                                 alt="main" loading="lazy" >
                                        @endif
                                    @endif

                                </a>



                                    <?php  if($saleAqar->vip ==1 && \Carbon\Carbon::now()->diffInYears($saleAqar->created_at) < 1 ){   ?>
                                <div class="views"  >
                                    <div class="views-1">مميز</div>
                                </div>
                                <?php }  ?>


                                    <?php if(\Carbon\Carbon::now()->diffInYears($saleAqar->created_at) >= 1){ ?>
                                <div class="views " style="left: 13px;">
                                    <div class="viewsRed">غير متاح</div>
                                </div>
                                <?php } ?>


                                <div class="views">

                                    <div class="views-2">
                                        <i class="fa fa-eye"></i>
                                        <span>{{ $saleAqar->views }}</span>

                                    </div>
                                </div>
                            </div>



                            <div class="listing-content">



                                <div class="listing-detail-wrapper-box">

                                    <div class="listing-detail-wrapper">

                                        <div class="listing-short-detail">

                                            <h4 class="listing-name">
                                                <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}">
                                                    {{  \Illuminate\Support\Str::limit($saleAqar->title, $limit = 33, $end = '...') }}
                                                </a>
                                            </h4>



                                        </div>



                                    </div>

                                </div>
                                <div class="list-price">

                                    <h6  class="">{{ $saleAqar->total_price }} جنيه مصري </h6>

                                </div>


                                <div class="price-features-wrapper" >

                                    <div class="list-fx-features feat2">

                                        <div class="listing-card-info-icon">

                                            {{ $saleAqar->baths }} حمام
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"

                                                                             alt="" loading="lazy" /></div>
                                        </div>

                                        <div class="listing-card-info-icon">

                                            {{ $saleAqar->rooms }} غرف
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"

                                                                             alt="" loading="lazy" /></div>

                                        </div>

                                        <div class="listing-card-info-icon">

                                            {{ $saleAqar->total_area }}  م²
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"

                                                                             alt="" loading="lazy" /></div>

                                        </div>

                                    </div>

                                </div>



                                <div class="listing-footer-wrapper bg-light">

                                    <div class="listing-locate">

                <span class="listing-location"> @if ($saleAqar->governrateq)
                        {{ $saleAqar->governrateq->governrate }}
                    @endif @if ($saleAqar->districte)
                        {{ $saleAqar->districte->district }}
                    @endif
 <i class="ti-location-pin"></i></span>

                                    </div>

                                    <div class="footer-flex">

                                        <a target="_blank" target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}" class="prt-view">عرض</a>

                                        <!-- <a target="_blank" href="single-property-2.html" class="more-btn">View</a> -->

                                    </div>

                                </div>



                            </div>



                        </div>

                    </div>


                @endforeach



            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_sale') }}" class="btn btn-theme-light rounded">اعرض المزيد</a>
                    <!-- <a target="_blank" href="listings-list-with-sidebar.html" class="btrn btn-theme-light rounded">Browse More Properties</a> -->
                </div>
            </div>

        </div>
    </section>
    <!-- ============================ All Featured Property ================================== -->
    <!-- ============================ Free Plan CTA ================================== -->
{{--    <x-free-plan-cta />--}}
    <!-- ============================ Free Plan CTA End ================================== -->

    <!-- ============================ Latest Property للبيع Start ================================== -->
    <section class="" dir="ltr">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle"> 	{{ trans('langsite.Real_estate_for_rent')}} </h2>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">
                        @foreach ($rentAqars as $rentAqar)
                            <div class="single-items">
                                <div class="property-listing shadow-none property-2 border">

                                    <div class="listing-img-wrapper">

                                        <div class="list-img-slide">
                                            <div class="click">

                                                <div><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}">

                                                        @if($rentAqar->mainImage)
                                                            <img src="{{ URL::to('/').'/images/'.$rentAqar->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                                        @else

                                                            @if($rentAqar->firstImage)<img
                                                                src="{{ URL::to('/').'/images/'.$rentAqar->firstImage->img_url}}"
                                                                class="img-fluid mx-auto" alt="" loading="lazy" />
                                                            @else
                                                                <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                                                     alt="main"loading="lazy" >
                                                            @endif
                                                        @endif

                                                    </a></div>



                                            </div>
                                        </div>


                                            <?php  if($rentAqar->vip ==1  && \Carbon\Carbon::now()->diffInYears($rentAqar->created_at) < 1){   ?>
                                        <div class="views">
                                            <div class="views-1">مميز</div>
                                        </div>

                                        <?php }  ?>


                                            <?php if(\Carbon\Carbon::now()->diffInYears($rentAqar->created_at) >= 1){ ?>
                                        <div class="views " style="left: 13px;">
                                            <div class="viewsRed">غير متاح</div>
                                        </div>
                                        <?php } ?>



                                        <div class="views">

                                            <div class="views-2">
                                                <i class="fa fa-eye"></i>
                                                <span>{{ $rentAqar->views }}</span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="listing-detail-wrapper">
                                        <div class="listing-short-detail-wrap">
                                            <div class="listing-short-detail">
                                                <h4 class="listing-name verified center-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}"
                                                                                                 class="">{{ \Illuminate\Support\Str::limit($rentAqar->title, $limit = 29, $end = '...')  }}</a></h4>
                                                <!-- <h4 class="listing-name verified"><a target="_blank" href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
                                            </div>

                                        </div>

                                    </div>
                                    <div  class="listing-short-detail-flex">
                                        <h6 class="listing-card-info-price">{{ $rentAqar->monthly_rent }} جنيه مصري</h6>
                                    </div>
                                    <div class="price-features-wrapper" >
                                        <div class="list-fx-features" >





                                            <div class="listing-card-info-icon">
                                                {{ $rentAqar->baths }} حمام
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>
                                            <div class="listing-card-info-icon">
                                                {{ $rentAqar->rooms }} غرف
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>

                                            <div class="listing-card-info-icon">
                                                {{ $rentAqar->total_area }} م²
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="listing-detail-footer bg-light">
                                        <div class="footer-first">
                                            <div class="foot-location">
                                                @if ($rentAqar->governrateq)
                                                    {{ $rentAqar->governrateq->governrate }}
                                                @endif
                                                @if ($rentAqar->districte)
                                                    {{ $rentAqar->districte->district }}
                                                @endif


                                                <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt=""  loading="lazy" />
                                            </div>
                                        </div>
                                        <div class="footer-flex">
                                            <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}" class="prt-view">عرض</a>
                                            <!-- <a target="_blank" href="property-detail.html" class="prt-view">View</a> -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                    <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_rent') }}" class="btn btn-theme-light rounded">اعرض المزيد</a>
                    <!-- <a target="_blank" href="listings-list-with-sidebar.html" class="btrn btn-theme-light rounded">Browse More Properties</a> -->
                </div>
            </div>
        </div>
    </section>
    <!-- ============================ Latest Property للبيع End ================================== -->

    <!-- ============================ Price Table Start ================================== -->

    <!-- ============================ Step How To Use Start ================================== -->
{{--    <section class="ggok">--}}

{{--        <div class="container">--}}

{{--            <!-- row Start -->--}}
{{--            <div class="row align-items-center videoAction">--}}

{{--                <div class="col-lg-7 col-md-9">--}}

{{--                    <x-i-video />--}}
{{--                </div>--}}

{{--                <div class="col-lg-5 col-md-3">--}}
{{--                    <div class="story-wrap explore-content text-center">--}}
{{--                        <h2 class="headingTitle2"> 	Right choice  </h2>--}}
{{--                        <h2 class="headingTitle2"> 	{{ trans('langsite.site_name')}}  </h2>--}}
{{--                        <p class="">--}}

{{--                            نضع العقارات التي تريدها بين يديك بدون وسيط ومن<br/>  المالك مباشرة--}}
{{--                            <br/>--}}
{{--                            اختار عقارك بنفسك بدون وسطاء--}}
{{--                        </p>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <!-- /row -->--}}

{{--        </div>--}}

{{--    </section>--}}

    <!-- sections-->
    <section class="bg-light">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center">
                        <h2 class="headingTitle">{{ trans('langsite.services')}}</h2>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">

                        @foreach ($services as $serv )


                            <div class="single-items">
                                <div class="location-property-wrap">
                                    <div class="location-property-thumb">
                                        <!-- <a target="_blank" href="listings-list-with-sidebar.html"><img src="https://via.placeholder.com/1200x800" class="img-fluid" alt=""></a> -->
                                        <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug) }}"><img src="{{ URL::to('/').'/'.$serv->image}}" class="img-fluid" alt="" loading="lazy" ></a>
                                    </div>
                                    <div class="location-property-content">
                                        <div class="lp-content-flex">
                                            <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug) }}" class="lp-property-view">	<h4 class="lp-content-title">{{ $serv->Service}}</h4></a>
                                            <!--<span>العنوان</span>-->
                                        </div>
                                        <div class="lp-content-right">
                                            <!-- <a target="_blank" href="listings-list-with-sidebar.html" class="lp-property-view"><i class="ti-angle-right"></i></a> -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>


            </div>



        </div>
    </section>
    <!-- ============================ Latest Property للبيع Start ================================== -->
    <section class="" dir="ltr">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle"> 	{{ trans('langsite.The_most_researched')}}  </h2>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">



                        @foreach ($mostRecent as $most )
                            <div class="single-items">
                                <div class="property-listing shadow-none property-2 border">

                                    <div class="listing-img-wrapper">

                                        <div class="list-img-slide">
                                            <div class="click">

                                                <div><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}">

                                                        @if($most->mainImage)
                                                            <img src="{{ URL::to('/').'/images/'.$most->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                                        @else


                                                            @if($most->firstImage)
                                                                <img
                                                                    src="{{ URL::to('/').'/images/'.$most->firstImage->img_url}}"
                                                                    class="img-fluid mx-auto" alt="" loading="lazy" />
                                                            @else
                                                                <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                                                     alt="main" loading="lazy" >

                                                            @endif		@endif

                                                    </a></div>


                                            </div>
                                        </div>
                                        <div class="views">

                                            <div class="views-2">
                                                <i class="fa fa-eye"></i>
                                                <span>{{ $most->views }}</span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="listing-detail-wrapper">
                                        <div class="listing-short-detail-wrap">
                                            <div class="listing-short-detail">
                                                <h4 class="listing-name verified center-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}"
                                                                                                 class="">{{  \Illuminate\Support\Str::limit($most->title, $limit = 29, $end = '...') }}</a></h4>
                                                <!-- <h4 class="listing-name verified"><a target="_blank" href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
                                            </div>

                                        </div>

                                    </div>
                                    <div class="listing-short-detail-flex">
                                        <h6 class="listing-card-info-price">


                                            @if ($most->offerTypes->id == 1 || $most->offerTypes->id == 2 )
                                                {{ $most->total_price }}
                                            @endif
                                            @if ($most->offerTypes->id == 3 || $most->offerTypes->id == 4 )
                                                {{ $most->monthly_rent }}
                                            @endif  جنيه مصري



                                        </h6>
                                    </div>
                                    <div class="price-features-wrapper" >
                                        <div class="list-fx-features" >





                                            <div class="listing-card-info-icon">
                                                {{ $most->baths }} حمام
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>
                                            <div class="listing-card-info-icon">
                                                {{ $most->rooms }} غرف
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>

                                            <div class="listing-card-info-icon">
                                                {{ $most->total_area }}  م²
                                                <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
                                                                                 alt="" loading="lazy" /></div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="listing-detail-footer bg-light">
                                        <div class="footer-first">
                                            <div class="foot-location">
                                                @if ($most->governrateq)
                                                    {{ $most->governrateq->governrate }}
                                                @endif
                                                @if ($most->districte)
                                                    {{ $most->districte->district }}
                                                @endif


                                                <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy" />
                                            </div>
                                        </div>
                                        <div class="footer-flex">
                                            <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}" class="prt-view">عرض</a>
                                            <!-- <a target="_blank" href="property-detail.html" class="prt-view">View</a> -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- ============================ Latest Property للبيع End ================================== -->


    <!-- ============================ Call To Action ================================== -->
{{--    <x-call-to-action />--}}

    <!-- ============================ Call To Action End ================================== -->

</x-layout>
