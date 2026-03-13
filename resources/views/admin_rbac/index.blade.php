@extends('layouts.admin')
@section('title', 'إدارة الصلاحيات والأدوار')

@push('page_css')
<style>
    /* ── Matrix table ─────────────────────────────────────── */
    #rbac-matrix { font-size: 13px; }
    #rbac-matrix thead th.role-col {
        writing-mode: vertical-rl;
        text-orientation: mixed;
        transform: rotate(180deg);
        white-space: nowrap;
        min-width: 44px;
        max-width: 60px;
        text-align: center;
        vertical-align: bottom;
        padding-bottom: 8px;
        font-size: 12px;
    }
    #rbac-matrix th.perm-name { min-width: 200px; }
    #rbac-matrix .module-header td {
        background: #343a40;
        color: #fff;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: .5px;
        padding: 5px 10px;
    }
    #rbac-matrix tbody tr:hover { background: #f8f9fa; }
    .perm-checkbox { width: 18px; height: 18px; cursor: pointer; }
    .role-badge { font-size: 11px; }

    /* ── Role colour codes ───────────────────────────────── */
    .role-admin  { color: #dc3545; }
    .role-viewer { color: #6c757d; }
    .role-user   { color: #007bff; }

    /* ── Quick-toggle column highlight ──────────────────── */
    .col-highlight { background: #fff3cd !important; }

    /* ── Sticky header ───────────────────────────────────── */
    .table-sticky thead th { position: sticky; top: 0; z-index: 2; background: #fff; }

    /* ── Select-all row ──────────────────────────────────── */
    #rbac-matrix .select-all-row td { background: #e9ecef; }

    .card-rbac { border-top: 3px solid #007bff; }
</style>
@endpush

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1><i class="fas fa-shield-alt text-primary mr-2"></i>إدارة الأدوار والصلاحيات</h1>
            </div>
            <div class="col-sm-6 text-right">
                <span class="badge badge-primary p-2">
                    {{ $roles->count() }} أدوار &nbsp;|&nbsp; {{ $permissions->count() }} صلاحية
                </span>
            </div>
        </div>
    </div>
</section>

<div class="content px-3">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 1: Permission Matrix
    ══════════════════════════════════════════════════════════════ --}}
    <div class="card card-rbac mb-4">
        <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="mb-0"><i class="fas fa-table mr-1 text-primary"></i> مصفوفة الصلاحيات</h5>
            <div class="d-flex align-items-center gap-2">
                <input type="text" id="permSearch" class="form-control form-control-sm" placeholder="🔍 بحث في الصلاحيات..." style="max-width:220px;">
                <button type="button" class="btn btn-sm btn-outline-secondary ml-2" id="expandAllBtn">
                    <i class="fas fa-expand-alt"></i> توسيع الكل
                </button>
                <button form="rbac-form" type="submit" class="btn btn-success btn-sm ml-1">
                    <i class="fas fa-save mr-1"></i> حفظ التغييرات
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <form id="rbac-form" method="POST" action="{{ route('sitemanagement.rbac.updateMatrix') }}">
                @csrf
                <div class="table-responsive" style="max-height:600px; overflow-y:auto;">
                    <table class="table table-bordered table-sm table-sticky mb-0" id="rbac-matrix">
                        <thead>
                            <tr>
                                <th class="perm-name" style="min-width:200px;">الصلاحية</th>
                                <th class="text-center" style="min-width:55px; font-size:11px; color:#888;">الوحدة</th>
                                @foreach($roles as $role)
                                    @php
                                        $roleClass = match($role->name) {
                                            'admin'  => 'role-admin',
                                            'viewer' => 'role-viewer',
                                            default  => 'role-user',
                                        };
                                        $roleIcon = match($role->name) {
                                            'admin'  => 'fas fa-crown',
                                            'viewer' => 'fas fa-eye',
                                            default  => 'fas fa-user',
                                        };
                                    @endphp
                                    <th class="role-col text-center" data-role-id="{{ $role->id }}">
                                        <i class="{{ $roleIcon }} {{ $roleClass }}"></i>
                                        <span class="{{ $roleClass }}">{{ $role->label ?? $role->name }}</span>
                                    </th>
                                @endforeach
                            </tr>
                            {{-- Select-All row --}}
                            <tr class="select-all-row">
                                <td><strong style="font-size:11px;">تحديد / إلغاء الكل</strong></td>
                                <td></td>
                                @foreach($roles as $role)
                                    <td class="text-center">
                                        <input type="checkbox"
                                               class="perm-checkbox select-all-role"
                                               data-role-id="{{ $role->id }}"
                                               title="تحديد كل صلاحيات {{ $role->label ?? $role->name }}">
                                    </td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grouped as $module => $perms)
                                {{-- Module group header --}}
                                <tr class="module-header" data-module="{{ $module }}">
                                    <td colspan="{{ $roles->count() + 2 }}">
                                        <i class="fas fa-layer-group mr-1"></i>
                                        {{ strtoupper($module) }}
                                        <span class="badge badge-secondary ml-2">{{ $perms->count() }}</span>
                                    </td>
                                </tr>
                                @foreach($perms as $permission)
                                    <tr class="perm-row" data-module="{{ $module }}" data-perm-name="{{ strtolower($permission->name) }}">
                                        <td>
                                            <span class="font-weight-bold">{{ $permission->label }}</span>
                                            <br>
                                            <code style="font-size:10px; color:#888;">{{ $permission->name }}</code>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-light border" style="font-size:10px;">
                                                {{ $permission->module }}
                                            </span>
                                        </td>
                                        @foreach($roles as $role)
                                            @php
                                                $checked = $role->permissions->contains('id', $permission->id);
                                            @endphp
                                            <td class="text-center" data-role-id="{{ $role->id }}">
                                                <input type="checkbox"
                                                       class="perm-checkbox role-perm-check"
                                                       name="matrix[{{ $role->id }}][]"
                                                       value="{{ $permission->id }}"
                                                       data-role-id="{{ $role->id }}"
                                                       data-perm-id="{{ $permission->id }}"
                                                       {{ $checked ? 'checked' : '' }}>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Save button (bottom) --}}
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-1"></i> حفظ جميع الصلاحيات
                    </button>
                    <small class="text-muted ml-3">
                        <i class="fas fa-info-circle"></i>
                        أي تغيير في المصفوفة يسري فوراً على كل المستخدمين الذين يحملون هذا الدور.
                    </small>
                </div>
            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 2: Roles & Permissions management (side by side)
    ══════════════════════════════════════════════════════════════ --}}
    <div class="row">

        {{-- Roles Card --}}
        <div class="col-md-5">
            <div class="card card-rbac">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user-tag mr-1 text-danger"></i> الأدوار</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>الاسم (key)</th>
                                <th>التسمية</th>
                                <th>الصلاحيات</th>
                                <th>المستخدمون</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                                @php
                                    $badgeColor = match($role->name) {
                                        'admin'  => 'danger',
                                        'viewer' => 'secondary',
                                        default  => 'primary',
                                    };
                                    $isCore = in_array($role->name, ['admin','user','viewer']);
                                @endphp
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        <span class="badge badge-{{ $badgeColor }}">{{ $role->name }}</span>
                                    </td>
                                    <td>{{ $role->label }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $role->permissions->count() }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">
                                            {{ \App\Models\User::where('role_id', $role->id)->count() }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(!$isCore)
                                            <form method="POST"
                                                  action="{{ route('sitemanagement.rbac.roles.destroy', $role) }}"
                                                  onsubmit="return confirm('هل أنت متأكد من حذف الدور {{ $role->name }}؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-xs btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-muted" title="دور أساسي - محمي">
                                                <i class="fas fa-lock fa-sm"></i>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Add new role --}}
                <div class="card-footer">
                    <p class="font-weight-bold text-sm mb-2"><i class="fas fa-plus-circle text-success mr-1"></i> إضافة دور جديد</p>
                    <form method="POST" action="{{ route('sitemanagement.rbac.roles.store') }}">
                        @csrf
                        <div class="form-group mb-1">
                            <input type="text" name="name" class="form-control form-control-sm"
                                   placeholder="اسم الدور بالإنجليزية (مثال: moderator)"
                                   value="{{ old('name') }}">
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" name="label" class="form-control form-control-sm"
                                   placeholder="التسمية (مثال: مشرف)"
                                   value="{{ old('label') }}">
                        </div>
                        <div class="form-group mb-1">
                            <input type="text" name="description" class="form-control form-control-sm"
                                   placeholder="وصف اختياري"
                                   value="{{ old('description') }}">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm btn-block">
                            <i class="fas fa-save mr-1"></i> حفظ الدور
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Permissions Card --}}
        <div class="col-md-7">
            <div class="card card-rbac">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-key mr-1 text-warning"></i> الصلاحيات</h5>
                    <input type="text" id="permListSearch" class="form-control form-control-sm"
                           placeholder="🔍 بحث..." style="max-width:180px;">
                </div>
                <div class="card-body p-0" style="max-height:450px; overflow-y:auto;">
                    <table class="table table-sm table-hover mb-0" id="permListTable">
                        <thead class="thead-light" style="position:sticky;top:0;z-index:1;">
                            <tr>
                                <th>الصلاحية</th>
                                <th>التسمية</th>
                                <th>الوحدة</th>
                                <th>الأدوار</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $perm)
                                <tr class="perm-list-row">
                                    <td><code style="font-size:11px;">{{ $perm->name }}</code></td>
                                    <td style="font-size:12px;">{{ $perm->label }}</td>
                                    <td>
                                        <span class="badge badge-light border">{{ $perm->module }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">{{ $perm->roles->count() }}</span>
                                    </td>
                                    <td>
                                        <form method="POST"
                                              action="{{ route('sitemanagement.rbac.permissions.destroy', $perm) }}"
                                              onsubmit="return confirm('هل أنت متأكد من حذف الصلاحية {{ $perm->name }}؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-xs btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Add new permission --}}
                <div class="card-footer">
                    <p class="font-weight-bold text-sm mb-2"><i class="fas fa-plus-circle text-success mr-1"></i> إضافة صلاحية جديدة</p>
                    <form method="POST" action="{{ route('sitemanagement.rbac.permissions.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4 mb-1">
                                <input type="text" name="name" class="form-control form-control-sm"
                                       placeholder="module.action"
                                       value="{{ old('name') }}">
                            </div>
                            <div class="col-md-4 mb-1">
                                <input type="text" name="label" class="form-control form-control-sm"
                                       placeholder="التسمية"
                                       value="{{ old('label') }}">
                            </div>
                            <div class="col-md-4 mb-1">
                                <input type="text" name="module" class="form-control form-control-sm"
                                       placeholder="الوحدة (module)"
                                       value="{{ old('module') }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-warning btn-sm btn-block mt-1">
                            <i class="fas fa-save mr-1"></i> حفظ الصلاحية
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         SECTION 3: Role → Users quick-view
    ══════════════════════════════════════════════════════════════ --}}
    <div class="card card-rbac mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-users mr-1 text-info"></i> توزيع المستخدمين على الأدوار</h5>
        </div>
        <div class="card-body">
            <div class="row text-center">
                @foreach($roles as $role)
                    @php
                        $count      = \App\Models\User::where('role_id', $role->id)->count();
                        $colorClass = match($role->name) {
                            'admin'  => 'danger',
                            'viewer' => 'secondary',
                            default  => 'primary',
                        };
                        $icon = match($role->name) {
                            'admin'  => 'fas fa-crown',
                            'viewer' => 'fas fa-eye',
                            default  => 'fas fa-user',
                        };
                    @endphp
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-{{ $colorClass }} elevation-1">
                                <i class="{{ $icon }}"></i>
                            </span>
                            <div class="info-box-content text-left">
                                <span class="info-box-text">{{ $role->label ?? $role->name }}</span>
                                <span class="info-box-number">{{ $count }} مستخدم</span>
                                <div class="progress">
                                    @php $total = \App\Models\User::count() ?: 1; @endphp
                                    <div class="progress-bar bg-{{ $colorClass }}"
                                         style="width: {{ round($count / $total * 100) }}%"></div>
                                </div>
                                <span class="progress-description">
                                    {{ round($count / $total * 100) }}% من المستخدمين
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{-- No role --}}
                @php $noRole = \App\Models\User::whereNull('role_id')->count(); @endphp
                @if($noRole > 0)
                    <div class="col-md-3 col-6 mb-3">
                        <div class="info-box shadow-sm">
                            <span class="info-box-icon bg-warning elevation-1">
                                <i class="fas fa-question"></i>
                            </span>
                            <div class="info-box-content text-left">
                                <span class="info-box-text">بدون دور</span>
                                <span class="info-box-number text-danger">{{ $noRole }} مستخدم</span>
                                <div class="progress">
                                    <div class="progress-bar bg-warning"
                                         style="width: {{ round($noRole / $total * 100) }}%"></div>
                                </div>
                                <span class="progress-description text-danger">
                                    يجب تعيين دور لهم
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection

@push('page_scripts')
<script>
$(function () {

    // ── 1. Select-All per role column ────────────────────────────
    $('.select-all-role').on('change', function () {
        var roleId  = $(this).data('role-id');
        var checked = $(this).is(':checked');
        $('.role-perm-check[data-role-id="' + roleId + '"]:visible')
            .prop('checked', checked);
    });

    // ── 2. Highlight column when any checkbox in it changes ──────
    $('.role-perm-check').on('change', function () {
        var roleId = $(this).data('role-id');
        var col    = $('td[data-role-id="' + roleId + '"]');
        col.addClass('col-highlight');
        setTimeout(function () { col.removeClass('col-highlight'); }, 800);
    });

    // ── 3. Matrix permission search ──────────────────────────────
    $('#permSearch').on('keyup', function () {
        var q = $(this).val().toLowerCase().trim();
        $('.perm-row').each(function () {
            var name = $(this).data('perm-name') || '';
            if (!q || name.indexOf(q) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        // hide module headers with no visible rows
        $('.module-header').each(function () {
            var mod     = $(this).data('module');
            var visible = $('.perm-row[data-module="' + mod + '"]:visible').length;
            $(this).toggle(visible > 0);
        });
    });

    // ── 4. Permission list search ────────────────────────────────
    $('#permListSearch').on('keyup', function () {
        var q = $(this).val().toLowerCase().trim();
        $('#permListTable tbody tr').each(function () {
            var text = $(this).text().toLowerCase();
            $(this).toggle(!q || text.indexOf(q) >= 0);
        });
    });

    // ── 5. Expand / collapse all module groups ───────────────────
    var expanded = true;
    $('#expandAllBtn').on('click', function () {
        expanded = !expanded;
        if (expanded) {
            $('.perm-row').show();
            $('.module-header').show();
            $(this).html('<i class="fas fa-compress-alt"></i> طي الكل');
        } else {
            $('.perm-row').hide();
            $(this).html('<i class="fas fa-expand-alt"></i> توسيع الكل');
        }
    });

    // ── 6. Auto-dismiss alerts ────────────────────────────────────
    setTimeout(function () {
        $('.alert').fadeOut(500);
    }, 4000);

});
</script>
@endpush
