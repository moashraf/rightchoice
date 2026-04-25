{{-- Property card partial reused on developer profile page --}}
<div class="col-lg-12">
    <div class="card mt-3" style="margin: 0 0px;">
        <div class="row no-gutters">

            <div class="col-sm-5 col-card-imgs">
                <div class="click">
                    <div>
                        <a target="_blank"
                           href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}">
                            @if ($aqar->mainImage)
                                <img src="{{ URL::to('/') . '/images/' . $aqar->mainImage->img_url }}"
                                     class="img-fluid mx-auto" alt="main" loading="lazy">
                            @elseif($aqar->firstImage)
                                <img src="{{ URL::to('/') . '/images/' . $aqar->firstImage->img_url }}"
                                     class="img-fluid mx-auto" alt="" loading="lazy"/>
                            @else
                                <img src="https://rightchoice-co.com/images/FBO.png"
                                     class="img-fluid main-img" alt="main" loading="lazy">
                            @endif
                        </a>
                    </div>
                </div>

                <?php if ($aqar->vip == 1 && \Carbon\Carbon::now()->diffInYears($aqar->created_at) < 1) { ?>
                <div class="views">
                    <div class="views-1">مميز</div>
                </div>
                <?php } ?>

                <div class="views-2">
                    <i class="fa fa-eye"></i>
                    <span>{{ $aqar->views }}</span>
                </div>
            </div>

            <div class="col-sm-7 order-lg-first col-card-details">
                <div class="card-body">
                    <div class="listing-detail-wrapper">
                        <div class="listing-short-detail-wrap">
                            <div class="listing-short-detail">
                                <h4 class="listing-name verified">
                                    <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}"
                                       target="_blank">
                                        {{ $aqar->title }}
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div class="listing-short-detail-flex">
                            <h6 class="listing-card-info-price2">
                                @if ($aqar->offerTypes && ($aqar->offerTypes->id == 1 || $aqar->offerTypes->id == 2))
                                    {{ $aqar->total_price }}
                                @endif
                                @if ($aqar->offerTypes && ($aqar->offerTypes->id == 3 || $aqar->offerTypes->id == 4))
                                    {{ $aqar->monthly_rent }}
                                @endif جنيه مصري
                            </h6>
                        </div>
                    </div>

                    <div class="list-rap">
                        <div class="list-fx-features2">
                            <div class="listing-card-info-icon">
                                {{ $aqar->baths }} حمام
                                <div class="inc-fleat-icon">
                                    <img src="{{ asset('images/icons/area.png') }}" width="13" alt="" loading="lazy"/>
                                </div>
                            </div>
                            <div class="listing-card-info-icon">
                                {{ $aqar->rooms }} غرف
                                <div class="inc-fleat-icon">
                                    <img src="{{ asset('images/icons/room.png') }}" width="13" alt="" loading="lazy"/>
                                </div>
                            </div>
                            <div class="listing-card-info-icon">
                                {{ $aqar->total_area }} م²
                                <div class="inc-fleat-icon">
                                    <img src="{{ asset('images/icons/area.png') }}" width="13" alt="" loading="lazy"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="btnAdds listing-detail-footer">
                        <div class="footer-first">
                            <div class="foot-location">
                                @if ($aqar->governrateq)
                                    {{ $aqar->governrateq->governrate }}
                                @endif
                                @if ($aqar->districte)
                                    , {{ $aqar->districte->district }}
                                @endif
                                <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy"/>
                            </div>
                        </div>
                        <a class="btn btn-light ml-2 addToCart" data-id="{{ $aqar['id'] }}"> حفظ
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                            </svg>
                        </a>
                        <a href="{{ URL::to(Config::get('app.locale') . '/aqars/' . $aqar->slug) }}"
                           id="btn1" class="btn" target="_blank">عرض</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

