<x-layout>
    @section('title')
        تسجيل دخول
    @endsection

    <section id="register" class="login-page bg-light" dir="rtl">
        <div class="login-bg-shape login-bg-shape-one"></div>
        <div class="login-bg-shape login-bg-shape-two"></div>

        <div class="container login-container" id="login-form">
            <div class="row align-items-center justify-content-center min-vh-100 py-5">
                <div class="col-xl-10 col-lg-11">
                    <div class="login-shell">
                        <div class="login-brand-panel">


                            <div class="brand-content">
                                 <h1>سجّل دخولك لإدارة حسابك بسهولة</h1>
                                <p>
                                    واجهة حديثة وسريعة تساعدك على الوصول إلى لوحة التحكم ومتابعة بياناتك بأمان.
                                </p>
                            </div>

                            <div class="brand-features">
                                <div class="brand-feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>تسجيل آمن وسريع</span>
                                </div>
                                <div class="brand-feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span> بوابتك الذكية لعالم العقارات </span>
                                </div>
                                <div class="brand-feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>  كل فرصك العقارية في مكان واحد </span>
                                </div>

                                <div class="brand-feature-item">
                                    <span class="feature-icon">✓</span>
                                    <span>  عقاراتك، عملاؤك، مبيعاتك… في نظام واحد </span>
                                </div>


                            </div>
                        </div>

                        <div class="login-card-panel">
                            <div class="login-card-header">
                                <span class="login-card-kicker">تسجيل الدخول</span>
                                <h2>أدخل بيانات حسابك</h2>
                                <p>استخدم البريد الإلكتروني أو رقم الهاتف وكلمة المرور الخاصة بك.</p>
                            </div>

                            @if (session('status'))
                                <div class="login-alert login-alert-success mb-4 font-medium text-sm text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <x-jet-validation-errors class="mb-4 error-box" />

                            <form method="POST" action="{{ route('customLoginManual' , Config::get('app.locale') ) }}" class="login-form">
                                @csrf

                                <div class="form-group login-form-group">
                                    <label for="exampleInputEmail1">البريد الإلكتروني / الهاتف</label>
                                    <div class="login-input-wrap">
                                        <span class="input-leading-icon fa fa-user"></span>
                                        <input
                                            type="text"
                                            name="email"
                                            :value="old('email')"
                                            required
                                            class="form-control login-input"
                                            id="exampleInputEmail1"
                                            aria-describedby="emailHelp"
                                            placeholder="email or phone"
                                            oninvalid="this.setCustomValidity('Please enter a valid phone or email')"
                                            oninput="this.setCustomValidity('')"
                                            pattern="^(?:01\d{9}|[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})$"
                                        />
                                    </div>
                                </div>

                                <div class="form-group login-form-group">
                                    <label for="exampleInputPassword1">كلمة المرور</label>
                                    <div class="login-input-wrap">
                                        <span class="input-leading-icon fa fa-lock"></span>
                                        <input
                                            type="password"
                                            name="password"
                                            required
                                            class="form-control login-input passwordInput"
                                            id="exampleInputPassword1"
                                            placeholder="كلمة المرور"
                                        >
                                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </div>
                                </div>

                                <div class="login-options-row">
                                    <div class="remember-box">
                                        <input name="remember" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            تذكرني
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="forgot-link underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                            نسيت كلمة المرور؟
                                        </a>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary login-submit-btn">
                                    الدخول
                                </button>

                                <p class="register-link-wrap">
                                    <span>ليس لديك حساب؟</span>
                                    <a href="{{ route('user.register', Config::get('app.locale')) }} ">
                                        مستخدم جديد
                                    </a>
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <x-adv-slider/>

    <style>
        #register.login-page {
            --brand-primary: #0b4d8f;
            --brand-primary-dark: #06345f;
            --brand-primary-soft: #e9f3ff;
            --brand-secondary: #f6a619;
            --brand-secondary-dark: #d88900;
            --brand-ink: #102033;
            --brand-muted: #667085;
            --brand-border: #dbe7f3;
            --brand-card: rgba(255, 255, 255, 0.96);

            position: relative;
            overflow: hidden;
            min-height: 100vh;
            background:
                radial-gradient(circle at top right, rgba(246, 166, 25, 0.18), transparent 34%),
                radial-gradient(circle at bottom left, rgba(11, 77, 143, 0.16), transparent 36%),
                linear-gradient(135deg, #f8fbff 0%, #eef6ff 48%, #ffffff 100%);
            font-family: inherit;
        }

        #register .login-bg-shape {
            position: absolute;
            border-radius: 999px;
            filter: blur(2px);
            opacity: 0.58;
            pointer-events: none;
        }

        #register .login-bg-shape-one {
            width: 290px;
            height: 290px;
            top: -110px;
            left: 8%;
            background: rgba(11, 77, 143, 0.14);
        }

        #register .login-bg-shape-two {
            width: 220px;
            height: 220px;
            right: -70px;
            bottom: 12%;
            background: rgba(246, 166, 25, 0.16);
        }

        #register .login-container {
            position: relative;
            z-index: 1;
        }

        #register .login-shell {
            display: grid;
            grid-template-columns: minmax(310px, 0.9fr) minmax(340px, 1fr);
            overflow: hidden;
            border: 1px solid rgba(219, 231, 243, 0.9);
            border-radius: 32px;
            background: rgba(255, 255, 255, 0.72);
            box-shadow: 0 28px 80px rgba(16, 32, 51, 0.16);
            backdrop-filter: blur(14px);
        }

        #register .login-brand-panel {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 620px;
            padding: 48px 42px;
            color: #ffffff;
            background:
                linear-gradient(145deg, rgba(6, 52, 95, 0.96), rgba(11, 77, 143, 0.92)),
                radial-gradient(circle at top left, rgba(246, 166, 25, 0.24), transparent 42%);
        }

        #register .login-brand-panel::after {
            content: '';
            position: absolute;
            width: 240px;
            height: 240px;
            left: -92px;
            bottom: -76px;
            border: 36px solid rgba(246, 166, 25, 0.22);
            border-radius: 50%;
        }

        #register .brand-badge {
            position: relative;
            z-index: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 74px;
            height: 74px;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.22), 0 18px 32px rgba(0, 0, 0, 0.12);
            color: #ffffff;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        #register .brand-content,
        #register .brand-features {
            position: relative;
            z-index: 1;
        }

        #register .brand-eyebrow,
        #register .login-card-kicker {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            margin-bottom: 14px;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.2px;
        }

        #register .brand-eyebrow {
            color: #fff4da;
            background: rgba(246, 166, 25, 0.16);
            border: 1px solid rgba(246, 166, 25, 0.25);
        }

        #register .brand-content h1 {
            margin: 0 0 18px;
            color: #ffffff;
            font-size: 38px;
            font-weight: 900;
            line-height: 1.35;
        }

        #register .brand-content p {
            max-width: 420px;
            margin: 0;
            color: rgba(255, 255, 255, 0.78);
            font-size: 16px;
            line-height: 1.9;
        }

        #register .brand-features {
            display: grid;
            gap: 14px;
        }

        #register .brand-feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 14px;
            border: 1px solid rgba(255, 255, 255, 0.14);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.09);
            color: rgba(255, 255, 255, 0.9);
            font-weight: 700;
        }

        #register .feature-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 28px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--brand-secondary);
            color: var(--brand-primary-dark);
            font-weight: 900;
        }

        #register .login-card-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 56px 58px;
            background: var(--brand-card);
        }

        #register .login-card-header {
            margin-bottom: 30px;
            text-align: right;
        }

        #register .login-card-kicker {
            color: var(--brand-primary);
            background: var(--brand-primary-soft);
        }

        #register .login-card-header h2 {
            margin: 0 0 10px;
            color: var(--brand-ink);
            font-size: 31px;
            font-weight: 900;
        }

        #register .login-card-header p {
            margin: 0;
            color: var(--brand-muted);
            font-size: 15px;
            line-height: 1.8;
        }

        #register .login-alert {
            padding: 14px 16px;
            border-radius: 16px;
            border: 1px solid #b9efcc;
            background: #ecfff3;
            color: #117b3d;
        }

        #register .error-box {
            overflow: hidden;
            border-radius: 16px;
        }

        #register .login-form-group {
            margin-bottom: 20px;
        }

        #register .login-form-group label {
            display: block;
            margin-bottom: 9px;
            color: var(--brand-ink);
            font-size: 14px;
            font-weight: 800;
        }

        #register .login-input-wrap {
            position: relative;
        }

        #register .input-leading-icon {
            position: absolute;
            top: 50%;
            right: 18px;
            z-index: 3;
            transform: translateY(-50%);
            color: var(--brand-primary);
            font-size: 15px;
        }

        #register .login-input {
            height: 56px;
            padding: 12px 48px 12px 48px;
            border: 1px solid var(--brand-border);
            border-radius: 17px;
            background: #f8fbff;
            color: var(--brand-ink);
            font-size: 15px;
            font-weight: 600;
            box-shadow: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        #register .login-input::placeholder {
            color: #9aa8b8;
            font-weight: 500;
        }

        #register .login-input:focus {
            border-color: rgba(11, 77, 143, 0.58);
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(11, 77, 143, 0.11);
        }

        #register .field-icon {
            position: absolute;
            top: 50%;
            left: 18px;
            z-index: 4;
            float: none;
            margin: 0;
            transform: translateY(-50%);
            color: #8797aa;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        #register .field-icon:hover {
            color: var(--brand-primary);
        }

        #register .login-options-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 4px 0 26px;
        }

        #register .remember-box {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--brand-muted);
            font-size: 14px;
            font-weight: 700;
        }

        #register .remember-box .form-check-input {
            position: static;
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: var(--brand-primary);
            cursor: pointer;
        }

        #register .remember-box label {
            margin: 0;
            cursor: pointer;
        }

        #register .forgot-link {
            color: var(--brand-primary);
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        #register .forgot-link:hover {
            color: var(--brand-secondary-dark);
            text-decoration: none;
        }

        #register .login-submit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 56px;
            border: 0;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--brand-primary) 0%, var(--brand-primary-dark) 100%);
            color: #ffffff;
            font-size: 16px;
            font-weight: 900;
            box-shadow: 0 16px 34px rgba(11, 77, 143, 0.25);
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }

        #register .login-submit-btn:hover,
        #register .login-submit-btn:focus {
            color: #ffffff;
            transform: translateY(-2px);
            filter: brightness(1.04);
            box-shadow: 0 20px 40px rgba(11, 77, 143, 0.31);
        }

        #register .register-link-wrap {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 24px 0 0;
            color: var(--brand-muted);
            text-align: center;
            font-size: 14px;
            font-weight: 700;
        }

        #register .register-link-wrap a {
            color: var(--brand-secondary-dark);
            font-weight: 900;
            text-decoration: none;
        }

        #register .register-link-wrap a:hover {
            color: var(--brand-primary);
            text-decoration: none;
        }

        @media (max-width: 991px) {
            #register .login-shell {
                grid-template-columns: 1fr;
                border-radius: 26px;
            }

            #register .login-brand-panel {
                min-height: auto;
                padding: 36px 28px;
                gap: 34px;
            }

            #register .brand-content h1 {
                font-size: 30px;
            }

            #register .brand-features {
                grid-template-columns: 1fr;
            }

            #register .login-card-panel {
                padding: 38px 28px;
            }
        }

        @media (max-width: 575px) {
            #register .row.min-vh-100 {
                min-height: auto !important;
            }

            #register .login-container {
                padding-left: 14px;
                padding-right: 14px;
            }

            #register .login-shell {
                border-radius: 22px;
            }

            #register .login-brand-panel {
                padding: 30px 22px;
            }

            #register .brand-badge {
                width: 62px;
                height: 62px;
                border-radius: 20px;
                font-size: 22px;
            }

            #register .brand-content h1,
            #register .login-card-header h2 {
                font-size: 25px;
            }

            #register .login-card-panel {
                padding: 32px 20px;
            }

            #register .login-options-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</x-layout>
