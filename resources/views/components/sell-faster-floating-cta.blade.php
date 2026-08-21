@php
    $promoLocale = Config::get('app.locale') ?: app()->getLocale();
    $isSellFasterPage = request()->is($promoLocale . '/sell-faster');
    $isAuthenticated = auth()->check();
    $floatingCtaUrl = $isAuthenticated
        ? url($promoLocale . '/sell-faster')
        : route('user.register', ['locale' => $promoLocale]);
@endphp

@unless($isSellFasterPage)
    <a
        href="{{ $floatingCtaUrl }}"
        class="rc-sell-faster-float"
        aria-label="{{ $isAuthenticated
            ? (App::isLocale('en') ? 'Sell your property faster - 80% off packages' : 'بيع عقارك أسرع - خصم 80% على الباقات')
            : (App::isLocale('en') ? 'Register your details for free' : 'سجل بياناتك مجانًا') }}"
    >


        <span class="rc-sell-faster-float__copy">
            @if($isAuthenticated)
                <strong>{{ App::isLocale('en') ? 'Sell faster' : 'بيع عقارك أسرع' }}</strong>
                <small>{{ App::isLocale('en') ? 'Limited 80% OFF' : 'خصم 80% على الباقات' }}</small>
            @else
                <strong>{{ App::isLocale('en') ? 'Join Right Choice' : 'سجل بياناتك' }}</strong>
             @endif
        </span>

        <span class="rc-sell-faster-float__badge">
            {{ $isAuthenticated ? '80%' : (App::isLocale('en') ? 'FREE' : 'مجانًا') }}
        </span>
    </a>

    <style>
        .rc-sell-faster-float,
        .rc-sell-faster-float * {
            box-sizing: border-box;
        }

        .rc-sell-faster-float {
            position: fixed;
            top: 53%;
            right: 0;
            z-index: 9998;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 66px;
            padding: 10px 12px 10px 14px;
            border-radius: 22px 0 0 22px;
            color: #fff !important;
            text-decoration: none !important;
            background:
                radial-gradient(circle at 15% 10%, rgba(255,255,255,.22), transparent 35%),
                linear-gradient(135deg, #F47D35 0%, #EE5B2A 48%, #D9472A 100%);
            border: 1px solid rgba(255,255,255,.26);
            border-right: 0;
            box-shadow: 0 18px 44px rgba(4, 44, 78, .28);
            transform: translateY(-50%);
            transition: transform .25s ease, box-shadow .25s ease, padding .25s ease;
            overflow: hidden;
            isolation: isolate;
            animation: rcSellFasterFloatPulse 2.8s ease-in-out infinite;
        }

        .rc-sell-faster-float::before {
            content: '';
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(115deg, transparent 15%, rgba(255,255,255,.26) 42%, transparent 67%);
            transform: translateX(120%);
            animation: rcSellFasterShine 3.2s ease-in-out infinite;
        }

        .rc-sell-faster-float:hover,
        .rc-sell-faster-float:focus {
            color: #fff !important;
            text-decoration: none !important;
            transform: translateY(-50%) translateX(-6px);
            box-shadow: 0 22px 54px rgba(4, 44, 78, .36);
            outline: none;
        }



        .rc-sell-faster-float__copy {
            display: flex;
            flex-direction: column;
            gap: 2px;
            white-space: nowrap;
            text-align: right;
            line-height: 1.3;
        }

        html[lang^="en"] .rc-sell-faster-float__copy {
            text-align: left;
        }

        .rc-sell-faster-float__copy strong {
            color: #fff;
            font-size: 14px;
            font-weight: 900;
        }

        .rc-sell-faster-float__copy small {
            color: rgba(255,255,255,.88);
            font-size: 11px;
            font-weight: 800;
        }

        .rc-sell-faster-float__badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 42px;
            height: 32px;
            padding: 0 7px;
            border-radius: 999px;
            color: #073F73;
            background: #fff;
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 8px 20px rgba(0,0,0,.14);
        }

        @keyframes rcSellFasterFloatPulse {
            0%, 100% { box-shadow: 0 18px 44px rgba(4, 44, 78, .28); }
            50% { box-shadow: 0 18px 50px rgba(244, 125, 53, .46); }
        }

        @keyframes rcSellFasterShine {
            0%, 58% { transform: translateX(120%); }
            78%, 100% { transform: translateX(-120%); }
        }

        @media (max-width: 767.98px) {
            .rc-sell-faster-float {
                top: auto;
                right: 14px;
                bottom: 82px;
                min-height: 56px;
                padding: 8px 10px;
                border-radius: 18px;
                border-right: 1px solid rgba(255,255,255,.26);
                transform: none;
                box-shadow: 0 16px 38px rgba(4, 44, 78, .3);
            }

            .rc-sell-faster-float:hover,
            .rc-sell-faster-float:focus {
                transform: translateY(-4px);
            }

            .rc-sell-faster-float__copy strong {  display: none; font-size: 13px; }
            .rc-sell-faster-float__copy small { font-size: 10px; }
            .rc-sell-faster-float__badge { min-width: 38px; height: 29px; }
        }

        @media (max-width: 420px) {
            .rc-sell-faster-float__copy small { display: none; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-sell-faster-float,
            .rc-sell-faster-float::before {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
@endunless
