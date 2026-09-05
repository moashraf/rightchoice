<x-layout>
    @section('title')
        سياسة الخصوصية
    @endsection

    @section('og_description')
        تعرف على كيفية جمع واستخدام وحماية البيانات الشخصية في منصة Right Choice العقارية.
    @endsection

    @php
        $locale = app()->getLocale();
        $isEnglish = $locale === 'en';
    @endphp

    <style>
        :root {
            --rc-privacy-primary: #0e4f86;
            --rc-privacy-primary-dark: #082f52;
            --rc-privacy-accent: #ff6b35;
            --rc-privacy-bg: #f5f8fb;
            --rc-privacy-card: #ffffff;
            --rc-privacy-text: #263238;
            --rc-privacy-muted: #687786;
            --rc-privacy-border: #dce7f0;
            --rc-privacy-soft: #eaf3fa;
        }

        html {
            scroll-behavior: smooth;
        }

        .rc-privacy-page {
            background: var(--rc-privacy-bg);
            color: var(--rc-privacy-text);
            min-height: 100vh;
            direction: rtl;
            text-align: right;
        }

        .rc-privacy-hero {
            position: relative;
            overflow: hidden;
            padding: 78px 0 66px;
            background:
                radial-gradient(circle at 12% 20%, rgba(255, 255, 255, .16), transparent 28%),
                radial-gradient(circle at 88% 80%, rgba(255, 107, 53, .18), transparent 30%),
                linear-gradient(135deg, var(--rc-privacy-primary-dark), var(--rc-privacy-primary));
            color: #fff;
        }

        .rc-privacy-hero::after {
            content: '';
            position: absolute;
            inset: auto -8% -110px auto;
            width: 360px;
            height: 360px;
            border: 52px solid rgba(255,255,255,.05);
            border-radius: 50%;
        }

        .rc-privacy-hero__inner {
            position: relative;
            z-index: 2;
            max-width: 880px;
            margin: 0 auto;
        }

        .rc-privacy-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            border: 1px solid rgba(255,255,255,.22);
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 18px;
            backdrop-filter: blur(6px);
        }

        .rc-privacy-hero h1 {
            color: #fff;
            font-size: clamp(34px, 5vw, 58px);
            font-weight: 800;
            margin-bottom: 16px;
            line-height: 1.15;
        }

        .rc-privacy-hero p {
            color: rgba(255,255,255,.9);
            font-size: 18px;
            line-height: 1.9;
            margin-bottom: 20px;
        }

        .rc-privacy-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 20px;
            font-size: 14px;
            color: rgba(255,255,255,.82);
        }

        .rc-privacy-meta span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .rc-privacy-wrap {
            padding: 50px 0 80px;
        }

        .rc-privacy-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 280px;
            gap: 28px;
            align-items: start;
        }

        .rc-privacy-content {
            min-width: 0;
        }

        .rc-privacy-summary {
            background: linear-gradient(135deg, #fff8f4, #ffffff);
            border: 1px solid #ffd9c9;
            border-right: 5px solid var(--rc-privacy-accent);
            border-radius: 18px;
            padding: 22px 24px;
            margin-bottom: 24px;
            box-shadow: 0 10px 28px rgba(23, 64, 95, .06);
        }

        .rc-privacy-summary strong {
            display: block;
            color: #b7461f;
            font-size: 18px;
            margin-bottom: 7px;
        }

        .rc-privacy-card {
            background: var(--rc-privacy-card);
            border: 1px solid var(--rc-privacy-border);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 20px;
            box-shadow: 0 10px 35px rgba(23, 64, 95, .055);
            scroll-margin-top: 110px;
        }

        .rc-privacy-card h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--rc-privacy-primary-dark);
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 18px;
            line-height: 1.45;
        }

        .rc-privacy-card h2 .rc-num {
            width: 38px;
            min-width: 38px;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: var(--rc-privacy-soft);
            color: var(--rc-privacy-primary);
            font-size: 15px;
        }

        .rc-privacy-card h3 {
            color: var(--rc-privacy-primary);
            font-size: 17px;
            font-weight: 800;
            margin: 20px 0 10px;
        }

        .rc-privacy-card p,
        .rc-privacy-card li {
            color: var(--rc-privacy-text);
            line-height: 1.95;
            font-size: 15.5px;
        }

        .rc-privacy-card p:last-child,
        .rc-privacy-card ul:last-child {
            margin-bottom: 0;
        }

        .rc-privacy-card ul {
            margin: 0;
            padding-right: 22px;
        }

        .rc-privacy-card li {
            margin-bottom: 8px;
        }

        .rc-privacy-data-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .rc-privacy-data-item {
            background: #f8fbfd;
            border: 1px solid var(--rc-privacy-border);
            border-radius: 15px;
            padding: 16px;
        }

        .rc-privacy-data-item strong {
            display: block;
            color: var(--rc-privacy-primary-dark);
            margin-bottom: 6px;
        }

        .rc-privacy-data-item span {
            color: var(--rc-privacy-muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .rc-privacy-note {
            margin-top: 16px;
            padding: 16px 18px;
            border-radius: 14px;
            background: #eef8f1;
            border: 1px solid #cce8d4;
            color: #27643a;
            line-height: 1.85;
        }

        .rc-privacy-sidebar {
            position: sticky;
            top: 105px;
            background: #fff;
            border: 1px solid var(--rc-privacy-border);
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(23, 64, 95, .06);
            overflow: hidden;
        }

        .rc-privacy-sidebar__title {
            padding: 18px 18px 14px;
            border-bottom: 1px solid var(--rc-privacy-border);
            color: var(--rc-privacy-primary-dark);
            font-weight: 800;
        }

        .rc-privacy-sidebar nav {
            max-height: calc(100vh - 190px);
            overflow: auto;
            padding: 10px;
        }

        .rc-privacy-sidebar a {
            display: block;
            padding: 9px 10px;
            color: #526270;
            font-size: 13.5px;
            border-radius: 10px;
            text-decoration: none;
            transition: .2s ease;
        }

        .rc-privacy-sidebar a:hover {
            background: var(--rc-privacy-soft);
            color: var(--rc-privacy-primary);
            transform: translateX(-2px);
        }

        .rc-privacy-contact {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 24px;
            border-radius: 18px;
            background: linear-gradient(135deg, var(--rc-privacy-primary-dark), var(--rc-privacy-primary));
            color: #fff;
            margin-top: 26px;
        }

        .rc-privacy-contact h3 {
            color: #fff;
            margin: 0 0 4px;
            font-size: 20px;
        }

        .rc-privacy-contact p {
            color: rgba(255,255,255,.82);
            margin: 0;
        }

        .rc-privacy-contact a {
            white-space: nowrap;
            background: #fff;
            color: var(--rc-privacy-primary-dark);
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
        }

        @media (max-width: 991px) {
            .rc-privacy-layout {
                grid-template-columns: 1fr;
            }

            .rc-privacy-sidebar {
                display: none;
            }

            .rc-privacy-hero {
                padding: 58px 0 48px;
            }
        }

        @media (max-width: 767px) {
            .rc-privacy-wrap {
                padding: 28px 0 55px;
            }

            .rc-privacy-card {
                padding: 20px 18px;
                border-radius: 16px;
            }

            .rc-privacy-card h2 {
                font-size: 19px;
            }

            .rc-privacy-data-grid {
                grid-template-columns: 1fr;
            }

            .rc-privacy-contact {
                align-items: flex-start;
                flex-direction: column;
            }

            .rc-privacy-contact a {
                width: 100%;
                text-align: center;
            }
        }
    </style>

    <main class="rc-privacy-page">
        <section class="rc-privacy-hero">
            <div class="container">
                <div class="rc-privacy-hero__inner">
                    <div class="rc-privacy-badge">
                        <i class="fa fa-shield-alt"></i>
                        <span>الخصوصية والأمان في Right Choice</span>
                    </div>
                    <h1>سياسة الخصوصية</h1>
                    <p>
                        نوضح هنا بصورة واضحة كيف نجمع بياناتك ونستخدمها ونشاركها ونحميها أثناء استخدامك لمنصة Right Choice العقارية.
                    </p>
                    <div class="rc-privacy-meta">
                        <span><i class="far fa-calendar-alt"></i> آخر تحديث: 5 سبتمبر 2026</span>
                        <span><i class="fas fa-globe"></i> rightchoice-co.com</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="rc-privacy-wrap">
            <div class="container">
                <div class="rc-privacy-layout">
                    <div class="rc-privacy-content">
                        @if($isEnglish)
                            <div class="rc-privacy-summary">
                                <strong>ملاحظة</strong>
                                النسخة القانونية المعتمدة من هذه الصفحة متاحة حاليًا باللغة العربية.
                            </div>
                        @endif

                        <div class="rc-privacy-summary">
                            <strong>ملخص سريع</strong>
                            توضح هذه السياسة كيفية تعامل Right Choice مع بياناتك أثناء التسجيل، نشر العقارات، البحث والتواصل، استخدام المفضلة، إرسال الشكاوى والاستفسارات، الاشتراك في الباقات والإعلانات المميزة، وإتمام عمليات الدفع من خلال مزودي الخدمة المعتمدين.
                        </div>

                        <article id="intro" class="rc-privacy-card">
                            <h2><span class="rc-num">1</span> مقدمة ونطاق السياسة</h2>
                            <p>خصوصيتك مهمة لنا. تشرح هذه السياسة كيفية تعامل منصة Right Choice مع البيانات الشخصية عند استخدامك للموقع الإلكتروني أو الواجهات البرمجية أو أي خدمات رقمية مرتبطة به، ويشار إليها مجتمعة باسم «المنصة».</p>
                            <p>تغطي السياسة البيانات التي تقدمها لنا مباشرة، والبيانات الناتجة عن استخدامك للمنصة، والبيانات التي تصلنا من مزودي الخدمات عند الحاجة لتقديم وظائف مثل التحقق عبر الرسائل النصية أو الدفع الإلكتروني.</p>
                            <p>باستخدام المنصة أو إنشاء حساب أو إرسال بيانات من خلالها، فإنك تقر بأن بياناتك ستتم معالجتها وفقًا لهذه السياسة وبالقدر اللازم لتقديم الخدمات والوفاء بالالتزامات القانونية والتنظيمية المعمول بها.</p>
                        </article>

                        <article id="who-we-are" class="rc-privacy-card">
                            <h2><span class="rc-num">2</span> من نحن وكيفية التواصل معنا</h2>
                            <p>Right Choice منصة عقارية تعمل على تسهيل عرض العقارات والبحث عنها والتواصل بين أصحاب العقارات والمشترين أو المستأجرين والمطورين العقاريين، مع إتاحة خدمات إضافية مثل الباقات المدفوعة وتمييز الإعلانات.</p>
                            <ul>
                                <li>البريد الإلكتروني العام: <a href="mailto:info@rightchoice-co.com">info@rightchoice-co.com</a></li>
                                <li>البريد الإلكتروني للمبيعات: <a href="mailto:sales@rightchoice-co.com">sales@rightchoice-co.com</a></li>
                                <li>الهاتف: <a href="tel:0225196690">02-25196690</a></li>
                                <li>واتساب / موبايل: <a href="https://wa.me/201060660079" target="_blank" rel="noopener">01060660079</a></li>
                                <li>العنوان: محافظة القاهرة، المعادي، دجلة، شارع 216، عمارة 17، الدور الثاني، فيلا 1.</li>
                            </ul>
                        </article>

                        <article id="personal-data" class="rc-privacy-card">
                            <h2><span class="rc-num">3</span> ما المقصود بالبيانات الشخصية؟</h2>
                            <p>البيانات الشخصية هي أي معلومات تتعلق بشخص طبيعي محدد أو يمكن تحديد هويته بصورة مباشرة أو غير مباشرة، مثل الاسم ورقم الهاتف والبريد الإلكتروني وبيانات الحساب. أما البيانات التي يتم إخفاء هوية أصحابها بصورة لا تسمح بإعادة التعرف عليهم فلا تعامل عادةً كبيانات شخصية.</p>
                        </article>

                        <article id="data-we-collect" class="rc-privacy-card">
                            <h2><span class="rc-num">4</span> البيانات التي نجمعها</h2>
                            <p>قد نجمع الفئات التالية بحسب نوع الحساب والوظائف التي تستخدمها:</p>

                            <div class="rc-privacy-data-grid">
                                <div class="rc-privacy-data-item"><strong>بيانات الحساب والهوية</strong><span>الاسم، البريد الإلكتروني، رقم الهاتف، كلمة المرور بصيغة آمنة، نوع الحساب، حالة الحساب، صورة الملف الشخصي وبيانات التحقق.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات المطور أو النشاط العقاري</strong><span>اسم المطور أو الشركة، المسمى الوظيفي، السجل التجاري، البطاقة الضريبية، شعار الشركة أو صورة الحساب والبيانات التي تقدمها عند التسجيل.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات التحقق والأمان</strong><span>حالة التحقق من رقم الهاتف، رمز OTP لفترة تشغيلية، بيانات التحقق من البريد ورموز أو بيانات المصادقة اللازمة لتأمين الجلسات والواجهات البرمجية.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات العقارات والإعلانات</strong><span>العنوان والوصف والصور ونوع العرض والعقار والسعر والمساحات والغرف والحمامات والتمويل والتقسيط والإيجار والترخيص والمزايا.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات الموقع العقاري</strong><span>المحافظة والمنطقة والحي أو الكمبوند، وقد تشمل إحداثيات خط العرض والطول للعقار إذا تم إدخالها أو اختيارها.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات الاهتمام والتفاعل</strong><span>المفضلة، العقارات التي طلبت التواصل بشأنها، وسيلة التواصل مثل واتساب، واستخدام النقاط أو الباقات والخدمات المرتبطة بها.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات الدفع والمعاملات</strong><span>المبلغ والعملة وحالة وطريقة الدفع وأرقام المرجع والمعاملة وتاريخ السداد وبيانات الاسترداد ورسوم بوابة الدفع والردود الفنية.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات التواصل والدعم</strong><span>الاسم والهاتف والبريد والموضوع ومحتوى الرسالة عند التواصل معنا، بالإضافة إلى بيانات الشكاوى وطلبات الدعم أو حذف الحساب.</span></div>
                                <div class="rc-privacy-data-item"><strong>بيانات تقنية وتشغيلية</strong><span>بيانات الجلسة وتسجيل الدخول وعنوان IP وسجلات الخادم ونوع المتصفح والجهاز ونظام التشغيل والتوقيت واللغة بالقدر الذي تنشئه أنظمة التشغيل والحماية.</span></div>
                            </div>

                            <h3>بيانات لا نطلبها منك عادةً</h3>
                            <p>لا نطلب منك كجزء طبيعي من استخدام المنصة تقديم بيانات شديدة الحساسية مثل المعتقدات الدينية أو الآراء السياسية أو البيانات الصحية أو الوراثية أو تفاصيل الحياة الخاصة، وننصح بعدم إدراج هذه المعلومات داخل وصف العقار أو الشكاوى أو نماذج التواصل ما لم تكن ضرورية بشكل واضح ومسموح بها قانونًا.</p>

                            <h3>ماذا يحدث إذا لم تقدم البيانات المطلوبة؟</h3>
                            <p>يمكنك تصفح بعض أجزاء المنصة دون إنشاء حساب، ولكن بعض الخدمات تحتاج بيانات محددة. إذا لم تقدم البيانات اللازمة للتسجيل أو التحقق أو الدفع أو تنفيذ خدمة معينة فقد لا نتمكن من إتمام تلك الخدمة.</p>
                        </article>

                        <article id="sources" class="rc-privacy-card">
                            <h2><span class="rc-num">5</span> كيف نحصل على بياناتك؟</h2>
                            <ul>
                                <li>مباشرة منك عند التسجيل أو تحديث الحساب أو نشر إعلان أو رفع صور أو إرسال نموذج تواصل أو شكوى.</li>
                                <li>من استخدامك للمنصة، مثل إنشاء قائمة مفضلة أو طلب التواصل مع صاحب عقار أو الاشتراك في باقة.</li>
                                <li>من مزودي الخدمات الذين نتعامل معهم لتقديم وظيفة طلبتها، مثل مزود الرسائل النصية ومزود الدفع.</li>
                                <li>من السجلات التقنية الناتجة عن تشغيل الموقع والخوادم وأنظمة الأمان.</li>
                            </ul>
                        </article>

                        <article id="purposes" class="rc-privacy-card">
                            <h2><span class="rc-num">6</span> لماذا نستخدم بياناتك؟</h2>
                            <ul>
                                <li><strong>إنشاء وإدارة الحساب:</strong> التسجيل والتحقق وإدارة حالة الحساب واستعادة الوصول وتأمين الجلسات.</li>
                                <li><strong>التحقق والأمان:</strong> إرسال OTP ومكافحة إساءة الاستخدام والاحتيال وحماية الحسابات والأنظمة.</li>
                                <li><strong>تشغيل الإعلانات العقارية:</strong> إنشاء الإعلانات ومراجعتها ونشرها وعرض بياناتها وصورها وموقعها وإدارة الإعلانات المميزة.</li>
                                <li><strong>التواصل بين المستخدمين:</strong> تمكين طلب التواصل مع أصحاب العقارات وتسجيل الاهتمام واستخدام وسائل التواصل المتاحة.</li>
                                <li><strong>الباقات والنقاط:</strong> إدارة الاشتراكات والنقاط وتمييز العقارات وتتبع صلاحية الباقات.</li>
                                <li><strong>الدفع والاسترداد:</strong> إرسال البيانات اللازمة لمزود الدفع والتحقق من حالة المعاملة ومعالجة المرتجعات والتسويات.</li>
                                <li><strong>الدعم والشكاوى:</strong> الرد على الاستفسارات ومعالجة الشكاوى ومتابعة المشكلات.</li>
                                <li><strong>تحسين التشغيل والأداء:</strong> تشخيص الأعطال وحماية المنصة وقياس الاستخدام وتحسين تجربة المستخدم.</li>
                            </ul>
                            <div class="rc-privacy-note">لن نستخدم بياناتك لغرض غير متوافق بصورة جوهرية مع الغرض الذي جمعت من أجله إلا إذا كان ذلك مسموحًا به قانونًا أو تم إخطارك أو الحصول على موافقتك عندما تكون الموافقة مطلوبة.</div>
                        </article>

                        <article id="public-data" class="rc-privacy-card">
                            <h2><span class="rc-num">7</span> البيانات التي تظهر للآخرين</h2>
                            <p>طبيعة المنصة العقارية تعني أن بعض المعلومات التي تختار نشرها تكون متاحة لمستخدمي الموقع أو لمحركات البحث، مثل بيانات الإعلان ووصف العقار وصوره وسعره وموقعه العام ونوع العرض.</p>
                            <p>قد تتاح بعض بيانات التواصل مع صاحب الإعلان للمستخدمين وفق آلية المنصة وصلاحيات الحساب أو النقاط أو الباقات. لذلك يجب ألا تنشر داخل الإعلان بيانات لا ترغب في إتاحتها للآخرين.</p>
                        </article>

                        <article id="sharing" class="rc-privacy-card">
                            <h2><span class="rc-num">8</span> مع من نشارك البيانات؟</h2>
                            <ul>
                                <li>مزود الدفع الإلكتروني، بما في ذلك فوري، لمعالجة الدفع والتحقق والاسترداد والتسوية.</li>
                                <li>مزود خدمات الرسائل النصية لإرسال رموز التحقق OTP والرسائل التشغيلية.</li>
                                <li>مزودو الاستضافة والبنية التحتية والدعم الفني والأمن السيبراني والبريد الإلكتروني عند الحاجة.</li>
                                <li>خدمات الخرائط أو المحتوى الخارجي المضمن، مثل خرائط Google.</li>
                                <li>المستشارون والمراجعون والجهات المهنية عند الحاجة القانونية أو المحاسبية أو الأمنية.</li>
                                <li>الجهات الحكومية أو القضائية أو التنظيمية إذا كان الإفصاح مطلوبًا بموجب قانون أو أمر ملزم.</li>
                                <li>طرف يستحوذ على كل أو جزء من النشاط أو يندمج معه، مع استمرار الالتزامات القانونية المناسبة.</li>
                            </ul>
                        </article>

                        <article id="payments" class="rc-privacy-card">
                            <h2><span class="rc-num">9</span> الدفع الإلكتروني وبيانات فوري</h2>
                            <p>عند استخدام الدفع عبر فوري، قد نرسل إلى مزود الدفع البيانات اللازمة لإتمام العملية، مثل رقم تعريف العميل ورقم الهاتف والبريد الإلكتروني ومبلغ العملية والعملة ووصف الخدمة.</p>
                            <p>كما نحتفظ بسجلات تشغيلية مرتبطة بالمعاملة مثل رقم المرجع ورقم مرجع التاجر وحالة الدفع وتاريخ السداد وبيانات الاسترداد والردود الفنية ذات الصلة.</p>
                            <div class="rc-privacy-note">لا نهدف إلى تخزين رقم البطاقة البنكية الكامل أو رمز الأمان CVV داخل قواعد بيانات Right Choice. إذا كانت طريقة الدفع تتطلب بيانات مالية إضافية، فيجب إدخالها ومعالجتها وفق واجهة وشروط مزود الدفع المعتمد.</div>
                        </article>

                        <article id="cookies" class="rc-privacy-card">
                            <h2><span class="rc-num">10</span> ملفات تعريف الارتباط والبيانات التقنية</h2>
                            <p>تستخدم المنصة تقنيات تشغيلية مثل ملفات تعريف الارتباط أو الجلسات الرقمية للحفاظ على تسجيل الدخول، حماية الطلبات، حفظ بعض التفضيلات مثل اللغة، وتشغيل الوظائف الأساسية للموقع.</p>
                            <p>قد تستخدم الخدمات الخارجية المضمنة، مثل الخرائط أو بوابات الدفع، ملفات تعريف ارتباط أو تقنيات مشابهة وفق سياساتها الخاصة.</p>
                        </article>

                        <article id="security" class="rc-privacy-card">
                            <h2><span class="rc-num">11</span> أمن البيانات</h2>
                            <p>نتخذ تدابير تقنية وتنظيمية معقولة لحماية البيانات من الوصول غير المصرح به أو الفقد أو التعديل أو الإفصاح غير المشروع. وتشمل آليات المنصة بحسب الوظيفة المستخدمة تخزين كلمات المرور بصيغة تجزئة آمنة، التحقق من البريد أو الهاتف، رموز الوصول للواجهات البرمجية، المصادقة الثنائية عند تفعيلها، وإدارة الصلاحيات للمستخدمين الإداريين.</p>
                            <p>لا توجد وسيلة نقل أو تخزين إلكتروني يمكن ضمان أمانها بنسبة 100%، لذلك نراجع وسائل الحماية ونحدثها عند الحاجة.</p>
                        </article>

                        <article id="retention" class="rc-privacy-card">
                            <h2><span class="rc-num">12</span> مدة الاحتفاظ بالبيانات</h2>
                            <p>نحتفظ بالبيانات فقط للمدة اللازمة لتقديم الخدمات وإدارة الحسابات والإعلانات والمعاملات ومعالجة النزاعات والشكاوى والوفاء بالمتطلبات المالية والقانونية وممارسة الحقوق أو الدفاع عنها.</p>
                            <p>قد يلزم الاحتفاظ بسجلات المعاملات والدفع والاسترداد وطلبات الدعم لفترة أطول من البيانات التشغيلية المؤقتة.</p>
                        </article>

                        <article id="account-deletion" class="rc-privacy-card">
                            <h2><span class="rc-num">13</span> حذف الحساب</h2>
                            <p>توفر المنصة آلية لطلب حذف الحساب. يتم إرسال الطلب إلى الإدارة لمراجعته، ويمكن قبوله أو رفضه وفق حالة الحساب والالتزامات المرتبطة به.</p>
                            <p>عند الموافقة على الطلب، قد يتم تعطيل الحساب باستخدام «الحذف المنطقي» (Soft Delete) بدلًا من الإزالة الفورية والنهائية لجميع السجلات. ويعني ذلك أن الحساب يتوقف عن الاستخدام العادي مع إمكان الاحتفاظ ببعض البيانات لأغراض الاستعادة أو السجلات المالية أو حماية الحقوق أو الالتزام بالقانون.</p>
                        </article>

                        <article id="rights" class="rc-privacy-card">
                            <h2><span class="rc-num">14</span> حقوقك بشأن بياناتك</h2>
                            <p>بحسب القانون المعمول به وظروف كل طلب، قد يكون لك الحق في:</p>
                            <ul>
                                <li>طلب معرفة البيانات الشخصية التي نحتفظ بها عنك والحصول على نسخة منها عندما يكون ذلك متاحًا قانونًا.</li>
                                <li>طلب تصحيح أو استكمال البيانات غير الدقيقة أو الناقصة.</li>
                                <li>طلب حذف أو تعطيل الحساب والبيانات في الحالات التي يسمح بها القانون.</li>
                                <li>الاعتراض على بعض أنواع المعالجة أو طلب تقييدها عندما ينطبق ذلك.</li>
                                <li>سحب موافقتك في الحالات التي نعتمد فيها على الموافقة دون التأثير على مشروعية المعالجة السابقة.</li>
                                <li>طلب نقل بعض البيانات بصيغة مناسبة عندما يقرر القانون هذا الحق وتنطبق شروطه.</li>
                                <li>تقديم شكوى لنا أو إلى الجهة المختصة بحماية البيانات إذا كنت ترى أن بياناتك عولجت بصورة غير مشروعة.</li>
                            </ul>
                            <p>قد نطلب معلومات مناسبة للتحقق من هويتك قبل تنفيذ أي طلب متعلق بالبيانات لحماية حسابك ومنع الإفصاح لشخص غير مخول.</p>
                        </article>

                        <article id="messages" class="rc-privacy-card">
                            <h2><span class="rc-num">15</span> الرسائل والإشعارات</h2>
                            <p>نستخدم رقم الهاتف أو البريد الإلكتروني لإرسال رسائل تشغيلية لازمة للخدمة، مثل رموز التحقق OTP وإشعارات الحساب وتحديثات المعاملات أو الدعم عند الحاجة.</p>
                            <p>إذا أرسلنا رسائل تسويقية أو عروضًا ترويجية، فسيكون ذلك وفقًا للقواعد القانونية والتفضيلات المتاحة للمستخدم، وسنوفر وسيلة مناسبة لطلب إيقاف هذا النوع من الرسائل حيثما ينطبق.</p>
                        </article>

                        <article id="minors" class="rc-privacy-card">
                            <h2><span class="rc-num">16</span> القاصرون</h2>
                            <p>المنصة موجهة أساسًا للأشخاص الذين لديهم الأهلية القانونية للتعامل في الخدمات العقارية، وليست مصممة لاستهداف الأطفال. إذا علمنا بأن بيانات قاصر قد جمعت بصورة غير مناسبة، يمكن لولي الأمر التواصل معنا لطلب مراجعتها واتخاذ الإجراء الملائم.</p>
                        </article>

                        <article id="third-parties" class="rc-privacy-card">
                            <h2><span class="rc-num">17</span> الروابط والخدمات الخارجية</h2>
                            <p>قد تحتوي المنصة على روابط أو محتوى مضمّن من مواقع أو خدمات تابعة لجهات خارجية. عند الانتقال إلى تلك الخدمات، تخضع بياناتك لسياسات الخصوصية والشروط الخاصة بها. لا نتحكم في ممارسات الخصوصية لتلك الجهات، لذلك ننصح بمراجعة سياساتها قبل تقديم بيانات شخصية إليها.</p>
                        </article>

                        <article id="transfers" class="rc-privacy-card">
                            <h2><span class="rc-num">18</span> نقل البيانات عبر الحدود</h2>
                            <p>قد تكون بعض خدمات الاستضافة أو البنية التحتية أو مزودي التقنية موجودة داخل مصر أو خارجها. إذا استلزم تشغيل الخدمة نقل بيانات شخصية إلى دولة أخرى، فنتعامل مع هذا النقل وفق المتطلبات القانونية المطبقة ونتخذ التدابير المناسبة لحماية البيانات في حدود طبيعة الخدمة ومزودها.</p>
                        </article>

                        <article id="updates" class="rc-privacy-card">
                            <h2><span class="rc-num">19</span> تحديث سياسة الخصوصية</h2>
                            <p>قد نقوم بتحديث هذه السياسة من وقت لآخر لتعكس تغييرات في خدمات المنصة أو أنظمتها أو المتطلبات القانونية. سيتم نشر النسخة المحدثة على الموقع مع تاريخ آخر تحديث، وقد نستخدم وسيلة إضافية للإخطار إذا كان التغيير جوهريًا.</p>
                            <p>يسري التحديث من تاريخ نشره ما لم يذكر تاريخ آخر بشكل صريح.</p>
                        </article>

                        <article id="privacy-contact" class="rc-privacy-card">
                            <h2><span class="rc-num">20</span> التواصل بخصوص الخصوصية والشكاوى</h2>
                            <p>إذا كان لديك سؤال أو شكوى أو طلب متعلق ببياناتك الشخصية، تواصل معنا عبر <a href="mailto:info@rightchoice-co.com">info@rightchoice-co.com</a> أو من خلال صفحة «تواصل معنا» على الموقع.</p>
                            <p>يرجى وصف طلبك بوضوح وذكر بيانات تعريف كافية للتحقق من الحساب دون إرسال كلمات المرور أو رموز OTP.</p>
                            <div class="rc-privacy-note"><strong>تنبيه أمني:</strong> لن نطلب منك إرسال كلمة المرور أو رمز OTP الكامل عبر البريد الإلكتروني أو نموذج التواصل.</div>
                        </article>

                        <div class="rc-privacy-contact">
                            <div>
                                <h3>لديك استفسار بخصوص بياناتك؟</h3>
                                <p>فريق Right Choice متاح لمراجعة طلبات الخصوصية والاستفسارات.</p>
                            </div>
                            <a href="{{ url($locale . '/contact-us') }}">تواصل معنا</a>
                        </div>
                    </div>

                    <aside class="rc-privacy-sidebar" aria-label="فهرس سياسة الخصوصية">
                        <div class="rc-privacy-sidebar__title">محتويات الصفحة</div>
                        <nav>
                            <a href="#intro">1. مقدمة ونطاق السياسة</a>
                            <a href="#who-we-are">2. من نحن</a>
                            <a href="#personal-data">3. البيانات الشخصية</a>
                            <a href="#data-we-collect">4. البيانات التي نجمعها</a>
                            <a href="#sources">5. مصادر البيانات</a>
                            <a href="#purposes">6. استخدام البيانات</a>
                            <a href="#public-data">7. البيانات التي تظهر للآخرين</a>
                            <a href="#sharing">8. مشاركة البيانات</a>
                            <a href="#payments">9. الدفع وفوري</a>
                            <a href="#cookies">10. ملفات الارتباط</a>
                            <a href="#security">11. أمن البيانات</a>
                            <a href="#retention">12. مدة الاحتفاظ</a>
                            <a href="#account-deletion">13. حذف الحساب</a>
                            <a href="#rights">14. حقوقك</a>
                            <a href="#messages">15. الرسائل والإشعارات</a>
                            <a href="#minors">16. القاصرون</a>
                            <a href="#third-parties">17. الخدمات الخارجية</a>
                            <a href="#transfers">18. نقل البيانات</a>
                            <a href="#updates">19. تحديث السياسة</a>
                            <a href="#privacy-contact">20. التواصل معنا</a>
                        </nav>
                    </aside>
                </div>
            </div>
        </section>
    </main>
</x-layout>
