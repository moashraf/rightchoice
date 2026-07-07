<x-layout>


    @section('title')
        {{$getService->title}}
    @endsection

    <style>
        .companies-page-hero.hero-banner {
            min-height: 260px;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            background-size: cover !important;
            background-position: center !important;
        }

        .companies-page-hero.hero-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(5, 43, 75, 0.82), rgba(13, 132, 157, 0.48));
            z-index: 1;
        }

        .companies-page-hero .container {
            position: relative;
            z-index: 2;
        }

        .companies-page-hero .hero__p {
            max-width: 760px;
            margin: 0 auto;
            padding: 28px 34px;
            text-align: center;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.13);
            box-shadow: 0 24px 70px rgba(0, 0, 0, 0.16);
            backdrop-filter: blur(9px);
        }

        .companies-page-hero .hero__p h1 {
            margin-bottom: 10px;
            font-size: clamp(28px, 4vw, 44px);
            line-height: 1.25;
            font-weight: 800;
            color: #fff;
        }

        .companies-page-hero .hero__p p {
            margin: 0 auto;
            max-width: 640px;
            font-size: 15px;
            line-height: 1.9;
            color: rgba(255, 255, 255, 0.92);
        }

        .company-listing-section {
            position: relative;
            padding: 58px 0 70px;
            background: linear-gradient(180deg, #f8fbff 0%, #ffffff 46%, #f7fbff 100%);
        }

        .companies-filter-card {
            margin: -12px auto 42px;
            padding: 18px;
            max-width: 960px;
            border: 1px solid #e7eef8;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.94);
            box-shadow: 0 18px 55px rgba(15, 63, 102, 0.10);
        }

        .companies-filter-inner {
            display: flex;
            gap: 16px;
            align-items: center;
            justify-content: space-between;
        }

        .companies-filter-title {
            flex: 0 0 auto;
        }

        .companies-filter-title span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
            font-size: 12px;
            font-weight: 800;
            color: #0d82a3;
            letter-spacing: .2px;
        }

        .companies-filter-title h2 {
            margin: 0;
            color: #0d3153;
            font-size: 22px;
            font-weight: 800;
        }

        .companies-search-box {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            max-width: 520px;
            padding: 8px;
            border: 1px solid #dbe7f3;
            border-radius: 18px;
            background: #f8fbff;
        }

        .companies-search-box .form-control {
            height: 46px;
            border: 0;
            box-shadow: none;
            background: transparent;
            color: #16324f;
            font-size: 14px;
        }

        .companies-search-box .form-control::placeholder {
            color: #8aa0b8;
        }

        .companies-search-box .btn.our-btn {
            min-width: 104px;
            height: 46px;
            border: 0;
            border-radius: 14px;
            color: #fff;
            font-weight: 800;
            background: linear-gradient(135deg, #0d82a3, #075c91);
            box-shadow: 0 12px 22px rgba(13, 130, 163, .24);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .companies-search-box .btn.our-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 28px rgba(13, 130, 163, .30);
        }

        .companies-grid {
            row-gap: 26px;
        }

        .company-card {
            position: relative;
            display: flex;
            min-height: 100%;
            overflow: hidden;
            border: 1px solid #e7eef8;
            border-radius: 26px;
            background: #fff;
            color: inherit;
            text-decoration: none !important;
            box-shadow: 0 18px 48px rgba(15, 63, 102, 0.10);
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
        }

        .company-card:hover {
            transform: translateY(-6px);
            border-color: rgba(13, 130, 163, .34);
            box-shadow: 0 28px 70px rgba(15, 63, 102, 0.16);
        }

        .company-image-wrap {
            position: relative;
            flex: 0 0 270px;
            min-height: 230px;
            overflow: hidden;
            background: #edf5fb;
        }

        .company-image-wrap img {
            width: 100%;
            height: 100%;
            min-height: 230px;
            object-fit: cover;
            transition: transform .28s ease;
        }

        .company-card:hover .company-image-wrap img {
            transform: scale(1.045);
        }

        .company-date-badge {
            position: absolute;
            top: 14px;
            inset-inline-start: 14px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 12px;
            border-radius: 999px;
            color: #0d3153;
            font-size: 12px;
            font-weight: 800;
            background: rgba(255, 255, 255, .93);
            box-shadow: 0 10px 22px rgba(0, 0, 0, .12);
            backdrop-filter: blur(8px);
        }

        .company-card-content {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding: 24px 24px 22px;
        }

        .company-title {
            margin: 0 0 10px;
            color: #0d3153;
            font-size: 21px;
            line-height: 1.45;
            font-weight: 900;
        }

        .company-description {
            margin: 0 0 18px;
            color: #60758d;
            font-size: 14px;
            line-height: 1.9;
        }

        .company-details-list {
            display: grid;
            gap: 12px;
            margin-top: auto;
        }

        .company-detail-item {
            display: flex;
            gap: 11px;
            align-items: flex-start;
            padding: 12px 13px;
            border: 1px solid #edf3f9;
            border-radius: 16px;
            background: #f8fbff;
        }

        .company-detail-item i {
            display: inline-flex;
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            color: #0d82a3;
            background: rgba(13, 130, 163, .11);
        }

        .company-detail-item span {
            display: block;
            margin-bottom: 2px;
            color: #8aa0b8;
            font-size: 12px;
            font-weight: 800;
        }

        .company-detail-item strong {
            display: block;
            color: #193a5b;
            font-size: 13px;
            line-height: 1.65;
            font-weight: 800;
        }

        .company-view-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            margin-top: 18px;
            padding: 10px 15px;
            border-radius: 999px;
            color: #fff;
            font-size: 13px;
            font-weight: 900;
            background: linear-gradient(135deg, #0d82a3, #075c91);
            box-shadow: 0 12px 24px rgba(13, 130, 163, .22);
        }

        .companies-empty-state {
            padding: 44px 24px;
            border: 1px dashed #cbdbea;
            border-radius: 26px;
            text-align: center;
            color: #60758d;
            background: #fff;
        }

        .companies-pagination {
            margin-top: 34px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 991px) {
            .company-card {
                flex-direction: column;
            }

            .company-image-wrap {
                flex-basis: auto;
                min-height: 240px;
            }
        }

        @media (max-width: 767px) {
            .companies-page-hero.hero-banner {
                min-height: 220px;
            }

            .companies-page-hero .hero__p {
                padding: 22px 18px;
                border-radius: 20px;
            }

            .companies-filter-inner,
            .companies-search-box {
                flex-direction: column;
                align-items: stretch;
            }

            .companies-filter-card {
                margin-bottom: 28px;
                border-radius: 22px;
            }

            .companies-search-box .btn.our-btn {
                width: 100%;
            }
        }
    </style>

    <div class="image-cover hero-banner companies-page-hero" style="background:url('{{ URL::to('/').'/'.$getService->image}}') no-repeat;">

        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="hero__p">

                        <h1>
                            @if(!empty($getService->Service))
                                @if(App::isLocale('ar'))
                                    {{$getService->Service}}
                                @else
                                    {{$getService->Service_en}}
                                @endif
                            @endif


                        </h1>


                        <p>@if(!empty($getService->description))

                                @if(App::isLocale('ar'))
                                    {{$getService->description}}
                                @else
                                    {{$getService->description_en}}
                                @endif
                            @endif</p>

                    </div>

                </div>

            </div>


        </div>

    </div>


    <section class="articels company-listing-section" dir="{{ App::isLocale('ar') ? 'rtl' : 'ltr' }}">

        <div class="container">

            <div class="companies-filter-card">
                <form
                    action="{{  URL::to('/'.Config::get('app.locale').'/ourcompanies-'.$getService->slug.'/filterby') }}"
                    id="sortform" method="get">
                    @csrf

                    <div class="companies-filter-inner">
                        <div class="companies-filter-title">
                            <span>
                                <i class="fa fa-building-o"></i>
                                {{ App::isLocale('ar') ? 'دليل الشركات' : 'Companies Directory' }}
                            </span>
                            <h2>{{ App::isLocale('ar') ? 'اختر الشركة المناسبة لك' : 'Find the right company' }}</h2>
                        </div>

                        <div class="companies-search-box">
                            <input
                                name="keywords"
                                type="text"
                                class="form-control"
                                placeholder="{{ App::isLocale('ar') ? 'ابحث باسم الشركة أو العنوان' : 'Search by company name or address' }}"
                                value="{{ request('keywords') }}"
                                tabindex="0">
                            <input type="submit" class="btn our-btn" value="{{ trans('langsite.search')}}"/>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row companies-grid">
                @forelse ($companies as $company)
                    @php
                        $isArabic = App::isLocale('ar');

                        $companyName = $isArabic
                            ? ($company->Name ?? $company->name_en ?? '')
                            : ($company->name_en ?? $company->Name ?? '');

                        $companyDescription = $isArabic
                            ? ($company->description ?? $company->description_en ?? '')
                            : ($company->description_en ?? $company->description ?? '');

                        $companyImage = !empty($company->photo)
                            ? URL::to('/').'/images/'.$company->photo
                            : 'https://rightchoice-co.com/images/FBO.png';

                        $companyDate = '';
                        if (!empty($company->created_at)) {
                            try {
                                $companyDate = \Carbon\Carbon::parse($company->created_at)->format('Y/m/d');
                            } catch (\Exception $exception) {
                                $companyDate = $company->created_at;
                            }
                        }

                        $addressParts = [];
                        foreach (['address', 'Address', 'company_address', 'companyAddress', 'location', 'street'] as $addressField) {
                            if (!empty($company->{$addressField})) {
                                $addressParts[] = trim($company->{$addressField});
                                break;
                            }
                        }

                        if (!empty($company->governrateq) && !empty($company->governrateq->governrate)) {
                            $addressParts[] = $company->governrateq->governrate;
                        }

                        if (!empty($company->districte) && !empty($company->districte->district)) {
                            $addressParts[] = $company->districte->district;
                        }

                        $companyAddress = implode(' - ', array_unique(array_filter($addressParts)));
                    @endphp

                    <div class="col-lg-6 col-md-12 col-12">
                        <a class="company-card" target="_blank"
                           href="{{ URL::to(Config::get('app.locale').'/companies/' . $company->slug) }}">

                            <div class="company-image-wrap">
                                <img src="{{ $companyImage }}" class="img-fluid" alt="{{ $companyName ?: 'company' }}">

                                @if($companyDate)
                                    <span class="company-date-badge">
                                        <i class="fa fa-calendar"></i>
                                        {{ $companyDate }}
                                    </span>
                                @endif
                            </div>

                            <div class="company-card-content">
                                <h3 class="company-title">{{ $companyName }}</h3>

                                @if(!empty($companyDescription))
                                    <p class="company-description">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($companyDescription), 150, '...') }}
                                    </p>
                                @endif

                                <div class="company-details-list">
                                    @if($companyDate)
                                        <div class="company-detail-item">
                                            <i class="fa fa-clock-o"></i>
                                            <div>
                                                <span>{{ App::isLocale('ar') ? 'تاريخ إضافة الشركة' : 'Added date' }}</span>
                                                <strong>{{ $companyDate }}</strong>
                                            </div>
                                        </div>
                                    @endif

                                    @if($companyAddress)
                                        <div class="company-detail-item">
                                            <i class="fa fa-map-marker"></i>
                                            <div>
                                                <span>{{ App::isLocale('ar') ? 'عنوان الشركة' : 'Company address' }}</span>
                                                <strong>{{ $companyAddress }}</strong>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <span class="company-view-link">
                                    {{ App::isLocale('ar') ? 'عرض تفاصيل الشركة' : 'View company details' }}
                                    <i class="fa {{ App::isLocale('ar') ? 'fa-long-arrow-left' : 'fa-long-arrow-right' }}"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="companies-empty-state">
                            <i class="fa fa-search" style="font-size: 34px; margin-bottom: 12px; color: #0d82a3;"></i>
                            <h3>{{ App::isLocale('ar') ? 'لا توجد شركات مطابقة للبحث' : 'No matching companies found' }}</h3>
                            <p>{{ App::isLocale('ar') ? 'جرّب البحث بكلمة مختلفة أو تصفح كل الشركات.' : 'Try another keyword or browse all companies.' }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="companies-pagination">
                {{ $companies->links() }}
            </div>

        </div>

    </section>

    <section>


        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle">العقارات المميزه</h2>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">

                        @foreach ($allAqars as $aqarSim)
                            <div class="single-items">
                                <div class="property-listing shadow-none property-2 border bg-light">

                                    <div class="listing-img-wrapper">

                                        <div class="list-img-slide">
                                            <div class="click">

                                                <!--   @foreach ($aqarSim->images as $images_url)
                                                    <div><a href="{{ URL::to('aqars/' . $aqarSim->slug) }}"><img
                                            src="{{ URL::to('/').'/images/'.$images_url->img_url}}"
                                            class="img-fluid mx-auto" alt="" /></a></div>
                                        @endforeach-->

                                                    <div>
                                                        <a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
                                                           target="_blank">

                                                            @if($aqarSim->mainImage)
                                                                <img
                                                                    src="{{ URL::to('/').'/images/'.$aqarSim->mainImage->img_url}}"
                                                                    class="img-fluid mx-auto" alt="main">

                                                            @else

                                                                @if($aqarSim->firstImage)
                                                                    <img
                                                                        src="{{ URL::to('/').'/images/'.$aqarSim->firstImage->img_url}}"
                                                                        class="img-fluid mx-auto" alt=""/>
                                                                @else
                                                                    <img src="https://rightchoice-co.com/images/FBO.png"
                                                                         class="img-fluid main-img"
                                                                         alt="main">
                                                                @endif
                                                            @endif

                                                        </a></div>


                                            </div>
                                        </div>
                                        <div class="views">

                                            <div class="views-2">
                                                <i class="fa fa-eye"></i>
                                                <span>{{ $aqarSim->views }}</span>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="listing-detail-wrapper">
                                        <div class="listing-short-detail-wrap">
                                            <div class="listing-short-detail">
                                                <h4 class="listing-name verified center-name"><a target="_blank"
                                                                                                 href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
                                                                                                 class=""
                                                                                                 target="_blank">{{ \Illuminate\Support\Str::limit($aqarSim->title, $limit = 33, $end = '...') }}</a>
                                                </h4>
                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
                                            </div>

                                        </div>

                                    </div>
                                    <div class="listing-short-detail-flex">
                                        @if ($aqarSim->offer_type == 1 || $aqarSim->offer_type == 2)

                                            <h6 class="listing-card-info-price">{{ $aqarSim->total_price }} {{ trans('langsite.egyptian_pound') }}</h6>

                                        @endif
                                        @if ($aqarSim->offer_type == 3 || $aqarSim->offer_type == 4)
                                            <h6 class="listing-card-info-price">{{ $aqarSim->monthly_rent }} {{ trans('langsite.egyptian_pound') }}</h6>

                                        @endif

                                    </div>
                                    <div class="price-features-wrapper">
                                        <div class="list-fx-features">


                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->baths }} حمام
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/bath.png') }}" width="12"
                                                        alt=""/></div>
                                            </div>
                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->rooms }} غرف
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/room.png') }}" width="12"
                                                        alt=""/></div>
                                            </div>

                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->total_area }} م²
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/area.png') }}" width="12"
                                                        alt=""/></div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="listing-detail-footer">
                                        <div class="footer-first">
                                            <div class="foot-location">

                                                @if ($aqarSim->governrateq)

                                                    {{ $aqarSim->governrateq->governrate }}
                                                @endif

                                                @if ($aqarSim->districte)

                                                    {{ $aqarSim->districte->district }}
                                                @endif


                                                <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt=""/>
                                            </div>
                                        </div>
                                        <div class="footer-flex">
                                            <a target="_blank"
                                               href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
                                               class="prt-view" target="_blank">عرض</a>
                                            <!-- <a href="property-detail.html" class="prt-view">View</a> -->
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach


                    </div>
                </div>
            </div>
        </div>


    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#sorting').on('change', function () {
                var idCountry = this.value;
                $("#location2").html('');
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#location2').html('<option value="" selected disabled  >الحي</option>');
                        $.each(result.states, function (key, value) {
                            $("#location2").append('<option value="' + value
                                .id + '">' + value.district + '</option>');
                        });
                    }
                });
            });

        });

    </script>

</x-layout>
