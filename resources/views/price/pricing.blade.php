<x-layout>

    @section('title')
        اختر إحدى الباقات
    @endsection

    @php
        $isCompanyAccount = auth()->check() && auth()->user()->isCompanyAccount();
    @endphp

    <div class="rc-pricing-page" dir="rtl">

        {{-- Hero --}}
        <section class="rc-pricing-hero">
            <div class="rc-pricing-hero__overlay"></div>
            <div class="container position-relative">
                <div class="rc-pricing-hero__content">
                    <span class="rc-eyebrow">Right Choice</span>
                    <h1>{{ trans('langsite.Packages') }}</h1>
                    <p>
                        اختر الباقة المناسبة وابدأ الوصول إلى أفضل الفرص العقارية والتواصل
                        المباشر مع الملاك بدون وسطاء أو عمولات.
                    </p>

                    <div class="rc-hero-points">
                    <span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        تعامل مباشر
                    </span>
                        <span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        بدون عمولات
                    </span>
                        <span>
                        <svg viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>
                        خيارات مرنة
                    </span>
                    </div>
                </div>
            </div>
        </section>

        {{-- Benefits --}}
        <section class="rc-section rc-benefits-section">
            <div class="container">
                <div class="rc-section-heading">
                    <span>لماذا تشترك؟</span>
                    <h2>مزايا تمنحك تجربة بحث عقاري أسهل</h2>
                    <p>كل ما تحتاجه للوصول إلى العقار المناسب بصورة أسرع وأكثر وضوحًا.</p>
                </div>

                <div class="row rc-benefits-grid">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="rc-benefit-card">
                            <div class="rc-benefit-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12 2v20M17 5.5c-.8-1-2.2-1.5-4-1.5-2.5 0-4 1.2-4 3s1.2 2.5 4 3c2.8.5 4 1.2 4 3s-1.5 3-4 3c-1.8 0-3.4-.6-4.5-1.8"/>
                                </svg>
                            </div>
                            <div>
                                <h3>توفير المال</h3>
                                <p>تواصل مباشر مع الملاك الأصليين بدون وسطاء وبدون عمولات إضافية.</p>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="rc-benefit-card">
                            <div class="rc-benefit-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M3 11.5 12 4l9 7.5M5 10v10h14V10M9 20v-6h6v6"/>
                                </svg>
                            </div>
                            <div>
                                <h3>عروض متنوعة</h3>
                                <p>شقق، فلل، أراضٍ، عقارات تجارية وإدارية بمساحات وأسعار مختلفة.</p>
                            </div>
                        </article>
                    </div>

                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="rc-benefit-card">
                            <div class="rc-benefit-icon">
                                <svg viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v5l3 2"/>
                                </svg>
                            </div>
                            <div>
                                <h3>توفير الوقت</h3>
                                <p>بحث واختيار أكثر سهولة للوصول إلى العقار المناسب في وقت أقل.</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        {{-- Plans --}}
        <section id="pricing" class="rc-section rc-plans-section">
            <div class="container">
                <div class="rc-section-heading rc-section-heading--light">
                    <span>خطط الاشتراك</span>
                    <h2>اختر الباقة الأنسب لاحتياجاتك</h2>
                    <p>ابدأ بالباقة المجانية أو اختر إحدى الباقات المدفوعة للحصول على نقاط إضافية.</p>
                </div>

                <div class="row rc-pricing-grid justify-content-center">
                    @foreach ($allPricing as $single)
                        @php $isFree = ((float) $single->price === 0.0); @endphp

                        <div class="col-xl-4 col-lg-4 col-md-6 mb-5 d-flex {{ $isFree ? 'rc-free-plan-column' : '' }}">
                            <article class="rc-plan-card {{ $isFree ? 'rc-plan-card--free' : '' }}">

                                @if($isFree)
                                    <div class="rc-free-badge">
                                        <span class="rc-free-badge__dot"></span>
                                        الباقة المجانية
                                    </div>

                                    <div class="rc-most-popular">
                                        الأكثر اختيارًا
                                    </div>
                                @endif

                                <div class="rc-plan-card__header">
                                    <div class="rc-plan-icon {{ $isFree ? 'rc-plan-icon--free' : '' }}">
                                        @if($isFree)
                                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M20 12v9H4v-9M2 7h20v5H2zM12 7v14M12 7H7.5A2.5 2.5 0 1 1 10 4.5C10 6 12 7 12 7Zm0 0h4.5A2.5 2.5 0 1 0 14 4.5C14 6 12 7 12 7Z"/>
                                            </svg>
                                        @else
                                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="m12 2 3 6 6.5 1-4.7 4.6 1.1 6.4-5.9-3.1L6.1 20l1.1-6.4L2.5 9 9 8z"/>
                                            </svg>
                                        @endif
                                    </div>

                                    <h3>{!! $single->type !!}</h3>

                                    <div class="rc-price">
                                        @if($isFree)
                                            <strong>مجانًا</strong>
                                            <span>0 ج.م</span>
                                        @else
                                            <strong>{{ $single->price }}</strong>
                                            <span>ج.م</span>
                                        @endif
                                    </div>

                                    <p class="rc-plan-summary">{{ $single->desc1 }}</p>
                                </div>

                                <div class="rc-plan-card__body">
                                    @if($isFree)
                                        <div class="rc-free-message">
                                            ابدأ الآن واستكشف المنصة بدون أي تكلفة أو بطاقة ائتمان.
                                        </div>

                                        <ul class="rc-plan-features">
                                            <li>
                                            <span class="rc-check">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                            </span>
                                                200 نقطة مجانية فور التسجيل
                                            </li>
                                            <li>
                                            <span class="rc-check">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                            </span>
                                                تواصل مباشر مع الملاك
                                            </li>
                                            <li>
                                            <span class="rc-check">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
                                            </span>
                                                بدون بطاقة ائتمان
                                            </li>
                                        </ul>
                                    @else
                                        <div class="rc-standard-message">
                                            اضغط على تفاصيل الباقة للتعرف على جميع المميزات والنقاط المتاحة.
                                        </div>
                                    @endif
                                </div>

                                <div class="rc-plan-card__footer">
                                    <button
                                        type="button"
                                        class="rc-btn rc-btn--details"
                                        data-toggle="modal"
                                        data-target="#myModal{{ $single->id }}"
                                    >
                                        تفاصيل الباقة
                                        <svg viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M9 18 15 12 9 6"/>
                                        </svg>
                                    </button>

                                    @if($isCompanyAccount)
                                        <button type="button" class="rc-btn rc-btn--disabled" disabled>
                                            غير متاح لحسابات الشركات
                                        </button>
                                    @else
                                        <a
                                            href="{{ URL::to(Config::get('app.locale').'/pricing-seller/' . $single->id) }}"
                                            class="rc-btn {{ $isFree ? 'rc-btn--free' : 'rc-btn--primary' }}"
                                        >
                                            {{ $isFree ? 'ابدأ مجانًا الآن' : 'اشترك بالباقة' }}
                                            <svg viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M5 12h14M13 6l6 6-6 6"/>
                                            </svg>
                                        </a>
                                    @endif

                                    @if($isFree)
                                        <small class="rc-free-note">لا توجد رسوم مخفية</small>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Subscription information --}}
        <section class="rc-section rc-how-section">
            <div class="container">
                <div class="rc-info-panel">
                    <div class="rc-section-heading rc-section-heading--inside">
                        <span>معلومات مهمة</span>
                        <h2>كيفية الاشتراك والاستفادة من النقاط</h2>
                        <p>تعرف على آلية استخدام الباقات والنقاط داخل منصة Right Choice.</p>
                    </div>

                    <div class="rc-steps">
                        <article class="rc-step">
                            <span class="rc-step-number">01</span>
                            <div>
                                <h3>تحويل قيمة الاشتراك إلى نقاط</h3>
                                <p>
                                    جميع المبالغ المدفوعة إلى موقع Right Choice يتم تحويلها إلى نقاط تضاف إلى
                                    حساب المستخدم، ويمكن استخدامها لفتح بيانات الوحدات والتواصل مع الملاك مباشرة.
                                </p>
                            </div>
                        </article>

                        <article class="rc-step">
                            <span class="rc-step-number">02</span>
                            <div>
                                <h3>اختيار الباقة المناسبة</h3>
                                <p>
                                    بعد انتهاء نقاط الباقة المجانية، يمكن للمستخدم اختيار إحدى الباقات المدفوعة
                                    وسداد قيمتها إلكترونيًا، ثم تضاف نقاط الباقة إلى رصيد حسابه.
                                </p>
                            </div>
                        </article>

                        <article class="rc-step">
                            <span class="rc-step-number">03</span>
                            <div>
                                <h3>التعويض عن البيانات غير الصحيحة</h3>
                                <p>
                                    عند اكتشاف أن المعلن وسيط عقاري أو أن العقار لم يعد متاحًا، يجب إرسال بلاغ
                                    من صفحة الإعلان. يتم فحص الشكوى خلال مدة أقصاها 48 ساعة وتعويض المستخدم
                                    وفقًا للحالة وسياسة الموقع.
                                </p>
                            </div>
                        </article>

                        <article class="rc-step rc-step--warning">
                            <span class="rc-step-number">04</span>
                            <div>
                                <h3>مسؤولية المستندات والعقود</h3>
                                <p>
                                    موقع Right Choice وإدارة الشركة غير مسؤولين عن مستندات العقارات أو العقود،
                                    ولا يتدخلان كوسيط في عمليات البيع أو الشراء أو الإيجار. تقع مسؤولية التحقق
                                    من المستندات والاتفاقات على أطراف المعاملة.
                                </p>
                            </div>
                        </article>
                    </div>

                    <div class="rc-compensation-box">
                        <div class="rc-compensation-box__icon">!</div>
                        <div>
                            <h3>حالات استرجاع أو تعويض النقاط</h3>
                            <p>
                                إذا كان المعلن وسيطًا أو سمسارًا، يمكن تعويض المستخدم بضعف النقاط بعد التحقق
                                من البلاغ. وإذا كان العقار قد تم بيعه أو تأجيره أو لم يعد متاحًا، يمكن استرجاع
                                النقاط بشرط إرسال الشكوى خلال خمسة أيام من تاريخ فتح البيانات.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Modals --}}
        @foreach ($allPricing as $single)
            @php $isFree = ((float) $single->price === 0.0); @endphp

            <div class="modal fade rc-plan-modal" id="myModal{{ $single->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div>
                                <span class="rc-modal-eyebrow">{{ $isFree ? 'الباقة المجانية' : 'تفاصيل الباقة' }}</span>
                                <h4 class="modal-title">{!! $single->type !!}</h4>
                            </div>

                            <button type="button" class="rc-modal-close" data-dismiss="modal" aria-label="إغلاق">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="rc-modal-price {{ $isFree ? 'rc-modal-price--free' : '' }}">
                                @if($isFree)
                                    <strong>مجانًا</strong>
                                    <span>0 ج.م</span>
                                @else
                                    <strong>{{ $single->price }}</strong>
                                    <span>ج.م</span>
                                @endif
                            </div>

                            <div class="rc-modal-description">
                                {!! $single->desc3 !!}
                            </div>

                            @if(!empty($single->desc2))
                                <div class="rc-modal-extra">
                                    {!! $single->desc2 !!}
                                </div>
                            @endif
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="rc-btn rc-btn--modal-close" data-dismiss="modal">
                                إغلاق
                            </button>

                            @if($isCompanyAccount)
                                <button type="button" class="rc-btn rc-btn--disabled" disabled>
                                    غير متاح لحسابات الشركات
                                </button>
                            @else
                                <a
                                    href="{{ URL::to(Config::get('app.locale').'/pricing-seller/' . $single->id) }}"
                                    class="rc-btn {{ $isFree ? 'rc-btn--free' : 'rc-btn--primary' }}"
                                >
                                    {{ $isFree ? 'ابدأ مجانًا الآن' : 'اشترك بالباقة' }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        :root {
            --rc-navy: #123b63;
            --rc-navy-dark: #0a2948;
            --rc-blue: #168bc3;
            --rc-sky: #38bdf8;
            --rc-red: #e53945;
            --rc-red-dark: #c71f2c;
            --rc-white: #ffffff;
            --rc-bg: #f4f8fc;
            --rc-text: #18324a;
            --rc-muted: #64748b;
            --rc-border: #dce7f1;
            --rc-success: #0f9f6e;
            --rc-free-a: #0f766e;
            --rc-free-b: #14b8a6;
            --rc-free-soft: #ecfdf8;
            --rc-shadow: 0 18px 45px rgba(18, 59, 99, 0.10);
            --rc-shadow-lg: 0 28px 70px rgba(10, 41, 72, 0.18);
        }

        .rc-pricing-page {
            background: var(--rc-bg);
            color: var(--rc-text);
            overflow: hidden;
            text-align: right;
        }

        .rc-pricing-page *,
        .rc-pricing-page *::before,
        .rc-pricing-page *::after {
            box-sizing: border-box;
        }

        .rc-section {
            padding: 88px 0;
        }

        .rc-pricing-hero {
            position: relative;
            min-height: 490px;
            display: flex;
            align-items: center;
            background:
                linear-gradient(90deg, rgba(10, 41, 72, .15), rgba(10, 41, 72, .45)),
                url('https://rightchoice-co.com/public/assets/img/sliders/pricing.jpg') center/cover no-repeat;
            isolation: isolate;
        }

        .rc-pricing-hero::before,
        .rc-pricing-hero::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            filter: blur(2px);
            pointer-events: none;
            z-index: -1;
        }

        .rc-pricing-hero::before {
            width: 360px;
            height: 360px;
            top: -160px;
            right: -100px;
            background: rgba(56, 189, 248, .18);
        }

        .rc-pricing-hero::after {
            width: 300px;
            height: 300px;
            bottom: -170px;
            left: -100px;
            background: rgba(229, 57, 69, .14);
        }

        .rc-pricing-hero__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(10, 41, 72, .48), rgba(10, 41, 72, .92));
            z-index: -2;
        }

        .rc-pricing-hero__content {
            width: min(680px, 100%);
            color: var(--rc-white);
            padding: 70px 0;
        }

        .rc-eyebrow,
        .rc-section-heading > span,
        .rc-modal-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--rc-red);
            font-size: .82rem;
            font-weight: 900;
            letter-spacing: .4px;
            margin-bottom: 12px;
        }

        .rc-eyebrow {
            color: #ff9ca4;
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .18);
            padding: 8px 15px;
            border-radius: 999px;
        }

        .rc-pricing-hero h1 {
            margin: 0 0 20px;
            font-size: clamp(2.5rem, 5vw, 4.5rem);
            line-height: 1.1;
            font-weight: 900;
            text-shadow: 0 10px 30px rgba(0, 0, 0, .16);
        }

        .rc-pricing-hero p {
            margin: 0;
            max-width: 640px;
            color: rgba(255, 255, 255, .84);
            font-size: 1.12rem;
            line-height: 2;
        }

        .rc-hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .rc-hero-points span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 12px;
            background: rgba(255, 255, 255, .08);
            font-weight: 700;
            font-size: .9rem;
            backdrop-filter: blur(6px);
        }

        .rc-hero-points svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #65d7ff;
            stroke-width: 2.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .rc-section-heading {
            max-width: 680px;
            margin: 0 auto 46px;
            text-align: center;
        }

        .rc-section-heading h2 {
            margin: 0 0 14px;
            color: var(--rc-navy-dark);
            font-size: clamp(1.8rem, 3vw, 2.75rem);
            font-weight: 900;
            line-height: 1.35;
        }

        .rc-section-heading p {
            margin: 0;
            color: var(--rc-muted);
            font-size: 1rem;
            line-height: 1.9;
        }

        .rc-benefits-section {
            position: relative;
            background: var(--rc-white);
        }

        .rc-benefit-card {
            height: 100%;
            display: flex;
            align-items: flex-start;
            gap: 18px;
            padding: 25px;
            border: 1px solid var(--rc-border);
            border-radius: 20px;
            background: var(--rc-white);
            box-shadow: 0 12px 35px rgba(18, 59, 99, .06);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .rc-benefit-card:hover {
            transform: translateY(-6px);
            border-color: rgba(22, 139, 195, .35);
            box-shadow: var(--rc-shadow);
        }

        .rc-benefit-icon {
            width: 56px;
            height: 56px;
            flex: 0 0 56px;
            display: grid;
            place-items: center;
            border-radius: 17px;
            color: var(--rc-blue);
            background: linear-gradient(145deg, #e7f6fd, #f5fbff);
            border: 1px solid #d6eef9;
        }

        .rc-benefit-icon svg {
            width: 27px;
            height: 27px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .rc-benefit-card h3 {
            margin: 2px 0 8px;
            color: var(--rc-navy);
            font-size: 1.16rem;
            font-weight: 900;
        }

        .rc-benefit-card p {
            margin: 0;
            color: var(--rc-muted);
            line-height: 1.8;
            font-size: .92rem;
        }

        .rc-plans-section {
            position: relative;
            background:
                radial-gradient(circle at 10% 20%, rgba(56, 189, 248, .12), transparent 28%),
                radial-gradient(circle at 90% 80%, rgba(229, 57, 69, .08), transparent 28%),
                linear-gradient(145deg, var(--rc-navy-dark), var(--rc-navy));
        }

        .rc-plans-section::before {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .08;
            background-image:
                linear-gradient(rgba(255,255,255,.8) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.8) 1px, transparent 1px);
            background-size: 42px 42px;
            pointer-events: none;
        }

        .rc-section-heading--light {
            position: relative;
            z-index: 1;
        }

        .rc-section-heading--light > span {
            color: #6ed8ff;
        }

        .rc-section-heading--light h2 {
            color: var(--rc-white);
        }

        .rc-section-heading--light p {
            color: rgba(255, 255, 255, .70);
        }

        .rc-pricing-grid {
            position: relative;
            z-index: 2;
            align-items: stretch;
        }

        .rc-plan-card {
            position: relative;
            width: 100%;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            padding: 34px 28px 28px;
            border: 1px solid rgba(255, 255, 255, .55);
            border-radius: 24px;
            background: rgba(255, 255, 255, .97);
            box-shadow: 0 24px 55px rgba(0, 0, 0, .20);
            transition: transform .3s ease, box-shadow .3s ease;
            overflow: hidden;
        }

        .rc-plan-card:hover {
            transform: translateY(-9px);
            box-shadow: 0 34px 75px rgba(0, 0, 0, .28);
        }

        .rc-plan-card::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--rc-blue), var(--rc-sky));
        }

        .rc-plan-card--free {
            overflow: visible;
            border: 2px solid transparent;
            background:
                linear-gradient(#fff, #fff) padding-box,
                linear-gradient(135deg, var(--rc-free-b), #6ee7b7, var(--rc-sky)) border-box;
            box-shadow:
                0 0 0 5px rgba(20, 184, 166, .10),
                0 30px 75px rgba(0, 0, 0, .28);
            transform: translateY(-14px);
        }

        .rc-plan-card--free:hover {
            transform: translateY(-23px);
        }

        .rc-plan-card--free::before {
            height: 6px;
            border-radius: 22px 22px 0 0;
            background: linear-gradient(90deg, var(--rc-free-a), var(--rc-free-b), var(--rc-sky));
        }

        .rc-free-badge {
            position: absolute;
            top: 22px;
            left: 22px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 11px;
            color: var(--rc-free-a);
            background: var(--rc-free-soft);
            border: 1px solid #b7f0e3;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 900;
        }

        .rc-free-badge__dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--rc-free-b);
            box-shadow: 0 0 0 4px rgba(20, 184, 166, .13);
        }

        .rc-most-popular {
            position: absolute;
            top: -19px;
            right: 50%;
            transform: translateX(50%);
            min-width: 150px;
            padding: 9px 18px;
            text-align: center;
            color: var(--rc-white);
            background: linear-gradient(135deg, var(--rc-free-a), var(--rc-free-b));
            border: 4px solid var(--rc-navy-dark);
            border-radius: 999px;
            box-shadow: 0 10px 25px rgba(20, 184, 166, .35);
            font-size: .78rem;
            font-weight: 900;
            z-index: 3;
        }

        .rc-plan-card__header {
            text-align: center;
        }

        .rc-plan-icon {
            width: 66px;
            height: 66px;
            display: grid;
            place-items: center;
            margin: 4px auto 18px;
            color: var(--rc-blue);
            background: linear-gradient(145deg, #eaf7fd, #f7fcff);
            border: 1px solid #d5eef9;
            border-radius: 20px;
            transform: rotate(-4deg);
        }

        .rc-plan-icon--free {
            color: var(--rc-free-a);
            background: linear-gradient(145deg, #dffaf3, #f5fffc);
            border-color: #bcefe3;
        }

        .rc-plan-icon svg {
            width: 31px;
            height: 31px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .rc-plan-card h3 {
            min-height: 48px;
            margin: 0 0 10px;
            color: var(--rc-navy-dark);
            font-size: 1.65rem;
            font-weight: 900;
            line-height: 1.45;
        }

        .rc-price {
            min-height: 82px;
            display: flex;
            align-items: baseline;
            justify-content: center;
            gap: 7px;
            margin-bottom: 8px;
            color: var(--rc-navy-dark);
        }

        .rc-price strong {
            font-size: 2.65rem;
            line-height: 1;
            font-weight: 950;
        }

        .rc-plan-card--free .rc-price strong {
            color: var(--rc-free-a);
            font-size: 2.5rem;
        }

        .rc-price span {
            color: var(--rc-muted);
            font-size: .9rem;
            font-weight: 800;
        }

        .rc-plan-summary {
            min-height: 55px;
            margin: 0;
            color: var(--rc-muted);
            line-height: 1.8;
            font-size: .9rem;
        }

        .rc-plan-card__body {
            flex: 1;
            margin-top: 22px;
            padding-top: 22px;
            border-top: 1px solid var(--rc-border);
        }

        .rc-free-message,
        .rc-standard-message {
            padding: 14px 15px;
            border-radius: 14px;
            font-size: .84rem;
            line-height: 1.75;
            font-weight: 700;
        }

        .rc-free-message {
            color: #0b6a61;
            background: var(--rc-free-soft);
            border: 1px solid #c4f1e7;
        }

        .rc-standard-message {
            color: var(--rc-navy);
            background: #f1f7fb;
            border: 1px solid #dcebf4;
        }

        .rc-plan-features {
            list-style: none;
            margin: 18px 0 0;
            padding: 0;
        }

        .rc-plan-features li {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 12px;
            color: var(--rc-text);
            font-size: .88rem;
            font-weight: 750;
        }

        .rc-check {
            width: 24px;
            height: 24px;
            flex: 0 0 24px;
            display: grid;
            place-items: center;
            color: var(--rc-white);
            background: linear-gradient(135deg, var(--rc-free-a), var(--rc-free-b));
            border-radius: 50%;
        }

        .rc-check svg {
            width: 14px;
            height: 14px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .rc-plan-card__footer {
            display: grid;
            gap: 10px;
            margin-top: 25px;
        }

        .rc-btn {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 12px 18px;
            border: 0;
            border-radius: 13px;
            font-family: inherit;
            font-size: .92rem;
            font-weight: 900;
            text-decoration: none !important;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease, color .2s ease;
        }

        .rc-btn svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .rc-btn:hover {
            transform: translateY(-2px);
        }

        .rc-btn--details {
            color: var(--rc-navy);
            background: #eef5fa;
            border: 1px solid #dce8f1;
        }

        .rc-btn--details:hover {
            color: var(--rc-navy-dark);
            background: #e5f1f8;
        }

        .rc-btn--primary {
            color: var(--rc-white) !important;
            background: linear-gradient(135deg, var(--rc-navy), var(--rc-blue));
            box-shadow: 0 11px 24px rgba(18, 59, 99, .22);
        }

        .rc-btn--primary:hover {
            color: var(--rc-white) !important;
            box-shadow: 0 15px 30px rgba(18, 59, 99, .30);
        }

        .rc-btn--free {
            position: relative;
            overflow: hidden;
            color: var(--rc-white) !important;
            background: linear-gradient(135deg, var(--rc-free-a), var(--rc-free-b));
            box-shadow: 0 12px 25px rgba(20, 184, 166, .26);
        }

        .rc-btn--free::after {
            content: "";
            position: absolute;
            top: 0;
            left: -110%;
            width: 60%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.35), transparent);
            transform: skewX(-20deg);
            transition: left .55s ease;
        }

        .rc-btn--free:hover::after {
            left: 150%;
        }

        .rc-btn--free:hover {
            color: var(--rc-white) !important;
            box-shadow: 0 16px 34px rgba(20, 184, 166, .36);
        }

        .rc-btn--disabled {
            color: #8b98a8;
            background: #e8edf2;
            cursor: not-allowed;
        }

        .rc-btn--disabled:hover {
            transform: none;
        }

        .rc-free-note {
            display: block;
            text-align: center;
            color: #719089;
            font-size: .72rem;
            font-weight: 700;
        }

        .rc-how-section {
            background:
                linear-gradient(180deg, #f7fbfe, #eef5fa);
        }

        .rc-info-panel {
            padding: 50px;
            border: 1px solid var(--rc-border);
            border-radius: 28px;
            background: var(--rc-white);
            box-shadow: var(--rc-shadow);
        }

        .rc-section-heading--inside {
            max-width: 760px;
            margin-bottom: 40px;
        }

        .rc-steps {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .rc-step {
            display: flex;
            gap: 18px;
            padding: 24px;
            border: 1px solid var(--rc-border);
            border-radius: 18px;
            background: #fbfdff;
        }

        .rc-step-number {
            min-width: 45px;
            color: rgba(22, 139, 195, .28);
            font-size: 1.55rem;
            font-weight: 950;
            line-height: 1;
        }

        .rc-step h3,
        .rc-compensation-box h3 {
            margin: 0 0 10px;
            color: var(--rc-navy);
            font-size: 1rem;
            font-weight: 900;
        }

        .rc-step p,
        .rc-compensation-box p {
            margin: 0;
            color: var(--rc-muted);
            font-size: .88rem;
            line-height: 1.9;
        }

        .rc-step--warning {
            border-color: #f6d9dc;
            background: #fffafb;
        }

        .rc-step--warning .rc-step-number {
            color: rgba(229, 57, 69, .28);
        }

        .rc-compensation-box {
            display: flex;
            align-items: flex-start;
            gap: 18px;
            margin-top: 22px;
            padding: 25px;
            color: var(--rc-white);
            background: linear-gradient(135deg, var(--rc-navy-dark), var(--rc-navy));
            border-radius: 18px;
        }

        .rc-compensation-box__icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: grid;
            place-items: center;
            color: var(--rc-white);
            background: var(--rc-red);
            border-radius: 13px;
            font-size: 1.25rem;
            font-weight: 950;
        }

        .rc-compensation-box h3 {
            color: var(--rc-white);
        }

        .rc-compensation-box p {
            color: rgba(255, 255, 255, .72);
        }

        .rc-plan-modal {
            direction: rtl;
            text-align: right;
        }

        .rc-plan-modal .modal-dialog {
            max-width: 850px;
        }

        .rc-plan-modal .modal-content {
            overflow: hidden;
            border: 0;
            border-radius: 24px;
            box-shadow: var(--rc-shadow-lg);
        }

        .rc-plan-modal .modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            padding: 26px 28px;
            border-bottom: 1px solid var(--rc-border);
            background: linear-gradient(145deg, #f7fbfe, #fff);
        }

        .rc-plan-modal .modal-title {
            margin: 0;
            color: var(--rc-navy-dark);
            font-size: 1.55rem;
            font-weight: 900;
        }

        .rc-modal-close {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            padding: 0;
            color: var(--rc-red);
            background: #fff1f2;
            border: 1px solid #ffd8dc;
            border-radius: 12px;
            font-size: 1.7rem;
            line-height: 1;
            cursor: pointer;
        }

        .rc-plan-modal .modal-body {
            padding: 30px;
        }

        .rc-modal-price {
            display: flex;
            align-items: baseline;
            gap: 7px;
            width: fit-content;
            margin-bottom: 22px;
            padding: 12px 18px;
            color: var(--rc-navy);
            background: #eef6fb;
            border: 1px solid #dcecf5;
            border-radius: 14px;
        }

        .rc-modal-price--free {
            color: var(--rc-free-a);
            background: var(--rc-free-soft);
            border-color: #c3f0e5;
        }

        .rc-modal-price strong {
            font-size: 1.7rem;
            font-weight: 950;
        }

        .rc-modal-price span {
            font-size: .82rem;
            font-weight: 800;
        }

        .rc-modal-description,
        .rc-modal-extra {
            color: var(--rc-text);
            line-height: 1.9;
        }

        .rc-modal-description {
            padding: 22px;
            background: #f8fbfd;
            border: 1px solid var(--rc-border);
            border-radius: 16px;
        }

        .rc-modal-extra {
            margin-top: 18px;
            padding: 18px 20px;
            color: var(--rc-muted);
            background: #fff;
            border-right: 4px solid var(--rc-blue);
            box-shadow: 0 8px 25px rgba(18, 59, 99, .06);
        }

        .rc-plan-modal .modal-footer {
            display: flex;
            gap: 10px;
            padding: 20px 28px;
            border-top: 1px solid var(--rc-border);
            background: #fbfdff;
        }

        .rc-btn--modal-close {
            color: var(--rc-muted);
            background: #edf2f6;
        }

        @media (max-width: 991.98px) {
            .rc-section {
                padding: 70px 0;
            }

            .rc-pricing-hero {
                min-height: 440px;
            }

            .rc-plan-card--free,
            .rc-plan-card--free:hover {
                transform: none;
            }

            .rc-free-plan-column {
                order: -1;
            }

            .rc-steps {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 767.98px) {
            .rc-pricing-hero {
                min-height: 400px;
                background-position: 58% center;
            }

            .rc-pricing-hero__content {
                padding: 55px 0;
            }

            .rc-pricing-hero h1 {
                font-size: 2.4rem;
            }

            .rc-pricing-hero p {
                font-size: .98rem;
            }

            .rc-hero-points {
                gap: 8px;
            }

            .rc-hero-points span {
                padding: 8px 10px;
                font-size: .78rem;
            }

            .rc-section {
                padding: 58px 0;
            }

            .rc-section-heading {
                margin-bottom: 34px;
            }

            .rc-benefit-card {
                padding: 20px;
            }

            .rc-plan-card {
                padding: 32px 22px 24px;
                border-radius: 20px;
            }

            .rc-plan-card--free {
                margin-top: 8px;
            }

            .rc-info-panel {
                padding: 28px 20px;
                border-radius: 20px;
            }

            .rc-step {
                padding: 20px;
            }

            .rc-compensation-box {
                flex-direction: column;
            }

            .rc-plan-modal .modal-header,
            .rc-plan-modal .modal-body,
            .rc-plan-modal .modal-footer {
                padding-right: 20px;
                padding-left: 20px;
            }

            .rc-plan-modal .modal-footer {
                flex-direction: column;
            }

            .rc-plan-modal .modal-footer .rc-btn {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-pricing-page *,
            .rc-pricing-page *::before,
            .rc-pricing-page *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    <link rel="stylesheet" href="https://rightchoice-co.com/public/assets/css/mof.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</x-layout>
