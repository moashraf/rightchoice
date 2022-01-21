<x-layout>
    <section id="sale-props">

        <div class="container">
<?php //dd($minPrice); ?>
            <h1 class="headingTitle2">
                @if (\Request::is('aqars-cash')) 
                @section('title',' عقارات للبيع' )

                    عقارات للبيع
                @endif

                @if (\Request::is('aqars-installment'))
                                @section('title',' عقارات تقسيط' )

                    عقارات للتقسيط
                @endif

                @if (\Request::is('aqar-finnance'))
                                @section('title',' عقارات تصلح تمويل عقاري' )

                    عقارات تصلح تمويل عقاري
                @endif

                @if (\Request::is('aqars-new-rent-law'))
                                @section('title',' عقارات ايجار قانون جديد' )

                    عقارات للايجار قانون جديد
                @endif

                @if (\Request::is('aqars-furnished-rent'))
                                @section('title',' عقارات ايجار مفروش' )

                    عقارات للايجار مفروش
                @endif

                @if (\Request::is('search'))
                                @section('title','بحث الموقع' )

                    قائمه البحث
                @endif

                @if (\Request::is('filter'))
                                @section('title','تحديد' )

                    النتائج
                @endif



            </h1>

            <br>

            <div class="row">

                <div class="col-lg-3"></div>
                <div class="col-lg-5 col-sale">
                    @if(Auth::check())
                    <a style="max-height:35px;" class="ml-3 btn btn-light" href="{{ URL::to(Config::get('app.locale').'/user_wishs') }}" 
                    > قائمه المفضلات <svg
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-heart" viewBox="0 0 16 16">

                        <path
                            d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />

                    </svg>
                    </a>
                    @endif
                </div>

                <div class="col-lg-4" style="justify-content: space-between;
                ">

          


                     <form action="{{ route('sort', Config::get('app.locale')) }}" id="sortform" method="get">
                        @csrf

                        <input name="typeoff" type="hidden" value="{{ $offs }}">

    

                        <select onchange="this.form.submit()" class="myselect sortSelect" name="sort" id="sorting">

                            <option  value="" selected disabled  >الترتيب</option>
    
                            <option  value="5" {{ $sort == '5' ? 'selected' : '' }}>التاريخ: الاحدث اولا</option>
    
                            <option value="6" {{ $sort == '6' ? 'selected' : '' }}>التاريخ: الاقدم اولا</option>
    
                            <option value="2" {{ $sort == '2' ? 'selected' : '' }}>السعر: الاقل اولا</option>
    
                            <option value="1" {{ $sort == '1' ? 'selected' : '' }}>السعر: الاعلى اولا</option>
    
                            <option value="4" {{ $sort == '4' ? 'selected' : '' }}>المساحه: الاقل اولا</option>
    
                            <option value="3" {{ $sort == '3' ? 'selected' : '' }}>المساحه: الاعلى اولا</option>
    
                        </select>
                     </form>

                </div>







                <div class="row mt-3">

                    <div class="col-lg-3 filter-props">

<div class="sticky">
                                    <x-purchase-now />

</div>
                        <div class="card">

                            <div class="card-body">

                                <form action="{{ route('filter',Config::get('app.locale')) }}" id="selectform" method="get">
                                    @csrf

                                    @if (\Request::is('aqars-cash'))
                                    <input name="typeoff" type="hidden" value="1">
                                @endif
                
                                @if (\Request::is('aqars-installment'))
                                <input name="typeoff" type="hidden" value="2">
                                @endif
                
                                @if (\Request::is('aqars-finnance'))
                                <input name="typeoff" type="hidden" value="5">
                                @endif
                
                                @if (\Request::is('aqars-new-rent-law'))
                                <input name="typeoff" type="hidden" value="3">
                                @endif
                
                                @if (\Request::is('aqars-furnished-rent'))
                                <input name="typeoff" type="hidden" value="3">
                                @endif
                
                                    <div class="accordion" id="accordionExample">
	<input name="keywords" type="text" class="form-control"  value="<?php if(!empty( $keyWords )) {echo $keyWords ; } ?>"	placeholder="كلمه البحث">
															
															<br>
                                        <div class="accordion-item">

                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">

                                                <h5>{{ trans('langsite.location').' '}}<span class="optional">{{trans('langsite.optional')}}</span></h5>

                                            </button>

                                            <div id="collapseOne" class="accordion-collapse collapse  "
                                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                                                <div class="">

                                                    <fieldset>

                                                        <select  class="myselect mt-3" name="location1" id="location1">

                                                            <option value=""  selected disabled >المحافظه</option>
                                                            @foreach ($governrates as $gover)
                                                                <option value="{{ $gover->id }}" {{ $governratew == $gover->id ? 'selected' : '' }}>
                                                                    
                                                                    {{ $gover->governrate }}</option>
                                                            @endforeach




                                                        </select>

                                                        <select class="myselect mt-3" name="location2" id="location2">

                                                            <option value="" selected disabled   >الحي</option>
                                                            @foreach ($district as $dis)
                                                                <option value="{{ $dis->id }}" {{ $districtw == $dis->id ? 'selected' : '' }}>
                                                                    
                                                                    {{ $dis->district }}</option>
                                                            @endforeach


                                                        </select>

                                                        <input list="areas" name="area" id="area" class="myselect mt-3"
                                                        value="<?php echo $areaw ;?>"
                                                                        placeholder="المنطقه"  >
                                                                        <datalist id="areas">
                                                               <option value="" selected disabled  >المنطقه</option>

                                                                @foreach ($areas as $aaa)
                                                                
                                                                 <option value="{{ $aaa->area }}" {{ $areaw == $aaa->area ? 'selected' : '' }}>
                                                                    {{ $aaa->area }}</option>
                                                            @endforeach  
                                                            </datalist>
                                              
                                              
                                                <div class="form-group mt-3">

 
                        <select type="text" name="compound" list="li-compound" class="myselect"
                            value="{{ old('compound') }}" >

                        <option value="" selected disabled  >اسم الكومبوند</option>
                            @foreach ($compounds as $comp)
                                <option value="{{ $comp->id }}" >
                                    {{ $comp->compound }}</option>
                            @endforeach
                        </select>

                    </div>
                    
                    </div>

                                            </div>

                                        </div>





                                    </div>

                                    <div class="accordion mt-2" id="accordiLastxample">

    <div class="accordion-item">

        <button class="accordion-button" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapseLast" aria-expanded="true"
            aria-controls="collapseLast">

            <h5>{{ trans('langsite.moreDetails').' '}}<span class="optional">{{trans('langsite.optional')}}</span></h5>

        </button>

        <div id="collapseLast" class="accordion-collapse collapse show "
            aria-labelledby="headingLast" data-bs-parent="#accordiLastxample">

            <div class="">

                <fieldset class="mt-2">




                    <div class="form-group">
                        
                                                <label for="Property-type">تصنيف العقار</label>

    <select class="myselect" name="licat" id="li-cat">

                            <option   value="" selected disabled  >اختر</option>

                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $cat_id == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}
                                </option>
                            @endforeach

                        </select>

                    </div>



                    <div class="form-group">

                        <label for="Property-type">نوع العقار</label>

                        <select name="Propertytype" id="Property-type" class="myselect">

                            <option   value="" selected disabled  >اختر نوع العقار</option>



                        </select>

                    </div>

                    <div class="form-group">

                        <label for="">نوع العرض</label>

                        <select class="myselect" name="saletype" id="sale-type">

                            <option   value="" selected disabled  >اختر</option>

                            @foreach ($offerTypes as $offer)
                                <option <?php ?>
                                    value="{{ $offer->id }}" {{ $offs == $offer->id ? 'selected' : '' }}>{{ $offer->type_offer }}
                                </option>
                            @endforeach



                        </select>

                    </div>

                  

                    <div class="form-group">

                        <label for="li-finish">التشطيب</label>

                        <select name="finishtype2" id="li-finish" class="myselect">

                            <option   value="" selected disabled >اختر نوع التشطيب</option>
                            <option value="">الكل</option>

                            @foreach ($finishes as $finish)
                                <option value="{{ $finish->id }}" {{ $finishType == $finish->id ? 'selected' : '' }}>
                                    {{ $finish->finish_type }}</option>
                            @endforeach



                        </select>



                    </div>





                </fieldset>




            </div>

        </div>

    </div>





</div>

                                    <div class="accordion-item  mt-3">

                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="true"
                                            aria-controls="collapseOne">

                                            <h5>{{ trans('langsite.searchDetails').' '}}<span class="optional">{{trans('langsite.optional')}}</span></h5>

                                        </button>

                                        <div id="collapseTwo" class="accordion-collapse collapse">

                                            <div class="">

                                                <fieldset>

                                                    <div class="row mt-3">

                                                        <label for="area">المساحه</label>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="minArea"
                                                                id="area" placeholder="من" min="1" value="{{ $minArea }}">

                                                        </div>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="maxArea"
                                                                id="area" placeholder="الى">

                                                        </div>

                                                    </div>

                                                    <div class="row mt-3">

                                                        <label for="price">السعر</label>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="minPrice"
                                                                id="price" placeholder="من" min="1" value="{{ $minPrice }}">

                                                        </div>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="maxPrice"
                                                                id="price2" placeholder="الى"  value="{{ $maxPrice }}">

                                                        </div>

                                                    </div>

                                                    <div class="row mt-3">

                                                        <label for="room">الغرف</label>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="minRooms"
                                                                id="room" placeholder="من" min="1"  value="{{ $minRooms }}">

                                                        </div>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="maxRooms"
                                                                id="room2" placeholder="الى" min="0"  value="{{ $maxPrice }}">

                                                        </div>

                                                    </div>

                                                    <div class="row mt-3">

                                                        <label for="bathroom">الحمامات</label>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="minBaths"
                                                                id="baths" placeholder="من" min="0"  value="{{ $minBaths }}">

                                                        </div>

                                                        <div class="col">

                                                            <input class="myselect" type="number" name="maxBaths"
                                                                id="baths2" placeholder="الى" min="0"  value="{{ $maxBaths }}">
                                                        </div>

                                                    </div>



                                                </fieldset>

                                            </div>

                                        </div>

                                    </div>



                                    <div class="accordion-item  mt-3">

                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree">

                                            <h5>{{ trans('langsite.Advantages').' ' }}<span class="optional">{{trans('langsite.optional')}}</span></h5>

                                        </button>

                                        <div id="collapseThree" class="accordion-collapse collapse">

                                            <div class="">

                                                <fieldset>

                                                    @foreach ($mzaya as $maz)
                                                        <div class="form-check">

                                                            <input class="form-check-input" name="mzaya[]"
                                                                type="checkbox" value="{{ $maz->id }}"
                                                                id="secuirty">

                                                            <label class="form-check-label" for="{{ $maz->mzaya_type }}">

                                                                {{ $maz->mzaya_type }}
                                                            </label>

                                                        </div>
                                                    @endforeach






                                                </fieldset>

                                            </div>

                                        </div>

                                    </div>

                            </div>

                            <div class="submit-btns">

                                <input  type="reset" id="resetBtn" href="" class="btn btn-light" value="اعد الاختيارات" />
                                <script>
                                    var resetBtn = document.getElementById('resetBtn');
                                    resetBtn.addEventListener("click", function() {
                                        document.getElementById("selectform").reset();
                                    });

                                </script>
                                <input value="بحث" type="submit" class="btn our-btn">

                            </div>

                            </form>



                        </div>

                    </div>

                    <div class="col-lg-9 col-cards-2">

                        <div class="row">
                        
<div class="col-lg-12" dir="ltr">
    <div class="vip-slide">

        @foreach ($vipAqars as $vip)
        <!-- Single Property -->
        <div class="single-items">
           <div class="card vip">
                                    @if($vip->mainImage)
                                   <img class="card-img"
                                    src="{{ URL::to('/') . '/images/' . $vip->mainImage->img_url }}"
                                    alt="{{ $vip->title }}">
                                     @elseif($vip->firstImage)
                                  <img class="card-img"
                                        src="{{ URL::to('/') . '/images/' . $vip->firstImage->img_url }}"
                                        alt="{{ $vip->title }}">
                    
                                     @else
                   
                                     <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"    alt="main">

                                     @endif
    
                        <div class="views">
                            <div class="views-1">مميز</div>
                        </div>
                           <div class="views-3">
                            <i class="fa fa-eye"></i>
                            <span>{{ $vip->views }}</span>

                        </div>
                                

                                    <div class="card-img-overlay text-white d-flex flex-column justify-content-end align-content-end"
                                        >
                                      
                                          <div><a dir="rtl"
                href="{{ URL::to(Config::get('app.locale').'/aqars/' . $vip->slug) }}" target="_blank">
                <h5 class="card-title">
                    {{ \Illuminate\Support\Str::limit($vip->title, 35)  }}
                </h5>
            </a></div>
                                       
                                        <div class="card-text">

            <h6>
                
                    @if ($vip->offerTypes->id == 1 || $vip->offerTypes->id == 2 )
                                                                {{ $vip->total_price }}
                                                                @endif
                                                                @if ($vip->offerTypes->id == 3 || $vip->offerTypes->id == 4 )
                                                                {{ $vip->monthly_rent }}
                                                                @endif  جنيه مصري  
                
                
                
                
                </h6>

        </div>
                                        <div class="">
                                   <div class="list-fx-features">
                <div class="listing-card-info-icon text-white">
                    {{ $vip->baths }}
                    حمام
                    <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="13" alt="" />
                    </div>
                </div>
                <div class="listing-card-info-icon text-white">
                    {{ $vip->rooms }}
                    غرف
                    <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="13" alt="" />
                    </div>
                </div>

                <div class="listing-card-info-icon text-white">
                    {{ $vip->total_area }}
                    م²
                    <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="13" alt="" />
                    </div>
                </div>
            </div>
                                        <h6 class="card-subtitle  fw-bold">
                                            <div class="foot-location2 text-white">

            @if ($vip->governrateq)
            {{ $vip->governrateq->governrate }}
            @endif,
            @if ($vip->districte)
            {{ $vip->districte->district }}
            @endif
           
            <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
        </div>
                                        </h6>

                                        <div class="footer-flex d-flex link mt-2">
                                            <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $vip->slug) }}" class="btn btn-success ">عرض</a>
                                              <a class="btn btn-light  ml-2 addToCart" data-id="{{$vip['id']}}"> حفظ <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-heart"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                        </svg></a>
                                            
                                            </div>
                                    </div>
                                </div>
        </div>
         </div>
@endforeach
        

               
    

</div></div>
                           
                                           
<?php    //  if (!empty($_GET['location1'])) { echo (  $_GET['location1']  ) ;   }  ?>
<br>
<?php      //if (!empty($_GET['location2'])) { echo (  $_GET['location2']  ) ;   }  ?>
<br>
<?php     // if (!empty($_GET['area'])) { echo (  $_GET['area']  ) ;   }  ?>
<br>
<?php     // if (!empty($_GET['saletype'])) { echo (  $_GET['saletype']  ) ;   }  ?>
<br>
<?php     // if (!empty($_GET['saletype'])) { echo (  $_GET['saletype']  ) ;   }  ?>

<?php  //echo $allAqars->count(); ?>
                                     @foreach ($allAqars as $aqar)
                                <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">

                                        
                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                        <div>
                                                            <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}" target="_blank">
                                                                
                                                                
                                                                 @if($aqar->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqar->mainImage->img_url}}"  class="img-fluid mx-auto" alt="main">
                            

                                
                                                            @elseif($aqar->firstImage)
                                                            <img
                                                                    src="{{ URL::to('/') . '/images/' . $aqar->firstImage->img_url }}"
                                                                    class="img-fluid mx-auto" alt="" />
                                                                    	@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"    alt="main">
                                                                    @endif

                                                                
                                                                    </a>
                                                                    </div>
                                                                    


                                            
                                                </div>
                                                
                                                
                                 <?php  if($aqar->vip ==1 ){   ?>               
                          <div class="views">
                            <div class="views-1">مميز</div>
                        </div>
                        
                                                         <?php }  ?>               

                        
                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $aqar->views }}
                          
                            
                            
                            
                            
                            </span>

                        </div>
                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap">
                                                            <div class="listing-short-detail">
                                                                <h4  class="listing-name verified"><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}" target="_blank">

                                                                        {{ $aqar->title }}
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>
                                                            

                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                                @if ($aqar->offerTypes->id == 1 || $aqar->offerTypes->id == 2 )
                                                                {{ $aqar->total_price }}
                                                                @endif
                                                                @if ($aqar->offerTypes->id == 3 || $aqar->offerTypes->id == 4 )
                                                                {{ $aqar->monthly_rent }}
                                                                @endif  جنيه مصري   
                                                            </h6>
                                                        </div>
                                                   
                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2" >
                                                            <div class="listing-card-info-icon">
                                                               {{ $aqar->baths }}
                                                               حمام
                                                                <div class="inc-fleat-icon"><img
                                                                        src="{{ asset('images/icons/area.png') }}" width="13"
                                                                        alt="" />
                                                                </div>
                                                            </div>
                                                            <div class="listing-card-info-icon">
                                                                {{ $aqar->rooms }}
                                                                غرف
                                                                <div class="inc-fleat-icon"><img
                                                                        src="{{ asset('images/icons/room.png') }}" width="13" alt="" />
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="listing-card-info-icon">
                                                                {{ $aqar->total_area }}
                                                                م²
                                                                <div class="inc-fleat-icon"><img
                                                                        src="{{ asset('images/icons/area.png') }}" width="13" alt="" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                      
                                                    <div class="btnAdds listing-detail-footer">
                                                        	<div class="footer-first">
											<div class="foot-location">
										                              @if ($aqar->governrateq)
                                                                        {{ $aqar->governrateq->governrate }}
                                                                    @endif
                                                                     @if ($aqar->districte)
                                                                     ,
                                                                    {{ $aqar->districte->district }}
                                                                    @endif 
                                                                    
                                                                    
                                                               
                                                                    <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
											
											</div>
										</div>
                                                        <a class="btn btn-light  ml-2 addToCart" data-id="{{$aqar['id']}}"> حفظ <svg
                                                            xmlns="http://www.w3.org/2000/svg" width="16"
                                                            height="16" fill="currentColor" class="bi bi-heart"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                        </svg></a>
                                                        <a  href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->slug) }}" id="btn1" class="btn" target="_blank">عرض</a>
                                                       
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach




                        </div>

                    </div>

                </div>



            </div>

            <div style="  direction: rtl;"  >

            {!! $allAqars->appends(Request::except('page'))->render() !!}

        </div>
        </div>

    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#location1').on('change', function() {
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
                    success: function(result) {
                        $('#location2').html('<option value="" selected disabled  >الحي</option>');
                        $.each(result.states, function(key, value) {
                            $("#location2").append('<option value="' + value
                                .id + '">' + value.district + '</option>');
                        });
                    }
                });
            });

        });

    </script>

   



</x-layout>
