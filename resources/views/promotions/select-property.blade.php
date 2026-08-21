<x-layout>
    @section('title')
        {{ App::isLocale('en') ? 'Choose the property to promote' : 'اختر العقار الذي تريد تمييزه' }}
    @endsection

    @php
        $locale = Config::get('app.locale') ?: app()->getLocale();
        $isEnglish = App::isLocale('en');
        $discountMultiplier = (100 - $discountPercent) / 100;
        $discountedPrice = round((float) $pricing->price * $discountMultiplier, 2);
        $packageName = $isEnglish && !empty($pricing->name_en)
            ? $pricing->name_en
            : $pricing->name;
    @endphp

    <main class="rc-property-picker" dir="{{ $isEnglish ? 'ltr' : 'rtl' }}">
        <section class="rc-property-picker__hero">
            <div class="container">
                <a href="{{ route('sell-faster.index', ['locale' => $locale]) }}" class="rc-property-picker__back">
                    <i class="fas {{ $isEnglish ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                    {{ $isEnglish ? 'Back to packages' : 'الرجوع إلى الباقات' }}
                </a>

                <div class="rc-property-picker__heading">
                    <span>{{ $isEnglish ? 'STEP 2 OF 3' : 'الخطوة 2 من 3' }}</span>
                    <h1>{{ $isEnglish ? 'Which property do you want to promote?' : 'عايز تميّز أنهي عقار؟' }}</h1>
                    <p>
                        {{ $isEnglish
                            ? 'Choose one of your properties. The promotion package will increase its exposure and help more interested buyers discover it faster.'
                            : 'اختار عقار من عقاراتك. باقة التمييز هتزود ظهوره وتساعد مشترين مهتمين أكتر يشوفوه بشكل أسرع.' }}
                    </p>
                </div>

                <div class="rc-selected-package">
                    <div>
                        <small>{{ $isEnglish ? 'Selected package' : 'الباقة المختارة' }}</small>
                        <strong>{{ $packageName }}</strong>
                    </div>
                    <div class="rc-selected-package__views">
                        <i class="fas fa-eye"></i>
                        {{ number_format((int) $pricing->views) }}
                        {{ $isEnglish ? 'expected views' : 'مشاهدة متوقعة' }}
                    </div>
                    <div class="rc-selected-package__metric">
                        <strong>{{ $pricing->duration_days }}</strong>
                        <span>{{ $isEnglish ? 'days promotion' : 'يوم تمييز' }}</span>
                    </div>
                    <div class="rc-selected-package__price">
                        <del>{{ number_format((float) $pricing->price, 2) }}</del>
                        <strong>{{ number_format($discountedPrice, 2) }}</strong>
                        <span>{{ $isEnglish ? 'EGP' : 'ج.م' }}</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="rc-property-picker__content">
            <div class="container">
                @if($errors->any())
                    <div class="rc-property-picker__error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                @if($properties->isEmpty())
                    <div class="rc-property-picker__empty">
                        <div class="rc-property-picker__empty-icon"><i class="fas fa-home"></i></div>
                        <h2>{{ $isEnglish ? 'You do not have any published properties' : 'لا توجد عقارات منشورة متاحة للتمييز' }}</h2>
                        <p>{{ $isEnglish ? 'Wait until your property is reviewed and published, then return to choose a promotion package.' : 'انتظر حتى تتم مراجعة عقارك ونشره، وبعدها ارجع لاختيار باقة التمييز.' }}</p>
                        <a href="{{ url($locale . '/aqars/create') }}" class="rc-property-picker__primary-btn">
                            <i class="fas fa-plus"></i>
                            {{ $isEnglish ? 'Add a property' : 'أضف عقارك الآن' }}
                        </a>
                    </div>
                @else
                    <form
                        action="{{ route('sell-faster.select-property', ['locale' => $locale, 'pricing' => $pricing->id]) }}"
                        method="POST"
                        id="property-selection-form"
                        novalidate
                    >
                        @csrf

                        <div class="rc-property-picker__toolbar">
                            <div>
                                <span>{{ $isEnglish ? 'Your properties' : 'عقاراتك' }}</span>
                                <strong>{{ $properties->count() }}</strong>
                            </div>
                            <p>{{ $isEnglish ? 'Select one property to continue' : 'اختار عقار واحد علشان تكمل الاشتراك' }}</p>
                        </div>

                        <div
                            id="property-selection-error"
                            class="rc-property-picker__error rc-property-picker__error--selection"
                            role="alert"
                            aria-live="polite"
                            hidden
                        >
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $isEnglish ? 'Please select one property before continuing.' : 'من فضلك اختر عقارًا واحدًا على الأقل قبل المتابعة.' }}
                        </div>

                        <div class="row">
                            @foreach($properties as $property)
                                @php
                                    $propertyTitle = $isEnglish && !empty($property->title_en)
                                        ? $property->title_en
                                        : $property->title;
                                    $propertyImage = $property->mainImage
                                        ? url('/images/' . $property->mainImage->img_url)
                                        : ($property->firstImage
                                            ? url('/images/' . $property->firstImage->img_url)
                                            : 'https://rightchoice-co.com/images/FBO.png');
                                    $propertyLocation = collect([
                                        optional($property->governrateq)->governrate,
                                        optional($property->districte)->district,
                                    ])->filter()->implode('، ');
                                @endphp

                                <div class="col-xl-4 col-lg-4 col-md-6 mb-4 d-flex">
                                    <div
                                        class="rc-property-card{{ (string) old('aqar_id') === (string) $property->id ? ' is-selected' : '' }}"
                                        role="radio"
                                        tabindex="0"
                                        aria-checked="{{ (string) old('aqar_id') === (string) $property->id ? 'true' : 'false' }}"
                                    >
                                        <input
                                            type="radio"
                                            name="aqar_id"
                                            value="{{ $property->id }}"
                                            required
                                            aria-describedby="property-selection-error"
                                            {{ (string) old('aqar_id') === (string) $property->id ? 'checked' : '' }}
                                        >

                                        <span class="rc-property-card__check"><i class="fas fa-check"></i></span>

                                        <span class="rc-property-card__selected-badge">
                                            <i class="fas fa-check-circle"></i>
                                            {{ $isEnglish ? 'Selected property' : 'العقار المختار' }}
                                        </span>

                                        <span class="rc-property-card__image">
                                            <img src="{{ $propertyImage }}" alt="{{ $propertyTitle }}" loading="lazy">
                                            <span class="rc-property-card__views">
                                                <i class="fas fa-eye"></i>
                                                {{ number_format((int) $property->views) }}
                                            </span>
                                        </span>

                                        <span class="rc-property-card__body">
                                            <strong>{{ \Illuminate\Support\Str::limit($propertyTitle, 65) }}</strong>

                                            @if($propertyLocation)
                                                <small>
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ $propertyLocation }}
                                                </small>
                                            @endif

                                            <span class="rc-property-card__meta">
                                                <span><i class="fas fa-ruler-combined"></i>{{ $property->total_area }} {{ $isEnglish ? 'm²' : 'م²' }}</span>
                                                <span><i class="fas fa-bed"></i>{{ $property->rooms ?: 0 }}</span>
                                                <span><i class="fas fa-bath"></i>{{ $property->baths ?: 0 }}</span>
                                            </span>

                                            <span
                                                class="rc-property-card__select-text"
                                                data-default-text="{{ $isEnglish ? 'Select this property' : 'اختار العقار ده' }}"
                                                data-selected-text="{{ $isEnglish ? 'This property is selected' : 'تم اختيار هذا العقار' }}"
                                            >
                                                {{ $isEnglish ? 'Select this property' : 'اختار العقار ده' }}
                                            </span>
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="rc-property-picker__submit">
                            <div>
                                <strong>{{ $isEnglish ? 'Ready to promote your property?' : 'جاهز تميّز عقارك؟' }}</strong>
                                <span>{{ $isEnglish ? 'Select a property, then continue to checkout.' : 'اختار العقار وبعدها كمل إلى صفحة الاشتراك والدفع.' }}</span>
                            </div>
                            <button type="submit" class="rc-property-picker__primary-btn" id="property-selection-submit">
                                {{ $isEnglish ? 'Continue to checkout' : 'متابعة إلى الاشتراك' }}
                                <i class="fas {{ $isEnglish ? 'fa-arrow-right' : 'fa-arrow-left' }}"></i>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </section>
    </main>

    <style>
        .rc-property-picker {
            --picker-navy: #042c4e;
            --picker-blue: #0b5f9f;
            --picker-green: #18c7a1;
            --picker-orange: #f47d35;
            --picker-text: #14324a;
            --picker-muted: #698095;
            min-height: 100vh;
            color: var(--picker-text);
            background: #f5f8fb;
        }
        .rc-property-picker, .rc-property-picker * { box-sizing: border-box; }
        .rc-property-picker__hero {
            padding: 60px 0 95px;
            color: #fff;
            background:
                radial-gradient(circle at 15% 10%, rgba(24,199,161,.2), transparent 27%),
                linear-gradient(135deg, var(--picker-navy), var(--picker-blue));
        }
        .rc-property-picker__back { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 30px; color: rgba(255,255,255,.78) !important; text-decoration: none !important; font-size: 13px; font-weight: 850; }
        .rc-property-picker__heading { max-width: 760px; margin-bottom: 32px; }
        .rc-property-picker__heading > span { display: inline-block; margin-bottom: 10px; color: #83ead3; font-size: 12px; font-weight: 950; letter-spacing: 1px; }
        .rc-property-picker__heading h1 { margin: 0 0 12px; color: #fff; font-size: clamp(32px, 5vw, 54px); font-weight: 950; }
        .rc-property-picker__heading p { margin: 0; color: rgba(255,255,255,.76); font-size: 16px; line-height: 1.9; font-weight: 600; }
        .rc-selected-package { display: flex; align-items: center; gap: 25px; padding: 18px 22px; border: 1px solid rgba(255,255,255,.15); border-radius: 20px; background: rgba(255,255,255,.09); backdrop-filter: blur(10px); }
        .rc-selected-package > div:first-child { margin-inline-end: auto; }
        .rc-selected-package small, .rc-selected-package strong { display: block; }
        .rc-selected-package small { margin-bottom: 3px; color: rgba(255,255,255,.62); font-size: 11px; font-weight: 800; }
        .rc-selected-package strong { color: #fff; font-size: 17px; font-weight: 950; }
        .rc-selected-package__views { display: flex; align-items: center; gap: 8px; color: #bdf5e8; font-size: 13px; font-weight: 850; }
        .rc-selected-package__metric { display: flex; align-items: baseline; gap: 6px; color: #fff; }
        .rc-selected-package__metric strong { font-size: 20px; }
        .rc-selected-package__metric span { color: #bdf5e8; font-size: 12px; font-weight: 800; }
        .rc-selected-package__price { display: flex; align-items: baseline; gap: 7px; }
        .rc-selected-package__price del { color: rgba(255,255,255,.45); font-size: 12px; }
        .rc-selected-package__price strong { color: #fff; font-size: 25px; }
        .rc-selected-package__price span { color: #fff; font-size: 11px; font-weight: 850; }
        .rc-property-picker__content { margin-top: -48px; padding-bottom: 80px; }
        .rc-property-picker__error { max-width: 720px; display: flex; align-items: center; gap: 10px; margin: 0 auto 22px; padding: 14px 17px; color: #a22632; border: 1px solid #f4c7cc; border-radius: 15px; background: #fff1f2; font-weight: 800; }
        .rc-property-picker__error[hidden] { display: none; }
        .rc-property-picker__error--selection { max-width: none; margin-bottom: 20px; }
        .rc-property-picker__toolbar { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 22px; padding: 20px 23px; border: 1px solid #e5edf3; border-radius: 20px; background: #fff; box-shadow: 0 18px 45px rgba(5,55,91,.07); }
        .rc-property-picker__toolbar div { display: flex; align-items: center; gap: 9px; }
        .rc-property-picker__toolbar span, .rc-property-picker__toolbar p { color: var(--picker-muted); font-size: 13px; font-weight: 750; }
        .rc-property-picker__toolbar strong { min-width: 29px; height: 29px; display: inline-flex; align-items: center; justify-content: center; color: #fff; border-radius: 50%; background: var(--picker-green); }
        .rc-property-picker__toolbar p { margin: 0; }
        .rc-property-card { position: relative; overflow: hidden; width: 100%; display: flex; flex-direction: column; margin: 0; border: 2px solid transparent; border-radius: 24px; background: #fff; box-shadow: 0 16px 42px rgba(5,55,91,.08); cursor: pointer; isolation: isolate; transition: transform .22s ease, border-color .22s ease, box-shadow .22s ease, background-color .22s ease; }
        .rc-property-card:hover { transform: translateY(-5px); box-shadow: 0 23px 52px rgba(5,55,91,.13); }
        .rc-property-card.is-selected { border-color: var(--picker-green); background: #f3fffc; box-shadow: 0 23px 55px rgba(24,199,161,.25), 0 0 0 4px rgba(24,199,161,.1); transform: translateY(-4px); }
        .rc-property-card:has(input:checked) { border-color: var(--picker-green); background: #f3fffc; box-shadow: 0 23px 55px rgba(24,199,161,.25), 0 0 0 4px rgba(24,199,161,.1); transform: translateY(-4px); }
        .rc-property-card > input[type="radio"] { position: absolute !important; top: 0 !important; right: auto !important; bottom: auto !important; left: 0 !important; width: 1px !important; height: 1px !important; margin: 0 !important; padding: 0 !important; opacity: 0 !important; clip-path: inset(50%); pointer-events: none; }
        .rc-property-card__check { position: absolute; z-index: 3; top: 14px; inset-inline-start: 14px; width: 31px; height: 31px; display: inline-flex; align-items: center; justify-content: center; color: transparent; border: 2px solid rgba(255,255,255,.85); border-radius: 50%; background: rgba(4,44,78,.35); backdrop-filter: blur(7px); transition: all .2s ease; }
        .rc-property-card input:checked ~ .rc-property-card__check,
        .rc-property-card.is-selected .rc-property-card__check { color: #fff; border-color: #fff; background: var(--picker-green); box-shadow: 0 0 0 4px rgba(24,199,161,.3); }
        .rc-property-card__selected-badge { position: absolute; z-index: 4; top: 16px; inset-inline-end: 14px; display: inline-flex; align-items: center; gap: 6px; padding: 7px 11px; color: #fff; border-radius: 999px; background: #08765f; box-shadow: 0 8px 20px rgba(8,118,95,.28); font-size: 11px; font-weight: 950; opacity: 0; visibility: hidden; transform: translateY(-7px); transition: opacity .2s ease, transform .2s ease, visibility .2s ease; }
        .rc-property-card.is-selected .rc-property-card__selected-badge { opacity: 1; visibility: visible; transform: translateY(0); }
        .rc-property-card__image { position: relative; height: 210px; display: block; overflow: hidden; background: #e8eef3; }
        .rc-property-card__image img { width: 100%; height: 100%; object-fit: cover; transition: transform .35s ease; }
        .rc-property-card:hover .rc-property-card__image img { transform: scale(1.04); }
        .rc-property-card__views { position: absolute; bottom: 12px; inset-inline-end: 12px; display: inline-flex; align-items: center; gap: 6px; padding: 7px 10px; color: #fff; border-radius: 999px; background: rgba(4,44,78,.78); font-size: 11px; font-weight: 850; backdrop-filter: blur(7px); }
        .rc-property-card__body { position: relative; z-index: 1; flex: 1; display: flex; flex-direction: column; padding: 19px; opacity: 1; visibility: visible; }
        .rc-property-card__body > strong { min-height: 48px; margin-bottom: 7px; color: var(--picker-navy); font-size: 17px; line-height: 1.5; font-weight: 950; }
        .rc-property-card__body > small { display: flex; align-items: center; gap: 6px; margin-bottom: 15px; color: var(--picker-muted); font-size: 12px; }
        .rc-property-card__body > small i { color: var(--picker-orange); }
        .rc-property-card__meta { display: flex; gap: 8px; margin-bottom: 17px; }
        .rc-property-card__meta > span { display: inline-flex; align-items: center; gap: 5px; padding: 6px 8px; color: var(--picker-muted); border-radius: 9px; background: #f2f6f9; font-size: 11px; font-weight: 800; }
        .rc-property-card__meta i { color: var(--picker-blue); }
        .rc-property-card__select-text { margin-top: auto; padding-top: 14px; color: var(--picker-blue); border-top: 1px solid #edf1f4; text-align: center; font-size: 12px; font-weight: 950; }
        .rc-property-card input:checked ~ .rc-property-card__body .rc-property-card__select-text,
        .rc-property-card.is-selected .rc-property-card__select-text { color: #fff; border-color: transparent; border-radius: 11px; background: #08765f; }
        .rc-property-picker__submit { position: sticky; z-index: 10; bottom: 15px; display: flex; align-items: center; justify-content: space-between; gap: 25px; margin-top: 15px; padding: 20px 23px; color: #fff; border-radius: 21px; background: linear-gradient(135deg, var(--picker-navy), var(--picker-blue)); box-shadow: 0 22px 50px rgba(4,44,78,.25); }
        .rc-property-picker__submit strong, .rc-property-picker__submit span { display: block; }
        .rc-property-picker__submit strong { margin-bottom: 3px; font-size: 15px; font-weight: 950; }
        .rc-property-picker__submit span { color: rgba(255,255,255,.68); font-size: 12px; }
        .rc-property-picker__primary-btn { min-height: 50px; display: inline-flex; align-items: center; justify-content: center; gap: 9px; padding: 12px 20px; color: #fff !important; border: 0; border-radius: 15px; background: linear-gradient(135deg, var(--picker-orange), #e75a28); box-shadow: 0 13px 27px rgba(244,125,53,.24); text-decoration: none !important; font-size: 13px; font-weight: 950; cursor: pointer; }
        .rc-property-picker__empty { max-width: 690px; margin: 0 auto; padding: 50px 30px; border: 1px solid #e3ebf1; border-radius: 28px; background: #fff; box-shadow: 0 24px 60px rgba(5,55,91,.1); text-align: center; }
        .rc-property-picker__empty-icon { width: 75px; height: 75px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 18px; color: var(--picker-blue); border-radius: 23px; background: rgba(11,95,159,.09); font-size: 27px; }
        .rc-property-picker__empty h2 { margin: 0 0 10px; color: var(--picker-navy); font-size: 25px; font-weight: 950; }
        .rc-property-picker__empty p { margin: 0 0 22px; color: var(--picker-muted); line-height: 1.8; }
        @media (max-width: 767.98px) {
            .rc-property-picker__hero { padding: 45px 0 82px; }
            .rc-selected-package { align-items: flex-start; flex-direction: column; gap: 13px; }
            .rc-selected-package > div:first-child { margin: 0; }
            .rc-property-picker__toolbar { align-items: flex-start; flex-direction: column; }
            .rc-property-picker__submit { align-items: stretch; flex-direction: column; }
            .rc-property-picker__submit .rc-property-picker__primary-btn { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) {
            .rc-property-picker * { transition: none !important; }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var form = document.getElementById('property-selection-form');

            if (!form) {
                return;
            }

            var propertyInputs = Array.prototype.slice.call(
                form.querySelectorAll('input[name="aqar_id"]')
            );
            var selectionError = document.getElementById('property-selection-error');

            function updateSelectedProperty(selectedInput) {
                propertyInputs.forEach(function (input) {
                    if (selectedInput && input !== selectedInput) {
                        input.checked = false;
                    }

                    var card = input.closest('.rc-property-card');
                    var selectText = card ? card.querySelector('.rc-property-card__select-text') : null;

                    if (!card) {
                        return;
                    }

                    card.classList.toggle('is-selected', input.checked);
                    card.setAttribute('aria-checked', input.checked ? 'true' : 'false');

                    if (selectText) {
                        selectText.textContent = input.checked
                            ? selectText.getAttribute('data-selected-text')
                            : selectText.getAttribute('data-default-text');
                    }
                });

                if (propertyInputs.some(function (input) { return input.checked; })) {
                    selectionError.hidden = true;
                }
            }

            propertyInputs.forEach(function (input) {
                var card = input.closest('.rc-property-card');

                input.addEventListener('change', function () {
                    updateSelectedProperty(input);
                });

                if (!card) {
                    return;
                }

                card.addEventListener('click', function () {
                    input.checked = true;
                    updateSelectedProperty(input);
                });

                card.addEventListener('keydown', function (event) {
                    if (event.key !== 'Enter' && event.key !== ' ') {
                        return;
                    }

                    event.preventDefault();
                    input.checked = true;
                    updateSelectedProperty(input);
                });
            });

            form.addEventListener('submit', function (event) {
                var selectedProperty = propertyInputs.find(function (input) {
                    return input.checked;
                });

                if (selectedProperty) {
                    selectionError.hidden = true;
                    return;
                }

                event.preventDefault();
                selectionError.hidden = false;
                selectionError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                propertyInputs[0].focus();
            });

            updateSelectedProperty();
        });
    </script>
</x-layout>
