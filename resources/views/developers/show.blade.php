<x-layout>

    @section('title')
        {{ $user->name }} - {{ trans('langsite.developer_profile') }}
    @endsection

    <section id="inner-listing" dir="rtl">
        <div class="container">

            <div class="row">
                {{-- Developer card (left/right depending on RTL) --}}
                <div class="col-lg-4">
                    <div class="sticky">
                        <div class="card">
                            <div class="card-body text-center">
                                @if($user->profile_image)
                                    <img src="{{ URL::to('/') . '/images/' . $user->profile_image }}"
                                         alt="{{ $user->name }}"
                                         style="width:140px;height:140px;border-radius:50%;object-fit:cover;border:3px solid #f5f5f5;"
                                         loading="lazy">
                                @else
                                    <div aria-label="{{ $user->name }}"
                                         style="width:140px;height:140px;border-radius:50%;background:#fff;border:3px solid #f5f5f5;margin:0 auto;"></div>
                                @endif

                                <h4 class="headingTitle2 mt-3">{{ $user->Commercial_Register }}</h4>

                                <div style="color:#666;margin-top:6px;">
                                    <i class="fas fa-building"></i>
                                    {{ trans('langsite.developer_badge') }}
                                </div>

                                <hr class="hr-add">

                                <div class="fr-grid-deatil-flex details mt-3" style="justify-content:center;">
                                    @if($user->name_of_real_estate_developer)
                                        <div class="listing-card-info-icon">
                                            {{ trans('langsite.name_of_real_estate_developer') }}: {{ $user->name_of_real_estate_developer }}
                                        </div>
                                    @endif

                                    @if($user->Commercial_Register)
                                        <div class="listing-card-info-icon mt-2">
                                            {{ trans('langsite.commercial_register') }}: {{ $user->Commercial_Register }}
                                        </div>
                                    @endif

                                    @if($user->MOP)
                                        <div class="listing-card-info-icon mt-2">
                                            <a href="tel:{{ $user->MOP }}">{{ $user->MOP }}</a>
                                        </div>
                                    @endif

                                    @if($user->email)
                                        <div class="listing-card-info-icon mt-2">
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </div>
                                    @endif
                                </div>

                                <hr class="hr-add">

                                <div class="text-center">
                                    @if($user->MOP)
                                        <a href="tel:{{ $user->MOP }}" class="btn btn-light mr-1 ml-1 mt-2">
                                            <i class="fas fa-phone"></i> {{ trans('langsite.call') }}
                                        </a>
                                    @endif
                                    <a href="{{ URL::to(Config::get('app.locale') . '/developers') }}"
                                       class="btn our-btn mt-2">
                                        {{ trans('langsite.back_to_developers') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Properties --}}
                <div class="col-lg-8">
                    <h3 class="headingTitle2">
                        {{ trans('langsite.developer_properties') }}
                        <small style="color:#888;font-size:14px;">({{ $allAqars->total() }})</small>
                    </h3>

                    <form action="{{ URL::to('/' . Config::get('app.locale') . '/developers/' . $user->id) }}"
                          method="get" class="mt-3 mb-3">
                        <div class="row">
                            <div class="col-lg-9 col-md-8 col-8">
                                <input name="keywords" type="text" class="form-control"
                                       placeholder="{{ trans('langsite.search_in_properties') }}"
                                       value="{{ $q }}">
                            </div>
                            <div class="col-lg-3 col-md-4 col-4">
                                <input type="submit" class="btn our-btn w-100"
                                       value="{{ trans('langsite.search') }}"/>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        @forelse($allAqars as $aqar)
                            @include('developers._card', ['aqar' => $aqar])
                        @empty
                            <div class="col-lg-12 text-center mt-4">
                                <h5>{{ trans('langsite.no_properties_found') }}</h5>
                            </div>
                        @endforelse
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12 d-flex justify-content-center">
                            {!! $allAqars->render() !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-layout>

