<x-layout>

    @section('title')
        السجل
    @endsection
    <?php
    $user = auth()->user();

    if (isset($user)) {
    } else {
        dd('يجب تسجيل الدخول ');
    }
    ?>

    <section id="profile-info" class="bg-light">

        <div class="container">

            <div class="main-body text-center">


                <div class="row gutters-sm">


                    <div class="col-md-8    text-right">

                        <div class="accordion" id="accordionExample">


                            <div class="accordion-item">
                                <!-- ============================     الباقات  ================================== -->

                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true"
                                        aria-controls="collapseOne">
                                    <h3 class="mt-3">الباقات التى تم الاشتراك بها</h3>
                                </button>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                     aria-labelledby="headingOne" data-bs-parent="#accordionExample">

                                    {{-- ─── فلتر نوع الباقات ─── --}}
                                    @php
                                        $currentFilter = $filter ?? 'all';
                                        $buyerCount   = isset($buyer_packages)  ? $buyer_packages->count()  : 0;
                                        $sellerCount  = isset($seller_packages) ? $seller_packages->count() : 0;
                                    @endphp

                                    <div class="pkg-filter-bar d-flex flex-wrap justify-content-center align-items-center gap-2 my-3">
                                        <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}?filter=all"
                                           class="btn btn-sm {{ $currentFilter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                            <i class="fa fa-list ml-1"></i>
                                            جميع الباقات
                                            <span class="badge bg-light text-dark ml-1">{{ $buyerCount + $sellerCount }}</span>
                                        </a>
                                        <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}?filter=buyer"
                                           class="btn btn-sm {{ $currentFilter === 'buyer' ? 'btn-success' : 'btn-outline-success' }}">
                                            <i class="fa fa-shopping-cart ml-1"></i>
                                            باقات المشتري
                                            <span class="badge bg-light text-dark ml-1">{{ $buyerCount }}</span>
                                        </a>
                                        <a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}?filter=seller"
                                           class="btn btn-sm {{ $currentFilter === 'seller' ? 'btn-warning' : 'btn-outline-warning' }}">
                                            <i class="fa fa-star ml-1"></i>
                                            باقات البائع (VIP)
                                            <span class="badge bg-light text-dark ml-1">{{ $sellerCount }}</span>
                                        </a>
                                    </div>

                                    {{-- ============================================================
                                         باقات المشتري (priceing_sale)
                                         ============================================================ --}}
                                    @if($currentFilter === 'all' || $currentFilter === 'buyer')
                                        <div class="pkg-group-title text-right mx-2 mb-2">
                                            <i class="fa fa-shopping-cart text-success ml-1"></i>
                                            <span>باقات المشتري</span>
                                            <small class="text-muted">— تُشحن نقاطها لعرض بيانات التواصل مع البائعين</small>
                                        </div>

                                        @if($buyer_packages->isEmpty())
                                            <div class="alert alert-info m-3">لا توجد باقات مشتري مشترك بها حتى الآن</div>
                                        @else
                                            @foreach ($buyer_packages as $not)
                                            @php $pkgIndex = 'buyer-' . $loop->index; @endphp
                                            <div class="pkg-card pkg-card-buyer shadow-sm mb-3 mx-2">
                                                {{-- ─── رأس الباقة ─── --}}
                                                <div class="pkg-header pkg-header-buyer d-flex justify-content-between align-items-center"
                                                     data-bs-toggle="collapse"
                                                     data-bs-target="#pkg-{{ $pkgIndex }}"
                                                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                     style="cursor:pointer;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="pkg-icon"><i class="fa fa-shopping-cart"></i></span>
                                                        <div class="text-right">
                                                            <div class="pkg-name">
                                                                {{ $not->pricing->type ?? 'باقة مشتري' }}
                                                                <span class="pkg-type-tag pkg-type-buyer">مشتري</span>
                                                            </div>
                                                            <div class="pkg-date text-muted small">
                                                                {{ \Carbon\Carbon::parse($not->created_at)->format('d-m-Y') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <span class="badge badge-price">{{ number_format($not->pricing->price ?? 0) }} ج.م</span>
                                                        <span class="badge badge-points-total">
                                                            <i class="fa fa-star ml-1"></i>
                                                            {{ $not->start_points }} نقطة
                                                        </span>
                                                        <span class="badge {{ $not->current_points > 0 ? 'badge-points-ok' : 'badge-points-zero' }}">
                                                            متبقي: {{ max(0, $not->current_points) }}
                                                        </span>
                                                        <i class="fa fa-chevron-down pkg-chevron"></i>
                                                    </div>
                                                </div>

                                                {{-- ─── تفاصيل الباقة + العقارات ─── --}}
                                                <div id="pkg-{{ $pkgIndex }}"
                                                     class="collapse {{ $loop->first ? 'show' : '' }}">
                                                    <div class="pkg-body">

                                                        {{-- ملخص النقاط --}}
                                                        <div class="points-summary">
                                                            <div class="points-box">
                                                                <div class="points-num text-primary">{{ $not->start_points }}</div>
                                                                <div class="points-lbl">إجمالي النقاط</div>
                                                            </div>
                                                            <div class="points-box">
                                                                <div class="points-num text-danger">{{ $not->sub_points }}</div>
                                                                <div class="points-lbl">المخصوم</div>
                                                            </div>
                                                            <div class="points-box">
                                                                <div class="points-num text-success">{{ max(0, $not->current_points) }}</div>
                                                                <div class="points-lbl">المتبقي</div>
                                                            </div>
                                                        </div>

                                                        {{-- شريط تقدم النقاط --}}
                                                        @php
                                                            $pct = $not->start_points > 0
                                                                ? min(100, round(($not->sub_points / $not->start_points) * 100))
                                                                : 0;
                                                        @endphp
                                                        <div class="progress my-2" style="height:8px;">
                                                            <div class="progress-bar bg-warning" style="width:{{ $pct }}%"></div>
                                                        </div>
                                                        <div class="text-muted small text-right mb-3">
                                                            تم استخدام {{ $pct }}% من النقاط
                                                        </div>

                                                        {{-- ─── العقارات التي تم مشاهدتها ─── --}}
                                                        <h6 class="pkg-section-title">
                                                            <i class="fa fa-building ml-1"></i>
                                                            العقارات التي شاهدتها وخُصمت نقاطها
                                                        </h6>

                                                        @php
                                                            $viewedAqars = $all_data->filter(fn($v) => $v->all_aqat_viw !== null);
                                                        @endphp

                                                        @if($viewedAqars->isEmpty())
                                                            <div class="alert alert-light text-muted text-center">
                                                                لم تشاهد أي عقار بعد
                                                            </div>
                                                        @else
                                                            <div class="aqar-list">
                                                                @foreach($viewedAqars as $val)
                                                                @php $aq = $val->all_aqat_viw; @endphp
                                                                <div class="aqar-row">
                                                                    <div class="aqar-row-img">
                                                                        @if($aq->firstImage)
                                                                            <img src="{{ URL::to('/') . '/images/' . $aq->firstImage->img_url }}"
                                                                                 alt="{{ $aq->title }}" loading="lazy"/>
                                                                        @else
                                                                            <img src="https://rightchoice-co.com/images/FBO.png"
                                                                                 alt="no-img" loading="lazy"/>
                                                                        @endif
                                                                    </div>
                                                                    <div class="aqar-row-info">
                                                                        <a href="{{ URL::to(Config::get('app.locale').'/aqars/'.$aq->slug) }}"
                                                                           target="_blank" class="aqar-row-title">
                                                                            {{ Str::limit($aq->title, 50) }}
                                                                        </a>
                                                                        <div class="aqar-row-meta">
                                                                            @if($aq->governrateq)
                                                                                <span><i class="fa fa-map-marker"></i> {{ $aq->governrateq->governrate }}</span>
                                                                            @endif
                                                                            @if($aq->categoryRel)
                                                                                <span><i class="fa fa-building"></i> {{ $aq->categoryRel->category_name }}</span>
                                                                            @endif
                                                                            <span class="text-muted small">
                                                                                <i class="fa fa-calendar"></i>
                                                                                {{ \Carbon\Carbon::parse($val->created_at)->format('d-m-Y') }}
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="aqar-row-points">
                                                                        <span class="points-deducted">
                                                                            <i class="fa fa-minus-circle text-danger ml-1"></i>
                                                                            {{ $aq->points_avail ?? 0 }}
                                                                        </span>
                                                                        <div class="text-muted" style="font-size:11px;">نقطة</div>
                                                                    </div>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        @endif

                                                    </div>{{-- /pkg-body --}}
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    @endif

                                    {{-- ============================================================
                                         باقات البائع (price_vip) — تمييز الإعلانات
                                         ============================================================ --}}
                                    @if($currentFilter === 'all' || $currentFilter === 'seller')
                                        <div class="pkg-group-title text-right mx-2 mb-2 mt-4">
                                            <i class="fa fa-star text-warning ml-1"></i>
                                            <span>باقات البائع (تمييز الإعلانات - VIP)</span>
                                            <small class="text-muted">— اشتراكات تمييز عقاراتك لجذب المزيد من المشاهدات</small>
                                        </div>

                                        @if($seller_packages->isEmpty())
                                            <div class="alert alert-info m-3">لا توجد باقات بائع مشترك بها حتى الآن</div>
                                        @else
                                            @foreach ($seller_packages as $aqSeller)
                                            @php
                                                $pkgIndex   = 'seller-' . $loop->index;
                                                $pkg        = $aqSeller->promotionPackage;
                                                $startedAt  = $aqSeller->vip_started_at;
                                                $expiresAt  = $aqSeller->vip_expires_at;
                                                $isActive   = $aqSeller->vip == 1 && $expiresAt && $expiresAt->isFuture() && !$aqSeller->trashed();
                                                $daysLeft   = ($expiresAt && $expiresAt->isFuture()) ? now()->diffInDays($expiresAt) : 0;
                                                $totalDays  = (int) ($pkg->duration_days ?? 0);
                                                $usedDays   = ($startedAt && $totalDays > 0)
                                                                ? min($totalDays, max(0, now()->diffInDays($startedAt, false)))
                                                                : 0;
                                                $usedPct    = $totalDays > 0 ? min(100, round(($usedDays / $totalDays) * 100)) : 0;
                                            @endphp
                                            <div class="pkg-card pkg-card-seller shadow-sm mb-3 mx-2">
                                                {{-- ─── رأس الباقة ─── --}}
                                                <div class="pkg-header pkg-header-seller d-flex justify-content-between align-items-center"
                                                     data-bs-toggle="collapse"
                                                     data-bs-target="#pkg-{{ $pkgIndex }}"
                                                     aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                     style="cursor:pointer;">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="pkg-icon"><i class="fa fa-star"></i></span>
                                                        <div class="text-right">
                                                            <div class="pkg-name">
                                                                {{ $pkg->name ?? 'باقة تمييز' }}
                                                                <span class="pkg-type-tag pkg-type-seller">بائع - VIP</span>
                                                            </div>
                                                            <div class="pkg-date text-muted small">
                                                                @if($startedAt)
                                                                    بدأت: {{ $startedAt->format('d-m-Y') }}
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <span class="badge badge-price">{{ number_format($pkg->price ?? 0) }} ج.م</span>
                                                        <span class="badge badge-points-total">
                                                            <i class="fa fa-clock ml-1"></i>
                                                            {{ $totalDays }} يوم
                                                        </span>
                                                        <span class="badge {{ $isActive ? 'badge-points-ok' : 'badge-points-zero' }}">
                                                            {{ $isActive ? 'نشطة - متبقي ' . $daysLeft . ' يوم' : 'منتهية' }}
                                                        </span>
                                                        <i class="fa fa-chevron-down pkg-chevron"></i>
                                                    </div>
                                                </div>

                                                {{-- ─── تفاصيل الباقة + العقار المرتبط ─── --}}
                                                <div id="pkg-{{ $pkgIndex }}"
                                                     class="collapse {{ $loop->first ? 'show' : '' }}">
                                                    <div class="pkg-body">

                                                        {{-- ملخص الأيام --}}
                                                        <div class="points-summary">
                                                            <div class="points-box">
                                                                <div class="points-num text-primary">{{ $totalDays }}</div>
                                                                <div class="points-lbl">مدة الباقة (يوم)</div>
                                                            </div>
                                                            <div class="points-box">
                                                                <div class="points-num text-danger">{{ $usedDays }}</div>
                                                                <div class="points-lbl">أيام مستخدمة</div>
                                                            </div>
                                                            <div class="points-box">
                                                                <div class="points-num text-success">{{ $daysLeft }}</div>
                                                                <div class="points-lbl">أيام متبقية</div>
                                                            </div>
                                                        </div>

                                                        {{-- شريط تقدم الأيام --}}
                                                        <div class="progress my-2" style="height:8px;">
                                                            <div class="progress-bar bg-warning" style="width:{{ $usedPct }}%"></div>
                                                        </div>
                                                        <div class="text-muted small text-right mb-3">
                                                            تم استخدام {{ $usedPct }}% من مدة الباقة
                                                            @if($expiresAt)
                                                                — تنتهى بتاريخ {{ $expiresAt->format('d-m-Y') }}
                                                            @endif
                                                        </div>

                                                        {{-- ─── العقار الذى تم تمييزه ─── --}}
                                                        <h6 class="pkg-section-title">
                                                            <i class="fa fa-building ml-1"></i>
                                                            العقار الذى تم تمييزه
                                                        </h6>

                                                        <div class="aqar-list">
                                                            <div class="aqar-row">
                                                                <div class="aqar-row-img">
                                                                    @if($aqSeller->firstImage)
                                                                        <img src="{{ URL::to('/') . '/images/' . $aqSeller->firstImage->img_url }}"
                                                                             alt="{{ $aqSeller->title }}" loading="lazy"/>
                                                                    @else
                                                                        <img src="https://rightchoice-co.com/images/FBO.png"
                                                                             alt="no-img" loading="lazy"/>
                                                                    @endif
                                                                </div>
                                                                <div class="aqar-row-info">
                                                                    @if($aqSeller->trashed())
                                                                        <span class="aqar-row-title text-muted">
                                                                            {{ Str::limit($aqSeller->title, 50) }} <small>(محذوف)</small>
                                                                        </span>
                                                                    @else
                                                                        <a href="{{ URL::to(Config::get('app.locale').'/aqars/'.$aqSeller->slug) }}"
                                                                           target="_blank" class="aqar-row-title">
                                                                            {{ Str::limit($aqSeller->title, 50) }}
                                                                        </a>
                                                                    @endif
                                                                    <div class="aqar-row-meta">
                                                                        <span>
                                                                            <i class="fa fa-eye"></i>
                                                                            {{ $pkg->views ?? 0 }} مشاهدات إضافية
                                                                        </span>
                                                                        @if($startedAt)
                                                                            <span class="text-muted small">
                                                                                <i class="fa fa-calendar"></i>
                                                                                {{ $startedAt->format('d-m-Y') }}
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="aqar-row-points">
                                                                    <span class="points-deducted text-warning">
                                                                        <i class="fa fa-star ml-1"></i>
                                                                        {{ $totalDays }}
                                                                    </span>
                                                                    <div class="text-muted" style="font-size:11px;">يوم</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>{{-- /pkg-body --}}
                                                </div>
                                            </div>
                                            @endforeach
                                        @endif
                                    @endif

                                </div>

                            </div>


                        </div>
                        <!-- ============================     الدفع  ================================== -->

                        <hr/>

                        <div class="accordion" id="accordionExample">


                            <div class="accordion-item">


                                <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                        data-bs-target="#collapseTwo" aria-expanded="true"

                                        aria-controls="collapseTwo">


                                    <h3 class="mt-3"> عمليات الدفع المقبوله</h3>


                                </button>
                                <div id="collapseTwo" class="accordion-collapse collapse"

                                     aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    @if (!empty($FawryPayment_data))

                                        @foreach ($FawryPayment_data->sortByDesc('id') as $not)
                                            <div class="col-lg-12">
                                                <div id="notifi "
                                                     class="rounded alert notifi_div text-center card mt-3">


                                                    <p style=" text-align: right;">
                                                        قيمه المبلغ :
                                                        {{ $not->paymentAmount }}
                                                        <br/>
                                                        تاريخ العمليه :
                                                            <?php $newDate = date('d-m-Y', strtotime($not->created_at));
                                                            echo $newDate; ?>

                                                        <br/>
                                                        الحاله :
                                                        {{ $not->paymentStatus }}

                                                        <br/>
                                                        طريقه الدفع
                                                        {{ $not->paymentMethod }}

                                                        </br>
                                                        الرقم
                                                        {{ $not->referenceNumber }}

                                                        </br>

                                                        الرقم المرجعي :

                                                        {{ $not->merchantRefNumber }}

                                                    </p>


                                                </div>

                                            </div>
                                        @endforeach
                                        <div style="  direction: rtl;">
                                            {{ $FawryPayment_data->appends( ( 'posts'))->links()  }}
                                        </div>
                                    @endif

                                </div>


                            </div>


                        </div>

                        <hr/>

                        <div class="accordion" id="accordionExample">


                            <div class="accordion-item">


                                <button class="accordion-button" type="button" data-bs-toggle="collapse"

                                        data-bs-target="#collapseThree" aria-expanded="true"

                                        aria-controls="collapseThree">


                                    <h3 class="mt-3"> عمليات الدفع غير مقبوله</h3>


                                </button>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    @if (!empty($FawryPayment_data_unpaid))

                                        @foreach ($FawryPayment_data_unpaid->sortByDesc('id') as $not2)
                                            <div class="col-lg-12">
                                                <div id="notifi "
                                                     class="rounded alert notifi_div text-center card mt-3">


                                                    <p style=" text-align: right;">
                                                        قيمه المبلغ :
                                                        {{ $not2->paymentAmount }}
                                                        <br/>
                                                        تاريخ العمليه :
                                                            <?php $newDate = date('d-m-Y', strtotime($not2->created_at));
                                                            echo $newDate; ?>

                                                        <br/>
                                                        الحاله :
                                                        {{ $not2->paymentStatus }}

                                                        <br/>
                                                        طريقه الدفع
                                                        {{ $not2->paymentMethod }}

                                                        <br/>
                                                        الرقم
                                                        {{ $not2->referenceNumber }}

                                                        <br/>

                                                        الرقم المرجعي :

                                                        {{ $not2->merchantRefNumber }}

                                                    </p>


                                                </div>

                                            </div>
                                        @endforeach
                                        <div style="  direction: rtl;">
                                            {{ $FawryPayment_data_unpaid->appends( ( 'posts'))->links()  }}
                                        </div>
                                    @endif

                                </div>


                            </div>


                        </div>


                    </div>
                    @include('components.profile-sidebar')

                </div>

                <div class="text-center my-4">
                    <a href="{{ URL::to(Config::get('app.locale').'/user_contacted_aqars') }}" class="btn btn-outline-primary">
                        <i class="fa fa-building ml-1"></i>
                        عرض العقارات التي تم التواصل مع ملاكها
                    </a>
                </div>


            </div>

        </div>


    </section>


    <!-- ============================ Call To Action ================================== -->
    <x-call-to-action/>
    <!-- ============================ Call To Action End ================================== -->

<style>
/* ── بطاقة الباقة ── */
.pkg-card {
    background: #fff;
    border: 1px solid #e0e9f5;
    border-radius: 14px;
    overflow: hidden;
}
.pkg-header {
    background: linear-gradient(135deg, #196aa2 0%, #1a85cc 100%);
    color: #fff;
    padding: 14px 18px;
    border-radius: 14px 14px 0 0;
    transition: opacity 0.2s;
}
.pkg-header:hover { opacity: 0.92; }

/* ── تمييز باقات المشترى مقابل باقات البائع ── */
.pkg-card-buyer   { border-color: #b6e2c9; }
.pkg-card-seller  { border-color: #ffe1a3; }
.pkg-header-buyer  { background: linear-gradient(135deg, #1e7d47 0%, #28a745 100%); }
.pkg-header-seller { background: linear-gradient(135deg, #c47b00 0%, #ffb703 100%); color:#fff; }

.pkg-type-tag {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
    margin-right: 6px;
    vertical-align: middle;
}
.pkg-type-buyer  { background:#e6f7ee; color:#1e7d47; }
.pkg-type-seller { background:#fff3d9; color:#8a5a00; }

/* ── شريط الفلاتر ── */
.pkg-filter-bar {
    background: #f8fbff;
    border: 1px dashed #dce8f5;
    border-radius: 12px;
    padding: 10px 12px;
    margin: 0 8px 12px 8px;
}
.pkg-filter-bar .btn { min-width: 130px; }
.pkg-filter-bar .badge { font-weight: 700; }

/* ── عنوان مجموعة الباقات ── */
.pkg-group-title {
    font-size: 15px;
    font-weight: 800;
    color: #196aa2;
    padding: 6px 10px;
    border-right: 4px solid #196aa2;
    background: #f4f9ff;
    border-radius: 4px;
}
.pkg-group-title small { font-weight: 400; margin-right: 6px; }
.pkg-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.pkg-name { font-weight: 700; font-size: 15px; }
.pkg-date { font-size: 12px; opacity: 0.85; }
.pkg-chevron { transition: transform 0.3s; }
.pkg-header[aria-expanded="true"] .pkg-chevron { transform: rotate(180deg); }

.badge-price { background:#ffc107; color:#333; padding:5px 10px; border-radius:20px; font-weight:700; font-size:13px; }
.badge-points-total { background:rgba(255,255,255,0.25); color:#fff; padding:5px 10px; border-radius:20px; font-size:13px; }
.badge-points-ok { background:#28a745; color:#fff; padding:5px 10px; border-radius:20px; font-size:13px; }
.badge-points-zero { background:#dc3545; color:#fff; padding:5px 10px; border-radius:20px; font-size:13px; }

.pkg-body { padding: 18px 16px; }

/* ── ملخص النقاط ── */
.points-summary {
    display: flex;
    justify-content: space-around;
    background: #f8f9fa;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 10px;
}
.points-box { text-align: center; }
.points-num { font-size: 22px; font-weight: 800; }
.points-lbl { font-size: 12px; color: #888; }

/* ── قسم العقارات ── */
.pkg-section-title {
    font-size: 14px;
    font-weight: 700;
    color: #196aa2;
    border-right: 3px solid #196aa2;
    padding-right: 8px;
    margin-bottom: 12px;
}
.aqar-list { display: flex; flex-direction: column; gap: 10px; }
.aqar-row {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f8fbff;
    border: 1px solid #dce8f5;
    border-radius: 10px;
    padding: 10px;
}
.aqar-row-img {
    flex-shrink: 0;
    width: 70px; height: 60px;
    border-radius: 8px;
    overflow: hidden;
}
.aqar-row-img img { width:100%; height:100%; object-fit:cover; }
.aqar-row-info { flex: 1; text-align: right; }
.aqar-row-title {
    font-weight: 600;
    font-size: 14px;
    color: #196aa2;
    text-decoration: none;
    display: block;
    margin-bottom: 4px;
}
.aqar-row-title:hover { text-decoration: underline; }
.aqar-row-meta { display: flex; flex-wrap: wrap; gap: 10px; font-size: 12px; color: #777; }
.aqar-row-points {
    text-align: center;
    flex-shrink: 0;
    min-width: 60px;
}
.points-deducted { font-size: 18px; font-weight: 800; color: #dc3545; }

/* gap utility for older bootstrap */
.gap-2 { gap: 8px; }
.gap-3 { gap: 12px; }
</style>

</x-layout>
