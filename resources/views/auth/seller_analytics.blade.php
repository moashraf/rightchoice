<x-layout>
@section('title')
    لوحة تحليلات العقار
@endsection

@php
    /** @var \App\Models\aqar $aqar */
    /** @var array $summary */
    /** @var int $days */
    /** @var array $periods */

    $locale = Config::get('app.locale');
    $isRtl  = $locale !== 'en';

    $formatNumber = function ($number) {
        return number_format((int) $number);
    };

    $formatPercent = function ($value) {
        if ($value === null) return '0%';
        $prefix = $value > 0 ? '+' : '';
        return $prefix . number_format($value, 2) . '%';
    };

    $imageUrl = null;
    if ($aqar->mainImage) {
        $imageUrl = URL::to('/') . '/images/' . $aqar->mainImage->img_url;
    } elseif ($aqar->firstImage) {
        $imageUrl = URL::to('/') . '/images/' . $aqar->firstImage->img_url;
    } else {
        $imageUrl = asset('images/FBO.png');
    }

    $statusLabel = 'مسودة';
    $statusClass = 'badge-secondary';
    if ((int) $aqar->status === 1) {
        $statusLabel = 'منشور';
        $statusClass = 'badge-success';
    } elseif ((int) $aqar->status === 0) {
        $statusLabel = 'قيد المراجعة';
        $statusClass = 'badge-warning';
    } else {
        $statusLabel = 'غير نشط';
        $statusClass = 'badge-danger';
    }

    $offerLabel = '';
    if ($aqar->offerTypes) {
        $offerId = (int) $aqar->offerTypes->id;
        if (in_array($offerId, [1, 2, 5], true)) {
            $offerLabel = 'بيع';
        } elseif (in_array($offerId, [3, 4], true)) {
            $offerLabel = 'إيجار';
        }
    }

    $isVip = (int) $aqar->vip === 1;

    $cards = [
        [
            'key'   => 'total_views',
            'title' => 'إجمالي المشاهدات',
            'icon'  => 'fa-eye',
            'color' => '#294c5f',
            'value' => $summary['total_views'],
            'change'=> $summary['percentage_changes']['total_views'] ?? 0,
        ],
        [
            'key'   => 'unique_views',
            'title' => 'المشاهدات الفريدة',
            'icon'  => 'fa-user-check',
            'color' => '#1abc9c',
            'value' => $summary['unique_views'],
            'change'=> $summary['percentage_changes']['unique_views'] ?? 0,
        ],
        [
            'key'   => 'contact_reveals',
            'title' => 'فتح بيانات التواصل',
            'icon'  => 'fa-phone',
            'color' => '#3498db',
            'value' => $summary['contact_reveals'],
            'change'=> $summary['percentage_changes']['contact_reveals'] ?? 0,
        ],
        [
            'key'   => 'whatsapp_clicks',
            'title' => 'ضغطات واتساب',
            'icon'  => 'fa-comments',
            'color' => '#25D366',
            'value' => $summary['whatsapp_clicks'],
            'change'=> $summary['percentage_changes']['whatsapp_clicks'] ?? 0,
        ],
        [
            'key'   => 'favorites',
            'title' => 'الإضافة للمفضلة',
            'icon'  => 'fa-heart',
            'color' => '#e74c3c',
            'value' => $summary['favorites'],
            'change'=> $summary['percentage_changes']['favorites'] ?? 0,
        ],
        [
            'key'   => 'comparisons',
            'title' => 'الإضافة للمقارنة',
            'icon'  => 'fa-balance-scale',
            'color' => '#9b59b6',
            'value' => $summary['comparisons'],
            'change'=> $summary['percentage_changes']['comparisons'] ?? 0,
        ],
        [
            'key'   => 'shares',
            'title' => 'المشاركة',
            'icon'  => 'fa-share-alt',
            'color' => '#f39c12',
            'value' => $summary['shares'],
            'change'=> $summary['percentage_changes']['shares'] ?? 0,
        ],
        [
            'key'   => 'contact_conversion_rate',
            'title' => 'معدل التحويل',
            'icon'  => 'fa-percent',
            'color' => '#16a085',
            'value' => $summary['contact_conversion_rate'] . '%',
            'change'=> null,
        ],
    ];
@endphp

<section id="seller-analytics" class="bg-light" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <div class="container py-4">

        <div class="analytics-header card p-3 mb-4" style="border-radius:14px; box-shadow:0 4px 20px rgba(0,0,0,0.05);">
            <div class="row align-items-center">
                <div class="col-md-3 mb-2 mb-md-0">
                    <img src="{{ $imageUrl }}" alt="{{ $aqar->title }}" class="img-fluid rounded" style="max-height:160px; width:100%; object-fit:cover;">
                </div>
                <div class="col-md-6">
                    <h3 class="mb-2" style="font-weight:700;">{{ $aqar->title }}</h3>
                    <div class="d-flex flex-wrap align-items-center" style="gap:8px;">
                        <span class="badge {{ $statusClass }}" style="font-size:12px; padding:6px 10px;">{{ $statusLabel }}</span>
                        @if($offerLabel)
                            <span class="badge badge-info" style="font-size:12px; padding:6px 10px;">{{ $offerLabel }}</span>
                        @endif
                        @if($isVip)
                            <span class="badge badge-warning text-dark" style="font-size:12px; padding:6px 10px;">
                                <i class="fa fa-star"></i> VIP
                            </span>
                        @endif
                        @if(!empty($aqar->ref_code))
                            <span class="badge badge-light border" style="font-size:12px; padding:6px 10px;">
                                رقم مرجعي: {{ $aqar->ref_code }}
                            </span>
                        @endif
                    </div>
                    <div class="mt-2 text-muted" style="font-size:13px;">
                        @if($aqar->governrateq){{ $aqar->governrateq->governrate }}@endif
                        @if($aqar->districte), {{ $aqar->districte->district }}@endif
                        @if($aqar->subAreaa), {{ $aqar->subAreaa->area }}@endif
                    </div>
                </div>
                <div class="col-md-3 text-md-left text-center mt-3 mt-md-0">
                    <a href="{{ URL::to($locale . '/aqars/' . $aqar->slug) }}" target="_blank"
                       class="btn btn-outline-primary btn-block mb-2">
                        <i class="fa fa-external-link-alt"></i> عرض العقار
                    </a>
                    <a href="{{ URL::to($locale . '/aqars/update/' . $aqar->slug) }}"
                       class="btn btn-outline-dark btn-block">
                        <i class="fa fa-edit"></i> تعديل العقار
                    </a>
                </div>
            </div>

            <hr>

            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div>
                    <strong>الفترة الحالية:</strong>
                    <span class="text-muted">{{ $summary['period_start'] }} → {{ $summary['period_end'] }}</span>
                </div>
                <div class="btn-group mt-2 mt-md-0" role="group" aria-label="Period filter">
                    @foreach($periods as $period)
                        <a href="{{ route('seller.property.analytics', ['locale' => $locale, 'aqar' => $aqar, 'days' => $period]) }}"
                           class="btn btn-sm {{ (int) $days === (int) $period ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $period }} يوم
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($cards as $card)
                @php
                    $change = $card['change'];
                    $changeClass = 'text-muted';
                    $changeIcon  = 'fa-minus';
                    if ($change !== null) {
                        if ($change > 0) { $changeClass = 'text-success'; $changeIcon = 'fa-arrow-up'; }
                        elseif ($change < 0) { $changeClass = 'text-danger'; $changeIcon = 'fa-arrow-down'; }
                    }
                @endphp
                <div class="col-xl-3 col-md-6 col-sm-12 mb-3">
                    <div class="card h-100" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.05);">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="stat-icon me-2" style="background:{{ $card['color'] }}20; color:{{ $card['color'] }}; width:44px; height:44px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
                                    <i class="fa {{ $card['icon'] }}"></i>
                                </div>
                                <h6 class="mb-0 mr-2 ml-2" style="font-weight:600;">{{ $card['title'] }}</h6>
                            </div>
                            <div class="stat-value" style="font-size:28px; font-weight:700; color:#222;">
                                {{ is_numeric($card['value']) ? $formatNumber($card['value']) : $card['value'] }}
                            </div>
                            @if($card['change'] !== null)
                                <div class="mt-2 {{ $changeClass }}" style="font-size:13px;">
                                    <i class="fa {{ $changeIcon }}"></i>
                                    {{ $formatPercent($card['change']) }}
                                    <span class="text-muted"> عن الفترة السابقة</span>
                                </div>
                            @else
                                <div class="mt-2 text-muted" style="font-size:13px;">
                                    الزوّار الفريدون: {{ $formatNumber($summary['unique_views']) }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card p-3 mb-4" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.05);">
            <h5 class="mb-3" style="font-weight:700;">
                <i class="fa fa-chart-line"></i>
                نشاط العقار اليومي
            </h5>
            <div style="position:relative; height: 340px;">
                <canvas id="analyticsChart"></canvas>
            </div>
            <p class="text-muted text-center mt-3 mb-0" id="noDataMessage" style="display:none;">
                لا توجد بيانات لعرضها في الفترة المحددة
            </p>
        </div>

        <div class="card p-3 mb-5" style="border-radius:12px; border:none; box-shadow:0 2px 12px rgba(0,0,0,0.05);">
            <h5 class="mb-4" style="font-weight:700;">
                <i class="fa fa-project-diagram"></i>
                رحلة العميل
            </h5>

            @php
                $funnel = [
                    [
                        'label' => 'إجمالي المشاهدات',
                        'value' => (int) $summary['total_views'],
                        'color' => '#294c5f',
                    ],
                    [
                        'label' => 'المشاهدات الفريدة',
                        'value' => (int) $summary['unique_views'],
                        'color' => '#1abc9c',
                    ],
                    [
                        'label' => 'فتح بيانات التواصل',
                        'value' => (int) $summary['contact_reveals'],
                        'color' => '#3498db',
                    ],
                    [
                        'label' => 'ضغطات واتساب',
                        'value' => (int) $summary['whatsapp_clicks'],
                        'color' => '#25D366',
                    ],
                ];

                $funnelMax = max(1, $funnel[0]['value']);
            @endphp

            <div class="funnel-wrapper">
                @foreach($funnel as $i => $step)
                    @php
                        $percentageOfTop = $funnelMax > 0 ? round(($step['value'] / $funnelMax) * 100, 2) : 0;
                        $width = max(20, min(100, $percentageOfTop));
                    @endphp
                    <div class="funnel-step" style="text-align:center; margin-bottom:12px;">
                        <div class="d-inline-block" style="min-width:{{ $width }}%; padding:14px 18px; background:{{ $step['color'] }}; color:#fff; border-radius:8px; font-weight:600;">
                            <span style="font-size:14px;">{{ $step['label'] }}</span>
                            <span style="float:{{ $isRtl ? 'left' : 'right' }}; font-size:16px;">{{ $formatNumber($step['value']) }}</span>
                        </div>
                        @if($i < count($funnel) - 1)
                            <div style="color:#bbb; font-size:22px; margin:4px 0;">
                                <i class="fa fa-angle-double-down"></i>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="mt-4 pt-3" style="border-top:1px solid #eee;">
                <div class="row text-center">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="text-muted small">معدل التحويل إلى تواصل</div>
                        <div style="font-size:24px; font-weight:700; color:#16a085;">
                            {{ $summary['contact_conversion_rate'] }}%
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">معدل التحويل إلى واتساب</div>
                        <div style="font-size:24px; font-weight:700; color:#25D366;">
                            {{ $summary['whatsapp_conversion_rate'] }}%
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    (function () {
        var dailyData   = @json($summary['daily_statistics']);
        var isRtl       = @json($isRtl);
        var canvasEl    = document.getElementById('analyticsChart');
        var emptyLabel  = document.getElementById('noDataMessage');

        if (!canvasEl || !window.Chart) {
            return;
        }

        var labels          = dailyData.map(function (d) { return d.date; });
        var viewsData       = dailyData.map(function (d) { return d.views || 0; });
        var contactData     = dailyData.map(function (d) { return d.contact_reveals || 0; });
        var whatsappData    = dailyData.map(function (d) { return d.whatsapp_clicks || 0; });

        var hasAnyData = viewsData.concat(contactData, whatsappData).some(function (v) { return v > 0; });
        if (!hasAnyData && emptyLabel) {
            emptyLabel.style.display = 'block';
        }

        try {
            new Chart(canvasEl.getContext('2d'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'المشاهدات',
                            data: viewsData,
                            borderColor: '#294c5f',
                            backgroundColor: 'rgba(41, 76, 95, 0.15)',
                            tension: 0.3,
                            fill: true,
                        },
                        {
                            label: 'فتح بيانات التواصل',
                            data: contactData,
                            borderColor: '#3498db',
                            backgroundColor: 'rgba(52, 152, 219, 0.12)',
                            tension: 0.3,
                            fill: true,
                        },
                        {
                            label: 'ضغطات واتساب',
                            data: whatsappData,
                            borderColor: '#25D366',
                            backgroundColor: 'rgba(37, 211, 102, 0.12)',
                            tension: 0.3,
                            fill: true,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: {
                            position: 'top',
                            rtl: isRtl,
                            labels: { usePointStyle: true }
                        },
                        tooltip: {
                            rtl: isRtl,
                            titleAlign: isRtl ? 'right' : 'left',
                            bodyAlign:  isRtl ? 'right' : 'left'
                        }
                    },
                    scales: {
                        x: {
                            reverse: isRtl,
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0 }
                        }
                    }
                }
            });
        } catch (e) {
            if (window.console && console.warn) { console.warn('Analytics chart error', e); }
        }
    })();
</script>

</x-layout>
