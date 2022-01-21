<x-layout>

    @section('title')
    اضف شركه
    @endsection

    <section id="register" class="bg-light">

        <div class="container">


            <div class="row">
            
                
                <div class="col-lg-8">
                    <h4 class="mb-5" style="
                         
    text-align: center;
    font-weight: bold;
    color: #196aa2; ">
اذا كانت شركتك تقدم احدى الخدمات  بالموقع سجل   الان مجانا

                         </h4>

                    <div class="container">


                        <div class="row ">
                            <form action="{{ route('add_company_post') }}"
                                enctype="multipart/form-data" method="POST" files="true">
                                @csrf
                                <!--      <input type="hidden" name="user_id" value="">-->
                             
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div
                                            class="form-group {{ $errors->has('Serv_id') ? ' has-error' : '' }}">
                                            <label
                                                for="company-type">{{ trans('langsite.company-service') }}<span
                                                    class="text-danger">*</span></label>
                                            <select required name="Serv_id" id="company-type" class="myselect">
                                                <option selected disabled value="">
                                                    {{ trans('langsite.choose') }}</option>
                                                @foreach($serviceInHeader as $serv)
                                                    <option <?php if(old('Serv_id') == $serv->id){ echo 'selected'; } ?>  value="{{ $serv->id }}">
                                                        @if(App::isLocale('en'))
                                                            {{ $serv->Service_en }}
                                                        @else
                                                            {{ $serv->Service }}
                                                        @endif

                                                    </option>

                                                @endforeach
                                            </select>
                                            <small
                                                class="text-danger">{{ $errors->first('Serv_id') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div
                                            class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">
                                            <label
                                                for="employe">{{ trans('langsite.company-employee') }}<span
                                                    class="text-danger">*</span></label>
                                            <input  value="{{ old('Employee_Name') }}" required type="text" name="Employee_Name" id="employe"
                                                class="form-control" value="">
                                            <small
                                                class="text-danger">{{ $errors->first('Employee_Name') }}</small>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div
                                            class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">
                                            <label
                                                for="employe-type">{{ trans('langsite.job-title') }}<span
                                                    class="text-danger">*</span></label>
                                            <select class="myselect" required name="Job_title" id="employe-type">
                                                <option selected disabled value="">
                                                    {{ trans('langsite.search') }}</option>
                                                @foreach($jobs as $job)
                                                    <option  <?php if(old('Job_title') == $job->id){ echo 'selected'; } ?> value="{{ $job->id }}">
                                                        @if(App::isLocale('en'))
                                                            {{ $job->Job_title_en }}
                                                        @else
                                                            {{ $job->Job_title }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small
                                                class="text-danger">{{ $errors->first('Job_title') }}</small>
                                        </div>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div
                                            class="form-group {{ $errors->has('Name') ? ' has-error' : '' }}">
                                            <label
                                                for="company-name">{{ trans('langsite.company-name') }}<span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('Name') }}" required type="text" name="Name" id="company-name"
                                                class="form-control">
                                            <small
                                                class="text-danger">{{ $errors->first('Name') }}</small>
                                        </div>
                                    </div>

 

                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div
                                            class="form-group {{ $errors->has('Phone') ? ' has-error' : '' }}">
                                            <label
                                                for="company-phone">{{ trans('langsite.Phone') }}<span
                                                    class="text-danger">*</span></label>
                                            <input  type="number" value="{{ old('Phone') }}" required   name="Phone" id="company-phone"
                                                class="form-control" value="">
                                            <small
                                                class="text-danger">{{ $errors->first('Phone') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div
                                            class="form-group {{ $errors->has('Phone2') ? ' has-error' : '' }}">
                                    <label for="company-phone2"> 
                                      الهاتف الفرعي (اختياري) 
                                    </label>
                                    
                                            <input value="{{ old('Phone2') }}"   type="number" name="Phone2" id="company-phone2"
                                                class="form-control" value="">
                                            <small
                                                class="text-danger">{{ $errors->first('Phone2') }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">



                                            <label for="email">البريد الالكنروني

                                                <span class="text-danger">*</span>

                                            </label>



                                            <input  type="email" name="email"
                                                value="{{ old('email') }}" required class="myselect"
                                                id="email" aria-describedby="emailHelp">
       <small
                                                class="text-danger">{{ $errors->first('email') }}</small>


                                        </div>
                                    </div>
                                    <div class="col-lg-4">

                                        <div class="form-group">



                                            <label for="exampleInputPassword1">

                                                كلمه المرور

                                                <span class="text-danger">*</span></label>



                                            <input name="password" required type="password" class="myselect"
                                                id="exampleInputPassword1" placeholder="كلمه المرور">



                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                      <div class="form-group">



                                    <label for="exampleInputPassword1">
                                        اعد ادخال كلمه المرور
                                                                            <span class="text-danger">*</span></label>



                                    <input  minlength="4" autocomplete="off"  name="password_confirmation" required type="password" class="myselect passwordInput"
                                        id="exampleInputPassword1" >



                                </div>
                                
                                </div>
                                
                                
                                
                                </div>
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
                                            required  placeholder="" value="{{ old('area_id') }}">
                                        <datalist id="areas">
                                            @foreach ($areas as $area)
                                            <option value="{{ $area->area }}"
                                                {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->area }}
                                            </option>
                                            @endforeach


                                        </datalist>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div
                                            class="form-group {{ $errors->has('building_number') ? ' has-error' : '' }}">
                                            <label
                                                for="building-no">{{ trans('langsite.building-no') }}<span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('building_number') }}" required id="building-no" name="building_number" type="number"
                                                class="form-control" min="1">
                                            <small
                                                class="text-danger">{{ $errors->first('building_number') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group {{ $errors->has('Floor') ? ' has-error' : '' }}">
                                            <label
                                                for="floor-no">{{ trans('langsite.floor-no') }}<span
                                                    class="text-danger">*</span></label>
                                            <input value="{{ old('Floor') }}"  required type="number" name="Floor" id="floor-no" class="form-control"
                                                min="1">
                                            <small
                                                class="text-danger">{{ $errors->first('Floor') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div
                                            class="form-group {{ $errors->has('unit_number') ? ' has-error' : '' }}">
                                            <label
                                                for="apartment-no">{{ trans('langsite.unit-no') }}</label>
                                            <input  value="{{ old('unit_number') }}" type="number" name="unit_number" id="apartment-no"
                                                class="form-control" min="1">
                                            <small
                                                class="text-danger">{{ $errors->first('unit_number') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div
                                            class="form-group {{ $errors->has('details') ? ' has-error' : '' }}">
                                            <label
                                                for="description">{{ trans('langsite.details') }}<span
                                                    class="text-danger">*</span></label>
                                            <textarea required name="details" id="description" class="form-control"
                                                rows="5">{{ old('details') }}</textarea>
                                            <small
                                                class="text-danger">{{ $errors->first('details') }}</small>
                                        </div>
                                    </div>
                             
                                  



                                </div>
                                <div
                                    class="form-group {{ $errors->has('photo') ? ' has-error' : '' }}">
                                    <label for="logo-company">{{ trans('langsite.add_logo') }}<span
                                            class="text-danger">*</span></label>
                                    <div>
                                        <input required type="file" id="upload_file" name="photo">
                                        <small
                                            class="text-danger">{{ $errors->first('photo') }}</small>
                                    </div>
                                </div>

                                <div class="form-check form-group">



                                    <input required type="checkbox" class="form-check-input" id="exampleCheck1">




                                    <label style="padding-right: 30px;" class="form-check-label"
                                        for="exampleCheck1">اوافق على
                                        <a href="">شروط واحكام</a> موقع Right Choice                                    </label>



                                </div>

                                <button type="submit"
                                    class="btn our-btn">{{ trans('langsite.register') }}</button>

                            </form>

                        </div>
                    </div>

                </div>
                
                
                    <div class="col-lg-4">
 <img src="{{asset('/images/04 (2).jpg')}}" alt="" style="  width: 100%;">
 
                </div>
                
                
            </div>

        </div>
    </section>
</x-layout>













<script src="{{ asset('assets/js/img-upload.js') }}"></script>
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
                        '<option   selected disabled   value="">Select State</option>');
                    $.each(result.states, function (key, value) {
                        $("#area_input").append('<option value="' + value
                            .id + '">' + value.district + '</option>');
                    });
                }
            });
        });

    });
</script>