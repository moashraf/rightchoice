<x-layout>


    @section('title')
        الصفحه الشخصيه
    @endsection


    <section id="profile-info" class="bg-light">


        <div class="container">


            <div class="main-body">


                <div class="row gutters-sm">


                    <div class="col-md-8">


                        <div class="card mb-3">


                            <div class="card-body">


                                <form action="{{ URL::to('updatedProfileUser') }}" enctype="multipart/form-data"
                                      method="POST">

                                    @csrf


                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">

                                        <label for="exampleInputEmail1">الاسم كاملا <span

                                                class="text-danger">*</span></label>


                                        <input type="text" name="name" class="myselect" id="exampleInputEmail1"

                                               aria-describedby="emailHelp" VALUE="{{ Auth::user()->name }}"

                                               placeholder=" الاسم  ">


                                        <small class="text-danger">{{ $errors->first('name') }}</small>


                                    </div>


                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">


                                        <label for="exampleInputEmail1">البريد الالكنروني <span

                                                class="text-danger">*</span></label>


                                        <input readonly type="email" name="email" class="myselect"
                                               id="exampleInputEmail1"

                                               aria-describedby="emailHelp" VALUE="{{ Auth::user()->email }}">


                                        <small class="text-danger">{{ $errors->first('email') }}</small>


                                    </div>


                                    <div class="form-group {{ $errors->has('MOP') ? ' has-error' : '' }}">


                                        <label for="profile-phone">الهاتف</label>


                                        <input minLength="9" maxLength="18" type="text" class="myselect" readonly
                                               id="profile-phone"

                                               aria-describedby="emailHelp" VALUE="{{ Auth::user()->MOP }}">

                                        <small class="text-muted d-block mt-1">لا يمكن تغيير رقم الهاتف من لوحة
                                            التحكم.</small>


                                        <small class="text-danger">{{ $errors->first('MOP') }}</small>


                                    </div>


                                    @if(Auth::user()->TYPE != 3)

                                        <div class="form-group {{ $errors->has('AGE') ? ' has-error' : '' }}">


                                            <label for="inputState">العمر <span class="text-danger">*</span></label>


                                            <select id="inputState" name="AGE" class="myselect">

                                                <option value=""> اختار</option>

                                                <option value="1" {{ Auth::user()->AGE == 1 ? 'selected' : '' }}>من 18 -
                                                    الى

                                                    25
                                                </option>


                                                <option value="2" {{ Auth::user()->AGE == 2 ? 'selected' : '' }}>من 26
                                                    الى

                                                    35
                                                </option>


                                                <option value="3" {{ Auth::user()->AGE == 4 ? 'selected' : '' }}>من 36
                                                    الى

                                                    45
                                                </option>


                                                <option value="4" {{ Auth::user()->AGE == 4 ? 'selected' : '' }}>من 46
                                                    الى

                                                    60
                                                </option>


                                                <option value="5" {{ Auth::user()->AGE == 5 ? 'selected' : '' }}>اكثر من
                                                    60

                                                </option>


                                            </select>


                                            <small class="text-danger">{{ $errors->first('AGE') }}</small>


                                        </div>

                                    @endIf

                                    <div class="form-group {{ $errors->has('TYPE') ? ' has-error' : '' }}">


                                        <label for="inputState">نوع المستخدم <span class="text-danger">*</span></label>


                                        <select disabled id="user-type" name="TYPE" class="myselect">


                                            <option @if(Auth::user()->TYPE == 3)  readonly
                                                    @endif value="1" {{ Auth::user()->TYPE == 1 ? 'selected' : '' }}>
                                                بائع

                                            </option>


                                            <option @if(Auth::user()->TYPE == 3)  readonly
                                                    @endif value="2" {{ Auth::user()->TYPE == 2 ? 'selected' : '' }}>
                                                مشتري

                                            </option>


                                            <option @if(Auth::user()->TYPE != 3)  readonly
                                                    @endif  value="3" {{ Auth::user()->TYPE == 3 ? 'selected' : '' }}>
                                                مطور عقاري

                                            </option>


                                        </select>


                                        <small class="text-danger">{{ $errors->first('TYPE') }}</small>


                                    </div>


{{--                                    @if(Auth::user()->TYPE == 3)--}}

{{--                                        <div id="motwar">--}}

{{--                                            <div>--}}


{{--                                                <div--}}
{{--                                                    class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">--}}

{{--                                                    <label for="employe">اسم الموظف المسئول<span--}}

{{--                                                            class="text-danger">*</span></label>--}}

{{--                                                    <input type="text" name="Employee_Name" id="employe"--}}

{{--                                                           class="myselect" value="{{ Auth::user()->Employee_Name }}">--}}

{{--                                                    <small--}}
{{--                                                        class="text-danger">{{ $errors->first('Employee_Name') }}</small>--}}

{{--                                                </div>--}}


{{--                                            </div>--}}

{{--                                            <div class="555">--}}

{{--                                                <div   class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">--}}

{{--                                                    <label for="employe-type">المسمى الوظيفي<span--}}

{{--                                                            class="text-danger">*</span></label>--}}

{{--                                                    <select class="myselect" name="Job_title" id="employe-type">--}}

{{--                                                        <option value="">اختر</option>--}}

{{--                                                        @foreach($jobs ?? [] as $job)--}}
{{--                                                            <option--}}
{{--                                                                value="{{ $job->id }}" {{ old('Job_title', Auth::user()->Job_title) == $job->id ? 'selected' : '' }}>--}}
{{--                                                                @if(App::isLocale('en'))--}}
{{--                                                                    {{ $job->Job_title_en ?: $job->Job_title }}--}}
{{--                                                                @else--}}
{{--                                                                    {{ $job->Job_title }}--}}
{{--                                                                @endif--}}
{{--                                                            </option>--}}
{{--                                                        @endforeach--}}

{{--                                                    </select>--}}

{{--                                                    <small class="text-danger">{{ $errors->first('Job_title') }}</small>--}}

{{--                                                </div>--}}


{{--                                            </div>--}}


{{--                                            <div>--}}

{{--                                                <div--}}
{{--                                                    class="form-group {{ $errors->has('Tax_card') ? ' has-error' : '' }}">--}}


{{--                                                    <label for="tax-id">رقم البطاقه الضريبيه<span--}}
{{--                                                            class="text-danger">*</span></label>--}}


{{--                                                    <input type="text" name="Tax_card" id="tax-id" class="myselect"--}}

{{--                                                           placeholder="البطاقه الضريبيه"--}}
{{--                                                           value="{{ Auth::user()->Tax_card }}">--}}

{{--                                                    <small class="text-danger">{{ $errors->first('Tax_card') }}</small>--}}

{{--                                                </div>--}}

{{--                                            </div>--}}


{{--                                            <div>--}}

{{--                                                <div class="form-group">--}}


{{--                                                    <label for="togary-id">رقم السجل التجاري</label>--}}


{{--                                                    <input type="text" name="Commercial_Register" id="togary-id"--}}

{{--                                                           class="myselect" placeholder="السجل التجاري"--}}
{{--                                                           value="{{ Auth::user()->Commercial_Register }}">--}}


{{--                                                </div>--}}

{{--                                            </div>--}}

{{--                                        </div>--}}

{{--                                    @endIf--}}

                                    <div class="form-group {{ $errors->has('img') ? ' has-error' : '' }}">

                                        <label for="logo-company">الصورة الشخصية</label>

                                        @if(!empty(Auth::user()->profile_image))
                                            <div class="mb-2">
                                                <a href="{{ URL::to('/').'/'.Auth::user()->profile_image}}"
                                                   data-toggle="lightbox">
                                                    <img src="{{ URL::to('/').'/'.Auth::user()->profile_image}}"
                                                         alt="" class="img-fluid img-thumbnail" style="max-width: 60%;"
                                                         loading="lazy">
                                                </a>
                                            </div>
                                        @endif

                                        <div>

                                            <input @if(empty(Auth::user()->profile_image)) @endif type="file"

                                                   id="upload_file" name="img">

                                            <small class="text-danger">{{ $errors->first('img') }}</small>

                                        </div>

                                    </div>


                                    <div class="accordion" id="accordionExample">


                                        <div class="accordion-item">


                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                                    data-bs-target="#collapseOne" aria-expanded="true"

                                                    aria-controls="collapseOne">


                                                <span class="h5 mb-0">لتغيير كلمه المرور</span>


                                            </button>


                                            <div id="collapseOne" class="accordion-collapse collapse"

                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">


                                                <div

                                                    class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">


                                                    <label for="old_password">ادخل كلمه المرور الحاليه </label>


                                                    <div style="position:relative;">
                                                        <input type="password" name="old_password" class="myselect"

                                                               id="old_password" aria-describedby="old_password"  style="padding-left:45px;">

                                                        <button type="button" class="password-visibility-toggle"
                                                                data-target="old_password"
                                                                aria-label="إظهار كلمة المرور"
                                                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#777;cursor:pointer;padding:0;width:22px;height:22px;display:flex;align-items:center;justify-content:center;">
                                                            <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                            <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                <path d="M1 1l22 22"></path>
                                                            </svg>
                                                        </button>
                                                    </div>


                                                    <small

                                                        class="text-danger">{{ $errors->first('old_password') }}</small>


                                                </div>


                                                <div

                                                    class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">


                                                    <label for="password">ادخل كلمه المرور الجديده </label>


                                                    <div style="position:relative;">
                                                        <input type="password" name="password" class="myselect"

                                                               id="password" aria-describedby="password"  style="padding-left:45px;">

                                                        <button type="button" class="password-visibility-toggle"
                                                                data-target="password"
                                                                aria-label="إظهار كلمة المرور"
                                                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#777;cursor:pointer;padding:0;width:22px;height:22px;display:flex;align-items:center;justify-content:center;">
                                                            <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                            <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                <path d="M1 1l22 22"></path>
                                                            </svg>
                                                        </button>
                                                    </div>


                                                    <small class="text-danger">{{ $errors->first('password') }}</small>


                                                </div>


                                                <div class="form-group">


                                                    <label for="password-confirm">اعد ادخال كامه المرور الجديده</label>


                                                    <div style="position:relative;">
                                                        <input type="password" name="password_confirmation"

                                                               class="myselect" id="password-confirm"

                                                               aria-describedby="password-confirm" placeholder="Confirm Password" style="padding-left:45px;">

                                                        <button type="button" class="password-visibility-toggle"
                                                                data-target="password-confirm"
                                                                aria-label="إظهار كلمة المرور"
                                                                style="position:absolute;left:12px;top:50%;transform:translateY(-50%);border:0;background:transparent;color:#777;cursor:pointer;padding:0;width:22px;height:22px;display:flex;align-items:center;justify-content:center;">
                                                            <svg data-eye-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                                                <circle cx="12" cy="12" r="3"></circle>
                                                            </svg>
                                                            <svg data-eye-off-icon xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="display:none;">
                                                                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20C5 20 1 12 1 12a20.29 20.29 0 0 1 5.06-5.94"></path>
                                                                <path d="M9.9 4.24A10.67 10.67 0 0 1 12 4c7 0 11 8 11 8a20.49 20.49 0 0 1-2.16 3.19"></path>
                                                                <path d="M14.12 14.12A3 3 0 0 1 9.88 9.88"></path>
                                                                <path d="M1 1l22 22"></path>
                                                            </svg>
                                                        </button>
                                                    </div>


                                                </div>


                                                <!--<a href="./forget-pass.html">هل نسيت كلمه المرور ؟</a>-->


                                            </div>


                                        </div>


                                    </div>

                                    <button type="submit" class="btn our-btn mt-5">تعديل</button>
                                    <!-- <button type="submit"

                                         class="btn btn-sm btn-primary btn-round btn-block waves-effect waves-light mt-5">تعديل</button>-->

                                </form>

                                <div class="links">


                                </div>


                            </div>


                        </div>

                    </div>

                    @include('components.profile-sidebar')


                </div>


            </div>


        </div>

    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var toggleButtons = document.querySelectorAll('.password-visibility-toggle');

            toggleButtons.forEach(function (toggleButton) {
                toggleButton.addEventListener('click', function () {
                var passwordInput = document.getElementById(toggleButton.getAttribute('data-target'));

                if (!passwordInput) {
                    return;
                }

                var eyeIcon = toggleButton.querySelector('[data-eye-icon]');
                var eyeOffIcon = toggleButton.querySelector('[data-eye-off-icon]');
                var shouldShowPassword = passwordInput.type === 'password';

                passwordInput.type = shouldShowPassword ? 'text' : 'password';
                toggleButton.setAttribute('aria-label', shouldShowPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور');

                if (eyeIcon && eyeOffIcon) {
                    eyeIcon.style.display = shouldShowPassword ? 'none' : 'block';
                    eyeOffIcon.style.display = shouldShowPassword ? 'block' : 'none';
                }
                });
            });
        });
    </script>


</x-layout>
