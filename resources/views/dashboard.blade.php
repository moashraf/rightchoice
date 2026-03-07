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

                                      method="POST" files="true">

                                    @csrf


                                    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">


                                        <label for="exampleInputEmail1">الاسم كاملا <span

                                                class="text-danger">*</span></label>


                                        <input type="text" name="name" class="myselect" id="exampleInputEmail1"

                                               aria-describedby="emailHelp" VALUE="{{ Auth::user()->name }}"

                                               placeholder="علي حسن">


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


                                        <label for="exampleInputEmail1">الهاتف <span

                                                class="text-danger">*</span></label>


                                        <input minLength="9" maxLength="18" type="text" name="MOP" class="myselect"
                                               id="exampleInputEmail1"

                                               aria-describedby="emailHelp" VALUE="{{ Auth::user()->MOP }}">


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

                                    @if(Auth::user()->TYPE == 3)

                                        <div id="motwar">

                                            <div>


                                                <div
                                                    class="form-group {{ $errors->has('Employee_Name') ? ' has-error' : '' }}">

                                                    <label for="employe">اسم الموظف المسئول<span

                                                            class="text-danger">*</span></label>

                                                    <input type="text" name="Employee_Name" id="employe"

                                                           class="myselect" value="{{ Auth::user()->Employee_Name }}">

                                                    <small
                                                        class="text-danger">{{ $errors->first('Employee_Name') }}</small>

                                                </div>


                                            </div>

                                            <div>

                                                <div
                                                    class="form-group {{ $errors->has('Job_title') ? ' has-error' : '' }}">

                                                    <label for="employe-type">المسمى الوظيفي<span

                                                            class="text-danger">*</span></label>

                                                    <select class="myselect" name="Job_title" id="employe-type">

                                                        <option value="">اختر</option>

                                                        <option
                                                            value="1" {{ Auth::user()->Job_title == 1 ? 'selected' : '' }}>
                                                            صاحب عمل
                                                        </option>

                                                        <option
                                                            value="2" {{ Auth::user()->Job_title == 2 ? 'selected' : '' }}>
                                                            مدير عام
                                                        </option>

                                                        <option
                                                            value="3" {{ Auth::user()->Job_title == 3 ? 'selected' : '' }}>
                                                            مدير تسويق
                                                        </option>

                                                        <option
                                                            value="4" {{ Auth::user()->Job_title == 4 ? 'selected' : '' }}>
                                                            مدير فرع
                                                        </option>

                                                        <option
                                                            value="5" {{ Auth::user()->Job_title == 5 ? 'selected' : '' }}>
                                                            اخرى
                                                        </option>

                                                    </select>

                                                    <small class="text-danger">{{ $errors->first('Job_title') }}</small>

                                                </div>


                                            </div>


                                            <div>

                                                <div
                                                    class="form-group {{ $errors->has('Tax_card') ? ' has-error' : '' }}">


                                                    <label for="tax-id">رقم البطاقه الضريبيه<span
                                                            class="text-danger">*</span></label>


                                                    <input type="text" name="Tax_card" id="tax-id" class="myselect"

                                                           placeholder="البطاقه الضريبيه"
                                                           value="{{ Auth::user()->Tax_card }}">

                                                    <small class="text-danger">{{ $errors->first('Tax_card') }}</small>

                                                </div>

                                            </div>


                                            <div>

                                                <div class="form-group">


                                                    <label for="togary-id">رقم السجل التجاري</label>


                                                    <input type="text" name="Commercial_Register" id="togary-id"

                                                           class="myselect" placeholder="السجل التجاري"
                                                           value="{{ Auth::user()->Commercial_Register }}">


                                                </div>

                                            </div>

                                        </div>

                                    @endIf

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


                                                <h5>لتغيير كلمه المرور</h5>


                                            </button>


                                            <div id="collapseOne" class="accordion-collapse collapse"

                                                 aria-labelledby="headingOne" data-bs-parent="#accordionExample">


                                                <div

                                                    class="form-group {{ $errors->has('old_password') ? ' has-error' : '' }}">


                                                    <label for="password">ادخل كلمه المرور الحاليه </label>


                                                    <input type="password" name="old_password" class="myselect"

                                                           id="password" aria-describedby="password"

                                                           placeholder="***********">


                                                    <small

                                                        class="text-danger">{{ $errors->first('old_password') }}</small>


                                                </div>


                                                <div

                                                    class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">


                                                    <label for="password">ادخل كلمه المرور الجديده </label>


                                                    <input type="password" name="password" class="myselect"

                                                           id="password" aria-describedby="password"

                                                           placeholder="***********">


                                                    <small class="text-danger">{{ $errors->first('password') }}</small>


                                                </div>


                                                <div class="form-group">


                                                    <label for="password">اعد ادخال كامه المرور الجديده</label>


                                                    <input type="password" name="password_confirmation"

                                                           class="myselect" id="password-confirm"

                                                           aria-describedby="password" placeholder="Confirm Password">


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

                    <div class="col-md-4 mb-3">


                        <div class="card">


                            <div class="card-body">


                                <div class="dashboard_dashboard d-flex flex-column align-items-center text-center">


                                    @if(!empty(Auth::user()->profile_image))
                                        <img src="{{ URL::to('/').'/'.Auth::user()->profile_image}}" alt="Admin"

                                             class="rounded-circle admin" loading="lazy">
                                    @else
                                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"

                                             class="rounded-circle admin" loading="lazy">
                                    @endif


                                    <div class="mt-5">


                                        <h4> {{ Auth::user()->name }} </h4>


                                        <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history')}}">
                                            <p><strong>عدد النقاط</strong></a>


                                        @if (Auth::user()->userpricin)

                                            @if(Auth::user()->userpricin->current_points >= 0 )

                                                {{ $points = Auth::user()->userpricin->current_points }}

                                            @else

                                                {{$points = 0}}

                                            @endif

                                        @else

                                            {{ $points = 0 }}

                                        @endif



                                        </p>


                                        <hr class="hr-add">


                                        <a data-toggle="tooltip" title="التنبيهات  !"
                                           href="{{ URL::to(Config::get('app.locale').'/notification')}}"
                                           style="<?php if($countNotifi > 0){ ?> color:gold; <?php }?>  ">
                                            <i class="fa fa-bell"></i>
                                        </a>

                                        <a data-toggle="tooltip" title=" اعلاناتي !"
                                           href="{{ URL::to(Config::get('app.locale').'/user_ads') }}"
                                           style="margin:0 10px" type="button"><i class="fa fa-building"></i>
                                        </a>
                                        <a data-toggle="tooltip" title="المفضله !"
                                           href="{{ URL::to(Config::get('app.locale').'/user_wishs')}}"
                                           type="button"><i class="fa fa-heart"></i>
                                        </a>
                                        <a data-toggle="tooltip" title="شكاواي !"
                                           href="{{ URL::to(Config::get('app.locale').'/user_complaints')}}"
                                           style="margin:0 10px" type="button">
                                            <i class="fa fa-exclamation-circle"></i>
                                        </a>

                                        {{-- Delete Account Request Button --}}
                                        <div class="mt-3">
                                            @if(session('delete_request_success'))
                                                <div class="alert alert-success alert-dismissible fade show"
                                                     role="alert">
                                                    <i class="fa fa-check-circle ml-1"></i> {{ session('delete_request_success') }}
                                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                                                    </button>
                                                </div>
                                            @endif
                                            @if(session('delete_request_error'))
                                                <div class="alert alert-warning alert-dismissible fade show"
                                                     role="alert">
                                                    <i class="fa fa-exclamation-triangle ml-1"></i> {{ session('delete_request_error') }}
                                                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
                                                    </button>
                                                </div>
                                            @endif

                                            @php
                                                $pendingDeleteReq = \App\Models\AccountDeleteRequest::where('user_id', auth()->id())->where('status','pending')->first();
                                                $rejectedDeleteReq = \App\Models\AccountDeleteRequest::where('user_id', auth()->id())->where('status','rejected')->orderBy('id','desc')->first();
                                            @endphp

                                            @if($pendingDeleteReq)
                                                <div class="alert alert-warning" style="font-size:13px;">
                                                    <i class="fa fa-clock ml-1"></i> <strong>طلب حذف الحساب قيد
                                                        المراجعة</strong><br>
                                                    <small>تم تقديم الطلب
                                                        بتاريخ {{ $pendingDeleteReq->created_at->format('Y-m-d') }}</small>
                                                </div>
                                            @elseif($rejectedDeleteReq && !$pendingDeleteReq)
                                                <div class="alert alert-danger" style="font-size:13px;">
                                                    <i class="fa fa-times-circle ml-1"></i> <strong>تم رفض طلب حذف
                                                        حسابك</strong><br>
                                                    @if($rejectedDeleteReq->admin_note)
                                                        <small>السبب: {{ $rejectedDeleteReq->admin_note }}</small><br>
                                                    @endif
                                                </div>
                                                <button type="button" id="openDeleteModalBtn"
                                                        class="btn btn-sm btn-outline-danger mt-1">
                                                    <i class="fa fa-trash ml-1"></i> طلب حذف الحساب مجدداً
                                                </button>
                                            @else
                                                <button type="button" id="openDeleteModalBtn"
                                                        class="btn btn-sm btn-outline-danger mt-1">
                                                    <i class="fa fa-trash ml-1"></i> طلب حذف الحساب
                                                </button>
                                            @endif
                                        </div>

                                        {{-- Delete Account Modal --}}
                                        <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog"
                                             aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ URL::to('request-account-delete') }}"
                                                          method="POST">
                                                        @csrf
                                                        <div class="modal-header"
                                                             style="background:#dc3545; color:#fff;">
                                                            <h5 class="modal-title" id="deleteAccountModalLabel">
                                                                <i class="fa fa-trash ml-1"></i> طلب حذف الحساب
                                                            </h5>
                                                            <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="alert alert-warning">
                                                                <i class="fa fa-exclamation-triangle ml-1"></i>
                                                                <strong>تنبيه:</strong> سيتم إرسال طلب حذف حسابك للإدارة
                                                                للمراجعة. سيتم إبلاغك بالقرار.
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deleteReason"><strong>سبب طلب الحذف <span
                                                                            style="color:red">*</span></strong></label>
                                                                <textarea id="deleteReason" name="reason"
                                                                          class="form-control" rows="4"
                                                                          placeholder="اكتب سبب رغبتك في حذف الحساب..."
                                                                          required minlength="10"></textarea>
                                                                @error('reason')
                                                                <small class="text-danger">{{ $message }}</small>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">إلغاء
                                                            </button>
                                                            <button type="submit" class="btn btn-danger">
                                                                <i class="fa fa-paper-plane ml-1"></i> إرسال الطلب
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!--         <a href="{{ URL::to(Config::get('app.locale').'/notification')}}" class="btn btn-info">


                                                {{ trans('langsite.Notifications')}}
                                        @if($countNotifi > 0)
                                            <span class="badge badgedanger badge-pill noti-icon-badge ml-1">{{$countNotifi}}</span>
                                        @endif</a>-->


                                    </div>


                                </div>


                            </div>


                        </div>


                        <div class="sticky mt-3">
                            <x-purchase-now/>

                        </div>

                    </div>


                </div>

            </div>


        </div>

    </section>

    <script>
        window.addEventListener('load', function () {
            var btn = document.getElementById('openDeleteModalBtn');
            if (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
                        $('#deleteAccountModal').modal('show');
                    } else {
                        var modal = document.getElementById('deleteAccountModal');
                        if (modal) {
                            modal.style.display = 'block';
                            modal.classList.add('show');
                            document.body.classList.add('modal-open');
                            var backdrop = document.createElement('div');
                            backdrop.className = 'modal-backdrop fade show';
                            backdrop.id = 'deleteModalBackdrop';
                            document.body.appendChild(backdrop);
                        }
                    }
                });
            }

            // Close modal on [data-dismiss="modal"] click
            document.querySelectorAll('#deleteAccountModal [data-dismiss="modal"]').forEach(function (el) {
                el.addEventListener('click', function () {
                    if (typeof $ !== 'undefined' && $.fn && $.fn.modal) {
                        $('#deleteAccountModal').modal('hide');
                    } else {
                        var modal = document.getElementById('deleteAccountModal');
                        if (modal) {
                            modal.style.display = 'none';
                            modal.classList.remove('show');
                            document.body.classList.remove('modal-open');
                        }
                    }
                    var bd = document.getElementById('deleteModalBackdrop');
                    if (bd) bd.remove();
                });
            });
        });
    </script>

</x-layout>
