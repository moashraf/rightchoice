@extends('layouts.admin')

@section('title', 'تفاصيل المستخدم - ' . $user->name)

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-user-shield text-primary"></i> تفاصيل المستخدم المتصل</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('sitemanagement.onlineUsers.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> رجوع للمتصلين
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- ════════════════════════════════════════════════════════════════
             User Profile Card
        ════════════════════════════════════════════════════════════════ --}}
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile text-center">
                        @if($user->profile_image)
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ asset('images/' . $user->profile_image) }}"
                                 alt="{{ $user->name }}"
                                 style="width:100px;height:100px;object-fit:cover;">
                        @else
                            <div class="mx-auto mb-2 rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                 style="width:100px;height:100px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                        <h3 class="profile-username">
                            <i class="fas fa-circle text-success" style="font-size:10px;"></i>
                            {{ $user->name }}
                        </h3>
                        <p class="text-muted">{{ $user->getUserType() }}</p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b><i class="fas fa-envelope mr-1"></i> البريد</b>
                                <span class="float-right">{{ $user->email }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-phone mr-1"></i> الهاتف</b>
                                <span class="float-right">{{ $user->MOP ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-toggle-on mr-1"></i> الحالة</b>
                                <span class="float-right">
                                    @if($user->status == 1)
                                        <span class="badge badge-success">نشط</span>
                                    @elseif($user->status == 0)
                                        <span class="badge badge-warning">غير نشط</span>
                                    @else
                                        <span class="badge badge-danger">محظور</span>
                                    @endif
                                </span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-calendar mr-1"></i> تاريخ التسجيل</b>
                                <span class="float-right">{{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-briefcase mr-1"></i> الوظيفة</b>
                                <span class="float-right">{{ $user->Job_title ?? '-' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b><i class="fas fa-id-badge mr-1"></i> ID</b>
                                <span class="float-right">{{ $user->id }}</span>
                            </li>
                        </ul>

                        <a href="{{ route('sitemanagement.users.show', $user->id) }}" class="btn btn-primary btn-block">
                            <i class="fas fa-external-link-alt"></i> عرض الملف الكامل
                        </a>
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════════
                 Active Sessions
            ════════════════════════════════════════════════════════════ --}}
            <div class="col-lg-8">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-desktop mr-1"></i> الجلسات النشطة ({{ $sessions->count() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        @if($sessions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width:40px;">#</th>
                                            <th>عنوان IP</th>
                                            <th>الجهاز</th>
                                            <th>نظام التشغيل</th>
                                            <th>المتصفح</th>
                                            <th>آخر نشاط</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sessions as $i => $session)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    <code class="bg-light px-2 py-1 rounded">{{ $session->ip_address ?? '-' }}</code>
                                                </td>
                                                <td>
                                                    @if($session->device->device === 'موبايل')
                                                        <i class="fas fa-mobile-alt text-info"></i>
                                                    @elseif($session->device->device === 'تابلت')
                                                        <i class="fas fa-tablet-alt text-warning"></i>
                                                    @else
                                                        <i class="fas fa-desktop text-secondary"></i>
                                                    @endif
                                                    {{ $session->device->device }}
                                                </td>
                                                <td>{{ $session->device->os }}</td>
                                                <td>{{ $session->device->browser }}</td>
                                                <td>
                                                    <span title="{{ $session->last_activity_carbon->format('Y-m-d H:i:s') }}">
                                                        {{ $session->last_activity_carbon->diffForHumans() }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr class="bg-light">
                                                <td colspan="6" style="padding:4px 15px;">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle mr-1"></i>
                                                        <strong>User Agent:</strong> {{ Str::limit($session->user_agent, 120) }}
                                                    </small>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-plug fa-2x text-muted mb-2"></i>
                                <p class="text-muted">لا توجد جلسات نشطة حالياً</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════
             All IP Addresses
        ════════════════════════════════════════════════════════════════ --}}
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-network-wired mr-1"></i> عناوين IP المُستخدمة ({{ $allIps->count() }})</h3>
                    </div>
                    <div class="card-body p-0">
                        @if($allIps->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>عنوان IP</th>
                                            <th>عدد الجلسات</th>
                                            <th>آخر ظهور</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allIps as $ip)
                                            <tr>
                                                <td><code class="bg-light px-2 py-1 rounded">{{ $ip->ip_address }}</code></td>
                                                <td><span class="badge badge-secondary">{{ $ip->session_count }}</span></td>
                                                <td>
                                                    <span title="{{ $ip->last_seen_carbon->format('Y-m-d H:i:s') }}">
                                                        {{ $ip->last_seen_carbon->diffForHumans() }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($ip->last_seen >= now()->subMinutes(config('session.lifetime', 120))->timestamp)
                                                        <span class="badge badge-success"><i class="fas fa-circle" style="font-size:8px;"></i> نشط</span>
                                                    @else
                                                        <span class="badge badge-secondary">غير نشط</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">لا توجد بيانات IP</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════════
                 Shared IP Detection (same IP used by other users)
            ════════════════════════════════════════════════════════════ --}}
            <div class="col-lg-6">
                <div class="card card-warning card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            مستخدمون آخرون بنفس الـ IP ({{ $sharedIpUsers->count() }})
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        @if($sharedIpUsers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>الاسم</th>
                                            <th>البريد</th>
                                            <th>الهاتف</th>
                                            <th>إجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sharedIpUsers as $sharedUser)
                                            <tr>
                                                <td>{{ $sharedUser->id }}</td>
                                                <td>{{ $sharedUser->name }}</td>
                                                <td>{{ $sharedUser->email }}</td>
                                                <td>{{ $sharedUser->MOP ?? '-' }}</td>
                                                <td>
                                                    <a href="{{ route('sitemanagement.onlineUsers.show', $sharedUser->id) }}"
                                                       class="btn btn-xs btn-outline-info" title="تفاصيل">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <p class="text-muted">لا يوجد مستخدمون آخرون يستخدمون نفس عنوان الـ IP</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════
             Recent Activity Log
        ════════════════════════════════════════════════════════════════ --}}
        <div class="card card-secondary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-history mr-1"></i> آخر النشاطات ({{ $recentActivity->count() }})</h3>
            </div>
            <div class="card-body p-0">
                @if($recentActivity->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width:50px;">#</th>
                                    <th>الوصف</th>
                                    <th>الحدث</th>
                                    <th>نوع العنصر</th>
                                    <th>رقم العنصر</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivity as $i => $log)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ Str::limit($log->description, 80) }}</td>
                                        <td>
                                            @php
                                                $eventColors = [
                                                    'created' => 'success',
                                                    'updated' => 'warning',
                                                    'deleted' => 'danger',
                                                ];
                                                $color = $eventColors[$log->event ?? ''] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $color }}">{{ $log->event ?? '-' }}</span>
                                        </td>
                                        <td>
                                            @if($log->subject_type)
                                                {{ class_basename($log->subject_type) }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $log->subject_id ?? '-' }}</td>
                                        <td>
                                            <span title="{{ $log->created_at }}">
                                                {{ \Carbon\Carbon::parse($log->created_at)->diffForHumans() }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="fas fa-history fa-2x mb-2"></i>
                        <p>لا توجد نشاطات مسجلة لهذا المستخدم</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
@endsection
