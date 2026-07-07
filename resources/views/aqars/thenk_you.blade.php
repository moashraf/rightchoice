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


            <h3 style="line-height: 41px;">
                {{ session('success') }}</h3>
            <br>

            {{-- بطاقة تفاصيل العقار المضاف --}}
            @if($aqar)
            <div class="ty-aqar-card">
                <div class="ty-aqar-badge-row">
                    @if($aqar->categoryRel)
                        <span class="ty-badge ty-badge-cat">
                            <i class="fa fa-building ml-1"></i>
                            {{ $aqar->categoryRel->category_name ?? 'عقار' }}
                        </span>
                    @endif
                    @if($aqar->propertyType)
                        <span class="ty-badge ty-badge-prop">
                            <i class="fa fa-tags ml-1"></i>
                            {{ $aqar->propertyType->property_type ?? '' }}
                        </span>
                    @endif
                    @if($aqar->offerTypes)
                        @php
                            $offerName = $aqar->offerTypes->type_offer ?? '';
                            $isRent = in_array($aqar->offer_type, [3, 4]);
                        @endphp
                        <span class="ty-badge {{ $isRent ? 'ty-badge-rent' : 'ty-badge-sale' }}">
                            <i class="fa {{ $isRent ? 'fa-key' : 'fa-handshake-o' }} ml-1"></i>
                            {{ $offerName }}
                        </span>
                    @endif
                </div>

                @if($aqar->title)
                    <h4 class="ty-aqar-title">{{ $aqar->title }}</h4>
                @endif

                <div class="ty-aqar-meta">
                    @if($aqar->governrateq)
                        <span><i class="fa fa-map-marker ml-1"></i>{{ $aqar->governrateq->name ?? '' }}</span>
                    @endif
                    @if($aqar->districte)
                        <span><i class="fa fa-map-pin ml-1"></i>{{ $aqar->districte->name ?? '' }}</span>
                    @endif
                    @if($aqar->total_area)
                        <span><i class="fa fa-crop ml-1"></i>{{ number_format($aqar->total_area) }} م²</span>
                    @endif
                </div>

                <div class="ty-aqar-actions">
                    <a class="btn ty-btn-view"
                       href="{{ url(Config::get('app.locale').'/aqars/'.$aqar->slug) }}">
                        <i class="fa fa-eye ml-1"></i> عرض الإعلان
                    </a>
                    <a class="btn ty-btn-vip"
                       href="{{ url(Config::get('app.locale').'/pricing-vip/'.$aqar->id) }}">
                        <i class="fa fa-star ml-1"></i> ميز إعلانك
                    </a>
                </div>
            </div>
            @else
                <p class="lead">
                    @if(session('id'))
                    <a class="btn btn-light btn-sm" style="padding:10px"
                       href="{{ url(Config::get('app.locale').'/pricing-vip/'.session('id')) }}" role="button">
                        ميز اعلانك</a>
                    @endif
                </p>
            @endif

            <p class="mt-3">
                تم اضافه الاعلان بنجاح و جاري المراجعه
<br>
                <a href="{{ url(Config::get('app.locale').'/user_ads') }}">
شاهد الاعلان الخاص بك               </a>
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

    /* ── بطاقة العقار المضاف ── */
    .ty-aqar-card {
        background: #fff;
        border: 2px solid #196aa2;
        border-radius: 18px;
        padding: 24px 28px;
        max-width: 560px;
        margin: 0 auto 30px;
        box-shadow: 0 4px 20px rgba(25,106,162,0.13);
        text-align: right;
        animation: ty-fadeup 0.5s ease both;
    }
    .ty-aqar-badge-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
        justify-content: flex-end;
    }
    .ty-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        color: #fff;
    }
    .ty-badge-cat  { background: #196aa2; }
    .ty-badge-prop { background: #5a6a85; }
    .ty-badge-sale { background: #28a745; }
    .ty-badge-rent { background: #fd7e14; }
    .ty-aqar-title {
        font-size: 18px;
        font-weight: 700;
        color: #196aa2;
        margin-bottom: 12px;
        line-height: 1.5;
    }
    .ty-aqar-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        justify-content: flex-end;
        color: #555;
        font-size: 14px;
        margin-bottom: 18px;
    }
    .ty-aqar-meta span { display: flex; align-items: center; gap: 4px; }
    .ty-aqar-actions {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
    }
    .ty-btn-view {
        background: #196aa2;
        color: #fff !important;
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: background 0.3s;
    }
    .ty-btn-view:hover { background: #145585; }
    .ty-btn-vip {
        background: #ffc107;
        color: #333 !important;
        border-radius: 10px;
        padding: 8px 20px;
        font-weight: 600;
        font-size: 14px;
        transition: background 0.3s;
    }
    .ty-btn-vip:hover { background: #e0a800; }
    @media (max-width: 560px) {
        .ty-aqar-card { padding: 16px; }
    }
    </style>

    <x-call-to-action />

</x-layout>
