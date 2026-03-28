<x-layout>

    @section('title')
        مقارنة العقارات
    @endsection

    <section class="py-5">
        <div class="container">
            <div class="compare-header text-center mb-4">
                <h2 class="compare-title">مقارنة العقارات</h2>
                <p class="text-muted">قارن بين {{ $aqars->count() }} عقارات جنبًا إلى جنب</p>
                <a href="javascript:void(0);" onclick="CompareManager.clearAll(); window.history.back();" class="btn btn-outline-danger btn-sm mt-2">
                    <i class="fas fa-trash-alt"></i> مسح الكل والعودة
                </a>
            </div>

            {{-- Property Images & Titles Row --}}
            <div class="compare-table-wrapper">
                <table class="table compare-table">
                    <thead>
                        <tr>
                            <th class="compare-label-col"></th>
                            @foreach($aqars as $aqar)
                                <th class="compare-property-col text-center">
                                    <div class="compare-property-card">
                                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}" target="_blank" class="compare-img-link">
                                            @if($aqar->mainImage)
                                                <img src="{{ URL::to('/') . '/images/' . $aqar->mainImage->img_url }}" class="compare-property-img" alt="{{ $aqar->title }}" loading="lazy">
                                            @elseif($aqar->firstImage)
                                                <img src="{{ URL::to('/') . '/images/' . $aqar->firstImage->img_url }}" class="compare-property-img" alt="{{ $aqar->title }}" loading="lazy">
                                            @else
                                                <img src="https://rightchoice-co.com/images/FBO.png" class="compare-property-img" alt="no image" loading="lazy">
                                            @endif
                                        </a>
                                        <h5 class="compare-property-title mt-2">
                                            <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}" target="_blank">{{ $aqar->title }}</a>
                                        </h5>
                                        <button class="btn btn-sm btn-outline-danger compare-remove-btn" onclick="CompareManager.remove({{ $aqar->id }}); location.reload();">
                                            <i class="fas fa-times"></i> إزالة
                                        </button>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Price --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-tag"></i> السعر</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->offer_type == 1 || $aqar->offer_type == 2 || $aqar->offer_type == 5)
                                        <strong>{{ number_format($aqar->total_price) }}</strong> جنيه
                                    @elseif($aqar->offer_type == 3 || $aqar->offer_type == 4)
                                        <strong>{{ number_format($aqar->monthly_rent) }}</strong> جنيه/شهر
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Offer Type --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-handshake"></i> نوع العرض</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->offerTypes ? $aqar->offerTypes->offer : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Category --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-th-large"></i> التصنيف</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->categoryRel ? $aqar->categoryRel->cat : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Property Type --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-building"></i> نوع العقار</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->propertyType ? $aqar->propertyType->propertytype : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Total Area --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-ruler-combined"></i> المساحة</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    <strong>{{ $aqar->total_area }}</strong> م²
                                </td>
                            @endforeach
                        </tr>

                        {{-- Rooms --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-door-open"></i> الغرف</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">{{ $aqar->rooms ?? '—' }}</td>
                            @endforeach
                        </tr>

                        {{-- Bathrooms --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-bath"></i> الحمامات</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">{{ $aqar->baths ?? '—' }}</td>
                            @endforeach
                        </tr>

                        {{-- Floor --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-layer-group"></i> الدور</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->floorNo ? $aqar->floorNo->floor : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Finish Type --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-paint-roller"></i> نوع التشطيب</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->finishType ? $aqar->finishType->finish : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Location --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-map-marker-alt"></i> الموقع</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->governrateq ? $aqar->governrateq->governrate : '' }}
                                    @if($aqar->districte) , {{ $aqar->districte->district }} @endif
                                    @if($aqar->subAreaa) , {{ $aqar->subAreaa->area }} @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Compound --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-city"></i> الكمبوند</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    {{ $aqar->compounds ? $aqar->compounds->compound : '—' }}
                                </td>
                            @endforeach
                        </tr>

                        {{-- Price per meter --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-calculator"></i> سعر المتر</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->mtr_price)
                                        <strong>{{ number_format($aqar->mtr_price) }}</strong> جنيه/م²
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Down Payment --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-money-bill-wave"></i> المقدم</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->downpayment)
                                        <strong>{{ number_format($aqar->downpayment) }}</strong> جنيه
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Installment --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-calendar-alt"></i> القسط الشهري</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->installment_value)
                                        <strong>{{ number_format($aqar->installment_value) }}</strong> جنيه
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Installment Period --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-clock"></i> مدة التقسيط</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->installment_time)
                                        {{ $aqar->installment_time }} سنة
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Licensed --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-certificate"></i> مرخص</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->licensed)
                                        <span class="badge bg-success text-white">نعم</span>
                                    @else
                                        <span class="badge bg-secondary text-white">لا</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- Features (Mzaya) --}}
                        <tr>
                            <td class="compare-label"><i class="fas fa-star"></i> المميزات</td>
                            @foreach($aqars as $aqar)
                                <td class="text-center compare-value">
                                    @if($aqar->mzaya && $aqar->mzaya->count())
                                        <div class="compare-features">
                                            @foreach($aqar->mzaya as $mz)
                                                <span class="badge bg-light text-dark me-1 mb-1">{{ $mz->mzaya }}</span>
                                            @endforeach
                                        </div>
                                    @else
                                        —
                                    @endif
                                </td>
                            @endforeach
                        </tr>

                        {{-- View Details Link --}}
                        <tr>
                            <td class="compare-label"></td>
                            @foreach($aqars as $aqar)
                                <td class="text-center">
                                    <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}" target="_blank" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> عرض التفاصيل
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <style>
        .compare-header { padding-top: 20px; }
        .compare-title {
            font-size: 28px;
            font-weight: 700;
            color: #294c5f;
        }
        .compare-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.08);
            background: #fff;
        }
        .compare-table {
            margin-bottom: 0;
            min-width: 700px;
        }
        .compare-table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            vertical-align: top;
            padding: 20px 15px;
        }
        .compare-label-col {
            width: 180px;
            min-width: 150px;
        }
        .compare-property-col {
            min-width: 220px;
        }
        .compare-property-card {
            padding: 10px;
        }
        .compare-property-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .compare-property-img:hover {
            transform: scale(1.03);
        }
        .compare-property-title a {
            color: #294c5f;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
        }
        .compare-property-title a:hover {
            color: #ff5722;
        }
        .compare-label {
            font-weight: 600;
            color: #294c5f;
            background: #f8f9fa;
            white-space: nowrap;
            padding: 12px 15px !important;
            vertical-align: middle;
        }
        .compare-label i {
            color: #ff5722;
            margin-left: 8px;
            width: 20px;
            text-align: center;
        }
        .compare-value {
            padding: 12px 15px !important;
            vertical-align: middle;
            font-size: 14px;
        }
        .compare-table tbody tr:nth-child(even) {
            background-color: #fafbfc;
        }
        .compare-table tbody tr:hover {
            background-color: #f0f4f8;
        }
        .compare-remove-btn {
            font-size: 12px;
            border-radius: 20px;
            padding: 4px 12px;
            margin-top: 8px;
        }
        .compare-features {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 4px;
        }
        .compare-features .badge {
            font-size: 12px;
            border: 1px solid #dee2e6;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .compare-title { font-size: 22px; }
            .compare-label-col { width: 120px; min-width: 120px; }
            .compare-property-col { min-width: 180px; }
            .compare-property-img { height: 140px; }
            .compare-label { font-size: 13px; }
            .compare-value { font-size: 13px; }
        }
    </style>

</x-layout>
