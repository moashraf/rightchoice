<x-layout>
    @section('title')
        {{ trans('langsite.add_an_advertisement')}}
    @endsection

    <link href="{{ asset('assets/css/img-upload.css') }}" rel="stylesheet">

    <section id="add-listing" class="create-page" dir="rtl">

        <div id="pageloader" class="d-none create-page-loader" role="status" aria-live="polite">
            <div class="create-page-loader-card">
                <span class="create-page-loader-spinner" aria-hidden="true"></span>
                <h6 class="create-page-loader-title">جاري تجهيز الإعلان</h6>
                <p class="create-page-loader-text">
                    بعض الصور كبيرة الحجم، لذلك قد يستغرق رفعها بضع ثوانٍ.
                </p>
            </div>
        </div>

        <div class="container create-page-container">
            <header class="create-page-hero">
                <div class="create-page-hero-content">
                    <span class="create-page-hero-label">
                        <i class="fas fa-home" aria-hidden="true"></i>
                        Right Choice
                    </span>
                    <h1 class="create-page-title">أضف إعلانك العقاري بسهولة</h1>
                    <p class="create-page-subtitle">
                        أكمل البيانات الأساسية والمواصفات ثم أضف صورًا واضحة ليظهر عقارك بأفضل صورة.
                    </p>
                </div>
                <div class="create-page-hero-visual" aria-hidden="true">
                    <span class="create-page-hero-circle create-page-hero-circle-large"></span>
                    <span class="create-page-hero-circle create-page-hero-circle-small"></span>
                    <i class="fas fa-building create-page-hero-icon"></i>
                </div>
            </header>

            <nav id="create-page-steps" class="create-page-steps" aria-label="خطوات إضافة الإعلان">
                <div class="create-page-step create-page-step-active" data-create-step="1">
                    <span class="create-page-step-number">1</span>
                    <span class="create-page-step-copy">
                        <strong>البيانات الأساسية</strong>
                        <small>نوع العقار والموقع</small>
                    </span>
                </div>
                <span class="create-page-step-line" aria-hidden="true"></span>
                <div class="create-page-step" data-create-step="2">
                    <span class="create-page-step-number">2</span>
                    <span class="create-page-step-copy">
                        <strong>المواصفات</strong>
                        <small>التفاصيل والسعر</small>
                    </span>
                </div>
                <span class="create-page-step-line" aria-hidden="true"></span>
                <div class="create-page-step" data-create-step="3">
                    <span class="create-page-step-number">3</span>
                    <span class="create-page-step-copy">
                        <strong>الصور والنشر</strong>
                        <small>المراجعة النهائية</small>
                    </span>
                </div>
            </nav>

            <div class="contents create-page-wizard">


                <div class="content-1 create-page-panel">

                    <form method="POST" id="form-1" class="create-page-form" action="/aqars">

                        @csrf
                        <div class="create-page-section-heading">
                            <span class="create-page-section-icon"><i class="fas fa-map-marker-alt" aria-hidden="true"></i></span>
                            <div class="create-page-section-copy">
                                <h3>نوع العقار والموقع</h3>
                                <p>حدد تصنيف العقار وموقعه بدقة ليسهل الوصول إليه.</p>
                            </div>
                        </div>

                        <div class="row mt-3" style="align-content: start;
                        justify-content: start;">
                            <div class="col-lg-2">
                                <div class="form-group create-page-form-group">

                                    <label for="li-cat">تصنيف العرض <span class="text-danger">*</span></label>

                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.categoryError')}}')"
                                            oninput="this.setCustomValidity('')" required name="category" id="li-cat"
                                            class="myselect create-page-control">
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
                                <div class="form-group create-page-form-group">
                                    <label for="Property-type">نوع العقار
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.aqarError')}}')"
                                            oninput="this.setCustomValidity('')" required name="property_type"
                                            id="Property-type" class="myselect create-page-control">
                                        <option selected disabled value="">اختر نوع العقار</option>

                                    </select>

                                    @error('property_type')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group create-page-form-group">
                                    <label for="li-compound">اسم الكومبوند (اختياري)</label>
                                    <input type="text" list="li-compound" name="compound" class="myselect create-page-control"
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
                            <div class="form-group create-page-form-group">

                                <div class="row create_governrate_btn create-page-governorate-row">
                                    <div class="col-lg-4">
                                        <label for="create">المحافظه <span class="text-danger">*</span></label>

                                        <div class="col-lg-12">

                                            <div class="create_create gov-dropdown create-page-dropdown w-100">
                                                <button type="button" id="governrate_btn"
                                                        class="myselect create-page-control create-page-dropdown-button gov-dropbtn w-100">
                                                    <span
                                                        id="governrate_btn_text">{{ old('governrate_name') ?: 'اختر المحافظه' }}</span>
                                                    <span class="gov-caret">▾</span>
                                                </button>

                                                <div id="governrate_dropdown" class="gov-dropdown-content create-page-dropdown-menu w-100">
                                                    <input
                                                        type="text"
                                                        id="governrate_search"
                                                        class="gov-search-input create-page-dropdown-search"
                                                        placeholder="ابحث عن المحافظه..."
                                                        autocomplete="off"
                                                    />

                                                    <div id="governrate_results" class="gov-results create-page-dropdown-results">
                                                        @foreach($governrate as $gov)
                                                            <div class="gov-item create-page-dropdown-item" data-id="{{ $gov->id }}"
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

                                        <div class="gov-dropdown create-page-dropdown w-100" id="district-dropdown-wrapper">
                                            <button type="button" id="district_btn" class="myselect create-page-control create-page-dropdown-button gov-dropbtn w-100">
                                                <span id="district_btn_text">اختر</span>
                                                <span class="gov-caret">▾</span>
                                            </button>

                                            <div id="district_dropdown" class="gov-dropdown-content create-page-dropdown-menu w-100">
                                                <input
                                                    type="text"
                                                    id="district_search"
                                                    class="gov-search-input create-page-dropdown-search"
                                                    placeholder="ابحث عن الحي..."
                                                    autocomplete="off"
                                                />
                                                <div id="district_results" class="gov-results create-page-dropdown-results">
                                                    <div class="gov-empty create-page-dropdown-empty">اختر المحافظه اولاً</div>
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
                                        <input list="areas" name="area_id" id="area" class="myselect create-page-control"
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

                            {{-- ── Map Location Section ──────────────────── --}}
                            {{--                            <div class="form-group" style="width:100%;">--}}
                            {{--                                <label style="font-weight:700; font-size:15px; margin-bottom:10px;">--}}
                            {{--                                    <i class="fas fa-map-marker-alt text-danger"></i>--}}
                            {{--                                    موقع العقار على الخريطة--}}
                            {{--                                </label>--}}
                            {{--                                <small class="d-block text-muted mb-2">اضغط على الخريطة لتحديد الموقع أو سيتم استخدام موقع المحافظة تلقائياً</small>--}}

                            {{--                                <div class="row mb-2">--}}
                            {{--                                    <div class="col-md-5">--}}
                            {{--                                        <input type="number" step="any" name="location_lat" id="location_lat"--}}
                            {{--                                               class="myselect create-page-control" placeholder="خط العرض (Latitude)"--}}
                            {{--                                               value="{{ old('location_lat') }}" min="-90" max="90">--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-5">--}}
                            {{--                                        <input type="number" step="any" name="location_lon" id="location_lon"--}}
                            {{--                                               class="myselect create-page-control" placeholder="خط الطول (Longitude)"--}}
                            {{--                                               value="{{ old('location_lon') }}" min="-180" max="180">--}}
                            {{--                                    </div>--}}
                            {{--                                    <div class="col-md-2 d-flex align-items-center">--}}
                            {{--                                        <button type="button" id="clearCoordsBtn" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">--}}
                            {{--                                            <i class="fas fa-times"></i> مسح--}}
                            {{--                                        </button>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <div id="frontPropertyMap" style="width:100%; height:350px; border-radius:12px; border:2px solid #e0e0e0;"></div>--}}
                            {{--                            </div>--}}
                            {{-- ── End Map Location Section ──────────────────── --}}

                            <div class="create-page-divider"></div>
                            <div class="create-page-section-heading create-page-section-heading-spaced">
                                <span class="create-page-section-icon"><i class="fas fa-align-right" aria-hidden="true"></i></span>
                                <div class="create-page-section-copy">
                                    <h3>تفاصيل الإعلان</h3>
                                    <p>اكتب عنوانًا واضحًا ووصفًا يساعد الباحثين على فهم مميزات العقار.</p>
                                </div>
                            </div>
                            <div class="form-group create-page-form-group">
                                <label for="listing-name"> عنوان الاعلان <span class="text-danger">*</span></label>
                                <input placeholder="" required type="text"
                                       name="title"
                                       minlength="40" maxlength="250" id="listing-name"
                                       class="myselect create-page-control"
                                       aria-describedby="listing-name-validation"
                                       value="{{ old('title') }}">
                                <div id="listing-name-validation"
                                     class="create-page-validation-message"
                                     role="alert"
                                     aria-live="polite"></div>
                                @error('title')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="form-group create-page-form-group">
                                <label for="listing-desc"> وصف تفصيلي للاعلان <span class="text-danger">*</span></label>
                                <textarea maxlength="1200" minlength="50"
                                          placeholder="" required="required" name="description"
                                          id="listing-desc" cols="30"
                                          class="myselect2 create-page-control create-page-textarea"
                                          aria-describedby="listing-desc-validation"
                                          rows="5">{{ old('description') }}</textarea>
                                <div id="listing-desc-validation"
                                     class="create-page-validation-message"
                                     role="alert"
                                     aria-live="polite"></div>
                                @error('description')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group create-page-form-group">
                                    <label for="phone">رقم الهاتف <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.phoneError')}}')"
                                           oninput="this.setCustomValidity('')" disabled type="tel" name="phone"
                                           id="phone"
                                           placeholder="{{auth()->user()->MOP}}" class="myselect create-page-control">
                                    <small class="create-page-field-note">إذا أردت تغيير رقم الهاتف، الرجاء الذهاب إلى <a
                                            href="{{ url(Config::get('app.locale').'/dashboard') }}">الإعدادات</a></small>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group create-page-form-group">
                                    <label id="call-times-label">الاوقات المتاحه للاتصال <span
                                            class="text-danger">*</span></label>
                                    <div class="call-times-radio-group create-page-call-times" role="radiogroup" aria-labelledby="call-times-label">
                                        @foreach ($calls as $call)
                                            <div class="call-time-option create-page-call-option">
                                                <input oninvalid="this.setCustomValidity('{{ trans('validation.callTimeError')}}')"
                                                       onchange="document.querySelectorAll('input[name=call_id]').forEach(function(input) { input.setCustomValidity(''); });"
                                                       required class="form-check-input" type="radio"
                                                       name="call_id" id="call-time-{{ $call->id }}"
                                                       value="{{ $call->id }}"
                                                    {{ old('call_id') == $call->id ? 'checked' : '' }}>
                                                <label class="form-check-label" for="call-time-{{ $call->id }}">
                                                    {{ $call->call_time }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('call_id')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="create-page-actions create-page-actions-end">
                            <input type="submit" class="btn our-btn create-page-button create-page-button-primary" value="{{ trans('langsite.complete')}}">
                        </div>

                    </form>
                </div>
                <div class="content-2 create-page-panel">
                    <div class="create-page-section-heading">
                        <span class="create-page-section-icon"><i class="fas fa-sliders-h" aria-hidden="true"></i></span>
                        <div class="create-page-section-copy">
                            <h3>مواصفات العقار</h3>
                            <p>أضف المساحة والتشطيب والسعر وباقي المواصفات الأساسية.</p>
                        </div>
                    </div>

                    <form action="/aqars" method="POST" id="form-2" class="create-page-form">
                        @csrf
                        <div class="row" style="align-content: start;
                        justify-content: start;">
                            <!-- offer type -->
                            <div class="col-lg-4">
                                <div class="form-group create-page-form-group">
                                    <label for="offer-type">نوع العرض <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.offerError')}}')"
                                            oninput="this.setCustomValidity('')" required class="myselect create-page-control"
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
                                <div class="form-group create-page-form-group">
                                    <label for="total-area">اجمالي المساحه <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.totalAreaError')}}')"
                                           oninput="this.setCustomValidity('')" required type="number" class="myselect create-page-control"
                                           placeholder="" min="0"
                                           name="total_area" id="total-area" value="{{ old('total_area') }}">
                                    @error('total_area')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            <!-- finish type -->
                            <div class="col-lg-4" id="finish-type-div">
                                <div class="form-group create-page-form-group">
                                    <label for="finish-type">التشطيب <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.finishError')}}')"
                                            oninput="this.setCustomValidity('')" class="myselect create-page-control" name="finishtype"
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
                                <div class="form-group create-page-form-group">
                                    <label for="floors">عدد الطوابق <span class="text-danger">*</span></label>
                                    <input oninvalid="this.setCustomValidity('{{ trans('validation.floorsNumError')}}')"
                                           oninput="this.setCustomValidity('')" type="number" class="myselect create-page-control"
                                           placeholder="" min="0"
                                           name="number_of_floors" id="floors" value="{{ old('number_of_floors') }}">
                                </div>
                                @error('number_of_floors')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>


                            <div class="col-lg-3" id="license-type-div">
                                <div class="form-group create-page-form-group">
                                    <label for="license-type">نوع الترخيص <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.licenseError')}}')"
                                            oninput="this.setCustomValidity('')" name="license_type" class="myselect create-page-control"
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
                                <div class="form-group create-page-form-group">
                                    <label for="floor-number">الدور <span class="text-danger">*</span></label>
                                    <select oninvalid="this.setCustomValidity('{{ trans('validation.floorError')}}')"
                                            oninput="this.setCustomValidity('')" name="floor" id="floor-number"
                                            class="myselect create-page-control">
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
                                    <div class="form-group create-page-form-group">
                                        <label for="rooms">عدد الغرف <span class="text-danger">*</span></label>
                                        <input oninvalid="this.setCustomValidity('{{ trans('validation.roomsError')}}')"
                                               oninput="this.setCustomValidity('')" type="number" class="myselect create-page-control"
                                               placeholder="" min="0"
                                               name="rooms" id="rooms" value="{{ old('rooms') }}">
                                        @error('rooms')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- bathrooms -->
                                <div class="col-lg-3">
                                    <div class="form-group create-page-form-group">
                                        <label for="baths">عدد الحمامات <span class="text-danger">*</span></label>
                                        <input oninvalid="this.setCustomValidity('{{ trans('validation.bathError')}}')"
                                               oninput="this.setCustomValidity('')" type="number" class="myselect create-page-control"
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
                                        <div class="form-group create-page-form-group">
                                            <label for="bank-finance">تصلح تمويل عقاري <span
                                                    class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="finannce_bank"
                                                    id="bank-finance" class="myselect create-page-control">
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
                                        <div class="form-group create-page-form-group">
                                            <label for="trade">تصلح للبدل <span class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="trade" id="trade"
                                                    class="myselect create-page-control">
                                                <option selected disabled value="">اختر</option>
                                                <option value="1">نعم</option>
                                                <option value="0">كلا</option>
                                            </select>

                                        </div>
                                    </div>
                                    <!-- signed -->
                                    <div class="col-lg-3">
                                        <div class="form-group create-page-form-group">
                                            <label for="signed">مسجله شهر عقاري <span
                                                    class="text-danger">*</span></label>
                                            <select required
                                                    oninvalid="this.setCustomValidity('من فضلك اختر احد الاختيارات')"
                                                    oninput="this.setCustomValidity('')" name="licensed" id="signed"
                                                    class="myselect create-page-control">
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
                                    <div class="form-group create-page-form-group">
                                        <label for="total-price">السعر الاجمالي <span
                                                class="text-danger">*</span></label>
                                        <input required
                                               oninvalid="this.setCustomValidity('من فضلك ادخل السعر الاجمالي ')"
                                               oninput="this.setCustomValidity('')" type="number" name="total_price"
                                               id="total-price" class="myselect create-page-control"
                                               placeholder="" min="50">

                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 mb-3 create-page-features" id="mzaya-div">
                                <div class="create-page-section-heading create-page-section-heading-compact">
                                    <span class="create-page-section-icon"><i class="fas fa-star" aria-hidden="true"></i></span>
                                    <div class="create-page-section-copy">
                                        <h3>مزايا العقار</h3>
                                        <p>يمكنك اختيار أكثر من ميزة بالضغط عليها.</p>
                                    </div>
                                </div>

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


                        <div class="create-page-actions">
                            <button id="back-form-1" class="btn btn-light create-page-button create-page-button-secondary" type="button">
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                الرجوع
                            </button>
                            <input type="submit" value="{{ trans('langsite.add_an_advertisement')}}" class="add_an_advertisement btn our-btn create-page-button create-page-button-primary"/>
                        </div>
                    </form>
                </div>
                <div class="content-3 create-page-panel">
                    <div class="create-page-section-heading">
                        <span class="create-page-section-icon"><i class="fas fa-images" aria-hidden="true"></i></span>
                        <div class="create-page-section-copy">
                            <h3>صور العقار</h3>
                            <p>أضف صورًا واضحة ومتنوعة، واختر الصورة الرئيسية بعناية.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('aqars.upload') }}" id="form-3" files="true"
                          enctype="multipart/form-data" class="create-page-form">
                        {{ csrf_field() }}
                        <div id="result-form-1" style="display:none;"></div>
                        <div id="result-form-2" style="display:none;"></div>
                        <div id="result3" style="display:none;"><input name="main_img" id="mainImg" loading="lazy"/>
                        </div>
                        <div class="form-group create-page-form-group">
                            <!-- <input type="file"   name="photos_id[]" multiple> -->
                            <div class="mt-3 w-100">

                                <div class="w-100 ">
                                    <div class="d-flex justify-content-between create-page-upload-header">

                                        <div class="d-flex w-100 justify-content-between create-page-upload-title-row">

                                            <h4 class="create-page-upload-title">أضف الصور بحد أقصى 8 صور</h4>
                                            <button id="needsclickBtn" type="button" class="btn btn-primary create-page-button create-page-button-primary create-page-upload-button"
                                                    onclick="document.getElementById('image').click();"><i class="fas fa-plus" aria-hidden="true"></i> اختر الصور
                                            </button>

                                        </div>
                                        <input accept="image/png , image/jpeg, image/jpg" type="file" name="photos_id[]"
                                               id="image" multiple
                                               class="d-none" onchange="image_select(this.files)">

                                    </div>
                                    <p class="create-page-upload-note"><i class="fas fa-info-circle" aria-hidden="true"></i> الرجاء عدم رفع صور عليها شعار لتجنب رفض الإعلان.</p>

                                    <div
                                        class="dropzone mt-3 dz-message needsclick d-flex flex-wrap justify-content-center text-center containerimgs create-page-dropzone"
                                        id="container-imgs">
                                        <!-- image preview -->
                                        <div class="dz-message needsclick create-page-dropzone-message">
                                            <button type="button" class="upBtn create-page-upload-icon"
                                                    onclick="document.getElementById('image').click()"><i
                                                    class="fa fa-upload fa-7x"></i></button>


                                            <p class="mt-3 create-page-dropzone-title">اسحب الصور هنا أو اضغط للاختيار</p><small class="create-page-dropzone-hint">PNG أو JPG — بحد أقصى 8 صور</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="form-check mb-3 form-switch mt-3 create-page-endorsement">
                            <input required class="form-check-input" name="endorsement" type="checkbox" id="ekrar">
                            <label class="form-check-label create-page-endorsement-label" for="ekrar">
                                اقر اني مالك الوحدة وليس وسيط عقاري او سمسار وان جميع محتويات الاعلان صحيحة وعلى
                                مسؤوليتي
                            </label>
                        </div>

                        <!--    <input type="submit" class="btn btn-primary"  value="submit"/> -->

                        <div class="create-page-actions">
                            <a id="back-form-2" class="btn btn-light create-page-button create-page-button-secondary">
                                <i class="fas fa-arrow-right" aria-hidden="true"></i>
                                الرجوع
                            </a>
                            <input type="submit" value="انشر الإعلان" class="btn btn-primary create-page-button create-page-button-primary">
                        </div>
                    </form>

                </div>

                @if ($errors->any())
                    <div class="create-page-errors" role="alert">
                        <div class="create-page-errors-title">
                            <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                            <h3>يرجى مراجعة البيانات التالية</h3>
                        </div>
                        <ul class="create-page-errors-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
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

        .call-times-radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 18px;
            padding-top: 8px;
        }

        .call-time-option {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 0;
        }

        .call-time-option .form-check-input,
        .call-time-option .form-check-label {
            cursor: pointer;
        }

        .call-time-option input[type="radio"][name="call_id"] {
            position: static !important;
            float: none !important;
            opacity: 1 !important;
            visibility: visible !important;
            display: inline-block !important;
            width: 18px;
            height: 18px;
            margin: 0 !important;
            appearance: auto;
            -webkit-appearance: radio;
            accent-color: #0d6efd;
        }

        .call-time-option input[type="radio"][name="call_id"]:checked + .form-check-label {
            color: #0d6efd;
            font-weight: 700;
        }
    </style>

    <script>
        $(document).ready(function () {

            function fetchDistrictsByGovernorateId(governrateId) {
                if (!governrateId) return;

                // reset district selection
                $('#district_id').val('');
                $('#district_btn_text').text('جاري التحميل...');
                $('#district_results').html('<div class="gov-empty create-page-dropdown-empty">جاري التحميل...</div>');

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
                            $('#district_results').html('<div class="gov-empty create-page-dropdown-empty">لا توجد أحياء</div>');
                        }
                    },
                    error: function (xhr) {
                        console.log('fetch-states error:', xhr.status, xhr.responseText);
                        $('#district_btn_text').text('اختر');
                        $('#district_results').html('<div class="gov-empty create-page-dropdown-empty">خطأ في التحميل</div>');
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
                    $('#governrate_results').append('<div class="gov-empty create-page-dropdown-empty">لا توجد نتائج</div>');
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
                    $('#district_results').append('<div class="gov-empty create-page-dropdown-empty">لا توجد نتائج</div>');
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
            $("#total-area,#rooms,#baths,#total-price,#installment-time,#installment-value,#installment-date,#rent-value,#daily-rent").keypress(function (event) {
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


    <style>
        :root {
            --create-page-primary: #0879a6;
            --create-page-primary-dark: #075f83;
            --create-page-secondary: #34b56f;
            --create-page-secondary-dark: #249458;
            --create-page-ink: #17364a;
            --create-page-muted: #6f8593;
            --create-page-bg: #f4fafc;
            --create-page-surface: #ffffff;
            --create-page-border: #dceaf0;
            --create-page-danger: #dc3545;
            --create-page-shadow: 0 20px 55px rgba(20, 71, 96, 0.10);
            --create-page-radius-xl: 28px;
            --create-page-radius-lg: 20px;
            --create-page-radius-md: 14px;
        }

        .create-page {
            position: relative;
            min-height: 100vh;
            padding: 48px 0 80px;
            overflow: hidden;
            background:
                radial-gradient(circle at 8% 10%, rgba(52, 181, 111, .13), transparent 25%),
                radial-gradient(circle at 90% 18%, rgba(8, 121, 166, .13), transparent 30%),
                linear-gradient(180deg, #f8fcfd 0%, var(--create-page-bg) 100%);
            color: var(--create-page-ink);
        }

        .create-page,
        .create-page *,
        .create-page *::before,
        .create-page *::after {
            box-sizing: border-box;
        }

        .create-page::before,
        .create-page::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(2px);
        }

        .create-page::before {
            width: 260px;
            height: 260px;
            top: 130px;
            right: -130px;
            border: 42px solid rgba(8, 121, 166, .05);
        }

        .create-page::after {
            width: 210px;
            height: 210px;
            bottom: 140px;
            left: -105px;
            border: 34px solid rgba(52, 181, 111, .06);
        }

        .create-page-container {
            position: relative;
            z-index: 1;
            max-width: 1180px;
        }

        .create-page-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 250px;
            margin-bottom: 24px;
            padding: 42px 50px;
            overflow: hidden;
            border-radius: var(--create-page-radius-xl);
            color: #fff;
            background: linear-gradient(125deg, var(--create-page-primary-dark) 0%, var(--create-page-primary) 56%, #1196a8 100%);
            box-shadow: 0 26px 60px rgba(7, 95, 131, .22);
        }

        .create-page-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            opacity: .22;
            background-image:
                linear-gradient(rgba(255,255,255,.08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.08) 1px, transparent 1px);
            background-size: 32px 32px;
            mask-image: linear-gradient(to left, #000, transparent 78%);
        }

        .create-page-hero::after {
            content: '';
            position: absolute;
            width: 340px;
            height: 340px;
            top: -170px;
            left: -85px;
            border-radius: 50%;
            background: rgba(52, 181, 111, .45);
        }

        .create-page-hero-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .create-page-hero-label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 16px;
            padding: 8px 14px;
            border: 1px solid rgba(255,255,255,.24);
            border-radius: 999px;
            background: rgba(255,255,255,.12);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .3px;
            backdrop-filter: blur(10px);
        }

        .create-page-title {
            margin: 0 0 14px;
            color: #fff;
            font-size: clamp(28px, 4vw, 44px);
            font-weight: 800;
            line-height: 1.25;
        }

        .create-page-subtitle {
            max-width: 630px;
            margin: 0;
            color: rgba(255,255,255,.86);
            font-size: 16px;
            line-height: 1.9;
        }

        .create-page-hero-visual {
            position: relative;
            z-index: 2;
            display: grid;
            place-items: center;
            width: 170px;
            min-width: 170px;
            height: 170px;
        }

        .create-page-hero-circle {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,.28);
        }

        .create-page-hero-circle-large {
            inset: 0;
            animation: create-page-float 6s ease-in-out infinite;
        }

        .create-page-hero-circle-small {
            inset: 22px;
            border-width: 18px;
            border-color: rgba(255,255,255,.10);
        }

        .create-page-hero-icon {
            position: relative;
            z-index: 2;
            font-size: 58px;
            color: #fff;
            text-shadow: 0 16px 24px rgba(0,0,0,.14);
        }

        @keyframes create-page-float {
            0%, 100% { transform: translateY(0) rotate(0); }
            50% { transform: translateY(-8px) rotate(4deg); }
        }

        .create-page-steps {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 90px minmax(0, 1fr) 90px minmax(0, 1fr);
            align-items: center;
            margin-bottom: 24px;
            padding: 19px 24px;
            border: 1px solid rgba(8, 121, 166, .10);
            border-radius: var(--create-page-radius-lg);
            background: rgba(255,255,255,.9);
            box-shadow: 0 14px 35px rgba(20, 71, 96, .07);
            backdrop-filter: blur(12px);
        }

        .create-page-step {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            color: #8aa0ad;
            transition: color .25s ease, transform .25s ease;
        }

        .create-page-step-number {
            display: grid;
            place-items: center;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            border: 1px solid #dbe8ed;
            border-radius: 14px;
            background: #f6fafb;
            font-size: 15px;
            font-weight: 800;
            transition: all .25s ease;
        }

        .create-page-step-copy {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .create-page-step-copy strong {
            color: inherit;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
        }

        .create-page-step-copy small {
            margin-top: 2px;
            color: #9babb4;
            font-size: 11px;
            white-space: nowrap;
        }

        .create-page-step-line {
            height: 3px;
            border-radius: 999px;
            background: #e7f0f3;
            transition: background .25s ease;
        }

        .create-page-step-active,
        .create-page-step-complete {
            color: var(--create-page-primary);
        }

        .create-page-step-active {
            transform: translateY(-1px);
        }

        .create-page-step-active .create-page-step-number {
            border-color: transparent;
            color: #fff;
            background: linear-gradient(135deg, var(--create-page-primary), #0b91b7);
            box-shadow: 0 10px 22px rgba(8, 121, 166, .22);
        }

        .create-page-step-complete .create-page-step-number {
            border-color: rgba(52, 181, 111, .22);
            color: var(--create-page-secondary-dark);
            background: rgba(52, 181, 111, .12);
        }

        .create-page-step-line-complete {
            background: linear-gradient(90deg, var(--create-page-primary), var(--create-page-secondary));
        }

        .create-page-wizard {
            position: relative;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
        }

        .create-page-panel {
            width: 100% !important;
            margin: 0 !important;
            padding: 34px;
            border: 1px solid rgba(8, 121, 166, .10);
            border-radius: var(--create-page-radius-xl);
            background: var(--create-page-surface);
            box-shadow: var(--create-page-shadow);
        }

        .create-page-form {
            margin: 0;
        }

        .create-page-section-heading {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 26px;
        }

        .create-page-section-heading-spaced {
            margin-top: 10px;
        }

        .create-page-section-heading-compact {
            margin-bottom: 10px;
        }

        .create-page-section-icon {
            display: grid;
            place-items: center;
            width: 50px;
            height: 50px;
            flex: 0 0 50px;
            border-radius: 17px;
            color: #fff;
            background: linear-gradient(135deg, var(--create-page-primary), var(--create-page-secondary));
            box-shadow: 0 12px 24px rgba(8, 121, 166, .18);
        }

        .create-page-section-copy h3 {
            margin: 0;
            color: var(--create-page-ink);
            font-size: 21px;
            font-weight: 800;
        }

        .create-page-section-copy p {
            margin: 5px 0 0;
            color: var(--create-page-muted);
            font-size: 13px;
            line-height: 1.7;
        }

        .create-page-divider {
            height: 1px;
            margin: 32px 0;
            background: linear-gradient(90deg, transparent, var(--create-page-border), transparent);
        }

        .create-page .row {
            row-gap: 8px;
        }

        .create-page-form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .create-page-form-group > label,
        .create-page #call-times-label,
        .create-page [id$="-div"] .form-group > label {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            margin-bottom: 8px;
            color: #28495d;
            font-size: 13px;
            font-weight: 800;
        }

        .create-page .text-danger {
            font-weight: 700;
        }

        .create-page-control,
        .create-page .myselect,
        .create-page .myselect2 {
            width: 100%;
            min-height: 48px!important;
            padding: 11px 14px;
            border: 1px solid var(--create-page-border) !important;
            border-radius: var(--create-page-radius-md) !important;
            color: var(--create-page-ink);
            background-color: #fbfdfe !important;
            box-shadow: none !important;
            font-size: 14px;
            transition: border-color .2s ease, box-shadow .2s ease, background-color .2s ease, transform .2s ease;
        }

        .create-page-textarea,
        .create-page textarea.myselect2 {
            min-height: 145px;
            resize: vertical;
            line-height: 1.8;
        }

        .create-page-control:hover,
        .create-page .myselect:hover,
        .create-page .myselect2:hover {
            border-color: rgba(8, 121, 166, .36) !important;
            background: #fff !important;
        }

        .create-page-control:focus,
        .create-page .myselect:focus,
        .create-page .myselect2:focus {
            outline: none !important;
            border-color: var(--create-page-primary) !important;
            background: #fff !important;
            box-shadow: 0 0 0 4px rgba(8, 121, 166, .10) !important;
        }

        .create-page input:disabled,
        .create-page select:disabled {
            cursor: not-allowed;
            color: #748b98 !important;
            background: #f1f6f8 !important;
        }

        .create-page-field-note {
            display: block;
            margin-top: 8px;
            color: var(--create-page-muted);
            font-size: 11px;
            line-height: 1.7;
        }

        .create-page-field-note a {
            color: var(--create-page-primary);
            font-weight: 800;
            text-decoration: none;
        }

        .create-page-dropdown {
            position: relative;
        }

        .create-page-dropdown-button {
            display: flex !important;
            align-items: center;
            justify-content: space-between;
            text-align: right;
        }

        .create-page-dropdown-menu {
            top: calc(100% + 8px) !important;
            overflow: hidden;
            border: 1px solid var(--create-page-border) !important;
            border-radius: 16px !important;
            background: #fff !important;
            box-shadow: 0 18px 42px rgba(20, 71, 96, .15) !important;
        }

        .create-page-dropdown-search {
            min-height: 48px;
            padding: 12px 14px !important;
            border: 0 !important;
            border-bottom: 1px solid var(--create-page-border) !important;
            background: #fbfdfe;
        }

        .create-page-dropdown-search:focus {
            outline: none;
            background: #fff;
        }

        .create-page-dropdown-results {
            max-height: 260px;
        }

        .create-page-dropdown-item,
        .create-page .gov-item {
            padding: 12px 14px !important;
            border-bottom: 1px solid #eef4f6 !important;
            color: #315366;
            font-size: 13px;
            transition: background-color .2s ease, color .2s ease, padding .2s ease;
        }

        .create-page-dropdown-item:hover,
        .create-page .gov-item:hover {
            padding-right: 18px !important;
            color: var(--create-page-primary-dark);
            background: rgba(8, 121, 166, .07) !important;
        }

        .create-page-dropdown-empty,
        .create-page .gov-empty {
            padding: 14px !important;
            color: var(--create-page-muted) !important;
            text-align: center;
        }

        .create-page .gov-invalid {
            border-color: var(--create-page-danger) !important;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, .10) !important;
        }

        .create-page-call-times {
            display: grid !important;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px !important;
            padding-top: 0 !important;
        }

        .create-page-call-option {
            position: relative;
            display: flex !important;
            align-items: center;
            min-height: 48px;
            padding: 10px 12px;
            gap: 9px !important;
            border: 1px solid var(--create-page-border);
            border-radius: 13px;
            background: #fbfdfe;
            transition: all .2s ease;
        }

        .create-page-call-option:hover {
            border-color: rgba(8, 121, 166, .35);
            background: #fff;
        }

        .create-page-call-option input[type="radio"] {
            width: 18px !important;
            height: 18px !important;
            accent-color: var(--create-page-secondary) !important;
        }

        .create-page-call-option .form-check-label {
            margin: 0;
            color: #3d5969;
            font-size: 13px;
            font-weight: 700;
        }

        .create-page-call-option:has(input:checked) {
            border-color: rgba(52, 181, 111, .55);
            background: rgba(52, 181, 111, .08);
            box-shadow: 0 8px 18px rgba(52, 181, 111, .09);
        }

        .create-page-governorate-row {
            width: 100%;
            margin-inline: 0;
        }

        .create-page-features {
            width: 100%;
            margin-top: 24px !important;
            padding: 24px;
            border: 1px solid var(--create-page-border);
            border-radius: var(--create-page-radius-lg);
            background: linear-gradient(180deg, #fbfdfe, #f7fbfc);
        }

        .create-page-features .row {
            row-gap: 12px;
        }

        .create-page-features input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-left: 7px;
            accent-color: var(--create-page-secondary);
            cursor: pointer;
        }

        .create-page-features label {
            color: #3a586a;
            font-size: 13px;
            cursor: pointer;
        }

        .create-page-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 30px;
            padding-top: 24px;
            border-top: 1px solid #e8f0f3;
        }

        .create-page-actions-end {
            justify-content: flex-end;
        }

        .create-page-button {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-width: 145px;
            min-height: 48px;
            padding: 11px 22px !important;
            border-radius: 14px !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            text-decoration: none !important;
            cursor: pointer;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease, background-color .2s ease !important;
        }

        .create-page-button:hover {
            transform: translateY(-2px);
        }

        .create-page-button-primary {
            border: 0 !important;
            color: #fff !important;
            background: linear-gradient(135deg, var(--create-page-primary), var(--create-page-secondary)) !important;
            box-shadow: 0 13px 26px rgba(8, 121, 166, .20) !important;
        }

        .create-page-button-primary:hover {
            box-shadow: 0 16px 32px rgba(8, 121, 166, .28) !important;
        }

        .create-page-button-secondary {
            border: 1px solid var(--create-page-border) !important;
            color: #315467 !important;
            background: #fff !important;
            box-shadow: 0 8px 20px rgba(20, 71, 96, .06) !important;
        }

        .create-page-button-secondary:hover {
            border-color: rgba(8, 121, 166, .35) !important;
            color: var(--create-page-primary-dark) !important;
        }

        .create-page-upload-header {
            align-items: center;
            gap: 12px;
        }

        .create-page-upload-title-row {
            align-items: center;
            gap: 14px;
        }

        .create-page-upload-title {
            margin: 0;
            color: var(--create-page-ink);
            font-size: 18px;
            font-weight: 800;
        }

        .create-page-upload-button {
            min-width: 135px;
        }

        .create-page-upload-note {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 0 0;
            padding: 10px 12px;
            border-radius: 12px;
            color: #6c6470;
            background: #fff9e9;
            font-size: 12px;
        }

        .create-page-upload-note i {
            color: #dda51b;
        }

        .create-page-dropzone {
            min-height: 260px;
            padding: 26px !important;
            border: 2px dashed rgba(8, 121, 166, .30) !important;
            border-radius: var(--create-page-radius-lg) !important;
            background:
                radial-gradient(circle at center, rgba(52, 181, 111, .07), transparent 52%),
                #f8fcfd !important;
            transition: border-color .2s ease, background-color .2s ease, transform .2s ease;
        }

        .create-page-dropzone:hover {
            border-color: var(--create-page-secondary) !important;
            background-color: #fff !important;
            transform: translateY(-1px);
        }

        .create-page-dropzone-message {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 190px;
        }

        .create-page-upload-icon {
            display: grid !important;
            place-items: center;
            width: 76px;
            height: 76px;
            border: 0 !important;
            border-radius: 24px !important;
            color: var(--create-page-primary) !important;
            background: #fff !important;
            box-shadow: 0 16px 34px rgba(8, 121, 166, .13) !important;
            cursor: pointer;
            transition: transform .2s ease, color .2s ease;
        }

        .create-page-upload-icon:hover {
            color: var(--create-page-secondary-dark) !important;
            transform: translateY(-3px) rotate(-2deg);
        }

        .create-page-upload-icon .fa-7x {
            font-size: 28px !important;
        }

        .create-page-dropzone-title {
            margin-bottom: 4px;
            color: #28495d;
            font-size: 15px;
            font-weight: 800;
        }

        .create-page-dropzone-hint {
            color: var(--create-page-muted);
            font-size: 11px;
        }

        .create-page-endorsement {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-top: 24px !important;
            padding: 16px 18px;
            border: 1px solid rgba(52, 181, 111, .22);
            border-radius: 15px;
            background: rgba(52, 181, 111, .07);
        }

        .create-page-endorsement .form-check-input {
            width: 38px;
            min-width: 38px;
            height: 21px;
            margin: 2px 0 0 !important;
            accent-color: var(--create-page-secondary);
        }

        .create-page-endorsement-label {
            padding: 0 !important;
            color: #3b5a4b;
            font-size: 13px;
            line-height: 1.8;
            cursor: pointer;
        }

        .create-page-errors {
            margin-top: 24px;
            padding: 22px;
            border: 1px solid rgba(220, 53, 69, .18);
            border-radius: var(--create-page-radius-lg);
            background: #fff7f8;
        }

        .create-page-errors-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #b92d3b;
        }

        .create-page-errors-title h3 {
            margin: 0;
            font-size: 16px;
            font-weight: 800;
        }

        .create-page-errors-list {
            margin: 14px 0 0;
            padding-right: 22px;
            color: #8f3942;
            font-size: 13px;
            line-height: 1.9;
        }

        .create-page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(242, 249, 251, .88);
            backdrop-filter: blur(8px);
        }

        .create-page-loader.d-none {
            display: none !important;
        }

        .create-page-loader-card {
            width: min(100%, 390px);
            padding: 34px 28px;
            border: 1px solid rgba(8, 121, 166, .12);
            border-radius: 24px;
            text-align: center;
            background: #fff;
            box-shadow: 0 24px 60px rgba(20, 71, 96, .16);
        }

        .create-page-loader-spinner {
            display: inline-block;
            width: 58px;
            height: 58px;
            margin-bottom: 18px;
            border: 5px solid rgba(8, 121, 166, .13);
            border-top-color: var(--create-page-primary);
            border-right-color: var(--create-page-secondary);
            border-radius: 50%;
            animation: create-page-spin .8s linear infinite;
        }

        .create-page-loader-title {
            margin: 0 0 8px;
            color: var(--create-page-ink);
            font-size: 17px;
            font-weight: 800;
        }

        .create-page-loader-text {
            margin: 0;
            color: var(--create-page-muted);
            font-size: 13px;
            line-height: 1.8;
        }

        @keyframes create-page-spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 991.98px) {
            .create-page {
                padding-top: 28px;
            }

            .create-page-hero {
                min-height: 220px;
                padding: 34px;
            }

            .create-page-hero-visual {
                width: 130px;
                min-width: 130px;
                height: 130px;
            }

            .create-page-steps {
                grid-template-columns: 1fr 34px 1fr 34px 1fr;
                padding: 16px;
            }

            .create-page-step-copy small {
                display: none;
            }

            .create-page-panel {
                padding: 26px;
            }
        }

        @media (max-width: 767.98px) {
            .create-page {
                padding: 18px 0 55px;
            }

            .create-page-hero {
                min-height: auto;
                padding: 28px 24px;
                border-radius: 22px;
            }

            .create-page-hero-visual {
                display: none;
            }

            .create-page-title {
                font-size: 28px;
            }

            .create-page-subtitle {
                font-size: 14px;
            }

            .create-page-steps {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 8px;
                padding: 12px;
                overflow: hidden;
            }

            .create-page-step-line {
                display: none;
            }

            .create-page-step {
                flex-direction: column;
                justify-content: center;
                gap: 7px;
                text-align: center;
            }

            .create-page-step-number {
                width: 36px;
                height: 36px;
                flex-basis: 36px;
                border-radius: 12px;
            }

            .create-page-step-copy strong {
                font-size: 11px;
            }

            .create-page-panel {
                padding: 20px 16px;
                border-radius: 22px;
            }

            .create-page-section-heading {
                align-items: flex-start;
                margin-bottom: 20px;
            }

            .create-page-section-icon {
                width: 44px;
                height: 44px;
                flex-basis: 44px;
                border-radius: 15px;
            }

            .create-page-section-copy h3 {
                font-size: 18px;
            }

            .create-page-call-times {
                grid-template-columns: 1fr;
            }

            .create-page-features {
                padding: 18px 14px;
            }

            .create-page-actions {
                flex-direction: column-reverse;
            }

            .create-page-actions-end {
                align-items: stretch;
            }

            .create-page-button {
                width: 100%;
            }

            .create-page-upload-title-row {
                flex-direction: column;
                align-items: stretch;
            }

            .create-page-upload-button {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .create-page *,
            .create-page *::before,
            .create-page *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    <style>
        .create-page-validation-message {
            display: none;
            margin-top: 7px;
            padding: 8px 11px;
            border-radius: 8px;
            background: #fff3f3;
            color: #c62828;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.6;
        }

        .create-page-validation-message.is-visible {
            display: block;
        }

        .create-page-control.create-page-control-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, .12) !important;
        }
    </style>

    <script>
        (function () {
            function setupAdvertisementTextValidation() {
                var form = document.getElementById('form-1');
                var titleInput = document.getElementById('listing-name');
                var descriptionInput = document.getElementById('listing-desc');

                if (!form || !titleInput || !descriptionInput) return;

                var fields = [
                    {
                        element: titleInput,
                        messageElement: document.getElementById('listing-name-validation'),
                        label: 'عنوان الإعلان',
                        min: 40,
                        max: 250
                    },
                    {
                        element: descriptionInput,
                        messageElement: document.getElementById('listing-desc-validation'),
                        label: 'وصف الإعلان',
                        min: 50,
                        max: 1200
                    }
                ];

                function validateField(field, showMessage) {
                    var valueLength = field.element.value.trim().length;
                    var message = '';

                    if (valueLength === 0) {
                        message = field.label + ' مطلوب.';
                    } else if (valueLength < field.min) {
                        message = 'يجب ألا يقل ' + field.label + ' عن ' + field.min +
                            ' حرفًا. المتبقي ' + (field.min - valueLength) + ' حرف.';
                    } else if (valueLength > field.max) {
                        message = 'يجب ألا يزيد ' + field.label + ' عن ' + field.max +
                            ' حرفًا. احذف ' + (valueLength - field.max) + ' حرف.';
                    }

                    field.element.setCustomValidity(message);
                    field.element.classList.toggle('create-page-control-invalid', Boolean(message) && showMessage);

                    if (field.messageElement) {
                        field.messageElement.textContent = showMessage ? message : '';
                        field.messageElement.classList.toggle('is-visible', Boolean(message) && showMessage);
                    }

                    return !message;
                }

                fields.forEach(function (field) {
                    field.element.addEventListener('input', function () {
                        validateField(field, true);
                    });

                    field.element.addEventListener('blur', function () {
                        validateField(field, true);
                    });

                    field.element.addEventListener('invalid', function (event) {
                        event.preventDefault();
                        validateField(field, true);
                    });

                    if (field.element.value.trim().length > 0) {
                        validateField(field, true);
                    }
                });

                form.addEventListener('submit', function (event) {
                    var firstInvalidField = null;

                    fields.forEach(function (field) {
                        if (!validateField(field, true) && !firstInvalidField) {
                            firstInvalidField = field.element;
                        }
                    });

                    if (firstInvalidField) {
                        event.preventDefault();
                        firstInvalidField.focus();
                        firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            }

            function createPageSyncSteps() {
                var panels = [
                    document.querySelector('.content-1'),
                    document.querySelector('.content-2'),
                    document.querySelector('.content-3')
                ];
                var currentStep = 1;

                panels.forEach(function (panel, index) {
                    if (!panel) return;
                    var styles = window.getComputedStyle(panel);
                    var isVisible = styles.display !== 'none' && styles.visibility !== 'hidden';
                    if (isVisible) currentStep = index + 1;
                });

                var steps = document.querySelectorAll('[data-create-step]');
                var lines = document.querySelectorAll('.create-page-step-line');

                steps.forEach(function (step) {
                    var stepNumber = Number(step.getAttribute('data-create-step'));
                    step.classList.remove('create-page-step-active', 'create-page-step-complete');

                    if (stepNumber === currentStep) {
                        step.classList.add('create-page-step-active');
                    } else if (stepNumber < currentStep) {
                        step.classList.add('create-page-step-complete');
                    }
                });

                lines.forEach(function (line, index) {
                    line.classList.toggle('create-page-step-line-complete', index + 1 < currentStep);
                });
            }

            document.addEventListener('DOMContentLoaded', function () {
                setupAdvertisementTextValidation();
                createPageSyncSteps();

                var wizard = document.querySelector('.create-page-wizard');
                if (wizard && window.MutationObserver) {
                    new MutationObserver(createPageSyncSteps).observe(wizard, {
                        attributes: true,
                        subtree: true,
                        attributeFilter: ['style', 'class']
                    });
                }

                ['form-1', 'form-2', 'form-3', 'back-form-1', 'back-form-2'].forEach(function (id) {
                    var element = document.getElementById(id);
                    if (!element) return;
                    element.addEventListener('click', function () {
                        window.setTimeout(createPageSyncSteps, 80);
                    });
                    element.addEventListener('submit', function () {
                        window.setTimeout(createPageSyncSteps, 80);
                    });
                });
            });
        })();
    </script>

    {{-- Google Maps for property location --}}
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key', '') }}&callback=Function.prototype" async defer></script>
    <script>
        (function waitForLibs() {
            if (typeof window.jQuery === 'undefined' || typeof google === 'undefined' || typeof google.maps === 'undefined') {
                return setTimeout(waitForLibs, 150);
            }

            jQuery(function($) {
                var mapEl = document.getElementById('frontPropertyMap');
                if (!mapEl) return;

                var GOV_COORDS_URL = "{{ route('api.map.govCoords') }}";
                var defaultLat = 30.0444, defaultLng = 31.2357;

                var map = new google.maps.Map(mapEl, {
                    center: { lat: defaultLat, lng: defaultLng },
                    zoom: 7,
                    mapTypeControl: true,
                    streetViewControl: false,
                    fullscreenControl: true
                });

                var marker = null;

                function placeMarker(lat, lng, animate) {
                    if (marker) marker.setMap(null);
                    marker = new google.maps.Marker({
                        position: { lat: lat, lng: lng },
                        map: map,
                        draggable: true,
                        animation: animate ? google.maps.Animation.DROP : null
                    });
                    marker.addListener('dragend', function(e) {
                        $('#location_lat').val(e.latLng.lat().toFixed(8));
                        $('#location_lon').val(e.latLng.lng().toFixed(8));
                    });
                }

                // Click on map to set location
                map.addListener('click', function(e) {
                    var lat = e.latLng.lat().toFixed(8);
                    var lng = e.latLng.lng().toFixed(8);
                    $('#location_lat').val(lat);
                    $('#location_lon').val(lng);
                    placeMarker(parseFloat(lat), parseFloat(lng), true);
                });

                // Clear button
                $('#clearCoordsBtn').on('click', function() {
                    $('#location_lat').val('');
                    $('#location_lon').val('');
                    if (marker) { marker.setMap(null); marker = null; }
                });

                // Manual input change
                $('#location_lat, #location_lon').on('change', function() {
                    var lat = parseFloat($('#location_lat').val());
                    var lon = parseFloat($('#location_lon').val());
                    if (!isNaN(lat) && !isNaN(lon) && lat >= -90 && lat <= 90 && lon >= -180 && lon <= 180) {
                        placeMarker(lat, lon, true);
                        map.setCenter({ lat: lat, lng: lon });
                        map.setZoom(15);
                    }
                });

                // When governorate changes → auto-center map to governorate location
                $(document).on('change', 'input[name="governrate_id"]', function() {
                    var govId = $(this).val();
                    if (!govId) return;

                    // Only auto-center if user hasn't manually set coords
                    if ($('#location_lat').val() && $('#location_lon').val()) return;

                    $.get(GOV_COORDS_URL, { governrate_id: govId }, function(res) {
                        if (res.success && res.data) {
                            var lat = res.data.lat;
                            var lon = res.data.lon;
                            map.setCenter({ lat: lat, lng: lon });
                            map.setZoom(12);
                            placeMarker(lat, lon, true);
                            $('#location_lat').val(lat);
                            $('#location_lon').val(lon);
                        }
                    });
                });

                // Also listen for the hidden input that stores governrate_id
                // (the custom governorate picker uses a hidden input)
                var govObserver = new MutationObserver(function(mutations) {
                    mutations.forEach(function(m) {
                        if (m.type === 'attributes' && m.attributeName === 'value') {
                            var govId = m.target.value;
                            if (!govId || ($('#location_lat').val() && $('#location_lon').val())) return;
                            $.get(GOV_COORDS_URL, { governrate_id: govId }, function(res) {
                                if (res.success && res.data) {
                                    map.setCenter({ lat: res.data.lat, lng: res.data.lon });
                                    map.setZoom(12);
                                    placeMarker(res.data.lat, res.data.lon, true);
                                    $('#location_lat').val(res.data.lat);
                                    $('#location_lon').val(res.data.lon);
                                }
                            });
                        }
                    });
                });
                var govInput = document.querySelector('input[name="governrate_id"]');
                if (govInput) {
                    govObserver.observe(govInput, { attributes: true });
                }

                // If old values exist (validation redirect)
                var oldLat = parseFloat($('#location_lat').val());
                var oldLon = parseFloat($('#location_lon').val());
                if (!isNaN(oldLat) && !isNaN(oldLon) && oldLat !== 0 && oldLon !== 0) {
                    placeMarker(oldLat, oldLon, false);
                    map.setCenter({ lat: oldLat, lng: oldLon });
                    map.setZoom(15);
                }
            });
        })();
    </script>


</x-layout>
