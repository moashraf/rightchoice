<x-layout>


 @section('title')
{{$company->Name}}
@endsection


   <section id="inner-listing">

        <div class="container">

<div class="adv">



                 	<img src="<?php if (isset($random_ads)){echo URL::to('/').'/images/'.$random_ads->img  ;} ?>" class="image-fluid w-100 mx-auto mb-5" alt="">


 </div>

            <h3 class=" single-company headingTitle2 hideTitle2" style="    margin-bottom: 28px;  font-size: 24px!important;">
                    {{ $company->serv->Service }}

                    </h3>

            <div class="row">
                <div class="col-lg-4">
                    <div class="sticky">

                        <div class="card">
                            <div class="card-body">
                                <h4 class="headingTitle2">{{ $company->Name }} </h4>
                                <div dir="rtl">
                                 <a href="tel:{{ $company->Phone }}">{{ $company->Phone }}</a>
                                </div>

                                <div class="fr-grid-deatil-flex details mt-3">

                                    <div class="listing-card-info-icon">
                                          {{ $company->governrateq->governrate}}
                            @if($company->district_ashraf)  , {{ $company->district_ashraf->district}}@endif
                            @if($company->subArea)  , {{ $company->subArea->area}}@endif

                                        <div class="inc-fleat-icon">
                                            <img src="{{asset('images/icons/location.png')}}"
                                                width="13" alt="" /></div>
                                    </div>

                                </div>
                                <hr class="hr-add">


<div class="text-center">
   <a style="width:41%" href="tel:{{ $company->Phone }}" class="btn btn-light ml-1 mr-1 addToCart mt-3" data-id="146103"> {{ $company->Phone }}</a>





                                    <a style="width:30%" class="btn our-btn mt-3" id="trigger-2">مشاركه</a>

                                </div>



                                <!--  <img src="https://al-kafigroup.com/images/vhjfhgc.jpeg" class="img-thumbnail">-->

                                <hr class="hr-add">







                            </div>
                        </div>
                    </div>



                </div>
                <div class="col-lg-8">
                    <div class="images" dir="ltr">





                               <div class="watermarked">

                                        <img src="<?php if (isset($company)){echo URL::to('/').'/images/'.$company->photo  ;} ?>"
                                            class="img-fluid main-img" alt="main">
                                </div>













                            <div class="details mt-3">
                                <h3 class="headingTitle2"> تفاصيل </h3>

                                <div class="fr-grid-deatil-flex">
                                    <div class="listing-card-info-icon">
                                  {{ $company->serv->Service }}
                                  </div>
    <div class="listing-card-info-icon">
                              {{ $company->Name }}
                                  </div>

                                    <div class="listing-card-info-icon">
                                        رقم الاعلان
                                        {{ $company->id }}


                                    </div>
                                    <div class="listing-card-info-icon">

                                        تاريخ الاعلان


                                        {{ date('d/m/Y', strtotime($company->created_at))  }}



                                    </div>

                                </div>





                                     <div class="fr-grid-deatil-flex">
                                    <div class="listing-card-info-icon">
                                        {{ $company->governrateq->governrate}}
                            @if($company->district_ashraf)  , {{ $company->district_ashraf->district}}@endif
                            @if($company->subArea)  , {{ $company->subArea->area}}@endif


                                    </div>




                                </div>



                              <div class="fr-grid-deatil-flex">
                                    <div class="listing-card-info-icon">
                                 <a href="tel:{{ $company->Phone }}">{{ $company->Phone }}</a>

                                    </div>

                                    <div class="listing-card-info-icon">
                            @if( $company->landline )
                             <a href="tel:{{ $company->landline }}">{{ $company->landline }}</a>

                             @endif

   </div>


                                </div>




                            </div>












                            <br />


                    </div>

                    <div class="details mt-3">
                        <br>
                        <h3 class="headingTitle2"> {{ trans('langsite.moreDetails')}}</h3>


                        <p>
                            <div  id="small_text_show">
                            {{ $company->details }}
                            </div>


                        </p>


                    </div>



                </div>

            </div>



        </div>

    </section>

    <section class="" dir="ltr">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-10 text-center">
                    <div class="sec-heading center mb-4">
                        <h2 class="headingTitle"> العقارات  المميزه </h2>
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


</x-layout>
