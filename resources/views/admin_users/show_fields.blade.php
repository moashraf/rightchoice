<ul class="list-group">
    <li class="list-group-item" style="background-color:#343a40; color:#fff; font-weight:bold;">User Details</li>

    <ul class="list-group">
        @if($user->name)
            <li class="list-group-item"><strong>User name:</strong> {{ $user->name }}</li>
        @endif

        @if($user->email)
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        @endif

        @if($user->MOP)
            <li class="list-group-item"><strong>Mobile:</strong> {{ $user->MOP }}</li>
        @endif

        @php
            $ageOptions = [
                1 => 'From 18 - to 25',
                2 => 'From 26 to 35',
                3 => 'From 36 to 45',
                4 => 'From 46 to 60',
                5 => 'More than 60'
            ];
        @endphp
        @if($user->AGE && array_key_exists($user->AGE, $ageOptions))
            <li class="list-group-item"><strong>Age:</strong>
                <span>{{ $ageOptions[$user->AGE] }}</span>
            </li>
        @endif

        @if($user->TYPE)
            <li class="list-group-item"><strong>Type Of User:</strong>
                {{ $user->getUserType() }}
            </li>
        @endif

        <li class="list-group-item"><strong>Status:</strong> {{ $user->status ? 'Active' : 'Un Active' }}</li>

        @if($user->invited_by)
            <li class="list-group-item"><strong>تم الدعوة بواسطة:</strong> {{ $user->invited_by }}</li>
        @endif

        @if($user->phone_sms_otp)
            <li class="list-group-item"><strong>OTP Code:</strong> {{ $user->phone_sms_otp }}</li>
        @endif

        @if($user->Employee_Name)
            <li class="list-group-item"><strong>Employee Name:</strong> {{ $user->Employee_Name }}</li>
        @endif

        @if($user->Job_title)
            <li class="list-group-item"><strong>Job Title:</strong>
                <span>
                    @if($user->Job_title == 1) صاحب عمل
                    @elseif($user->Job_title == 2) مدير عام
                    @elseif($user->Job_title == 3) مدير تسويق
                    @elseif($user->Job_title == 4) مدير فرع
                    @endif
                </span>
            </li>
        @endif

        @if($user->Commercial_Register)
            <li class="list-group-item"><strong>Company:</strong> {{ $user->Commercial_Register }}</li>
        @endif

        @if($user->Tax_card)
            <li class="list-group-item"><strong>Tax Card:</strong> {{ $user->Tax_card }}</li>
        @endif

        {{-- ── RBAC: Role Display ─────────────────────────────────────── --}}
        <li class="list-group-item">
            <strong>Role:</strong>
            @if($user->role)
                @php
                    $roleColors = ['admin' => 'danger', 'user' => 'primary', 'viewer' => 'secondary'];
                    $roleColor  = $roleColors[$user->role->name] ?? 'dark';
                @endphp
                <span class="badge badge-{{ $roleColor }} px-2 py-1">
                    {{ $user->role->label ?? ucfirst($user->role->name) }}
                </span>
            @else
                <span class="badge badge-light">No Role Assigned</span>
            @endif
        </li>
    </ul>
</ul>

{{-- ======= باقة النقاط ======= --}}
@php
    $userPricings = \App\Models\UserPriceing::where('user_id', $user->id)
        ->with('pricing')
        ->orderBy('id', 'desc')
        ->get();
    $latestPricing = $userPricings->first();
@endphp

@if($userPricings->isNotEmpty())
<div class="mt-4">
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-coins ml-1 text-warning"></i>
                <strong>باقة النقاط</strong>
            </h3>
        </div>
        <div class="card-body p-0">

            {{-- النقاط الحالية - بارزة --}}
            <div class="text-center py-4" style="background: linear-gradient(135deg,#1a1a2e,#16213e); color:#fff; border-radius:4px 4px 0 0;">
                <div style="font-size:13px; opacity:.8; margin-bottom:4px;">النقاط المتاحة حالياً</div>
                <div style="font-size:52px; font-weight:900; color:#f4c430; line-height:1;">
                    {{ number_format($latestPricing->current_points ?? 0) }}
                </div>
                <div style="font-size:13px; opacity:.7; margin-top:4px;">نقطة</div>
            </div>

            <table class="table table-bordered table-sm mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>اسم الباقة</th>
                        <th>نقاط البداية</th>
                        <th>النقاط الحالية</th>
                        <th>النقاط المستخدمة</th>
                        <th>تاريخ الاشتراك</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($userPricings as $up)
                    @php
                        $usedPoints = ($up->start_points ?? 0) - ($up->current_points ?? 0);
                        $isLatest   = $loop->first;
                    @endphp
                    <tr class="{{ $isLatest ? 'table-warning font-weight-bold' : '' }}">
                        <td>
                            {{ $up->pricing->type ?? ('باقة #' . $up->pricing_id) }}
                            @if($isLatest)
                                <span class="badge badge-success mr-1">الحالية</span>
                            @endif
                        </td>
                        <td>{{ number_format($up->start_points ?? 0) }}</td>
                        <td>
                            <span class="badge badge-{{ ($up->current_points ?? 0) > 0 ? 'primary' : 'secondary' }} p-2"
                                  style="font-size:14px;">
                                {{ number_format($up->current_points ?? 0) }}
                            </span>
                        </td>
                        <td>
                            @if($usedPoints > 0)
                                <span class="text-danger">- {{ number_format($usedPoints) }}</span>
                            @else
                                <span class="text-muted">0</span>
                            @endif
                        </td>
                        <td>{{ $up->created_at ? $up->created_at->format('Y-m-d') : '-' }}</td>
                        <td>
                            @if(($up->current_points ?? 0) > 0)
                                <span class="badge badge-success">نشطة</span>
                            @else
                                <span class="badge badge-secondary">منتهية</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
        <div class="card-footer text-muted" style="font-size:12px;">
            <i class="fas fa-info-circle ml-1"></i>
            إجمالي الباقات المشترك بها: <strong>{{ $userPricings->count() }}</strong> باقة
        </div>
    </div>
</div>
@else
<div class="mt-4">
    <div class="alert alert-secondary">
        <i class="fas fa-times-circle ml-1"></i>
        هذا المستخدم غير مشترك في أي باقة حتى الآن.
    </div>
</div>
@endif

{{-- ======= العقارات التي دفع فيها نقاط ======= --}}
@php
    $contactedAqars = \App\Models\UserContactAqar::where('user_id', $user->id)
        ->with('all_aqat_viw')
        ->latest()
        ->get()
        ->unique('aqars_id');
@endphp

<div class="mt-4">
    <div class="card card-warning card-outline">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-eye ml-1 text-warning"></i>
                <strong>العقارات التي دفع فيها نقاط</strong>
            </h3>
            <div class="card-tools">
                <span class="badge badge-warning" style="font-size:14px;">
                    {{ $contactedAqars->count() }} عقار
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            @if($contactedAqars->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>عنوان العقار</th>
                                <th>التاريخ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contactedAqars as $i => $contact)
                                @php $aqar = $contact->all_aqat_viw; @endphp
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        @if($aqar)
                                            {{ Str::limit($aqar->title, 50) }}
                                        @else
                                            <span class="text-muted">عقار محذوف</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $contact->created_at ? $contact->created_at->format('Y-m-d') : '-' }}</div>
                                        <div class="text-muted small">{{ $contact->created_at ? $contact->created_at->format('H:i') : '' }}</div>
                                    </td>
                                    <td>
                                        @if($aqar)
                                            <a href="{{ route('sitemanagement.aqars.show', $aqar->id) }}"
                                               class="btn btn-xs btn-outline-primary" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-3">
                    <div class="alert alert-secondary mb-0">
                        <i class="fas fa-info-circle ml-1"></i>
                        لم يقم هذا المستخدم بالدفع على أي عقار حتى الآن.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
