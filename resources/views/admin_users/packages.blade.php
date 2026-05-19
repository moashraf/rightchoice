@extends('layouts.admin')
@section('title', 'الباقات - ' . $user->name)
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        <i class="fas fa-gem ml-2 text-primary"></i>
                        باقات المستخدم: {{ $user->name }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('sitemanagement.users.show', $user->id) }}">
                        <i class="fas fa-arrow-right ml-1"></i> رجوع
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        {{-- ── ملخص سريع ── --}}
        @php
            $totalPoints   = $packages->sum('start_points');
            $usedPoints    = $packages->sum('sub_points');
            $currentPoints = $packages->sum(fn($p) => max(0, $p->current_points));
            $validAqars    = $viewedAqars->filter(fn($v) => $v->all_aqat_viw !== null);
        @endphp
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="info-box bg-primary">
                    <span class="info-box-icon"><i class="fas fa-gem"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">إجمالي الباقات</span>
                        <span class="info-box-number">{{ $packages->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-info">
                    <span class="info-box-icon"><i class="fas fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">إجمالي النقاط</span>
                        <span class="info-box-number">{{ number_format($totalPoints) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-danger">
                    <span class="info-box-icon"><i class="fas fa-minus-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">النقاط المستخدمة</span>
                        <span class="info-box-number">{{ number_format($usedPoints) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="info-box bg-success">
                    <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">النقاط المتبقية</span>
                        <span class="info-box-number">{{ number_format($currentPoints) }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── الباقات ── --}}
        @if($packages->isEmpty())
            <div class="card">
                <div class="card-body text-center text-muted py-5">
                    <i class="fas fa-box-open fa-3x mb-3"></i>
                    <p>لا توجد باقات لهذا المستخدم.</p>
                </div>
            </div>
        @else
            @foreach($packages as $pkg)
            @php
                $pct = $pkg->start_points > 0
                    ? min(100, round(($pkg->sub_points / $pkg->start_points) * 100))
                    : 0;
                $pkgIdx = $loop->index;
            @endphp
            <div class="card mb-3 shadow-sm">
                {{-- رأس الباقة --}}
                <div class="card-header pkg-header"
                     data-toggle="collapse"
                     data-target="#pkg-body-{{ $pkgIdx }}"
                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                     style="cursor:pointer; background:linear-gradient(135deg,#1a6fa5,#1e8fd4); color:#fff;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-gem fa-lg ml-2"></i>
                            <div>
                                <strong style="font-size:16px;">{{ $pkg->pricing->type ?? 'باقة #'.$pkg->id }}</strong>
                                <div style="font-size:12px; opacity:.85;">
                                    {{ $pkg->created_at ? $pkg->created_at->format('d-m-Y') : '' }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center" style="gap:8px; flex-wrap:wrap;">
                            <span class="badge" style="background:#ffc107;color:#333;padding:6px 12px;border-radius:20px;font-size:13px;">
                                {{ number_format($pkg->pricing->price ?? 0) }} ج.م
                            </span>
                            <span class="badge" style="background:rgba(255,255,255,0.25);color:#fff;padding:6px 12px;border-radius:20px;font-size:13px;">
                                <i class="fas fa-star ml-1"></i> {{ number_format($pkg->start_points) }} نقطة
                            </span>
                            <span class="badge" style="background:#dc3545;color:#fff;padding:6px 12px;border-radius:20px;font-size:13px;">
                                <i class="fas fa-minus ml-1"></i> مُستخدم: {{ number_format($pkg->sub_points) }}
                            </span>
                            <span class="badge" style="background:{{ $pkg->current_points > 0 ? '#28a745' : '#6c757d' }};color:#fff;padding:6px 12px;border-radius:20px;font-size:13px;">
                                متبقي: {{ number_format(max(0,$pkg->current_points)) }}
                            </span>
                            <i class="fas fa-chevron-down pkg-chevron {{ $loop->first ? 'rotated' : '' }}"></i>
                        </div>
                    </div>
                    {{-- شريط التقدم --}}
                    <div class="progress mt-2" style="height:6px;background:rgba(255,255,255,0.3);">
                        <div class="progress-bar bg-warning" style="width:{{ $pct }}%;"></div>
                    </div>
                    <div style="font-size:11px;opacity:.8;text-align:left;margin-top:2px;">{{ $pct }}% مستخدم</div>
                </div>

                {{-- جسم الباقة: العقارات المشاهدة --}}
                <div id="pkg-body-{{ $pkgIdx }}" class="collapse {{ $loop->first ? 'show' : '' }}">
                    <div class="card-body p-0">
                        <div class="px-3 pt-3 pb-1">
                            <h6 class="text-primary mb-3" style="border-right:3px solid #1a6fa5;padding-right:8px;">
                                <i class="fas fa-building ml-1"></i>
                                العقارات التي شاهدها العميل وخُصمت نقاطها
                                <span class="badge badge-secondary ml-1">{{ $validAqars->count() }}</span>
                            </h6>
                        </div>

                        @if($validAqars->isEmpty())
                            <div class="text-center text-muted py-4">
                                <i class="fas fa-home fa-2x mb-2"></i>
                                <p>لم يشاهد العميل أي عقار بعد</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>العقار</th>
                                        <th>الفئة</th>
                                        <th>نوع العرض</th>
                                        <th>المحافظة</th>
                                        <th class="text-center">طريقة التواصل</th>
                                        <th class="text-danger text-center">النقاط المخصومة</th>
                                        <th>تاريخ المشاهدة</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($validAqars as $contact)
                                    @php $aq = $contact->all_aqat_viw; @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($aq->firstImage)
                                                    <img src="{{ url('/images/'.$aq->firstImage->img_url) }}"
                                                         style="width:45px;height:38px;object-fit:cover;border-radius:6px;margin-left:8px;"
                                                         alt="">
                                                @else
                                                    <div style="width:45px;height:38px;background:#eee;border-radius:6px;margin-left:8px;display:flex;align-items:center;justify-content:center;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div style="font-weight:600;font-size:13px;">
                                                        {{ Str::limit($aq->title, 40) }}
                                                    </div>
                                                    <div class="text-muted" style="font-size:11px;">ID: {{ $aq->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-info">
                                                {{ $aq->categoryRel->category_name ?? '—' }}
                                            </span>
                                        </td>
                                        <td>
                                            @php $isRent = in_array($aq->offer_type, [3,4]); @endphp
                                            <span class="badge {{ $isRent ? 'badge-warning' : 'badge-success' }}">
                                                {{ $aq->offerTypes->type_offer ?? '—' }}
                                            </span>
                                        </td>
                                        <td>{{ $aq->governrateq->governrate ?? '—' }}</td>
                                        <td class="text-center">
                                            @if($contact->contact_via_whats_app)
                                                <span class="badge badge-success" style="font-size:12px;padding:5px 8px;">
                                                    <img src="https://img.icons8.com/color/16/000000/whatsapp--v1.png" width="14" height="14"/>
                                                    واتساب
                                                </span>
                                            @else
                                                <span class="badge badge-info" style="font-size:12px;padding:5px 8px;">
                                                    <i class="fas fa-phone ml-1"></i> اتصال
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span style="font-size:18px;font-weight:800;color:#dc3545;">
                                                {{ $aq->points_avail ?? 0 }}
                                            </span>
                                            <div class="text-muted" style="font-size:10px;">نقطة</div>
                                        </td>
                                        <td>
                                            <div>{{ $contact->created_at ? $contact->created_at->format('d-m-Y') : '—' }}</div>
                                            <div class="text-muted" style="font-size:11px;">{{ $contact->created_at ? $contact->created_at->format('H:i') : '' }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ route('sitemanagement.aqars.show', $aq->id) }}"
                                               target="_blank"
                                               class="btn btn-xs btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot class="thead-light">
                                    <tr>
                                        <th colspan="5" class="text-right">الإجمالي</th>
                                        <th class="text-center">
                                            <span class="badge badge-success" style="font-size:12px;">
                                                {{ $validAqars->filter(fn($v) => $v->contact_via_whats_app)->count() }}
                                                <img src="https://img.icons8.com/color/14/000000/whatsapp--v1.png" width="14" height="14"/>
                                            </span>
                                            <span class="badge badge-info" style="font-size:12px;">
                                                {{ $validAqars->filter(fn($v) => !$v->contact_via_whats_app)->count() }}
                                                <i class="fas fa-phone"></i>
                                            </span>
                                        </th>
                                        <th class="text-center text-danger" style="font-size:16px;font-weight:800;">
                                            {{ $validAqars->sum(fn($v) => $v->all_aqat_viw->points_avail ?? 0) }}
                                            <div style="font-size:10px;font-weight:400;">نقطة</div>
                                        </th>
                                        <th colspan="2"></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <style>
        .pkg-chevron { transition: transform 0.3s; }
        .pkg-chevron.rotated { transform: rotate(180deg); }
        .pkg-header[aria-expanded="true"] .pkg-chevron { transform: rotate(180deg); }
        .pkg-header[aria-expanded="false"] .pkg-chevron { transform: rotate(0deg); }
        .info-box { border-radius: 10px; }
    </style>
    <script>
        document.querySelectorAll('.pkg-header').forEach(function(header) {
            header.addEventListener('click', function() {
                var chevron = this.querySelector('.pkg-chevron');
                var target = document.querySelector(this.getAttribute('data-target'));
                if (target.classList.contains('show')) {
                    chevron.classList.remove('rotated');
                } else {
                    chevron.classList.add('rotated');
                }
            });
        });
    </script>
@endsection
