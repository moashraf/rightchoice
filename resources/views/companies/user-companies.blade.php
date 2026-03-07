<x-layout>
    @section('title')
        شركاتي
    @endsection
    <?PHP
    $user = auth()->user();

    if (isset($user)) {
    } else {
        dd("يجب تسجيل الدخول ");
    }

    ?>

    <section id="profile-info" class="bg-light">

        <div class="container">

            <div class="main-body">


                <div class="row gutters-sm">


                    <div class="col-md-8">


                        @foreach ($allCompanies as $comp)
                            <div class="col-lg-12">
                                <div class="card mt-3">
                                    <div class="row no-gutters">


                                        <div class="col-sm-5 col-card-imgs">
                                            <div class="click">


                                                <div>
                                                    <a href="{{ URL::to(Config::get('app.locale').'/companies/' . $comp->slug) }}"><img
                                                            src="{{ URL::to('/') . '/images/' . $comp->photo }}"
                                                            class="img-fluid mx-auto" alt=""/></a></div>


                                            </div>
                                        </div>
                                        <div class="col-sm-7 order-lg-first col-card-details">
                                            <div class="card-body">
                                                <div class="listing-detail-wrapper">
                                                    <div class="listing-short-detail-wrap">
                                                        <div class="listing-short-detail">

                                                            <h4 class="listing-name verified"><a
                                                                    href="{{ URL::to(Config::get('app.locale').'/update_companies/' .$comp->slug) }}"
                                                                    class="">

                                                                    {{ $comp->Name }}
                                                                </a></h4>
                                                            <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->


                                                        </div>
                                                        @if ($comp->status == 0)
                                                            <div>

                                                                <a href="#" class="btn btn-outline-warning">جاري
                                                                    المراجعه</a>

                                                            </div>
                                                        @endif

                                                    </div>
                                                    <div class="listing-short-detail-flex">
                                                        <p class="listing-card-info-price2">
                                                            {{ Str::limit($comp->details, 60, '...') }}
                                                        </p>
                                                    </div>
                                                    <div class="foot-location">

                                                        @if ($comp->governrate_id)
                                                            {{ $comp->governrateq->governrate }},
                                                        @endif
                                                        @if ($comp->district_id)
                                                            {{ $comp->district_ashraf->district }}
                                                        @endif
                                                        @if ($comp->area_id && $comp->subArea)
                                                            ,{{ $comp->subArea->area }}
                                                        @endif
                                                        <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt=""/>
                                                    </div>
                                                </div>


                                                <div class="btnAdds">
                                                    <!-- <a href="#" type="button" class="btn btn-outline-danger  ml-2 removeFromCompany" data-id="{{$comp['id']}}"> حذف</a>   -->
                                                    <a href="#" type="button" class="btn btn-outline-danger  ml-2 "
                                                       data-id="{{$comp['id']}}"> حذف</a>
                                                    <a href="{{ URL::to(Config::get('app.locale').'/update_companies/' .$comp->slug) }}"
                                                       class="btn btn-outline-dark ml-2">تعديل</a>

                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{ $allCompanies->links() }}


                    </div>

                </div>


            </div>

        </div>


    </section>


    <!-- ============================ Call To Action ================================== -->
    <x-call-to-action/>
    <!-- ============================ Call To Action End ================================== -->

</x-layout>
