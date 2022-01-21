<x-layout>
  
    
    @section('title')
    تعديل الاعلان | {{ $aqar->title }}
    @endsection
    <link href="{{ asset('assets/css/img-upload.css') }}" rel="stylesheet">


    <div class="container editpage">
        <form action="{{ URL::to('updated-aqar/' . $aqar->id) }}" method ="POST" enctype ="multipart/form-data">
            @csrf
     <input type="hidden"  name="status" value=0>

            <section>
                <h3>تعديل تصنيف العقار و الموقع</h3>
    
   
                <div class="row mt-3" style="align-content: start;
                justify-content: start;">
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label for="li-cat">تصنيف العرض</label>
                            <select     name="category" id="li-cat" class="myselect">
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $aqar->category == $cat->id ? 'selected' : '' }}>{{ $cat->category_name }}</option>
    
                                @endforeach
                            </select>
    
                            @error('category')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                            @enderror
    
                        </div>
                    </div>
                       <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="Property-type">نوع العقار</label>
                                    <select disabled  name="property_type" id="Property-type" class="myselect">
                                         @foreach ($properties as $pop)
                                             <option value="{{ $pop->id }}" {{ $aqar->property_type == $pop->id ? 'selected' : '' }}>{{ $pop->property_type }}</option>
    
                                           @endforeach
                                    </select>

                                    @error('property_type')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror

                                </div>
                            </div>
                            
                                  
                               <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="li-compound">الكومبوند (اختياري)</label>
                                       <?php
                                    
                                       if (!isset($aqar->compound)) {     ?>
                                       
                        <input         value=""  type="text" list="li-compound" name="compound" class="myselect"  />
                                                        <?php  }  ?>
                                     
                                        @foreach ($compounds as $com)
                                       <?php
                                    
                                       if (isset($aqar->compound)) { if( $aqar->compound ==   $com->id ){      ?>	
                                       
                                           <input         value="{{ $com->compound }}"  type="text" list="li-compound" name="compound" class="myselect"  />
                                           
                                           <?php }}  ?>
                                    
                                    
                                  
                                        </option>
                                        @endforeach
                                        
                                        
                                
                                    <datalist id="li-compound">
                                        @foreach ($compounds as $com)
                                        <option      <?php if (isset($aqar->compound)) { if( $aqar->compound ==   $com->id ){    echo'selected = selected' ;} }?>	
                                        value="{{ $com->compound }}"  > 
                                        
                                        {{ $com->compound }}
                                  
                                        </option>
                                        @endforeach
                                    </datalist>
                                    @error('compound')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            
                  
                    <div class="form-group">
                        <label for="">الموقع</label>
                        <div class="row" style="align-content: start;
                        justify-content: start;">
                            <div class="col-lg-4">
                                <select    name="governrate_id" id="country" class="myselect">
                                    @foreach ($governrate as $loc)
                                        <option value="{{ $loc->id }}" {{ $aqar->governrate_id == $loc->id ? 'selected' : '' }}>{{ $loc->governrate }}</option>
    
                                    @endforeach
                                </select>
    
                                @error('governrate_id')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
    
                            <div class="col-lg-4">
                                <select    name="district_id" id="area_input" class="myselect">
                               <option  >اختر    </option>

                               @foreach ($district as $dis)
                              <option value="{{ $dis->id }}" {{ $aqar->district_id == $dis->id ? 'selected' : '' }}>
                                   {{ $dis->district }}
                                   </option>
                                      @endforeach
                                </select>
                                @error('district_id')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
    
    
       
                               <div class="col-lg-3">
                                <div class="form-group">
                                         @foreach ($areas as $areas_val)
                                       <?php
                                       
                                       
                                 //    dd($areas_val->area  );
                                       
                                       
                                       if (isset($aqar->area_id)) { if( $aqar->area_id ==   $areas_val->id ){      ?>	
                                       
                                           <input       id="area"    value="{{ $areas_val->area }}"  type="text" list="li-area" name="area_id" class="myselect"  />
                                           
                                           <?php }}  ?>
                                    
                                    
                                  
                                        </option>
                                        @endforeach
                                        
                                        
                                
                                    <datalist id="li-area">
                                        @foreach ($areas as $areas_val)
                                        <option      <?php if (isset($aqar->area_id)) { if( $aqar->area_id ==   $areas_val->id ){    echo'selected = selected' ;} }?>	
                                        value="{{ $areas_val->area }}"  > 
                                        
                                        {{ $areas_val->area }}
                                  
                                        </option>
                                        @endforeach
                                    </datalist>
                                  
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-lg-4">
    
    
                               
    
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h3>التفاصيل</h3>
                    <div class="form-group">
                        <label for="listing-name">اسم الاعلان</label>
                        <input placeholder="عقار بالتجمع الخامس"  type="text" name="title"
                        maxlength="55" id="listing-name" class="myselect" value="{{ $aqar->title }}">
                        @error('title')
                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="listing-desc">وصف الاعلان</label>
                        <textarea maxlength="5000" placeholder="اوصق اعلانك"  name="description" id="listing-desc"
                            cols="30" class="myselect2" rows="5">{{ $aqar->description }}</textarea>
                        @error('description')
                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                        @enderror
                    </div>

                     <!-- offer type -->
                            <div class="col-lg-4" >
                                <div class="form-group">
                                    <label for="offer-type">نوع العرض</label>
                                    <select    class="myselect" name="offer_type" id="offer-type">
                                        <option value="">اختر نوع العرض</option>
              
                                        @foreach ($offerTypes as $item)
                                            @if ($item->id != 5)
                                            <?php  if($aqar->offer_type == $item->id) {  ?>
                                                <option value="{{ $item->id }}" {{ $aqar->offer_type == $item->id ? 'selected' : '' }}>{{ $item->type_offer }}
                                                </option>
                                            <?php   }  ?>

                                            @endif
                                        @endforeach
                                    </select>
                                    @error('offer_type')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
    
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="call-times">الاوقات المتاحه للاتصال</label>
                            <Select  class="myselect" name="call_id">
    
                                @foreach ($calls as $call)
                                    <option value="{{ $call->id }}" {{ $aqar->call_id == $call->id ? 'selected' : '' }}>{{ $call->call_time }}</option>
                                @endforeach
    
    
                            </Select>
                            @error('call_id')
                                <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                            @enderror
    
    
                        </div>
                    </div>
                        <!-- total area -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="total-area">اجمالي المساحه</label>
                                <input  type="number" class="myselect" placeholder="المساحه" min="0"
                                    name="total_area" id="total-area" value="{{ $aqar->total_area }}">
                                @error('total_area')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>
                         <!-- finish type -->
                         <div class="col-lg-4" id="finish-type-div">
                            <div class="form-group">
                                <label for="finish-type">التشطيب</label>
                                <select  class="myselect" name="finishtype" id="finish-type">
                                    @foreach ($finishes as $finish)
                                        <option value="{{ $finish->id }}" {{ $aqar->finishtype == $finish->id ? 'selected' : '' }}>{{ $finish->finish_type }}
                                        </option>

                                    @endforeach
                                </select>
                                @error('finishtype')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>
                        </div>


                            @if ($prop == 9)
                                
                            <div class="col-lg-3" id="license-type-div">
                                <div class="form-group">
                                    <label for="license-type">نوع الترخيص</label>
                                    <select name="license_type" class="myselect" id="license-type">
                                        @foreach ($lic_types as $lic)
                                            <option value="{{ $lic->id }}" {{ $aqar->license_type    == $lic->id ? 'selected' : '' }}>{{ $lic->license_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('license_type')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            @if ( $prop == 7 || $prop == 22 || $prop == 23 )
                            <div class="col-lg-3" id="floors-div">
                                <div class="form-group">
                                    <label for="floors">عدد الطوابق</label>
                                    <input type="number" class="myselect" placeholder="عدد الطوابق" min="0"
                                        name="number_of_floors"  id="floors" value="{{ $aqar->number_of_floors }}">
                                </div>
                                @error('number_of_floors')
                                    <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                @enderror
                            </div>


                            @endif
                            <?php // dd($aqar->category); ?>
                            @if ( $aqar->category ==1 )
                                 <!-- floor and property inners -->
                            <div id="inner-floor" class="row" style="align-content: start;
                            justify-content: start;">

                                <!-- rooms -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="rooms">عدد الغرف</label>
                                        <input type="number" class="myselect" placeholder="عدد الغرف" min="0" name="rooms"
                                             id="rooms" value="{{ $aqar->rooms }}">
                                        @error('rooms')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- bathrooms -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="baths">عدد الحمامات</label>
                                        <input type="number" class="myselect" placeholder="عدد الحمامات" min="0" name="baths"
                                             id="baths" value="{{ $aqar->baths }}">
                                        @error('baths')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                    <!-- floor number -->
                            <div class="col-lg-3" id="floor-div">
                                <div class="form-group">
                                    <label for="floor-number">الدور</label>
                                    <select name="floor" id="floor-number" class="myselect">
                                        <option value="">اختر</option>
                                        @foreach ($floors as $floor)
                                            <option value="{{ $floor->id }}" {{ $aqar->floor    == $floor->id ? 'selected' : '' }}>{{ $floor->floor }}</option>
                                        @endforeach
                                    </select>
                                    @error('floor')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                            @endif

                            @if ($type == 1 || $type == 2)
                                      <!-- total-price -->
                            <div class="col-lg-3" id="total-price-div">
                                <div class="form-group">
                                    <label for="total-price">السعر الاجمالي</label>
                                    <input type="number" name="total_price" id="total-price" class="myselect"
                                        placeholder="السعر الاجمالي" min="0" value="{{ $aqar->total_price }}">
                                    @error('total_price')
                                        <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                    @enderror
                                </div>
                            </div>
                             <!-- boolean row -->
                             <div id="boolean-row" class="row" style="align-content: start;
                             justify-content: start;">
                               
                                 <!-- bank-finance -->
                                 <div class="col-lg-4">
                                     <div class="form-group">
                                         <label for="bank-finance">تصلح تمويل عقاري</label>
                                         <select name="finannce_bank" id="bank-finance" class="myselect">
                                             <option value="">اختر</option>
                                             <option value="1" {{ $aqar->finannce_bank    == '1' ? 'selected' : '' }}>نعم</option>
                                             <option value="0" {{ $aqar->finannce_bank    == '0' ? 'selected' : '' }}>كلا</option>
                                         </select>
                                         @error('finannce_bank')
                                             <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                         @enderror
                                     </div>
                                 </div>
 
                                   <!-- trade -->
                                 <div class="col-lg-4">
                                     <div class="form-group">
                                         <label for="trade">تصلح للبدل</label>
                                         <select name="trade" id="trade" class="myselect">
                                             <option value="">اختر</option>
                                             <option value="1" {{ $aqar->trade    == '1' ? 'selected' : '' }}>نعم</option>
                                             <option value="0" {{ $aqar->trade    == '0' ? 'selected' : '' }}>كلا</option>
                                         </select>
                                         @error('trade')
                                             <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                         @enderror
                                     </div>
                                 </div>
                                 <!-- signed -->
                                 <div class="col-lg-4">
                                     <div class="form-group">
                                         <label for="signed">مسجله شعر عقاري</label>
                                         <select name="licensed" id="signed" class="myselect">
                                             <option value="">اختر</option>
                                             <option value="1" {{ $aqar->licensed    == '1' ? 'selected' : '' }}>نعم</option>
                                             <option value="0" {{ $aqar->licensed    == '0' ? 'selected' : '' }}>كلا</option>
                                         </select>
                                         @error('licensed')
                                             <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                         @enderror
                                     </div>
                                 </div>
                             </div>
                            @endif

                            @if ($type == 3 || $type == 4)
                            <div class="row" id="rent-div" style="align-content: start;
                            justify-content: start;">
                                <!-- rent-value -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="rent-value">الايجار الشهري</label>
                                        <input type="number" name="monthly_rent" id="rent-value" class="myselect"
                                            placeholder="الايجار" min="0" value="{{  $aqar->monthly_rent }}">
                                        @error('monthly_rent')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            @endif
                            @if ($type == 2)
                                      <!-- installment row -->
                            <div id="installment-div" class="row" style="align-content: start;
                            justify-content: start;">
                                <!-- mtr price -->
                               <!-- <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="mtr-price">سعر المتر</label>
                                        <input type="number" name="mtr_price" id="mtr-price" class="myselect"
                                            placeholder="500 L.E" min="0" value="{{ old('mtr_price') }}">
                                        @error('mtr_price')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>-->
                                <!-- down payment -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="down-payment">المقدم</label>
                                        <input type="number" name="downpayment" id="down-payment" class="myselect"
                                            placeholder="المقدم" value="{{ $aqar->downpayment }}">
                                        @error('downpayment')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- installment length -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="installment-time">مده الاقساط</label>
                                        <input type="number" name="installment_time" id="installment-time"
                                            class="myselect" placeholder="مده الاقساط بالاشهر" min="0" value="{{ $aqar->installment_time  }}">
                                        @error('installment_time')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- installment value -->
                              <!--  <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="installment-value">قيمه القسط</label>
                                        <input type="number" name="installment_value" id="installment-value"
                                            class="myselect" placeholder="5000 L.E شهريا" min="0">
                                        @error('installment_value')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div> -->
                                <!-- installment time to recive -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="reciving">الاستلام</label>
                                        <select name="reciving" id="reciving" class="myselect">
                                            <option value="">اختر</option>
                                            <option value="1" {{ $aqar->reciving    == '1' ? 'selected' : '' }}>فوري</option>
                                            <option value="0" {{ $aqar->reciving    == '0' ? 'selected' : '' }}>غير فوري</option>
                                        </select>
                                        @error('reciving')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>
                                <!-- installment time  -->
                                <div class="col-lg-3" id="installment-date-div">
                                    <div class="form-group">
                                        <label for="installment-date">الاستلام</label>
                                        <input placeholder="سنه الاستلام" type="text" name="rec_time" id="installment-date" class="myselect" value="{{ $aqar->installment }}">
                                        @error('installment')
                                            <p class="text-danger text-sm mt-1"> {{ $message }} </p>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            @endif
                            <h3>المزايا</h3>
                            <br>
                            <div class="row" style="align-items:start; text-align:right; justify-content:right;">
                                @foreach ($mzaya as $maz) 

                                

                                    
                                <div class="col-lg-2">
                                      <input @foreach ($aqar->mzayaAqar as $item)  @if ($item->mzaya_id ==  $maz->id ) checked @endif @endforeach type="checkbox" name="mzaya[]" value="{{$maz->id}}">
                                      <label for="mzaya[]">{{ $maz->mzaya_type }}</label><br>
                                </div> 
                                
                                @endforeach

                            <h3>الصور</h3>

                            <div class="dropzone mt-3 dz-message needsclick d-flex flex-wrap justify-content-center text-center containerimgs2"
                            id="container-imgs2">
                            @if ($aqar->images)

                            @foreach(  $aqar->images  as  $images_url)
                            <ul style="padding:10px !important;"  >

                                <li>
            
                                <div  id="main_contener<?php echo$images_url->id; ?>" style="<?php if($images_url->main_img){ echo'border: solid #dc3545 4px;'; } else { echo'border:solid black 2px;'; }  ?>" 
                                class="image_container d-flex justify-content-center position-relative">
            
            
            
                                    <img  src="{{ URL::to('/').'/images/'.$images_url->img_url}}" class="img-thumbnail">
            
            
            
            
                                       
            
                                 </div> 
                                 
                                 </li>
                                 <a href="{{ URL::to('/').'/remove-image/'.$images_url->id}}">
                                <li><button class="btn btn-danger" type="button" onclick="">   مسح الصوره</button></li></a>
                                <li><button class="btn btn-primary" type="button" 
                                onclick="ajx_main_img_edit_only( <?php  echo $images_url->aqar_id; ?> , <?php  echo $images_url->id; ?> )"> جعلها رئيسيه  </button></li></a>
            
                         
            
                            </ul>

                      
                           @endforeach

                            @endif
                </div>


 <hr class="mt-5">
<div id="result3" style="display:none;">
    <input name="main_img" id="mainImg" /></div>
    
    <?php  
    
     if($aqar->images->count()<8)  { ?>
                        <div class="form-group">
                            <div class="mt-3 w-100">
                              
                                <div class="w-100 ">
                                    <div class="d-flex justify-content-between">
                                      
                                      
                                      <div class="d-flex w-100 justify-content-between">
                                          
<h4>اضف الصور بحد اقصى 8  صور</h4>
<button id="needsclickBtn" type="button" class="btn btn-primary" onclick="document.getElementById('image').click();">اختر الصور</button>
                                      
                                      </div>
                                        <br>
                                        <input accept="image/*" type="file" name="photos_id[]" id="image" multiple class="d-none"
                                            onchange="image_select(this.files)">
                                    
                                    </div>
                                    <div class="dropzone mt-3 dz-message needsclick d-flex flex-wrap justify-content-center text-center containerimgs"
                                        id="container-imgs">
                                        <!-- image preview -->
                                        <div  class="dz-message needsclick">
                                            <br>
                                          <button type="button" class="upBtn" onclick="document.getElementById('image').click()">  <i  class="fa fa-upload fa-7x"></i></button>
                                      
                                          
                                          <p class="mt-3">upload images here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
    <?php }
        
        ?>

                      

                        <!--    <input type="submit" class="btn btn-primary"  value="submit"/> -->

                        <div>
                            <input type="submit" value="انشر الاعلان" class="btn btn-primary">
                        </div>
                   

            </div>
            </section>
    
        
        
        </form>
    </div>
    






    <script src="{{ asset('assets/js/img-upload.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    <script>
        $(document).ready(function() {
            $('#country').on('change', function() {
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
                    success: function(result) {
                        $('#area_input').html('<option value="">Select State</option>');
                        $.each(result.states, function(key, value) {
                            $("#area_input").append('<option value="' + value
                                .id + '">' + value.district + '</option>');
                        });
                    }
                });
            });

        });

function ajx_main_img_edit_only (aqar_id, img_id) {
//alert("fgfdg");
$.ajax({
 type: "POST",
 url: "{{ url('ajx_main_img_edit_only') }}",
 data: {
_token: '{{ csrf_token() }}',
aqar_id: aqar_id,
img_id: img_id
     
 },
 success: function(data){
     document.getElementById("main_contener"+img_id).style = "border: solid #dc3545 4px;";


 console.log(data);
 },
 error: function(xhr, status, error){
 console.error(xhr);
 }
});

}
        
    </script>

</x-layout>