<x-layout>
 @section('title')
    شكرا لك
@endsection

    <br>
    <br>
    <br>
    <section id="thank-page">
        <div class="text-center container">
            <h1 class="display-3">!شكرا لك</h1>
             <hr>


            <h3 style=" line-height: 41px;">
                {{ session('success') }}</h3>
            <br>

            <p>
              لديك مشكله ؟
              <a href="{{ url(Config::get('app.locale').'/contact-us') }}">
                 تواصل معنا
              </a>
            </p>
            <p class="lead">
                @if(session('id'))
              <a class="btn btn-light btn-sm" style="padding:10px"
                 href="{{ url(Config::get('app.locale').'/pricing-vip/'.session('id')) }}" role="button">
                  ميز اعلانك</a>
                @endif
            </p>

            {{-- Quick Navigation Links --}}
            <div class="ty-nav-links">
                <a href="{{ url(Config::get('app.locale').'/') }}" class="ty-nav-btn">
                    <span class="ty-nav-icon"><i class="fa fa-home"></i></span>
                    <span class="ty-nav-label">الرئيسية</span>
                </a>
                <a href="{{ url(Config::get('app.locale').'/all_aqar_for_sale') }}" class="ty-nav-btn">
                    <span class="ty-nav-icon"><i class="fa fa-building"></i></span>
                    <span class="ty-nav-label">عقارات للبيع</span>
                </a>
                <a href="{{ url(Config::get('app.locale').'/all_aqar_for_rent') }}" class="ty-nav-btn">
                    <span class="ty-nav-icon"><i class="fa fa-key"></i></span>
                    <span class="ty-nav-label">عقارات للإيجار</span>
                </a>
                <a href="{{ url(Config::get('app.locale').'/smart-search') }}" class="ty-nav-btn">
                    <span class="ty-nav-icon"><i class="fa fa-cogs"></i></span>
                    <span class="ty-nav-label">بدور علي ايه</span>
                </a>
                <a href="{{ url(Config::get('app.locale').'/pricing-seller') }}" class="ty-nav-btn">
                    <span class="ty-nav-icon"><i class="fa fa-tags"></i></span>
                    <span class="ty-nav-label">الباقات</span>
                </a>
            </div>
          </div>
    </section>

    <style>
    .ty-nav-links {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 16px;
        margin: 30px auto 20px;
        padding: 0 10px;
    }
    .ty-nav-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 130px;
        height: 110px;
        background: #ffffff;
        border: 2px solid #196aa2;
        border-radius: 16px;
        color: #196aa2;
        text-decoration: none;
        transition: all 0.35s cubic-bezier(.25,.8,.25,1);
        box-shadow: 0 2px 8px rgba(25,106,162,0.10);
        animation: ty-fadeup 0.6s ease both;
        position: relative;
        overflow: hidden;
    }
    .ty-nav-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: #196aa2;
        transform: scaleY(0);
        transform-origin: bottom;
        transition: transform 0.35s cubic-bezier(.25,.8,.25,1);
        z-index: 0;
    }
    .ty-nav-btn:hover::before,
    .ty-nav-btn:focus::before {
        transform: scaleY(1);
    }
    .ty-nav-btn:hover,
    .ty-nav-btn:focus {
        color: #fff;
        text-decoration: none;
        box-shadow: 0 6px 24px rgba(25,106,162,0.30);
        transform: translateY(-6px) scale(1.04);
    }
    .ty-nav-icon {
        font-size: 28px;
        margin-bottom: 8px;
        position: relative;
        z-index: 1;
        transition: transform 0.35s;
    }
    .ty-nav-btn:hover .ty-nav-icon {
        transform: scale(1.2) rotate(-8deg);
    }
    .ty-nav-label {
        font-size: 14px;
        font-weight: 700;
        position: relative;
        z-index: 1;
        letter-spacing: 0.3px;
    }
    /* Staggered entrance animation */
    .ty-nav-btn:nth-child(1) { animation-delay: 0.05s; }
    .ty-nav-btn:nth-child(2) { animation-delay: 0.15s; }
    .ty-nav-btn:nth-child(3) { animation-delay: 0.25s; }
    .ty-nav-btn:nth-child(4) { animation-delay: 0.35s; }
    .ty-nav-btn:nth-child(5) { animation-delay: 0.45s; }
    @keyframes ty-fadeup {
        from { opacity: 0; transform: translateY(30px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @media (max-width: 480px) {
        .ty-nav-btn { width: 100px; height: 90px; }
        .ty-nav-icon { font-size: 22px; }
        .ty-nav-label { font-size: 12px; }
    }
    </style>

    <x-call-to-action />

</x-layout>
