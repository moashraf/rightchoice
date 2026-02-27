<x-layout>
    @section('title')
        {{ trans('langsite.add_an_advertisement')}}
    @endsection

    <link href="{{ asset('assets/css/img-upload.css') }}" rel="stylesheet">

    <section id="add-listing" dir="rtl">

        <div id="pageloader" class="d-none text-center justify-content-center align-items-center" style="  background: rgba( 255, 255, 255, 0.8 );


  position: fixed;
  top:0;
  bottom:0;
  left:0;
  right:0;
  z-index: 9999;">


            <div>
                <img width="80px" height="80px"
                     src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif"
                     alt="processing..." loading="lazy"/>
                <h6 class="fw-bolder text-dark mt-5">
                    بعض الصور حجمها كبير قد يتسغرق رفعها 20 ثانيه (جاري التحميل)
                </h6>

            </div>

        </div>


        <div class="container">

            <br>
            <br>
            <br>
            <div class="contents">


                <div class="content-1">

                    <form method="POST" id="form-1" action="/aqars">

                        @csrf
                        <h3>نوع العقار و الموقع</h3>


                        <div class="row mt-3" style="align-content: start;
                        justify-content: start;">
                            <div class="col-lg-2">
                                <div class="form-group">


                                    <label for="li-cat">تصنيف العرض <span class="text-danger">*</span></label>

                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.categoryError')}}')"
                                            oninput="this.setCustomValidity('')" required name="category" id="li-cat"
                                            class="myselect">
                                        <option selected disabled value="">اختر</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ old('category') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->category_name }}</option>

                                        @endforeach
                                    </select>

                                    @error('category')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Property-type">نوع العقار <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.aqarError')}}')"
                                            oninput="this.setCustomValidity('')" required name="property_type"
                                            id="Property-type" class="myselect">
                                        <option selected disabled value="">اختر نوع العقار</option>

                                    </select>

                                    @error('property_type')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="li-compound">اسم الكومبوند (اختياري)</label>
                                    <input type="text" list="li-compound" name="compound" class="myselect"
                                           value="{{ old('compound') }}"/>
                                    <datalist id="li-compound">
                                        @foreach ($compounds as $com)
                                            <option value="{{ $com->compound }}"
                                                {{ old('compound') == $com->id ? 'selected' : '' }}>{{ $com->compound }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                    @error('compound')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="row create_governrate_btn">
                                    <div class="col-lg-4">
                                        <label for="create">المحافظه <span class="text-danger">*</span></label>

                                        <div class="col-lg-12">

                                            <div class="gov-dropdown w-100">
                                                <button type="button" id="governrate_btn"
                                                        class="myselect gov-dropbtn w-100">
                                                    <span
                                                        id="governrate_btn_text">{{ old('governrate_name') ?: 'اختر المحافظه' }}</span>
                                                    <span class="gov-caret">▾</span>
                                                </button>

                                                <div id="governrate_dropdown" class="gov-dropdown-content w-100">
                                                    <input
                                                        type="text"
                                                        id="governrate_search"
                                                        class="gov-search-input"
                                                        placeholder="ابحث عن المحافظه..."
                                                        autocomplete="off"
                                                    />

                                                    <div id="governrate_results" class="gov-results">
                                                        @foreach($governrate as $gov)
                                                            <div class="gov-item" data-id="{{ $gov->id }}"
                                                                 data-name="{{ $gov->governrate }}">{{ $gov->governrate }}</div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <input type="hidden" id="governrate_id" name="governrate_id"
                                                       value="{{ old('governrate_id') }}">
                                                <input type="hidden" id="governrate_input" name="governrate_name"
                                                       value="{{ old('governrate_name') }}">
                                            </div>
                                            <p id="governrate_error" class="text-danger text-sm mt-1" style="display:none;">من فضلك اختر المحافظه</p>

                                            @error('governrate_id')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                            @enderror
                                        </div>


                                        @error('governrate_id')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="">الحي <span class="text-danger">*</span></label>

                                        <div class="gov-dropdown w-100" id="district-dropdown-wrapper">
                                            <button type="button" id="district_btn" class="myselect gov-dropbtn w-100">
                                                <span id="district_btn_text">اختر</span>
                                                <span class="gov-caret">▾</span>
                                            </button>

                                            <div id="district_dropdown" class="gov-dropdown-content w-100">
                                                <input
                                                    type="text"
                                                    id="district_search"
                                                    class="gov-search-input"
                                                    placeholder="ابحث عن الحي..."
                                                    autocomplete="off"
                                                />
                                                <div id="district_results" class="gov-results">
                                                    <div class="gov-empty">اختر المحافظه اولاً</div>
                                                </div>
                                            </div>

                                            <input type="hidden" id="district_id" name="district_id"
                                                   value="{{ old('district_id') }}">
                                        </div>
                                        <p id="district_error" class="text-danger text-sm mt-1" style="display:none;">من فضلك اختر الحي</p>

                                        @error('district_id')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>


                                    <div class="col-lg-4">
                                        <label for="">المنطقه او الشارع (اختياري)</label>
                                        <input list="areas" name="area_id" id="area" class="myselect"
                                               placeholder="" value="{{ old('area_id') }}">
                                        <datalist id="areas">
                                            @foreach ($areas as $area)
                                                <option value="{{ $area->area }}"
                                                    {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->area }}
                                                </option>
                                            @endforeach


                                        </datalist>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h3>التفاصيل</h3>
                            <div class="form-group">
                                <label for="listing-name"> عنوان الاعلان <span class="text-danger">*</span></label>
                                <input oninvalid="this.setCustomValidity('{{ trans('validation.titleError')}}')"
                                       oninput="this.setCustomValidity('')" placeholder="" required type="text"
                                       name="title"
                                       minlength="3" maxlength="55" id="listing-name" class="myselect"
                                       value="{{ old('title') }}">
                                @error('title')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="listing-desc"> وصف تفصيلي للاعلان <span class="text-danger">*</span></label>
                                <textarea oninvalid="this.setCustomValidity('{{ trans('validation.descError')}}')"
                                          oninput="this.setCustomValidity('')" maxlength="5000" minlength="10"
                                          placeholder="" required="required" name="description"
                                          id="listing-desc" cols="30" class="myselect2"
                                          rows="5">{{ old('description') }}</textarea>
                                @error('description')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="phone">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.phoneError')}}')"
                                           oninput="this.setCustomValidity('')" disabled type="tel" name="phone"
                                           id="phone"
                                           placeholder="{{auth()->user()->MOP}}" class="myselect">
                                    <small>اذا ارد تغيير رقم الهاتف الرجاء الذهاب الى <a
                                            href="{{ url(Config::get('app.locale').'/dashboard') }}">الاعدادات</a></small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="call-times">الاوقات المتاحه للاتصال <span
                                            class="text-danger">*</span></label>
                                    <Select oninvalid="this.setCustomValidity('{{ trans('validation.callTimeError')}}')"
                                            oninput="this.setCustomValidity('')" required class="myselect"
                                            name="call_id">
                                        <option selected disabled value="">اختر الوقت المناسب</option>

                                        @foreach ($calls as $call)
                                            <option value="{{ $call->id }}"
                                                {{ old('call_id') == $call->id ? 'selected' : '' }}>{{ $call->call_time }}
                                            </option>
                                        @endforeach

                                    </Select>
                                    @error('call_id')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <input type="submit" class="btn our-btn" value="{{ trans('langsite.complete')}}">

                    </form>
                </div>
                <div class="content-2">
                    <h3>المواصفات</h3>

                    <form action="/aqars" method="POST" id="form-2">
                        @csrf
                        <div class="row" style="align-content: start;
                        justify-content: start;">
                            <!-- offer type -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="offer-type">نوع العرض <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.offerError')}}')"
                                            oninput="this.setCustomValidity('')" required class="myselect"
                                            name="offer_type" id="offer-type">
                                        <option selected disabled value="">اختر نوع العرض</option>

                                        @foreach ($offerTypes as $item)
                                            @if ($item->id != 5)
                                                <option value="{{ $item->id }}"
                                                    {{ old('offer_type') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->type_offer }}
                                                </option>

                                            @endif
                                        @endforeach
                                    </select>
                                    @error('offer_type')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <!-- total area -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="total-area">اجمالي المساحه <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.totalAreaError')}}')"
                                           oninput="this.setCustomValidity('')" required type="number" class="myselect"
                                           placeholder="" min="0"
                                           name="total_area" id="total-area" value="{{ old('total_area') }}">
                                    @error('total_area')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <!-- finish type -->
                            <div class="col-lg-4" id="finish-type-div">
                                <div class="form-group">
                                    <label for="finish-type">التشطيب <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.finishError')}}')"
                                            oninput="this.setCustomValidity('')" class="myselect" name="finishtype"
                                            id="finish-type">
                                        <option selected disabled value="">اختر نوع التشطيب</option>
                                        @foreach ($finishes as $finish)
                                            <option value="{{ $finish->id }}"
                                                {{ old('finishtype') == $finish->id ? 'selected' : '' }}>
                                                {{ $finish->finish_type }}
                                            </option>

                                        @endforeach
                                    </select>
                                    @error('finishtype')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <!-- floors number -->
                            <div class="col-lg-3" id="floors-div">
                                <div class="form-group">
                                    <label for="floors">عدد الطوابق <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.floorsNumError')}}')"
                                           oninput="this.setCustomValidity('')" type="number" class="myselect"
                                           placeholder="" min="0"
                                           name="number_of_floors" id="floors" value="{{ old('number_of_floors') }}">
                                </div>
                                @error('number_of_floors')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>


                            <div class="col-lg-3" id="license-type-div">
                                <div class="form-group">
                                    <label for="license-type">نوع الترخيص <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.licenseError')}}')"
                                            oninput="this.setCustomValidity('')" name="license_type" class="myselect"
                                            id="license-type">
                                        @foreach ($lic_types as $lic)
                                            <option value="{{ $lic->id }}"
                                                {{ old('license_id') == $lic->id ? 'selected' : '' }}>
                                                {{ $lic->license_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('license_type')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- floor number -->
                            <div class="col-lg-3" id="floor-div">
                                <div class="form-group">
                                    <label for="floor-number">الدور <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.floorError')}}')"
                                            oninput="this.setCustomValidity('')" name="floor" id="floor-number"
                                            class="myselect">
                                        <option selected disabled value="">اختر</option>
                                        @foreach ($floors as $floor)
                                            <option value="{{ $floor->id }}"
                                                {{ old('floor') == $floor->id ? 'selected' : '' }}>{{ $floor->floor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('floor')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <!-- floor and property inners -->
                            <div id="inner-floor" class="row" style="align-content: start;
                            justify-content: start;">

                                <!-- rooms -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="rooms">عدد الغرف <span class="text-danger">*</span></label>
                                        <input oninvalid="this.setCustomValidity('{{ trans('validation.roomsError')}}')"
                                               oninput="this.setCustomValidity('')" type="number" class="myselect"
                                               placeholder="" min="0"
                                               name="rooms" id="rooms" value="{{ old('rooms') }}">
                                        @error('rooms')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- bathrooms -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="baths">عدد الحمامات <span class="text-danger">*</span></label>
                                        <input oninvalid="this.setCustomValidity('{{ trans('validation.bathError')}}')"
                                               oninput="this.setCustomValidity('')" type="number" class="myselect"
                                               placeholder="" min="0"
                                               name="baths" id="baths" value="{{ old('baths') }}">
                                        @error('baths')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- boolean row -->

                            <!-- total-price -->

                            <!-- installment row -->
                            <div id="showHide">


                                <div id="boolean-row" class="row" style="align-content: start;
                            justify-content: start;">

                                    <!-- bank-finance -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="bank-finance">تصلح تمويل عقاري <span
                                                    class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="finannce_bank"
                                                    id="bank-finance" class="myselect">
                                                <option selected disabled value="">اختر</option>
                                                <option value="1">نعم
                                                </option>
                                                <option value="0">كلا
                                                </option>
                                            </select>

                                        </div>
                                    </div>

                                    <!-- trade -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="trade">تصلح للبدل <span class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="trade" id="trade"
                                                    class="myselect">
                                                <option selected disabled value="">اختر</option>
                                                <option value="1">نعم</option>
                                                <option value="0">كلا</option>
                                            </select>

                                        </div>
                                    </div>
                                    <!-- signed -->
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="signed">مسجله شهر عقاري <span
                                                    class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احد الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="licensed" id="signed"
                                                    class="myselect">
                                                <option selected disabled value="">اختر</option>
                                                <option value="1">نعم
                                                </option>
                                                <option value="0">كلا
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3" id="total-price-div">
                                    <div class="form-group">
                                        <label for="total-price">السعر الاجمالي <span
                                                class="text-danger">*</span></label>
                                        <input required
                                               oninvalid="this.setCustomValidity('من فضلك ادخل السعر الاجمالي ')"
                                               oninput="this.setCustomValidity('')" type="number" name="total_price"
                                               id="total-price" class="myselect"
                                               placeholder="" min="50">

                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 mb-3" id="mzaya-div">
                                <h3>المزايا</h3>
                                <small>يمكن اختيار اكثر من ميزه بالضغط عليها</small>

                                <br>
                                <br>
                                <div class="row"
                                     style="align-items:start !important;align-content: start !important;justify-content: start !important;">
                                    <div class="col-lg-12">
                                        <input type="checkbox" onClick="toggle(this)"/>
                                        <label for="mzaya[]">بالضغط على المربع يتم اختيار جميع المزايا</label><br>
                                    </div>
                                    @foreach ($mzaya as $maz)
                                        <div class="col-lg-2">
                                            <input type="checkbox" name="mzaya[]" value="{{$maz->id}}">
                                            <label for="mzaya[]">{{ $maz->mzaya_type }}</label><br>
                                        </div>
                                    @endforeach

                                    <script language="JavaScript">
                                        function toggle(source) {
                                            checkboxes = document.getElementsByName('mzaya[]');
                                            for (var i = 0, n = checkboxes.length; i < n; i++) {
                                                checkboxes[i].checked = source.checked;
                                            }
                                        }
                                    </script>

                                </div>

                            </div>


                        </div>


                        <input type="submit" value=" {{ trans('langsite.add_an_advertisement')}}" class=" add_an_advertisement btn our-btn"/>
                        <button id="back-form-1" class="btn btn-light">الرجوع</button>
                    </form>
                </div>
                <div class="content-3">


                    <form method="POST" action="{{ route('aqars.upload') }}" id="form-3" files="true"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div id="result-form-1" style="display:none;"></div>
                        <div id="result-form-2" style="display:none;"></div>
                        <div id="result3" style="display:none;"><input name="main_img" id="mainImg" loading="lazy"/>
                        </div>
                        <div class="form-group">
                            <!-- <input type="file"   name="photos_id[]" multiple> -->
                            <div class="mt-3 w-100">

                                <div class="w-100 ">
                                    <div class="d-flex justify-content-between">

                                        <div class="d-flex w-100 justify-content-between">

                                            <h4>
                                                اضف الصور بحد اقصى 8 صور
                                            </h4>
                                            <button id="needsclickBtn" type="button" class="btn btn-primary"
                                                    onclick="document.getElementById('image').click();">اختر الصور
                                            </button>

                                        </div>
                                        <br>
                                        <input accept="image/png , image/jpeg, image/jpg" type="file" name="photos_id[]"
                                               id="image" multiple
                                               class="d-none" onchange="image_select(this.files)">

                                    </div>
                                    <p>الرجاء عدم وضع صور عليها لوجو منعا لرفض الإعلان</p>

                                    <div
                                        class="dropzone mt-3 dz-message needsclick d-flex flex-wrap justify-content-center text-center containerimgs"
                                        id="container-imgs">
                                        <!-- image preview -->
                                        <div class="dz-message needsclick">
                                            <br>
                                            <button type="button" class="upBtn"
                                                    onclick="document.getElementById('image').click()"><i
                                                    class="fa fa-upload fa-7x"></i></button>


                                            <p class="mt-3">upload images here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-check mb-3 form-switch mt-3">
                            <input required class="form-check-input" name="endorsement" type="checkbox" id="ekrar">
                            <label style="padding-right: 40px;" class="form-check-label" for="ekrar">
                                اقر اني مالك الوحدة وليس وسيط عقاري او سمسار وان جميع محتويات الاعلان صحيحة وعلى
                                مسؤوليتي
                            </label>
                        </div>

                        <!--    <input type="submit" class="btn btn-primary"  value="submit"/> -->

                        <a id="back-form-2" class="btn btn-light">الرجوع</a>
                        <input type="submit" value="انشر الاعلان" class="btn btn-primary">
                    </form>

                </div>

                @if ($errors->any())
                    <h3 class="mt-3">ماذا حدث خطاء</h3>
                    @foreach ($errors->all() as $error)
                        <li class="text-danger text-sm">{{ $error }}</li>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <x-call-to-action/>

    <!-- ✅ FIX: لازم jQuery يبقى قبل أي ملف بيستخدمه -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <?php if (App::getLocale() == 'en')
    {

        ?>

    <script src="{{ asset('assets/js/english-imgs.js') }}"></script>
        <?php
    }
    else{


        ?>

    <script src="{{ asset('assets/js/img-upload.js') }}"></script>

        <?php
    }
        ?>

        <!-- ✅ CSS بسيط للـ suggestions (كان ناقص) -->
    <style>
        .suggestions {
            position: absolute;
            background: #fff;
            border: 1px solid #ddd;
            width: calc(100% - 24px);
            max-height: 220px;
            overflow-y: auto;
            z-index: 9999;
            display: none;
            margin-top: 2px;
            border-radius: 6px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .suggestion-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f1f1f1;
            font-size: 14px;
        }

        .suggestion-item:hover {
            background: #f7f7f7;
        }
    </style>

    <script>
        $(document).ready(function () {

            function fetchDistrictsByGovernorateId(governrateId) {
                if (!governrateId) return;

                // reset district selection
                $('#district_id').val('');
                $('#district_btn_text').text('جاري التحميل...');
                $('#district_results').html('<div class="gov-empty">جاري التحميل...</div>');

                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        country_id: governrateId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (result) {
                        $('#district_btn_text').text('اختر');
                        let html = '';
                        if (result && result.states && result.states.length > 0) {
                            $.each(result.states, function (key, value) {
                                html += '<div class="gov-item district-item" data-id="' + value.id + '" data-name="' + value.district + '">' + value.district + '</div>';
                            });
                            $('#district_results').html(html);
                        } else {
                            $('#district_results').html('<div class="gov-empty">لا توجد أحياء</div>');
                        }
                    },
                    error: function (xhr) {
                        console.log('fetch-states error:', xhr.status, xhr.responseText);
                        $('#district_btn_text').text('اختر');
                        $('#district_results').html('<div class="gov-empty">خطأ في التحميل</div>');
                    }
                });
            }

            // فتح/غلق dropdown
            $('#governrate_btn').on('click', function () {
                $('#governrate_dropdown').toggleClass('show');

                if ($('#governrate_dropdown').hasClass('show')) {
                    $('#governrate_search').val('');
                    // اظهر كل المحافظات
                    $('#governrate_results .gov-item').show();
                    $('#governrate_results .gov-empty').remove();
                    setTimeout(() => $('#governrate_search').focus(), 0);
                }
            });

            // قفل dropdown لو ضغط بره
            $(document).on('click', function (e) {
                if (!$(e.target).closest('.gov-dropdown').length) {
                    $('#governrate_dropdown').removeClass('show');
                    $('#district_dropdown').removeClass('show');
                }
            });

            // تطبيع النص العربي للبحث الذكي
            function normalizeArabic(str) {
                return str
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

            // فلترة المحافظات محلياً مع بحث ذكي
            $('#governrate_search').on('keyup', function () {
                const query = normalizeArabic($(this).val());
                let found = false;

                if (query.length === 0) {
                    $('#governrate_results .gov-item').show();
                    $('#governrate_results .gov-empty').remove();
                    return;
                }

                $('#governrate_results .gov-item').each(function () {
                    const name = normalizeArabic($(this).data('name').toString());
                    if (name.indexOf(query) > -1) {
                        $(this).show();
                        found = true;
                    } else {
                        $(this).hide();
                    }
                });

                // اظهار رسالة لو مفيش نتائج
                $('#governrate_results .gov-empty').remove();
                if (!found) {
                    $('#governrate_results').append('<div class="gov-empty">لا توجد نتائج</div>');
                }
            });

            // اختيار محافظة (فقط العناصر داخل governrate_results)
            $(document).on('click', '#governrate_results .gov-item', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');

                $('#governrate_input').val(name);
                $('#governrate_id').val(id);

                // تحديث نص الزرار
                $('#governrate_btn_text').text(name);

                // اقفل dropdown
                $('#governrate_dropdown').removeClass('show');

                // reset الحي
                $('#district_id').val('');
                $('#district_btn_text').text('اختر');

                // هات الأحياء
                fetchDistrictsByGovernorateId(id);
            });

            // ===== District Dropdown =====

            // فتح/غلق dropdown الحي
            $('#district_btn').on('click', function () {
                $('#district_dropdown').toggleClass('show');

                if ($('#district_dropdown').hasClass('show')) {
                    $('#district_search').val('');
                    $('#district_results .gov-item').show();
                    $('#district_results .gov-empty').remove();
                    setTimeout(() => $('#district_search').focus(), 0);
                }
            });

            // فلترة الأحياء محلياً مع بحث ذكي
            $('#district_search').on('keyup', function () {
                const query = normalizeArabic($(this).val());
                let found = false;

                if (query.length === 0) {
                    $('#district_results .gov-item').show();
                    $('#district_results .gov-empty').remove();
                    return;
                }

                $('#district_results .gov-item').each(function () {
                    const name = normalizeArabic($(this).data('name').toString());
                    if (name.indexOf(query) > -1) {
                        $(this).show();
                        found = true;
                    } else {
                        $(this).hide();
                    }
                });

                $('#district_results .gov-empty').remove();
                if (!found) {
                    $('#district_results').append('<div class="gov-empty">لا توجد نتائج</div>');
                }
            });

            // اختيار حي
            $(document).on('click', '#district_results .gov-item', function () {
                const id = $(this).data('id');
                const name = $(this).data('name');

                $('#district_id').val(id);
                $('#district_btn_text').text(name);
                $('#district_dropdown').removeClass('show');
            });

            // لو فيه old value من السيرفر (edit/validation) هات الأحياء تلقائيًا
            const oldGovId = $('#governrate_id').val();
            const oldGovName = $('#governrate_input').val();
            if (oldGovName) $('#governrate_btn_text').text(oldGovName);
            if (oldGovId) fetchDistrictsByGovernorateId(oldGovId);

            // ===== Form Validation for required dropdowns =====

            // شيل البوردر الأحمر والرسالة لما يختار محافظة
            $(document).on('click', '#governrate_results .gov-item', function () {
                $('#governrate_btn').removeClass('gov-invalid');
                $('#governrate_error').hide();
            });

            // شيل البوردر الأحمر والرسالة لما يختار حي
            $(document).on('click', '#district_results .gov-item', function () {
                $('#district_btn').removeClass('gov-invalid');
                $('#district_error').hide();
            });

        });
    </script>


    <script>
        {{--$(document).ready(function () {--}}

        {{--    function fetchDistrictsByGovernorateId(governrateId) {--}}
        {{--        if (!governrateId) return;--}}

        {{--        $("#area_input").html('');--}}
        {{--        $.ajax({--}}
        {{--            url: "{{ url('api/fetch-states') }}",--}}
        {{--            type: "POST",--}}
        {{--            data: {--}}
        {{--                country_id: governrateId,--}}
        {{--                _token: '{{ csrf_token() }}'--}}
        {{--            },--}}
        {{--            dataType: 'json',--}}
        {{--            success: function (result) {--}}
        {{--                $('#area_input').html('<option value="" selected disabled>اختر</option>');--}}
        {{--                $.each(result.states, function (key, value) {--}}
        {{--                    $("#area_input").append('<option value="' + value.id + '">' + value.district + '</option>');--}}
        {{--                });--}}
        {{--            },--}}
        {{--            error: function(xhr){--}}
        {{--                console.log('fetch-states error:', xhr.status, xhr.responseText);--}}
        {{--            }--}}
        {{--        });--}}
        {{--    }--}}

        {{--    // ✅ لو المستخدم غيّر القيمة يدويًا، نحاول نجيب الأحياء بالـ governrate_id لو موجود--}}
        {{--    $('#governrate_input').on('change', function () {--}}
        {{--        var governrateId = $('#governrate_id').val();--}}
        {{--        if (!governrateId) return;--}}
        {{--        fetchDistrictsByGovernorateId(governrateId);--}}
        {{--    });--}}

        {{--    // Autocomplete for governorate--}}
        {{--    let govAjax = null; // ✅ cancel previous request--}}
        {{--    $('#governrate_input').on('input', function() {--}}
        {{--        var query = $(this).val();--}}

        {{--        // ✅ reset hidden id عندما يكتب من جديد--}}
        {{--        $('#governrate_id').val('');--}}
        {{--        $("#area_input").html('<option value="" selected disabled>اختر</option>');--}}

        {{--        if (govAjax) {--}}
        {{--            try { govAjax.abort(); } catch(e) {}--}}
        {{--        }--}}

        {{--        if (query.length > 0) {--}}
        {{--            govAjax = $.ajax({--}}
        {{--                url: '{{ url(App::getLocale() . "/governorates/search") }}',--}}
        {{--                type: 'GET',--}}
        {{--                data: { q: query },--}}
        {{--                dataType: 'json',--}}
        {{--                success: function(data) {--}}
        {{--                    var suggestions = $('#governrate_suggestions');--}}
        {{--                    suggestions.empty();--}}

        {{--                    if (Array.isArray(data) && data.length > 0) {--}}
        {{--                        data.forEach(function(item) {--}}
        {{--                            // دعم أسماء مختلفة للحقول--}}
        {{--                            var id = item.id ?? item.governrate_id ?? '';--}}
        {{--                            var name = item.governrate ?? item.name ?? item.governorate ?? '';--}}
        {{--                            if (!id || !name) return;--}}

        {{--                            suggestions.append(--}}
        {{--                                '<div class="suggestion-item" data-id="' + id + '" data-name="' + name + '">' + name + '</div>'--}}
        {{--                            );--}}
        {{--                        });--}}
        {{--                        suggestions.show();--}}
        {{--                    } else {--}}
        {{--                        suggestions.hide();--}}
        {{--                    }--}}
        {{--                },--}}
        {{--                error: function(xhr){--}}
        {{--                    console.log('governorates/search error:', xhr.status, xhr.responseText);--}}
        {{--                    $('#governrate_suggestions').hide();--}}
        {{--                }--}}
        {{--            });--}}
        {{--        } else {--}}
        {{--            $('#governrate_suggestions').hide();--}}
        {{--        }--}}
        {{--    });--}}

        {{--    // ✅ عند اختيار المحافظة: نحدد id + نجيب الأحياء فورًا--}}
        {{--    $(document).on('click', '.suggestion-item', function() {--}}
        {{--        var id = $(this).data('id');--}}
        {{--        var name = $(this).data('name');--}}

        {{--        $('#governrate_input').val(name);--}}
        {{--        $('#governrate_id').val(id);--}}
        {{--        $('#governrate_suggestions').hide();--}}

        {{--        fetchDistrictsByGovernorateId(id);--}}
        {{--    });--}}

        {{--    $(document).on('click', function(e) {--}}
        {{--        if (!$(e.target).closest('#governrate_input, #governrate_suggestions').length) {--}}
        {{--            $('#governrate_suggestions').hide();--}}
        {{--        }--}}
        {{--    });--}}

        {{--});--}}





        $(function () {

            // ✅ FIX: أرقام فقط (بدون حروف)
            $("#total-area,#rooms,#baths,#total-price,#installment-time,#installment-value,#installment-date,#rent-value").keypress(function (event) {
                var ew = event.which;

                // backspace / delete / arrows
                if (ew === 0 || ew === 8) return true;

                // digits فقط
                if (48 <= ew && ew <= 57) return true;

                return false;
            });
        });

    </script>


    <style>
        .gov-dropdown {
            position: relative;
        }

        .gov-dropbtn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border: 1px solid #ddd;
            padding: 10px 12px;
            cursor: pointer;
            border-radius: 6px;
        }

        .gov-dropbtn:focus {
            outline: 3px solid #eee;
        }

        .gov-caret {
            font-size: 12px;
            color: #666;
        }

        .gov-dropdown-content {
            display: none;
            position: absolute;
            top: calc(100% + 4px);
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            z-index: 9999;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
            overflow: hidden;
        }

        .gov-dropdown-content.show {
            display: block;
        }

        .gov-search-input {
            width: 100%;
            border: 0;
            border-bottom: 1px solid #eee;
            padding: 10px 12px;
            outline: none;
        }

        .gov-results {
            max-height: 240px;
            overflow: auto;
        }

        .gov-item {
            padding: 10px 12px;
            cursor: pointer;
            border-bottom: 1px solid #f4f4f4;
        }

        .gov-item:hover {
            background: #f7f7f7;
        }

        .gov-empty {
            padding: 10px 12px;
            color: #777;
        }

        .gov-invalid {
            border: 2px solid #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2) !important;
        }

        .gov-invalid span:first-child {
            color: #dc3545;
        }

        .create_governrate_btn {
            align-content: start;
            justify-content: start;
        }

    </style>


</x-layout>
