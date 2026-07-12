<x-layout>

    @section('title')
        الصفحه الشخصيه
    @endsection

    <style>
        #profile-info.rc-profile-page {
            --rc-blue: #0878a9;
            --rc-blue-dark: #075985;
            --rc-blue-soft: #eaf6fb;
            --rc-green: #62b447;
            --rc-green-dark: #438c31;
            --rc-ink: #17324d;
            --rc-muted: #6b7f91;
            --rc-border: #dce9ef;
            --rc-surface: #ffffff;
            --rc-bg: #f4f9fb;
            position: relative;
            min-height: 100vh;
            padding: 42px 0 64px;
            overflow: hidden;
            background:
                radial-gradient(circle at 8% 10%, rgba(98, 180, 71, .10), transparent 28%),
                radial-gradient(circle at 92% 5%, rgba(8, 120, 169, .12), transparent 30%),
                linear-gradient(180deg, #f8fcfe 0%, var(--rc-bg) 100%);
            color: var(--rc-ink);
            direction: rtl;
        }

        #profile-info.rc-profile-page::before,
        #profile-info.rc-profile-page::after {
            content: "";
            position: absolute;
            border-radius: 999px;
            pointer-events: none;
            filter: blur(2px);
        }

        #profile-info.rc-profile-page::before {
            width: 240px;
            height: 240px;
            top: -120px;
            right: -90px;
            border: 34px solid rgba(8, 120, 169, .07);
        }

        #profile-info.rc-profile-page::after {
            width: 180px;
            height: 180px;
            left: -80px;
            bottom: 60px;
            border: 28px solid rgba(98, 180, 71, .08);
        }

        #profile-info .container,
        #profile-info .main-body {
            position: relative;
            z-index: 1;
        }

        #profile-info .rc-page-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        #profile-info .rc-page-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        #profile-info .rc-page-icon,
        #profile-info .rc-section-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
            color: #fff;
            background: linear-gradient(135deg, var(--rc-blue), var(--rc-green));
            box-shadow: 0 10px 26px rgba(8, 120, 169, .22);
        }

        #profile-info .rc-page-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
        }

        #profile-info .rc-page-heading h1 {
            margin: 0 0 4px;
            color: var(--rc-ink);
            font-size: clamp(24px, 3vw, 34px);
            font-weight: 800;
            line-height: 1.25;
        }

        #profile-info .rc-page-heading p {
            margin: 0;
            color: var(--rc-muted);
            font-size: 14px;
        }

        #profile-info .rc-security-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid rgba(98, 180, 71, .25);
            border-radius: 999px;
            background: rgba(255, 255, 255, .78);
            color: var(--rc-green-dark);
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 8px 24px rgba(23, 50, 77, .06);
            backdrop-filter: blur(8px);
        }

        #profile-info .rc-profile-layout {
            align-items: flex-start;
            margin-right: -12px;
            margin-left: -12px;
        }

        #profile-info .rc-profile-layout > [class*="col-"] {
            padding-right: 12px;
            padding-left: 12px;
        }

        #profile-info .rc-main-card,
        #profile-info .rc-profile-layout .rc-sidebar-column .card {
            overflow: hidden;
            border: 1px solid rgba(220, 233, 239, .95) !important;
            border-radius: 24px !important;
            background: rgba(255, 255, 255, .96) !important;
            box-shadow: 0 20px 55px rgba(26, 74, 101, .10) !important;
        }

        #profile-info .rc-main-card {
            margin-bottom: 0;
        }

        #profile-info .rc-main-card > .card-body {
            padding: 0;
        }

        #profile-info .rc-card-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 26px 30px;
            overflow: hidden;
            background: linear-gradient(135deg, rgba(8, 120, 169, .98), rgba(7, 89, 133, .96));
            color: #fff;
        }

        #profile-info .rc-card-hero::after {
            content: "";
            position: absolute;
            width: 210px;
            height: 210px;
            left: -65px;
            bottom: -135px;
            border-radius: 50%;
            border: 28px solid rgba(255, 255, 255, .08);
        }

        #profile-info .rc-card-hero-copy,
        #profile-info .rc-card-hero-mark {
            position: relative;
            z-index: 1;
        }

        #profile-info .rc-card-hero h2 {
            margin: 0 0 7px;
            font-size: 21px;
            font-weight: 800;
        }

        #profile-info .rc-card-hero p {
            margin: 0;
            color: rgba(255, 255, 255, .78);
            font-size: 13px;
        }

        #profile-info .rc-card-hero-mark {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 12px;
            background: rgba(255, 255, 255, .12);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        #profile-info .rc-profile-form {
            padding: 30px;
        }

        #profile-info .rc-form-section + .rc-form-section {
            margin-top: 26px;
            padding-top: 26px;
            border-top: 1px solid var(--rc-border);
        }

        #profile-info .rc-section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        #profile-info .rc-section-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(8, 120, 169, .16);
        }

        #profile-info .rc-section-heading h3 {
            margin: 0 0 2px;
            color: var(--rc-ink);
            font-size: 17px;
            font-weight: 800;
        }

        #profile-info .rc-section-heading p {
            margin: 0;
            color: var(--rc-muted);
            font-size: 12px;
        }

        #profile-info .rc-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        #profile-info .rc-form-field.rc-full-width {
            grid-column: 1 / -1;
        }

        #profile-info .rc-profile-form .form-group {
            margin-bottom: 0;
        }

        #profile-info .rc-profile-form label {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
            color: #27465f;
            font-size: 13px;
            font-weight: 800;
        }

        #profile-info .rc-profile-form .myselect {
            width: 100%;
            min-height: 48px!important;
            padding: 10px 14px;
            border: 1px solid var(--rc-border);
            border-radius: 13px;
            outline: none;
            background-color: #fbfdfe;
            color: var(--rc-ink);
            font-size: 14px;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        #profile-info .rc-profile-form select.myselect {
            cursor: pointer;
        }

        #profile-info .rc-profile-form .myselect:focus {
            border-color: rgba(8, 120, 169, .65);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(8, 120, 169, .10);
        }

        #profile-info .rc-profile-form .myselect[readonly],
        #profile-info .rc-profile-form .myselect:disabled {
            cursor: not-allowed;
            border-color: #e4edf1;
            background: #f3f7f9;
            color: #7c8e9c;
        }

        #profile-info .rc-field-note {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 7px;
            color: var(--rc-muted);
            font-size: 11px;
        }

        #profile-info .rc-profile-form .text-danger {
            display: block;
            margin-top: 6px;
            font-size: 11px;
        }

        #profile-info .has-error .myselect {
            border-color: #dc5365;
            box-shadow: 0 0 0 4px rgba(220, 83, 101, .08);
        }

        #profile-info .rc-upload-box {
            display: grid;
            grid-template-columns: 170px minmax(0, 1fr);
            align-items: center;
            gap: 22px;
            padding: 18px;
            border: 1px dashed rgba(8, 120, 169, .35);
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(234, 246, 251, .72), rgba(246, 252, 244, .78));
        }

        #profile-info .rc-current-photo {
            position: relative;
            width: 170px;
            height: 150px;
            overflow: hidden;
            border: 5px solid #fff;
            border-radius: 18px;
            background: #eaf3f7;
            box-shadow: 0 12px 28px rgba(23, 50, 77, .14);
        }

        #profile-info .rc-current-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #profile-info .rc-photo-placeholder {
            display: flex;
            width: 100%;
            height: 100%;
            align-items: center;
            justify-content: center;
            color: var(--rc-blue);
            background: linear-gradient(135deg, var(--rc-blue-soft), #eff8ec);
        }

        #profile-info .rc-upload-content h4 {
            margin: 0 0 6px;
            color: var(--rc-ink);
            font-size: 16px;
            font-weight: 800;
        }

        #profile-info .rc-upload-content p {
            margin: 0 0 14px;
            color: var(--rc-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        #profile-info .rc-file-control {
            position: relative;
            display: inline-flex;
            max-width: 100%;
            align-items: center;
            gap: 10px;
        }

        #profile-info .rc-file-input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            opacity: 0;
            pointer-events: none;
        }

        #profile-info .rc-file-label {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            margin: 0 !important;
            padding: 10px 16px;
            cursor: pointer;
            border: 1px solid rgba(8, 120, 169, .25);
            border-radius: 12px;
            background: #fff;
            color: var(--rc-blue) !important;
            box-shadow: 0 8px 18px rgba(8, 120, 169, .08);
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        #profile-info .rc-file-label:hover {
            transform: translateY(-1px);
            border-color: var(--rc-blue);
            box-shadow: 0 10px 22px rgba(8, 120, 169, .13);
        }

        #profile-info .rc-file-name {
            max-width: 220px;
            overflow: hidden;
            color: var(--rc-muted);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #profile-info .rc-password-card {
            overflow: hidden;
            border: 1px solid var(--rc-border);
            border-radius: 18px;
            background: #fbfdfe;
        }

        #profile-info .rc-password-card .accordion-button {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 18px 20px;
            border: 0;
            outline: 0;
            background: transparent;
            color: var(--rc-ink);
            text-align: right;
            box-shadow: none;
        }

        #profile-info .rc-password-card .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, rgba(234, 246, 251, .85), rgba(246, 252, 244, .9));
            color: var(--rc-blue-dark);
        }

        #profile-info .rc-password-title {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        #profile-info .rc-password-title strong {
            display: block;
            margin-bottom: 2px;
            font-size: 14px;
        }

        #profile-info .rc-password-title small {
            display: block;
            color: var(--rc-muted);
            font-size: 11px;
            font-weight: 500;
        }

        #profile-info .rc-password-body {
            padding: 20px;
            border-top: 1px solid var(--rc-border);
        }

        #profile-info .rc-password-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        #profile-info .rc-password-grid .rc-current-password {
            grid-column: 1 / -1;
        }

        #profile-info .rc-password-input-wrap {
            position: relative;
        }

        #profile-info .rc-password-input-wrap .myselect {
            padding-left: 48px;
        }

        #profile-info .password-visibility-toggle {
            position: absolute;
            top: 50%;
            left: 14px;
            display: inline-flex;
            width: 28px;
            height: 28px;
            align-items: center;
            justify-content: center;
            padding: 0;
            cursor: pointer;
            border: 0;
            border-radius: 8px;
            background: transparent;
            color: #7890a0;
            transform: translateY(-50%);
            transition: background-color .2s ease, color .2s ease;
        }

        #profile-info .password-visibility-toggle:hover {
            background: var(--rc-blue-soft);
            color: var(--rc-blue);
        }

        #profile-info .rc-form-actions {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            margin-top: 28px;
        }

        #profile-info .rc-submit-btn {
            display: inline-flex;
            min-width: 150px;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 11px 24px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--rc-blue), var(--rc-blue-dark));
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 12px 26px rgba(8, 120, 169, .24);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        #profile-info .rc-submit-btn:hover,
        #profile-info .rc-submit-btn:focus {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 32px rgba(8, 120, 169, .30);
        }

        #profile-info .rc-form-action-note {
            color: var(--rc-muted);
            font-size: 11px;
        }

        /* تنسيق الكمبوننت الجانبي الموجود بالفعل دون تغيير ملفه */
        #profile-info .rc-sidebar-column > [class*="col-"] {
            flex: 0 0 100%;
            width: 100%;
            max-width: 100%;
            padding: 0;
        }

        #profile-info .rc-sidebar-column .card {
            margin-bottom: 22px !important;
        }

        #profile-info .rc-sidebar-column .card-body {
            padding: 24px !important;
        }

        #profile-info .rc-sidebar-column img.rounded-circle,
        #profile-info .rc-sidebar-column .rounded-circle img,
        #profile-info .rc-sidebar-column img[style*="border-radius"] {
            border: 5px solid #fff !important;
            box-shadow: 0 0 0 3px rgba(8, 120, 169, .16), 0 12px 28px rgba(23, 50, 77, .16) !important;
        }

        #profile-info .rc-sidebar-column hr {
            border-top-color: var(--rc-border);
        }

        #profile-info .rc-sidebar-column .btn,
        #profile-info .rc-sidebar-column a[class*="btn"] {
            border-radius: 10px !important;
            font-weight: 700;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        #profile-info .rc-sidebar-column .btn:hover,
        #profile-info .rc-sidebar-column a[class*="btn"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 16px rgba(23, 50, 77, .10);
        }

        #profile-info .rc-sidebar-column .card img:not(.rounded-circle) {
            max-width: 100%;
        }

        @media (max-width: 991.98px) {
            #profile-info.rc-profile-page {
                padding-top: 28px;
            }

            #profile-info .rc-sidebar-column {
                margin-bottom: 24px;
            }

            #profile-info .rc-sidebar-column .card,
            #profile-info .rc-main-card {
                border-radius: 20px !important;
            }
        }

        @media (max-width: 767.98px) {
            #profile-info .rc-page-heading,
            #profile-info .rc-card-hero {
                align-items: flex-start;
                flex-direction: column;
            }

            #profile-info .rc-security-badge,
            #profile-info .rc-card-hero-mark {
                align-self: stretch;
                justify-content: center;
            }

            #profile-info .rc-profile-form,
            #profile-info .rc-card-hero {
                padding: 22px;
            }

            #profile-info .rc-form-grid,
            #profile-info .rc-password-grid {
                grid-template-columns: 1fr;
            }

            #profile-info .rc-form-field.rc-full-width,
            #profile-info .rc-password-grid .rc-current-password {
                grid-column: auto;
            }

            #profile-info .rc-upload-box {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
            }

            #profile-info .rc-upload-content {
                width: 100%;
            }

            #profile-info .rc-file-control {
                justify-content: center;
                flex-wrap: wrap;
            }

            #profile-info .rc-form-actions {
                align-items: stretch;
                flex-direction: column;
            }

            #profile-info .rc-submit-btn {
                width: 100%;
            }
        }

        @media (max-width: 479.98px) {
            #profile-info.rc-profile-page {
                padding: 20px 0 40px;
            }

            #profile-info .rc-page-icon {
                width: 46px;
                height: 46px;
                border-radius: 14px;
            }

            #profile-info .rc-profile-form,
            #profile-info .rc-card-hero {
                padding: 18px;
            }

            #profile-info .rc-current-photo {
                width: 145px;
                height: 135px;
            }
        }
    </style>

    <section id="profile-info" class="rc-profile-page bg-light" dir="rtl">
        <div class="container">
            <div class="main-body">

                <div class="rc-page-heading">
                    <div class="rc-page-title-wrap">
                        <span class="rc-page-icon" aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21a8 8 0 0 0-16 0"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </span>
                        <div>
                            <h1>الملف الشخصي</h1>
                            <p>حدّث بيانات حسابك وصورتك الشخصية بأمان.</p>
                        </div>
                    </div>

                    <span class="rc-security-badge">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                            <path d="m9 12 2 2 4-4"></path>
                        </svg>
                        بياناتك محفوظة بأمان
                    </span>
                </div>

                <div class="row rc-profile-layout">
                    <div class="col-lg-8 order-2 order-lg-1 rc-form-column">
                        <div class="card rc-main-card">
                            <div class="card-body">
                                <div class="rc-card-hero">
                                    <div class="rc-card-hero-copy">
                                        <h2>تعديل بيانات الحساب</h2>
                                        <p>تأكد من صحة البيانات قبل حفظ التعديلات.</p>
                                    </div>

                                    <span class="rc-card-hero-mark">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M12 20h9"></path>
                                            <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                        </svg>
                                        حسابي
                                    </span>
                                </div>

                                <form class="rc-profile-form"
                                      action="{{ URL::to('updatedProfileUser') }}"
                                      enctype="multipart/form-data"
                                      method="POST">
                                    @csrf

                                    <div class="rc-form-section">
                                        <div class="rc-section-heading">
                                            <span class="rc-section-icon" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                                    <circle cx="12" cy="7" r="4"></circle>
                                                </svg>
                                            </span>
                                            <div>
                                                <h3>المعلومات الأساسية</h3>
                                                <p>البيانات المستخدمة للتعريف بحسابك.</p>
                                            </div>
                                        </div>

                                        <div class="rc-form-grid">
                                            <div class="form-group rc-form-field {{ $errors->has('name') ? 'has-error' : '' }}">
                                                <label for="profile-name">
                                                    الاسم كاملاً <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                       name="name"
                                                       class="myselect"
                                                       id="profile-name"
                                                       value="{{ Auth::user()->name }}"
                                                       placeholder="اكتب الاسم كاملاً">
                                                <small class="text-danger">{{ $errors->first('name') }}</small>
                                            </div>

                                            <div class="form-group rc-form-field {{ $errors->has('email') ? 'has-error' : '' }}">
                                                <label for="profile-email">
                                                    البريد الإلكتروني <span class="text-danger">*</span>
                                                </label>
                                                <input readonly
                                                       type="email"
                                                       name="email"
                                                       class="myselect"
                                                       id="profile-email"
                                                       value="{{ Auth::user()->email }}">
                                                <span class="rc-field-note">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                    </svg>
                                                    لا يمكن تعديل البريد الإلكتروني من هذه الصفحة.
                                                </span>
                                                <small class="text-danger">{{ $errors->first('email') }}</small>
                                            </div>

                                            <div class="form-group rc-form-field {{ $errors->has('MOP') ? 'has-error' : '' }}">
                                                <label for="profile-phone">الهاتف</label>
                                                <input minlength="9"
                                                       maxlength="18"
                                                       type="text"
                                                       class="myselect"
                                                       readonly
                                                       id="profile-phone"
                                                       value="{{ Auth::user()->MOP }}">
                                                <span class="rc-field-note">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                                    </svg>
                                                    لا يمكن تغيير رقم الهاتف من لوحة التحكم.
                                                </span>
                                                <small class="text-danger">{{ $errors->first('MOP') }}</small>
                                            </div>

                                            @if(Auth::user()->TYPE != 3)
                                                <div class="form-group rc-form-field {{ $errors->has('AGE') ? 'has-error' : '' }}">
                                                    <label for="profile-age">
                                                        العمر <span class="text-danger">*</span>
                                                    </label>
                                                    <select id="profile-age" name="AGE" class="myselect">
                                                        <option value="">اختر الفئة العمرية</option>
                                                        <option value="1" {{ Auth::user()->AGE == 1 ? 'selected' : '' }}>من 18 إلى 25</option>
                                                        <option value="2" {{ Auth::user()->AGE == 2 ? 'selected' : '' }}>من 26 إلى 35</option>
                                                        <option value="3" {{ Auth::user()->AGE == 4 ? 'selected' : '' }}>من 36 إلى 45</option>
                                                        <option value="4" {{ Auth::user()->AGE == 4 ? 'selected' : '' }}>من 46 إلى 60</option>
                                                        <option value="5" {{ Auth::user()->AGE == 5 ? 'selected' : '' }}>أكثر من 60</option>
                                                    </select>
                                                    <small class="text-danger">{{ $errors->first('AGE') }}</small>
                                                </div>
                                            @endif

                                            <div class="form-group rc-form-field {{ $errors->has('TYPE') ? 'has-error' : '' }}">
                                                <label for="user-type">
                                                    نوع المستخدم <span class="text-danger">*</span>
                                                </label>
                                                <select disabled id="user-type" name="TYPE" class="myselect">
                                                    <option @if(Auth::user()->TYPE == 3) readonly @endif
                                                    value="1" {{ Auth::user()->TYPE == 1 ? 'selected' : '' }}>
                                                        بائع
                                                    </option>
                                                    <option @if(Auth::user()->TYPE == 3) readonly @endif
                                                    value="2" {{ Auth::user()->TYPE == 2 ? 'selected' : '' }}>
                                                        مشتري
                                                    </option>
                                                    <option @if(Auth::user()->TYPE != 3) readonly @endif
                                                    value="3" {{ Auth::user()->TYPE == 3 ? 'selected' : '' }}>
                                                        مطور عقاري
                                                    </option>
                                                </select>
                                                <span class="rc-field-note">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <line x1="12" y1="16" x2="12" y2="12"></line>
                                                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                                                    </svg>
                                                    نوع الحساب ثابت ولا يمكن تغييره من هنا.
                                                </span>
                                                <small class="text-danger">{{ $errors->first('TYPE') }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rc-form-section">
                                        <div class="rc-section-heading">
                                            <span class="rc-section-icon" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                                    <polyline points="21 15 16 10 5 21"></polyline>
                                                </svg>
                                            </span>
                                            <div>
                                                <h3>الصورة الشخصية</h3>
                                                <p>استخدم صورة واضحة بجودة مناسبة.</p>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('img') ? 'has-error' : '' }}">
                                            <div class="rc-upload-box">
                                                <div class="rc-current-photo" id="profile-image-preview-wrap">
                                                    @if(!empty(Auth::user()->profile_image))
                                                        <a href="{{ URL::to('/').'/'.Auth::user()->profile_image }}"
                                                           data-toggle="lightbox">
                                                            <img id="profile-image-preview"
                                                                 src="{{ URL::to('/').'/'.Auth::user()->profile_image }}"
                                                                 alt="الصورة الشخصية"
                                                                 loading="lazy">
                                                        </a>
                                                    @else
                                                        <div class="rc-photo-placeholder" id="profile-image-placeholder">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                                                <circle cx="12" cy="13" r="4"></circle>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="rc-upload-content">
                                                    <h4>اختيار صورة جديدة</h4>
                                                    <p>يفضل استخدام صورة مربعة بصيغة JPG أو PNG لتظهر بشكل أفضل داخل حسابك.</p>

                                                    <div class="rc-file-control">
                                                        <input type="file"
                                                               id="upload_file"
                                                               name="img"
                                                               class="rc-file-input"
                                                               accept="image/png,image/jpeg,image/jpg,image/webp">
                                                        <label class="rc-file-label" for="upload_file">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                                <polyline points="17 8 12 3 7 8"></polyline>
                                                                <line x1="12" y1="3" x2="12" y2="15"></line>
                                                            </svg>
                                                            رفع صورة
                                                        </label>
                                                        <span class="rc-file-name" id="selected-file-name">لم يتم اختيار ملف</span>
                                                    </div>

                                                    <small class="text-danger">{{ $errors->first('img') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rc-form-section">
                                        <div class="rc-section-heading">
                                            <span class="rc-section-icon" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                </svg>
                                            </span>
                                            <div>
                                                <h3>الأمان وكلمة المرور</h3>
                                                <p>غيّر كلمة المرور عند الحاجة فقط.</p>
                                            </div>
                                        </div>

                                        <div class="accordion rc-password-card" id="accordionExample">
                                            <div class="accordion-item border-0 bg-transparent">
                                                <button class="accordion-button collapsed"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne"
                                                        aria-expanded="false"
                                                        aria-controls="collapseOne">
                                                    <span class="rc-password-title">
                                                        <span class="rc-section-icon" aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M12 20h9"></path>
                                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"></path>
                                                            </svg>
                                                        </span>
                                                        <span>
                                                            <strong>تغيير كلمة المرور</strong>
                                                            <small>اضغط لإظهار حقول كلمة المرور.</small>
                                                        </span>
                                                    </span>
                                                </button>

                                                <div id="collapseOne"
                                                     class="accordion-collapse collapse"
                                                     data-bs-parent="#accordionExample">
                                                    <div class="rc-password-body">
                                                        <div class="rc-password-grid">
                                                            <div class="form-group rc-current-password {{ $errors->has('old_password') ? 'has-error' : '' }}">
                                                                <label for="old_password">كلمة المرور الحالية</label>
                                                                <div class="rc-password-input-wrap">
                                                                    <input type="password"
                                                                           name="old_password"
                                                                           class="myselect"
                                                                           id="old_password"
                                                                           autocomplete="current-password">
                                                                    <button type="button"
                                                                            class="password-visibility-toggle"
                                                                            data-target="old_password"
                                                                            aria-label="إظهار كلمة المرور">
                                                                        <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                        </svg>
                                                                        <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                            <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                            <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                            <path d="M1 1l22 22"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <small class="text-danger">{{ $errors->first('old_password') }}</small>
                                                            </div>

                                                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                                                <label for="password">كلمة المرور الجديدة</label>
                                                                <div class="rc-password-input-wrap">
                                                                    <input type="password"
                                                                           name="password"
                                                                           class="myselect"
                                                                           id="password"
                                                                           autocomplete="new-password">
                                                                    <button type="button"
                                                                            class="password-visibility-toggle"
                                                                            data-target="password"
                                                                            aria-label="إظهار كلمة المرور">
                                                                        <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                        </svg>
                                                                        <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                            <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                            <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                            <path d="M1 1l22 22"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                                <small class="text-danger">{{ $errors->first('password') }}</small>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="password-confirm">تأكيد كلمة المرور الجديدة</label>
                                                                <div class="rc-password-input-wrap">
                                                                    <input type="password"
                                                                           name="password_confirmation"
                                                                           class="myselect"
                                                                           id="password-confirm"
                                                                           autocomplete="new-password">
                                                                    <button type="button"
                                                                            class="password-visibility-toggle"
                                                                            data-target="password-confirm"
                                                                            aria-label="إظهار كلمة المرور">
                                                                        <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                            <circle cx="12" cy="12" r="3"></circle>
                                                                        </svg>
                                                                        <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                            <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                            <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                            <path d="M1 1l22 22"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rc-form-actions">
                                        <button type="submit" class="btn rc-submit-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                                <polyline points="7 3 7 8 15 8"></polyline>
                                            </svg>
                                            حفظ التعديلات
                                        </button>
                                        <span class="rc-form-action-note">سيتم تحديث بيانات حسابك فور الحفظ.</span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 order-1 order-lg-2 rc-sidebar-column">
                        @include('components.profile-sidebar')
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleButtons = document.querySelectorAll('#profile-info .password-visibility-toggle');
            var fileInput = document.getElementById('upload_file');
            var selectedFileName = document.getElementById('selected-file-name');

            toggleButtons.forEach(function (toggleButton) {
                toggleButton.addEventListener('click', function () {
                    var passwordInput = document.getElementById(toggleButton.getAttribute('data-target'));

                    if (!passwordInput) {
                        return;
                    }

                    var eyeIcon = toggleButton.querySelector('[data-eye-icon]');
                    var eyeOffIcon = toggleButton.querySelector('[data-eye-off-icon]');
                    var shouldShowPassword = passwordInput.type === 'password';

                    passwordInput.type = shouldShowPassword ? 'text' : 'password';
                    toggleButton.setAttribute(
                        'aria-label',
                        shouldShowPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'
                    );

                    if (eyeIcon && eyeOffIcon) {
                        eyeIcon.style.display = shouldShowPassword ? 'none' : 'block';
                        eyeOffIcon.style.display = shouldShowPassword ? 'block' : 'none';
                    }
                });
            });

            if (fileInput) {
                fileInput.addEventListener('change', function (event) {
                    var file = event.target.files && event.target.files[0];

                    if (!file) {
                        if (selectedFileName) {
                            selectedFileName.textContent = 'لم يتم اختيار ملف';
                        }
                        return;
                    }

                    if (selectedFileName) {
                        selectedFileName.textContent = file.name;
                    }

                    if (!file.type || file.type.indexOf('image/') !== 0) {
                        return;
                    }

                    var reader = new FileReader();
                    reader.onload = function (loadEvent) {
                        var previewWrap = document.getElementById('profile-image-preview-wrap');
                        var previewImage = document.getElementById('profile-image-preview');

                        if (!previewWrap) {
                            return;
                        }

                        if (!previewImage) {
                            previewWrap.innerHTML = '<img id="profile-image-preview" alt="معاينة الصورة الشخصية">';
                            previewImage = document.getElementById('profile-image-preview');
                        }

                        if (previewImage) {
                            previewImage.src = loadEvent.target.result;
                        }
                    };
                    reader.readAsDataURL(file);
                });
            }
        });
    </script>

</x-layout>
