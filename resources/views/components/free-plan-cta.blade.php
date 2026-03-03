<!-- ============================ Free Plan CTA Section ================================== -->
<section class="free-plan-section" dir="rtl">

    <!-- Floating Background Shapes -->
    <div class="fp-bg-shape fp-shape-1"></div>
    <div class="fp-bg-shape fp-shape-2"></div>
    <div class="fp-bg-shape fp-shape-3"></div>

    <div class="container fp-container">

        <!-- Section Header -->
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="fp-badge">
                    <i class="fa fa-gift"></i>
                    <span>عرض حصري مجاني</span>
                </div>
                <h2 class="fp-main-title">
                    ابدأ رحلتك العقارية
                    <span class="fp-highlight">مجاناً الآن</span>
                </h2>
                <p class="fp-subtitle">
                    انضم إلى آلاف المستخدمين واستفد من الباقة المجانية — بدون أي رسوم، بدون بطاقة ائتمان
                </p>
            </div>
        </div>

        <!-- Main Card -->
        <div class="row justify-content-center mt-5">
            <div class="col-lg-11">
                <div class="fp-main-card">

                    <!-- Left: Price & CTA -->
                    <div class="fp-left-panel">
                        <div class="fp-price-badge">
                            <span class="fp-free-label">مجاناً</span>
                            <span class="fp-price-value">0 ج.م</span>
                         </div>

                        <h3 class="fp-plan-name">الباقة المجانية</h3>
                        <p class="fp-plan-desc">
                            اشترك الان مجاناً واحصل على 100 نقطه مجانية وتواصل مع مالك الوحده مباشرة واشتري عقارك بدون عمولة وبدون وسيط
                        </p>

                        @auth
                            <a href="/ar/pricing-seller" class="fp-cta-btn">
                                <span>اشترك مجاناً الآن</span>
                                <i class="fa fa-arrow-left fp-btn-icon"></i>
                            </a>
                        @else
                            <a href="/ar/register" class="fp-cta-btn">
                                <span>اشترك مجاناً الآن</span>
                                <i class="fa fa-arrow-left fp-btn-icon"></i>
                            </a>
                        @endauth

                        <div class="fp-trust-row">
                            <div class="fp-trust-item">
                                <i class="fa fa-shield fp-trust-icon"></i>
                                <span>آمن 100%</span>
                            </div>
                            <div class="fp-trust-item">
                                <i class="fa fa-credit-card fp-trust-icon"></i>
                                <span>بدون بطاقة</span>
                            </div>
                            <div class="fp-trust-item">
                                <i class="fa fa-clock-o fp-trust-icon"></i>
                                <span>في ثوانٍ</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Features -->
                    <div class="fp-right-panel">
                        <h4 class="fp-features-title">
                            <i class="fa fa-star fp-star-icon"></i>
                            ما ستحصل عليه مجاناً
                        </h4>

                        <div class="fp-features-grid">

                            <div class="fp-feature-item">
                                <div class="fp-feature-icon fp-icon-gold">
                                    <i class="fa fa-coins"></i>
                                </div>
                                <div class="fp-feature-text">
                                    <strong>100 نقطة مجانية</strong>
                                    <span>فور إنشاء حسابك مباشرة</span>
                                </div>
                            </div>



                            <div class="fp-feature-item">
                                <div class="fp-feature-icon fp-icon-green">
                                    <i class="fa fa-handshake-o"></i>
                                </div>
                                <div class="fp-feature-text">
                                    <strong>تواصل مباشر مع المالك</strong>
                                    <span>تفاوض مباشرة بدون وسيط</span>
                                </div>
                            </div>

                            <div class="fp-feature-item">
                                <div class="fp-feature-icon fp-icon-purple">
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="fp-feature-text">
                                    <strong>بحث متقدم</strong>
                                    <span>ابحث في آلاف العقارات بكل سهولة</span>
                                </div>
                            </div>


                            <div class="fp-feature-item">
                                <div class="fp-feature-icon fp-icon-teal">
                                    <i class="fa fa-bell"></i>
                                </div>
                                <div class="fp-feature-text">
                                    <strong>إشعارات فورية</strong>
                                    <span>لا تفوت أي فرصة عقارية مميزة</span>
                                </div>
                            </div>

                        </div>

                        <!-- Points System Note -->
                        <div class="fp-points-note">
                            <i class="fa fa-info-circle"></i>
                            <div>
                                <strong>نظام النقاط:</strong>
                                وحدات بيع: كل 100,000 ج.م = نقطة واحدة &nbsp;|&nbsp; وحدات إيجار: كل 500 ج.م = نقطة واحدة
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    </div>
</section>

<style>
/* =========================================
   FREE PLAN CTA SECTION
   ========================================= */
.free-plan-section {
    position: relative;
    padding: 90px 0 80px;
    background: linear-gradient(135deg, #0f0c29 0%, #196aa2  40%, #24243e 100%);
    overflow: hidden;
}

/* Background floating shapes */
.fp-bg-shape {
    position: absolute;
    border-radius: 50%;
    opacity: 0.07;
    animation: fp-float 8s ease-in-out infinite;
}
.fp-shape-1 {
    width: 500px; height: 500px;
    background: radial-gradient(circle, #f7971e, #ffd200);
    top: -150px; left: -100px;
    animation-delay: 0s;
}
.fp-shape-2 {
    width: 350px; height: 350px;
    background: radial-gradient(circle, #12c2e9, #c471ed);
    bottom: -100px; right: -80px;
    animation-delay: 3s;
}
.fp-shape-3 {
    width: 200px; height: 200px;
    background: radial-gradient(circle, #f64f59, #c471ed);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation-delay: 5s;
}
@keyframes fp-float {
    0%, 100% { transform: translateY(0) scale(1); }
    50% { transform: translateY(-30px) scale(1.05); }
}

/* Badge */
.fp-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(247, 151, 30, 0.15);
    border: 1px solid rgba(247, 151, 30, 0.4);
    color: #ffd200;
    padding: 8px 22px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 20px;
    letter-spacing: 0.5px;
    backdrop-filter: blur(10px);
}
.fp-badge i { font-size: 16px; }

/* Main Title */
.fp-main-title {
    font-size: 38px;
    font-weight: 800;
    color: #ffffff;
    line-height: 1.3;
    margin-bottom: 16px;
}
.fp-highlight {
    background: linear-gradient(135deg, #f7971e, #ffd200);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.fp-subtitle {
    font-size: 17px;
    color: rgba(255,255,255,0.65);
    line-height: 1.7;
    max-width: 550px;
    margin: 0 auto;
}

/* Main Card */
.fp-main-card {
    display: flex;
    align-items: stretch;
    gap: 0;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 24px;
    backdrop-filter: blur(20px);
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(0,0,0,0.4);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.fp-main-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 40px 100px rgba(0,0,0,0.5);
}

/* Left Panel */
.fp-left-panel {
    flex: 0 0 320px;
    background: linear-gradient(160deg, #f7971e 0%, #ffd200 100%);
    padding: 48px 36px;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.fp-left-panel::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
}
.fp-left-panel::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 150px; height: 150px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
}

.fp-price-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 24px;
    position: relative;
    z-index: 1;
}
.fp-free-label {
    background: rgba(0,0,0,0.15);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    padding: 4px 18px;
    border-radius: 50px;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 8px;
}
.fp-price-value {
    font-size: 52px;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    text-shadow: 0 4px 12px rgba(0,0,0,0.2);
}
.fp-price-period {
    font-size: 15px;
    color: rgba(255,255,255,0.8);
    font-weight: 600;
    margin-top: 4px;
}

.fp-plan-name {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 12px;
    position: relative;
    z-index: 1;
}
.fp-plan-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.85);
    line-height: 1.7;
    margin-bottom: 30px;
    position: relative;
    z-index: 1;
}

/* CTA Button */
.fp-cta-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    padding: 16px 24px;
    background: #fff;
    color: #f7971e !important;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 800;
    text-decoration: none !important;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    position: relative;
    z-index: 1;
    margin-bottom: 24px;
}
.fp-cta-btn:hover {
    background: #0f0c29;
    color: #ffd200 !important;
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.3);
}
.fp-btn-icon {
    transition: transform 0.3s ease;
}
.fp-cta-btn:hover .fp-btn-icon {
    transform: translateX(-4px);
}

/* Trust Row */
.fp-trust-row {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative;
    z-index: 1;
}
.fp-trust-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    color: rgba(255,255,255,0.9);
    font-weight: 600;
}
.fp-trust-icon { font-size: 13px; }

/* Right Panel */
.fp-right-panel {
    flex: 1;
    padding: 48px 40px;
}

.fp-features-title {
    font-size: 20px;
    font-weight: 800;
    color: #ffffff;
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.fp-star-icon {
    color: #ffd200;
    font-size: 18px;
}

/* Features Grid */
.fp-features-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 28px;
}

.fp-feature-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.07);
    transition: all 0.3s ease;
}
.fp-feature-item:hover {
    background: rgba(255,255,255,0.09);
    border-color: rgba(247,151,30,0.3);
    transform: translateY(-2px);
}

.fp-feature-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.fp-icon-gold   { background: rgba(247,151,30,0.2);  color: #ffd200; }
.fp-icon-blue   { background: rgba(18,194,233,0.2);  color: #12c2e9; }
.fp-icon-green  { background: rgba(0,230,118,0.2);   color: #00e676; }
.fp-icon-purple { background: rgba(196,113,237,0.2); color: #c471ed; }
.fp-icon-orange { background: rgba(255,87,34,0.2);   color: #ff5722; }
.fp-icon-teal   { background: rgba(0,188,212,0.2);   color: #00bcd4; }

.fp-feature-text {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.fp-feature-text strong {
    font-size: 14px;
    font-weight: 700;
    color: #ffffff;
}
.fp-feature-text span {
    font-size: 12px;
    color: rgba(255,255,255,0.55);
    line-height: 1.5;
}

/* Points Note */
.fp-points-note {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: rgba(247,151,30,0.08);
    border: 1px solid rgba(247,151,30,0.25);
    border-radius: 12px;
    padding: 14px 18px;
    font-size: 13px;
    color: rgba(255,255,255,0.75);
    line-height: 1.6;
}
.fp-points-note > i {
    color: #ffd200;
    font-size: 16px;
    margin-top: 2px;
    flex-shrink: 0;
}
.fp-points-note strong {
    color: #ffd200;
    margin-left: 4px;
}

/* Stats Row */
.fp-stats-row {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    padding: 24px 32px;
    backdrop-filter: blur(10px);
}
.fp-stat-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-align: center;
}
.fp-stat-num {
    font-size: 26px;
    font-weight: 900;
    background: linear-gradient(135deg, #f7971e, #ffd200);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.fp-stat-label {
    font-size: 13px;
    color: rgba(255,255,255,0.55);
    font-weight: 500;
}
.fp-stat-divider {
    width: 1px;
    height: 50px;
    background: rgba(255,255,255,0.1);
    margin: 0 10px;
}

/* =========================================
   RESPONSIVE
   ========================================= */
@media (max-width: 992px) {
    .fp-main-card {
        flex-direction: column;
    }
    .fp-left-panel {
        flex: none;
        padding: 40px 28px;
    }
    .fp-right-panel {
        padding: 36px 28px;
    }
    .fp-main-title { font-size: 30px; }
}

@media (max-width: 768px) {
    .free-plan-section { padding: 60px 0; }
    .fp-main-title { font-size: 26px; }
    .fp-features-grid {
        grid-template-columns: 1fr;
    }
    .fp-stats-row {
        flex-wrap: wrap;
        gap: 20px;
        padding: 20px;
    }
    .fp-stat-divider { display: none; }
    .fp-stat-item { flex: 0 0 45%; }
}

@media (max-width: 480px) {
    .fp-price-value { font-size: 40px; }
    .fp-left-panel { padding: 32px 20px; }
    .fp-right-panel { padding: 28px 20px; }
}
</style>
<!-- ============================ Free Plan CTA Section End ================================== -->
