<x-layout>

    @section('title')
        {{ trans('langsite.developers') }}
    @endsection

    <style>
        .rc-developers-page {
            --rc-blue: #0b4f86;
            --rc-blue-dark: #063a66;
            --rc-blue-soft: #eaf5fb;
            --rc-teal: #18c6a3;
            --rc-teal-dark: #0aa987;
            --rc-aqua: #84d7e9;
            --rc-ink: #1b3354;
            --rc-muted: #748399;
            --rc-border: #e6edf4;
            --rc-white: #ffffff;
            direction: rtl;
            background:
                radial-gradient(circle at 12% 18%, rgba(24, 198, 163, .10), transparent 28%),
                radial-gradient(circle at 88% 24%, rgba(11, 79, 134, .10), transparent 32%),
                linear-gradient(180deg, #f7fbfe 0%, #ffffff 55%, #f8fbfd 100%);
            min-height: 100vh;
            padding-bottom: 70px;
        }

        .rc-developers-hero {
            position: relative;
            overflow: hidden;
            padding: 76px 0 58px;
            background:
                linear-gradient(135deg, rgba(6, 58, 102, .97) 0%, rgba(11, 79, 134, .94) 48%, rgba(24, 198, 163, .88) 100%),
                url('https://rightchoice-co.com/assets/img/rclogo.png');
            color: var(--rc-white);
            isolation: isolate;
        }

        .rc-developers-hero:before,
        .rc-developers-hero:after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            z-index: -1;
        }

        .rc-developers-hero:before {
            width: 420px;
            height: 420px;
            inset-inline-start: -140px;
            top: -170px;
            background: rgba(255, 255, 255, .12);
        }

        .rc-developers-hero:after {
            width: 520px;
            height: 520px;
            inset-inline-end: -210px;
            bottom: -280px;
            border: 70px solid rgba(255, 255, 255, .10);
        }

        .rc-hero-content {
            position: relative;
            max-width: 860px;
            margin: 0 auto;
            text-align: center;
            padding: 0 15px;
        }

        .rc-hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 16px;
            padding: 9px 18px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 999px;
            background: rgba(255, 255, 255, .13);
            backdrop-filter: blur(12px);
            font-size: 14px;
            font-weight: 700;
            color: rgba(255, 255, 255, .92);
        }

        .rc-hero-eyebrow i {
            color: #bff9ee;
        }

        .rc-developers-hero h1 {
            margin: 0;
            font-size: clamp(34px, 5vw, 58px);
            line-height: 1.18;
            font-weight: 900;
            letter-spacing: -.8px;
            color: #fff;
        }

        .rc-developers-hero p {
            max-width: 690px;
            margin: 18px auto 0;
            font-size: 18px;
            line-height: 1.9;
            color: rgba(255, 255, 255, .86);
            font-weight: 500;
        }

        .rc-hero-stats {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 28px;
        }

        .rc-hero-stat {
            min-width: 150px;
            padding: 14px 18px;
            border-radius: 20px;
            background: rgba(255, 255, 255, .13);
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(14px);
        }

        .rc-hero-stat strong {
            display: block;
            font-size: 23px;
            font-weight: 900;
            color: #fff;
        }

        .rc-hero-stat span {
            display: block;
            margin-top: 4px;
            font-size: 13px;
            color: rgba(255, 255, 255, .80);
        }

        .rc-developers-content {
            margin-top: -34px;
            position: relative;
            z-index: 3;
        }

        .rc-search-card {
            max-width: 930px;
            margin: 0 auto 34px;
            padding: 18px;
            border-radius: 28px;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(230, 237, 244, .92);
            box-shadow: 0 22px 60px rgba(6, 58, 102, .13);
            backdrop-filter: blur(16px);
        }

        .rc-search-inner {
            display: flex;
            align-items: stretch;
            gap: 12px;
            background: #f7fbfd;
            border: 1px solid var(--rc-border);
            border-radius: 22px;
            padding: 8px;
        }

        .rc-search-input-wrap {
            position: relative;
            flex: 1;
        }

        .rc-search-input-wrap i {
            position: absolute;
            top: 50%;
            inset-inline-start: 18px;
            transform: translateY(-50%);
            color: var(--rc-teal);
            font-size: 16px;
            z-index: 2;
        }

        .rc-search-input {
            width: 100%;
            height: 54px;
            border: 0;
            outline: 0;
            border-radius: 17px;
            background: #fff;
            color: var(--rc-ink);
            padding: 0 48px 0 18px;
            font-size: 15px;
            font-weight: 700;
            box-shadow: inset 0 0 0 1px rgba(11, 79, 134, .08);
            transition: box-shadow .2s ease, transform .2s ease;
        }

        .rc-search-input:focus {
            box-shadow: inset 0 0 0 2px rgba(24, 198, 163, .46), 0 10px 24px rgba(24, 198, 163, .10);
        }

        .rc-search-btn {
            min-width: 145px;
            height: 54px;
            border: 0;
            border-radius: 17px;
            color: #fff;
            font-weight: 900;
            font-size: 15px;
            background: linear-gradient(135deg, var(--rc-blue) 0%, #116fa9 52%, var(--rc-teal) 100%);
            box-shadow: 0 14px 28px rgba(11, 79, 134, .22);
            transition: transform .2s ease, box-shadow .2s ease;
            cursor: pointer;
        }

        .rc-search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 36px rgba(11, 79, 134, .28);
        }

        .rc-section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .rc-section-title small {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: var(--rc-teal-dark);
            font-weight: 900;
            font-size: 13px;
        }

        .rc-section-title h2 {
            margin: 0;
            color: var(--rc-ink);
            font-size: 28px;
            font-weight: 900;
            line-height: 1.35;
        }

        .rc-section-note {
            max-width: 420px;
            margin: 0;
            color: var(--rc-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .rc-developer-col {
            margin-bottom: 26px;
        }

        .rc-developer-link {
            display: block;
            height: 100%;
            color: inherit;
            text-decoration: none !important;
        }

        .rc-developer-card {
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: 360px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .96);
            border: 1px solid rgba(230, 237, 244, .92);
            box-shadow: 0 18px 45px rgba(22, 45, 76, .09);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
        }

        .rc-developer-card:before {
            content: "";
            position: absolute;
            inset: 0 0 auto 0;
            height: 112px;
            background:
                radial-gradient(circle at 18% 12%, rgba(24, 198, 163, .26), transparent 30%),
                linear-gradient(135deg, rgba(11, 79, 134, .11), rgba(24, 198, 163, .11));
            pointer-events: none;
        }

        .rc-developer-card:hover {
            transform: translateY(-8px);
            border-color: rgba(24, 198, 163, .34);
            box-shadow: 0 26px 70px rgba(11, 79, 134, .16);
        }

        .rc-card-body {
            position: relative;
            z-index: 1;
            padding: 28px 24px 24px;
            text-align: center;
        }

        .rc-dev-image-ring {
            width: 144px;
            height: 144px;
            margin: 0 auto 20px;
            border-radius: 50%;
            padding: 7px;
            background: linear-gradient(135deg, #fff, rgba(132, 215, 233, .42), rgba(24, 198, 163, .38));
            box-shadow: 0 18px 38px rgba(11, 79, 134, .16);
        }

        .rc-dev-image,
        .rc-dev-fallback {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 4px solid #fff;
        }

        .rc-dev-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .rc-dev-fallback {
            background:
                radial-gradient(circle at 25% 18%, rgba(255, 255, 255, .28), transparent 26%),
                linear-gradient(135deg, var(--rc-blue-dark), var(--rc-blue) 52%, #1186bd);
            color: #fff;
            font-size: 38px;
            font-weight: 900;
            letter-spacing: .5px;
        }

        .rc-dev-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            border-radius: 999px;
            color: var(--rc-blue);
            background: var(--rc-blue-soft);
            font-size: 12px;
            font-weight: 900;
        }

        .rc-dev-badge i {
            color: var(--rc-teal-dark);
        }

        .rc-dev-name {
            min-height: 52px;
            margin: 15px 0 12px;
            color: var(--rc-ink);
            font-size: 21px;
            line-height: 1.45;
            font-weight: 900;
            word-break: break-word;
        }

        .rc-dev-meta {
            display: grid;
            grid-template-columns: 1fr;
            gap: 12px;
            margin: 18px 0 22px;
        }

        .rc-dev-count {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 18px;
            background: #f8fcfe;
            border: 1px solid var(--rc-border);
        }

        .rc-dev-count span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--rc-muted);
            font-size: 13px;
            font-weight: 800;
        }

        .rc-dev-count span i {
            color: var(--rc-teal-dark);
        }

        .rc-dev-count strong {
            color: var(--rc-blue);
            font-size: 24px;
            font-weight: 950;
        }

        .rc-dev-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 48px;
            border-radius: 16px;
            color: #fff;
            font-weight: 900;
            background: linear-gradient(135deg, var(--rc-blue), #0f6faa);
            box-shadow: 0 13px 26px rgba(11, 79, 134, .22);
            transition: background .2s ease, transform .2s ease;
        }

        .rc-developer-card:hover .rc-dev-action {
            background: linear-gradient(135deg, var(--rc-teal-dark), var(--rc-blue));
        }

        .rc-empty-state {
            margin: 35px auto 0;
            max-width: 560px;
            padding: 42px 28px;
            text-align: center;
            border-radius: 30px;
            background: #fff;
            border: 1px solid var(--rc-border);
            box-shadow: 0 20px 55px rgba(11, 79, 134, .10);
        }

        .rc-empty-state i {
            width: 74px;
            height: 74px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: var(--rc-blue);
            background: var(--rc-blue-soft);
            font-size: 28px;
            margin-bottom: 15px;
        }

        .rc-empty-state h4 {
            color: var(--rc-ink);
            font-weight: 900;
            margin: 0;
        }

        .rc-pagination-wrap {
            margin-top: 18px;
        }

        .rc-pagination-wrap .pagination {
            gap: 7px;
            flex-wrap: wrap;
        }

        .rc-pagination-wrap .page-link {
            border-radius: 12px !important;
            border-color: var(--rc-border);
            color: var(--rc-blue);
            font-weight: 800;
        }

        .rc-pagination-wrap .page-item.active .page-link {
            background: var(--rc-blue);
            border-color: var(--rc-blue);
        }

        @media (max-width: 991px) {
            .rc-section-head {
                display: block;
                text-align: center;
            }

            .rc-section-note {
                margin: 10px auto 0;
            }
        }

        @media (max-width: 767px) {
            .rc-developers-hero {
                padding: 58px 0 48px;
            }

            .rc-search-inner {
                display: block;
            }

            .rc-search-btn {
                width: 100%;
                margin-top: 10px;
            }

            .rc-hero-stats {
                gap: 10px;
            }

            .rc-hero-stat {
                width: calc(50% - 6px);
                min-width: auto;
            }
        }
    </style>

    <main class="rc-developers-page" dir="rtl">
        <section class="rc-developers-hero">
            <div class="container">
                <div class="rc-hero-content">
                    <div class="rc-hero-eyebrow">
                        <i class="fas fa-city"></i>
                        <span>{{ trans('langsite.developer_badge') }}</span>
                    </div>

                    <h1>{{ trans('langsite.developers') }}</h1>
                    <p>{{ trans('langsite.developers_intro') }}</p>

                    <div class="rc-hero-stats" aria-label="Developers statistics">
                        <div class="rc-hero-stat">
                            <strong>{{ $developers->total() }}</strong>
                            <span>{{ trans('langsite.developers') }}</span>
                        </div>
                        <div class="rc-hero-stat">
                            <strong>{{ $developers->sum('aqars_count') }}</strong>
                            <span>{{ trans('langsite.properties_count') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rc-developers-content">
            <div class="container">
                <form action="{{ URL::to('/' . Config::get('app.locale') . '/developers') }}"
                      id="sortform" method="get" class="rc-search-card">
                    <div class="rc-search-inner">
                        <div class="rc-search-input-wrap">
                            <i class="fas fa-search"></i>
                            <input name="keywords" type="text" class="rc-search-input"
                                   placeholder="{{ trans('langsite.search_developers') }}"
                                   value="{{ $q }}" tabindex="0">
                        </div>

                        <button type="submit" class="rc-search-btn">
                            {{ trans('langsite.search') }}
                        </button>
                    </div>
                </form>

                <div class="rc-section-head">
                    <div class="rc-section-title">
                        <small>
                            <i class="fas fa-star"></i>
                            {{ trans('langsite.developer_badge') }}
                        </small>
                        <h2>{{ trans('langsite.developers') }}</h2>
                    </div>
                    <p class="rc-section-note">
                        اختر مطورك العقاري الموثوق وتصفح ملفه وعدد العقارات المتاحة لديه بتجربة عرض أكثر وضوحًا وفخامة.
                    </p>
                </div>

                <div class="row">
                    @forelse ($developers as $dev)
                        @php
                            $developerName = $dev->Commercial_Register ?: ($dev->name ?? 'Right Choice');
                            $developerInitial = function_exists('mb_substr') ? mb_substr($developerName, 0, 1, 'UTF-8') : substr($developerName, 0, 1);
                            $profileImage = $dev->profile_image ?? null;
                            $profileImageUrl = null;

                            if ($profileImage) {
                                $profileImageUrl = preg_match('/^https?:\/\//i', $profileImage)
                                    ? $profileImage
                                    : URL::to('/') . '/images/' . ltrim($profileImage, '/');
                            }
                        @endphp

                        <div class="col-lg-4 col-md-6 rc-developer-col">
                            <a href="{{ URL::to(Config::get('app.locale') . '/developers/' . $dev->id) }}"
                               class="rc-developer-link"
                               aria-label="{{ trans('langsite.view_profile') }} {{ $developerName }}">
                                <article class="rc-developer-card">
                                    <div class="rc-card-body">
                                        <div class="rc-dev-image-ring">
                                            @if($profileImageUrl)
                                                <div class="rc-dev-image">
                                                    <img src="{{ $profileImageUrl }}"
                                                         alt="{{ $developerName }}"
                                                         loading="lazy">
                                                </div>
                                            @else
                                                <div class="rc-dev-fallback" aria-label="{{ $developerName }}">
{{--                                                    <span>{{ $developerInitial }}</span>--}}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="rc-dev-badge">
                                            <i class="fas fa-building"></i>
                                            <span>{{ trans('langsite.developer_badge') }}</span>
                                        </div>

                                        <h3 class="rc-dev-name">{{ $developerName }}</h3>

                                        <div class="rc-dev-meta">
                                            <div class="rc-dev-count">
                                                <span>
                                                    <i class="fas fa-home"></i>
                                                    {{ trans('langsite.properties_count') }}
                                                </span>
                                                <strong>{{ number_format((int) $dev->aqars_count) }}</strong>
                                            </div>
                                        </div>

                                        <span class="rc-dev-action">
                                            {{ trans('langsite.view_profile') }}
                                            <i class="fas fa-arrow-left"></i>
                                        </span>
                                    </div>
                                </article>
                            </a>
                        </div>
                    @empty
                        <div class="col-lg-12">
                            <div class="rc-empty-state">
                                <i class="fas fa-building-circle-exclamation"></i>
                                <h4>{{ trans('langsite.no_developers_found') }}</h4>
                            </div>
                        </div>
                    @endforelse
                </div>

                <div class="row rc-pagination-wrap">
                    <div class="col-lg-12 d-flex justify-content-center">
                        {!! $developers->render() !!}
                    </div>
                </div>
            </div>
        </section>
    </main>

</x-layout>
