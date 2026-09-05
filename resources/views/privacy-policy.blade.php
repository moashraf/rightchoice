<x-layout>
    @section('title')
        سياسة الخصوصية
    @endsection

    @section('og_description')
        تعرف على كيفية جمع واستخدام وحماية البيانات الشخصية في منصة Right Choice العقارية.
    @endsection

    @php
        $locale = app()->getLocale();
        $isEnglish = $locale === 'en';
        $lastUpdatedSection = $sections->sortByDesc('updated_at')->first();
        $lastUpdated = $lastUpdatedSection && $lastUpdatedSection->updated_at
            ? $lastUpdatedSection->updated_at->format('d/m/Y')
            : '05/09/2026';
    @endphp

    <style>
        :root {
            --rc-privacy-primary: #0e4f86;
            --rc-privacy-primary-dark: #082f52;
            --rc-privacy-accent: #ff6b35;
            --rc-privacy-bg: #f5f8fb;
            --rc-privacy-card: #ffffff;
            --rc-privacy-text: #263238;
            --rc-privacy-muted: #687786;
            --rc-privacy-border: #dce7f0;
            --rc-privacy-soft: #eaf3fa;
        }

        html { scroll-behavior: smooth; }

        .rc-privacy-page {
            background: var(--rc-privacy-bg);
            color: var(--rc-privacy-text);
            min-height: 100vh;
            direction: rtl;
            text-align: right;
        }

        .rc-privacy-hero {
            position: relative;
            overflow: hidden;
            padding: 78px 0 66px;
            background:
                radial-gradient(circle at 12% 20%, rgba(255,255,255,.16), transparent 28%),
                radial-gradient(circle at 88% 80%, rgba(255,107,53,.18), transparent 30%),
                linear-gradient(135deg, var(--rc-privacy-primary-dark), var(--rc-privacy-primary));
            color: #fff;
        }

        .rc-privacy-hero:after {
            content: '';
            position: absolute;
            width: 360px;
            height: 360px;
            right: -8%;
            bottom: -110px;
            border: 52px solid rgba(255,255,255,.05);
            border-radius: 50%;
        }

        .rc-privacy-hero__inner {
            position: relative;
            z-index: 2;
            max-width: 880px;
            margin: 0 auto;
        }

        .rc-privacy-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            margin-bottom: 18px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            font-weight: 700;
            font-size: 14px;
        }

        .rc-privacy-hero h1 {
            color: #fff;
            font-size: clamp(34px, 5vw, 58px);
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.15;
        }

        .rc-privacy-hero p {
            color: rgba(255,255,255,.9);
            font-size: 18px;
            line-height: 1.9;
            margin-bottom: 20px;
        }

        .rc-privacy-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            color: rgba(255,255,255,.82);
            font-size: 14px;
        }

        .rc-privacy-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .rc-privacy-wrap { padding: 50px 0 80px; }

        .rc-privacy-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 280px;
            gap: 28px;
            align-items: start;
        }

        .rc-privacy-content { min-width: 0; }

        .rc-privacy-summary {
            background: linear-gradient(135deg, #fff8f4, #fff);
            border: 1px solid #ffd9c9;
            border-right: 5px solid var(--rc-privacy-accent);
            border-radius: 18px;
            padding: 22px 24px;
            margin-bottom: 24px;
            box-shadow: 0 10px 28px rgba(23,64,95,.06);
            line-height: 1.9;
        }

        .rc-privacy-summary strong {
            display: block;
            color: #b7461f;
            font-size: 18px;
            margin-bottom: 7px;
        }

        .rc-privacy-card {
            background: var(--rc-privacy-card);
            border: 1px solid var(--rc-privacy-border);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 20px;
            box-shadow: 0 10px 35px rgba(23,64,95,.055);
            scroll-margin-top: 110px;
        }

        .rc-privacy-card h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--rc-privacy-primary-dark);
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 8px;
            line-height: 1.45;
        }

        .rc-privacy-card .rc-num {
            width: 38px;
            min-width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--rc-privacy-soft);
            color: var(--rc-privacy-primary);
            font-size: 15px;
        }

        .rc-privacy-subtitle {
            margin: 0 48px 18px 0;
            color: var(--rc-privacy-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .rc-privacy-details p,
        .rc-privacy-details li {
            color: var(--rc-privacy-text);
            font-size: 15.5px;
            line-height: 1.95;
        }

        .rc-privacy-details p:last-child,
        .rc-privacy-details ul:last-child { margin-bottom: 0; }

        .rc-privacy-details ul {
            margin: 0;
            padding-right: 22px;
        }

        .rc-privacy-details li { margin-bottom: 8px; }

        .rc-privacy-details h3 {
            color: var(--rc-privacy-primary);
            font-size: 17px;
            font-weight: 800;
            margin: 20px 0 10px;
        }

        .rc-privacy-details a { color: var(--rc-privacy-primary); }

        .rc-privacy-note {
            margin-top: 16px;
            padding: 16px 18px;
            border-radius: 14px;
            background: #eef8f1;
            border: 1px solid #cce8d4;
            color: #27643a;
            line-height: 1.85;
        }

        .rc-privacy-sidebar {
            position: sticky;
            top: 105px;
            background: #fff;
            border: 1px solid var(--rc-privacy-border);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(23,64,95,.06);
            overflow: hidden;
        }

        .rc-privacy-sidebar__title {
            padding: 18px 18px 14px;
            border-bottom: 1px solid var(--rc-privacy-border);
            color: var(--rc-privacy-primary-dark);
            font-weight: 800;
        }

        .rc-privacy-sidebar nav {
            max-height: calc(100vh - 190px);
            overflow: auto;
            padding: 10px;
        }

        .rc-privacy-sidebar a {
            display: block;
            padding: 9px 10px;
            color: #526270;
            font-size: 13.5px;
            border-radius: 10px;
            text-decoration: none;
            transition: .2s ease;
        }

        .rc-privacy-sidebar a:hover {
            background: var(--rc-privacy-soft);
            color: var(--rc-privacy-primary);
            transform: translateX(-2px);
        }

        .rc-privacy-contact {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 24px;
            margin-top: 26px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--rc-privacy-primary-dark), var(--rc-privacy-primary));
            color: #fff;
        }

        .rc-privacy-contact h3 {
            color: #fff;
            margin: 0 0 4px;
            font-size: 20px;
        }

        .rc-privacy-contact p {
            color: rgba(255,255,255,.82);
            margin: 0;
        }

        .rc-privacy-contact a {
            white-space: nowrap;
            background: #fff;
            color: var(--rc-privacy-primary-dark);
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        @media (max-width: 991px) {
            .rc-privacy-layout { grid-template-columns: 1fr; }
            .rc-privacy-sidebar { display: none; }
            .rc-privacy-hero { padding: 58px 0 48px; }
        }

        @media (max-width: 767px) {
            .rc-privacy-wrap { padding: 28px 0 55px; }
            .rc-privacy-card { padding: 20px 18px; border-radius: 16px; }
            .rc-privacy-card h2 { font-size: 19px; }
            .rc-privacy-subtitle { margin-right: 0; }
            .rc-privacy-contact { align-items: flex-start; flex-direction: column; }
            .rc-privacy-contact a { width: 100%; text-align: center; }
        }
    </style>

    <main class="rc-privacy-page">
        <section class="rc-privacy-hero">
            <div class="container">
                <div class="rc-privacy-hero__inner">
                    <div class="rc-privacy-badge">
                        <i class="fa fa-shield-alt"></i>
                        <span>الخصوصية والأمان في Right Choice</span>
                    </div>
                    <h1>سياسة الخصوصية</h1>
                    <p>نوضح هنا بصورة واضحة كيف نجمع بياناتك ونستخدمها ونشاركها ونحميها أثناء استخدامك لمنصة Right Choice العقارية.</p>
                    <div class="rc-privacy-meta">
                        <span><i class="far fa-calendar-alt"></i> آخر تحديث: {{ $lastUpdated }}</span>
                        <span><i class="fas fa-globe"></i> rightchoice-co.com</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="rc-privacy-wrap">
            <div class="container">
                <div class="rc-privacy-layout">
                    <div class="rc-privacy-content">
                        @if($isEnglish)
                            <div class="rc-privacy-summary">
                                <strong>ملاحظة</strong>
                                النسخة القانونية المعتمدة من هذه الصفحة متاحة حاليًا باللغة العربية.
                            </div>
                        @endif

                        <div class="rc-privacy-summary">
                            <strong>ملخص سريع</strong>
                            توضح هذه السياسة كيفية تعامل Right Choice مع بياناتك أثناء التسجيل، نشر العقارات، البحث والتواصل، استخدام المفضلة، إرسال الشكاوى والاستفسارات، الاشتراك في الباقات والإعلانات المميزة، وإتمام عمليات الدفع من خلال مزودي الخدمة المعتمدين.
                        </div>

                        @forelse($sections as $section)
                            <article id="{{ $section->slug }}" class="rc-privacy-card">
                                <h2>
                                    <span class="rc-num">{{ $section->sort_order }}</span>
                                    {{ $section->title }}
                                </h2>

                                @if(!empty($section->subtitle))
                                    <p class="rc-privacy-subtitle">{{ $section->subtitle }}</p>
                                @endif

                                <div class="rc-privacy-details">
                                    {!! $section->details !!}
                                </div>
                            </article>
                        @empty
                            <div class="rc-privacy-summary">
                                <strong>المحتوى غير متاح حاليًا</strong>
                                يرجى المحاولة مرة أخرى لاحقًا أو التواصل معنا إذا كان لديك استفسار متعلق بالخصوصية.
                            </div>
                        @endforelse

                        <div class="rc-privacy-contact">
                            <div>
                                <h3>لديك استفسار بخصوص بياناتك؟</h3>
                                <p>فريق Right Choice متاح لمراجعة طلبات الخصوصية والاستفسارات.</p>
                            </div>
                            <a href="{{ url($locale . '/contact-us') }}">تواصل معنا</a>
                        </div>
                    </div>

                    <aside class="rc-privacy-sidebar" aria-label="فهرس سياسة الخصوصية">
                        <div class="rc-privacy-sidebar__title">محتويات الصفحة</div>
                        <nav>
                            @foreach($sections as $section)
                                <a href="#{{ $section->slug }}">{{ $section->sort_order }}. {{ $section->title }}</a>
                            @endforeach
                        </nav>
                    </aside>
                </div>
            </div>
        </section>
    </main>
</x-layout>
