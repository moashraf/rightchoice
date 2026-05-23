<x-layout>

    @section('title')
        العقارات التي تم التواصل مع ملاكها
    @endsection

    <section id="profile-info" class="bg-light">
        <div class="container">
            <div class="main-body text-center">
                <div class="row gutters-sm">
                    <div class="col-md-8 text-right">
                        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:10px;">
                            <h3 class="mt-3 mb-0">العقارات التي تم التواصل مع ملاكها</h3>
                            <a href="{{ URL::to(Config::get('app.locale').'/my-payments') }}" class="btn btn-sm btn-outline-success">
                                <i class="fa fa-credit-card ml-1"></i> مدفوعاتي
                            </a>
                        </div>

                        @if($all_data->isEmpty())
                            <div class="alert alert-info text-center">
                                لم تقم بالتواصل مع أي عقار حتى الآن.
                            </div>
                        @else
                            @foreach ($all_data as $val)
                                @if ($val->all_aqat_viw != null)
                                    @php
                                        $aq = $val->all_aqat_viw;
                                        $offerTypeId = optional($aq->offerTypes)->id;
                                    @endphp

                                    <div class="col-lg-12">
                                        <div class="card mt-3" style="margin: 0 0px;">
                                            <div class="row no-gutters">
                                                <div class="col-sm-5 col-card-imgs">
                                                    <div class="click">
                                                        <div>
                                                            <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aq->slug) }}" target="_blank">
                                                                @if ($aq->firstImage)
                                                                    <img src="{{ URL::to('/') . '/images/' . $aq->firstImage->img_url }}"
                                                                         class="img-fluid mx-auto" alt="{{ $aq->title }}" loading="lazy"/>
                                                                @else
                                                                    <img src="https://rightchoice-co.com/images/FBO.png"
                                                                         class="img-fluid main-img" alt="main" loading="lazy">
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="views-2">
                                                        <i class="fa fa-eye"></i>
                                                        <span>{{ $aq->views }}</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-7 order-lg-first col-card-details">
                                                    <div class="card-body">
                                                        <div class="listing-detail-wrapper">
                                                            <div class="listing-short-detail-wrap flex-block">
                                                                <div class="listing-short-detail">
                                                                    <h4 class="listing-name verified">
                                                                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aq->slug) }}" target="_blank">
                                                                            {{ $aq->title }}
                                                                        </a>
                                                                    </h4>
                                                                </div>

                                                                <div>
                                                                    <span class="btn btn-outline-warning">
                                                                        عدد النقاط التي تم خصمها : {{ $aq->points_avail }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="listing-short-detail-flex">
                                                                <h6 class="listing-card-info-price2">
                                                                    @if ($offerTypeId == 1 || $offerTypeId == 2)
                                                                        {{ $aq->total_price }}
                                                                    @elseif ($offerTypeId == 3 || $offerTypeId == 4)
                                                                        {{ $aq->monthly_rent }}
                                                                    @endif
                                                                    جنيه مصري
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        <div class="list-rap">
                                                            <div class="list-fx-features2">
                                                                <div class="listing-card-info-icon">
                                                                    تاريخ مشاهدة العقار :
                                                                    {{ \Carbon\Carbon::parse($val->created_at)->format('d-m-Y') }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="btnAdds listing-detail-footer">
                                                            <div class="footer-first">
                                                                <div class="foot-location">
                                                                    @if ($aq->governrateq)
                                                                        {{ $aq->governrateq->governrate }}
                                                                    @endif
                                                                    @if ($aq->districte)
                                                                        , {{ $aq->districte->district }}
                                                                    @endif
                                                                    @if ($aq->subAreaa)
                                                                        , {{ $aq->subAreaa->area }}
                                                                    @endif
                                                                    <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy"/>
                                                                </div>
                                                            </div>

                                                            <a class="btn btn-light ml-2 addToCart" data-id="{{ $aq->id }}">
                                                                حفظ
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                                    <path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aq->slug) }}" id="btn1" class="btn" target="_blank">عرض</a>
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
                                                            <img style="object-fit: contain;"
                                                                 src="https://rightchoice-co.com/assets/img/rclogo.png"
                                                                 class="img-fluid mx-auto" alt="" loading="lazy"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-7 order-lg-first col-card-details">
                                                    <div class="card-body">
                                                        <div class="list-rap">
                                                            <div class="list-fx-features2">
                                                                <div class="listing-card-info-icon">
                                                                    <h3><br><br>تم مسح العقار</h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div style="direction: rtl;">
                                {{ $all_data->links() }}
                            </div>
                        @endif
                    </div>

                    @include('components.profile-sidebar')
                </div>
            </div>
        </div>
    </section>

    <x-call-to-action/>

</x-layout>

