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

                                    @if($all_history_of_point_of_user->isEmpty())
                                        <div class="alert alert-info m-3">لا توجد باقات مشترك بها حتى الآن</div>
                                    @else
                                        @foreach ($all_history_of_point_of_user->sortByDesc('id') as $not)
                                        @php $pkgIndex = $loop->index; @endphp
                                        <div class="pkg-card shadow-sm mb-3 mx-2">
                                            {{-- ─── رأس الباقة ─── --}}
                                            <div class="pkg-header d-flex justify-content-between align-items-center"
                                                 data-bs-toggle="collapse"
                                                 data-bs-target="#pkg-{{ $pkgIndex }}"
                                                 aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                 style="cursor:pointer;">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="pkg-icon"><i class="fa fa-gem"></i></span>
                                                    <div class="text-right">
                                                        <div class="pkg-name">{{ $not->pricing->type ?? 'باقة' }}</div>
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

                <h3 class="mt-3 mb-5">العقارات التي تم التواصل مع ملاكها
                    <h3>

                        @foreach ($all_data as $val)
                            @if ($val->all_aqat_viw != null)

                                <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">


                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                    <div>
                                                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                           target="_blank">
                                                            @if ($val->all_aqat_viw->firstImage)
                                                                <img
                                                                    src="{{ URL::to('/') . '/images/' . $val->all_aqat_viw->firstImage->img_url }}"
                                                                    class="img-fluid mx-auto" alt="" loading="lazy"/>

                                                            @else

                                                                <img src="https://rightchoice-co.com/images/FBO.png"
                                                                     class="img-fluid main-img" alt="main"
                                                                     loading="lazy">

                                                            @endif
                                                        </a></div>


                                                </div>

                                                <div class="views-2">
                                                    <i class="fa fa-eye"></i>
                                                    <span>{{ $val->all_aqat_viw->views }}</span>

                                                </div>
                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4 class="listing-name verified"><a
                                                                        href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                                        target="_blank">

                                                                        {{ $val->all_aqat_viw->title }}
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->


                                                            </div>

                                                            <div>

                                                                <a href="#" class="btn btn-outline-warning">عدد النقاط
                                                                    التي تم خصمها :
                                                                    {{ $val->all_aqat_viw->points_avail }}</a>

                                                            </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                                @if ($val->all_aqat_viw->offerTypes->id == 1 || $val->all_aqat_viw->offerTypes->id == 2)
                                                                    {{ $val->all_aqat_viw->total_price }}
                                                                @endif
                                                                @if ($val->all_aqat_viw->offerTypes->id == 3 || $val->all_aqat_viw->offerTypes->id == 4)
                                                                    {{ $val->all_aqat_viw->monthly_rent }}
                                                                @endif جنيه مصري
                                                            </h6>
                                                        </div>

                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2">
                                                            <div class="listing-card-info-icon">
                                                                تاريخ مشاهده العقار :
                                                                    <?php $newDate = date('d-m-Y', strtotime($val->created_at));
                                                                    echo $newDate; ?>

                                                            </div>


                                                        </div>
                                                    </div>

                                                    <div class="btnAdds listing-detail-footer">
                                                        <div class="footer-first">
                                                            <div class="foot-location">
                                                                @if ($val->all_aqat_viw->governrateq)
                                                                    {{ $val->all_aqat_viw->governrateq->governrate }}
                                                                @endif,
                                                                @if ($val->all_aqat_viw->districte)
                                                                    {{ $val->all_aqat_viw->districte->district }}
                                                                @endif
                                                                @if ($val->all_aqat_viw->subAreaa)
                                                                    {{ $val->all_aqat_viw->subAreaa->area }}
                                                                @endif
                                                                <img src="{{ asset('assets/img/pin.svg') }}"
                                                                     width="18" alt="" loading="lazy"/>

                                                            </div>
                                                        </div>
                                                        <a class="btn btn-light  ml-2 addToCart"
                                                           data-id="{{ $val->all_aqat_viw['id'] }}"> حفظ
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-heart"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                                            </svg>
                                                        </a>
                                                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $val->all_aqat_viw->slug) }}"
                                                           id="btn1" class="btn" target="_blank">عرض</a>

                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else

                                <div class="col-lg-12">
                                    <div class="card mt-3" style="margin: 0 0px;">
                                        <div class="row no-gutters">


                                            <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                    <div>
                                                        <img style=" object-fit: contain;"
                                                             src="https://rightchoice-co.com/assets/img/rclogo.png"
                                                             class="img-fluid mx-auto" alt="" loading="lazy"/>
                                                    </div>


                                                </div>


                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap flex-block">
                                                            <div class="listing-short-detail">
                                                                <h4 class="listing-name verified"><a href="#"
                                                                                                     target="_blank">
                                                                    </a></h4>
                                                                <!-- <h4 class="listing-name verified">
                                                                <a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->


                                                            </div>

                                                            <div>


                                                            </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                            </h6>
                                                        </div>

                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2">
                                                            <div class="listing-card-info-icon">
                                                                <h3></br></br>
                                                                    تم مسح العقار
                                                                </h3>
                                                            </div>


                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--     aqar has been deleted -->
                            @endif
                        @endforeach


                        <div style="  direction: rtl;">

                            {{ $all_data->links() }} </div>


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
