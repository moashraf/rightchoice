<x-layout>

    @section('title')
        تسجيل مستخدم جديد
    @endsection

    <section id="register" class="bg-light">


        <div class="container">

            <div class="row">

                <div class="col-lg-8">

                    <h2 style="font-weight: bold;" class="mb-5">
                        {{ trans('langsite.register') }}
                    </h2>

                     @if (count($errors) > 0)

                        <ul style="COLOR: red; font-size: 20px;">


                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    @endif

                    <form method="POST" action="{{ route('custom_register', Config::get('app.locale')) }}"
                          autocomplete="off">

                        @csrf

                        <div class="row">

                            <div class="col-lg-6">

                                <div class="form-group">

                                    @if(isset($invited_by) && $invited_by)
                                        <input type="hidden" name="invited_by" value="{{ $invited_by }}">
                                    @endif


                                    <label for="name">

                                        الاسم الكامل
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input oninvalid="this.setCustomValidity('   برجاء ادخال    الاسم     ')"
                                           oninput="this.setCustomValidity('')"
                                           name="name" autocomplete="off" value="{{ old('name') }}" required autofocus
                                           type="text"
                                           class="myselect" id="name" aria-describedby="">

                                </div>
                            </div>


                            <div class="col-lg-6">


                                <div class="form-group">

                                    <label for="email">
                                        البريد الالكتروني
                                        {{--     <span class="text-danger">*</span>--}}

                                    </label>


                                    <input
                                        oninvalid="this.setCustomValidity('   برجاء ادخال    البريد     ')"
                                        oninput="this.setCustomValidity('')"
                                        type="email" name="email" value="{{ old('email') }}"
                                        class="myselect" autocomplete="off" id="email" aria-describedby="emailHelp"
                                    >


                                </div>


                            </div>

                        </div>


                        <div class="row">
                            @if(isset($getUserType) && $getUserType)

                            <div class="getUserType_getUserType col-lg-6">
                                <div class="form-group">


                                    <label for="user-type">

                                        نوع المستخدم

                                        <span class="text-danger">*</span>

                                    </label>


                                    <select
                                        oninvalid="this.setCustomValidity('   برجاء ادخال  نوع المستخدم    ')"
                                        oninput="this.setCustomValidity('')"
                                        autocomplete="off" name="TYPE" id="user-type" class="myselect">
                                        <option value="1">
                                            أختار
                                        </option>
                                        @foreach($getUserType as $name => $id)
                                            <option value="{{ $id }}">{{ $name }}</option>
                                        @endforeach


                                    </select>


                                </div>
                            </div>
                            @endif


                            <div class="col-lg-6">

                                <div class="form-group  ">
                                    <label name="phone" for="phone">

                                        رقم الهاتف
                                        <span class="text-danger">*</span></label>


                                    <input
                                           id="phone" value="{{ old('MOP') }}" style="/* width:96% */"
                                           type="tel" name="MOP" inputmode="numeric" pattern="01\d{9}"
                                           maxlength="11"
                                           required
                                           class="myselect"
                                           oninput="this.value=this.value.replace(/[^0-9]/g,'').slice(0,11); validatePhone(this);"
                                           oninvalid="this.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم ويبدأ بـ 01')"/>
                                    <small id="phone-hint" style="color:#6c757d; font-size:12px;">
                                        أدخل 11 رقم يبدأ بـ 01 (مثال: 01012345678)
                                    </small>
                                    <small id="phone-error" class="text-danger" style="display:none; font-size:12px;">
                                        <i class="fa fa-exclamation-circle"></i> رقم الهاتف يجب أن يكون 11 رقم ويبدأ بـ 01
                                    </small>

                                </div>
                            </div>


                        </div>


                        <div class="row" id="motwar" style="display:none;">
                            <div class="col-lg-4">

                                <div class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">
                                    <label for="employe">اسم الموظف المسئول<span class="text-danger">*</span></label>
                                    <input type="text" name="Employee_Name" id="employe" class="form-control"
                                           value="">
                                    <small class="text-danger">{{ $errors->first('Employee_Name') }}</small>
                                </div>

                            </div>

                            <div class="col-lg-4">
                                <div class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">
                                    <label for="employe-type">المسمى الوظيفي<span class="text-danger">*</span></label>
                                    <select class="myselect" name="Job_title" id="employe-type">
                                        <option value="">اختر</option>
                                        @foreach($jobs ?? [] as $job)
                                            <option value="{{ $job->id }}" {{ old('Job_title') == $job->id ? 'selected' : '' }}>
                                                @if(App::isLocale('en'))
                                                    {{ $job->Job_title_en ?: $job->Job_title }}
                                                @else
                                                    {{ $job->Job_title }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('Job_title') }}</small>
                                </div>

                            </div>


                            <div class="col-lg-4">
                                <div class="form-group">

                                    <label for="togary-id">
                                        {{ trans('langsite.company-name') }}
                                          <span class="text-danger">*</span>
                                     </label>

                                    <input type="text" autocomplete="off" name="Commercial_Register" id="togary-id"
                                           class="myselect">

                                </div>
                            </div>

                        </div>


                        <div class="row">


                            <div class="col-lg-6">


                                <div class="form-group">


                                    <label for="exampleInputPassword1">
                                        ادخل كلمه المرور
                                        <span class="text-danger">*</span></label>
                                    <input
                                        oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')"
                                        oninput="this.setCustomValidity('')"
                                        minlength="4" name="password" autocomplete="off" required type="password"
                                        class="myselect passwordInput"
                                        id="exampleInputPassword1" placeholder="كلمه المرور">
                                    <span toggle="#password-field"
                                          class="fa fa-fw fa-eye field-icon toggle-password"></span>

                                </div>


                            </div>


                            <div class="col-lg-6">


                                <div class="form-group">


                                    <label for="exampleInputPassword1">
                                        اعد ادخال كلمه المرور
                                        <span class="text-danger">*</span></label>

                                    <input

                                        oninvalid="this.setCustomValidity('   برجاء ادخال       كلمه  المرور مكونه من اكثر من 4 ارقام او احرف       ')"
                                        oninput="this.setCustomValidity('')"
                                        minlength="4" autocomplete="off" name="password_confirmation" required
                                        type="password" class="myselect passwordInput"
                                        id="exampleInputPassword1">


                                </div>

                            </div>


                        </div>


                        <div class="form-check form-group">

                            <br>

                            <input
                                oninvalid="this.setCustomValidity(' برجاء الضغط علي الموافقه علي الشروط والاحكام       ')"
                                oninput="this.setCustomValidity('')"
                                required type="checkbox" class="form-check-input" name="check">

                            <label style="padding-right: 30px;" class="form-check-label" for="check">
                                اوافق على
                                <strong> <a target="_blank"
                                            href="{{ url(Config::get('app.locale').'/terms-conditions') }}">&nbsp; شروط
                                        و احكام &nbsp; </a></strong>
                                موقع
                                Right Choice

                                <span id="termsCheckLabel"></span>
                            </label>


                        </div>
                        {{--                                <br>--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                   <label class="form-label"> </label>--}}
                        {{--                                        <div class="col-md-6">--}}
                        {{--                                            <div class="caption-parent w-100" >--}}
                        {{--                                                    {!! NoCaptcha::display() !!}--}}
                        {{--                                                     <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>--}}
                        {{--                                            </div>--}}
                        {{--                                        --}}
                        {{--                                        </div>--}}
                        {{--                                </div>--}}
                        {{--                                <br>--}}
                        <button type="submit" class="btn our-btn">سجل</button>


                    </form>


                </div>

                <div class="col-lg-4">

                    <img src="{{asset('/images/03 (1).jpg')}}" alt="" style="  width: 100%;  padding-top: 25px;">


                </div>


            </div>


        </div>


    </section>

    {{--    {!! NoCaptcha::renderJs() !!}--}}
    <style>
        .field-icon {
            float: left;
            margin-left: 10px;
            margin-top: -25px;
            position: relative;
            z-index: 2;
        }
        #phone.is-valid-phone  { border-color: #28a745 !important; }
        #phone.is-invalid-phone { border-color: #dc3545 !important; }
    </style>

    <script>
        function validatePhone(input) {
            var val = input.value;
            var hint  = document.getElementById('phone-hint');
            var error = document.getElementById('phone-error');
            if (val.length === 0) {
                input.classList.remove('is-valid-phone','is-invalid-phone');
                hint.style.display  = 'block';
                error.style.display = 'none';
                input.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم ويبدأ بـ 01');
            } else if (!val.startsWith('01')) {
                input.classList.remove('is-valid-phone');
                input.classList.add('is-invalid-phone');
                hint.style.display  = 'none';
                error.style.display = 'block';
                error.innerHTML = '<i class="fa fa-exclamation-circle"></i> رقم الهاتف يجب أن يبدأ بـ 01';
                input.setCustomValidity('رقم الهاتف يجب أن يبدأ بـ 01');
            } else if (val.length < 11) {
                input.classList.remove('is-valid-phone');
                input.classList.add('is-invalid-phone');
                hint.style.display  = 'none';
                error.style.display = 'block';
                error.innerHTML = '<i class="fa fa-exclamation-circle"></i> أدخلت ' + val.length + ' أرقام — مطلوب 11 رقم';
                input.setCustomValidity('برجاء إدخال رقم هاتف مكون من 11 رقم');
            } else {
                input.classList.remove('is-invalid-phone');
                input.classList.add('is-valid-phone');
                hint.style.display  = 'none';
                error.style.display = 'none';
                input.setCustomValidity('');
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            var phone = document.getElementById('phone');
            if (phone && phone.value.length > 0) validatePhone(phone);
        });
    </script>

</x-layout>
