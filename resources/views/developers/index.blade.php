<x-layout>

    @section('title')
        {{ trans('langsite.developers') }}
    @endsection

    <div class="image-cover hero-banner"
         style="background:url('{{ asset('assets/img/banner-1.jpg') }}') no-repeat center/cover;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="hero__p">
                        <h1>{{ trans('langsite.developers') }}</h1>
                        <p>{{ trans('langsite.developers_intro') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="articels" dir="rtl">
        <div class="container">
            <br>

            <form action="{{ URL::to('/' . Config::get('app.locale') . '/developers') }}"
                  id="sortform" method="get">
                <div class="col-lg-12 row searchRow">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4">
                        <input name="keywords" type="text" class="form-control"
                               placeholder="{{ trans('langsite.search_developers') }}"
                               value="{{ $q }}" tabindex="0">
                    </div>
                    <div class="col-lg-2">
                        <input type="submit" class="btn our-btn"
                               value="{{ trans('langsite.search') }}"/>
                    </div>
                </div>
            </form>

            <br><br>

            <div class="row">
                @forelse ($developers as $dev)
                    <div class="col-lg-4 col-md-6 mt-3">
                        <a href="{{ URL::to(Config::get('app.locale') . '/developers/' . $dev->id) }}"
                           style="text-decoration:none;color:inherit;">
                            <div class="box developer-box"
                                 style="background:#fff;border:1px solid #eee;border-radius:10px;padding:20px;text-align:center;height:100%;box-shadow:0 2px 6px rgba(0,0,0,.04);transition:.2s;">
                                @if($dev->profile_image)
                                    <img src="{{ URL::to('/') . '/images/' . $dev->profile_image }}"
                                         alt="{{ $dev->name }}"
                                         style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #f5f5f5;"
                                         loading="lazy">
                                @else
                                    <img src="{{ asset('assets/img/avatar.png') }}"
                                         alt="{{ $dev->name }}"
                                         onerror="this.src='https://rightchoice-co.com/images/FBO.png'"
                                         style="width:120px;height:120px;border-radius:50%;object-fit:cover;border:3px solid #f5f5f5;"
                                         loading="lazy">
                                @endif

                                <h3 style="margin-top:15px;font-size:18px;">{{ $dev->name }}</h3>

                                <div style="color:#888;font-size:13px;margin-top:6px;">
                                    <i class="fas fa-building"></i>
                                    {{ trans('langsite.developer_badge') }}
                                </div>

                                <div style="margin-top:10px;color:#0a8f3c;font-weight:bold;">
                                    {{ trans('langsite.properties_count') }}:
                                    {{ $dev->aqars_count }}
                                </div>

                                <span class="btn our-btn mt-3" style="display:inline-block;">
                                    {{ trans('langsite.view_profile') }}
                                </span>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-lg-12 text-center mt-5">
                        <h4>{{ trans('langsite.no_developers_found') }}</h4>
                    </div>
                @endforelse
            </div>

            <div class="row mt-4">
                <div class="col-lg-12 d-flex justify-content-center">
                    {!! $developers->render() !!}
                </div>
            </div>
        </div>
    </section>

</x-layout>

