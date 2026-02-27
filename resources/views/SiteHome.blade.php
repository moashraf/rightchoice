<x-layout>




		<!-- ============================ Hero Banner  Start================================== -->
		<div class="hero-slide-1">
		    <!--slider-->
		    @if(!empty($slider))
		    @foreach($slider as $slid)
			<div class="image-cover hero-banner single-items"
				style="background:url('{{ URL::to('/').'/admin/public/'.$slid->image}}') no-repeat;">
				<div class="container">

					<div class="row">
						<div class=" form_form col-lg-6 col-md-6 order-2 order-lg-1">
							<form action="{{ Config::get('app.locale') }}/search" method="GET">

								<div class="hero-search-wrap">
									<div class="hero-search">
										<!-- <h1>البحث</h1> -->
									</div>
									<div class="hero-search-content side-form">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<div class="input-with-icon">
														<input name="keywords" type="text" class="form-control"
															placeholder="كلمه البحث">
														<img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy" />
													</div>
												</div>
											</div>
										</div>

										<div class="row">
												<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="form-group">
													<label>   أعلى سعر</label>
										 	<input style="min-height: 56px;" type="number" name="maxPrice" id="maxPrice" class="form-control" />

											</div>
											</div>
											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="form-group">
													<label>           اقل سعر   </label>
											 	<input style="min-height: 56px;" type= "number" name="minPrice" id="minPrice" class="form-control" />

												</div>
											</div>


											<div class="col-lg-4 col-md-6 col-sm-6">
												<div class="form-group">
													<label>{{ trans('langsite.offer_type')}}</label>
													<select name="offerType" id="status" class="form-control"  >
														<option value="">{{ trans('langsite.search')}}</option>
														@foreach ($offers as $off)


															<option value="{{ $off->id }}">

															       @if(App::isLocale('en'))
                                                 {{ $off->type_offer_en }}
                                                @else
                                                 {{ $off->type_offer }}
                                                @endif</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>



									</div>
									<div class="hero-search-action mb-2">
										<button type="submit" class="btn search-btn">{{ trans('langsite.search')}}</button>
									</div>
									<div class="hero-search-action searchDetails">
										<button type="submit" class="btn search-btn2">{{ trans('langsite.searchDetails')}}</button>
									</div>
								</div>
							</form>

						</div>

						<div class="col-lg-6 col-md-12 order-1 order-lg-2">
							<div class="hero__p"><h1>
							    @if(App::isLocale('en'))
							    {{$slid->title_en}}
							    @else
							    {{$slid->title}}
							    @endif
							    </h1>
							<p style="text-align:center;">
							      @if(App::isLocale('en'))
							    	{{$slid->sub_title_en}}
							    @else
							    	{{$slid->sub_title}}
							    @endif

								</p>

									<p style="text-align:center;">
									     @if(App::isLocale('en'))
							    	{{$slid->description_en}}
							    @else
							    	{{$slid->description}}
							    @endif

								</p>
							</div>
						</div>
					</div>

				</div>
			</div>
			@endforeach
			@endif

		</div>
		<!-- ============================ Hero Banner End ================================== -->
		<!-- ============================ Latest Property للبيع Start ================================== -->
		<section class="" dir="ltr">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center mb-4">
						<h2 class="headingTitle">  {{ trans('langsite.Special_ads')}}</h2>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="property-slide">

					@foreach ($vipAqars as $aqarVip)
							<!-- Single Property -->
							<div class="single-items">
								<div class="property-listing shadow-none property-2 border">

									<div class="listing-img-wrapper">

										<div class="list-img-slide">
											<div class="click">

												<div><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarVip->slug) }}">

												    		    		     @if($aqarVip->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqarVip->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                @else

												    @if($aqarVip->firstImage)
												    <img
													src="{{ URL::to('/').'/images/'.$aqarVip->firstImage->img_url}}"
													class="img-fluid mx-auto" alt="" loading="lazy" />
														@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main" loading="lazy" >
													@endif	@endif
													</a></div>


											</div>
										</div>

							   <?php  if($aqarVip->vip ==1 && \Carbon\Carbon::now()->diffInYears($aqarVip->created_at) < 1 ){   ?>

                            <div class="views"  >
                            <div class="views-1">مميز</div>
                              </div>
                                <?php }  ?>
                                    <?php if(\Carbon\Carbon::now()->diffInYears($aqarVip->created_at) >= 1){ ?>
                                        <div class="views " style="left: 13px;">
                                            <div class="viewsRed">غير متاح</div>
                                        </div>
                                        <?php } ?>



					   <div class="views">

                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $aqarVip->views }}</span>

                        </div>
                    </div>
									</div>

									<div class="listing-detail-wrapper">
										<div class="listing-short-detail-wrap">
											<div class="listing-short-detail">
												<h4  class="listing-name verified center-name" ><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarVip->slug) }}"
														class="">{{ \Illuminate\Support\Str::limit($aqarVip->title, $limit = 29, $end = '...')  }}</a></h4>
												<!-- <h4 class="listing-name verified"><a target="_blank" href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
											</div>

										</div>

									</div>
									<div class="listing-short-detail-flex">



                                    @if ($aqarVip->offer_type == 1 || $aqarVip->offer_type == 2 || $aqarVip->offer_type == 5)

                               <h6 class="listing-card-info-price"> {{ $aqarVip->total_price }} {{ trans('langsite.egyptian_pound') }} </h6>

                                    @endif
                                    @if ($aqarVip->offer_type == 3 || $aqarVip->offer_type == 4 )

                                <h6 class="listing-card-info-price"> {{ $aqarVip->monthly_rent }} {{ trans('langsite.egyptian_pound') }} </h6>


                                    @endif




									</div>
									<div class="price-features-wrapper" >
										<div class="list-fx-features" >





											<div class="listing-card-info-icon">
												{{ $aqarVip->baths }} حمام
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>
											<div class="listing-card-info-icon">
												{{ $aqarVip->rooms }} غرف
											<div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
														alt=""  loading="lazy" /></div>
											</div>

											<div class="listing-card-info-icon">
												{{ $aqarVip->total_area }}  م²
															<div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>


										</div>
									</div>

									<div class="listing-detail-footer bg-light">
										<div class="footer-first">
											<div class="foot-location">
											@if ($aqarVip->governrateq)
												{{ $aqarVip->governrateq->governrate }}
											@endif
											@if ($aqarVip->districte)
												{{ $aqarVip->districte->district }}
											@endif


												<img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy" />
											</div>
										</div>
										<div class="footer-flex">
											<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarVip->slug) }}" class="prt-view">عرض</a>
											<!-- <a target="_blank" href="property-detail.html" class="prt-view">View</a> -->
										</div>
									</div>

								</div>
							</div>
					@endforeach


						</div>
					</div>
				</div>

			</div>
		</section>
		<!-- ============================ Latest Property للبيع End ================================== -->



    <!-- ============================ Register CTA Section (Guest Only) ================================== -->
    @guest
        <section class="register-cta-section" dir="rtl">
            <div class="register-cta-overlay"></div>
            <div class="container position-relative" style="z-index:2;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 col-md-10 text-center">
                        <div class="register-cta-content">
                            <div class="register-cta-icon-wrap animate-bounce-in">
                                <div class="register-cta-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ffffff" viewBox="0 0 24 24"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                                </div>
                            </div>
                            <h2 class="register-cta-title animate-fade-up">
                                سجّل الآن <span class="register-cta-highlight">مجاناً</span>
                            </h2>
                            <p class="register-cta-desc animate-fade-up-delay">
                                انضم إلى آلاف المستخدمين واستمتع بالبحث عن أفضل العقارات، إضافة إعلاناتك، وإدارة مفضلتك بكل سهولة
                            </p>
                            <div class="register-cta-features animate-fade-up-delay2">
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>إضافة إعلانات مجانية</span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>حفظ العقارات المفضلة</span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>تواصل مباشر مع المُعلنين</span>
                                </div>
                            </div>
                            <a href="{{ URL::to(Config::get('app.locale').'/register') }}{{ session('invited_by') ? '?invited_by=' . urlencode(session('invited_by')) : '' }}" class="register-cta-btn animate-fade-up-delay3">
                                <span>سجّل الآن مجاناً</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" style="margin-right:8px;"><path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative shapes -->
            <div class="register-cta-shape register-cta-shape-1"></div>
            <div class="register-cta-shape register-cta-shape-2"></div>
        </section>


    @else
        <section class="register-cta-section" dir="rtl">
            <div class="register-cta-overlay"></div>
            <div class="container position-relative" style="z-index:2;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 col-md-10 text-center">
                        <div class="register-cta-content">
                            <div class="register-cta-icon-wrap animate-bounce-in">
                                <div class="register-cta-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#ffffff" viewBox="0 0 24 24">
                                        <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                    </svg>
                                </div>
                            </div>
                            <h2 class="register-cta-title animate-fade-up">
                                أضف عقارك الآن وابدأ
                                <span class="register-cta-highlight">
                                       <br>
                                استقبال العروض فوراً
                                </span>
                            </h2>
                            <p class="register-cta-desc animate-fade-up-delay">
                                حوّل عقارك إلى فرصة استثمارية اليوم
                                <br>
                                أنشئ إعلانك بخطوات بسيطة ودع العملاء يصلون إليك مباشرة.    </p>
                            <div class="register-cta-features animate-fade-up-delay2">
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>إضافة إعلانات مجانية</span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>
                                    تحكم كامل في تفاصيل إعلانك
                                    </span>
                                </div>
                                <div class="register-cta-feature">
                                    <div class="register-cta-feature-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#196aa2" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
                                    </div>
                                    <span>تواصل مباشر مع المُعلنين</span>
                                </div>
                            </div>
                            <a href="{{ URL::to(Config::get('app.locale').'/aqars/create') }}" class="register-cta-btn animate-fade-up-delay3">
                                <span> جرّب إضافة عقارك   مجاناً</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 24 24" style="margin-right:8px;">
                                    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Decorative shapes -->
            <div class="register-cta-shape register-cta-shape-1"></div>
            <div class="register-cta-shape register-cta-shape-2"></div>
        </section>


    @endguest
    <style>
        /* ===== Register CTA Section ===== */
        .register-cta-section {
            position: relative;
            padding: 80px 0;
            background: linear-gradient(135deg, #196aa2 0%, #0d4a73 50%, #196aa2 100%);
            background-size: 200% 200%;
            animation: registerGradientShift 8s ease infinite;
            overflow: hidden;
        }
        @keyframes registerGradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .register-cta-overlay {
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
        }
        /* Decorative floating shapes */
        .register-cta-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            z-index: 1;
        }
        .register-cta-shape-1 {
            width: 300px; height: 300px;
            background: #ffffff;
            top: -80px; left: -80px;
            animation: registerFloat 6s ease-in-out infinite;
        }
        .register-cta-shape-2 {
            width: 200px; height: 200px;
            background: #ffffff;
            bottom: -60px; right: -40px;
            animation: registerFloat 8s ease-in-out infinite reverse;
        }
        @keyframes registerFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        /* Content */
        .register-cta-content {
            position: relative;
            z-index: 2;
        }
        /* Icon */
        .register-cta-icon-wrap {
            margin-bottom: 24px;
        }
        .register-cta-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 90px; height: 90px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            border: 2px solid rgba(255,255,255,0.3);
            backdrop-filter: blur(10px);
            margin: 0 auto;
        }
        /* Title */
        .register-cta-title {
            font-family: 'Cairo', sans-serif;
            font-size: 2.5rem;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 16px;
            line-height: 1.3;
        }
        .register-cta-highlight {
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        /* Description */
        .register-cta-desc {
            font-family: 'Cairo', sans-serif;
            font-size: 1.15rem;
            color: rgba(255,255,255,0.85);
            max-width: 600px;
            margin: 0 auto 32px;
            line-height: 1.8;
        }
        /* Features */
        .register-cta-features {
            display: flex;
            justify-content: center;
            gap: 28px;
            flex-wrap: wrap;
            margin-bottom: 36px;
        }
        .register-cta-feature {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 10px 20px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        .register-cta-feature:hover {
            background: rgba(255,255,255,0.22);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        .register-cta-feature span {
            font-family: 'Cairo', sans-serif;
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 600;
        }
        .register-cta-feature-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30px; height: 30px;
            border-radius: 50%;
            background: #ffffff;
            flex-shrink: 0;
        }
        /* Button */
        .register-cta-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 48px;
            background: linear-gradient(135deg, #ffd700, #ffaa00);
            color: #0d4a73 !important;
            font-family: 'Cairo', sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            border-radius: 50px;
            text-decoration: none !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 30px rgba(255,215,0,0.3);
            position: relative;
            overflow: hidden;
        }
        .register-cta-btn::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; right: 0; bottom: 0;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s ease;
        }
        .register-cta-btn:hover::before {
            left: 100%;
        }
        .register-cta-btn:hover {
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 14px 40px rgba(255,215,0,0.45);
            color: #0d4a73 !important;
            text-decoration: none !important;
        }
        /* Animations */
        .animate-bounce-in {
            animation: registerBounceIn 0.8s cubic-bezier(0.68, -0.55, 0.27, 1.55) both;
        }
        @keyframes registerBounceIn {
            0% { opacity: 0; transform: scale(0.3); }
            50% { opacity: 1; transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-fade-up {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.3s;
        }
        .animate-fade-up-delay {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.5s;
        }
        .animate-fade-up-delay2 {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.7s;
        }
        .animate-fade-up-delay3 {
            animation: registerFadeUp 0.8s ease both;
            animation-delay: 0.9s;
        }
        @keyframes registerFadeUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        /* Responsive */
        @media (max-width: 768px) {
            .register-cta-section { padding: 50px 0; }
            .register-cta-title { font-size: 1.8rem; }
            .register-cta-desc { font-size: 1rem; }
            .register-cta-features { gap: 12px; }
            .register-cta-feature { padding: 8px 14px; }
            .register-cta-feature span { font-size: 0.85rem; }
            .register-cta-btn { padding: 14px 36px; font-size: 1.05rem; }
            .register-cta-icon { width: 70px; height: 70px; }
            .register-cta-icon svg { width: 36px; height: 36px; }
            .register-cta-shape-1 { width: 180px; height: 180px; }
            .register-cta-shape-2 { width: 120px; height: 120px; }
        }
        @media (max-width: 480px) {
            .register-cta-title { font-size: 1.5rem; }
            .register-cta-features { flex-direction: column; align-items: center; }
        }
    </style>

    <!-- ============================ Register CTA Section End ================================== -->

		<!-- ============================ All Property ================================== -->
		<section class="bg-light">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center">
							<h2 class="headingTitle">	{{ trans('langsite.Properties_for_sale')}} </h2>

						</div>
					</div>
				</div>


				<div class="row list-layout">
			@foreach ($saleAqars as $saleAqar)

				<!-- Single Property Start -->

    <div class="col-lg-6 col-md-12">

<div class="property-listing property-1">

    <div class="listing-img-wrapper">
 <!-- <a target="_blank" href="single-property-2.html"> -->

		<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}">
                             @if($saleAqar->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$saleAqar->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                @else

		    @if($saleAqar->firstImage)<img
		src="{{ URL::to('/').'/images/'.$saleAqar->firstImage->img_url}}"
		class="img-fluid mx-auto" alt="" loading="lazy" />
			@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main" loading="lazy" >
		@endif
		@endif

		</a>



             <?php  if($saleAqar->vip ==1 && \Carbon\Carbon::now()->diffInYears($saleAqar->created_at) < 1 ){   ?>
                        <div class="views"  >
                            <div class="views-1">مميز</div>
                        </div>
                     <?php }  ?>


                         <?php if(\Carbon\Carbon::now()->diffInYears($saleAqar->created_at) >= 1){ ?>
        <div class="views " style="left: 13px;">
            <div class="viewsRed">غير متاح</div>
        </div>
        <?php } ?>


               <div class="views">

                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $saleAqar->views }}</span>

                        </div>
                    </div>
    </div>



    <div class="listing-content">



        <div class="listing-detail-wrapper-box">

            <div class="listing-detail-wrapper">

                <div class="listing-short-detail">

                    <h4 class="listing-name">
                        <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}">
                            {{  \Illuminate\Support\Str::limit($saleAqar->title, $limit = 33, $end = '...') }}
                        </a>
                    </h4>



                </div>



            </div>

        </div>
        <div class="list-price">

            <h6  class="">{{ $saleAqar->total_price }} جنيه مصري </h6>

        </div>


        <div class="price-features-wrapper" >

            <div class="list-fx-features feat2">

                <div class="listing-card-info-icon">

                    {{ $saleAqar->baths }} حمام
						<div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"

                            alt="" loading="lazy" /></div>
                </div>

                <div class="listing-card-info-icon">

                   {{ $saleAqar->rooms }} غرف
				    <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"

                            alt="" loading="lazy" /></div>

                </div>

                <div class="listing-card-info-icon">

                    {{ $saleAqar->total_area }}  م²
					<div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"

                            alt="" loading="lazy" /></div>

                </div>

            </div>

        </div>



        <div class="listing-footer-wrapper bg-light">

            <div class="listing-locate">

                <span class="listing-location"> @if ($saleAqar->governrateq)
					{{ $saleAqar->governrateq->governrate }}
				@endif @if ($saleAqar->districte)
					{{ $saleAqar->districte->district }}
				@endif
 <i class="ti-location-pin"></i></span>

            </div>

            <div class="footer-flex">

                <a target="_blank" target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}" class="prt-view">عرض</a>

                <!-- <a target="_blank" href="single-property-2.html" class="more-btn">View</a> -->

            </div>

        </div>



    </div>



</div>

</div>


			@endforeach



				</div>

				<!-- Pagination -->
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 text-center">
						<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_sale') }}" class="btn btn-theme-light rounded">اعرض المزيد</a>
						<!-- <a target="_blank" href="listings-list-with-sidebar.html" class="btrn btn-theme-light rounded">Browse More Properties</a> -->
					</div>
				</div>

			</div>
		</section>
		<!-- ============================ All Featured Property ================================== -->

		<!-- ============================ Latest Property للبيع Start ================================== -->
		<section class="" dir="ltr">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center mb-4">
							<h2 class="headingTitle"> 	{{ trans('langsite.Real_estate_for_rent')}} </h2>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="property-slide">
							@foreach ($rentAqars as $rentAqar)
							<div class="single-items">
								<div class="property-listing shadow-none property-2 border">

									<div class="listing-img-wrapper">

										<div class="list-img-slide">
											<div class="click">

												<div><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}">

												     @if($rentAqar->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$rentAqar->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                @else

												    @if($rentAqar->firstImage)<img
													src="{{ URL::to('/').'/images/'.$rentAqar->firstImage->img_url}}"
													class="img-fluid mx-auto" alt="" loading="lazy" />
														@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main"loading="lazy" >
													@endif
													@endif

													</a></div>



											</div>
										</div>


					   <?php  if($rentAqar->vip ==1  && \Carbon\Carbon::now()->diffInYears($rentAqar->created_at) < 1){   ?>
                          <div class="views">
                            <div class="views-1">مميز</div>
                        </div>

                         <?php }  ?>


                             <?php if(\Carbon\Carbon::now()->diffInYears($rentAqar->created_at) >= 1){ ?>
                                        <div class="views " style="left: 13px;">
                                            <div class="viewsRed">غير متاح</div>
                                        </div>
                                        <?php } ?>



										               <div class="views">

                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $rentAqar->views }}</span>

                        </div>
                    </div>
									</div>

									<div class="listing-detail-wrapper">
										<div class="listing-short-detail-wrap">
											<div class="listing-short-detail">
												<h4 class="listing-name verified center-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}"
														class="">{{ \Illuminate\Support\Str::limit($rentAqar->title, $limit = 29, $end = '...')  }}</a></h4>
												<!-- <h4 class="listing-name verified"><a target="_blank" href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
											</div>

										</div>

									</div>
									<div  class="listing-short-detail-flex">
										<h6 class="listing-card-info-price">{{ $rentAqar->monthly_rent }} جنيه مصري</h6>
									</div>
									<div class="price-features-wrapper" >
										<div class="list-fx-features" >





											<div class="listing-card-info-icon">
												{{ $rentAqar->baths }} حمام
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>
											<div class="listing-card-info-icon">
												{{ $rentAqar->rooms }} غرف
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>

											<div class="listing-card-info-icon">
												{{ $rentAqar->total_area }} م²
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>


										</div>
									</div>

									<div class="listing-detail-footer bg-light">
										<div class="footer-first">
											<div class="foot-location">
											@if ($rentAqar->governrateq)
												{{ $rentAqar->governrateq->governrate }}
											@endif
											@if ($rentAqar->districte)
												{{ $rentAqar->districte->district }}
											@endif


												<img src="{{ asset('assets/img/pin.svg') }}" width="18" alt=""  loading="lazy" />
											</div>
										</div>
										<div class="footer-flex">
											<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $rentAqar->slug) }}" class="prt-view">عرض</a>
											<!-- <a target="_blank" href="property-detail.html" class="prt-view">View</a> -->
										</div>
									</div>

								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>
	<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 text-center">
						<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_rent') }}" class="btn btn-theme-light rounded">اعرض المزيد</a>
						<!-- <a target="_blank" href="listings-list-with-sidebar.html" class="btrn btn-theme-light rounded">Browse More Properties</a> -->
					</div>
				</div>
			</div>
		</section>
		<!-- ============================ Latest Property للبيع End ================================== -->

		<!-- ============================ Price Table Start ================================== -->

		<!-- ============================ Step How To Use Start ================================== -->
		<section class="ggok">

			<div class="container">

				<!-- row Start -->
				<div class="row align-items-center videoAction">

					<div class="col-lg-7 col-md-9">

                        <x-i-video />
					</div>

					<div class="col-lg-5 col-md-3">
						<div class="story-wrap explore-content text-center">
                            <h2 class="headingTitle2"> 	Right choice  </h2>
							<h2 class="headingTitle2"> 	{{ trans('langsite.site_name')}}  </h2>
							<p class="">

                                  نضع العقارات التي تريدها بين يديك بدون وسيط ومن<br/>  المالك مباشرة
                                  <br/>
                                   اختار عقارك بنفسك بدون وسطاء
							</p>

						</div>
					</div>

				</div>
				<!-- /row -->

			</div>

		</section>

		<!-- sections-->
		<section class="bg-light">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center">
							<h2 class="headingTitle">{{ trans('langsite.services')}}</h2>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="property-slide">

                            					@foreach ($services as $serv )


                             <div class="single-items">
								<div class="location-property-wrap">
									<div class="location-property-thumb">
										<!-- <a target="_blank" href="listings-list-with-sidebar.html"><img src="https://via.placeholder.com/1200x800" class="img-fluid" alt=""></a> -->
										<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug) }}"><img src="{{ URL::to('/').'/admin/public/'.$serv->image}}" class="img-fluid" alt="" loading="lazy" ></a>
									</div>
									<div class="location-property-content">
										<div class="lp-content-flex">
										<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug) }}" class="lp-property-view">	<h4 class="lp-content-title">{{ $serv->Service}}</h4></a>
											<!--<span>العنوان</span>-->
										</div>
										<div class="lp-content-right">
											<!-- <a target="_blank" href="listings-list-with-sidebar.html" class="lp-property-view"><i class="ti-angle-right"></i></a> -->

										</div>
									</div>
								</div>
                             </div>

												@endforeach

						</div>
					</div>


				</div>



			</div>
		</section>
		<!-- ============================ Latest Property للبيع Start ================================== -->
		<section class="" dir="ltr">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-7 col-md-10 text-center">
						<div class="sec-heading center mb-4">
							<h2 class="headingTitle"> 	{{ trans('langsite.The_most_researched')}}  </h2>

						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="property-slide">



							@foreach ($mostRecent as $most )
								<div class="single-items">
								<div class="property-listing shadow-none property-2 border">

									<div class="listing-img-wrapper">

										<div class="list-img-slide">
											<div class="click">

												<div><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}">

												    		     @if($most->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$most->mainImage->img_url}}"  		class="img-fluid mx-auto"   alt="main" loading="lazy" >

                                @else


												     @if($most->firstImage)
												     <img
													src="{{ URL::to('/').'/images/'.$most->firstImage->img_url}}"
													class="img-fluid mx-auto" alt="" loading="lazy" />
														@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main" loading="lazy" >

													@endif		@endif

													</a></div>


											</div>
										</div>
											               <div class="views">

                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $most->views }}</span>

                        </div>
                    </div>
									</div>

									<div class="listing-detail-wrapper">
										<div class="listing-short-detail-wrap">
											<div class="listing-short-detail">
												<h4 class="listing-name verified center-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}"
														class="">{{  \Illuminate\Support\Str::limit($most->title, $limit = 29, $end = '...') }}</a></h4>
												<!-- <h4 class="listing-name verified"><a target="_blank" href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
											</div>

										</div>

									</div>
									<div class="listing-short-detail-flex">
										<h6 class="listing-card-info-price">


										                @if ($most->offerTypes->id == 1 || $most->offerTypes->id == 2 )
                                                                {{ $most->total_price }}
                                                                @endif
                                                                @if ($most->offerTypes->id == 3 || $most->offerTypes->id == 4 )
                                                                {{ $most->monthly_rent }}
                                                                @endif  جنيه مصري



                                                            </h6>
									</div>
									<div class="price-features-wrapper" >
										<div class="list-fx-features" >





											<div class="listing-card-info-icon">
												{{ $most->baths }} حمام
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>
											<div class="listing-card-info-icon">
												{{ $most->rooms }} غرف
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>

											<div class="listing-card-info-icon">
												{{ $most->total_area }}  م²
												<div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
														alt="" loading="lazy" /></div>
											</div>


										</div>
									</div>

									<div class="listing-detail-footer bg-light">
										<div class="footer-first">
											<div class="foot-location">
											@if ($most->governrateq)
												{{ $most->governrateq->governrate }}
											@endif
											@if ($most->districte)
												{{ $most->districte->district }}
											@endif


												<img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" loading="lazy" />
											</div>
										</div>
										<div class="footer-flex">
											<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $most->slug) }}" class="prt-view">عرض</a>
											<!-- <a target="_blank" href="property-detail.html" class="prt-view">View</a> -->
										</div>
									</div>

								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>

			</div>
		</section>
		<!-- ============================ Latest Property للبيع End ================================== -->


		<!-- ============================ Call To Action ================================== -->
								<x-call-to-action />

		<!-- ============================ Call To Action End ================================== -->

						</x-layout>
