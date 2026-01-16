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
						<div class="col-lg-6 col-md-6">
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

						<div class="col-lg-6 col-md-12">
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
										
							   <?php  if($aqarVip->vip ==1 ){   ?>               

  <div class="views"  >
                            <div class="views-1">مميز</div>
                        </div>
                                                         <?php }  ?>   
                        
                        
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

        
												
             <?php  if($saleAqar->vip ==1 ){   ?>               

  <div class="views"  >
                            <div class="views-1">مميز</div>
                        </div>
                                                         <?php }  ?>   
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

                    <h4 class="listing-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $saleAqar->slug) }}">{{  \Illuminate\Support\Str::limit($saleAqar->title, $limit = 33, $end = '...') }}</a></h4>

                

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
										
										
										    <?php  if($rentAqar->vip ==1 ){   ?>               
                          <div class="views">
                            <div class="views-1">مميز</div>
                        </div>
                        
                                                         <?php }  ?>  
                                                         
                                                         
                                                         
                                                         
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
		<section>

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
						