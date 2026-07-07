<x-layout>

    @section('title')
        تسجيل مستخدم جديد
    @endsection

    <section id="register" class="rc-register-page" dir="rtl">
        <div class="rc-register-bg-shape rc-register-bg-shape-one"></div>
        <div class="rc-register-bg-shape rc-register-bg-shape-two"></div>

        <div class="container rc-register-container">
            <div class="rc-register-wrapper">
                <div class="row align-items-stretch no-gutters rc-register-row">
                    <div class="col-lg-7 rc-form-column">
                        <div class="rc-form-card">
                            <div class="rc-form-header text-center">
                                <span class="rc-form-badge">Right Choice</span>
                                <h2>{{ trans('langsite.register') }}</h2>
                                <span class="rc-title-line"></span>
                                <p>ابدأ الآن وأنشئ حسابك للوصول إلى أفضل تجربة عقارية بسهولة وأمان.</p>
                            </div>

                            @if (count($errors) > 0)
                                <div class="rc-error-box">
                                    <strong>برجاء مراجعة البيانات التالية:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('custom_register', Config::get('app.locale')) }}" autocomplete="off" class="rc-register-form">
                                @csrf

                                @if(isset($invited_by) && $invited_by)
                                    <input type="hidden" name="invited_by" value="{{ $invited_by }}">
                                @endif

                                <div class="rc-form-grid">
                                    <div class="rc-field">
                                        <label for="name">
                                            الاسم الكامل
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="rc-input-wrap">
                                            <i class="fa fa-user-o rc-input-icon" aria-hidden="true"></i>
                                            <input oninvalid="this.setCustomValidity('   برجاء ادخال    الاسم     ')"
                                                   oninput="this.setCustomValidity('')"
                                                   name="name"
                                                   autocomplete="off"
                                                   value="{{ old('name') }}"
                                                   required
                                                   autofocus
                                                   type="text"
                                                   class="myselect rc-control"
                                                   id="name"
                                                   aria-describedby="">
                                        </div>
                                    </div>

                                    <div class="rc-field">
                                        <label for="email">
                                            البريد الالكتروني
                                        </label>
                                        <div class="rc-input-wrap">
                                            <i class="fa fa-envelope-o rc-input-icon" aria-hidden="true"></i>
                                            <input oninvalid="this.setCustomValidity('   برجاء ادخال    البريد     ')"
                                                   oninput="this.setCustomValidity('')"
                                                   type="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   class="myselect rc-control"
                                                   autocomplete="off"
                                                   id="email"
                                                   aria-describedby="emailHelp">
                                        </div>
                                    </div>

                                    @if(isset($getUserType) && $getUserType)
                                        <div class="rc-field getUserType_getUserType">
                                            <label for="user-type">
                                                نوع المستخدم
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="rc-input-wrap rc-select-wrap">
                                                <i class="fa fa-user-plus rc-input-icon" aria-hidden="true"></i>
                                                <select oninvalid="this.setCustomValidity('   برجاء ادخال  نوع المستخدم    ')"
                                                        oninput="this.setCustomValidity('')"
                                                        autocomplete="off"
                                                        name="TYPE"
                                                        id="user-type"
                                                        class="myselect rc-control">
                                                    <option value="1">أختار</option>
                                                    @foreach($getUserType as $name => $id)
                                                        <option value="{{ $id }}" {{ old('TYPE') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="rc-field">
                                        <label name="phone" for="phone">
                                            رقم الهاتف
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="rc-input-wrap">
                                            <i class="fa fa-phone rc-input-icon" aria-hidden="true"></i>
                                            <input id="phone"
                                                   value="{{ old('MOP') }}"
                                                   type="tel"
                                                   name="MOP"
                                                   inputmode="numeric"
                                                   pattern="01\d{9}"
                                                   maxlength="11"
                                                   required
                                                   class="myselect rc-control"
                                                   placeholder="01012345678"
                                                   oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11); validatePhone(this);"
                                                   oninvalid="this.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم ويبدأ بـ 01')"/>
                                        </div>
                                        <small id="phone-hint" class="rc-help-text">
                                            أدخل 11 رقم يبدأ بـ 01 (مثال: 01012345678)
                                        </small>
                                        <small id="phone-error" class="text-danger rc-help-text" style="display:none;">
                                            <i class="fa fa-exclamation-circle"></i> رقم الهاتف يجب أن يكون 11 رقم ويبدأ بـ 01
                                        </small>
                                    </div>

                                    <div class="rc-extra-fields" id="motwar" style="display:none;">
                                        <div class="rc-field {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">
                                            <label for="employe">
                                                اسم الموظف المسئول
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="rc-input-wrap">
                                                <i class="fa fa-id-badge rc-input-icon" aria-hidden="true"></i>
                                                <input type="text" name="Employee_Name" id="employe" class="form-control rc-control" value="{{ old('Employee_Name') }}">
                                            </div>
                                            <small class="text-danger rc-help-text">{{ $errors->first('Employee_Name') }}</small>
                                        </div>

                                        <div class="rc-field {{ $errors->has('Job_title') ? ' has-error' : '' }}">
                                            <label for="employe-type">
                                                المسمى الوظيفي
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="rc-input-wrap rc-select-wrap">
                                                <i class="fa fa-briefcase rc-input-icon" aria-hidden="true"></i>
                                                <select class="myselect rc-control" name="Job_title" id="employe-type">
                                                    <option value="">اختر</option>
                                                    @foreach($jobs ?? [] as $job)
                                                        <option value="{{ $job->id }}" {{ old('Job_title') == $job->id ? 'selected' : '' }}>
                                                            @if(App::isLocale('en'))
                                                                {{ $job->Job_title_en ?: $job->Job_title }}
                                                            @else
                                                                {{ $job->Job_title }}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <small class="text-danger rc-help-text">{{ $errors->first('Job_title') }}</small>
                                        </div>

                                        <div class="rc-field">
                                            <label for="togary-id">
                                                {{ trans('langsite.company-name') }}
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="rc-input-wrap">
                                                <i class="fa fa-building-o rc-input-icon" aria-hidden="true"></i>
                                                <input type="text" autocomplete="off" name="Commercial_Register" id="togary-id" class="myselect rc-control" value="{{ old('Commercial_Register') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rc-field">
                                        <label for="password">
                                            ادخل كلمه المرور
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="rc-input-wrap">
                                            <i class="fa fa-lock rc-input-icon" aria-hidden="true"></i>
                                            <input oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')"
                                                   oninput="this.setCustomValidity('')"
                                                   minlength="4"
                                                   name="password"
                                                   autocomplete="off"
                                                   required
                                                   type="password"
                                                   class="myselect rc-control passwordInput"
                                                   id="password"
                                                   placeholder="كلمه المرور">
                                            <button type="button" class="rc-password-toggle toggle-password" data-target="#password" aria-label="إظهار أو إخفاء كلمة المرور">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="rc-field">
                                        <label for="password_confirmation">
                                            اعد ادخال كلمه المرور
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="rc-input-wrap">
                                            <i class="fa fa-lock rc-input-icon" aria-hidden="true"></i>
                                            <input oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')"
                                                   oninput="this.setCustomValidity('')"
                                                   minlength="4"
                                                   autocomplete="off"
                                                   name="password_confirmation"
                                                   required
                                                   type="password"
                                                   class="myselect rc-control passwordInput"
                                                   id="password_confirmation"
                                                   placeholder="اعد ادخال كلمه المرور">
                                            <button type="button" class="rc-password-toggle toggle-password" data-target="#password_confirmation" aria-label="إظهار أو إخفاء كلمة المرور">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="rc-terms-box">
                                    <input oninvalid="this.setCustomValidity(' برجاء الضغط علي الموافقه علي الشروط والاحكام       ')"
                                           oninput="this.setCustomValidity('')"
                                           required
                                           type="checkbox"
                                           class="form-check-input"
                                           name="check"
                                           id="check">

                                    <label class="form-check-label" for="check">
                                        اوافق على
                                        <strong>
                                            <a target="_blank" href="{{ url(Config::get('app.locale').'/terms-conditions') }}">شروط و احكام</a>
                                        </strong>
                                        موقع
                                        <span>Right Choice</span>
                                        <span id="termsCheckLabel"></span>
                                    </label>
                                </div>

                                <button type="submit" class="btn our-btn rc-submit-btn">
                                    سجل
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </button>

                                <div class="rc-secure-note">
                                    <i class="fa fa-shield" aria-hidden="true"></i>
                                    بياناتك آمنة ولن يتم مشاركتها مع أي طرف ثالث
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-5 rc-promo-column">
                        <div class="rc-promo-card">
                            <div class="rc-promo-overlay"></div>
                            <div class="rc-logo-badge">
                                <img src="https://rightchoice-co.com/assets/img/rclogo.png" alt="Right Choice logo">
                            </div>

                            <div class="rc-promo-content">
                                <h3>
                                    مرحباً بك في
                                    <span>رايت تشويز</span>
                                </h3>
                                <span class="rc-promo-line"></span>
                                <p>
                                    رايت تشويز لإدارة الأصول العقارية، موقع متكامل يتيح التواصل المباشر بين البائع والمشتري بدون عمولة وبدون وسيط مع توفير مجموعة متميزة من أفضل الشركات لبيع الأثاث المنزلي والمكتبي وبيع الأجهزة الكهربائية والالكترونية وخدمات شركات نقل الأثاث.
                                </p>
                            </div>

                            <div class="rc-promo-footer">
                                <div>
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    <span>www.rightchoice-co.com</span>
                                </div>
                                <div>
                                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                    <span>info@rightchoice-co.com</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--    {!! NoCaptcha::renderJs() !!}--}}

    <style>
        :root {
            --rc-blue: #0B5F9F;
            --rc-blue-dark: #073F73;
            --rc-teal: #18C7A1;
            --rc-teal-dark: #0A9C8E;
            --rc-mint: #63E2BF;
            --rc-text: #163A5C;
            --rc-muted: #7D8EA7;
            --rc-border: #DCE6F2;
            --rc-soft: #F3F8FC;
            --rc-danger: #ff4b5f;
        }

        #register.rc-register-page {
            position: relative;
            overflow: hidden;
            min-height: calc(100vh - 80px);
            padding: 70px 0 85px;
            background:
                radial-gradient(circle at 15% 20%, rgba(24, 199, 161, 0.14), transparent 30%),
                radial-gradient(circle at 90% 10%, rgba(11, 95, 159, 0.12), transparent 32%),
                linear-gradient(135deg, #F7FBFF 0%, #EEF6FC 100%);
            color: var(--rc-text);
        }

        .rc-register-bg-shape {
            position: absolute;
            border-radius: 999px;
            filter: blur(2px);
            pointer-events: none;
            z-index: 0;
        }

        .rc-register-bg-shape-one {
            width: 330px;
            height: 330px;
            right: -115px;
            top: 120px;
            background: rgba(24, 199, 161, 0.10);
        }

        .rc-register-bg-shape-two {
            width: 440px;
            height: 440px;
            left: -180px;
            bottom: -180px;
            background: rgba(11, 95, 159, 0.10);
        }

        .rc-register-container {
            position: relative;
            z-index: 1;
        }

        .rc-register-wrapper {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.85);
            border-radius: 28px;
            padding: 16px;
            box-shadow: 0 24px 70px rgba(22, 58, 92, 0.12);
            backdrop-filter: blur(14px);
        }

        .rc-register-row {
            gap: 0;
        }

        .rc-form-column,
        .rc-promo-column {
            padding: 10px;
        }

        .rc-form-card,
        .rc-promo-card {
            min-height: 100%;
            border-radius: 24px;
        }

        .rc-form-card {
            background: #fff;
            padding: 42px 42px 34px;
            box-shadow: 0 18px 45px rgba(20, 74, 116, 0.10);
            border: 1px solid rgba(220, 230, 242, 0.9);
        }

        .rc-form-header {
            margin-bottom: 32px;
        }

        .rc-form-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            padding: 6px 18px;
            border-radius: 999px;
            color: var(--rc-teal-dark);
            background: rgba(24, 199, 161, 0.10);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .2px;
            margin-bottom: 13px;
        }

        .rc-form-header h2 {
            margin: 0;
            color: var(--rc-blue-dark);
            font-weight: 800;
            font-size: 34px;
            line-height: 1.35;
        }

        .rc-title-line {
            display: block;
            width: 78px;
            height: 4px;
            border-radius: 999px;
            margin: 14px auto 14px;
            background: linear-gradient(90deg, var(--rc-teal), var(--rc-blue));
            position: relative;
        }

        .rc-title-line:before,
        .rc-title-line:after {
            content: '';
            position: absolute;
            top: 0;
            width: 5px;
            height: 4px;
            border-radius: 999px;
            background: var(--rc-teal);
        }

        .rc-title-line:before { right: -12px; }
        .rc-title-line:after { left: -12px; }

        .rc-form-header p {
            max-width: 520px;
            margin: 0 auto;
            color: var(--rc-muted);
            font-size: 15px;
            line-height: 1.8;
        }

        .rc-error-box {
            background: rgba(255, 75, 95, 0.08);
            border: 1px solid rgba(255, 75, 95, 0.22);
            border-radius: 16px;
            color: #ba2135;
            padding: 16px 18px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .rc-error-box ul {
            margin: 8px 0 0;
            padding-right: 20px;
        }

        .rc-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px 24px;
        }

        .rc-field {
            position: relative;
        }

        .rc-field label {
            display: block;
            margin-bottom: 9px;
            color: var(--rc-blue-dark);
            font-weight: 700;
            font-size: 14px;
        }

        .rc-field .text-danger,
        .text-danger {
            color: var(--rc-danger) !important;
        }

        .rc-input-wrap {
            position: relative;
        }

        .rc-input-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6A7D99;
            font-size: 18px;
            z-index: 2;
            pointer-events: none;
        }

        .rc-control,
        .rc-field .myselect,
        .rc-field .form-control {
            width: 100% !important;
            height: 56px;
            border: 1px solid var(--rc-border) !important;
            border-radius: 13px !important;
            background: #fff !important;
            color: var(--rc-text) !important;
            padding: 0 48px 0 16px !important;
            font-size: 14px;
            font-weight: 500;
            outline: none !important;
            box-shadow: 0 8px 18px rgba(20, 74, 116, 0.04) !important;
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease;
            direction: rtl;
        }

        .rc-control::placeholder {
            color: #9BA9BB;
        }

        .rc-control:focus,
        .rc-field .myselect:focus,
        .rc-field .form-control:focus {
            border-color: var(--rc-teal) !important;
            box-shadow: 0 0 0 4px rgba(24, 199, 161, .12), 0 12px 24px rgba(20, 74, 116, 0.08) !important;
        }

        .rc-select-wrap select.rc-control {
            appearance: auto;
            cursor: pointer;
        }

        .rc-help-text {
            display: block;
            margin-top: 8px;
            color: var(--rc-muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .rc-extra-fields {
            grid-column: 1 / -1;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            padding: 20px;
            border-radius: 18px;
            border: 1px dashed rgba(11, 95, 159, 0.20);
            background: linear-gradient(135deg, rgba(11, 95, 159, 0.04), rgba(24, 199, 161, 0.05));
        }

        #motwar[style*="display:none"] {
            display: none !important;
        }

        .rc-password-toggle {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: 0;
            background: transparent;
            color: #6A7D99;
            width: 34px;
            height: 34px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background .2s ease, color .2s ease;
        }

        .rc-password-toggle:hover {
            background: rgba(11, 95, 159, 0.08);
            color: var(--rc-blue);
        }

        .rc-terms-box {
            margin: 30px 0 20px;
            padding: 16px 18px;
            border-radius: 16px;
            background: var(--rc-soft);
            border: 1px solid rgba(220, 230, 242, 0.86);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .rc-terms-box input[type="checkbox"] {
            position: static;
            margin: 0;
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
            cursor: pointer;
            accent-color: var(--rc-teal);
        }

        .rc-terms-box label {
            margin: 0;
            color: var(--rc-text);
            font-size: 14px;
            line-height: 1.8;
            cursor: pointer;
        }

        .rc-terms-box a {
            color: var(--rc-teal-dark);
            text-decoration: none;
        }

        .rc-terms-box a:hover {
            color: var(--rc-blue);
            text-decoration: underline;
        }

        .rc-terms-box span {
            color: var(--rc-blue);
            font-weight: 700;
        }

        .rc-submit-btn,
        .our-btn.rc-submit-btn {
            width: 100%;
            min-height: 58px;
            border: 0 !important;
            border-radius: 14px !important;
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-blue), var(--rc-blue-dark)) !important;
            box-shadow: 0 16px 28px rgba(11, 95, 159, 0.26) !important;
            font-size: 19px;
            font-weight: 800;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        .rc-submit-btn:hover,
        .our-btn.rc-submit-btn:hover {
            transform: translateY(-2px);
            filter: brightness(1.03);
            box-shadow: 0 20px 34px rgba(11, 95, 159, 0.32) !important;
        }

        .rc-secure-note {
            margin-top: 17px;
            color: var(--rc-muted);
            font-size: 13px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .rc-secure-note i {
            color: var(--rc-blue);
        }

        .rc-promo-card {
            position: relative;
            overflow: hidden;
            padding: 42px 38px;
            min-height: 690px;
            background-image: linear-gradient(160deg, rgba(7, 63, 115, .93), rgba(11, 95, 159, .82)), url('{{ asset('/images/03 (1).jpg') }}');
            background-size: cover;
            background-position: center;
            box-shadow: 0 18px 45px rgba(7, 63, 115, 0.20);
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .rc-promo-card:before,
        .rc-promo-card:after {
            content: '';
            position: absolute;
            border-radius: 50%;
            z-index: 0;
        }

        .rc-promo-card:before {
            width: 460px;
            height: 460px;
            right: -230px;
            bottom: -250px;
            background: rgba(24, 199, 161, 0.75);
        }

        .rc-promo-card:after {
            width: 360px;
            height: 360px;
            right: -160px;
            bottom: -190px;
            background: rgba(99, 226, 191, 0.45);
        }

        .rc-promo-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(3, 27, 52, .08), rgba(3, 27, 52, .28));
            z-index: 0;
        }

        .rc-logo-badge,
        .rc-promo-content,
        .rc-promo-footer {
            position: relative;
            z-index: 1;
        }

        .rc-logo-badge {
            width: 168px;
            height: 168px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .94);
            color: var(--rc-blue);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 18px 44px rgba(0,0,0,.18);
            margin-bottom: 28px;
        }

        .rc-logo-badge img {
            width: 126px;
            max-width: 78%;
            height: auto;
            display: block;
        }

        .rc-promo-content {
            max-width: 430px;
            margin-top: auto;
            margin-bottom: auto;
        }

        .rc-promo-content h3 {
            margin: 0;
            color: #fff;
            font-size: 40px;
            font-weight: 900;
            line-height: 1.38;
        }

        .rc-promo-content h3 span {
            display: block;
            color: var(--rc-mint);
        }

        .rc-promo-line {
            display: block;
            width: 92px;
            height: 4px;
            margin: 20px 0 24px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--rc-teal), rgba(255,255,255,.9));
        }

        .rc-promo-content p {
            margin: 0;
            color: rgba(255,255,255,.92);
            font-size: 16px;
            line-height: 2;
            font-weight: 500;
        }

        .rc-promo-footer {
            display: grid;
            gap: 12px;
            margin-top: 36px;
        }

        .rc-promo-footer div {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.93);
            font-size: 14px;
            direction: ltr;
            justify-content: flex-end;
        }

        .rc-promo-footer i {
            color: var(--rc-mint);
            font-size: 17px;
        }

        #phone.is-valid-phone {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 4px rgba(40, 167, 69, .10) !important;
        }

        #phone.is-invalid-phone {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, .10) !important;
        }

        @media (max-width: 991.98px) {
            #register.rc-register-page {
                padding: 42px 0 58px;
            }

            .rc-register-wrapper {
                padding: 10px;
                border-radius: 22px;
            }

            .rc-promo-card {
                min-height: 480px;
                margin-top: 10px;
            }

            .rc-form-card {
                padding: 34px 24px 28px;
            }
        }

        @media (max-width: 767.98px) {
            .rc-form-grid,
            .rc-extra-fields {
                grid-template-columns: 1fr;
            }

            .rc-form-header h2 {
                font-size: 28px;
            }

            .rc-promo-content h3 {
                font-size: 32px;
            }

            .rc-promo-card {
                padding: 34px 26px;
            }
        }
    </style>

    <script>
        function validatePhone(input) {
            var val = input.value;
            var hint  = document.getElementById('phone-hint');
            var error = document.getElementById('phone-error');
            if (val.length === 0) {
                input.classList.remove('is-valid-phone','is-invalid-phone');
                hint.style.display  = 'block';
                error.style.display = 'none';
                input.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم ويبدأ بـ 01');
            } else if (!val.startsWith('01')) {
                input.classList.remove('is-valid-phone');
                input.classList.add('is-invalid-phone');
                hint.style.display  = 'none';
                error.style.display = 'block';
                error.innerHTML = '<i class="fa fa-exclamation-circle"></i> رقم الهاتف يجب أن يبدأ بـ 01';
                input.setCustomValidity('رقم الهاتف يجب أن يبدأ بـ 01');
            } else if (val.length < 11) {
                input.classList.remove('is-valid-phone');
                input.classList.add('is-invalid-phone');
                hint.style.display  = 'none';
                error.style.display = 'block';
                error.innerHTML = '<i class="fa fa-exclamation-circle"></i> أدخلت ' + val.length + ' أرقام — مطلوب 11 رقم';
                input.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم');
            } else {
                input.classList.remove('is-invalid-phone');
                input.classList.add('is-valid-phone');
                hint.style.display  = 'none';
                error.style.display = 'none';
                input.setCustomValidity('');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            var phone = document.getElementById('phone');
            if (phone && phone.value.length > 0) validatePhone(phone);

            document.querySelectorAll('.rc-password-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    var targetSelector = button.getAttribute('data-target');
                    var input = document.querySelector(targetSelector);
                    var icon = button.querySelector('i');
                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        if (icon) {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        }
                    } else {
                        input.type = 'password';
                        if (icon) {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                });
            });
        });
    </script>

</x-layout>
