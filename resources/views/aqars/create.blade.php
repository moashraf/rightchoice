<x-layout>
    
        
    @section('title')
    اضف اعلان
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
       <img width="80px" height="80px"  src="http://cdnjs.cloudflare.com/ajax/libs/semantic-ui/0.16.1/images/loader-large.gif" alt="processing..." />
<h6 class="fw-bolder text-dark mt-5">  بعض الصور حجمها كبير قد يتسغرق رفعها 40   ثانيه (جاري التحميل)</h6>

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
  oninput="this.setCustomValidity('')" required name="category" id="li-cat" class="myselect">
                                        <option selected disabled   value="">اختر</option>
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
  oninput="this.setCustomValidity('')" required name="property_type" id="Property-type" class="myselect">
                                        <option  selected disabled   value="">اختر نوع العقار</option>

                                    </select>

                                    @error('property_type')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="li-compound">اسم الكومبوند   (اختياري)</label>
                                    <input type="text" list="li-compound" name="compound" class="myselect"
                                        value="{{ old('compound') }}" />
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
                               
                                <div class="row" style="align-content: start;
                                justify-content: start;">
                                    <div class="col-lg-4">
                                         <label for="">المحافظه <span class="text-danger">*</span></label>
                                        <select oninvalid="this.setCustomValidity('{{ trans('validation.country')}}')"
  oninput="this.setCustomValidity('')" required name="governrate_id" id="country" class="myselect">
                                            <option selected disabled   selected="true" value >اختر</option>
                                            @foreach ($governrate as $loc)
                                            <option value="{{ $loc->id }}"
                                                {{ old('governrate_id') == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->governrate }}</option>

                                            @endforeach
                                        </select>

                                        @error('governrate_id')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>

                                    <div class="col-lg-4">
                                         <label for="">الحي <span class="text-danger">*</span></label>
                                        <select oninvalid="this.setCustomValidity('{{ trans('validation.areaError')}}')"
  oninput="this.setCustomValidity('')" required name="district_id" id="area_input" class="myselect">
                                            <option  selected disabled  value="">اختر</option>


                                        </select>
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
  oninput="this.setCustomValidity('')" placeholder="" required type="text" name="title"
                                  minlength="3"  maxlength="55" id="listing-name" class="myselect" value="{{ old('title') }}">
                                @error('title')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="listing-desc"> وصف تفصيلي للاعلان <span class="text-danger">*</span></label>
                                <textarea oninvalid="this.setCustomValidity('{{ trans('validation.descError')}}')"
  oninput="this.setCustomValidity('')" maxlength="5000" minlength="10" placeholder="" required="required" name="description"
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
  oninput="this.setCustomValidity('')" disabled type="tel" name="phone" id="phone"
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
  oninput="this.setCustomValidity('')" required class="myselect" name="call_id">
                                        <option  selected disabled  value="">اختر الوقت المناسب</option>

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

                        <input type="submit" class="btn our-btn" value="اكمل">
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
  oninput="this.setCustomValidity('')" required class="myselect" name="offer_type" id="offer-type">
                                        <option   selected disabled  value="">اختر نوع العرض</option>

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
  oninput="this.setCustomValidity('')" required type="number" class="myselect" placeholder="" min="0"
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
  oninput="this.setCustomValidity('')" class="myselect" name="finishtype" id="finish-type">
                                        <option  selected disabled   value="">اختر نوع التشطيب</option>
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
  oninput="this.setCustomValidity('')" type="number" class="myselect" placeholder="" min="0"
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
  oninput="this.setCustomValidity('')" name="license_type" class="myselect" id="license-type">
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
  oninput="this.setCustomValidity('')" name="floor" id="floor-number" class="myselect">
                                        <option  selected disabled  value="">اختر</option>
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
  oninput="this.setCustomValidity('')" type="number" class="myselect" placeholder="" min="0"
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
  oninput="this.setCustomValidity('')" type="number" class="myselect" placeholder="" min="0"
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
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
                         oninput="this.setCustomValidity('')" name="finannce_bank" id="bank-finance" class="myselect">
                                            <option  selected disabled   value="">اختر</option>
                                            <option  value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>
                                     
                                    </div>
                                </div>

                                <!-- trade -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="trade">تصلح للبدل <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احدى الاختيارات')"
  oninput="this.setCustomValidity('')" name="trade" id="trade" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم</option>
                                            <option value="0">كلا</option>
                                        </select>
                                     
                                    </div>
                                </div>
                                <!-- signed -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="signed">مسجله شهر عقاري <span class="text-danger">*</span></label>
                                        <select required oninvalid="this.setCustomValidity('من فضلك اختر احد الاختيارات')"
  oninput="this.setCustomValidity('')" name="licensed" id="signed" class="myselect">
                                            <option   selected disabled  value="">اختر</option>
                                            <option value="1" >نعم
                                            </option>
                                            <option value="0" >كلا
                                            </option>
                                        </select>
                                       
                                    </div>
                                </div>
                            </div>
	     <div class="col-lg-3" id="total-price-div">
                                <div class="form-group">
                                    <label for="total-price">السعر الاجمالي <span class="text-danger">*</span></label>
                                    <input required  oninvalid="this.setCustomValidity('من فضلك ادخل السعر الاجمالي ')"
  oninput="this.setCustomValidity('')" type="number" name="total_price" id="total-price" class="myselect"
                                        placeholder="" min="50">
                                   
                                </div>
                            </div>`
                            </div>
                            
                            <div class="mt-3 mb-3" id="mzaya-div">
                                <h3>المزايا</h3>
                                <small>يمكن اختيار اكثر من ميزه بالضغط عليها</small>

                                <br>
                                <br>
                                <div class="row" style="align-items:start !important;align-content: start !important;justify-content: start !important;">
                                    <div class="col-lg-12">
                                        <input type="checkbox" onClick="toggle(this)" /> 
                                        <label for="mzaya[]">بالضغط على المربع يتم اختيار جميع المزايا</label><br>
                                    </div> 
                                    @foreach ($mzaya as $maz)
                                    <div class="col-lg-2">
                                        <input type="checkbox" name="mzaya[]" value="{{$maz->id}}">
                                        <label for="mzaya[]">{{ $maz->mzaya_type }}</label><br>
                                    </div> @endforeach
                                    
                                  <script language="JavaScript">
                               function toggle(source) {
                                  checkboxes = document.getElementsByName('mzaya[]');
                                  for(var i=0, n=checkboxes.length;i<n;i++) {
                                    checkboxes[i].checked = source.checked;
                                  }
}
                                    </script>
                                    
                                    </div>

                            </div>




                        </div>




                        <input type="submit" value="اضف اعلان" class="btn our-btn" />
                        <button id="back-form-1" class="btn btn-light">الرجوع</button>
                    </form>
                </div>
                <div class="content-3">


                    <form method="POST" action="{{ route('aqars.upload') }}" id="form-3" files="true"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div id="result-form-1" style="display:none;"></div>
                        <div id="result-form-2" style="display:none;"></div>
                        <div id="result3" style="display:none;"><input name="main_img" id="mainImg" /></div>
                        <div class="form-group">
                            <!-- <input type="file"   name="photos_id[]" multiple> -->
                            <div class="mt-3 w-100">

                                <div class="w-100 ">
                                    <div class="d-flex justify-content-between">

                                        <div class="d-flex w-100 justify-content-between">

                                            <h4>
اضف الصور بحد اقصى  8  صور
                                                </h4>
                                            <button id="needsclickBtn" type="button" class="btn btn-primary"
                                                onclick="document.getElementById('image').click();">اختر الصور</button>

                                        </div>
                                        <br>
                                        <input  accept="image/png , image/jpeg, image/jpg"  type="file" name="photos_id[]" id="image" multiple
                                            class="d-none" onchange="image_select(this.files)">

                                    </div>
                                                                            <p>الرجاء عدم وضع صور عليها لوجو منعا لرفض الإعلان</p>

                                    <div class="dropzone mt-3 dz-message needsclick d-flex flex-wrap justify-content-center text-center containerimgs"
                                        id="container-imgs">
                                        <!-- image preview -->
                                        <div class="dz-message needsclick">
                                            <br>
                                            <button type="button" class="upBtn"
                                                onclick="document.getElementById('image').click()"> <i
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
                                اقر اني مالك الوحدة وليس وسيط عقاري او سمسار وان جميع محتويات الاعلان صحيحة وعلى مسؤوليتي
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


    <x-call-to-action />




    
    
    
    
    
     <?php  if (  App::getLocale()== 'en' )
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        $(document).ready(function () {
            $('#country').on('change', function () {
                var idCountry = this.value;
                $("#area_input").html('');
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#area_input').html(
                            '<option value=""  >الحى</option>');
                        $.each(result.states, function (key, value) {
                            $("#area_input").append('<option value="' + value
                                .id + '">' + value.district + '</option>');
                        });
                    }
                });
            });

        });
        
        
        
        
        
        $(function(){
             
    $("#total-area,#rooms,#baths,#total-price,#installment-time,#installment-value,#installment-date,#rent-value").keypress(function(event){
        var ew = event.which;
        if(ew == 32)
            return true;
        if(48 <= ew && ew <= 57)
            return true;
        if(65 <= ew && ew <= 90)
            return true;
        if(97 <= ew && ew <= 122)
            return true;
        return false;
    });
});






    </script>

</x-layout>