<x-layout>
    <section id="sale-props" class="modern-properties-page">

        <div class="container">
            <?php //dd($minPrice);
            ?>
            <div class="properties-hero">
                <div class="properties-hero__content">
                    <span class="properties-hero__eyebrow">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="m3 11 9-8 9 8"/>
                            <path d="M5 10v10h14V10"/>
                            <path d="M9 20v-6h6v6"/>
                        </svg>
                        فرص عقارية مختارة بعناية
                    </span>

                    <h1 class="headingTitle2">
                        @if (\Request::segment(2) =='aqars-cash')
                            @section('title', ' عقارات للبيع')
                            عقارات للبيع
                        @endif

                        @if (\Request::segment(2) =='aqars-installment')
                            @section('title', ' عقارات تقسيط')
                            عقارات للتقسيط
                        @endif

                        @if (\Request::segment(2) =='aqar-finnance')
                            @section('title', ' عقارات تصلح تمويل عقاري')
                            عقارات تصلح تمويل عقاري
                        @endif

                        @if (\Request::segment(2) =='aqars-new-rent-law')
                            @section('title', ' عقارات ايجار قانون جديد')
                            عقارات للايجار قانون جديد
                        @endif

                        @if (\Request::segment(2) =='aqars-furnished-rent')
                            @section('title', ' عقارات ايجار مفروش')
                            عقارات للايجار مفروش
                        @endif

                        @if (\Request::segment(2) =='search')
                            @section('title', 'بحث الموقع')
                            قائمه البحث
                        @endif

                        @if (\Request::segment(2) =='filter')
                            @section('title', 'تحديد')
                            النتائج
                        @endif
                    </h1>

                    <p class="properties-hero__description">
                        قارن بين أفضل الوحدات، استخدم الفلاتر للوصول إلى اختيارك المناسب، وتواصل مباشرة بدون وسيط.
                    </p>

                    <div class="properties-hero__stats">
                        <span>
                            <strong>{{ number_format($allAqars->total()) }}</strong>
                            عقار متاح
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5"/>
                            </svg>
                            تواصل مباشر مع المالك
                        </span>
                    </div>
                </div>

                <div class="properties-hero__brand" aria-hidden="true">
                    <span>RC</span>
                    <small>Right Choice</small>
                </div>
            </div>

            <div class="properties-toolbar">
                <div class="properties-toolbar__intro">
                    <span class="properties-toolbar__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M4 6h16"/>
                            <path d="M7 12h10"/>
                            <path d="M10 18h4"/>
                        </svg>
                    </span>
                    <div>
                        <strong>رتّب النتائج بالطريقة المناسبة لك</strong>
                        <small>استخدم البحث المتقدم لتحديد العقار الأقرب لاحتياجاتك</small>
                    </div>
                </div>

                <div class="properties-toolbar__actions">
                    @if (Auth::check())
                        <a class="btn properties-wishlist-btn"
                           href="{{ URL::to(Config::get('app.locale') . '/user_wishs') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor"
                                 class="bi bi-heart" viewBox="0 0 16 16" aria-hidden="true">
                                <path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                            </svg>
                            قائمة المفضلات
                        </a>
                    @endif

                    @if (\Request::segment(2) =='filter')
                        <form action="{{ route('sort', Config::get('app.locale')) }}" id="sortform" method="get" class="properties-sort-form">
                            @csrf
                            <input name="typeoff" type="hidden" value="{{ $offs }}">
                            <label for="sorting">ترتيب حسب</label>
                            <select onchange="submit_another_form_filter()" class="myselect sortSelect" name="sort" id="sorting">
                                <option value="" selected disabled>اختر الترتيب</option>
                                <option value="5" {{ $sort == '5' ? 'selected' : '' }}>التاريخ: الأحدث أولاً</option>
                                <option value="6" {{ $sort == '6' ? 'selected' : '' }}>التاريخ: الأقدم أولاً</option>
                                <option value="2" {{ $sort == '2' ? 'selected' : '' }}>السعر: الأقل أولاً</option>
                                <option value="1" {{ $sort == '1' ? 'selected' : '' }}>السعر: الأعلى أولاً</option>
                                <option value="4" {{ $sort == '4' ? 'selected' : '' }}>المساحة: الأقل أولاً</option>
                                <option value="3" {{ $sort == '3' ? 'selected' : '' }}>المساحة: الأعلى أولاً</option>
                            </select>
                        </form>
                    @else
                        <form action="{{ route('sort', Config::get('app.locale')) }}" id="sortform" method="get" class="properties-sort-form">
                            @csrf
                            <input name="typeoff" type="hidden" value="{{ $offs }}">
                            <label for="sorting">ترتيب حسب</label>
                            <select onchange="this.form.submit()" class="myselect sortSelect" name="sort" id="sorting">
                                <option value="" selected disabled>اختر الترتيب</option>
                                <option value="5" {{ $sort == '5' ? 'selected' : '' }}>التاريخ: الأحدث أولاً</option>
                                <option value="6" {{ $sort == '6' ? 'selected' : '' }}>التاريخ: الأقدم أولاً</option>
                                <option value="2" {{ $sort == '2' ? 'selected' : '' }}>السعر: الأقل أولاً</option>
                                <option value="1" {{ $sort == '1' ? 'selected' : '' }}>السعر: الأعلى أولاً</option>
                                <option value="4" {{ $sort == '4' ? 'selected' : '' }}>المساحة: الأقل أولاً</option>
                                <option value="3" {{ $sort == '3' ? 'selected' : '' }}>المساحة: الأعلى أولاً</option>
                            </select>
                        </form>
                    @endif
                </div>
            </div>

            <div class="row mt-4 properties-layout">

                <div class="all-aqars-all-aqars col-lg-3 filter-props">

                    <div class="sticky">
                        <x-purchase-now/>

                    </div>
                    <div class="card filter-card">

                        <div class="card-body">
                            <div class="filter-card__heading">
                                    <span class="filter-card__heading-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                            <path d="M4 21v-7"/>
                                            <path d="M4 10V3"/>
                                            <path d="M12 21v-9"/>
                                            <path d="M12 8V3"/>
                                            <path d="M20 21v-5"/>
                                            <path d="M20 12V3"/>
                                            <path d="M1 14h6"/>
                                            <path d="M9 8h6"/>
                                            <path d="M17 16h6"/>
                                        </svg>
                                    </span>
                                <div>
                                    <h2>تصفية النتائج</h2>
                                    <p>حدد مواصفات العقار الذي تبحث عنه</p>
                                </div>
                            </div>

                            <form action="{{ route('filter', Config::get('app.locale')) }}" id="selectform"
                                  method="get">
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
                                    <input name="keywords" type="text" class="form-control"
                                           value="<?php if (!empty($keyWords)) {
                                                echo $keyWords;
                                            } ?>" placeholder="كلمه البحث">

                                    <br>
                                    <div class="accordion-item">

                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="true"
                                                aria-controls="collapseOne">

                                            <h5>{{ trans('langsite.location') . ' ' }}<span
                                                    class="optional">{{ trans('langsite.optional') }}</span>
                                            </h5>

                                        </button>

                                        <div id="collapseOne" class="accordion-collapse collapse  "
                                             aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                                            <div class="">

                                                <fieldset>

                                                    {{-- location1: المحافظه autocomplete --}}
                                                    <div class="autocomplete-wrapper mt-3" id="wrapper-location1">
                                                        <input type="text" class="myselect" id="location1-text"
                                                               placeholder="المحافظه"
                                                               autocomplete="off"
                                                               value="@foreach($governrates as $gover){{ $governratew == $gover->id ? $gover->governrate : '' }}@endforeach">
                                                        <input type="hidden" name="location1" id="location1"
                                                               value="{{ $governratew ?? '' }}">
                                                        <div class="autocomplete-dropdown" id="dropdown-location1">
                                                            @foreach ($governrates as $gover)
                                                                <div class="autocomplete-item"
                                                                     data-value="{{ $gover->id }}"
                                                                     data-label="{{ $gover->governrate }}">{{ $gover->governrate }}</div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    {{-- location2: الحي autocomplete --}}
                                                    <div class="autocomplete-wrapper mt-3" id="wrapper-location2">
                                                        <input type="text" class="myselect" id="location2-text"
                                                               placeholder="الحي"
                                                               autocomplete="off"
                                                               value="@foreach($district as $dis){{ $districtw == $dis->id ? $dis->district : '' }}@endforeach">
                                                        <input type="hidden" name="location2" id="location2"
                                                               value="{{ $districtw ?? '' }}">
                                                        <div class="autocomplete-dropdown" id="dropdown-location2">
                                                            @foreach ($district as $dis)
                                                                <div class="autocomplete-item"
                                                                     data-value="{{ $dis->id }}"
                                                                     data-label="{{ $dis->district }}">{{ $dis->district }}</div>
                                                            @endforeach
                                                        </div>
                                                    </div>

                                                    <input list="areas" name="area" id="area" class="myselect mt-3"
                                                           value="<?php echo $areaw; ?>" placeholder="المنطقه">
                                                    <datalist id="areas">
                                                        <option value="" selected disabled>المنطقه</option>

                                                        @foreach ($areas as $aaa)

                                                            <option value="{{ $aaa->area }}"
                                                                {{ $areaw == $aaa->area ? 'selected' : '' }}>
                                                                {{ $aaa->area }}</option>
                                                        @endforeach
                                                    </datalist>


                                                    {{-- compound: الكومبوند autocomplete --}}
                                                    <div class="autocomplete-wrapper mt-3" id="wrapper-compound">
                                                        <input type="text" class="myselect" id="compound-text"
                                                               placeholder="اسم الكومبوند"
                                                               autocomplete="off"
                                                               value="@foreach($compounds as $comp){{ (isset($compound_singel) && $compound_singel == $comp->id) ? $comp->compound : '' }}@endforeach">
                                                        <input type="hidden" name="compound" id="compound-hidden"
                                                               value="{{ $compound_singel ?? '' }}">
                                                        <div class="autocomplete-dropdown" id="dropdown-compound">
                                                            @foreach ($compounds as $comp)
                                                                <div class="autocomplete-item"
                                                                     data-value="{{ $comp->id }}"
                                                                     data-label="{{ $comp->compound }}">{{ $comp->compound }}</div>
                                                            @endforeach
                                                        </div>
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

                                            <h5>{{ trans('langsite.moreDetails') . ' ' }}<span
                                                    class="optional">{{ trans('langsite.optional') }}</span>
                                            </h5>

                                        </button>

                                        <div id="collapseLast" class="accordion-collapse collapse show "
                                             aria-labelledby="headingLast" data-bs-parent="#accordiLastxample">

                                            <div class="">

                                                <fieldset class="mt-2">


                                                    <div class="form-group">

                                                        <label for="Property-type">تصنيف العقار</label>

                                                        <select class="myselect" name="licat" id="li-cat">

                                                            <option value="" selected disabled>اختر</option>

                                                            @foreach ($categories as $cat)
                                                                <option value="{{ $cat->id }}"
                                                                    {{ $cat_id == $cat->id ? 'selected' : '' }}>
                                                                    {{ $cat->category_name }}
                                                                </option>
                                                            @endforeach

                                                        </select>

                                                    </div>


                                                    <div class="form-group">

                                                        <label for="Property-type">نوع العقار</label>

                                                        <select name="Propertytype" id="Property-type"
                                                                class="myselect">

                                                            <option value="" selected disabled>اختر نوع العقار
                                                            </option>


                                                            @foreach ($categories as $cat)
                                                                    <?php if ($cat_id == $cat->id) { //dd( $prop_id."ffffffff" ); ?>
                                                                @foreach ($cat->all_property_type_of_cat as $cat_val)
                                                                    <option value="{{ $cat_val->id }}"
                                                                        {{ $prop_id == $cat_val->id ? 'selected' : '' }}>
                                                                        {{ $cat_val->property_type }}
                                                                    </option>
                                                                @endforeach
                                                                <?php } ?>

                                                            @endforeach


                                                        </select>

                                                    </div>

                                                    <div class="form-group">

                                                        <label for="">نوع العرض</label>

                                                        <select class="myselect" name="saletype"
                                                                id="sale-type">

                                                            <option value="" selected disabled>اختر</option>
                                                            <option value="ALL1" <?php if ($offs == 'ALL1') {
                                                                echo 'selected';
                                                            } ?> > الكل للبيع
                                                            </option>
                                                            <option value="ALL2" <?php if ($offs == 'ALL2') {
                                                                echo 'selected';
                                                            } ?> > الكل ايجار
                                                            </option>

                                                            @foreach ($offerTypes as $offer)
                                                                <option <?php ?>
                                                                        value="{{ $offer->id }}"
                                                                    {{ $offs == $offer->id ? 'selected' : '' }}>
                                                                    {{ $offer->type_offer }}
                                                                </option>
                                                            @endforeach


                                                        </select>

                                                    </div>


                                                    <div class="form-group">

                                                        <label for="li-finish">التشطيب</label>

                                                        <select name="finishtype2" id="li-finish"
                                                                class="myselect">

                                                            <option value="" selected disabled>اختر نوع التشطيب
                                                            </option>
                                                            <option value="">الكل</option>

                                                            @foreach ($finishes as $finish)
                                                                <option value="{{ $finish->id }}"
                                                                    {{ $finishType == $finish->id ? 'selected' : '' }}>
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

                                        <h5>{{ trans('langsite.searchDetails') . ' ' }}<span
                                                class="optional">{{ trans('langsite.optional') }}</span></h5>

                                    </button>

                                    <div id="collapseTwo" class="accordion-collapse collapse">

                                        <div class="">

                                            <fieldset>

                                                <div class="row mt-3" id="solo">

                                                    <label for="area">المساحه</label>

                                                    <div class="col">

                                                        <input class="myselect hi" type="number" name="minArea"
                                                               id="area" placeholder="من" min="1"
                                                               value="{{ $minArea }}">

                                                    </div>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="maxArea"
                                                               value="{{ $maxArea }}"
                                                               id="area" placeholder="الى">

                                                    </div>

                                                </div>

                                                <div class="row mt-3">

                                                    <label for="price">السعر</label>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="minPrice"
                                                               id="price" placeholder="اعلى سعر " min="1"
                                                               value="{{ $minPrice }}">

                                                    </div>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="maxPrice"
                                                               id="price2" placeholder="اقل سعر "
                                                               value="{{ $maxPrice }}">

                                                    </div>

                                                </div>

                                                <div class="row mt-3">

                                                    <label for="room">الغرف</label>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="minRooms"
                                                               id="room" placeholder="من" min="1"
                                                               value="{{ $minRooms }}">

                                                    </div>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="maxRooms"
                                                               id="room2" placeholder="الى" min="0"
                                                               value="{{ $maxRooms }}">

                                                    </div>

                                                </div>

                                                <div class="row mt-3">

                                                    <label for="bathroom">الحمامات</label>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="minBaths"
                                                               id="baths" placeholder="من" min="0"
                                                               value="{{ $minBaths }}">

                                                    </div>

                                                    <div class="col">

                                                        <input class="myselect" type="number" name="maxBaths"
                                                               id="baths2" placeholder="الى" min="0"
                                                               value="{{ $maxBaths }}">
                                                    </div>

                                                </div>


                                            </fieldset>

                                        </div>

                                    </div>

                                </div>


                                <div class="accordion-item  mt-3">

                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree">

                                        <h5>{{ trans('langsite.Advantages') . ' ' }}<span
                                                class="optional">{{ trans('langsite.optional') }}</span></h5>

                                    </button>

                                    <div id="collapseThree" class="accordion-collapse collapse">

                                        <div class="">

                                            <fieldset>

                                                @foreach ($mzaya as $maz_val)
                                                    <div class="form-check">

                                                        <input class="form-check-input" name="mzaya[]"

                                                               <?php

                                                                   if (isset($maz)) {
                                                                       if (in_array($maz_val->id, $maz)) {
                                                                           echo 'checked';
                                                                       }
                                                                   }
                                                                   ?>
                                                               type="checkbox" value="{{ $maz_val->id }}"
                                                               id="secuirty">

                                                        <label class="form-check-label"
                                                               for="{{ $maz_val->mzaya_type }}">

                                                            {{ $maz_val->mzaya_type }}
                                                        </label>

                                                    </div>
                                                @endforeach


                                            </fieldset>

                                        </div>

                                    </div>

                                </div>

                        </div>

                        <div class="submit-btns">

                            <input type="button" onclick="myFunctionresetBtn()" id="resetBtn" href=""
                                   class="btn btn-light"
                                   value="اعد الاختيارات"/>
                            <script>
                                function myFunctionresetBtn() {
                                    document.getElementById("li-finish").value = "";
                                    document.getElementById("sale-type").value = "";
                                    document.getElementById("price").value = "";
                                    document.getElementById("price2").value = "";
                                    document.getElementById("Property-type").value = "";
                                    document.getElementById("li-cat").value = "";
                                    document.getElementById("room").value = "";
                                    document.getElementById("room2").value = "";
                                    document.getElementById("baths").value = "";
                                    document.getElementById("baths2").value = "";
                                    // autocomplete fields
                                    document.getElementById("location1-text").value = "";
                                    document.getElementById("location1").value = "";
                                    document.getElementById("location2-text").value = "";
                                    document.getElementById("location2").value = "";
                                    document.getElementById("compound-text").value = "";
                                    document.getElementById("compound-hidden").value = "";
                                    document.getElementById("area").value = "";

                                    var uncheck = document.getElementsByTagName('input');
                                    var number = document.getElementsByTagName('input');

                                    for (var i = 0; i < uncheck.length; i++) {
                                        if (uncheck[i].type == 'checkbox') {
                                            uncheck[i].checked = false;
                                        }
                                    }
                                    for (var i = 0; i < number.length; i++) {
                                        if (uncheck[i].type == 'number') {
                                            uncheck[i].value = "";
                                        }
                                    }
                                }
                            </script>
                            <input value="بحث" type="submit" class="btn our-btn">

                        </div>

                        </form>


                    </div>

                </div>

                <div class="col-lg-9 col-cards-2 rc-results-column">

                    @if ($vipAqars->isNotEmpty())
                        <section class="rc-featured-properties" aria-labelledby="featured-properties-title">
                            <div class="rc-results-heading rc-results-heading--featured">
                                <div class="rc-results-heading__title">
                                    <span class="rc-results-heading__icon" aria-hidden="true">
                                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                            <path d="m12 3 2.4 5.1L20 9l-4 4 .95 5.7L12 16l-4.95 2.7L8 13 4 9l5.6-.9L12 3Z"
                                                  stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    <div>
                                        <span class="rc-results-heading__eyebrow">اختيارات مميزة</span>
                                        <h2 id="featured-properties-title">عقارات تستحق اهتمامك</h2>
                                    </div>
                                </div>
                                <p>إعلانات مميزة تظهر لك أولًا لتسهيل الوصول إلى أفضل الفرص.</p>
                            </div>

                            <div class="rc-featured-grid">
                                @foreach ($vipAqars->take(3) as $featuredAqar)
                                    @php
                                        $featuredOffer = $featuredAqar->offerTypes;
                                        $featuredOfferId = (int) optional($featuredOffer)->id;
                                        $featuredPrice = in_array($featuredOfferId, [3, 4], true)
                                            ? $featuredAqar->monthly_rent
                                            : $featuredAqar->total_price;
                                        $featuredHasPrice = is_numeric($featuredPrice) && (float) $featuredPrice > 0;
                                        $featuredHasImage = (bool) ($featuredAqar->mainImage || $featuredAqar->firstImage);
                                        $featuredImage = $featuredAqar->mainImage
                                            ? URL::to('/') . '/images/' . $featuredAqar->mainImage->img_url
                                            : ($featuredAqar->firstImage
                                                ? URL::to('/') . '/images/' . $featuredAqar->firstImage->img_url
                                                : asset('images/FBO.png'));
                                        $featuredUrl = URL::to(Config::get('app.locale') . '/aqars/' . $featuredAqar->slug);
                                        $featuredTitle = $featuredAqar->title ?: 'تفاصيل العقار';
                                        $featuredOfferName = optional($featuredOffer)->type_offer ?: 'عقار مميز';
                                        $featuredUnavailable = $featuredAqar->created_at
                                            && \Carbon\Carbon::now()->diffInYears($featuredAqar->created_at) >= 1;
                                    @endphp

                                    <article class="rc-property-card rc-property-card--featured">
                                        <div class="rc-property-card__media">
                                            <a href="{{ $featuredUrl }}" target="_blank"
                                               aria-label="عرض {{ $featuredTitle }}">
                                                <img
                                                    class="rc-property-card__image {{ $featuredHasImage ? '' : 'rc-property-card__image--placeholder' }}"
                                                    src="{{ $featuredImage }}"
                                                    alt="{{ $featuredTitle }}"
                                                    width="640"
                                                    height="420"
                                                    loading="lazy">
                                            </a>

                                            <div class="rc-property-card__badges">
                                                <x-property-promotion-badge :property="$featuredAqar" />
                                                <span class="rc-property-badge rc-property-badge--offer">
                                                    {{ $featuredOfferName }}
                                                </span>
                                                @if ($featuredUnavailable)
                                                    <span class="rc-property-badge rc-property-badge--unavailable">غير متاح</span>
                                                @endif
                                            </div>

                                            <span class="rc-property-card__views" aria-label="عدد المشاهدات">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                {{ number_format((int) $featuredAqar->views) }}
                                            </span>
                                        </div>

                                        <div class="rc-property-card__content">
                                            <div class="rc-property-card__reference">
                                                <span>فرصة عقارية مميزة</span>
                                                <small>#{{ $featuredAqar->id }}</small>
                                            </div>

                                            <h3 class="rc-property-card__title">
                                                <a href="{{ $featuredUrl }}" target="_blank"
                                                   title="{{ $featuredTitle }}">
                                                    {{ $featuredTitle }}
                                                </a>
                                            </h3>

                                            <div class="rc-property-card__price">
                                                 @if ($featuredHasPrice)
                                                    <strong>{{ number_format((float) $featuredPrice) }}</strong>
                                                    <small>جنيه مصري</small>
                                                @else
                                                    <strong class="rc-property-card__price-contact">عند التواصل</strong>
                                                @endif
                                            </div>

                                            <div class="rc-property-card__meta">
                                                <div>
                                                    <span class="rc-property-card__meta-icon">
                                                        <img src="{{ asset('images/icons/area.png') }}" width="16" height="16" alt="">
                                                    </span>
                                                    <small>المساحة</small>
                                                    <strong>{{ number_format((float) $featuredAqar->total_area) }} م²</strong>
                                                </div>
                                                <div>
                                                    <span class="rc-property-card__meta-icon">
                                                        <img src="{{ asset('images/icons/room.png') }}" width="16" height="16" alt="">
                                                    </span>
                                                    <small>الغرف</small>
                                                    <strong>{{ (int) $featuredAqar->rooms }}</strong>
                                                </div>
                                                <div>
                                                    <span class="rc-property-card__meta-icon">
                                                        <img src="{{ asset('images/icons/bath.png') }}" width="16" height="16" alt="">
                                                    </span>
                                                    <small>الحمامات</small>
                                                    <strong>{{ (int) $featuredAqar->baths }}</strong>
                                                </div>
                                            </div>

                                            <div class="rc-property-card__footer">
                                                <div class="rc-property-card__location">
                                                    <span class="rc-property-card__location-icon" aria-hidden="true">
                                                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                                                            <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                                                  stroke="currentColor" stroke-width="1.8"/>
                                                            <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                                                        </svg>
                                                    </span>
                                                    <span>
                                                        @if ($featuredAqar->governrateq)
                                                            {{ $featuredAqar->governrateq->governrate }}
                                                        @endif
                                                        @if ($featuredAqar->districte)
                                                            <bdi>، {{ $featuredAqar->districte->district }}</bdi>
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="rc-property-card__actions">
                                                    <button type="button"
                                                            class="btn rc-property-action rc-property-action--save addToCart"
                                                            data-id="{{ $featuredAqar['id'] }}">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                            <path d="M20.8 4.7a5.5 5.5 0 0 0-7.8 0L12 5.8l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.4 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"
                                                                  stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                        </svg>
                                                        حفظ
                                                    </button>
                                                    <button type="button"
                                                            class="btn rc-property-action rc-property-action--compare btn-compare-toggle"
                                                            data-compare-id="{{ $featuredAqar->id }}">
                                                        <i class="fas fa-balance-scale" aria-hidden="true"></i>
                                                        قارن
                                                    </button>
                                                    <a href="{{ $featuredUrl }}" target="_blank"
                                                       class="btn rc-property-action rc-property-action--primary">
                                                        عرض التفاصيل
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                            <path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="2"
                                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    <section class="rc-all-properties" aria-labelledby="all-properties-title">
                        <div class="rc-results-heading">
                            <div class="rc-results-heading__title">
                                <span class="rc-results-heading__icon" aria-hidden="true">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <path d="M3 11.5 12 4l9 7.5" stroke="currentColor" stroke-width="1.8"
                                              stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M5.5 10.5V20h13v-9.5M9.5 20v-5h5v5"
                                              stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <div>
                                    <span class="rc-results-heading__eyebrow">نتائج البحث</span>
                                    <h2 id="all-properties-title">كل العقارات المتاحة</h2>
                                </div>
                            </div>
                            <p>
                                يتم عرض {{ number_format($allAqars->count()) }} عقار في هذه الصفحة
                                من إجمالي {{ number_format($allAqars->total()) }} عقار.
                            </p>
                        </div>

                        <div class="rc-properties-stack">
                            @forelse ($allAqars as $aqar)
                                @php
                                    $cardOffer = $aqar->offerTypes;
                                    $cardOfferId = (int) optional($cardOffer)->id;
                                    $cardPrice = in_array($cardOfferId, [3, 4], true)
                                        ? $aqar->monthly_rent
                                        : $aqar->total_price;
                                    $cardHasPrice = is_numeric($cardPrice) && (float) $cardPrice > 0;
                                    $cardHasImage = (bool) ($aqar->mainImage || $aqar->firstImage);
                                    $cardImage = $aqar->mainImage
                                        ? URL::to('/') . '/images/' . $aqar->mainImage->img_url
                                        : ($aqar->firstImage
                                            ? URL::to('/') . '/images/' . $aqar->firstImage->img_url
                                            : asset('images/FBO.png'));
                                    $cardUrl = URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug);
                                    $cardTitle = $aqar->title ?: 'تفاصيل العقار';
                                    $cardOfferName = optional($cardOffer)->type_offer ?: 'عقار';
                                    $cardIsFeatured = $aqar->isPromotionActive();
                                @endphp

                                <article class="rc-property-card rc-property-card--list {{ $cardIsFeatured ? 'rc-property-card--inline-featured' : '' }}">
                                    <div class="rc-property-card__media">
                                        <a href="{{ $cardUrl }}" target="_blank"
                                           aria-label="عرض {{ $cardTitle }}">
                                            <img
                                                class="rc-property-card__image {{ $cardHasImage ? '' : 'rc-property-card__image--placeholder' }}"
                                                src="{{ $cardImage }}"
                                                alt="{{ $cardTitle }}"
                                                width="640"
                                                height="420"
                                                loading="lazy">
                                        </a>

                                        <div class="rc-property-card__badges">
                                            <x-property-promotion-badge :property="$aqar" />
                                            <span class="rc-property-badge rc-property-badge--offer">
                                                {{ $cardOfferName }}
                                            </span>
                                            @if ((int) $aqar->finannce_bank === 1)
                                                <span class="rc-property-badge rc-property-badge--finance">تمويل عقاري</span>
                                            @endif
                                        </div>

                                        <span class="rc-property-card__views" aria-label="عدد المشاهدات">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                            {{ number_format((int) $aqar->views) }}
                                        </span>
                                    </div>

                                    <div class="rc-property-card__content">
                                        <div class="rc-property-card__reference">
                                            <span>{{ $cardOfferName }}</span>
                                            <small>#{{ $aqar->id }}</small>
                                        </div>

                                        <h3 class="rc-property-card__title">
                                            <a href="{{ $cardUrl }}" target="_blank"
                                               title="{{ $cardTitle }}">
                                                {{ $cardTitle }}
                                            </a>
                                        </h3>

                                        <div class="rc-property-card__price">
                                            <span>السعر</span>
                                            @if ($cardHasPrice)
                                                <strong>{{ number_format((float) $cardPrice) }}</strong>
                                                <small>جنيه مصري</small>
                                            @else
                                                <strong class="rc-property-card__price-contact">عند التواصل</strong>
                                            @endif
                                        </div>

                                        <div class="rc-property-card__meta">
                                            <div>
                                                <span class="rc-property-card__meta-icon">
                                                    <img src="{{ asset('images/icons/area.png') }}" width="16" height="16" alt="">
                                                </span>
                                                <small>المساحة</small>
                                                <strong>{{ number_format((float) $aqar->total_area) }} م²</strong>
                                            </div>
                                            <div>
                                                <span class="rc-property-card__meta-icon">
                                                    <img src="{{ asset('images/icons/room.png') }}" width="16" height="16" alt="">
                                                </span>
                                                <small>الغرف</small>
                                                <strong>{{ (int) $aqar->rooms }}</strong>
                                            </div>
                                            <div>
                                                <span class="rc-property-card__meta-icon">
                                                    <img src="{{ asset('images/icons/bath.png') }}" width="16" height="16" alt="">
                                                </span>
                                                <small>الحمامات</small>
                                                <strong>{{ (int) $aqar->baths }}</strong>
                                            </div>
                                        </div>

                                        <div class="rc-property-card__footer">
                                            <div class="rc-property-card__location">
                                                <span class="rc-property-card__location-icon" aria-hidden="true">
                                                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none">
                                                        <path d="M20 10c0 5-8 11-8 11S4 15 4 10a8 8 0 1 1 16 0Z"
                                                              stroke="currentColor" stroke-width="1.8"/>
                                                        <circle cx="12" cy="10" r="2.5" stroke="currentColor" stroke-width="1.8"/>
                                                    </svg>
                                                </span>
                                                <span>
                                                    @if ($aqar->governrateq)
                                                        {{ $aqar->governrateq->governrate }}
                                                    @endif
                                                    @if ($aqar->districte)
                                                        <bdi>، {{ $aqar->districte->district }}</bdi>
                                                    @endif
                                                </span>
                                            </div>

                                            <div class="rc-property-card__actions">
                                                <button type="button"
                                                        class="btn rc-property-action rc-property-action--save addToCart"
                                                        data-id="{{ $aqar['id'] }}">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="M20.8 4.7a5.5 5.5 0 0 0-7.8 0L12 5.8l-1.1-1.1a5.5 5.5 0 0 0-7.8 7.8l1.1 1.1L12 21l7.8-7.4 1.1-1.1a5.5 5.5 0 0 0-.1-7.8Z"
                                                              stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                                    </svg>
                                                    حفظ
                                                </button>
                                                <button type="button"
                                                        class="btn rc-property-action rc-property-action--compare btn-compare-toggle"
                                                        data-compare-id="{{ $aqar->id }}">
                                                    <i class="fas fa-balance-scale" aria-hidden="true"></i>
                                                    قارن
                                                </button>
                                                <a href="{{ $cardUrl }}" target="_blank"
                                                   class="btn rc-property-action rc-property-action--primary">
                                                    عرض التفاصيل
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                                        <path d="m15 18-6-6 6-6" stroke="currentColor" stroke-width="2"
                                                              stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="rc-properties-empty">
                                    <span class="rc-properties-empty__icon" aria-hidden="true">
                                        <svg width="38" height="38" viewBox="0 0 24 24" fill="none">
                                            <path d="M3 11.5 12 4l9 7.5" stroke="currentColor" stroke-width="1.6"
                                                  stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.5 10.5V20h13v-9.5M9.5 20v-5h5v5"
                                                  stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    <h3>لا توجد عقارات مطابقة حاليًا</h3>
                                    <p>جرّب تعديل خيارات البحث أو إزالة بعض الفلاتر لعرض نتائج أكثر.</p>
                                    <a href="{{ url()->current() }}" class="btn">إعادة ضبط البحث</a>
                                </div>
                            @endforelse
                        </div>
                    </section>

                </div>

            </div>

            <div class="properties-pagination" dir="rtl">

                {!! $allAqars->appends(Request::except('page'))->render() !!}

            </div>
        </div>

    </section>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
        function submit_another_form_filter() {

            //	alert("ff");
            form = document.getElementById('selectform');
            //form.target='_blank';
            form.submit();
        }


        /*****************************/

        show_collaps_when_user_add_filter();

        function show_collaps_when_user_add_filter() {
            var queryString = $('#selectform').serializeArray();
            //  console.log(queryString);


            queryString.forEach(element => {
                console.log(element.name)

                if (element.name == "location1" && element.value !== "") {
                    var element = document.getElementById("collapseOne");
                    element.classList.add("show");
                }


                if (element.name == "mzaya[]" && element.value !== "") {
                    var element = document.getElementById("collapseThree");
                    element.classList.add("show");
                }

                if (element.name == "minPrice" && element.value !== "" ||
                    element.name == "minArea" && element.value !== "" ||
                    element.name == "minRooms" && element.value !== "" ||
                    element.name == "minBaths" && element.value !== "") {
                    var element = document.getElementById("collapseTwo");
                    element.classList.add("show");
                }


            });


        }


        /*****************************/

    </script>


    <style>
        #sale-props.modern-properties-page {
            --rc-primary: #123d72;
            --rc-primary-dark: #08284d;
            --rc-primary-soft: #edf4ff;
            --rc-accent: #f3a51f;
            --rc-accent-dark: #d88600;
            --rc-accent-soft: #fff7e7;
            --rc-ink: #17263d;
            --rc-muted: #6f7c90;
            --rc-line: #e3eaf3;
            --rc-surface: #ffffff;
            --rc-page: #f5f8fc;
            --rc-success: #188c65;
            direction: rtl;
            overflow: hidden;
            padding: 34px 0 70px;
            background:
                radial-gradient(circle at 8% 5%, rgba(243, 165, 31, .10), transparent 24%),
                radial-gradient(circle at 92% 14%, rgba(18, 61, 114, .10), transparent 26%),
                var(--rc-page);
            color: var(--rc-ink);
        }

        #sale-props * {
            box-sizing: border-box;
        }

        #sale-props a {
            text-decoration: none;
        }
        .text-white {
            color: #40b991 !important;
        }
        #sale-props .properties-hero {
            position: relative;
            min-height: 300px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 36px;
            overflow: hidden;
            padding: 48px 54px;
            border-radius: 30px;
            background:
                linear-gradient(120deg, rgba(8, 40, 77, .98), rgba(18, 61, 114, .96) 55%, rgba(35, 94, 155, .94)),
                var(--rc-primary);
            box-shadow: 0 24px 58px rgba(8, 40, 77, .22);
            isolation: isolate;
        }

        #sale-props .properties-hero::before,
        #sale-props .properties-hero::after {
            content: "";
            position: absolute;
            z-index: -1;
            border-radius: 50%;
            pointer-events: none;
        }

        #sale-props .properties-hero::before {
            width: 330px;
            height: 330px;
            inset-inline-start: -110px;
            top: -170px;
            border: 52px solid rgba(255, 255, 255, .06);
        }

        #sale-props .properties-hero::after {
            width: 210px;
            height: 210px;
            inset-inline-end: 32%;
            bottom: -150px;
            background: rgba(243, 165, 31, .13);
            filter: blur(2px);
        }

        #sale-props .properties-hero__content {
            position: relative;
            z-index: 2;
            max-width: 760px;
        }

        #sale-props .properties-hero__eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 17px;
            padding: 9px 14px;
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 999px;
            background: rgba(255, 255, 255, .10);
            color: #fff4d8;
            font-size: 14px;
            font-weight: 700;
            backdrop-filter: blur(10px);
        }

        #sale-props .headingTitle2 {
            margin: 0;
            color: #fff;
            font-size: clamp(32px, 4vw, 53px);
            font-weight: 900;
            line-height: 1.24;
            letter-spacing: -.7px;
            text-align: right;
        }

        #sale-props .properties-hero__description {
            max-width: 675px;
            margin: 16px 0 0;
            color: rgba(255, 255, 255, .78);
            font-size: 17px;
            line-height: 1.9;
        }

        #sale-props .properties-hero__stats {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
        }

        #sale-props .properties-hero__stats > span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 42px;
            padding: 9px 14px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .10);
            color: rgba(255, 255, 255, .90);
            font-size: 14px;
            font-weight: 600;
        }

        #sale-props .properties-hero__stats strong {
            color: #fff;
            font-size: 18px;
        }

        #sale-props .properties-hero__stats svg {
            color: var(--rc-accent);
        }

        #sale-props .properties-hero__brand {
            position: relative;
            z-index: 2;
            width: 190px;
            height: 190px;
            flex: 0 0 190px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, .22);
            border-radius: 50%;
            background: linear-gradient(145deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, .05));
            box-shadow: inset 0 0 0 12px rgba(255, 255, 255, .04), 0 20px 45px rgba(0, 0, 0, .18);
            color: #fff;
            backdrop-filter: blur(9px);
        }

        #sale-props .properties-hero__brand::after {
            content: "";
            position: absolute;
            width: 42px;
            height: 7px;
            bottom: 43px;
            border-radius: 20px;
            background: var(--rc-accent);
        }

        #sale-props .properties-hero__brand span {
            font-size: 52px;
            font-weight: 900;
            letter-spacing: -4px;
            line-height: 1;
        }

        #sale-props .properties-hero__brand small {
            margin-top: 8px;
            color: rgba(255, 255, 255, .72);
            font-size: 12px;
            letter-spacing: 1px;
        }

        #sale-props .properties-toolbar {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin: -28px 32px 0;
            padding: 18px 22px;
            border: 1px solid rgba(227, 234, 243, .85);
            border-radius: 20px;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 10px 28px rgba(31, 54, 88, .08);
            backdrop-filter: blur(14px);
        }

        #sale-props .properties-toolbar__intro,
        #sale-props .properties-toolbar__actions {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        #sale-props .properties-toolbar__icon,
        #sale-props .filter-card__heading-icon {
            width: 45px;
            height: 45px;
            flex: 0 0 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .properties-toolbar__intro strong {
            display: block;
            color: var(--rc-ink);
            font-size: 15px;
        }

        #sale-props .properties-toolbar__intro small {
            display: block;
            margin-top: 3px;
            color: var(--rc-muted);
            font-size: 12px;
        }

        #sale-props .properties-wishlist-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 46px;
            padding: 10px 16px;
            border: 1px solid #f3d5d8;
            border-radius: 12px;
            background: #fff6f7;
            color: #c53648;
            font-weight: 700;
            white-space: nowrap;
            transition: .25s ease;
        }

        #sale-props .properties-wishlist-btn:hover {
            border-color: #c53648;
            background: #c53648;
            color: #fff;
            transform: translateY(-2px);
        }

        #sale-props .properties-sort-form {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
        }

        #sale-props .properties-sort-form label {
            margin: 0;
            color: var(--rc-muted);
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        #sale-props .properties-sort-form .sortSelect {
            min-width: 220px;
            height: 46px;
            min-height: 46px;
            margin: 0;
            padding: 0 15px;
            line-height: 44px;
            border: 1px solid var(--rc-line);
            border-radius: 12px;
            background-color: #fff;
            color: var(--rc-ink);
            font-size: 14px;
            font-weight: 600;
            outline: none;
            transition: .2s ease;
        }

        #sale-props .properties-sort-form .sortSelect:focus {
            border-color: var(--rc-primary);
            box-shadow: 0 0 0 4px rgba(18, 61, 114, .10);
        }

        #sale-props .properties-layout {
            align-items: flex-start;
        }

        #sale-props .filter-props {
            align-self: flex-start;
        }

        #sale-props .filter-props > .sticky {
            overflow: hidden;
            margin-bottom: 18px;
            border-radius: 18px;
        }

        #sale-props .filter-card {
            overflow: visible;
            border: 1px solid var(--rc-line);
            border-radius: 22px;
            background: var(--rc-surface);
            box-shadow: 0 8px 24px rgba(31, 54, 88, .07);
        }

        #sale-props .filter-card > .card-body {
            padding: 22px;
        }

        #sale-props .filter-card__heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--rc-line);
        }

        #sale-props .filter-card__heading h2 {
            margin: 0;
            color: var(--rc-ink);
            font-size: 18px;
            font-weight: 900;
        }

        #sale-props .filter-card__heading p {
            margin: 4px 0 0;
            color: var(--rc-muted);
            font-size: 12px;
        }

        #sale-props .filter-card .form-control,
        #sale-props .filter-card .myselect {
            width: 100%;
            height: 46px;
            min-height: 46px;
            margin-bottom: 0;
            padding: 0 13px;
            border: 1px solid var(--rc-line);
            border-radius: 11px;
            background-color: #fbfcfe;
            color: var(--rc-ink);
            font-family: inherit;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.35;
            outline: none;
            vertical-align: middle;
            transition: .2s ease;
        }

        /* تثبيت ارتفاع ومحاذاة القوائم الأصلية في كل المتصفحات */
        #sale-props .filter-card select.myselect,
        #sale-props .filter-card select.form-control,
        #sale-props .properties-sort-form select.sortSelect {
            height: 46px !important;
            min-height: 46px !important;
            padding-top: 0 !important;
            padding-bottom: 0 !important;
            line-height: 44px !important;
            font-family: inherit !important;
            vertical-align: middle;
        }

        #sale-props .filter-card input.myselect,
        #sale-props .filter-card input.form-control {
            line-height: 44px;
        }

        #sale-props .filter-card select.myselect option,
        #sale-props .properties-sort-form select.sortSelect option {
            color: var(--rc-ink);
            background: #fff;
            font-family: inherit;
            line-height: 1.6;
        }

        #sale-props .filter-card .form-control::placeholder,
        #sale-props .filter-card .myselect::placeholder {
            color: #98a4b5;
        }

        #sale-props .filter-card .form-control:focus,
        #sale-props .filter-card .myselect:focus {
            border-color: var(--rc-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(18, 61, 114, .08);
        }

        #sale-props .filter-card .form-group {
            margin-bottom: 16px;
        }

        #sale-props .filter-card label {
            margin-bottom: 7px;
            color: #34445b;
            font-size: 13px;
            font-weight: 700;
        }

        #sale-props .filter-card .accordion,
        #sale-props .filter-card .accordion-item {
            border: 0;
            background: transparent;
        }

        #sale-props .filter-card .accordion-item {
            overflow: hidden;
            margin-top: 12px;
            border: 1px solid var(--rc-line);
            border-radius: 13px;
            background: #fff;
        }

        #sale-props .filter-card .accordion-button {
            min-height: 52px;
            padding: 13px 15px;
            border: 0;
            background: #f9fbfe;
            color: var(--rc-ink);
            box-shadow: none;
        }

        #sale-props .filter-card .accordion-button:not(.collapsed) {
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .filter-card .accordion-button h5 {
            margin: 0;
            font-size: 14px;
            font-weight: 800;
        }

        #sale-props .filter-card .accordion-button::after {
            margin-right: auto;
            margin-left: 0;
        }

        #sale-props .filter-card .accordion-collapse > div,
        #sale-props .filter-card .accordion-collapse fieldset {
            padding: 0 12px 13px;
        }

        #sale-props .filter-card .optional {
            display: inline-flex;
            margin-right: 5px;
            padding: 3px 7px;
            border-radius: 999px;
            background: var(--rc-accent-soft);
            color: var(--rc-accent-dark);
            font-size: 9px;
            font-weight: 800;
        }

        #sale-props .filter-card .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 8px 0;
            padding: 9px 11px;
            border: 1px solid transparent;
            border-radius: 9px;
            background: #f8fafc;
            transition: .2s ease;
        }

        #sale-props .filter-card .form-check:hover {
            border-color: #cfdded;
            background: var(--rc-primary-soft);
        }

        #sale-props .filter-card .form-check-input {
            float: none;
            flex: 0 0 auto;
            margin: 0;
            accent-color: var(--rc-primary);
        }

        #sale-props .filter-card .form-check-label {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }

        #sale-props .submit-btns {
            display: grid;
            grid-template-columns: 1fr 1.35fr;
            gap: 10px;
            margin-top: 20px;
        }

        #sale-props .submit-btns .btn {
            min-height: 47px;
            border-radius: 11px;
            font-weight: 800;
            transition: .25s ease;
        }

        #sale-props .submit-btns .btn-light {
            border: 1px solid var(--rc-line);
            background: #fff;
            color: var(--rc-muted);
        }

        #sale-props .submit-btns .our-btn {
            border: 1px solid var(--rc-primary);
            background: linear-gradient(135deg, var(--rc-primary), #245f9d);
            color: #fff;
            box-shadow: 0 10px 22px rgba(18, 61, 114, .20);
        }

        #sale-props .submit-btns .btn:hover {
            transform: translateY(-2px);
        }

        #sale-props .autocomplete-wrapper {
            position: relative;
            width: 100%;
        }

        #sale-props .autocomplete-wrapper input[type="text"] {
            width: 100%;
        }

        #sale-props .autocomplete-dropdown {
            position: absolute;
            z-index: 9999;
            top: calc(100% + 5px);
            right: 0;
            left: 0;
            display: none;
            overflow-y: auto;
            max-height: 230px;
            border: 1px solid var(--rc-line);
            border-radius: 11px;
            background: #fff;
            box-shadow: 0 10px 24px rgba(31, 54, 88, .12);
        }

        #sale-props .autocomplete-dropdown.open {
            display: block;
        }

        #sale-props .autocomplete-item {
            padding: 10px 13px;
            color: var(--rc-ink);
            cursor: pointer;
            direction: rtl;
            font-size: 13px;
            text-align: right;
        }

        #sale-props .autocomplete-item + .autocomplete-item {
            border-top: 1px solid #f0f3f7;
        }

        #sale-props .autocomplete-item:hover,
        #sale-props .autocomplete-item.highlighted {
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .col-cards-2 > .row {
            margin-top: -12px;
        }

        #sale-props .vip-slide {
            margin: 0 -8px 18px;
        }

        #sale-props .vip-slide .single-items {
            padding: 12px 8px;
        }

        #sale-props .vip-property-card {
            position: relative;
            overflow: hidden;
            min-height: 410px;
            border: 0;
            border-radius: 22px;
            background: var(--rc-primary-dark);
            box-shadow: 0 9px 24px rgba(8, 40, 77, .14);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        #sale-props .vip-property-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 32px rgba(8, 40, 77, .18);
        }

        #sale-props .vip-property-card > .card-img,
        #sale-props .vip-property-card > .main-img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .55s ease;
        }

        #sale-props .vip-property-card:hover > .card-img,
        #sale-props .vip-property-card:hover > .main-img {
            transform: scale(1.055);
        }

        #sale-props .vip-property-card .card-img-overlay {
            padding: 24px;
            background: linear-gradient(
                to top,
                rgba(5, 25, 48, .94) 0%,
                rgba(5, 25, 48, .72) 34%,
                rgba(5, 25, 48, .18) 66%,
                rgba(5, 25, 48, 0) 100%
            );
        }

        #sale-props .vip-property-card .card-title {
            margin-bottom: 9px;
            color: #fff;
            font-size: 20px;
            font-weight: 900;
            line-height: 1.55;
        }

        #sale-props .vip-property-card .card-text h6 {
            display: inline-flex;
            margin: 0 0 12px;
            padding: 7px 11px;
            border-radius: 9px;
            background: rgba(243, 165, 31, .17);
            color: #ffd98f;
            font-size: 16px;
            font-weight: 900;
        }

        #sale-props .vip-property-card .list-fx-features,
        #sale-props .list-fx-features2 {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        #sale-props .vip-property-card .listing-card-info-icon {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 10px;
            border: 1px solid rgba(255, 255, 255, .15);
            border-radius: 9px;
            background: rgba(255, 255, 255, .08);
            font-size: 12px;
        }

        #sale-props .vip-property-card .foot-location2 {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 12px;
            color: rgba(255, 255, 255, .82) !important;
            font-size: 13px;
        }

        #sale-props .vip-property-card .footer-flex {
            gap: 9px;
        }

        #sale-props .vip-property-card .footer-flex .btn {
            min-width: 88px;
            border: 0;
            border-radius: 10px;
            font-weight: 800;
        }

        #sale-props .vip-property-card .footer-flex .btn-success {
            background: var(--rc-accent);
            color: var(--rc-primary-dark);
        }

        #sale-props .vip-property-card .footer-flex .btn-light {
            background: rgba(255, 255, 255, .14);
            color: #fff;
        }

        #sale-props .property-list-card {
            overflow: hidden;
            border: 1px solid var(--rc-line);
            border-radius: 22px;
            background: var(--rc-surface);
            box-shadow: 0 7px 22px rgba(31, 54, 88, .07);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        #sale-props .property-list-card:hover {
            border-color: #cedbeb;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(31, 54, 88, .11);
        }

        #sale-props .featured-property-card {
            border: 1px solid rgba(243, 165, 31, .65);
            box-shadow: 0 8px 24px rgba(216, 134, 0, .10);
        }

        #sale-props .property-list-card > .row {
            min-height: 270px;
            margin: 0;
            direction: ltr;
        }

        #sale-props .property-list-card .col-card-imgs,
        #sale-props .property-list-card .col-card-details {
            padding: 0;
        }

        #sale-props .property-list-card .col-card-imgs {
            position: relative;
            overflow: hidden;
            min-height: 270px;
            background: #e8eef6;
        }

        #sale-props .property-list-card .click,
        #sale-props .property-list-card .click > div,
        #sale-props .property-list-card .click a {
            display: block;
            width: 100%;
            height: 100%;
        }

        #sale-props .property-list-card .col-card-imgs img {
            width: 100%;
            height: 100%;
            min-height: 270px;
            object-fit: cover;
            transition: transform .55s ease;
        }

        #sale-props .property-list-card .col-card-imgs,
        #sale-props .property-list-card .click,
        #sale-props .property-list-card .click > div,
        #sale-props .property-list-card .click a,
        #sale-props .property-list-card .col-card-imgs img,
        #sale-props .vip-property-card > .card-img,
        #sale-props .vip-property-card > .main-img {
            box-shadow: none !important;
            filter: none !important;
        }

        #sale-props .property-list-card:hover .col-card-imgs img {
            transform: scale(1.055);
        }

        #sale-props .property-list-card .col-card-details {
            direction: rtl;
        }

        #sale-props .property-list-card .card-body {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 27px 28px;
        }

        #sale-props .property-list-card .listing-detail-wrapper {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid var(--rc-line);
        }

        #sale-props .property-list-card .listing-name {
            margin: 0;
            font-size: 21px;
            font-weight: 900;
            line-height: 1.55;
        }

        #sale-props .property-list-card .listing-name a {
            color: var(--rc-ink);
            transition: color .2s ease;
        }

        #sale-props .property-list-card .listing-name a:hover {
            color: var(--rc-primary);
        }

        #sale-props .property-list-card .listing-card-info-price2 {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 10px 13px;
            border-radius: 11px;
            background: var(--rc-accent-soft);
            color: var(--rc-accent-dark);
            font-size: 15px;
            font-weight: 900;
            white-space: nowrap;
        }

        #sale-props .property-list-card .list-rap {
            padding: 20px 0;
        }

        #sale-props .property-list-card .listing-card-info-icon {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 8px 11px;
            border: 1px solid #e7edf5;
            border-radius: 10px;
            background: #f8fafc;
            color: #485a72;
            font-size: 13px;
            font-weight: 700;
        }

        #sale-props .inc-fleat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        #sale-props .property-list-card .listing-detail-footer {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 9px;
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid var(--rc-line);
        }

        #sale-props .property-list-card .footer-first {
            flex: 1 1 170px;
            min-width: 0;
        }

        #sale-props .property-list-card .foot-location {
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--rc-muted);
            font-size: 13px;
            font-weight: 700;
        }

        #sale-props .property-list-card .listing-detail-footer .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 42px;
            margin: 0 !important;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 800;
            transition: .22s ease;
        }

        #sale-props .property-list-card .addToCart {
            border: 1px solid #f0d7da;
            background: #fff7f8;
            color: #c53648;
        }

        #sale-props .property-list-card .btn-compare-toggle {
            border: 1px solid #cfe0f3;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .property-list-card .property-view-btn,
        #sale-props .property-list-card #btn1 {
            border: 1px solid var(--rc-primary);
            background: linear-gradient(135deg, var(--rc-primary), #245f9d);
            color: #fff;
            box-shadow: 0 8px 18px rgba(18, 61, 114, .18);
        }

        #sale-props .property-list-card .listing-detail-footer .btn:hover {
            transform: translateY(-2px);
        }

        #sale-props .views,
        #sale-props .views-2,
        #sale-props .views-3 {
            position: absolute;
            z-index: 4;
        }

        #sale-props .views {
            top: 14px;
            right: 14px;
        }

        #sale-props .views-1,
        #sale-props .viewsRed {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 31px;
            padding: 6px 11px;
            border-radius: 9px;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(0, 0, 0, .14);
        }

        #sale-props .views-1 {
            background: linear-gradient(135deg, var(--rc-accent), #ef8c16) !important;
            color: var(--rc-primary-dark) !important;
        }

        #sale-props .viewsRed {
            background: #b93444;
        }

        #sale-props .views-2,
        #sale-props .views-3,
        #sale-props .property-views-badge {
            position: absolute !important;
            z-index: 6 !important;
            top: 14px !important;
            right: auto !important;
            bottom: auto !important;
            left: 14px !important;
            width: auto !important;
            min-width: 58px;
            max-width: calc(100% - 28px);
            height: 32px !important;
            min-height: 32px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 6px;
            margin: 0 !important;
            padding: 0 11px !important;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 999px !important;
            background: rgba(8, 40, 77, .84) !important;
            box-shadow: 0 4px 12px rgba(8, 40, 77, .16) !important;
            color: #fff !important;
            direction: ltr;
            font-size: 12px !important;
            font-weight: 800 !important;
            line-height: 1 !important;
            white-space: nowrap;
            backdrop-filter: blur(6px);
        }

        #sale-props .property-views-badge i {
            width: 13px;
            flex: 0 0 13px;
            margin: 0 !important;
            font-size: 12px;
            line-height: 1;
            text-align: center;
        }

        #sale-props .property-views-badge span {
            display: inline-block;
            width: auto !important;
            margin: 0 !important;
            padding: 0 !important;
            color: inherit !important;
            font: inherit !important;
            line-height: 1 !important;
        }

        #sale-props .properties-pagination {
            display: flex;
            justify-content: center;
            margin-top: 34px;
        }

        #sale-props .properties-pagination .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin: 0;
        }

        #sale-props .properties-pagination .page-item .page-link {
            min-width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--rc-line);
            border-radius: 10px !important;
            background: #fff;
            color: var(--rc-primary);
            font-weight: 800;
            box-shadow: 0 7px 16px rgba(31, 54, 88, .06);
        }

        #sale-props .properties-pagination .page-item.active .page-link {
            border-color: var(--rc-primary);
            background: var(--rc-primary);
            color: #fff;
        }

        #sale-props .properties-pagination .page-item.disabled .page-link {
            opacity: .5;
        }

        @media (min-width: 992px) {
            #sale-props .filter-card {
                position: sticky;
                top: 88px;
            }
        }

        @media (max-width: 1199.98px) {
            #sale-props .properties-hero {
                padding: 42px;
            }

            #sale-props .properties-hero__brand {
                width: 160px;
                height: 160px;
                flex-basis: 160px;
            }

            #sale-props .properties-toolbar {
                margin-right: 20px;
                margin-left: 20px;
            }

            #sale-props .properties-toolbar__intro small {
                display: none;
            }

            #sale-props .property-list-card .listing-detail-wrapper {
                display: block;
            }

            #sale-props .property-list-card .listing-short-detail-flex {
                margin-top: 12px;
            }
        }

        @media (max-width: 991.98px) {
            #sale-props.modern-properties-page {
                padding-top: 20px;
            }

            #sale-props .properties-hero {
                min-height: auto;
                padding: 38px 30px 70px;
            }

            #sale-props .properties-hero__brand {
                width: 125px;
                height: 125px;
                flex-basis: 125px;
            }

            #sale-props .properties-hero__brand span {
                font-size: 40px;
            }

            #sale-props .properties-hero__brand::after {
                bottom: 29px;
            }

            #sale-props .properties-toolbar {
                align-items: stretch;
                flex-direction: column;
                margin-top: -38px;
            }

            #sale-props .properties-toolbar__actions {
                justify-content: space-between;
            }

            #sale-props .properties-sort-form {
                flex: 1;
            }

            #sale-props .properties-sort-form .sortSelect {
                flex: 1;
                min-width: 0;
            }

            #sale-props .filter-props {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 767.98px) {
            #sale-props.modern-properties-page {
                padding-bottom: 45px;
            }

            #sale-props .container {
                padding-right: 14px;
                padding-left: 14px;
            }

            #sale-props .properties-hero {
                display: block;
                padding: 32px 23px 66px;
                border-radius: 22px;
            }

            #sale-props .properties-hero__brand {
                position: absolute;
                top: 20px;
                left: 18px;
                width: 84px;
                height: 84px;
                opacity: .35;
            }

            #sale-props .properties-hero__brand span {
                font-size: 30px;
            }

            #sale-props .properties-hero__brand small,
            #sale-props .properties-hero__brand::after {
                display: none;
            }

            #sale-props .headingTitle2 {
                padding-left: 70px;
                font-size: 32px;
            }

            #sale-props .properties-hero__description {
                font-size: 15px;
            }

            #sale-props .properties-hero__stats {
                display: grid;
                grid-template-columns: 1fr;
            }

            #sale-props .properties-toolbar {
                margin-right: 10px;
                margin-left: 10px;
                padding: 16px;
                border-radius: 16px;
            }

            #sale-props .properties-toolbar__intro {
                align-items: flex-start;
            }

            #sale-props .properties-toolbar__actions {
                align-items: stretch;
                flex-direction: column;
            }

            #sale-props .properties-wishlist-btn {
                width: 100%;
            }

            #sale-props .properties-sort-form {
                align-items: stretch;
                flex-direction: column;
                gap: 6px;
            }

            #sale-props .properties-sort-form .sortSelect {
                width: 100%;
            }

            #sale-props .filter-card > .card-body {
                padding: 18px;
            }

            #sale-props .property-list-card > .row {
                display: block;
            }

            #sale-props .property-list-card .col-card-imgs {
                min-height: 230px;
            }

            #sale-props .property-list-card .col-card-imgs img {
                min-height: 230px;
                max-height: 230px;
            }

            #sale-props .property-list-card .card-body {
                padding: 22px 19px;
            }

            #sale-props .property-list-card .listing-name {
                font-size: 18px;
            }

            #sale-props .property-list-card .listing-detail-footer {
                align-items: stretch;
            }

            #sale-props .property-list-card .footer-first {
                flex-basis: 100%;
                margin-bottom: 3px;
            }

            #sale-props .property-list-card .listing-detail-footer .btn {
                flex: 1 1 auto;
            }
        }

        @media (max-width: 420px) {
            #sale-props .headingTitle2 {
                padding-left: 0;
                font-size: 28px;
            }

            #sale-props .properties-hero__brand {
                display: none;
            }

            #sale-props .properties-hero__eyebrow {
                font-size: 12px;
            }

            #sale-props .submit-btns {
                grid-template-columns: 1fr;
            }

            #sale-props .property-list-card .listing-detail-footer .btn {
                flex-basis: calc(50% - 6px);
            }
        }

        /* ─────────────────────────────────────────────────────────────
         * Results cards — RTL-first, responsive and isolated
         * ───────────────────────────────────────────────────────────── */
        #sale-props .rc-results-column {
            direction: rtl;
        }

        #sale-props .rc-featured-properties,
        #sale-props .rc-all-properties {
            margin-bottom: 2px;
        }

        #sale-props .rc-results-heading {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 12px;
            padding: 0 3px;
        }

        #sale-props .rc-results-heading__title {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        #sale-props .rc-results-heading__icon {
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 14px;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .rc-results-heading--featured .rc-results-heading__icon {
            background: linear-gradient(135deg, #fff4d5, #ffe1a0);
            color: #b86b00;
            box-shadow: inset 0 0 0 1px rgba(216, 134, 0, .16);
        }

        #sale-props .rc-results-heading__eyebrow {
            display: block;
            margin-bottom: 2px;
            color: var(--rc-muted);
            font-size: 11px;
            font-weight: 800;
        }

        #sale-props .rc-results-heading--featured .rc-results-heading__eyebrow {
            color: #b86b00;
        }

        #sale-props .rc-results-heading h2 {
            margin: 0;
            color: var(--rc-ink);
            font-size: 19px;
            font-weight: 900;
            line-height: 1.35;
        }

        #sale-props .rc-results-heading p {
            max-width: 430px;
            margin: 0;
            color: var(--rc-muted);
            font-size: 12px;
            font-weight: 600;
            line-height: 1.75;
            text-align: left;
        }

        #sale-props .rc-featured-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        #sale-props .rc-properties-stack {
            display: grid;
            gap: 14px;
        }

        #sale-props .rc-property-card {
            position: relative;
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--rc-line);
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 9px 28px rgba(31, 54, 88, .075);
            direction: rtl;
            animation: rc-property-card-enter .5s ease both;
            transition: transform .28s ease, border-color .28s ease, box-shadow .28s ease;
        }

        #sale-props .rc-property-card:hover {
            border-color: #c7d7ea;
            transform: translateY(-4px);
            box-shadow: 0 18px 42px rgba(31, 54, 88, .13);
        }

        #sale-props .rc-property-card--featured {
            border-color: rgba(226, 145, 16, .55);
            background:
                linear-gradient(145deg, rgba(255, 249, 235, .92), #fff 42%),
                #fff;
            box-shadow: 0 12px 34px rgba(188, 112, 0, .13);
        }

        #sale-props .rc-property-card--featured::before,
        #sale-props .rc-property-card--inline-featured::before {
            content: "";
            position: absolute;
            z-index: 7;
            top: 0;
            right: 0;
            left: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffca55, #e28b10, #ffe19a);
        }

        #sale-props .rc-property-card--list {
            display: grid;
            grid-template-columns: minmax(190px, 30%) minmax(0, 1fr);
            min-height: 230px;
        }

        #sale-props .rc-property-card--inline-featured {
            border-color: rgba(226, 145, 16, .48);
            background: linear-gradient(100deg, #fffdf7, #fff);
        }

        #sale-props .rc-property-card__media {
            position: relative;
            height: 128px;
            min-height: 128px;
            overflow: hidden;
            background: linear-gradient(145deg, #edf3fa, #f7f9fc);
        }

        #sale-props .rc-property-card--list .rc-property-card__media {
            height: 230px;
            min-height: 230px;
        }

        #sale-props .rc-property-card__media > a {
            display: block;
            width: 100%;
            height: 100%;
        }

        #sale-props .rc-property-card__image {
            width: 100%;
            height: 100%;
            min-height: inherit;
            display: block;
            object-fit: cover;
            box-shadow: none !important;
            filter: none !important;
            transition: transform .55s ease;
        }

        #sale-props .rc-property-card__image--placeholder {
            padding: 18px;
            object-fit: contain;
            background:
                radial-gradient(circle at 20% 20%, rgba(243, 165, 31, .14), transparent 34%),
                linear-gradient(145deg, #f3f7fc, #fff);
        }

        #sale-props .rc-property-card:hover .rc-property-card__image {
            transform: scale(1.045);
        }

        #sale-props .rc-property-card:hover .rc-property-card__image--placeholder {
            transform: scale(1.025);
        }

        #sale-props .rc-property-card__badges {
            position: absolute;
            z-index: 3;
            top: 9px;
            right: 9px;
            left: 9px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 7px;
            pointer-events: none;
        }

        #sale-props .rc-property-badge {
            min-height: 26px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 5px 8px;
            border: 1px solid rgba(255, 255, 255, .50);
            border-radius: 999px;
            background: rgba(255, 255, 255, .93);
            color: var(--rc-primary-dark);
            box-shadow: 0 7px 18px rgba(8, 40, 77, .13);
            font-size: 11px;
            font-weight: 900;
            line-height: 1;
            backdrop-filter: blur(9px);
        }

        #sale-props .rc-property-badge--featured {
            border-color: rgba(255, 226, 157, .72);
            background: linear-gradient(135deg, #ffcc5b, #e99017);
            color: #412800;
        }

        #sale-props .rc-property-badge--offer {
            color: var(--rc-primary);
        }

        #sale-props .rc-property-badge--finance {
            background: rgba(21, 139, 97, .93);
            color: #fff;
        }

        #sale-props .rc-property-badge--unavailable {
            background: rgba(185, 52, 68, .94);
            color: #fff;
        }

        #sale-props .rc-property-card__views {
            position: absolute;
            z-index: 3;
            bottom: 8px;
            left: 8px;
            min-width: 52px;
            height: 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 0 10px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 999px;
            background: rgba(8, 40, 77, .82);
            color: #fff;
            box-shadow: 0 6px 15px rgba(8, 40, 77, .18);
            direction: ltr;
            font-size: 11px;
            font-weight: 800;
            backdrop-filter: blur(8px);
        }

        #sale-props .rc-property-card__content {
            min-width: 0;
            display: flex;
            flex-direction: column;
            padding: 13px 14px 14px;
        }

        #sale-props .rc-property-card--list .rc-property-card__content {
            padding: 15px 18px;
        }

        #sale-props .rc-property-card__reference {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 4px;
            color: var(--rc-muted);
            font-size: 10px;
            font-weight: 800;
        }

        #sale-props .rc-property-card__reference > span {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #sale-props .rc-property-card__reference small {
            flex: 0 0 auto;
            color: #9aa6b6;
            direction: ltr;
        }

        #sale-props .rc-property-card__title {
            min-height: 47px;
            margin: 0 0 7px;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.45;
        }

        #sale-props .rc-property-card__title a {
            text-align: right;
            display: -webkit-box;
            overflow: hidden;
            color: var(--rc-ink);
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            transition: color .2s ease;
        }

        #sale-props .rc-property-card__title a:hover {
            color: var(--rc-primary);
        }

        #sale-props .rc-property-card__price {
            display: flex;
            align-items: baseline;
            flex-wrap: wrap;
            gap: 5px;
            margin-bottom: 8px;
            color:  #40b991;
        }

        #sale-props .rc-property-card__price > span {
            color: var(--rc-muted);
            font-size: 11px;
            font-weight: 700;
        }

        #sale-props .rc-property-card__price strong {
            font-size: 20px;
            font-weight: 900;
            line-height: 1.1;
            direction: ltr;
        }

        #sale-props .rc-property-card__price small {
            color: #9a6a17;
            font-size: 11px;
            font-weight: 800;
        }

        #sale-props .rc-property-card__price-contact {
            font-size: 17px !important;
        }

        #sale-props .rc-property-card__meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 5px;
            margin-bottom: 9px;
        }

        #sale-props .rc-property-card__meta > div {
            min-width: 0;
            display: grid;
            grid-template-columns: 24px minmax(0, 1fr);
            grid-template-rows: auto auto;
            column-gap: 5px;
            padding: 6px;
            border: 1px solid #e7edf5;
            border-radius: 11px;
            background: #f8fafc;
        }

        #sale-props .rc-property-card__meta-icon {
            grid-row: 1 / 3;
            width: 24px;
            height: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            align-self: center;
            border-radius: 8px;
            background: var(--rc-primary-soft);
        }

        #sale-props .rc-property-card__meta-icon img {
            width: 15px;
            height: 15px;
            object-fit: contain;
        }

        #sale-props .rc-property-card__meta small,
        #sale-props .rc-property-card__meta strong {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #sale-props .rc-property-card__meta small {
            color: var(--rc-muted);
            font-size: 9px;
            font-weight: 700;
        }

        #sale-props .rc-property-card__meta strong {
            color: #40536b;
            font-size: 11px;
            font-weight: 900;
        }

        #sale-props .rc-property-card__footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: auto;
            padding-top: 9px;
            border-top: 1px solid var(--rc-line);
        }

        #sale-props .rc-property-card__location {
            min-width: 0;
            flex: 1 1 130px;
            display: flex;
            align-items: center;
            gap: 5px;
            color: var(--rc-muted);
            font-size: 11px;
            font-weight: 800;
        }

        #sale-props .rc-property-card__location > span:last-child {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #sale-props .rc-property-card__location-icon {
            width: 27px;
            height: 27px;
            flex: 0 0 27px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .rc-property-card__actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        #sale-props .rc-property-action {
            min-height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin: 0 !important;
            padding: 6px 8px;
            border-radius: 9px;
            font-size: 10px;
            font-weight: 900;
            line-height: 1.1;
            box-shadow: none;
            transition: transform .2s ease, color .2s ease, background .2s ease, border-color .2s ease;
        }

        #sale-props .rc-property-action:hover {
            transform: translateY(-2px);
        }

        #sale-props .rc-property-action--save {
            border: 1px solid #f0d7da;
            background: #fff7f8;
            color: #c53648;
        }

        #sale-props .rc-property-action--save:hover {
            border-color: #c53648;
            background: #c53648;
            color: #fff;
        }

        #sale-props .rc-property-action--compare {
            border: 1px solid #cfe0f3;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .rc-property-action--compare:hover,
        #sale-props .rc-property-action--compare.is-selected {
            border-color: var(--rc-primary);
            background: var(--rc-primary);
            color: #fff;
        }

        #sale-props .rc-property-action--primary {
            border: 1px solid var(--rc-primary);
            background: linear-gradient(135deg, var(--rc-primary), #245f9d);
            color: #fff;
            box-shadow: 0 8px 18px rgba(18, 61, 114, .16);
        }

        #sale-props .rc-property-card--featured .rc-property-action--primary {
            border-color: #d88600;
            background: linear-gradient(135deg, #f3a51f, #e58a0c);
            color: #2e2108;
            box-shadow: 0 8px 18px rgba(216, 134, 0, .18);
        }

        #sale-props .rc-properties-empty {
            padding: 55px 24px;
            border: 1px dashed #cbd7e5;
            border-radius: 22px;
            background: rgba(255, 255, 255, .72);
            text-align: center;
        }

        #sale-props .rc-properties-empty__icon {
            width: 70px;
            height: 70px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            border-radius: 20px;
            background: var(--rc-primary-soft);
            color: var(--rc-primary);
        }

        #sale-props .rc-properties-empty h3 {
            margin: 0 0 8px;
            color: var(--rc-ink);
            font-size: 20px;
            font-weight: 900;
        }

        #sale-props .rc-properties-empty p {
            margin: 0 auto 18px;
            color: var(--rc-muted);
            font-size: 13px;
        }

        #sale-props .rc-properties-empty .btn {
            min-height: 42px;
            padding: 9px 17px;
            border-radius: 11px;
            background: var(--rc-primary);
            color: #fff;
            font-weight: 800;
        }

        @keyframes rc-property-card-enter {
            from {
                opacity: 0;
                transform: translateY(14px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 1200px) {
            #sale-props .rc-property-card--featured .rc-property-card__footer,
            #sale-props .rc-property-card--featured .rc-property-card__actions {
                flex-wrap: nowrap;
            }

            #sale-props .rc-property-card--featured .rc-property-card__location {
                flex: 0 0 27px;
            }

            #sale-props .rc-property-card--featured .rc-property-card__location > span:last-child {
                display: none;
            }
        }

        @media (max-width: 1199.98px) {
            #sale-props .rc-featured-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            #sale-props .rc-property-card--list {
                grid-template-columns: minmax(200px, 32%) minmax(0, 1fr);
            }

            #sale-props .rc-property-card--list .rc-property-card__content {
                padding: 15px 17px;
            }

            #sale-props .rc-property-card__footer {
                align-items: stretch;
            }

            #sale-props .rc-property-card__actions {
                flex: 1 1 100%;
            }
        }

        @media (max-width: 991.98px) {
            #sale-props .rc-results-column {
                margin-top: 8px;
            }
        }

        @media (max-width: 767.98px) {
            #sale-props .rc-results-heading {
                align-items: flex-start;
                flex-direction: column;
                gap: 9px;
            }

            #sale-props .rc-results-heading p {
                max-width: none;
                padding-right: 58px;
                text-align: right;
            }

            #sale-props .rc-featured-grid {
                grid-template-columns: 1fr;
            }

            #sale-props .rc-property-card--list {
                display: block;
                min-height: 0;
            }

            #sale-props .rc-property-card--list .rc-property-card__media {
                min-height: 190px;
                height: 190px;
            }

            #sale-props .rc-property-card__content,
            #sale-props .rc-property-card--list .rc-property-card__content {
                padding: 16px 15px;
            }

            #sale-props .rc-property-card__title {
                font-size: 16px;
            }

            #sale-props .rc-property-card__footer {
                display: block;
            }

            #sale-props .rc-property-card__location {
                margin-bottom: 13px;
            }

            #sale-props .rc-property-card__actions {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            #sale-props .rc-property-action--primary {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 420px) {
            #sale-props .rc-results-heading h2 {
                font-size: 18px;
            }

            #sale-props .rc-results-heading p {
                padding-right: 0;
            }

            #sale-props .rc-property-card {
                border-radius: 18px;
            }

            #sale-props .rc-property-card__meta {
                gap: 5px;
            }

            #sale-props .rc-property-card__meta > div {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 3px;
                padding: 8px 4px;
                text-align: center;
            }

            #sale-props .rc-property-card__meta-icon {
                width: 26px;
                height: 26px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #sale-props .rc-property-card,
            #sale-props .rc-property-card__image,
            #sale-props .rc-property-action {
                animation: none;
                transition: none;
            }
        }

    </style>

    <script>
        (function () {

            // تطبيع النص العربي للبحث الذكي
            function normalizeAr(str) {
                return (str || '').toString()
                    .replace(/[أإآٱ]/g, 'ا')
                    .replace(/ة/g, 'ه')
                    .replace(/ى/g, 'ي')
                    .replace(/ؤ/g, 'و')
                    .replace(/ئ/g, 'ي')
                    .replace(/[َُِّْٰـًٌٍ]/g, '')
                    .replace(/\s+/g, ' ')
                    .trim()
                    .toLowerCase();
            }

            /**
             * initAutocomplete – يعمل على العناصر الحية (live DOM) دائماً
             * لذا يعمل صح حتى بعد إضافة عناصر جديدة بالـ AJAX
             */
            function initAutocomplete(textId, hiddenId, dropdownId, onSelect) {
                var textInput = document.getElementById(textId);
                var hiddenInput = document.getElementById(hiddenId);
                var dropdown = document.getElementById(dropdownId);
                if (!textInput || !hiddenInput || !dropdown) return;

                // --- helpers that always read live items ---
                function getLiveItems() {
                    return Array.from(dropdown.querySelectorAll('.autocomplete-item'));
                }

                function showAll() {
                    getLiveItems().forEach(function (item) {
                        item.style.display = '';
                    });
                    dropdown.classList.add('open');
                }

                function filterItems(q) {
                    var query = normalizeAr(q);
                    var hasVisible = false;
                    getLiveItems().forEach(function (item) {
                        var label = normalizeAr(item.getAttribute('data-label'));
                        var match = query === '' || label.indexOf(query) !== -1;
                        item.style.display = match ? '' : 'none';
                        if (match) hasVisible = true;
                    });
                    // أظهر رسالة "لا توجد نتائج" لو مفيش
                    var noRes = dropdown.querySelector('.ac-no-results');
                    if (!hasVisible && query !== '') {
                        if (!noRes) {
                            var d = document.createElement('div');
                            d.className = 'ac-no-results';
                            d.style.cssText = 'padding:8px 12px;color:#999;font-size:13px;';
                            d.textContent = 'لا توجد نتائج';
                            dropdown.appendChild(d);
                        }
                        dropdown.classList.add('open');
                    } else {
                        if (noRes) noRes.remove();
                        if (hasVisible) dropdown.classList.add('open');
                        else dropdown.classList.remove('open');
                    }
                }

                // --- فتح عند focus ---
                textInput.addEventListener('focus', function () {
                    showAll();
                });

                // --- فلترة عند الكتابة ---
                textInput.addEventListener('input', function () {
                    hiddenInput.value = '';
                    filterItems(this.value);
                });

                // --- event delegation للـ click (يعمل مع العناصر الجديدة تلقائياً) ---
                dropdown.addEventListener('click', function (e) {
                    var item = e.target.closest('.autocomplete-item');
                    if (!item) return;
                    var val = item.getAttribute('data-value');
                    var label = item.getAttribute('data-label');
                    textInput.value = label;
                    hiddenInput.value = val;
                    dropdown.classList.remove('open');
                    if (typeof onSelect === 'function') onSelect(val, label);
                });

                // --- إغلاق عند الضغط خارج ---
                document.addEventListener('click', function (e) {
                    if (!textInput.contains(e.target) && !dropdown.contains(e.target)) {
                        dropdown.classList.remove('open');
                    }
                });
            }

            // ============ location1 ============
            initAutocomplete('location1-text', 'location1', 'dropdown-location1', function (val) {
                var loc2Text = document.getElementById('location2-text');
                var loc2Hidden = document.getElementById('location2');
                var loc2Dropdown = document.getElementById('dropdown-location2');

                // مسح location2
                loc2Text.value = '';
                loc2Hidden.value = '';

                // أظهر "جاري التحميل"
                loc2Dropdown.innerHTML = '<div class="ac-loading" style="padding:10px 12px;color:#555;font-size:13px;"><span>&#9696;</span> جاري التحميل...</div>';
                loc2Dropdown.classList.add('open');

                if (!val) {
                    loc2Dropdown.innerHTML = '';
                    loc2Dropdown.classList.remove('open');
                    return;
                }

                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {country_id: val, _token: '{{ csrf_token() }}'},
                    dataType: 'json',
                    success: function (result) {
                        loc2Dropdown.innerHTML = '';
                        if (result.states && result.states.length > 0) {
                            result.states.forEach(function (s) {
                                var div = document.createElement('div');
                                div.className = 'autocomplete-item';
                                div.setAttribute('data-value', s.id);
                                div.setAttribute('data-label', s.district);
                                div.textContent = s.district;
                                loc2Dropdown.appendChild(div);
                            });
                            loc2Dropdown.classList.add('open');
                        } else {
                            loc2Dropdown.innerHTML = '<div style="padding:8px 12px;color:#999;font-size:13px;">لا توجد أحياء</div>';
                            loc2Dropdown.classList.add('open');
                        }
                    },
                    error: function () {
                        loc2Dropdown.innerHTML = '<div style="padding:8px 12px;color:#c00;font-size:13px;">خطأ في التحميل</div>';
                        loc2Dropdown.classList.add('open');
                    }
                });
            });

            // ============ location2 ============
            initAutocomplete('location2-text', 'location2', 'dropdown-location2', null);

            // ============ compound ============
            initAutocomplete('compound-text', 'compound-hidden', 'dropdown-compound', null);


        })();
    </script>

    {{-- ── Meta Pixel: Search (Browser-side) ─────────────────────────── --}}
    @php $metaSetting = \App\Models\SettingSite::first(); @endphp
    @if($metaSetting && $metaSetting->fb_conversions_api_enabled && $metaSetting->fb_pixel_id)
        <script>
            if (typeof fbq !== 'undefined') {
                fbq('track', 'Search', {
                    search_string: '{{ addslashes(request()->keyWords ?? request()->location1 ?? '') }}'
                });
            }
        </script>
    @endif
    {{-- ─────────────────────────────────────────────────────────────────── --}}

</x-layout>
