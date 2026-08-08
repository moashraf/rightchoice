@php
    $promoLocale = Config::get('app.locale') ?: app()->getLocale();
    $isSellFasterPage = request()->is($promoLocale . '/sell-faster');
@endphp

@unless($isSellFasterPage)
    <a
        href="{{ url($promoLocale . '/sell-faster') }}"
        class="rc-sell-faster-float"
        aria-label="{{ App::isLocale('en') ? 'Sell your property faster - 80% off packages' : 'بيع عقارك أسرع - خصم 80% على الباقات' }}"
    >
        <span class="rc-sell-faster-float__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M3 11.2 12 4l9 7.2" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M5.5 10.5V20h13v-9.5M9.5 20v-5.8h5V20" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round"/>
                <path d="m15.4 3.2-2.1 4h2.5l-2.4 4.1" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </span>

        <span class="rc-sell-faster-float__copy">
            <strong>{{ App::isLocale('en') ? 'Sell faster' : 'بيع عقارك أسرع' }}</strong>
            <small>{{ App::isLocale('en') ? 'Limited 80% OFF' : 'خصم 80% على الباقات' }}</small>
        </span>

        <span class="rc-sell-faster-float__badge">80%</span>
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

        .rc-sell-faster-float__icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            color: #fff;
            background: rgba(255,255,255,.16);
            border: 1px solid rgba(255,255,255,.2);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.16);
        }

        .rc-sell-faster-float__icon svg {
            width: 25px;
            height: 25px;
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

            .rc-sell-faster-float__icon {
                width: 38px;
                height: 38px;
                flex-basis: 38px;
                border-radius: 12px;
                display: none;
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
