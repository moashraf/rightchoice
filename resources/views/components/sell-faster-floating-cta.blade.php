@php
    $promoLocale = Config::get('app.locale') ?: app()->getLocale();
    $isSellFasterPage = request()->is($promoLocale . '/sell-faster');
    $isContactMoreOwnersPage = request()->is($promoLocale . '/contact-more-owners*');
    $isAuthenticated = auth()->check();
    $sellFasterUrl = $isAuthenticated
        ? route('sell-faster.index', ['locale' => $promoLocale])
        : route('user.register', ['locale' => $promoLocale]);
    $contactMoreOwnersUrl = route('contact-more-owners.index', ['locale' => $promoLocale]);
@endphp

@if(!$isSellFasterPage || !$isContactMoreOwnersPage)
    <div class="rc-floating-promos" aria-label="{{ App::isLocale('en') ? 'Special offers' : 'العروض الخاصة' }}">
        @unless($isSellFasterPage)
            <a href="{{ $sellFasterUrl }}" class="rc-promo-float rc-promo-float--seller">
                <span class="rc-promo-float__copy">
                    @if($isAuthenticated)
                        <strong>{{ App::isLocale('en') ? 'Sell faster' : 'بيع عقارك أسرع' }}</strong>
                        <small>{{ App::isLocale('en') ? 'Limited 80% OFF' : 'خصم 80% على الباقات' }}</small>
                    @else
                        <strong>{{ App::isLocale('en') ? 'Join Right Choice' : 'سجل بياناتك' }}</strong>
                        <small>{{ App::isLocale('en') ? 'Start for free' : 'ابدأ مجانًا' }}</small>
                    @endif
                </span>
                <span class="rc-promo-float__badge">{{ $isAuthenticated ? '80%' : (App::isLocale('en') ? 'FREE' : 'مجانًا') }}</span>
            </a>
        @endunless

        @unless($isContactMoreOwnersPage)
            <a href="{{ $contactMoreOwnersUrl }}#buyer-packages" class="rc-promo-float rc-promo-float--buyer">
                <span class="rc-promo-float__copy">
                    <strong>{{ App::isLocale('en') ? 'Contact more owners' : 'تواصل   مباشر مع الملاك ' }}</strong>
                    <small>
                         خصم

                        <span style="
    background: #ffffff;
    font-size: 13px;
    color: #000000;
    padding: 2px;
    border-radius: 50%;
"> 80 %</span>
                         على الباقات
                    </small>
                 </span>
{{--                <span class="rc-promo-float__badge">80%</span>--}}
            </a>
        @endunless
    </div>

    <style>
        .rc-floating-promos,.rc-floating-promos *{box-sizing:border-box}
        .rc-floating-promos{position:fixed;top:47%;right:0;z-index:9998;display:flex;flex-direction:column;align-items:flex-end;gap:10px;transform:translateY(-50%)}
        .rc-promo-float{position:relative;display:flex;align-items:center;gap:10px;min-height:66px;padding:10px 12px 10px 14px;border:1px solid #ffffff42;border-right:0;border-radius:22px 0 0 22px;color:#fff!important;text-decoration:none!important;box-shadow:0 18px 44px #042c4e47;overflow:hidden;isolation:isolate;transition:transform .25s ease,box-shadow .25s ease,padding .25s ease;animation:rcPromoPulse 3s ease-in-out infinite}
        .rc-promo-float::before{content:"";position:absolute;inset:0;z-index:-1;background:linear-gradient(115deg,transparent 15%,#ffffff42 42%,transparent 67%);transform:translateX(120%);animation:rcPromoShine 3.2s ease-in-out infinite}
        .rc-promo-float--seller{background:radial-gradient(circle at 15% 10%,#ffffff38,transparent 35%),linear-gradient(135deg,#f47d35,#ee5b2a 48%,#d9472a)}
        .rc-promo-float--buyer{background:radial-gradient(circle at 15% 10%,#ffffff38,transparent 35%),linear-gradient(135deg,#178ee0,#0b66bd 50%,#084b91);animation-delay:.7s}
        .rc-promo-float--buyer::before{animation-delay:1.1s}
        .rc-promo-float:hover,.rc-promo-float:focus{color:#fff!important;text-decoration:none!important;transform:translateX(-7px);box-shadow:0 22px 54px #042c4e5c;outline:none}
        .rc-promo-float__copy{display:flex;flex-direction:column;gap:6px;white-space:nowrap;text-align:right;line-height:1.3}html[lang^=en] .rc-promo-float__copy{text-align:left}
        .rc-promo-float__copy strong{color:#fff;font-size:14px;font-weight:900}.rc-promo-float__copy small{color:#ffffffe0;font-size:11px;font-weight:800}
        .rc-promo-float__badge{display:inline-flex;align-items:center;justify-content:center;min-width:42px;height:32px;padding:0 7px;border-radius:999px;color:#073f73;background:#fff;font-size:12px;font-weight:900;box-shadow:0 8px 20px #00000024}
        @keyframes rcPromoPulse{50%{box-shadow:0 20px 52px #0b66bd59}}@keyframes rcPromoShine{0%,58%{transform:translateX(120%)}78%,100%{transform:translateX(-120%)}}
        @media(max-width:767.98px){.rc-floating-promos{top:auto;right:12px;bottom:76px;gap:8px;transform:none}.rc-promo-float{min-height:52px;padding:7px 9px;border-radius:17px;border-right:1px solid #ffffff42}.rc-promo-float:hover,.rc-promo-float:focus{transform:translateY(-3px)}.rc-promo-float__copy strong{font-size:12px}.rc-promo-float__copy small{font-size:9px}.rc-promo-float__badge{min-width:36px;height:28px}}
        @media(max-width:420px){.rc-promo-float__copy small{display:none}.rc-promo-float{min-height:46px}.rc-promo-float__badge{height:25px}}
        @media(prefers-reduced-motion:reduce){.rc-promo-float,.rc-promo-float::before{animation:none!important;transition:none!important}}
    </style>
@endif
