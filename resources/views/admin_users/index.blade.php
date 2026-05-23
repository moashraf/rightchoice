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

    $activeUserTypeTab = in_array(request('type_tab'), ['companies', 'developer', 'normal'], true)
        ? request('type_tab')
        : 'all';
    $userTypeTabs = [
        'all'       => 'الكل',
        'companies' => 'الشركات',
        'developer' => 'مطور عقاري',
        'normal'    => 'مستخدم عادي',
    ];
    $userTypeTabBaseQuery = request()->except(['page', 'type_tab', 'filter_type']);
    $exportUsersParams = request()->only([
        'search_key',
        'filter_status',
        'filter_type',
        'type_tab',
        'filter_invited_by',
        'filter_user_id',
        'has_package',
        'has_aqars',
        'sortBy',
    ]);
    $exportUsersParams = array_filter($exportUsersParams, function ($value) {
        return $value !== null && $value !== '';
    });
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
                       href="{{ route('sitemanagement.users.exportUsers', $exportUsersParams) }}">
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

        @if(request()->filled('filter_user_id'))
        <div class="alert alert-info d-flex justify-content-between align-items-center">
            <span>
                <i class="fas fa-filter ml-1"></i>
                عرض المستخدم رقم: <strong>#{{ request('filter_user_id') }}</strong>
            </span>
            <a href="{{ route('sitemanagement.users.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-times ml-1"></i> إلغاء الفلتر
            </a>
        </div>
        @endif

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
                <ul class="nav nav-pills mb-3">
                    @foreach($userTypeTabs as $tabKey => $tabLabel)
                        @php
                            $tabQuery = $userTypeTabBaseQuery;
                            if ($tabKey !== 'all') {
                                $tabQuery['type_tab'] = $tabKey;
                            }
                        @endphp
                        <li class="nav-item ml-2 mb-2">
                            <a href="{{ route('sitemanagement.users.index', $tabQuery) }}"
                               class="nav-link {{ $activeUserTypeTab === $tabKey ? 'active' : '' }}">
                                {{ $tabLabel }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <form action="{{ route('sitemanagement.users.index') }}" method="GET">
                    @if($activeUserTypeTab !== 'all')
                        <input type="hidden" name="type_tab" value="{{ $activeUserTypeTab }}">
                    @endif
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
                            <select class="form-control" name="filter_type" {{ $activeUserTypeTab !== 'all' ? 'disabled' : '' }}>
                                <option value="">اختر</option>
                                @foreach(\App\Enums\UserTypeEnum::values() as $key => $case)
                                    <option value="{{ $case }}" {{ request('filter_type') == $case ? 'selected' : '' }}>{{ $key }}</option>
                                @endforeach
                            </select>
                            @if($activeUserTypeTab !== 'all')
                                <small class="text-muted">الفلتر مطبق من التابات بالأعلى</small>
                            @endif
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
                        <div class="col-md-2">
                            <label>الباقة</label>
                            <select class="form-control" name="has_package">
                                <option value="">الكل</option>
                                <option value="1" {{ request('has_package') === '1' ? 'selected' : '' }}>مشترك في باقة</option>
                                <option value="0" {{ request('has_package') === '0' ? 'selected' : '' }}>غير مشترك في باقة</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>العقارات</label>
                            <select class="form-control" name="has_aqars">
                                <option value="">الكل</option>
                                <option value="1" {{ request('has_aqars') === '1' ? 'selected' : '' }}>أضاف عقارات</option>
                                <option value="0" {{ request('has_aqars') === '0' ? 'selected' : '' }}>لم يضف عقارات</option>
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
                            <th>#</th>
                            <th>ID</th>

                            <th>اسم</th>
                            <th>نوع</th>
                             <th>التليفون المحمول</th>
                            <th>عدد العقارات</th>
                            <th>مصدر الدعوة</th>
                            <th>الاشتراك</th>
                            <th>التاريخ</th>
                            <th>حالة</th>
                            <th>حدث</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $users->total() - ($users->currentPage() - 1) * $users->perPage() - $loop->index }}</td>
                                <td>{{ $user->id }}</td>

                                <td>{{ implode(' ', array_slice(explode(' ', $user->name), 0, 3)) }}</td>
                                <td>{{ $user->getUserType() }}</td>

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
                                    @php
                                        $packages = $user->userpricing->sortByDesc('id');
                                        $packagesCount = $packages->count();
                                        $contactCount = $user->contact_count ?? 0;
                                    @endphp
                                    @if($packagesCount > 0)
                                        <div class="mb-1">
                                            <span class="badge badge-secondary" style="font-size:11px;">
                                                <i class="fas fa-layer-group ml-1"></i> {{ $packagesCount }} باقة
                                            </span>
                                            <a href="{{ route('sitemanagement.users.packages', $user->id) }}"
                                               class="badge badge-info" style="font-size:11px;" title="عرض العقارات التي تواصل معها" target="_blank">
                                                <i class="fas fa-phone ml-1"></i> {{ $contactCount }} تواصل
                                            </a>
                                        </div>
                                        @foreach($packages as $pkg)
                                            @php
                                                $pkgName = optional($pkg->pricing)->type ?? ('باقة #'.$pkg->pricing_id);
                                            @endphp
                                            <div class="mb-1 p-1 border rounded" style="font-size:11px; background:#f8f9fa;">
                                                <strong class="text-success">{{ $pkgName }}</strong><br>
                                                <span class="text-muted">أساسية:</span>
                                                <span class="badge badge-primary">{{ number_format($pkg->start_points) }}</span>
                                                &nbsp;
                                                <span class="text-muted">متبقية:</span>
                                                <span class="badge badge-{{ $pkg->current_points > 0 ? 'success' : 'danger' }}">
                                                    {{ number_format($pkg->current_points) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div>
                                            <span class="badge badge-light text-muted" style="font-size:12px;">
                                                <i class="fas fa-times-circle ml-1"></i> غير مشترك
                                            </span>
                                            @if($contactCount > 0)
                                                <a href="{{ route('sitemanagement.users.packages', $user->id) }}"
                                                   class="badge badge-info" style="font-size:11px;" title="عرض العقارات التي تواصل معها" target="_blank">
                                                    <i class="fas fa-phone ml-1"></i> {{ $contactCount }} تواصل
                                                </a>
                                            @endif
                                        </div>
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

    {{-- Modal: إضافة نقاط --}}
    @include('admin_users.partials.add_points_modal')
@endsection

@section('third_party_scripts')
    @include('admin_users.partials.add_points_scripts')
@endsection
