<x-layout>


    @section('title')
    {{ $aqar->title }}
    @endsection
    <section id="inner-listing">

        <div class="container">

<div class="adv">
    <?php //dd($random_ads); ?>
 <a  target="_blank"  href="{{  $random_ads->name  }}" >





                 	<img src="{{ URL::to('/').'/images/'.$random_ads->img}}" class="image-fluid w-100 mx-auto mb-5" alt="">


</a>
 </div>

            <h3 class="headingTitle2 hideTitle2" style=" margin-bottom: 28px;  font-size: 24px!important;">
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
                                                width="13" alt="" /></div>
                                    </div>


                                    <div class="listing-card-info-icon">
                                        {{ $aqar->rooms }} {{ trans('langsite.rooms')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/room.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                    <div class="listing-card-info-icon">
                                        {{ $aqar->baths }} {{ trans('langsite.bathroom')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/bath.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    <br /> <br />
                                    <div class="listing-card-info-icon">
                                        @if ($aqar->governrateq)
                                        {{ $aqar->governrateq->governrate }}
                                        @endif

                                        @if ($aqar->districte),
                                        {{ $aqar->districte->district }}
                                        @endif


                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/location.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                </div>
                                <hr class="hr-add">






                                <div class="text-center">







                                    @if(Auth::user())

                                    <?php if($show && $aqar->user !=null ){    ?>

                                    <div id="contMop">
                                       @if($show2)
                                        <a class="btn btn-success" href="tel:{{ $aqar->user->MOP }}">{{ $aqar->user->MOP }}</a>
                                        @else

                                        <button onclick="document.getElementById('myModal').style.display = 'block'"
                                            class="btn btn-success">اظهر الرقم</button>
                                                @endif
                                    </div>

                                    <?php }else{?>

                                    <a id="notShow" href="#"
                                        onclick="document.getElementById('myModal2').style.display = 'block'"
                                        class="btn btn-success mt-3"><img
                                            src="https://img.icons8.com/carbon-copy/50/000000/phone.png" width="20"
                                            height="20" />اتصال</a>


                                    <?php }?>



                                    <a style="width:30%" href="#"
                                        class="btn btn-light ml-1 mr-1 addToCart {{--<?php if(isset($show)){ echo 'mt-3'; } ?>--}}"
                                        data-id="{{$aqar['id']}}"> {{ trans('langsite.save')}}</a>

                                    @else
                                    <form action="{{ route('redirectBack',Config::get('app.locale')) }}" method="post">
                                        @csrf
                                        <input type="submit" value="تواصل مع المالك" class="btn btn-success" />
                                        <input type="submit" value="حفظ" class="btn btn-light" />

                                    </form>

                                    @endif




                                    <a style="width:30%" class="btn our-btn {{--<?php if(@show){ echo 'mt-3'; } ?>--}}"
                                        id="trigger-2">{{ trans('langsite.sharing')}}</a>

                                </div>
                                <!--  <img src="https://al-kafigroup.com/images/vhjfhgc.jpeg" class="img-thumbnail">-->

                                <hr class="hr-add">
                                <div style="padding:8px;">
                                    <x-purchase-now />

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
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main">

                                        @endif


                                        @endif



                                </a>
                      <?php  if($aqar->vip ==1  && \Carbon\Carbon::now()->diffInYears($aqar->created_at) < 1){   ?>

                        <div class="views" style=" left: 13px;">
                            <div class="views-1">مميز</div>
                        </div>
                              <?php }  ?>

                              <?php if(\Carbon\Carbon::now()->diffInYears($aqar->created_at) >= 1){ ?>
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
                                       <?php  //$image_info = exif_read_data("https://rightchoice-co.com/images/$images_url->img_url"); print_r( $image_info);  ?>

                                    @endif
                                    @endforeach


                                </div>



                                @if($aqar->firstImage)
                                <a href="{{ URL::to('/').'/images/'.$aqar->firstImage->img_url}}"
                                    data-lightbox="roadtrip" class="btn btn-light lightbtn">
                                  <b>  {{ trans('langsite.show_photos')}}
                                    ( <?php echo(   $aqar->images ->count() ); ?> )
                                    </b>
                                    <img src="https://img.icons8.com/carbon-copy/100/000000/camera--v1.png" width="20"
                                        height="20" /></a>
                                @endif



                            <div class="details mt-3">
                                <h3 class="headingTitle2">{{ trans('langsite.details')}}</h3>

                                <div class="fr-grid-deatil-flex">
                                    <div class="listing-card-info-icon">
                                        @if ($aqar->governrateq)
                                        {{ $aqar->governrateq->governrate }}
                                        @endif @if ($aqar->districte),
                                        {{ $aqar->districte->district }}
                                        @endif @if ($aqar->subAreaa)
                                        ,
                                        {{ $aqar->subAreaa->area }}
                                        @endif

                                           @if ($aqar->compounds),
                                        {{ $aqar->compounds->compound }}
                                        @endif

                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/location.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                    <div class="listing-card-info-icon">
                                        رقم الاعلان
                                        {{ $aqar->id }}

                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/counter.png')}}"
                                                width="13" alt="" /></div>

                                    </div>


                                         <div class="listing-card-info-icon">
عدد المشاهدات

{{ $aqar->views }}

                                        <div class="fa fa-eye"> </div>

                                    </div>


                                    <div class="listing-card-info-icon">

                                        تاريخ الاعلان


                                        {{ date('d/m/Y', strtotime($aqar->created_at))  }}

                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/calnder.png')}}"
                                                width="13" alt="" /></div>

                                    </div>

                                </div>
                                <div class="fr-grid-deatil-flex">

                                    @if ($aqar->offer_type == 1 || $aqar->offer_type == 1 || $aqar->offer_type == 5 ||
                                    $aqar->offer_type == 2)
                                    @if ($aqar->total_price)
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->total_price }} {{ trans('langsite.egyptian_pound')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/cash.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    @endif
                                    @endif
                                    @if ($aqar->offer_type == 3 || $aqar->offer_type == 4 )
                                    @if ($aqar->monthly_rent)
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->monthly_rent }} {{ trans('langsite.egyptian_pound')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/cash.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    @endif
                                    @endif




                                    <div class="listing-card-info-icon">
                                        {{ $aqar->offerTypes->type_offer }}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/cash.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    <?php if( $aqar->offer_type == 2 ){ ?>

                                    <div class="listing-card-info-icon">
                                        {{ trans('langsite.offered')}} {{ $aqar->downpayment }}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/downpayment.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    <div class="listing-card-info-icon">

                                        مده التقسيط
                                        {{ $aqar->installment_time }} {{ trans('langsite.month')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/cash.png')}}"
                                                width="13" alt="" /></div>
                                    </div>


                                    <div class="listing-card-info-icon">
                                        {{ trans('langsite.Receipt_time')}} {{ $aqar->rec_time }}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/clock.png')}}"
                                                width="13" alt="" /></div>
                                    </div>



                                    <!--<div class="listing-card-info-icon">
                        {{ $aqar->installment_value }} {{ trans('langsite.value_installment')}}
                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/installment.png')}}" width="13" alt="" /></div>
                    </div>-->




                                    <?php } ?>
                                </div>
                                <div class="fr-grid-deatil-flex">

                                    @if ( $aqar->propertyType)

                                    <div class="listing-card-info-icon">

                                        {{ $aqar->propertyType->property_type }}





                                        <div class="inc-fleat-icon">
                                            <img src="{{ asset('images/icons/room.png') }}" width="13" alt="" />
                                        </div>
                                    </div>

                                    @endif


                                    @if ($aqar->number_of_floors)
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->number_of_floors }} {{ trans('langsite.number_floor')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('assets/img/city.svg')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    @endif
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->total_area }} {{ trans('langsite.meterS')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/area.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                    @if ($aqar->floorNo)
                                    <div class="listing-card-info-icon">
                                        {{ trans('langsite.floor')}} {{ $aqar->floorNo->floor }}

                                        <div class="inc-fleat-icon"><img src="{{asset('assets/img/city.svg')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    @endif
                                    @if ($aqar->rooms)
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->rooms }} {{ trans('langsite.rooms')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/room.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                    @endif
                                    @if ($aqar->baths)
                                    <div class="listing-card-info-icon">
                                        {{ $aqar->baths }} {{ trans('langsite.bathroom')}}
                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/bath.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                    @endif
                                    @if ( $aqar->finishType)

                                    <div class="listing-card-info-icon">

                                        {{ $aqar->finishType->finish_type }}


                                        <div class="inc-fleat-icon"><img src="{{asset('images/icons/finish.png')}}"
                                                width="13" alt="" /></div>
                                    </div>
                                    @endif

                                </div>

                            </div>




                            <div class="fr-grid-deatil-flex">
                                <?php if($aqar->finannce_bank == 1){ ?>
                                <div class="listing-card-info-icon">
                                    {{ trans('langsite.Suitable')}}
                                    <div class="inc-fleat-icon"><img src="{{asset('images/icons/bank.png')}}" width="13"
                                            alt="" /></div>
                                </div>
                                <?php } ?>
                                <?php if($aqar->trade == 1){ ?>
                                <div class="listing-card-info-icon">
                                    {{ trans('langsite.suitable_sale')}}
                                    <div class="inc-fleat-icon"><img src="{{asset('images/icons/trade.png')}}"
                                            width="13" alt="" /></div>
                                </div>
                                <?php } ?>
                                <?php if($aqar->licensed == 1){ ?>
                                <div class="listing-card-info-icon">
                                    {{ trans('langsite.Registered')}}
                                    <div class="inc-fleat-icon"><img src="{{asset('images/icons/signed.png')}}"
                                            width="13" alt="" /></div>
                                </div>

                                <?php } ?>
                            </div>













                            <br />
                            <br />

                            <h3 class="headingTitle2">{{ trans('langsite.Advantages')}}</h3>
                            <div class="details">
                                <div class="fr-grid-deatil-flex">


                                    @if ($aqar->mzaya)
                                    @foreach ($aqar->mzaya as $maz)
                                    <div class="listing-card-info-icon">
                                        {{ $maz->mzaya_type }}

                                        <div class="inc-fleat-icon"><img
                                                src="{{asset('images/icons').'/'.$maz->img_name}}" width="13" alt="" />
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
                            <div  id="small_text_show">
                                           <?php

                                                $eastern_arabic  = array('0','1','2','3','4','5','6','7','8','9');
                                                $western_arabic= array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

                                                $str = str_replace($western_arabic, $eastern_arabic, $aqar->description) ?? '';

                                                $data_final = preg_replace('/[^\w\s]+/u', ' ', $str);

//echo $data_final ;

echo \Illuminate\Support\Str::limit($data_final , 500 , '') ;
?>
                            {{--  \Illuminate\Support\Str::limit(preg_replace('/\d{3}([().-\s[\]]*)\d{3}([().-\s[\]]*)\d{4}/', '*********01', $aqar->description), 100, '') --}}

                            </div>
                            @if (\Illuminate\Support\Str::length($aqar->description) > 500)
                            <span id="dots">...</span>
                            <span
                                id="more">

                                {{-- preg_replace('/\d{3}([().-\s[\]]*)\d{3}([().-\s[\]]*)\d{4}/', '*********', preg_replace('/\d+/u', '*********', $aqar->description)) --}}

                                <?php echo $data_final ; ?>
                                </span>

                            <a class="btnMore" onclick="myFunction()" id="myBtn">    اقرا المزيد</a>

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
                    <?php if(  $aqar->user !=null ){    ?>

                    <div class="same-owner mt-5">

                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle"
                            width="80">

                        <span>{{$aqar->user->name}}</span>

                    </div>
                    <?php }  ?>


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
                                                <a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"  target="_blank">


              @if($aqarSim->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqarSim->mainImage->img_url}}"   class="img-fluid mx-auto"  alt="main">

                                @else


                                                    @if($aqarSim->firstImage)
                                                    <img
                                                        src="{{ URL::to('/').'/images/'.$aqarSim->firstImage->img_url}}"
                                                        class="img-fluid mx-auto" alt="" />



                                                          @else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
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
                                            <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
                                        </div>

                                    </div>

                                </div>
                                <div class="listing-short-detail-flex">
                                    @if ($aqarSim->offer_type == 1 || $aqarSim->offer_type == 2)

                                    <h6 class="listing-card-info-price">{{ $aqarSim->total_price }}
                                        {{ trans('langsite.egyptian_pound') }}</h6>

                                    @endif
                                    @if ($aqarSim->offer_type == 3 || $aqarSim->offer_type == 4)
                                    <h6 class="listing-card-info-price">{{ $aqarSim->monthly_rent }}
                                        {{ trans('langsite.egyptian_pound') }}</h6>

                                    @endif

                                </div>
                                <div class="price-features-wrapper">
                                    <div class="list-fx-features">





                                        <div class="listing-card-info-icon">
                                            {{ $aqarSim->baths }} حمام
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}"
                                                    width="12" alt="" /></div>
                                        </div>
                                        <div class="listing-card-info-icon">
                                            {{ $aqarSim->rooms }} غرف
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}"
                                                    width="12" alt="" /></div>
                                        </div>

                                        <div class="listing-card-info-icon">
                                            {{ $aqarSim->total_area }} م²
                                            <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}"
                                                    width="12" alt="" /></div>
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

                                            <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
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


    <div id="overlay">



        <div id="popup">



            <div id="close">X</div>



            <h2>اترك بلاغك بخصوص الاعلان</h2>


            <form>

                <textarea name="message" id="report" class="myselect2" rows="4" requerid></textarea>



                <a href="#" type="button" class="btn our-btn  ml-2 AddComplain" data-id="{{$aqar['id']}}"> ابلغ</a>

            </form>





        </div>



    </div>
    @if(Auth::user())
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">


            <br />
            <x-logo />
            <br />
            @if(Auth::user()->userpricin != null)
            <p>
                عدد النقاط التي لديك هي {{ Auth::user()->userpricin->current_points}} ويكلفك هذا العقار عدد
                {{ $aqar->points_avail }} من النقاط <br /> هل تود الاستمرار ؟
            </p>

            @else
            <p> عدد النقاط التي لديك هي 0 ويكلفك هذا العقار عدد {{ $aqar->points_avail }} من النقاط <br /> هل تود
                الاستمرار ؟ </p>
            @endif
            <div>


                <button onClick="document.getElementById('myModal').style.display = 'none';"
                    class="btn btn-success addToContact" data-id="{{$aqar['id']}}">تاكيد</button>

                <button onClick="document.getElementById('myModal').style.display = 'none'"
                    class="btn btn-danger">الغاء</button>

            </div>
        </div>

    </div>



    <div id="myModal2" class="modal">

        <!-- Modal content -->
        <div class="modal-content">


            <br />
            <x-logo />
            <br />



                <p> تحتاج الي  {{ $aqar->points_avail }} نقطه    </p>


           <p> رصيد نقاطك لا يكفي  <br> الانتقال الى صفحه الباقات ؟ </p>
           <div>


                <a href="{{ route('priceSeller', Config::get('app.locale')) }}"
                    class="btn btn-success">تاكيد</a>

                <button onClick="document.getElementById('myModal2').style.display = 'none'"
                    class="btn btn-danger">الغاء</button>

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
            z-index: 1;
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
