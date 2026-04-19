@extends('layouts.admin')
@section('title', 'المستخدمون')

@php
    /* ── RBAC: resolve the correct guard once for the whole page ── */
    $__au = \Illuminate\Support\Facades\Auth::guard('admin')->check()
        ? \Illuminate\Support\Facades\Auth::guard('admin')->user()
        : \Illuminate\Support\Facades\Auth::user();

    $canCreate  = $__au && $__au->hasPermission('users.create');
    $canExport  = $__au && $__au->hasPermission('users.export');
    $canView    = $__au && $__au->hasPermission('users.view');
    $canUpdate  = $__au && $__au->hasPermission('users.update');
    $canDelete  = $__au && $__au->hasPermission('users.delete');
    $canBlock   = $__au && $__au->hasPermission('users.block');
@endphp

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>المستخدمون</h1>
                </div>
                <div class="col-sm-6">
                    @if($canCreate)
                    <a class="btn btn-primary float-right"
                       href="{{ route('sitemanagement.users.create') }}">
                        اضف جديد
                    </a>
                    @endif

                    @if($canExport)
                    <a id="export-users-btn" class="btn btn-success float-right mr-2"
                       href="{{ route('sitemanagement.users.exportUsers', array_filter([
                           'search_key'        => request('search_key'),
                           'filter_status'     => request('filter_status'),
                           'filter_type'       => request('filter_type'),
                           'filter_invited_by' => request('filter_invited_by'),
                           'sortBy'            => request('sortBy'),
                       ])) }}">
                        <i class="fa fa-file-excel ml-1"></i>
                        <span id="export-users-text">تصدير نتائج البحث</span>
                        <span id="export-users-spinner" style="display:none"><i class="fa fa-spinner fa-spin"></i> جاري التصدير...</span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <form action="{{ route('sitemanagement.users.index') }}" method="GET">
                    <div class="users_users_users row align-items-end">
                        <div class="col-md-3">
                            <label>بحث</label>
                            <input type="text" class="form-control" name="search_key"
                                   placeholder="بحث ..." value="{{ request('search_key') }}">
                        </div>
                        <div class="col-md-2">
                            <label>الحالة</label>
                            <select class="form-control" name="filter_status">
                                <option value="">اختر</option>
                                @foreach(\App\Enums\UserStatusEnum::values() as $key => $case)
                                    <option value="{{ $case }}" {{ request('filter_status') !== null && request('filter_status') !== '' && (string)request('filter_status') === (string)$case ? 'selected' : '' }}>
                                        {{ $key }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>النوع</label>
                            <select class="form-control" name="filter_type">
                                <option value="">اختر</option>
                                @foreach(\App\Enums\UserTypeEnum::values() as $key => $case)
                                    <option value="{{ $case }}" {{ request('filter_type') == $case ? 'selected' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>ترتيب حسب</label>
                            <select class="form-control" name="sortBy">
                                <option value="">اختر</option>
                                <option value="0" {{ request('sortBy') == '0' ? 'selected' : '' }}>من الأحدث للأقدم</option>
                                <option value="1" {{ request('sortBy') == '1' ? 'selected' : '' }}>من الأقدم للأحدث</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>مصدر الدعوة</label>
                            <select class="form-control" name="filter_invited_by">
                                <option value="">الكل</option>
                                @foreach($invitedByOptions as $option)
                                    <option value="{{ $option }}" {{ request('filter_invited_by') == $option ? 'selected' : '' }}>
                                        {{ $option }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>اظهار</label>
                            <select name="show" class="form-control">
                                <option value="10">10</option>
                                <option value="25"  {{ request('show') == 25  ? 'selected' : '' }}>25</option>
                                <option value="50"  {{ request('show') == 50  ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('show') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fa fa-filter"></i>
                            </button>
                        </div>
                        <div class="col-md-1">
                            <a href="{{ route('sitemanagement.users.index') }}" class="btn btn-secondary btn-block">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>اسم</th>
                            <th>نوع</th>
                            <th>الباقة</th>
                            <th>التليفون المحمول</th>
                            <th>عدد العقارات</th>
                            <th>مصدر الدعوة</th>
                            <th>التاريخ</th>
                            <th>حالة</th>
                            <th>حدث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ implode(' ', array_slice(explode(' ', $user->name), 0, 3)) }}</td>
                                <td>{{ $user->getUserType() }}</td>
                                <td>
                                    @foreach($user->UserPriceing as $val)
                                        {{ $val->type ?? '' }}
                                    @endforeach
                                </td>
                                <td>{{ $user->MOP }}</td>
                                <td>
                                    <a href="{{ route('sitemanagement.users.aqars', $user->id) }}"
                                       class="badge badge-info" style="font-size:13px;">
                                        {{ $user->aqars_count }}
                                    </a>
                                </td>
                                <td>
                                    @if($user->invited_by)
                                        <span class="badge badge-primary">{{ $user->invited_by }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $user->created_at->format('Y-m-d') }}</div>
                                    <div class="text-muted small">{{ $user->created_at->format('H:i:s') }}</div>
                                </td>
                                <td>
                                    @if($user->status == 1)
                                        <span class="badge badge-success">{{ $user->getStatus() }}</span>
                                    @elseif($user->status == 0)
                                        <span class="badge badge-warning">{{ $user->getStatus() }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $user->getStatus() }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($canBlock)
                                        @if($user->status == 1)
                                            <a onclick="return confirm('هل انت متأكد من حظر هذا المستخدم؟')"
                                               data-toggle="tooltip" title="حظر المستخدم"
                                               href="{{ route('sitemanagement.users.block', $user->id) }}"
                                               class="btn btn-sm btn-outline-danger ml-2">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @elseif($user->status != 0)
                                            <a onclick="return confirm('هل انت متأكد من تفعيل هذا المستخدم؟')"
                                               data-toggle="tooltip" title="تفعيل المستخدم"
                                               href="{{ route('sitemanagement.users.activate', $user->id) }}"
                                               class="btn btn-sm btn-outline-success ml-2">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if($canDelete)
                                        <a onclick="return confirm('هل انت متأكد من حذف هذا السجل؟')"
                                           data-toggle="tooltip" title="حذف"
                                           href="{{ route('sitemanagement.users.delete', $user->id) }}"
                                           class="btn btn-sm btn-outline-danger ml-2">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    @endif

                                    @if($canUpdate)
                                        <a href="{{ route('sitemanagement.users.edit', $user->id) }}"
                                           class="btn btn-sm btn-outline-info ml-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endif

                                    @if($canView)
                                        <a href="{{ route('sitemanagement.users.show', $user->id) }}"
                                           class="btn btn-sm btn-outline-primary ml-2">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif

                                    @if($canUpdate)
                                        @php
                                            $userPoints = $user->UserPriceing->last();
                                            $currentPts = $userPoints ? $userPoints->current_points : 0;
                                        @endphp
                                        <button type="button"
                                                class="btn btn-sm btn-outline-warning ml-2 btn-add-points"
                                                data-toggle="tooltip" title="إضافة نقاط"
                                                data-user-id="{{ $user->id }}"
                                                data-user-name="{{ $user->name }}"
                                                data-current-points="{{ $currentPts }}"
                                                data-action="{{ route('sitemanagement.users.addPoints', $user->id) }}"
                                                data-points-url="{{ route('sitemanagement.users.getPoints', $user->id) }}">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══ Modal: إضافة نقاط ═══ --}}
    <div class="modal fade" id="addPointsModal" tabindex="-1" role="dialog" aria-labelledby="addPointsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="max-width:420px">
            <div class="modal-content border-0 shadow-lg" style="border-radius:16px;overflow:hidden">
                {{-- Header --}}
                <div class="modal-header text-white border-0 pb-0"
                     style="background:linear-gradient(135deg,#f7971e,#ffd200);padding:24px 24px 0">
                    <div class="w-100 text-center">
                        <div class="mb-2" style="font-size:2.4rem"><i class="fas fa-star"></i></div>
                        <h5 class="modal-title font-weight-bold" id="addPointsModalLabel" style="font-size:1.2rem">
                            إضافة نقاط للمستخدم
                        </h5>
                        <p class="mb-0 mt-1 small" id="modal-user-name" style="opacity:.85"></p>
                    </div>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close"
                            style="position:absolute;left:14px;top:12px;opacity:.8;font-size:1.4rem">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                {{-- Body --}}
                <div class="modal-body" style="padding:28px 28px 10px">

                    {{-- Loading overlay --}}
                    <div id="modal-loading" class="text-center py-4" style="display:none">
                        <i class="fas fa-spinner fa-spin fa-2x" style="color:#f59e0b"></i>
                        <div class="mt-2 text-muted small">جاري تحميل البيانات...</div>
                    </div>

                    {{-- Main content (hidden while loading) --}}
                    <div id="modal-body-content">
                        {{-- Current points card --}}
                        <div class="d-flex align-items-center justify-content-between rounded-lg p-3 mb-4"
                             style="background:#fff8e1;border:1px solid #ffe082;border-radius:12px!important">
                            <div>
                                <div class="text-muted small mb-1">النقاط الحالية</div>
                                <div class="font-weight-bold" style="font-size:1.8rem;color:#f59e0b" id="modal-current-points">0</div>
                            </div>
                            <div style="font-size:2.5rem;color:#fcd34d"><i class="fas fa-coins"></i></div>
                        </div>

                        <form id="addPointsForm" onsubmit="return false;">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="font-weight-bold text-dark mb-1">النقاط الإضافية</label>
                                <div class="input-group" style="border-radius:10px;overflow:hidden">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border-0"
                                              style="background:#f3f4f6;color:#f59e0b;font-size:1.1rem">
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                    </div>
                                    <input type="number" name="extra_points" id="extra_points_input"
                                           class="form-control border-0"
                                           style="background:#f3f4f6;font-size:1.1rem"
                                           min="1" placeholder="مثال: 50" required>
                                </div>
                            </div>

                            {{-- Preview --}}
                            <div class="text-center small text-muted mb-2" id="points-preview" style="display:none">
                                سيصبح الرصيد:
                                <span class="font-weight-bold text-success" id="points-after" style="font-size:1rem"></span>
                                نقطة
                            </div>

                            {{-- Error --}}
                            <div id="modal-error" class="alert alert-danger py-2 mt-2" style="display:none;border-radius:8px"></div>
                        </form>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="modal-footer border-0" style="padding:10px 28px 22px;gap:8px">
                    <button type="button" class="btn btn-light btn-block mb-1" data-dismiss="modal"
                            style="border-radius:10px;font-weight:600">إلغاء</button>
                    <button type="button" id="confirmAddPoints" class="btn btn-block text-white"
                            style="background:linear-gradient(135deg,#f7971e,#ffd200);border:none;border-radius:10px;font-weight:700;font-size:1rem">
                        <i class="fas fa-star ml-1"></i> إضافة النقاط
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // ── Export button spinner ─────────────────────────────────────
            var exportBtn     = document.getElementById('export-users-btn');
            var exportText    = document.getElementById('export-users-text');
            var exportSpinner = document.getElementById('export-users-spinner');
            if (exportBtn) {
                exportBtn.addEventListener('click', function () {
                    exportBtn.classList.add('disabled');
                    exportText.style.display    = 'none';
                    exportSpinner.style.display = '';
                    setTimeout(function () {
                        exportBtn.classList.remove('disabled');
                        exportText.style.display    = '';
                        exportSpinner.style.display = 'none';
                    }, 5000);
                });
            }

            // ── Add-points modal (AJAX) ───────────────────────────────────
            var currentPts   = 0;
            var activeBtn    = null;
            var actionUrl    = '';

            document.querySelectorAll('.btn-add-points').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    activeBtn = this;
                    actionUrl = this.dataset.action;
                    var pointsUrl = this.dataset.pointsUrl;

                    // إظهار الموديل مع حالة تحميل
                    document.getElementById('modal-user-name').textContent      = this.dataset.userName;
                    document.getElementById('extra_points_input').value         = '';
                    document.getElementById('points-preview').style.display     = 'none';
                    document.getElementById('modal-error').style.display        = 'none';
                    document.getElementById('modal-loading').style.display      = '';
                    document.getElementById('modal-body-content').style.display = 'none';
                    document.getElementById('confirmAddPoints').disabled        = true;

                    $('#addPointsModal').modal('show');

                    // جلب البيانات الحديثة من السيرفر
                    var csrfToken = document.querySelector('meta[name="csrf-token"]');
                    var token     = csrfToken ? csrfToken.getAttribute('content') : '';

                    fetch(pointsUrl, {
                        method : 'GET',
                        headers: {
                            'Accept'          : 'application/json',
                            'X-CSRF-TOKEN'    : token,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    })
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.success) {
                            currentPts = data.current_points;
                            document.getElementById('modal-current-points').textContent = currentPts;
                            document.getElementById('modal-user-name').textContent      = data.user_name;
                            // تحديث الزر بالبيانات الجديدة
                            if (activeBtn) {
                                activeBtn.dataset.currentPoints = currentPts;
                            }
                        }
                    })
                    .catch(function () {
                        // fallback: استخدم البيانات المخزنة في data-attribute
                        currentPts = parseInt(activeBtn.dataset.currentPoints) || 0;
                        document.getElementById('modal-current-points').textContent = currentPts;
                    })
                    .finally(function () {
                        document.getElementById('modal-loading').style.display      = 'none';
                        document.getElementById('modal-body-content').style.display = '';
                        document.getElementById('confirmAddPoints').disabled        = false;
                    });
                });
            });

            // ── Live preview ──────────────────────────────────────────────
            document.getElementById('extra_points_input').addEventListener('input', function () {
                var extra   = parseInt(this.value) || 0;
                var preview = document.getElementById('points-preview');
                var after   = document.getElementById('points-after');
                if (extra > 0) {
                    after.textContent     = currentPts + extra;
                    preview.style.display = '';
                } else {
                    preview.style.display = 'none';
                }
            });

            // ── Confirm → AJAX ────────────────────────────────────────────
            document.getElementById('confirmAddPoints').addEventListener('click', function () {
                var input   = document.getElementById('extra_points_input');
                var errorEl = document.getElementById('modal-error');
                var extra   = parseInt(input.value);

                if (!extra || extra < 1) {
                    input.focus();
                    return;
                }

                var confirmBtn = this;
                confirmBtn.disabled = true;
                confirmBtn.innerHTML = '<i class="fas fa-spinner fa-spin ml-1"></i> جاري الحفظ...';
                errorEl.style.display = 'none';

                var csrfToken = document.querySelector('meta[name="csrf-token"]');
                var token     = csrfToken ? csrfToken.getAttribute('content') : '';

                fetch(actionUrl, {
                    method : 'POST',
                    headers: {
                        'Content-Type'    : 'application/json',
                        'Accept'          : 'application/json',
                        'X-CSRF-TOKEN'    : token,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ extra_points: extra }),
                })
                .then(function (res) { return res.json(); })
                .then(function (data) {
                    if (data.success) {
                        // ── تحديث النقاط في الزر بدون إعادة تحميل ────
                        if (activeBtn) {
                            activeBtn.dataset.currentPoints = data.new_points;
                        }
                        // أغلق الموديل
                        $('#addPointsModal').modal('hide');

                        // رسالة نجاح خفيفة
                        showToast(data.message, 'success');
                    } else {
                        errorEl.textContent    = data.message || 'حدث خطأ، حاول مرة أخرى';
                        errorEl.style.display  = '';
                    }
                })
                .catch(function () {
                    errorEl.textContent   = 'حدث خطأ في الاتصال، حاول مرة أخرى';
                    errorEl.style.display = '';
                })
                .finally(function () {
                    confirmBtn.disabled     = false;
                    confirmBtn.innerHTML    = '<i class="fas fa-star ml-1"></i> إضافة النقاط';
                });
            });

            // ── Toast بسيط ───────────────────────────────────────────────
            function showToast(msg, type) {
                var t = document.createElement('div');
                t.textContent = msg;
                t.style.cssText = [
                    'position:fixed', 'bottom:28px', 'left:50%',
                    'transform:translateX(-50%)',
                    'background:' + (type === 'success' ? '#16a34a' : '#dc2626'),
                    'color:#fff', 'padding:12px 28px', 'border-radius:10px',
                    'font-size:1rem', 'font-weight:600', 'z-index:9999',
                    'box-shadow:0 4px 16px rgba(0,0,0,.18)',
                    'transition:opacity .4s',
                ].join(';');
                document.body.appendChild(t);
                setTimeout(function () {
                    t.style.opacity = '0';
                    setTimeout(function () { t.remove(); }, 500);
                }, 2800);
            }
        });
    </script>
@endsection
