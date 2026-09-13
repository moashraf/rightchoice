<x-layout>
    @section('title', 'إضافة رقم الهاتف')

    <section class="phone-verification-page" dir="rtl">
        <div class="container">
            <div class="phone-verification-card">
                <div class="phone-verification-icon">
                    <i class="fa fa-mobile" aria-hidden="true"></i>
                </div>

                <h1>أضف رقم هاتفك</h1>
                <p class="phone-verification-description">
                    يلزم إضافة رقم هاتف موثّق قبل إضافة عقار أو الاشتراك في أي باقة.
                </p>

                @if (session('success'))
                    <div class="alert alert-success text-right">{{ session('success') }}</div>
                @endif

                @if (!$pendingPhone)
                    <form method="POST" action="{{ route('phone.request-otp', ['locale' => app()->getLocale()]) }}">
                        @csrf
                        <div class="form-group text-right">
                            <label for="phone">رقم الهاتف</label>
                            <input
                                id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                name="phone"
                                type="tel"
                                inputmode="numeric"
                                value="{{ old('phone', auth()->user()->MOP) }}"
                                placeholder="01XXXXXXXXX"
                                maxlength="11"
                                required
                                autofocus
                            >
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn phone-verification-button" type="submit">
                            إرسال رمز التحقق
                        </button>
                    </form>
                @else
                    <div class="phone-sent-message">
                        تم إرسال رمز التحقق إلى
                        <strong dir="ltr">{{ $pendingPhone }}</strong>
                    </div>

                    <form method="POST" action="{{ route('phone.verify', ['locale' => app()->getLocale()]) }}">
                        @csrf
                        <div class="form-group text-right">
                            <label for="otp">رمز التحقق</label>
                            <input
                                id="otp"
                                class="form-control otp-input @error('otp') is-invalid @enderror"
                                name="otp"
                                type="text"
                                inputmode="numeric"
                                maxlength="4"
                                autocomplete="one-time-code"
                                placeholder="ــــ"
                                required
                                autofocus
                            >
                            @error('otp')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button class="btn phone-verification-button" type="submit">
                            تأكيد وحفظ رقم الهاتف
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <style>
        .phone-verification-page {
            min-height: 560px;
            padding: 80px 15px;
            background: #f7f9fc;
        }

        .phone-verification-card {
            width: 100%;
            max-width: 560px;
            margin: 0 auto;
            padding: 42px;
            text-align: center;
            background: #fff;
            border: 1px solid #e8edf3;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(25, 67, 98, .09);
        }

        .phone-verification-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 66px;
            height: 66px;
            margin: 0 auto 20px;
            color: #fff;
            font-size: 31px;
            background: #1875aa;
            border-radius: 50%;
        }

        .phone-verification-card h1 {
            margin: 0 0 12px;
            color: #253b56;
            font-size: 30px;
            font-weight: 700;
        }

        .phone-verification-description {
            margin-bottom: 28px;
            color: #718096;
            font-size: 16px;
            line-height: 1.8;
        }

        .phone-verification-card label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: 600;
        }

        .phone-verification-card .form-control {
            width: 100%;
            height: 50px;
            padding: 10px 14px;
            color: #26384a;
            font-size: 17px;
            text-align: right;
            border: 1px solid #d8e0e8;
            border-radius: 9px;
            box-shadow: none;
        }

        .phone-verification-card .form-control:focus {
            border-color: #24c4a4;
            box-shadow: 0 0 0 3px rgba(36, 196, 164, .14);
        }

        .phone-verification-card .otp-input {
            direction: ltr;
            text-align: center;
            letter-spacing: 12px;
            font-size: 23px;
            font-weight: 700;
        }

        .phone-verification-button {
            width: 100%;
            margin-top: 10px;
            padding: 12px 20px;
            color: #fff !important;
            font-size: 16px;
            font-weight: 600;
            background: #1875aa;
            border: 0;
            border-radius: 9px;
            transition: background .2s ease, transform .2s ease;
        }

        .phone-verification-button:hover,
        .phone-verification-button:focus {
            color: #fff !important;
            background: #125f8b;
            transform: translateY(-1px);
        }

        .phone-sent-message {
            margin-bottom: 24px;
            padding: 13px 16px;
            color: #236b5d;
            background: #eafaf6;
            border: 1px solid #c8efe5;
            border-radius: 9px;
        }

        .phone-sent-message strong {
            display: inline-block;
            margin-right: 4px;
        }

        .phone-verification-card .invalid-feedback {
            margin-top: 7px;
            color: #dc3545;
            text-align: right;
        }

        @media (max-width: 575px) {
            .phone-verification-page {
                min-height: auto;
                padding: 45px 0;
            }

            .phone-verification-card {
                padding: 28px 20px;
                border-radius: 14px;
            }

            .phone-verification-card h1 {
                font-size: 25px;
            }
        }
    </style>
</x-layout>
