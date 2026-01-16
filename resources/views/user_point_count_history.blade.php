<x-layout>

    @section('title')
        السجل
    @endsection
    <?php
$user = auth()->user();

if (isset($user)) {
} else {
    dd('يجب تسجيل الدخول ');
}
?>

    <section id="profile-info" class="bg-light">

        <div class="container">

            <div class="main-body text-center">



                <div class="row gutters-sm">


                    <div class="col-md-8    text-right">

  <div class="accordion" id="accordionExample">


                                        <div class="accordion-item">
                        <!-- ============================     الباقات  ================================== -->

   <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                                data-bs-target="#collapseOne" aria-expanded="true"

                                                aria-controls="collapseOne">







                        <h3 class="mt-3">الباقات التى تم الاشتراك بها</h3>







                                            </button>
                                               <div id="collapseOne" class="accordion-collapse collapse"

                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        @if (!empty($all_history_of_point_of_user))
                            @foreach ($all_history_of_point_of_user->sortByDesc('id') as $not)
                                <div class="col-lg-12">
                                    <div id="notifi " class="rounded alert notifi_div text-center card mt-3 rounded shadow">
                                        <div class="accordion" id="accordionExample">

                                            <div class="accordion-item ">


                                                <p style=" text-align: right;">
                                                    تم الاشتراك في :
                                                    {!! $not->pricing->type !!}
                                                    </br>
                                                    تاريخ الاشتراق في الباقه :
                                                    <?php $newDate = date('d-m-Y', strtotime($not->created_at));
                                                    echo $newDate; ?>

                                                    </br>

                                                    سعر الباقه :
                                                    {{ $not->pricing->price }}

                                                    جنيه مصري

                                                    <br />
                                                    النقاط التي تعطيها الباقه :
                                                    {{ $not->start_points }}
                                                    نقطه
                                                    </br>
                                                    تم خصم :
                                                    {{ $not->sub_points }}
                                                    نقطه

                                                    </br>

                                                    النقاط المتاحه حاليا :
                                                    {{ $not->current_points }}
                                                    نقطه

                                                    </br>
                                                </p>
                                            </div>





                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        @endif
</div>


                                        </div>


                                    </div>
                        <!-- ============================     الدفع  ================================== -->

<hr />

  <div class="accordion" id="accordionExample">


                                        <div class="accordion-item">

                                        
   <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                                data-bs-target="#collapseTwo" aria-expanded="true"

                                                aria-controls="collapseTwo">







                        <h3 class="mt-3"> عمليات الدفع المقبوله</h3>







                                            </button>
<div id="collapseTwo" class="accordion-collapse collapse"

                                                aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        @if (!empty($FawryPayment_data))

                            @foreach ($FawryPayment_data->sortByDesc('id') as $not)
                                <div class="col-lg-12">
                                    <div id="notifi " class="rounded alert notifi_div text-center card mt-3">



                                                <p style=" text-align: right;">
                                                    قيمه المبلغ :
                                                    {{ $not->paymentAmount }}
                                                    <br />
                                                    تاريخ العمليه :
                                                    <?php $newDate = date('d-m-Y', strtotime($not->created_at));
                                                    echo $newDate; ?>

                                                    <br />
                                                    الحاله :
                                                    {{ $not->paymentStatus }}
                                                        
                                                    <br />
                                                    طريقه الدفع
                                                    {{ $not->paymentMethod }}

                                                    </br>
                                                    الرقم
                                                    {{ $not->referenceNumber }}

                                                    </br>

                                                    الرقم المرجعي :

                                                    {{ $not->merchantRefNumber }}

                                                </p>
                                            





                                    </div>

                                </div>
                            @endforeach
  <div style="  direction: rtl;">
                            {{ $FawryPayment_data->appends( ( 'posts'))->links()  }}
  </div>
                        @endif

</div>


  </div>


                                    </div>

                                    <hr />

  <div class="accordion" id="accordionExample">


                                        <div class="accordion-item">

                                        
   <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                                data-bs-target="#collapseThree" aria-expanded="true"

                                                aria-controls="collapseThree">







                        <h3 class="mt-3"> عمليات الدفع غير مقبوله</h3>







                                            </button>
<div id="collapseThree" class="accordion-collapse collapse"
                                                aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        @if (!empty($FawryPayment_data_unpaid))
                                                
                            @foreach ($FawryPayment_data_unpaid->sortByDesc('id') as $not2)
                                <div class="col-lg-12">
                                    <div id="notifi " class="rounded alert notifi_div text-center card mt-3">



                                                <p style=" text-align: right;">
                                                    قيمه المبلغ :
                                                    {{ $not2->paymentAmount }}
                                                    <br />
                                                    تاريخ العمليه :
                                                    <?php $newDate = date('d-m-Y', strtotime($not2->created_at));
                                                    echo $newDate; ?>

                                                    <br />
                                                    الحاله :
                                                    {{ $not2->paymentStatus }}
                                                        
                                                    <br />
                                                    طريقه الدفع
                                                    {{ $not2->paymentMethod }}

                                                    <br />
                                                    الرقم
                                                    {{ $not2->referenceNumber }}

                                                    <br />

                                                    الرقم المرجعي :

                                                    {{ $not2->merchantRefNumber }}

                                                </p>
                                            





                                    </div>

                                </div>
                            @endforeach
  <div style="  direction: rtl;">
                            {{ $FawryPayment_data_unpaid->appends( ( 'posts'))->links()  }}
  </div>
                        @endif

</div>


  </div>


                                    </div>



                    </div>


                    <div class="col-md-4">

                        <div class="card mt-3">

                            <div class="card-body">

                                <div class="d-flex flex-column align-items-center text-center">

                                    @if (!empty(Auth::user()->profile_image))
                                        <img src="{{ URL::to('/') . '/images/' . Auth::user()->profile_image }}"
                                            alt="Admin" class="rounded-circle admin" loading="lazy" >
                                    @else
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"
                                            class="rounded-circle admin" loading="lazy">
                                    @endif

                                    <div class="mt-3">

                                        <h4> {{ $user->name }} </h4>
                                        <a
                                            href="{{ URL::to(Config::get('app.locale') . '/user_point_count_history') }}">
                                            <p><strong>عدد النقاط</strong>
                                                <span> {{ $points }}</span>
                                                <i class=" fa fa-check-circle "></i>
                                        </a>

                                        <hr class="hr-add">



                                        <a data-toggle="tooltip" title="التنبيهات  !"
                                            href="{{ URL::to(Config::get('app.locale') . '/notification') }}"
                                            style="<?php if($countNotifi > 0){ ?> color:gold; <?php }?>  "><i
                                                class="fa fa-bell"></i></a>

                                        <a data-toggle="tooltip" title=" اعلاناتي !"
                                            href="{{ URL::to(Config::get('app.locale') . '/user_ads') }}"
                                            style="margin:0 10px" type="button"><i class="fa fa-building"></i></a>
                                        <a data-toggle="tooltip" title="المفضله !"
                                            href="{{ URL::to(Config::get('app.locale') . '/user_wishs') }}"
                                            type="button"><i class="fa fa-heart"></i></a>







                                    </div>

                                </div>

                            </div>

                        </div>



                        <div class="sticky mt-3">
                            <x-purchase-now />

                        </div>

                    </div>




                </div>

                <h3 class="mt-3 mb-5">العقارات التي تم التواصل مع ملاكها<h3>

                        @foreach ($all_data as $val)
                            @if ($val->all_aqat_viw != null)


                                <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">


                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                    <div><a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                            target="_blank">
                                                            @if ($val->all_aqat_viw->firstImage)
                                                                <img src="{{ URL::to('/') . '/images/' . $val->all_aqat_viw->firstImage->img_url }}"
                                                                    class="img-fluid mx-auto" alt="" loading="lazy" />

                                                            @else

                                                                <img src="https://rightchoice-co.com/images/FBO.png"
                                                                    class="img-fluid main-img" alt="main" loading="lazy" >



                                                            @endif
                                                        </a></div>




                                                </div>

                                                <div class="views-2">
                                                    <i class="fa fa-eye"></i>
                                                    <span>{{ $val->all_aqat_viw->views }}</span>

                                                </div>
                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4 class="listing-name verified"><a
                                                                        href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                                        target="_blank">

                                                                        {{ $val->all_aqat_viw->title }}
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>

                                                            <div>

                                                                <a href="#" class="btn btn-outline-warning">عدد النقاط
                                                                    التي تم خصمها :
                                                                    {{ $val->all_aqat_viw->points_avail }}</a>

                                                            </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                                @if ($val->all_aqat_viw->offerTypes->id == 1 || $val->all_aqat_viw->offerTypes->id == 2)
                                                                    {{ $val->all_aqat_viw->total_price }}
                                                                @endif
                                                                @if ($val->all_aqat_viw->offerTypes->id == 3 || $val->all_aqat_viw->offerTypes->id == 4)
                                                                    {{ $val->all_aqat_viw->monthly_rent }}
                                                                @endif جنيه مصري
                                                            </h6>
                                                        </div>

                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2">
                                                            <div class="listing-card-info-icon">
                                                                تاريخ مشاهده العقار :
                                                                <?php $newDate = date('d-m-Y', strtotime($val->created_at));
                                                                echo $newDate; ?>

                                                            </div>



                                                        </div>
                                                    </div>

                                                    <div class="btnAdds listing-detail-footer">
                                                        <div class="footer-first">
                                                            <div class="foot-location">
                                                                @if ($val->all_aqat_viw->governrateq)
                                                                    {{ $val->all_aqat_viw->governrateq->governrate }}
                                                                @endif,
                                                                @if ($val->all_aqat_viw->districte)
                                                                    {{ $val->all_aqat_viw->districte->district }}
                                                                @endif
                                                                @if ($val->all_aqat_viw->subAreaa)
                                                                    {{ $val->all_aqat_viw->subAreaa->area }}
                                                                @endif
                                                                <img src="{{ asset('assets/img/pin.svg') }}"
                                                                    width="18" alt="" loading="lazy" />

                                                            </div>
                                                        </div>
                                                        <a class="btn btn-light  ml-2 addToCart"
                                                            data-id="{{ $val->all_aqat_viw['id'] }}"> حفظ <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-heart"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                            </svg></a>
                                                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                            id="btn1" class="btn" target="_blank">عرض</a>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">


                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                    <div>
                                                        <img style=" object-fit: contain;"
                                                            src="https://rightchoice-co.com/assets/img/rclogo.png"
                                                            class="img-fluid mx-auto" alt="" loading="lazy" />
                                                    </div>




                                                </div>


                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4 class="listing-name verified"><a href="#"
                                                                        target="_blank">
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified">
                                                                <a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>

                                                            <div>


                                                            </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                            </h6>
                                                        </div>

                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2">
                                                            <div class="listing-card-info-icon">
                                                                <h3></br></br>
                                                                    تم مسح العقار
                                                                </h3>
                                                            </div>



                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--     aqar has been deleted -->
                            @endif
                        @endforeach



                        <div style="  direction: rtl;">

                            {{ $all_data->links() }} </div>






            </div>

        </div>





    </section>


    <!-- ============================ Call To Action ================================== -->
    <x-call-to-action />
    <!-- ============================ Call To Action End ================================== -->

</x-layout>
