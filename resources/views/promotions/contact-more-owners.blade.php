<x-layout>
@section('title'){{ App::isLocale('en') ? 'Contact more owners' : 'تواصل مع ملاك أكثر' }}@endsection
@php
    $locale = Config::get('app.locale') ?: app()->getLocale();
    $isEnglish = App::isLocale('en');
    $discountMultiplier = (100 - $discountPercent) / 100;
@endphp

<main class="rc-buyer-promo" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}">
    <section class="rc-buyer-hero">
        <span class="rc-buyer-orb rc-buyer-orb--one"></span>
        <span class="rc-buyer-orb rc-buyer-orb--two"></span>
        <div class="container rc-buyer-hero__inner">
            <div class="rc-buyer-hero__copy">
                <span class="rc-buyer-kicker"><i class="fas fa-key"></i> {{ $isEnglish ? 'A special offer for buyers' : 'عرض خاص للمشترين' }}</span>
                <h1>{{ $isEnglish ? 'Contact more' : 'تواصل مع' }} <em>{{ $isEnglish ? 'property owners' : 'ملاك أكثر' }}</em></h1>
                <p>  احصل على نقاط اضافيه  تساعدك تتواصل مباشرة مع ملاك العقارات بعدد أكثر       </p>
                <p>   بدون عمولة بدون وسيط. </p>
                <div class="rc-buyer-actions">
                    <a href="#buyer-packages" class="rc-buyer-btn rc-buyer-btn--primary">{{ $isEnglish ? 'Get 80% off' : 'استفد من خصم 80%' }} <i class="fas fa-arrow-down"></i></a>
                    <a href="{{ route('priceBuyer', ['locale' => $locale]) }}" class="rc-buyer-btn rc-buyer-btn--ghost">{{ $isEnglish ? 'Package details' : 'تفاصيل الباقات' }}</a>
                </div>
                <div class="rc-buyer-trust">
                    <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'Direct contact' : 'تواصل مباشر' }}</span>
                    <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'No broker commission' : 'بدون عمولة وسيط' }}</span>
                    <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'More choices' : 'اختيارات أكثر' }}</span>
                </div>
            </div>
            <aside class="rc-buyer-discount">
                <small>{{ $isEnglish ? 'LIMITED OFFER' : 'عرض لفترة محدودة' }}</small>
                <strong>{{ $discountPercent }}<sup>%</sup></strong>
                <h2>{{ $isEnglish ? 'Discount on buyer packages' : 'خصم على باقات المشتري' }}</h2>
                <p>{{ $isEnglish ? 'Pay only 20% of the regular price.' : 'ادفع 20% فقط من السعر الأساسي.' }}</p>
            </aside>
        </div>
    </section>

    <section class="rc-buyer-benefits">
        <div class="container">
            <header class="rc-buyer-heading">
                <span>{{ $isEnglish ? 'Why subscribe?' : 'ليه تشترك؟' }}</span>
                <h2> وفر لنفسك عمولتك ووقتك  ومجهودك</h2>
            </header>
            <div class="rc-buyer-benefits__grid">
                <article><i class="fas fa-phone-alt"></i><h3>{{ $isEnglish ? 'Unlock contact details' : 'افتح بيانات التواصل' }}</h3><p>{{ $isEnglish ? 'Use your points to view owner phone numbers.' : 'استخدم نقاطك لعرض أرقام ملاك العقارات.' }}</p></article>
                <article><i class="fas fa-home"></i><h3>{{ $isEnglish ? 'More properties' : 'عقارات أكثر' }}</h3><p>{{ $isEnglish ? 'Compare more suitable options before deciding.' : 'قارن بين اختيارات مناسبة أكثر قبل القرار.' }}</p></article>
                <article><i class="fas fa-handshake"></i><h3>{{ $isEnglish ? 'Direct negotiation' : 'تفاوض مباشر' }}</h3><p>{{ $isEnglish ? 'Speak with owners without an unnecessary intermediary.' : 'اتكلم مع المالك مباشرة بدون وسيط غير ضروري.' }}</p></article>
            </div>
        </div>
    </section>

    <section id="buyer-packages" class="rc-buyer-packages">
        <div class="container">
            <header class="rc-buyer-heading rc-buyer-heading--light">
                <span>{{ $isEnglish ? '80% OFF' : 'خصم 80%' }}</span>
                <h2>{{ $isEnglish ? 'Choose your buyer package' : 'اختار    الباقه المناسبة' }}</h2>
                <p>{{ $isEnglish ? 'The discounted price is applied automatically when you continue from this page.' : 'السعر بعد الخصم بيتطبق تلقائيًا عند الاشتراك من الصفحة دي.' }}</p>
            </header>
            @if($packages->isEmpty())
                <div class="rc-buyer-empty">{{ $isEnglish ? 'No paid packages are available now.' : 'لا توجد باقات مدفوعة متاحة حاليًا.' }}</div>
            @else
                <div class="rc-buyer-packages__grid">
                    @foreach($packages as $package)
                        @php
                            $originalPrice = (float) $package->price;
                            $promoPrice = round($originalPrice * $discountMultiplier, 2);
                            $packageName = $isEnglish && !empty($package->type_en) ? $package->type_en : $package->type;
                            $packageName = strip_tags($packageName, '<i>');
                            $packageDescription = $isEnglish && !empty($package->description_en)
                                ? $package->description_en
                                : $package->description;
                            $packageDetails = array_values(array_filter([
                                $package->desc1,
                                $package->desc2,
                                $package->desc3,
                            ], fn ($detail) => trim(strip_tags((string) $detail)) !== ''));
                        @endphp
                        <article class="rc-buyer-plan" style="--delay: {{ $loop->index * 120 }}ms">
                            <span class="rc-buyer-plan__badge">-{{ $discountPercent }}%</span>
                            <h3>{!! $packageName !!}</h3>

                            @if(!empty($packageDescription))
                                <p class="rc-buyer-plan__description">{{ strip_tags($packageDescription) }}</p>
                            @endif

                            <div class="rc-buyer-plan__price">
                                <div class="rc-buyer-plan__price-row rc-buyer-plan__price-row--before">
                                    <span>{{ $isEnglish ? 'Price before discount' : 'السعر قبل الخصم' }}</span>
                                    <del>{{ number_format($originalPrice, 2) }} {{ $isEnglish ? 'EGP' : 'ج.م' }}</del>
                                </div>
                                <div class="rc-buyer-plan__price-row rc-buyer-plan__price-row--after">
                                    <span>{{ $isEnglish ? 'Price after discount' : 'السعر بعد الخصم' }}</span>
                                    <strong>{{ number_format($promoPrice, 2) }} <small>{{ $isEnglish ? 'EGP' : 'ج.م' }}</small></strong>
                                </div>
                            </div>

                            @if(!empty($packageDetails))
                                <div class="rc-buyer-plan__details">
                                    <h4>{{ $isEnglish ? 'Package details' : 'تفاصيل الباقة' }}</h4>
                                    <ul>
                                        @foreach($packageDetails as $detail)
                                            <li><i class="fas fa-check"></i><span>{{ strip_tags($detail) }}</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <ul class="rc-buyer-plan__features">
                                <li><i class="fas fa-check"></i>{{ number_format((int) $package->points) }} {{ $isEnglish ? 'contact points' : 'نقطة تواصل فور الدفع' }}</li>
                                <li><i class="fas fa-check"></i>{{ $isEnglish ? 'Direct owner contact' : 'تواصل مباشر مع الملاك' }}</li>
                                <li><i class="fas fa-check"></i>{{ $isEnglish ? 'No commission or broker' : 'بدون عمولة وبدون وسيط' }}</li>
                            </ul>
                            <a href="{{ route('contact-more-owners.checkout', ['locale' => $locale, 'pricing' => $package->id]) }}">{{ $isEnglish ? 'Subscribe now' : 'اشترك الآن' }} <i class="fas fa-arrow-left"></i></a>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</main>

<style>
.rc-buyer-promo{--blue:#0b5cab;--dark:#062f5b;--cyan:#25a9e0;background:#f5f9ff;color:#102a43;overflow:hidden}
.rc-buyer-hero{position:relative;padding:105px 0 85px;background:linear-gradient(135deg,#031e3b,#07519a 60%,#1184c8);color:#fff}
.rc-buyer-orb{position:absolute;border-radius:50%;filter:blur(2px);opacity:.2;animation:rcBuyerFloat 7s ease-in-out infinite}
.rc-buyer-orb--one{width:300px;height:300px;top:-100px;right:8%;background:#56ccf2}
.rc-buyer-orb--two{width:190px;height:190px;bottom:-70px;left:9%;background:#fff;animation-delay:-2s}
.rc-buyer-hero__inner{position:relative;display:grid;grid-template-columns:minmax(0,1.35fr) minmax(290px,.65fr);align-items:center;gap:65px}
.rc-buyer-hero__copy{animation:rcBuyerEnter .75s ease both}.rc-buyer-kicker{display:inline-flex;gap:9px;align-items:center;padding:8px 14px;border:1px solid #ffffff42;border-radius:999px;background:#ffffff12;font-weight:800}
.rc-buyer-hero h1{     color: #ffffff; text-align: right; max-width:720px;margin:20px 0 16px;font-size:clamp(38px,5vw,72px);font-weight:950;line-height:1.05}.rc-buyer-hero h1 em{
                                                                                                                                             text-align: right; display:block;color:#71d2ff;font-style:normal}
.rc-buyer-hero__copy>p{ text-align: right; max-width:690px;font-size:18px;line-height:1.9;color:#e4f3ff}.rc-buyer-actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:28px}.rc-buyer-btn{display:inline-flex;align-items:center;gap:9px;padding:14px 20px;border-radius:14px;font-weight:900;text-decoration:none!important;transition:.25s}
.rc-buyer-btn--primary{background:#fff;color:var(--blue)!important;box-shadow:0 16px 35px #001b354d}.rc-buyer-btn--ghost{border:1px solid #ffffff55;color:#fff!important;background:#ffffff10}.rc-buyer-btn:hover{transform:translateY(-4px)}
.rc-buyer-trust{display:flex;flex-wrap:wrap;gap:18px;margin-top:25px;font-size:13px;font-weight:800}.rc-buyer-trust i{margin-inline-end:6px;color:#62d6ff}
.rc-buyer-discount{position:relative;padding:34px;text-align:center;border:1px solid #ffffff42;border-radius:30px;background:#ffffff14;box-shadow:0 25px 60px #00172d59;backdrop-filter:blur(12px);animation:rcBuyerCard 4s ease-in-out infinite}.rc-buyer-discount small{font-weight:900;letter-spacing:2px}.rc-buyer-discount strong{display:block;font-size:92px;line-height:1;color:#fff;text-shadow:0 10px 30px #001b35}.rc-buyer-discount sup{font-size:36px}.rc-buyer-discount h2{     color: #ffa908; font-size:22px;font-weight:900}.rc-buyer-discount p{color:#d9efff}
.rc-buyer-benefits,.rc-buyer-packages{padding:80px 0}.rc-buyer-heading{text-align:center;margin-bottom:38px}.rc-buyer-heading span{color:var(--blue);font-weight:950}.rc-buyer-heading h2{    color: #196ca2; margin:8px 0;font-size:clamp(28px,4vw,44px);font-weight:950}.rc-buyer-heading p{color:#dcecff}.rc-buyer-heading--light{color:#fff}.rc-buyer-heading--light span{color:#62d6ff}
.rc-buyer-benefits__grid,.rc-buyer-packages__grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:22px}.rc-buyer-benefits article{padding:30px;border:1px solid #dce9f7;border-radius:24px;background:#fff;box-shadow:0 15px 40px #194f8012;transition:.3s}.rc-buyer-benefits article:hover{transform:translateY(-8px);box-shadow:0 22px 48px #194f8024}.rc-buyer-benefits article i{display:grid;place-items:center;width:54px;height:54px;border-radius:16px;background:#e5f3ff;color:var(--blue);font-size:21px}.rc-buyer-benefits h3{margin:18px 0 8px;font-weight:900}.rc-buyer-benefits p{color:#64788c;line-height:1.8}
.rc-buyer-packages{background:linear-gradient(145deg,#052c55,#0b5cab)}.rc-buyer-plan{position:relative;padding:30px;border:1px solid #ffffff30;border-radius:26px;background:#fff;box-shadow:0 22px 55px #00172d52;animation:rcBuyerPlanEnter .65s ease backwards;animation-delay:var(--delay);transition:.3s}.rc-buyer-plan:hover{transform:translateY(-10px);box-shadow:0 30px 65px #00172d80}.rc-buyer-plan__badge{position:absolute;top:18px;left:18px;padding:6px 10px;border-radius:999px;background:#0b5cab;color:#fff;font-weight:950}.rc-buyer-plan h3{padding-inline-end:65px;font-size:22px;font-weight:950}.rc-buyer-plan__description{min-height:48px;color:#66798c;line-height:1.8}.rc-buyer-plan__price{display:grid;gap:12px;margin:22px 0;padding:18px;border-radius:18px;background:#edf7ff}.rc-buyer-plan__price-row{display:flex;align-items:center;justify-content:space-between;gap:12px}.rc-buyer-plan__price-row>span{font-size:13px;font-weight:900;color:#60778b}.rc-buyer-plan__price-row--before{padding-bottom:11px;border-bottom:1px dashed #bad6eb}.rc-buyer-plan__price del{color:#8798a8;font-size:16px;font-weight:800}.rc-buyer-plan__price strong{color:var(--blue);font-size:30px;font-weight:950}.rc-buyer-plan__price small{font-size:14px}.rc-buyer-plan__details{margin:0 0 18px;padding:16px;border:1px solid #d8e8f5;border-radius:16px;background:#f9fcff}.rc-buyer-plan__details h4{margin:0 0 9px;color:var(--dark);font-size:15px;font-weight:950}.rc-buyer-plan ul{padding:0;list-style:none;line-height:2.1}.rc-buyer-plan__details ul{margin:0}.rc-buyer-plan__details li{display:flex;align-items:flex-start;gap:2px;color:#526a7e}.rc-buyer-plan li i{margin-inline-end:8px;color:#159447}.rc-buyer-plan__features{margin-bottom:20px}.rc-buyer-plan>a{display:flex;justify-content:center;gap:10px;padding:14px;border-radius:13px;background:linear-gradient(135deg,var(--blue),var(--cyan));color:#fff!important;font-weight:900;text-decoration:none!important}
.rc-buyer-empty{padding:35px;border-radius:20px;background:#fff;text-align:center}.rc-buyer-plan:nth-child(2){transform:translateY(-12px)}.rc-buyer-plan:nth-child(2):hover{transform:translateY(-20px)}
@keyframes rcBuyerEnter{from{opacity:0;transform:translateY(25px)}to{opacity:1;transform:none}}@keyframes rcBuyerPlanEnter{from{opacity:0;transform:translateY(30px) scale(.96)}to{opacity:1;transform:none}}@keyframes rcBuyerFloat{50%{transform:translateY(25px)}}@keyframes rcBuyerCard{50%{transform:translateY(-10px)}}
@media(max-width:991px){.rc-buyer-hero__inner{grid-template-columns:1fr}.rc-buyer-discount{max-width:500px}.rc-buyer-benefits__grid,.rc-buyer-packages__grid{grid-template-columns:repeat(2,1fr)}}
@media(max-width:767px){.rc-buyer-hero{padding:75px 0 55px}.rc-buyer-benefits,.rc-buyer-packages{padding:55px 0}.rc-buyer-benefits__grid,.rc-buyer-packages__grid{grid-template-columns:1fr}.rc-buyer-plan:nth-child(2){transform:none}.rc-buyer-hero h1{font-size:42px}.rc-buyer-discount strong{font-size:75px}}
@media(prefers-reduced-motion:reduce){.rc-buyer-promo *{animation:none!important;transition:none!important}}
</style>
</x-layout>
