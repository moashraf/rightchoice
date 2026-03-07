{{-- ============================
     Profile Sidebar Component
     @usage: @include('components.profile-sidebar')
     ============================--}}
@php
    $user        = auth()->user();
    $points      = 0;
    if ($user && $user->userpricin) {
        $points = $user->userpricin->current_points >= 0 ? $user->userpricin->current_points : 0;
    }
    $countNotifi     = isset($countNotifi) ? $countNotifi : 0;
    $pendingDeleteReq  = \App\Models\AccountDeleteRequest::where('user_id', auth()->id())->where('status','pending')->first();
    $rejectedDeleteReq = \App\Models\AccountDeleteRequest::where('user_id', auth()->id())->where('status','rejected')->orderBy('id','desc')->first();
@endphp

<div class="col-md-4 mb-3">
    <div class="card">
        <div class="card-body">
            <div class="dashboard_dashboard d-flex flex-column align-items-center text-center">

                {{-- Profile Image --}}
                @if($user && $user->profile_image)
                    <img src="{{ URL::to('/').'/'.($user->profile_image) }}"
                         alt="Admin" class="rounded-circle admin" loading="lazy">
                @else
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                         alt="Admin" class="rounded-circle admin" loading="lazy">
                @endif

                <div class="mt-5">

                    <h4>{{ $user->name ?? '' }}</h4>

                    <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}">
                        <p><strong>عدد النقاط</strong> {{ number_format($points) }}</p>
                    </a>

                    <hr class="hr-add">

                    {{-- Quick Links --}}
                    <a data-toggle="tooltip" title="التنبيهات !"
                       href="{{ URL::to(Config::get('app.locale').'/notification') }}"
                       style="{{ $countNotifi > 0 ? 'color:gold;' : '' }}">
                        <i class="fa fa-bell"></i>
                    </a>

                    <a data-toggle="tooltip" title="اعلاناتي !"
                       href="{{ URL::to(Config::get('app.locale').'/user_ads') }}"
                       style="margin:0 10px">
                        <i class="fa fa-building"></i>
                    </a>

                    <a data-toggle="tooltip" title="المفضله !"
                       href="{{ URL::to(Config::get('app.locale').'/user_wishs') }}">
                        <i class="fa fa-heart"></i>
                    </a>

                    <a data-toggle="tooltip" title="شكاواي !"
                       href="{{ URL::to(Config::get('app.locale').'/user_complaints') }}"
                       style="margin:0 10px">
                        <i class="fa fa-exclamation-circle"></i>
                    </a>

                    {{-- Delete Account Request --}}
                    <div class="mt-3">

                        @if(session('delete_request_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa fa-check-circle ml-1"></i> {{ session('delete_request_success') }}
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        @endif

                        @if(session('delete_request_error'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <i class="fa fa-exclamation-triangle ml-1"></i> {{ session('delete_request_error') }}
                                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                            </div>
                        @endif

                        @if($pendingDeleteReq)
                            <div class="alert alert-warning" style="font-size:13px;">
                                <i class="fa fa-clock ml-1"></i> <strong>طلب حذف الحساب قيد المراجعة</strong><br>
                                <small>تم تقديم الطلب بتاريخ {{ $pendingDeleteReq->created_at->format('Y-m-d') }}</small>
                            </div>
                        @elseif($rejectedDeleteReq && !$pendingDeleteReq)
                            <div class="alert alert-danger" style="font-size:13px;">
                                <i class="fa fa-times-circle ml-1"></i> <strong>تم رفض طلب حذف حسابك</strong><br>
                                @if($rejectedDeleteReq->admin_note)
                                    <small>السبب: {{ $rejectedDeleteReq->admin_note }}</small><br>
                                @endif
                            </div>
                            <button type="button" id="openDeleteModalBtn" class="btn btn-sm btn-outline-danger mt-1">
                                <i class="fa fa-trash ml-1"></i> طلب حذف الحساب مجدداً
                            </button>
                        @else
                            <button type="button" id="openDeleteModalBtn" class="btn btn-sm btn-outline-danger mt-1">
                                <i class="fa fa-trash ml-1"></i> طلب حذف الحساب
                            </button>
                        @endif

                    </div>

                    {{-- Delete Account Modal --}}
                    <div class="modal fade" id="deleteAccountModal" tabindex="-1" role="dialog"
                         aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <form action="{{ URL::to('request-account-delete') }}" method="POST">
                                    @csrf
                                    <div class="modal-header" style="background:#dc3545; color:#fff;">
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
                                            <strong>تنبيه:</strong> سيتم إرسال طلب حذف حسابك للإدارة للمراجعة.
                                        </div>
                                        <div class="form-group">
                                            <label for="deleteReason">
                                                <strong>سبب طلب الحذف <span style="color:red">*</span></strong>
                                            </label>
                                            <textarea id="deleteReason" name="reason" class="form-control" rows="4"
                                                      placeholder="اكتب سبب رغبتك في حذف الحساب..."
                                                      required minlength="10"></textarea>
                                            @error('reason')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-paper-plane ml-1"></i> إرسال الطلب
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="sticky mt-3">
            <x-purchase-now/>
        </div>
    </div>



</div>

{{-- Modal Script --}}
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
