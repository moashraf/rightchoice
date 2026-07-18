<x-layout>


    <style>
        :root {
            --rc-blue: #0b5f9c;
            --rc-blue-dark: #073d68;
            --rc-teal: #18c7a2;
            --rc-teal-dark: #0f9f86;
            --rc-sky: #eaf7fb;
            --rc-border: #d9e4ee;
            --rc-text: #1f3554;
            --rc-muted: #6f7f95;
            --rc-danger: #e63757;
            --rc-white: #ffffff;
        }

        #register.bg-light {
            position: relative;
            overflow: hidden;
            min-height: calc(100vh - 90px);
            padding: 34px 0 48px;
            direction: rtl;
            background:
                radial-gradient(circle at 12% 8%, rgba(24, 199, 162, .13), transparent 30%),
                radial-gradient(circle at 92% 18%, rgba(11, 95, 156, .13), transparent 34%),
                linear-gradient(180deg, #f4fafe 0%, #eef6fb 48%, #f8fbfd 100%) !important;
        }

        #register.bg-light::before,
        #register.bg-light::after {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 999px;
            pointer-events: none;
            z-index: 0;
            filter: blur(2px);
        }

        #register.bg-light::before {
            top: -210px;
            right: -120px;
            background: rgba(11, 95, 156, .08);
        }

        #register.bg-light::after {
            bottom: -260px;
            left: -120px;
            background: rgba(24, 199, 162, .10);
        }

        #register > .container {
            position: relative;
            z-index: 1;
            max-width: 1180px;
        }

        #register > .container > .row {
            align-items: flex-start;
        }

        #register .col-lg-8 {
            order: 1;
        }

        #register .col-lg-4 {
            order: 2;
        }

        #register .col-lg-8 > h4 {
            position: relative;
            margin: 0 0 18px !important;
            padding: 28px 34px !important;
            border: 1px solid rgba(11, 95, 156, .12);
            border-radius: 26px;
            background: linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(231, 249, 247, .94));
            box-shadow: 0 20px 55px rgba(7, 61, 104, .10);
            color: var(--rc-blue-dark) !important;
            font-size: 26px;
            line-height: 1.7;
            letter-spacing: -.3px;
        }

        #register .col-lg-8 > h4::after {
            content: "";
            display: block;
            width: 86px;
            height: 4px;
            margin: 10px auto 0;
            border-radius: 30px;
            background: linear-gradient(90deg, var(--rc-teal), var(--rc-blue));
        }

        #register .alert-info {
            margin-bottom: 20px !important;
            padding: 16px 20px;
            border: 1px solid rgba(24, 199, 162, .22) !important;
            border-right: 5px solid var(--rc-teal) !important;
            border-radius: 18px;
            background: rgba(255, 255, 255, .82) !important;
            color: var(--rc-text) !important;
            box-shadow: 0 12px 36px rgba(7, 61, 104, .07);
            backdrop-filter: blur(10px);
        }

        #register .alert-info strong {
            color: var(--rc-blue);
        }

        #register .col-lg-8 > .container {
            width: 100%;
            max-width: 100%;
            padding: 26px 28px 30px;
            border: 1px solid rgba(217, 228, 238, .9);
            border-radius: 28px;
            background: rgba(255, 255, 255, .94);
            box-shadow: 0 22px 70px rgba(7, 61, 104, .12);
        }

        #register .col-lg-8 > .container > .row {
            margin: 0;
        }

        #register form {
            width: 100%;
        }

        #register form > .row {
            margin-right: -10px;
            margin-left: -10px;
        }

        #register form > .row > [class*="col-"] {
            padding-right: 10px;
            padding-left: 10px;
        }

        #register .form-group,
        #register .form-check.form-group,
        #register form > .row > [class*="col-"] {
            margin-bottom: 18px;
        }

        #register label {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 8px;
            color: var(--rc-text);
            font-size: 14px;
            font-weight: 800;
        }

        #register .text-danger {
            color: var(--rc-danger) !important;
            font-weight: 800;
        }

        #register small.text-danger,
        #register .text-danger.text-sm,
        #register p.text-danger {
            display: block;
            min-height: 18px;
            margin-top: 7px !important;
            margin-bottom: 0;
            font-size: 12px;
            line-height: 1.5;
        }

        #register .form-control,
        #register .myselect {
            width: 100%;
            height: 46px;
            padding: 1px 14px;
            border: 1px solid var(--rc-border);
            border-radius: 14px;
            background-color: #fff;
            color: var(--rc-text);
            font-size: 14px;
            font-weight: 600;
            outline: none;
            box-shadow: 0 8px 22px rgba(7, 61, 104, .04);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease, background-color .2s ease;
        }

        #register .form-control::placeholder,
        #register .myselect::placeholder {
            color: #9aa8b9;
        }

        #register select.myselect,
        #register input[list].myselect {
            cursor: pointer;
        }

        #register .form-control:focus,
        #register .myselect:focus {
            border-color: var(--rc-teal);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(24, 199, 162, .13), 0 12px 28px rgba(7, 61, 104, .08);
        }

        #register textarea.form-control {
            height: auto;
            min-height: 132px;
            resize: vertical;
            line-height: 1.8;
        }

        #register .has-error .form-control,
        #register .has-error .myselect,
        #register .form-group.has-error input,
        #register .form-group.has-error select,
        #register .form-group.has-error textarea {
            border-color: var(--rc-danger) !important;
            box-shadow: 0 0 0 4px rgba(230, 55, 87, .10) !important;
        }

        #register input[type="radio"],
        #register input[type="checkbox"] {
            accent-color: var(--rc-teal);
        }

        #register .d-flex.flex-wrap {
            gap: 10px !important;
        }

        #register .form-check-inline {
            position: relative;
            min-height: 42px;
            margin-left: 0 !important;
            margin-right: 0 !important;
            padding: 10px 14px 10px 16px !important;
            border: 1px solid var(--rc-border) !important;
            border-radius: 999px !important;
            background: #fff !important;
            color: var(--rc-text);
            box-shadow: 0 8px 20px rgba(7, 61, 104, .04);
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        #register .form-check-inline:hover {
            transform: translateY(-1px);
            border-color: rgba(24, 199, 162, .55) !important;
            box-shadow: 0 12px 26px rgba(7, 61, 104, .09);
        }

        #register .form-check-inline:has(input[type="radio"]:checked) {
            border-color: rgba(24, 199, 162, .80) !important;
            background: linear-gradient(135deg, rgba(24, 199, 162, .12), rgba(11, 95, 156, .06)) !important;
            box-shadow: 0 12px 28px rgba(24, 199, 162, .12);
        }

        #register .form-check-inline .form-check-input {
            position: static;
            margin: 0 0 0 8px;
        }

        #register .form-check-inline .form-check-label {
            margin: 0;
            cursor: pointer;
            font-size: 13px;
            font-weight: 800;
            color: var(--rc-text);
        }

        #register input[type="file"] {
            width: 100%;
            padding: 11px 12px;
            border: 1px dashed rgba(11, 95, 156, .35);
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff, #f4fbff);
            color: var(--rc-muted);
            font-weight: 700;
        }

        #register input[type="file"]::file-selector-button {
            margin-left: 10px;
            padding: 8px 14px;
            border: 0;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--rc-blue), var(--rc-teal));
            color: #fff;
            cursor: pointer;
            font-weight: 800;
        }

        #register .form-check.form-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 16px;
            border: 1px solid rgba(217, 228, 238, .95);
            border-radius: 18px;
            background: #f8fcff;
        }

        #register .form-check.form-group .form-check-input {
            position: static;
            margin: 0;
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
        }

        #register .form-check.form-group .form-check-label {
            padding-right: 0 !important;
            margin: 0;
            color: var(--rc-text);
            font-size: 13px;
            line-height: 1.7;
        }

        #register .form-check.form-group a {
            color: var(--rc-teal-dark);
            font-weight: 900;
            text-decoration: none;
        }

        #register .form-check.form-group a:hover {
            color: var(--rc-blue);
            text-decoration: underline;
        }

        #register .our-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 190px;
            min-height: 48px;
            padding: 12px 30px;
            border: 0;
            border-radius: 16px;
            background: linear-gradient(135deg, var(--rc-blue), #126fac 48%, var(--rc-teal));
            color: #fff;
            font-size: 16px;
            font-weight: 900;
            box-shadow: 0 16px 34px rgba(11, 95, 156, .26);
            transition: transform .2s ease, box-shadow .2s ease, filter .2s ease;
        }

        #register .our-btn:hover,
        #register .our-btn:focus {
            color: #fff;
            transform: translateY(-2px);
            filter: saturate(1.08);
            box-shadow: 0 20px 42px rgba(11, 95, 156, .34);
        }

        #register .col-lg-4 img {
            display: block;
            width: 100% !important;
            max-width: 360px;
            margin: 0 auto;
            border-radius: 28px;
            object-fit: cover;
            box-shadow: 0 24px 70px rgba(7, 61, 104, .22);
            border: 1px solid rgba(255, 255, 255, .78);
        }

        #register .col-lg-4 {
            position: sticky;
            top: 20px;
        }

        @media (max-width: 991.98px) {
            #register.bg-light {
                padding: 22px 0 36px;
            }

            #register .col-lg-4 {
                position: static;
                order: 0;
                margin-bottom: 22px;
            }

            #register .col-lg-8 {
                order: 1;
            }

            #register .col-lg-4 img {
                max-width: 420px;
            }

            #register .col-lg-8 > h4 {
                padding: 22px 18px !important;
                font-size: 22px;
            }

            #register .col-lg-8 > .container {
                padding: 20px 16px 24px;
                border-radius: 22px;
            }
        }

        @media (max-width: 575.98px) {
            #register .form-check-inline {
                width: 100%;
                border-radius: 14px !important;
            }

            #register .our-btn {
                width: 100%;
            }
        }
    </style>


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

                    <div class="alert alert-info mb-4" role="alert" style="border-right: 4px solid #196aa2; background: #eef8ff; color: #24506b;">
                        <strong>{{ trans('langsite.Note') }}:</strong>
                        {{ trans('langsite.company_activity_notice') }}

                    </div>

                    <div class="container">


                        <div class="row ">
                            <form action="{{ route('add_company_post') }}"
                                  enctype="multipart/form-data" method="POST" files="true">
                                @csrf
                                <!--      <input type="hidden" name="user_id" value="">-->

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div
                                            class="form-group {{ $errors->has('Serv_id') ? ' has-error' : '' }}">
                                            <label>{{ trans('langsite.company-service') }}<span
                                                    class="text-danger">*</span></label>

                                            <div class="d-flex flex-wrap" style="gap: 10px;">
                                                @foreach($serviceInHeader as $serv)
                                                    <div class="form-check form-check-inline mb-2" style="background: #fff; border: 1px solid #e6eaf3; border-radius: 8px; padding: 8px 14px;">
                                                        <input class="form-check-input" type="radio" required name="Serv_id"
                                                               id="company-service-{{ $serv->id }}" value="{{ $serv->id }}"
                                                                <?php if(old('Serv_id') == $serv->id){ echo 'checked'; } ?>>
                                                        <label class="form-check-label" for="company-service-{{ $serv->id }}">
                                                            @if(App::isLocale('en'))
                                                                {{ $serv->Service_en }}
                                                            @else
                                                                {{ $serv->Service }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <small
                                                class="text-danger">{{ $errors->first('Serv_id') }}</small>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">

                                        <div
                                            class="form-group {{ $errors->has('name_of_real_estate_developer') ? ' has-error' : '' }}">
                                            <label
                                                for="employe">{{ trans('langsite.company-employee') }}<span
                                                    class="text-danger">*</span></label>
                                            <input  value="{{ old('name_of_real_estate_developer') }}" required type="text" name="name_of_real_estate_developer" id="employe"
                                                    class="form-control" value="">
                                            <small
                                                class="text-danger">{{ $errors->first('name_of_real_estate_developer') }}</small>
                                        </div>

                                    </div>
                                    <div class="col-lg-12">
                                        <div
                                            class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">
                                            <label>{{ trans('langsite.job-title') }}<span
                                                    class="text-danger">*</span></label>

                                            <div class="d-flex flex-wrap" style="gap: 10px;">
                                                @foreach($jobs as $job)
                                                    <div class="form-check form-check-inline mb-2" style="background: #fff; border: 1px solid #e6eaf3; border-radius: 8px; padding: 8px 14px;">
                                                        <input class="form-check-input" type="radio" required name="Job_title"
                                                               id="job-title-{{ $job->id }}" value="{{ $job->id }}"
                                                                <?php if(old('Job_title') == $job->id){ echo 'checked'; } ?>>
                                                        <label class="form-check-label" for="job-title-{{ $job->id }}">
                                                            @if(App::isLocale('en'))
                                                                {{ $job->Job_title_en }}
                                                            @else
                                                                {{ $job->Job_title }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
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

{{--                                    <div class="col-lg-6">--}}
{{--                                        <div--}}
{{--                                            class="form-group {{ $errors->has('Phone2') ? ' has-error' : '' }}">--}}
{{--                                            <label for="company-phone2">--}}
{{--                                                الهاتف الفرعي (اختياري)--}}
{{--                                            </label>--}}

{{--                                            <input value="{{ old('Phone2') }}"   type="number" name="Phone2" id="company-phone2"--}}
{{--                                                   class="form-control" value="">--}}
{{--                                            <small--}}
{{--                                                class="text-danger">{{ $errors->first('Phone2') }}</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    --}}
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
                                        <input list="areas" name="area_id" id="area" class="myselect"  placeholder="" value="{{ old('area_id') }}">
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



{{--                                    <div class="col-md-4">--}}
{{--                                        <div--}}
{{--                                            class="form-group {{ $errors->has('unit_number') ? ' has-error' : '' }}">--}}
{{--                                            <label--}}
{{--                                                for="apartment-no">{{ trans('langsite.unit-no') }}</label>--}}
{{--                                            <input  value="{{ old('unit_number') }}" type="number" name="unit_number" id="apartment-no"--}}
{{--                                                    class="form-control" min="1">--}}
{{--                                            <small--}}
{{--                                                class="text-danger">{{ $errors->first('unit_number') }}</small>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}



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
