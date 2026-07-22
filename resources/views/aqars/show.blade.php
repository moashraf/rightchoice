<x-layout>

    @section('title')
        {{ $aqar->title }}
    @endsection

    @php
        $aqarImg = null;
        if (!empty($aqar->mainImage->img_url)) {
            $aqarImg = URL::to('/') . '/images/' . $aqar->mainImage->img_url;
        } elseif (!empty($aqar->firstImage->img_url)) {
            $aqarImg = URL::to('/') . '/images/' . $aqar->firstImage->img_url;
        }
        $aqarDesc = strip_tags($aqar->description ?? '');
        $aqarDesc = \Illuminate\Support\Str::limit($aqarDesc, 200);
        if (!$aqarDesc) {
            $parts = [];
            if ($aqar->governrateq) $parts[] = $aqar->governrateq->governrate;
            if ($aqar->districte)   $parts[] = $aqar->districte->district;
            if ($aqar->total_area)  $parts[] = $aqar->total_area . ' م²';
            $aqarDesc = implode(' - ', $parts);
        }
    @endphp

    @if($aqarImg)
        @section('og_image', $aqarImg)
    @endif

    @if($aqarDesc)
        @section('og_description', $aqarDesc)
    @endif
    <section id="inner-listing" class="property-show-modern" dir="rtl">
        <div class="container">
{{--            <x-ads :randomAds="$random_ads ?? null"/>--}}
            <div class="property-page-heading">
                <div class="property-page-heading__content">
                    <span class="property-kicker">
                        <i class="fas fa-building"></i>
                        تفاصيل العقار
                    </span>

                    <h1 class="property-page-title">{{ $aqar->title }}</h1>

                    <div class="property-page-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>
                            @if ($aqar->governrateq)
                                {{ $aqar->governrateq->governrate }}
                            @endif
                            @if ($aqar->districte)
                                <span class="property-location-separator">،</span>
                                {{ $aqar->districte->district }}
                            @endif
                            @if ($aqar->subAreaa)
                                <span class="property-location-separator">،</span>
                                {{ $aqar->subAreaa->area }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="property-page-heading__badges">
                    @if ($aqar->offerTypes)
                        <span class="property-heading-badge property-heading-badge--primary">
                            {{ $aqar->offerTypes->type_offer }}
                        </span>
                    @endif

                    @if ($aqar->vip == 1 && \Carbon\Carbon::now()->diffInYears($aqar->created_at) < 1)
                        <span class="property-heading-badge property-heading-badge--accent">
                            <i class="fas fa-star"></i>
                            عقار مميز
                        </span>
                    @endif
                </div>
            </div>

            <div class="row property-layout">
                <div class="col-lg-4 property-sidebar-column">
                    <div class="sticky property-sidebar-sticky">

                        <div class="card property-summary-card">
                            <div class="card-body property-summary-card__body">
                                <h4 class="headingTitle2">{{ $aqar->title }}</h4>

                                <div dir="rtl">
                                    @if ($aqar->offer_type == 1 || $aqar->offer_type == 1 || $aqar->offer_type == 5)

                                        <h5> {{ $aqar->total_price }} {{ trans('langsite.egyptian_pound') }}</h5>
                                    @endif
                                    @if ($aqar->offer_type == 3 || $aqar->offer_type == 4 )

                                        <h5> {{ $aqar->monthly_rent }} {{ trans('langsite.egyptian_pound') }}</h5>
                                        @if ($aqar->daily_rent)
                                            <h6 class="text-muted"> الايجار
                                                اليومي: {{ $aqar->daily_rent }} {{ trans('langsite.egyptian_pound') }}</h6>
                                        @endif
                                    @endif
                                </div>

                                <div class="fr-grid-deatil-flex details mt-3">

                                    <div class="listing-card-info-icon">
                                        {{ $aqar->total_area }}{{ trans('langsite.meterS')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/area.png')}}"
                                                                         width="13" alt=""/></div>
                                    </div>

                                    <div class="listing-card-info-icon">
                                        {{ $aqar->rooms }} {{ trans('langsite.rooms')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/room.png')}}"
                                                                         width="13" alt=""/></div>
                                    </div>

                                    <div class="listing-card-info-icon">
                                        {{ $aqar->baths }} {{ trans('langsite.bathroom')}}
                                        <div class="inc-fleat-icon">
                                            <img src="{{asset('images/icons/bath.png')}}"
                                                                         width="13" alt=""/>
                                        </div>
                                    </div>
                                    <br/> <br/>
                                    <div class="listing-card-info-icon">
                                        @if ($aqar->governrateq)
                                            {{ $aqar->governrateq->governrate }}
                                        @endif

                                        @if ($aqar->districte)
                                            ,
                                            {{ $aqar->districte->district }}
                                        @endif


                                        <div class="inc-fleat-icon">
                                            <img src="{{asset('images/icons/location.png')}}" width="13" alt=""/>
                                        </div>
                                    </div>

                                </div>
                                <hr class="hr-add">

                                <div class="text-center property-action-grid">

                                    @if(Auth::user())
                                        @if(Auth::user()->isCompanyAccount())
                                            <div class="alert alert-warning" style="font-size:14px;">
                                                <i class="fa fa-ban ml-1"></i>
                                                حسابات الشركات غير مسموح لها بمشاهدة أرقام التواصل للعقارات.
                                            </div>
                                        @else
                                                <?php if ($show && $aqar->user != null){ ?>
                                            <div id="contMop">
                                                @if($show2)
                                                    <a class="btn btn-success"
                                                       href="tel:{{ $aqar->user->MOP }}">
                                                        {{ $aqar->user->MOP }}
                                                    </a>

                                                    @php
                                                        $whatsappPhone = preg_replace('/[^0-9]/', '', $aqar->user->MOP ?? '');
                                                        if (!str_starts_with($whatsappPhone, '20')) {
                                                            $whatsappPhone = '20' . ltrim($whatsappPhone, '0');
                                                        }
                                                        $whatsappMsg = urlencode(
                                                            "السلام عليكم، أنا مهتم بالعقار التالي:\n" .
                                                            "العنوان: " . ($aqar->title ?? '') . "\n" .
                                                            "المساحة: " . ($aqar->total_area ?? '') . " م²\n" .
                                                            "الغرف: " . ($aqar->rooms ?? '') . "\n" .
                                                            "السعر: " . ($aqar->total_price ?? $aqar->monthly_rent ?? '') . " جنيه\n" .
                                                            "رابط العقار: " . url()->current()
                                                        );
                                                    @endphp
                                                    <a href="https://wa.me/{{ $whatsappPhone }}?text={{ $whatsappMsg }}"
                                                       target="_blank"
                                                       class=" normal_normal btn btn-success  "
                                                       style="background-color:#25D366; border-color:#25D366;"
                                                       onclick="trackWhatsappContact({{ $aqar->id }})">
                                                        <img src="https://img.icons8.com/color/20/000000/whatsapp--v1.png"
                                                             width="20" height="20"/>
                                                        واتساب
                                                    </a>

                                                    <script>
                                                        function trackWhatsappContact(aqarId) {
                                                            fetch('{{ route("track-whatsapp-contact") }}', {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/json',
                                                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                                },
                                                                body: JSON.stringify({ aqar_id: aqarId })
                                                            }).catch(function(){});
                                                        }
                                                    </script>

                                                @else

                                                    <button
                                                        onclick="document.getElementById('myModal').style.display = 'block'"
                                                        class="btn btn-success">اظهر الرقم
                                                    </button>
                                                @endif
                                            </div>

                                            <?php }else{ ?>

                                            <a id="notShow" href="#"
                                               onclick="document.getElementById('myModal2').style.display = 'block'"
                                               class="btn btn-success mt-3"><img
                                                    src="https://img.icons8.com/carbon-copy/50/000000/phone.png" width="20"
                                                    height="20"/>اتصال</a>



                                            <?php } ?>

                                        @endif



                                        <a style="width:30%" href="#"
                                           class="btn btn-light ml-1 mr-1 addToCart {{--<?php if(isset($show)){ echo 'mt-3'; } ?>--}}"
                                           data-id="{{$aqar['id']}}"> {{ trans('langsite.save')}}</a>

                                    @else
                                        <form action="{{ route('redirectBack',Config::get('app.locale')) }}"
                                              method="post">
                                            @csrf
                                            <input type="submit" value="تواصل مع المالك" class="btn btn-success"/>
                                            <input type="submit" value="حفظ" class="btn btn-light"/>

                                        </form>

                                    @endif


                                    <a style="width:30%" class="btn our-btn {{--<?php if(@show){ echo 'mt-3'; } ?>--}}"
                                       id="trigger-2">{{ trans('langsite.sharing')}}</a>

                                    <button type="button" class="btn btn-compare-toggle mt-2"
                                            data-compare-id="{{ $aqar->id }}" style="width:30%;">
                                        <i class="fas fa-balance-scale"></i> قارن
                                    </button>

                                </div>
                                <!--  <img src="https://al-kafigroup.com/images/vhjfhgc.jpeg" class="img-thumbnail">-->

                                <hr class="hr-add">
                                <div style="padding:8px;">
                                    <x-purchase-now/>

                                </div>

                                <hr class="hr-add">


                                <div class="text-center">
                                    <a class="btn our-btn" id="trigger">{{ trans('langsite.click_here')}}</a>

                                    <p class="mt-3">
                                        {{ trans('langsite.report_problem')}}
                                    </p>


                                </div>


                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-lg-8 property-content-column">
                    <div class="images property-gallery-card" dir="ltr">


                        @if($aqar->mainImage)
                            <a href="{{ URL::to('/').'/images/'.$aqar->mainImage->img_url}}" data-lightbox="roadtrip">
                                <div class="watermarked">
                                    <img src="{{ URL::to('/').'/images/'.$aqar->mainImage->img_url}}"
                                         class="img-fluid main-img" alt="main">
                                </div>
                                @else


                                    @if($aqar->firstImage)
                                        <a href="{{ URL::to('/').'/images/'.$aqar->firstImage->img_url}}"
                                           data-lightbox="roadtrip">
                                            <div class="watermarked">

                                                <img src="{{ URL::to('/').'/images/'.$aqar->firstImage->img_url}}"
                                                     class="img-fluid main-img" alt="main">
                                            </div>


                                            @else
                                                <img src="https://rightchoice-co.com/images/FBO.png"
                                                     class="img-fluid main-img"
                                                     alt="main">

                                            @endif


                                            @endif


                                        </a>
                                        <?php if ($aqar->vip == 1 && \Carbon\Carbon::now()->diffInYears($aqar->created_at) < 1){ ?>

                                        <div class="views" style=" left: 13px;">
                                            <div class="views-1">مميز</div>
                                        </div>
                                        <?php } ?>

                                        <?php if (\Carbon\Carbon::now()->diffInYears($aqar->created_at) >= 1){ ?>
                                        <div class="views " style="left: 13px;">
                                            <div class="viewsRed">غير متاح</div>
                                        </div>
                                        <?php } ?>


                                        <div class="lazy" dir="ltr">
                                            @foreach( $aqar->images as $images_url)
                                                @if($images_url)

                                                    <a href="{{ URL::to('/').'/images/'.$images_url->img_url}}"
                                                       data-lightbox="roadtrip">
                                                        <div class="watermarked">
                                                            <img src="{{ URL::to('/').'/images/'.$images_url->img_url}}"
                                                                 class="img-thumbnail">

                                                        </div>
                                                    </a>
                                                        <?php //$image_info = exif_read_data("https://rightchoice-co.com/images/$images_url->img_url"); print_r( $image_info);  ?>

                                                @endif
                                            @endforeach


                                        </div>



                                        @if($aqar->firstImage)
                                            <a href="{{ URL::to('/').'/images/'.$aqar->firstImage->img_url}}"
                                               data-lightbox="roadtrip" class="btn btn-light lightbtn">
                                                <b>  {{ trans('langsite.show_photos')}}
                                                    ( <?php echo($aqar->images->count()); ?> )
                                                </b>
                                                <img src="https://img.icons8.com/carbon-copy/100/000000/camera--v1.png"
                                                     width="20"
                                                     height="20"/></a>
                                        @endif



                                        <div class="details mt-3">
                                            <h3 class="headingTitle2">{{ trans('langsite.details')}}</h3>

                                            <div class="fr-grid-deatil-flex">
                                                <div class="listing-card-info-icon">
                                                    @if ($aqar->governrateq)
                                                        {{ $aqar->governrateq->governrate }}
                                                    @endif @if ($aqar->districte)
                                                        ,
                                                        {{ $aqar->districte->district }}
                                                    @endif @if ($aqar->subAreaa)
                                                        ,
                                                        {{ $aqar->subAreaa->area }}
                                                    @endif

                                                    @if ($aqar->compounds)
                                                        ,
                                                        {{ $aqar->compounds->compound }}
                                                    @endif

                                                    <div class="inc-fleat-icon"><img
                                                            src="{{asset('images/icons/location.png')}}"
                                                            width="13" alt=""/></div>
                                                </div>


                                                @if($aqar->ref_code)

                                                    <div class="listing-card-info-icon">
                                                        <small class="text-muted"
                                                               style="font-size:11px; display:block;">
                                                                &nbsp; رقم مرجعي &nbsp;
                                                        </small>
                                                        <span>
                                                            {{ $aqar->ref_code }}
                                                            </span>

                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('images/icons/counter.png')}}"
                                                                width="13" alt=""/>
                                                        </div>
                                                    </div>

                                                @endif

                                                <div class="listing-card-info-icon">
                                                    عدد المشاهدات

                                                    {{ $aqar->views }}

                                                    <div class="fa fa-eye"></div>

                                                </div>


                                                <div class="listing-card-info-icon">

                                                    تاريخ الاعلان


                                                    {{ date('d/m/Y', strtotime($aqar->created_at))  }}

                                                    <div class="inc-fleat-icon"><img
                                                            src="{{asset('images/icons/calnder.png')}}"
                                                            width="13" alt=""/></div>

                                                </div>

                                            </div>
                                            <div class="fr-grid-deatil-flex">

                                                @if ($aqar->offer_type == 1 || $aqar->offer_type == 1 || $aqar->offer_type == 5 ||
                                                $aqar->offer_type == 2)
                                                    @if ($aqar->total_price)
                                                        <div class="listing-card-info-icon">
                                                            {{ $aqar->total_price }} {{ trans('langsite.egyptian_pound')}}
                                                            <div class="inc-fleat-icon"><img
                                                                    src="{{asset('images/icons/cash.png')}}"
                                                                    width="13" alt=""/></div>
                                                        </div>
                                                    @endif
                                                @endif
                                                @if ($aqar->offer_type == 3 || $aqar->offer_type == 4 )
                                                    @if ($aqar->monthly_rent)
                                                        <div class="listing-card-info-icon">
                                                            {{ $aqar->monthly_rent }} {{ trans('langsite.egyptian_pound')}}
                                                            <div class="inc-fleat-icon"><img
                                                                    src="{{asset('images/icons/cash.png')}}"
                                                                    width="13" alt=""/></div>
                                                        </div>
                                                    @endif
                                                    @if ($aqar->daily_rent)
                                                        <div class="listing-card-info-icon">
                                                            الايجار
                                                            اليومي: {{ $aqar->daily_rent }} {{ trans('langsite.egyptian_pound')}}
                                                            <div class="inc-fleat-icon"><img
                                                                    src="{{asset('images/icons/cash.png')}}"
                                                                    width="13" alt=""/></div>
                                                        </div>
                                                    @endif
                                                @endif


                                                <div class="listing-card-info-icon">
                                                    {{ $aqar->offerTypes->type_offer }}
                                                    <div class="inc-fleat-icon"><img
                                                            src="{{asset('images/icons/cash.png')}}" width="13" alt=""/>
                                                    </div>
                                                </div>
                                                <?php if ($aqar->offer_type == 2){ ?>

                                                <div class="listing-card-info-icon">
                                                    {{ trans('langsite.offered')}} {{ $aqar->downpayment }}
                                                    <div class="inc-fleat-icon">
                                                        <img src="{{asset('images/icons/downpayment.png')}}"
                                                             width="13" alt=""/></div>
                                                </div>

                                                <div class="listing-card-info-icon">
                                                    مده التقسيط
                                                    {{ $aqar->installment_time }} {{ trans('langsite.month')}}
                                                    <div class="inc-fleat-icon">
                                                        <img src="{{asset('images/icons/cash.png')}}"
                                                             width="13" alt=""/></div>
                                                </div>

                                                    <?php if ($aqar->rec_time){ ?>
                                                <div class="rec_timerec_time listing-card-info-icon">
                                                    {{ trans('langsite.Receipt_time')}}
                                                    {{ $aqar->rec_time }}
                                                    <div class="inc-fleat-icon">
                                                        <img src="{{asset('images/icons/clock.png')}}" width="13"
                                                             alt=""/>
                                                    </div>
                                                </div>
                                                <?php } ?>

                                                    <!--<div class="listing-card-info-icon">
                        {{ $aqar->installment_value }} {{ trans('langsite.value_installment')}}
                                                <div class="inc-fleat-icon"><img src="{{asset('images/icons/installment.png')}}" width="13" alt="" /></div>
                                              </div>-->

                                                <?php } ?>


                                            </div>
                                            <div class="propertyTypepropertyType fr-grid-deatil-flex">
                                                @if ( $aqar->propertyType)
                                                    <div class="propertyType_propertyType listing-card-info-icon">
                                                        {{ $aqar->propertyType->property_type }}
                                                        <div class="inc-fleat-icon">
                                                            <img src="{{ asset('images/icons/room.png') }}" width="13"
                                                                 alt=""/>
                                                        </div>
                                                    </div>

                                                @endif

                                                @if ($aqar->categoryRel)
                                                    <div class="listing-card-info-icon">
                                                        {{ app()->getLocale() === 'en' && $aqar->categoryRel->category_name_en
                                                            ? $aqar->categoryRel->category_name_en
                                                            : $aqar->categoryRel->category_name }}
                                                        <div class="inc-fleat-icon">
                                                            <img src="{{ asset('images/icons/category.png') }}"
                                                                 width="13" alt=""/>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if ($aqar->number_of_floors)
                                                    <div class="listing-card-info-icon">
                                                        {{ $aqar->number_of_floors }} {{ trans('langsite.number_floor')}}
                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('assets/img/city.svg')}}"
                                                                width="13" alt=""/></div>
                                                    </div>
                                                @endif
                                                <div class="listing-card-info-icon">
                                                    {{ $aqar->total_area }} {{ trans('langsite.meterS')}}
                                                    <div class="inc-fleat-icon"><img
                                                            src="{{asset('images/icons/area.png')}}"
                                                            width="13" alt=""/></div>
                                                </div>

                                                @if ($aqar->floorNo)
                                                    <div class="listing-card-info-icon">
                                                        {{ trans('langsite.floor')}} {{ $aqar->floorNo->floor }}

                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('assets/img/city.svg')}}"
                                                                width="13" alt=""/></div>
                                                    </div>
                                                @endif
                                                @if ($aqar->rooms)
                                                    <div class="listing-card-info-icon">
                                                        {{ $aqar->rooms }} {{ trans('langsite.rooms')}}
                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('images/icons/room.png')}}"
                                                                width="13" alt=""/></div>
                                                    </div>

                                                @endif
                                                @if ($aqar->baths)
                                                    <div class="listing-card-info-icon">
                                                        {{ $aqar->baths }} {{ trans('langsite.bathroom')}}
                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('images/icons/bath.png')}}"
                                                                width="13" alt=""/></div>
                                                    </div>

                                                @endif
                                                @if ( $aqar->finishType)
                                                    <div class="finishTypefinishType listing-card-info-icon">
                                                        {{ $aqar->finishType->finish_type }}
                                                        <div class="inc-fleat-icon"><img
                                                                src="{{asset('images/icons/finish.png')}}"
                                                                width="13" alt=""/></div>
                                                    </div>
                                                @endif

                                            </div>

                                        </div>

                                        <div class="fr-grid-deatil-flex">
                                            <?php if ($aqar->finannce_bank == 1){ ?>
                                            <div class="listing-card-info-icon">
                                                {{ trans('langsite.Suitable')}}
                                                <div class="inc-fleat-icon"><img
                                                        src="{{asset('images/icons/bank.png')}}" width="13"
                                                        alt=""/></div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($aqar->trade == 1){ ?>
                                            <div class="listing-card-info-icon">
                                                {{ trans('langsite.suitable_sale')}}
                                                <div class="inc-fleat-icon"><img
                                                        src="{{asset('images/icons/trade.png')}}"
                                                        width="13" alt=""/></div>
                                            </div>
                                            <?php } ?>
                                            <?php if ($aqar->licensed == 1){ ?>
                                            <div class="listing-card-info-icon">
                                                {{ trans('langsite.Registered')}}
                                                <div class="inc-fleat-icon"><img
                                                        src="{{asset('images/icons/signed.png')}}"
                                                        width="13" alt=""/></div>
                                            </div>

                                            <?php } ?>
                                        </div>
                                        <br/>
                                        <br/>

                                        <h3 class="headingTitle2">{{ trans('langsite.Advantages')}}</h3>
                                        <div class="details">
                                            <div class="fr-grid-deatil-flex">


                                                @if ($aqar->mzaya)
                                                    @foreach ($aqar->mzaya as $maz)
                                                        <div class="listing-card-info-icon">
                                                            {{ $maz->mzaya_type }}

                                                            <div class="inc-fleat-icon"><img
                                                                    src="{{asset('images/icons').'/'.$maz->img_name}}"
                                                                    width="13" alt=""/>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif


                                            </div>
                                        </div>

                    </div>

                    <div class="details mt-3">
                        <br>
                        <h3 class="headingTitle2"> {{ trans('langsite.moreDetails')}}</h3>
                        <p style=" background: #f5fcff; font-weight: bold;      padding: 10px; ">
                            <!--{{ $aqar->id }},
                    {{ date('d/m/Y', strtotime($aqar->created_at))  }},
                  -->
                            الاوقات المناسبه للاتصال بالمالك

                            @if ($aqar->callTimes)

                                {{ $aqar->callTimes->call_time }}
                            @endif

                        </p>


                        <p>
                        <div id="small_text_show">
                            <?php

                            $eastern_arabic = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            $western_arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
                            $str = str_replace($western_arabic, $eastern_arabic, $aqar->description) ?? '';
                            $str = preg_replace('/(\+?[\d\s\-]{7,15})/', ' ', $str);
                            $data_final = preg_replace('/[^\w\s]+/u', ' ', $str);

                            echo \Illuminate\Support\Str::limit($data_final, 500, '');
                            ?>

                        </div>
                        @if (\Illuminate\Support\Str::length($aqar->description) > 500)
                            <span id="dots">...</span>
                            <span id="more">
                                     <?php echo $data_final; ?>
                                </span>

                            <a class="btnMore" onclick="myFunction()" id="myBtn"> اقرا المزيد</a>

                            @endif

                            </p>
                            <style>
                                #more {
                                    display: none;
                                }

                                .btnMore {
                                    color: #0fca98 !important;
                                }
                            </style>

                    </div>
                    <?php if ($aqar->user != null){ ?>

                    <div class="same-owner property-owner-card mt-5">

                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                             width="80">

                        <span>{{$aqar->user->name}}</span>

                    </div>
                    <?php } ?>


                </div>

            </div>


        </div>

    </section>

    <section class="property-similar-modern" dir="ltr">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle"> {{ trans('langsite.similar_properties') }} </h2>
                        <p>
                            {{ trans('langsite.similar_properties_desc') }}
                        </p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">

                        @foreach ($allAqars as $aqarSim)
                            <div class="single-items">
                                <div class="property-listing shadow-none property-2 border property-similar-card">

                                    <div class="listing-img-wrapper">

                                        <div class="list-img-slide">
                                            <div class="click">

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


                                                    </a>


                                                </div>
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
                                                <h4 class="listing-name verified center-name"><a
                                                        href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
                                                        class=""
                                                        target="_blank">{{ \Illuminate\Support\Str::limit($aqarSim->title, $limit = 29, $end = '...') }}</a>
                                                </h4>
                                                <!-- <h4 class="listing-name verified">
                                                <a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a>
                                                </h4>
                                                 -->
                                            </div>

                                        </div>

                                    </div>
                                    <div class="listing-short-detail-flex">
                                        @if ($aqarSim->offer_type == 1 || $aqarSim->offer_type == 2)

                                            <h6 class="listing-card-info-price">
                                                {{ $aqarSim->total_price }}
                                                {{ trans('langsite.egyptian_pound') }}</h6>

                                        @endif
                                        @if ($aqarSim->offer_type == 3 || $aqarSim->offer_type == 4)
                                            <h6 class="listing-card-info-price">{{ $aqarSim->monthly_rent }}
                                                {{ trans('langsite.egyptian_pound') }}
                                            </h6>

                                        @endif

                                    </div>
                                    <div class="price-features-wrapper">
                                        <div class="list-fx-features">
                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->baths }} حمام
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/bath.png') }}"
                                                        width="12" alt=""/></div>
                                            </div>
                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->rooms }} غرف
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/room.png') }}"
                                                        width="12" alt=""/></div>
                                            </div>

                                            <div class="listing-card-info-icon">
                                                {{ $aqarSim->total_area }} م²
                                                <div class="inc-fleat-icon"><img
                                                        src="{{ asset('images/icons/area.png') }}"
                                                        width="12" alt=""/></div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="listing-detail-footer bg-light">
                                        <div class="footer-first">
                                            <div class="foot-location">
                                                @if ($aqarSim->governrateq)
                                                    {{ $aqarSim->governrateq->governrate }}
                                                @endif
                                                @if ($aqarSim->districte)
                                                    ,  {{ $aqarSim->districte->district }}
                                                @endif
                                                @if ($aqarSim->subAreaa)
                                                    {{ $aqarSim->subAreaa->area }},
                                                @endif

                                                <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt=""/>
                                            </div>
                                        </div>
                                        <div class="footer-flex">
                                            <a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
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


    <style>
        /* =========================================================
           Modern property page — Right Choice brand colors
           Primary: #196aa2 | Accent: #0fca98
           ========================================================= */
        :root {
            --rc-primary: #196aa2;
            --rc-primary-dark: #0f4f7d;
            --rc-primary-soft: #eaf5fc;
            --rc-accent: #0fca98;
            --rc-accent-dark: #08a77d;
            --rc-accent-soft: #e9fbf6;
            --rc-ink: #132238;
            --rc-muted: #68778b;
            --rc-border: #e5edf4;
            --rc-surface: #ffffff;
            --rc-page: #f5f9fc;
            --rc-shadow-sm: 0 10px 30px rgba(25, 106, 162, 0.08);
            --rc-shadow-lg: 0 22px 60px rgba(25, 106, 162, 0.14);
            --rc-radius-sm: 12px;
            --rc-radius-md: 18px;
            --rc-radius-lg: 26px;
        }

        .property-show-modern {
            position: relative;
            padding: 34px 0 62px;
            background:
                radial-gradient(circle at 8% 8%, rgba(15, 202, 152, 0.09), transparent 28%),
                radial-gradient(circle at 92% 2%, rgba(25, 106, 162, 0.11), transparent 32%),
                var(--rc-page);
            overflow: hidden;
        }

        .property-show-modern::before {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--rc-primary), var(--rc-accent));
        }

        .property-show-modern > .container {
            position: relative;
            z-index: 1;
        }

        .property-page-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin: 24px 0 30px;
            padding: 24px 28px;
            border: 1px solid rgba(25, 106, 162, 0.11);
            border-radius: var(--rc-radius-lg);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: var(--rc-shadow-sm);
            backdrop-filter: blur(12px);
        }

        .property-page-heading__content {
            min-width: 0;
        }

        .property-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
            color: var(--rc-primary);
            font-size: 13px;
            font-weight: 800;
        }

        .property-kicker i {
            color: var(--rc-accent);
        }

        .property-page-title {
            margin: 0;
            color: var(--rc-ink);
            font-size: clamp(25px, 3vw, 39px);
            font-weight: 800;
            line-height: 1.35;
            letter-spacing: -0.5px;
        }

        .property-page-location {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 12px;
            color: var(--rc-muted);
            font-size: 14px;
            font-weight: 600;
        }

        .property-page-location i {
            color: var(--rc-accent);
        }

        .property-location-separator {
            color: #a0acb9;
        }

        .property-page-heading__badges {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 9px;
            flex-shrink: 0;
        }

        .property-heading-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .property-heading-badge--primary {
            color: var(--rc-primary-dark);
            background: var(--rc-primary-soft);
            border: 1px solid rgba(25, 106, 162, 0.14);
        }

        .property-heading-badge--accent {
            color: #057657;
            background: var(--rc-accent-soft);
            border: 1px solid rgba(15, 202, 152, 0.2);
        }

        .property-layout {
            align-items: flex-start;
        }

        .property-sidebar-sticky {
            position: sticky;
            top: 95px;
            z-index: 10;
        }

        .property-summary-card {
            overflow: hidden;
            border: 0 !important;
            border-radius: var(--rc-radius-lg) !important;
            background: var(--rc-surface);
            box-shadow: var(--rc-shadow-lg);
        }

        .property-summary-card::before {
            content: "";
            display: block;
            height: 6px;
            background: linear-gradient(90deg, var(--rc-primary), var(--rc-accent));
        }

        .property-summary-card__body {
            padding: 26px !important;
        }

        .property-summary-card .headingTitle2 {
            margin: 0 0 16px;
            color: var(--rc-ink);
            font-size: 21px;
            font-weight: 800;
            line-height: 1.5;
        }

        .property-summary-card h5 {
            margin: 0 0 5px;
            color: var(--rc-primary);
            font-size: 25px;
            font-weight: 900;
        }

        .property-summary-card h6 {
            margin-top: 8px;
            color: var(--rc-muted) !important;
            font-size: 13px;
            font-weight: 600;
        }

        .property-show-modern .hr-add {
            margin: 22px 0;
            border: 0;
            border-top: 1px solid var(--rc-border);
        }

        .property-show-modern .fr-grid-deatil-flex {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
            width: 100%;
            margin-bottom: 12px;
        }

        .property-show-modern .fr-grid-deatil-flex > br {
            display: none;
        }

        .property-show-modern .listing-card-info-icon {
            position: relative;
            display: flex;
            align-items: center;
            min-height: 52px;
            padding: 11px 48px 11px 13px;
            border: 1px solid var(--rc-border);
            border-radius: var(--rc-radius-sm);
            background: #fbfdff;
            color: #34455b;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.5;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .property-show-modern .listing-card-info-icon:hover {
            transform: translateY(-2px);
            border-color: rgba(25, 106, 162, 0.24);
            box-shadow: 0 9px 22px rgba(25, 106, 162, 0.08);
        }

        .property-show-modern .listing-card-info-icon .inc-fleat-icon,
        .property-show-modern .listing-card-info-icon > .fa {
            position: absolute;
            right: 12px;
            top: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 27px;
            height: 27px;
            margin: 0;
            border-radius: 9px;
            background: linear-gradient(145deg, var(--rc-primary-soft), var(--rc-accent-soft));
            color: var(--rc-primary);
            transform: translateY(-50%);
        }

        .property-show-modern .listing-card-info-icon img {
            width: 15px !important;
            height: 15px;
            object-fit: contain;
        }

        .property-action-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            text-align: initial !important;
        }

        .property-action-grid > form,
        .property-action-grid > #contMop,
        .property-action-grid > .alert {
            grid-column: 1 / -1;
            width: 100%;
            margin: 0;
        }

        .property-action-grid > form,
        .property-action-grid > #contMop {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .property-action-grid > #contMop .btn {
            width: 100% !important;
        }

        .property-action-grid .btn,
        .property-action-grid input[type="submit"] {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            width: 100% !important;
            min-height: 44px;
            margin: 0 !important;
            padding: 10px 14px;
            border: 0;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 800;
            box-shadow: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .property-action-grid .btn:hover,
        .property-action-grid input[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(25, 106, 162, 0.13);
        }

        .property-action-grid .btn-success,
        .property-action-grid input.btn-success {
            color: #fff;
            background: linear-gradient(135deg, var(--rc-accent), var(--rc-accent-dark));
        }

        .property-action-grid .our-btn,
        .property-action-grid .btn-compare-toggle {
            color: #fff !important;
            background: linear-gradient(135deg, var(--rc-primary), var(--rc-primary-dark)) !important;
        }

        .property-action-grid .btn-light {
            color: var(--rc-primary-dark);
            background: var(--rc-primary-soft);
            border: 1px solid rgba(25, 106, 162, 0.14);
        }

        .property-gallery-card {
            position: relative;
            padding: 12px;
            border: 1px solid rgba(25, 106, 162, 0.09);
            border-radius: var(--rc-radius-lg);
            background: var(--rc-surface);
            box-shadow: var(--rc-shadow-sm);
        }

        .property-gallery-card .main-img {
            display: block;
            width: 100%;
            min-height: 430px;
            max-height: 610px;
            border-radius: 20px;
            object-fit: cover;
            background: #eaf0f5;
        }

        .property-gallery-card .watermarked {
            overflow: hidden;
            border-radius: 20px;
        }

        .property-gallery-card .lazy {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 10px;
            margin-top: 11px;
        }

        .property-gallery-card .lazy a {
            display: block;
            min-width: 0;
        }

        .property-gallery-card .lazy .watermarked {
            border-radius: 12px;
        }

        .property-gallery-card .lazy .img-thumbnail {
            width: 100%;
            height: 86px;
            padding: 0;
            border: 2px solid transparent;
            border-radius: 12px;
            object-fit: cover;
            transition: transform 0.2s ease, border-color 0.2s ease;
        }

        .property-gallery-card .lazy a:hover .img-thumbnail {
            transform: translateY(-2px);
            border-color: var(--rc-accent);
        }

        .property-gallery-card .lightbtn {
            position: absolute;
            left: 26px;
            top: 392px;
            z-index: 5;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 15px;
            border: 1px solid rgba(255, 255, 255, 0.72);
            border-radius: 12px;
            color: var(--rc-ink);
            background: rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.13);
            backdrop-filter: blur(10px);
        }

        .property-gallery-card .views {
            top: 25px !important;
            left: 25px !important;
            z-index: 6;
        }

        .property-gallery-card .views-1,
        .property-gallery-card .viewsRed {
            padding: 8px 14px;
            border-radius: 999px;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.15);
        }

        .property-gallery-card .views-1 {
            background: linear-gradient(135deg, var(--rc-accent), var(--rc-accent-dark));
        }

        .property-gallery-card .viewsRed {
            background: linear-gradient(135deg, #ef5666, #c82333);
        }

        .property-content-column > .details,
        .property-gallery-card > .details {
            margin-top: 22px !important;
            padding: 26px;
            border: 1px solid var(--rc-border);
            border-radius: var(--rc-radius-md);
            background: var(--rc-surface);
            box-shadow: 0 10px 28px rgba(18, 49, 75, 0.05);
        }

        .property-show-modern .headingTitle2 {
            position: relative;
            margin-bottom: 20px;
            padding-bottom: 12px;
            color: var(--rc-ink);
            font-size: 22px;
            font-weight: 900;
        }

        .property-show-modern .headingTitle2::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 0;
            width: 58px;
            height: 4px;
            border-radius: 999px;
            background: linear-gradient(90deg, var(--rc-primary), var(--rc-accent));
        }

        .property-content-column > .details p {
            color: #4c5d71;
            font-size: 15px;
            line-height: 2;
        }

        .property-content-column > .details p[style] {
            padding: 14px 17px !important;
            border: 1px solid rgba(25, 106, 162, 0.12);
            border-radius: 13px;
            color: var(--rc-primary-dark);
            background: linear-gradient(135deg, var(--rc-primary-soft), #f7fcff) !important;
        }

        .btnMore {
            display: inline-flex;
            align-items: center;
            margin-top: 12px;
            padding: 8px 14px;
            border-radius: 10px;
            color: var(--rc-primary) !important;
            background: var(--rc-primary-soft);
            font-weight: 800;
            cursor: pointer;
        }

        .property-owner-card {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 20px 22px;
            border: 1px solid var(--rc-border);
            border-radius: var(--rc-radius-md);
            background: linear-gradient(135deg, #fff, var(--rc-accent-soft));
            box-shadow: var(--rc-shadow-sm);
        }

        .property-owner-card img {
            width: 64px;
            height: 64px;
            border: 4px solid #fff;
            box-shadow: 0 7px 18px rgba(25, 106, 162, 0.14);
        }

        .property-owner-card span {
            color: var(--rc-ink);
            font-size: 17px;
            font-weight: 900;
        }

        .property-similar-modern {
            padding: 66px 0 76px;
            background: #fff;
        }

        .property-similar-modern .sec-heading {
            margin-bottom: 32px !important;
        }

        .property-similar-modern .headingTitle {
            color: var(--rc-ink);
            font-weight: 900;
        }

        .property-similar-modern .sec-heading p {
            color: var(--rc-muted);
        }

        .property-similar-card {
            overflow: hidden;
            border: 1px solid var(--rc-border) !important;
            border-radius: 20px !important;
            background: #fff;
            box-shadow: 0 12px 35px rgba(25, 106, 162, 0.08) !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .property-similar-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 45px rgba(25, 106, 162, 0.14) !important;
        }

        .property-similar-card .listing-img-wrapper img {
            transition: transform 0.35s ease;
        }

        .property-similar-card:hover .listing-img-wrapper img {
            transform: scale(1.04);
        }

        .property-similar-card .prt-view {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 78px;
            padding: 8px 15px;
            border-radius: 10px;
            color: #fff;
            background: linear-gradient(135deg, var(--rc-primary), var(--rc-primary-dark));
            font-weight: 800;
        }

        .modal .modal-content {
            max-width: 520px;
            margin: 8vh auto 0;
            padding: 28px !important;
            border: 0 !important;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 28px 80px rgba(0, 0, 0, 0.22);
        }

        @media (max-width: 1199.98px) {
            .property-gallery-card .main-img {
                min-height: 380px;
            }

            .property-gallery-card .lightbtn {
                top: 342px;
            }

            .property-show-modern .fr-grid-deatil-flex {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 991.98px) {
            .property-page-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .property-page-heading__badges {
                justify-content: flex-start;
            }

            .property-sidebar-column {
                order: 2;
                margin-top: 24px;
            }

            .property-content-column {
                order: 1;
            }

            .property-sidebar-sticky {
                position: static;
            }

            .property-show-modern .fr-grid-deatil-flex {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 767.98px) {
            .property-show-modern {
                padding: 16px 0 42px;
            }

            .property-page-heading {
                margin: 16px 0 20px;
                padding: 20px;
                border-radius: 20px;
            }

            .property-page-title {
                font-size: 25px;
            }

            .property-summary-card__body,
            .property-content-column > .details,
            .property-gallery-card > .details {
                padding: 20px !important;
            }

            .property-gallery-card {
                padding: 8px;
                border-radius: 20px;
            }

            .property-gallery-card .main-img {
                min-height: 300px;
                max-height: 420px;
                border-radius: 16px;
            }

            .property-gallery-card .watermarked {
                border-radius: 16px;
            }

            .property-gallery-card .lazy {
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 7px;
            }

            .property-gallery-card .lazy .img-thumbnail {
                height: 67px;
            }

            .property-gallery-card .lightbtn {
                top: 255px;
                left: 18px;
                padding: 8px 11px;
                font-size: 11px;
            }

            .property-show-modern .fr-grid-deatil-flex,
            .property-action-grid,
            .property-action-grid > form {
                grid-template-columns: 1fr;
            }

            .property-action-grid > * {
                grid-column: 1 / -1;
            }

            .property-similar-modern {
                padding: 48px 0 58px;
            }
        }

        @media (max-width: 480px) {
            .property-page-heading__badges {
                width: 100%;
            }

            .property-heading-badge {
                flex: 1;
                justify-content: center;
            }

            .property-gallery-card .lazy {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .property-gallery-card .main-img {
                min-height: 255px;
            }

            .property-gallery-card .lightbtn {
                position: static;
                margin: 10px 4px 2px;
            }
        }
    </style>

    {{-- ===== Report Popup ===== --}}
    <div id="overlay"
         style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.55); z-index:9999; padding:20px; overflow-y:auto;">
        <div id="popup" style="
            background:#fff;
            border-radius:16px;
            max-width:480px;
            width:100%;
            margin:60px auto 20px;
            box-shadow:0 20px 60px rgba(0,0,0,0.25);
            overflow:hidden;
            direction:rtl;
                max-height: 900px;
            font-family: inherit;
        ">
            {{-- Header --}}
            <div
                style="background:#196aa2; padding:18px 24px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; align-items:center; gap:10px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="white" viewBox="0 0 16 16">
                        <path
                            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <h5 style="color:#fff; margin:0; font-size:17px; font-weight:700;">{{ trans('langsite.report') }}</h5>
                </div>
                <button id="close" onclick="document.getElementById('overlay').style.display='none'" style="
                    background:rgba(255,255,255,0.2);
                    border:none;
                    color:#fff;
                    width:32px; height:32px;
                    border-radius:50%;
                    font-size:16px;
                    cursor:pointer;
                    line-height:1;
                    display:flex; align-items:center; justify-content:center;
                    transition:background 0.2s;
                ">&times;
                </button>
            </div>

            {{-- Preloader --}}
            <div id="report-preloader" style="display:none; padding:50px 24px; text-align:center;">
                <div class="rp-spinner"></div>
                <p style="color:#196aa2; font-size:14px; margin-top:16px; font-weight:600;">جاري إرسال البلاغ...</p>
            </div>

            {{-- Success Message --}}
            <div id="report-success" style="display:none; padding:50px 24px; text-align:center;">
                <div style="
                    width:70px; height:70px;
                    background:#e8f5e9;
                    border-radius:50%;
                    display:flex; align-items:center; justify-content:center;
                    margin:0 auto 16px;
                ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="#2e7d32" viewBox="0 0 16 16">
                        <path
                            d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                    </svg>
                </div>
                <h5 style="color:#2e7d32; font-size:18px; font-weight:700; margin-bottom:8px;">تم إرسال البلاغ
                    بنجاح!</h5>
                <p style="color:#666; font-size:13px; margin-bottom:24px;">شكراً لك، سيتم مراجعة البلاغ من قِبل فريقنا
                    في أقرب وقت.</p>
                <button type="button" onclick="closeReportPopup()" style="
                    background:#196aa2; color:#fff; border:none;
                    padding:10px 30px; border-radius:8px;
                    font-size:14px; cursor:pointer;
                ">حسناً
                </button>
            </div>

            {{-- Body --}}
            <div id="report-body" style="padding:24px;">
                <p style="color:#555; font-size:13px; margin-bottom:16px;">اختر سبب الإبلاغ:</p>

                <form class="show_report">
                    <div class="report-options-modern">

                        <label class="rp-label">
                            <input type="radio" name="report_reason" value="  العقار مباع  " class="report-radio">
                            <span class="rp-icon">📋</span>
                            <span class="rp-text">
                                العقار مباع
                                     </span>
                            <span class="rp-check">✓</span>
                        </label>

                        <label class="rp-label">
                            <input type="radio" name="report_reason" value="  المالك غير متاح للتواصل  "
                                   class="report-radio">
                            <span class="rp-icon">📋</span>
                            <span class="rp-text">
                                المالك غير متاح للتواصل

                                     </span>
                            <span class="rp-check">✓</span>
                        </label>

                        <label class="rp-label">
                            <input type="radio" name="report_reason" value="بروكر  " class="report-radio">
                            <span class="rp-icon">📋</span>
                            <span class="rp-text">  بروكر

                                     </span>
                            <span class="rp-check">✓</span>
                        </label>


                        <label class="rp-label">
                            <input type="radio" name="report_reason" value="other" class="report-radio">
                            <span class="rp-icon">✏️</span>
                            <span class="rp-text">أخرى</span>
                            <span class="rp-check">✓</span>
                        </label>

                    </div>

                    <div id="report-other-box" style="display:none; margin-top:14px;">
                        <textarea
                            name="message"
                            id="report"
                            rows="4"
                            placeholder="اكتب شكواك هنا..."
                            style="
                                width:100%;
                                border:1.5px solid #196aa2;
                                border-radius:10px;
                                padding:12px;
                                font-size:14px;
                                resize:vertical;
                                outline:none;
                                direction:rtl;
                                font-family:inherit;
                                transition:border-color 0.2s;
                            "
                        ></textarea>
                    </div>

                    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
                        <button type="button"
                                onclick="document.getElementById('overlay').style.display='none'"
                                style="
                                background:#f0f0f0;
                                border:none;
                                padding:10px 22px;
                                border-radius:8px;
                                font-size:14px;
                                cursor:pointer;
                                color:#555;
                                transition:background 0.2s;
                            ">إلغاء
                        </button>

                        <a href="#" type="button"
                           class="AddComplain"
                           data-id="{{ $aqar['id'] }}"
                           style="
                                background:#196aa2;
                                color:#fff;
                                border:none;
                                padding:10px 28px;
                                border-radius:8px;
                                font-size:14px;
                                cursor:pointer;
                                text-decoration:none;
                                display:inline-flex;
                                align-items:center;
                                gap:6px;
                                transition:background 0.2s;
                            ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                                 viewBox="0 0 16 16">
                                <path
                                    d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                <path
                                    d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                            </svg>
                            إرسال البلاغ
                        </a>
                    </div>
                </form>
            </div>{{-- end report-body --}}
        </div>
    </div>

    <style>
        /* ===== Modern Report Popup ===== */
        .report-options-modern {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .rp-label {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border: 1.5px solid #e0e0e0;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            background: #fff;
        }

        .rp-label:hover {
            border-color: #196aa2;
            background: #f0f6fb;
        }

        .rp-label input[type="radio"] {
            display: none;
        }

        .rp-icon {
            font-size: 18px;
            flex-shrink: 0;
        }

        .rp-text {
            flex: 1;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .rp-check {
            width: 22px;
            height: 22px;
            border: 2px solid #ccc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: transparent;
            transition: all 0.2s;
            flex-shrink: 0;
        }

        .rp-label:has(input:checked) {
            border-color: #196aa2;
            background: #f0f6fb;
        }

        .rp-label:has(input:checked) .rp-check {
            background: #196aa2;
            border-color: #196aa2;
            color: #fff;
        }

        .rp-label:has(input:checked) .rp-text {
            color: #196aa2;
            font-weight: 700;
        }

        #report:focus {
            border-color: #0f4d7a !important;
            box-shadow: 0 0 0 3px rgba(25, 106, 162, 0.15);
        }

        /* Spinner */
        .rp-spinner {
            width: 52px;
            height: 52px;
            border: 5px solid #e3eef7;
            border-top: 5px solid #196aa2;
            border-radius: 50%;
            animation: rp-spin 0.8s linear infinite;
            margin: 0 auto;
        }

        @keyframes rp-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 576px) {
            #popup {
                margin: 20px auto !important;
            }

            .rp-label {
                padding: 10px 12px;
            }
        }
    </style>

    <script>
        function closeReportPopup() {
            document.getElementById('overlay').style.display = 'none';
            setTimeout(function () {
                document.getElementById('report-preloader').style.display = 'none';
                document.getElementById('report-success').style.display = 'none';
                document.getElementById('report-body').style.display = 'block';
                document.querySelectorAll('.report-radio').forEach(function (r) {
                    r.checked = false;
                });
                document.getElementById('report-other-box').style.display = 'none';
                document.getElementById('report').value = '';
            }, 300);
        }

        document.querySelectorAll('.report-radio').forEach(function (radio) {
            radio.addEventListener('change', function () {
                var otherBox = document.getElementById('report-other-box');
                var reportField = document.getElementById('report');
                if (this.value === 'other') {
                    otherBox.style.display = 'block';
                    reportField.value = '';
                    reportField.focus();
                } else {
                    otherBox.style.display = 'none';
                    reportField.value = this.value;
                }
            });
        });

        document.getElementById('overlay').addEventListener('click', function (e) {
            if (e.target === this) closeReportPopup();
        });

        document.getElementById('close').addEventListener('click', function () {
            closeReportPopup();
        });
    </script>
    @if(Auth::user())
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">


                <br/>
                <x-logo/>
                <br/>
                @if(Auth::user()->userpricin != null)
                    <p>
                        عدد النقاط التي لديك هي
                        {{ Auth::user()->userpricin->current_points}}
                        ويكلفك هذا العقار عدد
                        {{ $aqar->points_avail }}
                        من النقاط <br/> هل تود الاستمرار ؟
                    </p>

                @else
                    <p> عدد النقاط التي لديك هي 0 ويكلفك هذا العقار عدد
                        {{ $aqar->points_avail }}
                        من النقاط <br/> هل تود
                        الاستمرار ؟ </p>
                @endif
                <div>


                    <button onClick="document.getElementById('myModal').style.display = 'none';"
                            class="btn btn-success addToContact" data-id="{{$aqar['id']}}">تاكيد
                    </button>

                    <button onClick="document.getElementById('myModal').style.display = 'none'"
                            class="btn btn-danger">الغاء
                    </button>

                </div>
            </div>

        </div>



        <div id="myModal2" class="modal">

            <!-- Modal content -->
            <div class="modal-content">


                <br/>
                <x-logo/>
                <br/>


                <p> تحتاج الي {{ $aqar->points_avail }} نقطه </p>


                <p> رصيد نقاطك لا يكفي <br> الانتقال الى صفحه الباقات ؟ </p>
                <div>


                    <a href="{{ route('priceSeller', Config::get('app.locale')) }}"
                       class="btn btn-success">تاكيد</a>

                    <button onClick="document.getElementById('myModal2').style.display = 'none'"
                            class="btn btn-danger">الغاء
                    </button>

                </div>
            </div>

        </div>
    @endif
    <script>
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
    <style>
        /* The Modal (background) */
        .contMop {
            display: inline;
        }

        .modal {
            text-align: center;
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 100;
            /* Sit on top */
            padding-top: 200px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }

        @media screen and (max-width: 768px) {
            .modal-content {
                margin: auto;
                padding: 20px;
                border: 1px solid #888;
                width: 100%;
            }
        }
    </style>

    <script>
        //  document.getElementById("myBtn").click();

        function myFunction() {
            var dots = document.getElementById("dots");
            var moreText = document.getElementById("more");
            var btnText = document.getElementById("myBtn");
            var small_text_show = document.getElementById("small_text_show");

            if (dots.style.display === "none") {
                dots.style.display = "inline";
                btnText.innerHTML = "اقرا المزيد";
                moreText.style.display = "none";
                small_text_show.style.display = "inline";

            } else {
                dots.style.display = "none";
                btnText.innerHTML = "اقرا اقل";
                small_text_show.style.display = "none";

                moreText.style.display = "inline";
            }
        }
    </script>

    {{-- ── Meta Pixel: ViewContent (Browser-side) ───────────────────────── --}}
    @php
        $metaSetting = \App\Models\SettingSite::first();
    @endphp
    @if($metaSetting && $metaSetting->fb_conversions_api_enabled && $metaSetting->fb_pixel_id)
        <script>
            if (typeof fbq !== 'undefined') {
                fbq('track', 'ViewContent', {
                    content_ids: ['{{ $aqar->id }}'],
                    content_type: 'product',
                    content_name: '{{ addslashes($aqar->title ?? '') }}',
                    currency: 'EGP',
                    value: {{ $aqar->price ?? 0 }}
                });
            }
        </script>
    @endif
    {{-- ─────────────────────────────────────────────────────────────────── --}}



    <style>
        /* Final overrides placed after legacy page styles */
        .modal {
            padding: 20px !important;
            background: rgba(7, 28, 44, 0.66) !important;
            backdrop-filter: blur(5px);
        }

        .modal .modal-content {
            width: min(520px, 100%) !important;
            max-width: 520px;
            margin: 8vh auto 0 !important;
            padding: 28px !important;
            border: 0 !important;
            border-radius: 22px !important;
            background: #fff;
            box-shadow: 0 28px 80px rgba(0, 0, 0, 0.22);
        }

        @media (max-width: 767.98px) {
            .property-action-grid > #contMop {
                grid-template-columns: 1fr;
            }

            .modal .modal-content {
                margin-top: 4vh !important;
                padding: 22px !important;
            }
        }
    </style>

</x-layout>
