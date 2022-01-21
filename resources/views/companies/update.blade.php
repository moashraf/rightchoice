<x-layout>


 @section('title')
{{$company->Name }} 
@endsection



    <section id="profile-info" class="bg-light" dir="rtl">







        <div class="container">







            <div class="main-body">







                <div class="row gutters-sm">




<div class="col-md-12">







                        <div class="card mb-3">







                            <div class="card-body">







                                <form action="{{ URL::to('updated-company/' . $company->id) }}" enctype="multipart/form-data"

                                    method="POST" files="true">

                                    @csrf


                                    
                                <input type="hidden" name="user_id" value="{{  auth()->user()->id }}">






                                <div class="row">

                                    <div class="col-lg-4">

                                        <div class="form-group {{ $errors->has('Serv_id') ? ' has-error' : '' }}">

                                            <label for="company-type">اختر نشاط الشركه<span

                                                    class="text-danger">*</span></label>

                                            <select required name="Serv_id" id="company-type" class="myselect">

                                                <option value="">اختر</option>
                                                @foreach($serviceInHeader as $serv)
                                                        <option value="{{ $serv->id }}" {{ $company->Serv_id == $serv->id ? 'selected' : '' }}>{{ $serv->Service }}</option>

                                                @endforeach

                                            </select>

                                            <small class="text-danger">{{ $errors->first('Serv_id') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">



                                        <div class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">

                                            <label for="employe">اسم الموظف المسئول<span

                                                    class="text-danger">*</span></label>

                                            <input required type="text" name="Employee_Name" id="employe"

                                                class="form-control" value="{{  $company->Employee_Name }}">

                                            <small class="text-danger">{{ $errors->first('Employee_Name') }}</small>

                                        </div>



                                    </div>

                                    <div class="col-lg-4">

                                        <div class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">

                                            <label for="employe-type">المسمى الوظيفي<span

                                                    class="text-danger">*</span></label>

                                            <select class="myselect" required name="Job_title" id="employe-type">

                                                <option value="">اختر</option>

                                                <option value="1" {{ $company->Job_title == 1 ? 'selected' : '' }}>صاحب عمل</option>

                                                <option value="2" {{ $company->Job_title == 2 ? 'selected' : '' }}>مدير عام</option>

                                                <option value="3" {{ $company->Job_title == 3 ? 'selected' : '' }}>مدير تسويق</option>

                                                <option value="4" {{ $company->Job_title == 4 ? 'selected' : '' }}>مدير فرع</option>

                                                <option value="5" {{ $company->Job_title == 5 ? 'selected' : '' }}>اخرى</option>

                                            </select>

                                            <small class="text-danger">{{ $errors->first('Job_title') }}</small>

                                        </div>



                                    </div>

                                </div>





                                <div class="row">

                                    <div class="col-lg-6">

                                        <div class="form-group {{ $errors->has('Name') ? ' has-error' : '' }}">

                                            <label for="company-name">اسم الشركه<span

                                                    class="text-danger">*</span></label>

                                            <input required type="text" name="Name" id="company-name" class="form-control"

                                                placeholder="  company name" value="{{  $company->Name }}">

                                            <small class="text-danger">{{ $errors->first('Name') }}</small>

                                        </div>

                                    </div>



                                    <div class="col-lg-6">

                                        <div class="form-group {{ $errors->has('Phone') ? ' has-error' : '' }}">

                                            <label for="company-phone">رقم التلفون<span

                                                    class="text-danger">*</span></label>

                                            <input required type="phone" name="Phone" id="company-phone"

                                                class="form-control" placeholder="010000000000000"

                                                value="{{  $company->Phone }}">

                                            <small class="text-danger">{{ $errors->first('Phone') }}</small>

                                        </div>

                                    </div>

                                </div>







                                <div class="form-group">

                                    <label for="">الموقع<span class="text-danger">*</span></label>

                                    <div class="row">

                                        <div class="col-lg-4 {{ $errors->has('governrate_id') ? ' has-error' : '' }}">

                                            <select required name="governrate_id" id="country" class="myselect">

                                                <option value="">المحافظه</option>

                                                @foreach ($governrate as $loc)

                                                <option value="{{ $loc->id }}" {{ $company->governrate_id == $loc->id ? 'selected' : '' }}>{{ $loc->governrate }}</option>

                                                @endforeach

                                            </select>

                                            <small class="text-danger">{{ $errors->first('governrate_id') }}</small>

                                        </div>



                                        <div class="col-lg-4 {{ $errors->has('district_id') ? ' has-error' : '' }}">

                                            <select required name="district_id" id="area_input" class="myselect">

                                                <option value="">الحي</option>
                                                @foreach ($district as $dis)

                                                <option value="{{ $dis->id }}" {{ $company->district_id == $dis->id ? 'selected' : '' }}>{{ $dis->district }}</option>

                                                @endforeach

                                            </select>

                                            <small class="text-danger">{{ $errors->first('district_id') }}</small>

                                        </div>







                                        <div class="col-lg-4 {{ $errors->has('area_id') ? ' has-error' : '' }}">



                                          <select required name="area_id" id="area" class="myselect">
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}" {{ $company->area_id == $area->id ? 'selected' : '' }}>{{ $area->area }}</option>
                
                                                @endforeach
                                            </select>

                                            <small class="text-danger">{{ $errors->first('area_id') }}</small>

                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-4">

                                        <div

                                            class="form-group {{ $errors->has('building_number') ? ' has-error' : '' }}">

                                            <label for="building-no">رقم العماره<span

                                                    class="text-danger">*</span></label>

                                            <input id="building-no" name="building_number" type="number"

                                                class="form-control" placeholder="1" min="1"  value="{{  $company->building_number }}">

                                            <small class="text-danger">{{ $errors->first('building_number') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group {{ $errors->has('Floor') ? ' has-error' : '' }}"><label

                                                for="floor-no">رقم الدور<span class="text-danger">*</span></label>

                                            <input type="number" name="Floor" id="floor-no" class="form-control"

                                                placeholder="1" min="1" value="{{  $company->Floor }}">

                                            <small class="text-danger">{{ $errors->first('Floor') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="form-group {{ $errors->has('unit_number') ? ' has-error' : '' }}">

                                            <label for="apartment-no">رقم الشقه او المحل (اختياري)<span

                                                    class="text-danger">*</span></label>

                                            <input type="number" name="unit_number" id="apartment-no" class="form-control"

                                                placeholder="1" min="1" value="{{  $company->unit_number }}">

                                            <small class="text-danger">{{ $errors->first('unit_number') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-md-12">

                                        <div class="form-group {{ $errors->has('details') ? ' has-error' : '' }}">

                                            <label for="description">تفاصيل عن الشركه و خدماتها<span

                                                    class="text-danger">*</span></label>

                                            <textarea required name="details" id="description" class="form-control"

                                                rows="5">{{  $company->details }}</textarea>

                                            <small class="text-danger">{{ $errors->first('details') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group {{ $errors->has('Tax_card') ? ' has-error' : '' }}">

                                            <label for="tax-id">رقم البطاقه الضريبيه<span

                                                    class="text-danger">*</span></label>

                                            <input type="text" name="Tax_card" id="tax-id" class="form-control" value="{{  $company->Tax_card }}">

                                            <small class="text-danger">{{ $errors->first('Tax_card') }}</small>

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div

                                            class="form-group {{ $errors->has('Commercial_Register') ? ' has-error' : '' }}">

                                            <label for="togary-id">رقم السجل التجاري<span

                                                    class="text-danger">*</span></label>

                                            <input type="text" name="Commercial_Register" id="togary-id"

                                                class="form-control" value="{{  $company->Commercial_Register }}">

                                            <small

                                                class="text-danger">{{ $errors->first('Commercial_Register') }}</small>

                                        </div>

                                    </div>







                                </div>

                                <div class="form-group {{ $errors->has('img') ? ' has-error' : '' }}">
                                    
                                <label for="logo-company">اضف لوجو الشركه<span class="text-danger">*</span></label>
                                    @if(!empty($company->photo))
                                        <div class="mb-2">
                                            <a href="{{ URL::to('/').'/images/'.$company->photo}}" data-toggle="lightbox"><img src="{{ URL::to('/').'/images/'.$company->photo}}" alt=""  class="img-fluid img-thumbnail" style="max-width: 60%;">
                                            </a>
                                        </div>
                                        @endif

                                    <div>

                                        <input  type="file" id="upload_file" name="img">

                                        <small class="text-danger">{{ $errors->first('img') }}</small>

                                    </div>

                                </div>



                                <button type="submit" class="btn our-btn">

تعديل 
</button>




                                </form>







                                <div class="links">















                                </div>







                            </div>







                        </div>









                    </div>


                





                    









                </div>









            </div>







        </div>























    </section>










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

    </script>




</x-layout>