<x-layout>
    @section('title')
        {{ App::isLocale('en') ? 'Sell your property faster' : 'بيع عقارك أسرع' }}
    @endsection

    @section('og_description')
        {{ App::isLocale('en')
            ? 'Promote your property with Right Choice, reach more interested buyers, and sell faster.'
            : 'خلّي ناس أكتر تشوف عقارك، ووصل لمشترين مهتمين، وزوّد فرص البيع بشكل أسرع مع رايت تشويز.' }}
    @endsection

    @php
        $locale = Config::get('app.locale') ?: app()->getLocale();
        $isEnglish = App::isLocale('en');
        $isCompanyAccount = auth()->check() && auth()->user()->isCompanyAccount();
        $discountMultiplier = (100 - $discountPercent) / 100;
    @endphp

    <main class="rc-promo-page" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}">
        <section class="rc-promo-hero">
            <div class="rc-promo-hero__orb rc-promo-hero__orb--one"></div>
            <div class="rc-promo-hero__orb rc-promo-hero__orb--two"></div>
            <div class="rc-promo-hero__grid" aria-hidden="true"></div>

            <div class="container position-relative">
                <div class="row align-items-center rc-promo-hero__row">
                    <div class="col-lg-7">
                        <div class="rc-promo-hero__content">
                            <div class="rc-promo-kicker">
                                <span class="rc-promo-kicker__dot"></span>
                                {{ $isEnglish ? 'Special Right Choice offer' : 'عرض خاص من Right Choice' }}
                            </div>

                            <h1>
                                {{ $isEnglish ? 'Sell your property' : 'بيع عقارك' }}
                                <span>{{ $isEnglish ? 'faster' : 'أسرع' }}</span>
                            </h1>

                            <p class="rc-promo-hero__lead">
                                {{ $isEnglish
                                    ? 'Put your property in front of more interested buyers. Promotion packages increase your listing exposure, attract faster attention, and improve its chance of selling.'
                                    : 'باقات التمييز بتخلي ناس أكتر تشوف عقارك، وتوصّل إعلانك لمشترين مهتمين بشكل أسرع، وده يزود فرص البيع.' }}
                            </p>

                            <div class="rc-promo-hero__actions">
                                <a href="#promo-packages" class="rc-promo-btn rc-promo-btn--primary">
                                    <span>{{ $isEnglish ? 'Get the 80% discount' : 'استفد من خصم 80%' }}</span>
                                    <i class="fas fa-arrow-down"></i>
                                </a>

                                <a href="{{ url($locale . '/contact-us') }}" class="rc-promo-btn rc-promo-btn--ghost">
                                    <i class="far fa-comments"></i>
                                    <span>{{ $isEnglish ? 'Contact us' : 'تواصل معنا' }}</span>
                                </a>
                            </div>

                            <div class="rc-promo-trust-row">
                                <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'Direct contact' : 'تواصل مباشر' }}</span>
                                <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'No broker commission' : 'بدون عمولة وسيط' }}</span>
                                <span><i class="fas fa-check-circle"></i>{{ $isEnglish ? 'More property views' : 'مشاهدات أكتر لعقارك' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="rc-promo-offer-card">
                            <div class="rc-promo-offer-card__glow"></div>
                            <span class="rc-promo-offer-card__eyebrow">{{ $isEnglish ? 'SPECIAL OFFER' : 'عرض خاص' }}</span>
                            <div class="rc-promo-discount">
                                <strong>{{ $discountPercent }}%</strong>
                                <span>{{ $isEnglish ? 'OFF' : 'خصم' }}</span>
                            </div>
                            <h2>{{ $isEnglish ? 'Pay only 20% of the regular package price' : 'ادفع 20% فقط من سعر الباقة الأساسي' }}</h2>
                            <p>{{ $isEnglish ? 'The discount is calculated automatically when you subscribe from this page.' : 'الخصم بيتحسب تلقائيًا لما تبدأ الاشتراك من الصفحة دي.' }}</p>
                            <div class="rc-promo-price-example">
                                <span>{{ $isEnglish ? 'Regular price' : 'السعر الأساسي' }}</span>
                                <strong>100%</strong>
                                <i class="fas fa-long-arrow-alt-left"></i>
                                <span>{{ $isEnglish ? 'You pay' : 'هتدفع' }}</span>
                                <strong>20%</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="rc-promo-benefits">
            <div class="container">
                <div class="rc-promo-section-heading">
                    <span>{{ $isEnglish ? 'WHY SUBSCRIBE?' : 'ليه تشترك؟' }}</span>
                    <h2>{{ $isEnglish ? 'Give your property a stronger chance to sell' : 'خلّي فرص بيع عقارك أقوى' }}</h2>
                    <p>{{ $isEnglish ? 'Promotion packages improve your property visibility, help more interested buyers discover it, and increase your chances of receiving serious enquiries faster.' : 'باقات التمييز بتزود ظهور عقارك، وتساعد مشترين مهتمين أكتر يكتشفوا إعلانك، وتزيد فرص وصول استفسارات جادة بشكل أسرع.' }}</p>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <article class="rc-promo-benefit-card">
                            <div class="rc-promo-benefit-card__icon"><i class="fas fa-bullhorn"></i></div>
                            <h3>{{ $isEnglish ? 'More exposure' : 'وصول أكبر' }}</h3>
                            <p>{{ $isEnglish ? 'Show your property to more users who are actively searching for a suitable property.' : 'خلّي عقارك يظهر لعدد أكبر من المستخدمين اللي بيدوروا فعلًا على عقار مناسب.' }}</p>
                        </article>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <article class="rc-promo-benefit-card">
                            <div class="rc-promo-benefit-card__icon"><i class="fas fa-bolt"></i></div>
                            <h3>{{ $isEnglish ? 'Faster action' : 'فرصة أسرع' }}</h3>
                            <p>{{ $isEnglish ? 'Extra exposure helps your listing receive attention and serious enquiries sooner.' : 'الظهور الإضافي يساعد إعلانك يلفت الانتباه ويوصل لاستفسارات جادة في وقت أقصر.' }}</p>
                        </article>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <article class="rc-promo-benefit-card">
                            <div class="rc-promo-benefit-card__icon"><i class="fas fa-comments"></i></div>
                            <h3>{{ $isEnglish ? 'Direct communication' : 'تواصل مباشر' }}</h3>
                            <p>{{ $isEnglish ? 'Right Choice connects sellers and buyers without an unnecessary intermediary.' : 'رايت تشويز بتقرب البائع من المشتري بدون وسيط غير ضروري.' }}</p>
                        </article>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <article class="rc-promo-benefit-card">
                            <div class="rc-promo-benefit-card__icon"><i class="fas fa-coins"></i></div>
                            <h3>{{ $isEnglish ? 'More views' : 'مشاهدات أكتر' }}</h3>
                            <p>{{ $isEnglish ? 'Each package shows the expected number of views so you can choose the right exposure for your property.' : 'كل باقة بتوضح عدد المشاهدات المتوقع علشان تختار مستوى الظهور المناسب لعقارك.' }}</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section id="promo-packages" class="rc-promo-packages">
            <div class="container">
                <div class="rc-promo-section-heading rc-promo-section-heading--light">
                    <span>{{ $isEnglish ? '80% OFF PACKAGES' : 'خصم 80% على الباقات' }}</span>
                    <h2>{{ $isEnglish ? 'Choose how many people see your property' : 'اختار مستوى الظهور المناسب لعقارك' }}</h2>
                    <p>{{ $isEnglish ? 'Every package is designed to increase your property exposure. Compare the expected views and choose the package that helps you reach more buyers faster.' : 'كل باقة مصممة علشان تزود ظهور عقارك. قارن عدد المشاهدات المتوقع واختار الباقة اللي تساعدك توصل لمشترين أكتر وأسرع.' }}</p>
                </div>

                @if($packages->isEmpty())
                    <div class="rc-promo-empty">
                        <i class="fas fa-box-open"></i>
                        <h3>{{ $isEnglish ? 'No paid packages are available right now' : 'لا توجد باقات مدفوعة متاحة حاليًا' }}</h3>
                        <a href="{{ url($locale . '/contact-us') }}">{{ $isEnglish ? 'Contact us' : 'تواصل معنا' }}</a>
                    </div>
                @else
                    <div class="row justify-content-center rc-promo-packages__grid">
                        @foreach($packages as $package)
                            @php
                                $originalPrice = (float) $package->price;
                                $promoPrice = round($originalPrice * $discountMultiplier, 2);
                                $packageTitle = trim(strip_tags($isEnglish && !empty($package->name_en) ? $package->name_en : $package->name));
                                $packageDescription = trim(strip_tags($isEnglish && !empty($package->description_en) ? $package->description_en : $package->description));
                            @endphp

                            <div class="col-xl-4 col-lg-4 col-md-6 mb-4 d-flex">
                                <article class="rc-promo-package-card">
                                    <div class="rc-promo-package-card__badge">-{{ $discountPercent }}%</div>
                                    <div class="rc-promo-package-card__icon"><i class="fas fa-home"></i></div>
                                    <h3>{{ $packageTitle ?: ($isEnglish ? 'Property package' : 'باقة عقارية') }}</h3>

                                    @if($packageDescription)
                                        <p class="rc-promo-package-card__description">{{ Str::limit($packageDescription, 120) }}</p>
                                    @endif

                                    <div class="rc-promo-package-card__pricing">
                                        <div class="rc-promo-old-price">
                                            <span>{{ $isEnglish ? 'Before' : 'قبل الخصم' }}</span>
                                            <del>{{ number_format($originalPrice, 2) }} {{ $isEnglish ? 'EGP' : 'ج.م' }}</del>
                                        </div>
                                        <div class="rc-promo-new-price">
                                            <span>{{ $isEnglish ? 'Now' : 'الآن' }}</span>
                                            <strong>{{ number_format($promoPrice, 2) }}</strong>
                                            <small>{{ $isEnglish ? 'EGP' : 'ج.م' }}</small>
                                        </div>
                                    </div>

                                    <div class="rc-promo-package-card__reach">
                                        <div class="rc-promo-package-card__reach-icon">
                                            <i class="fas fa-eye"></i>
                                        </div>
                                        <div>
                                            <small>{{ $isEnglish ? 'Expected property exposure' : ' ميز اعلانك    ' }}</small>
                                            <strong>
                                                {{  $package->duration_days  }}
                                                  يوم  وخلي الاعلان يظهر اكثر للمشترين
                                            </strong>
                                        </div>
                                    </div>

                                    <ul class="rc-promo-package-card__benefits">
                                        <li><i class="fas fa-check"></i>{{ $isEnglish ? 'More people discover your property' : 'ناس أكتر تكتشف عقارك' }}</li>
                                        <li><i class="fas fa-check"></i>{{ $isEnglish ? 'Faster reach to interested buyers' : 'وصول أسرع لمشترين مهتمين' }}</li>
                                        <li><i class="fas fa-check"></i>{{ $isEnglish ? 'A stronger chance to receive serious enquiries' : 'فرصة أقوى لوصول استفسارات جادة' }}</li>
                                    </ul>

                                    <div class="rc-promo-package-card__action">
                                        @if($isCompanyAccount)
                                            <button class="rc-promo-package-btn rc-promo-package-btn--disabled" type="button" disabled>
                                                {{ $isEnglish ? 'Not available for company accounts' : 'غير متاح لحسابات الشركات' }}
                                            </button>
                                        @elseif(auth()->check())
                                            <form method="POST" action="{{ url($locale . '/sell-faster/subscribe/' . $package->id) }}">
                                                @csrf
                                                <button class="rc-promo-package-btn" type="submit">
                                                    <span>{{ $isEnglish ? 'Promote my property with 80% off' : 'ميّز عقاري الآن بخصم 80%' }}</span>
                                                    <i class="fas fa-arrow-left rc-promo-arrow-rtl"></i>
                                                    <i class="fas fa-arrow-right rc-promo-arrow-ltr"></i>
                                                </button>
                                            </form>
                                        @else
                                            <a class="rc-promo-package-btn" href="{{ url($locale . '/login') }}">
                                                <span>{{ $isEnglish ? 'Sign in to get the offer' : 'سجل دخولك للاستفادة من العرض' }}</span>
                                                <i class="fas fa-sign-in-alt"></i>
                                            </a>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="rc-promo-note">
                    <i class="fas fa-shield-alt"></i>
                    <p>
                        {{ $isEnglish
                            ? 'The 80% discount is applied automatically only when subscription starts from this promotional page. No expiry date is displayed unless one is configured for the campaign.'
                            : 'خصم 80% بيتم تطبيقه تلقائيًا عند بدء الاشتراك من صفحة العرض دي. مفيش تاريخ انتهاء معروض للعرض إلا لو تم تحديده للحملة لاحقًا.' }}
                    </p>
                </div>
            </div>
        </section>

        <section class="rc-promo-final-cta">
            <div class="container">
                <div class="rc-promo-final-cta__card">
                    <div>
                        <span>{{ $isEnglish ? 'Need help choosing?' : 'محتاج مساعدة في الاختيار؟' }}</span>
                        <h2>{{ $isEnglish ? 'Get more eyes on your property and sell faster' : 'خلّي ناس أكتر تشوف عقارك وبيع أسرع' }}</h2>
                        <p>{{ $isEnglish ? 'Choose the right exposure package or contact us to understand which option best suits your property.' : 'اختار باقة الظهور المناسبة، أو تواصل معانا علشان نساعدك تحدد أنسب اختيار لعقارك.' }}</p>
                    </div>
                    <a href="{{ url($locale . '/contact-us') }}" class="rc-promo-btn rc-promo-btn--white">
                        <i class="far fa-comments"></i>
                        {{ $isEnglish ? 'Contact us' : 'تواصل معنا' }}
                    </a>
                </div>
            </div>
        </section>
    </main>

    <style>
        .rc-promo-page {
            --rc-blue: #0B5F9F;
            --rc-blue-dark: #073F73;
            --rc-navy: #042C4E;
            --rc-green: #18C7A1;
            --rc-orange: #F47D35;
            --rc-orange-dark: #E75A28;
            --rc-text: #14324A;
            --rc-muted: #698095;
            overflow: hidden;
            background: #f7fafc;
            color: var(--rc-text);
        }

        .rc-promo-page,
        .rc-promo-page * { box-sizing: border-box; }

        .rc-promo-hero {
            position: relative;
            overflow: hidden;
            min-height: 650px;
            display: flex;
            align-items: center;
            padding: 88px 0;
            color: #fff;
            background:
                radial-gradient(circle at 15% 15%, rgba(24,199,161,.23), transparent 30%),
                radial-gradient(circle at 88% 75%, rgba(244,125,53,.26), transparent 29%),
                linear-gradient(135deg, var(--rc-navy) 0%, var(--rc-blue-dark) 48%, var(--rc-blue) 100%);
        }

        .rc-promo-hero__grid {
            position: absolute;
            inset: 0;
            opacity: .07;
            background-image:
                linear-gradient(rgba(255,255,255,.65) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.65) 1px, transparent 1px);
            background-size: 42px 42px;
            mask-image: linear-gradient(to bottom, #000 0%, transparent 95%);
        }

        .rc-promo-hero__orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(1px);
            pointer-events: none;
        }
        .rc-promo-hero__orb--one { width: 430px; height: 430px; top: -280px; right: -110px; background: rgba(24,199,161,.35); }
        .rc-promo-hero__orb--two { width: 360px; height: 360px; bottom: -250px; left: -120px; background: rgba(244,125,53,.24); }
        .rc-promo-hero__row { position: relative; z-index: 2; }

        .rc-promo-kicker {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 8px 14px;
            margin-bottom: 20px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.08);
            color: rgba(255,255,255,.9);
            font-size: 13px;
            font-weight: 900;
            backdrop-filter: blur(8px);
        }

        .rc-promo-kicker__dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: var(--rc-green);
            box-shadow: 0 0 0 6px rgba(24,199,161,.14);
        }

        .rc-promo-hero h1 {
            max-width: 760px;
            margin: 0 0 20px;
            color: #fff;
            font-size: clamp(42px, 6vw, 76px);
            line-height: 1.06;
            font-weight: 950;
            letter-spacing: -2px;
        }

        .rc-promo-hero h1 span {
            display: inline-block;
            color: #fff;
            background: linear-gradient(90deg, #fff 0%, #BFF8E9 55%, #FFD9BF 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .rc-promo-hero__lead {
            max-width: 680px;
            margin: 0 0 28px;
            color: rgba(255,255,255,.82);
            font-size: 18px;
            line-height: 1.95;
            font-weight: 600;
        }

        .rc-promo-hero__actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 27px;
        }

        .rc-promo-btn {
            min-height: 54px;
            padding: 12px 21px;
            border-radius: 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none !important;
            font-size: 15px;
            font-weight: 900;
            transition: transform .22s ease, box-shadow .22s ease, background .22s ease;
        }

        .rc-promo-btn--primary {
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-orange), var(--rc-orange-dark));
            box-shadow: 0 15px 32px rgba(244,125,53,.28);
        }
        .rc-promo-btn--primary:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(244,125,53,.38); }

        .rc-promo-btn--ghost {
            color: #fff !important;
            border: 1px solid rgba(255,255,255,.22);
            background: rgba(255,255,255,.08);
            backdrop-filter: blur(8px);
        }
        .rc-promo-btn--ghost:hover { transform: translateY(-3px); background: rgba(255,255,255,.13); }

        .rc-promo-trust-row { display: flex; flex-wrap: wrap; gap: 12px 22px; color: rgba(255,255,255,.8); font-size: 13px; font-weight: 800; }
        .rc-promo-trust-row span { display: inline-flex; align-items: center; gap: 7px; }
        .rc-promo-trust-row i { color: var(--rc-green); }

        .rc-promo-offer-card {
            position: relative;
            overflow: hidden;
            max-width: 440px;
            margin-inline-start: auto;
            padding: 35px;
            border-radius: 34px;
            border: 1px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.1);
            box-shadow: 0 35px 75px rgba(0,0,0,.22);
            backdrop-filter: blur(18px);
        }

        .rc-promo-offer-card__glow {
            position: absolute;
            width: 210px;
            height: 210px;
            border-radius: 50%;
            top: -115px;
            left: -95px;
            background: rgba(244,125,53,.28);
        }

        .rc-promo-offer-card__eyebrow {
            position: relative;
            z-index: 1;
            display: inline-flex;
            padding: 7px 12px;
            border-radius: 999px;
            color: #fff;
            background: rgba(244,125,53,.22);
            border: 1px solid rgba(244,125,53,.32);
            font-size: 11px;
            font-weight: 950;
            letter-spacing: 1px;
        }

        .rc-promo-discount { position: relative; z-index: 1; display: flex; align-items: flex-end; gap: 10px; margin: 19px 0 13px; }
        .rc-promo-discount strong { color: #fff; font-size: clamp(70px, 8vw, 102px); line-height: .86; font-weight: 950; letter-spacing: -5px; }
        .rc-promo-discount span { margin-bottom: 8px; padding: 6px 9px; border-radius: 9px; color: var(--rc-navy); background: var(--rc-green); font-size: 12px; font-weight: 950; }
        .rc-promo-offer-card h2 { position: relative; z-index: 1; margin: 0 0 12px; color: #fff; font-size: 22px; line-height: 1.5; font-weight: 900; }
        .rc-promo-offer-card p { position: relative; z-index: 1; margin: 0 0 22px; color: rgba(255,255,255,.75); line-height: 1.8; font-size: 14px; font-weight: 600; }

        .rc-promo-price-example {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: auto auto 1fr auto auto;
            gap: 8px;
            align-items: center;
            padding: 13px 14px;
            border-radius: 16px;
            background: rgba(3,31,55,.26);
            color: rgba(255,255,255,.76);
            font-size: 11px;
            font-weight: 800;
        }
        .rc-promo-price-example strong { color: #fff; font-size: 15px; }
        .rc-promo-price-example i { text-align: center; color: var(--rc-green); }

        .rc-promo-benefits { padding: 85px 0 65px; background: #f7fafc; }
        .rc-promo-section-heading { max-width: 720px; margin: 0 auto 42px; text-align: center; }
        .rc-promo-section-heading > span { display: inline-block; margin-bottom: 9px; color: var(--rc-orange); font-size: 12px; font-weight: 950; letter-spacing: 1px; }
        .rc-promo-section-heading h2 { margin: 0 0 11px; color: var(--rc-navy); font-size: clamp(29px, 4vw, 43px); line-height: 1.3; font-weight: 950; }
        .rc-promo-section-heading p { margin: 0; color: var(--rc-muted); font-size: 15px; line-height: 1.9; font-weight: 600; }

        .rc-promo-benefit-card {
            height: 100%;
            padding: 25px;
            border-radius: 24px;
            border: 1px solid #e6edf2;
            background: #fff;
            box-shadow: 0 16px 42px rgba(5,55,91,.06);
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
        }
        .rc-promo-benefit-card:hover { transform: translateY(-6px); border-color: rgba(24,199,161,.45); box-shadow: 0 24px 54px rgba(5,55,91,.11); }
        .rc-promo-benefit-card__icon { width: 54px; height: 54px; margin-bottom: 17px; border-radius: 17px; display: inline-flex; align-items: center; justify-content: center; color: var(--rc-blue); background: rgba(11,95,159,.09); font-size: 21px; }
        .rc-promo-benefit-card h3 { margin: 0 0 9px; color: var(--rc-navy); font-size: 18px; font-weight: 900; }
        .rc-promo-benefit-card p { margin: 0; color: var(--rc-muted); font-size: 13px; line-height: 1.85; font-weight: 600; }

        .rc-promo-packages {
            position: relative;
            padding: 88px 0 82px;
            background:
                radial-gradient(circle at 12% 0%, rgba(24,199,161,.12), transparent 25%),
                linear-gradient(135deg, #052F51, #073F73 55%, #0B5F9F);
        }
        .rc-promo-section-heading--light h2 { color: #fff; }
        .rc-promo-section-heading--light p { color: rgba(255,255,255,.7); }
        .rc-promo-section-heading--light > span { color: #79E7CD; }

        .rc-promo-package-card {
            position: relative;
            width: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 29px;
            border-radius: 28px;
            border: 1px solid rgba(255,255,255,.15);
            background: #fff;
            box-shadow: 0 28px 65px rgba(0,0,0,.18);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .rc-promo-package-card:hover { transform: translateY(-7px); box-shadow: 0 35px 75px rgba(0,0,0,.25); }
        .rc-promo-package-card__badge { position: absolute; top: 17px; left: 17px; padding: 7px 11px; border-radius: 999px; color: #fff; background: linear-gradient(135deg, var(--rc-orange), var(--rc-orange-dark)); font-size: 12px; font-weight: 950; box-shadow: 0 9px 22px rgba(244,125,53,.25); }
        .rc-promo-page[dir="ltr"] .rc-promo-package-card__badge { left: auto; right: 17px; }
        .rc-promo-package-card__icon { width: 55px; height: 55px; margin-bottom: 18px; border-radius: 18px; display: inline-flex; align-items: center; justify-content: center; color: #fff; background: linear-gradient(135deg, var(--rc-blue), var(--rc-blue-dark)); box-shadow: 0 14px 25px rgba(11,95,159,.2); font-size: 21px; }
        .rc-promo-package-card h3 { text-align: right; margin: 0 0 9px; padding-inline-end: 50px; color: var(--rc-navy); font-size: 21px; line-height: 1.4; font-weight: 950; }
        .rc-promo-package-card__description {text-align: right; min-height: 48px; margin: 0 0 17px; color: var(--rc-muted); line-height: 1.8; font-size: 13px; font-weight: 600; }

        .rc-promo-package-card__pricing { margin: 4px 0 16px; padding: 16px; border-radius: 19px; background: #f5f8fa; }
        .rc-promo-old-price { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 8px; color: #8a9aa7; font-size: 12px; font-weight: 700; }
        .rc-promo-old-price del { color: #a4afb8; }
        .rc-promo-new-price { display: flex; align-items: baseline; gap: 6px; color: var(--rc-orange); }
        .rc-promo-new-price span { margin-inline-end: auto; color: var(--rc-text); font-size: 12px; font-weight: 900; }
        .rc-promo-new-price strong { font-size: 34px; line-height: 1; font-weight: 950; letter-spacing: -1px; }
        .rc-promo-new-price small { color: var(--rc-orange); font-size: 12px; font-weight: 900; }

        .rc-promo-package-card__reach {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            padding: 14px;
            border-radius: 16px;
            color: #08765f;
            background: rgba(24,199,161,.09);
            border: 1px solid rgba(24,199,161,.18);
        }
        .rc-promo-package-card__reach-icon {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            color: #fff;
            background: linear-gradient(135deg, var(--rc-green), #0da889);
            box-shadow: 0 10px 20px rgba(24,199,161,.2);
        }
        .rc-promo-package-card__reach small,
        .rc-promo-package-card__reach strong { display: block; }
        .rc-promo-package-card__reach small { margin-bottom: 2px; color: #548076; font-size: 11px; font-weight: 800; }
        .rc-promo-package-card__reach strong { color: #08765f; font-size: 16px; font-weight: 950; }
        .rc-promo-package-card__benefits { list-style: none; margin: 0 0 22px; padding: 0; }
        .rc-promo-package-card__benefits li { display: flex; align-items: center; gap: 9px; margin-bottom: 9px; color: var(--rc-text); font-size: 12px; font-weight: 750; }
        .rc-promo-package-card__benefits i { width: 21px; height: 21px; flex: 0 0 21px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; color: #08765f; background: rgba(24,199,161,.12); font-size: 9px; }
        .rc-promo-package-card__action { margin-top: auto; }
        .rc-promo-package-card__action form { margin: 0; }

        .rc-promo-package-btn {
            width: 100%;
            min-height: 52px;
            padding: 11px 15px;
            border: 0;
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            cursor: pointer;
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-orange), var(--rc-orange-dark));
            box-shadow: 0 14px 28px rgba(244,125,53,.22);
            text-decoration: none !important;
            font-size: 13px;
            font-weight: 950;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .rc-promo-package-btn:hover { transform: translateY(-2px); box-shadow: 0 18px 34px rgba(244,125,53,.3); }
        .rc-promo-package-btn--disabled { cursor: not-allowed; color: #7d8b96 !important; background: #edf1f4; box-shadow: none; }
        .rc-promo-package-btn--disabled:hover { transform: none; box-shadow: none; }
        .rc-promo-page[dir="rtl"] .rc-promo-arrow-ltr,
        .rc-promo-page[dir="ltr"] .rc-promo-arrow-rtl { display: none; }

        .rc-promo-empty { max-width: 620px; margin: 0 auto; padding: 38px; border-radius: 25px; text-align: center; color: #fff; border: 1px solid rgba(255,255,255,.15); background: rgba(255,255,255,.08); }
        .rc-promo-empty i { font-size: 36px; color: var(--rc-green); margin-bottom: 14px; }
        .rc-promo-empty h3 { color: #fff; font-size: 20px; }
        .rc-promo-empty a { color: #fff; text-decoration: underline; font-weight: 900; }

        .rc-promo-note { max-width: 900px; margin: 25px auto 0; display: flex; align-items: flex-start; gap: 12px; padding: 15px 17px; border-radius: 17px; color: rgba(255,255,255,.74); background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1); }
        .rc-promo-note i { margin-top: 5px; color: var(--rc-green); }
        .rc-promo-note p { margin: 0; font-size: 12px; line-height: 1.8; font-weight: 650; }

        .rc-promo-final-cta { padding: 75px 0; background: #f7fafc; }
        .rc-promo-final-cta__card { display: flex; align-items: center; justify-content: space-between; gap: 30px; padding: 38px 42px; border-radius: 30px; color: #fff; background: linear-gradient(135deg, var(--rc-orange), #DE4A29); box-shadow: 0 25px 58px rgba(222,74,41,.2); }
        .rc-promo-final-cta__card > div > span { display: block; margin-bottom: 7px; color: rgba(255,255,255,.79); font-size: 12px; font-weight: 900; }
        .rc-promo-final-cta__card h2 { margin: 0 0 8px; color: #fff; font-size: 27px; line-height: 1.4; font-weight: 950; }
        .rc-promo-final-cta__card p { margin: 0; color: rgba(255,255,255,.82); font-size: 14px; font-weight: 600; }
        .rc-promo-btn--white { flex-shrink: 0; color: var(--rc-orange-dark) !important; background: #fff; box-shadow: 0 16px 34px rgba(0,0,0,.14); }
        .rc-promo-btn--white:hover { transform: translateY(-3px); }

        @media (max-width: 991.98px) {
            .rc-promo-hero { padding: 65px 0; }
            .rc-promo-hero__content { margin-bottom: 42px; }
            .rc-promo-offer-card { max-width: 600px; margin: 0; }
            .rc-promo-final-cta__card { flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 767.98px) {
            .rc-promo-hero { min-height: auto; padding: 52px 0; }
            .rc-promo-hero h1 { font-size: 43px; letter-spacing: -1px; }
            .rc-promo-hero__lead { font-size: 15px; }
            .rc-promo-hero__actions { align-items: stretch; flex-direction: column; }
            .rc-promo-btn { width: 100%; }
            .rc-promo-offer-card { padding: 26px; border-radius: 26px; }
            .rc-promo-discount strong { font-size: 76px; }
            .rc-promo-benefits, .rc-promo-packages { padding: 60px 0 48px; }
            .rc-promo-section-heading { margin-bottom: 30px; }
            .rc-promo-final-cta { padding: 50px 0; }
            .rc-promo-final-cta__card { padding: 29px 24px; border-radius: 24px; }
            .rc-promo-final-cta__card h2 { font-size: 23px; }
        }

        @media (max-width: 480px) {
            .rc-promo-hero h1 { font-size: 37px; }
            .rc-promo-price-example { grid-template-columns: auto auto; }
            .rc-promo-price-example i { display: none; }
            .rc-promo-package-card { padding: 23px; border-radius: 23px; }
        }

        @media (prefers-reduced-motion: reduce) {
            .rc-promo-page * { scroll-behavior: auto !important; transition: none !important; }
        }
    </style>
</x-layout>
