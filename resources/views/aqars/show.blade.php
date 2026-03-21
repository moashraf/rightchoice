<x-layout>

    @section('title')
        {{ $aqar->title }}
    @endsection
    <section id="inner-listing">
        <div class="container">
            <x-ads :randomAds="$random_ads ?? null"/>
            <h3 class="show_show headingTitle2 hideTitle2" style=" margin-bottom: 28px;  font-size: 24px!important;">
                {{ $aqar->title }}
            </h3>

            <div class="row">
                <div class="col-lg-4">
                    <div class="sticky">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="headingTitle2">{{ $aqar->title }}</h4>

                                <div dir="rtl">
                                    @if ($aqar->offer_type == 1 || $aqar->offer_type == 1 || $aqar->offer_type == 5)

                                        <h5> {{ $aqar->total_price }} {{ trans('langsite.egyptian_pound') }}</h5>
                                    @endif
                                    @if ($aqar->offer_type == 3 || $aqar->offer_type == 4 )

                                        <h5> {{ $aqar->monthly_rent }} {{ trans('langsite.egyptian_pound') }}</h5>
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
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/bath.png')}}"
                                                                         width="13" alt=""/></div>
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

                                <div class="text-center">

                                    @if(Auth::user())
                                            <?php if ($show && $aqar->user != null){ ?>
                                        <div id="contMop">
                                            @if($show2)
                                                <a class="btn btn-success"
                                                   href="tel:{{ $aqar->user->MOP }}">{{ $aqar->user->MOP }}</a>
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
                <div class="col-lg-8">
                    <div class="images" dir="ltr">


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
                            $data_final = preg_replace('/[^\w\s]+/u', ' ', $str);

                            echo \Illuminate\Support\Str::limit($data_final, 500, '');
                            ?>

                        </div>
                        @if (\Illuminate\Support\Str::length($aqar->description) > 500)
                            <span id="dots">...</span>
                            <span
                                id="more">

                                {{-- preg_replace('/\d{3}([().-\s[\]]*)\d{3}([().-\s[\]]*)\d{4}/', '*********', preg_replace('/\d+/u', '*********', $aqar->description)) --}}

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

                    <div class="same-owner mt-5">

                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                             width="80">

                        <span>{{$aqar->user->name}}</span>

                    </div>
                    <?php } ?>


                </div>

            </div>


        </div>

    </section>

    <section class="" dir="ltr">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle"> العقارات المشابهة </h2>
                        <p>
                            يمكنك مشاهدة أكثر العقارات مناسبة لطلباتك من حيث المساحة أو الموقع أو السعر
                        </p>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="property-slide">

                        @foreach ($allAqars as $aqarSim)
                            <div class="single-items">
                                <div class="property-listing shadow-none property-2 border">

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


</x-layout>
