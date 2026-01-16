<x-layout>


 @section('title')
{{$getService->title}} 
@endsection

   <div class="image-cover hero-banner" style="background:url('{{ URL::to('/').'/admin/public/'.$getService->image}}') no-repeat;">

      <div class="container">

         <div class="row">

            

            



            <div class="col-lg-12 col-md-12">

             

               <div class="hero__p">

                  <h1>

                      

                      

               @if(!empty($getService->Service)) 
               @if(App::isLocale('ar'))
               {{$getService->Service}}
               @else
               {{$getService->Service_en}}
               @endif
               @endif

                      

                      

                      

                  </h1>

                   

                  <p>@if(!empty($getService->description)) 
                  
                   @if(App::isLocale('ar'))
               {{$getService->description}}
               @else
               {{$getService->description_en}}
               @endif
                  @endif</p>

               </div>

            </div>

         </div>

         

      </div>

   </div>
  

           



<section class="articels" dir="rtl">





    



   <div class="container">



<!--	<h2> {{ trans('langsite.all_companies')}} </h2> -->

   
          
               
                     
                     
                     <br>
                     <br>
                     
    <div class="row">
 <form action="{{  URL::to('/'.Config::get('app.locale').'/ourcompanies-'.$getService->slug.'/filterby') }}" id="sortform" method="get">
                                        @csrf
 
    <div class="col-lg-12 row searchRow">
        
           <div class="col-lg-2">
                  </div>
                  <div class="col-lg-2">
                   
                </div>
                      
         <div class="col-lg-4">
                   <input name="keywords" type="text" class="form-control" placeholder="كلمه البحث" tabindex="0">
                   </div>
                <div class="col-lg-2">
                                            <input type="submit" class="btn our-btn" value="{{ trans('langsite.search')}}" />

                </div>
                </div>
                         </form>
<br><br><br><br>
        <div class="col-lg-12 row">
            @foreach ($companies as $company)

        <div class="col-lg-12 mt-12">



<a target="_blank" href="{{ URL::to(Config::get('app.locale').'/companies/' . $company->slug) }}">



<div class="box">


    @if($company->photo)
      <img src="<?php if (isset($company)){echo URL::to('/').'/images/'.$company->photo  ;} ?>" class="img-fluid" alt="">
	@else
                    <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid"
                    alt="main">
                    @endif


      <h3>  @if(App::isLocale('ar'))
               {{ $company->Name }}
               @else
               {{ $company->name_en }}
               @endif  </h3>



      <p>   @if(App::isLocale('ar'))
               {{ $company->description }}
               @else
               {{ $company->description_en }}
               @endif </p>



    </div>



</a>



 </div> 
        @endforeach
        
      </div>

       



</div>





          {{ $companies->links() }}  



</div>



</section>


<section>
    
    
  <div class="container">
      
      	<div class="row justify-content-center">
			<div class="col-lg-7 col-md-10 text-center">
				<div class="sec-heading center mb-4">
					<h2 class="headingTitle">العقارات المميزه</h2>
					
				</div>
			</div>
		</div>
		
        	 <div class="row">
			<div class="col-lg-12 col-md-12">
				<div class="property-slide">
					
					  @foreach ($allAqars as $aqarSim)
                      <div class="single-items">
                        <div class="property-listing shadow-none property-2 border bg-light">

                            <div class="listing-img-wrapper">

                                <div class="list-img-slide">
                                    <div class="click">

                                     <!--   @foreach ($aqarSim->images as $images_url)
                                        <div><a href="{{ URL::to('aqars/' . $aqarSim->slug) }}"><img
                                            src="{{ URL::to('/').'/images/'.$images_url->img_url}}"
                                            class="img-fluid mx-auto" alt="" /></a></div>	
                                        @endforeach-->
                                                    
                                         <div><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}" target="_blank">
                                             
                                                    @if($aqarSim->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqarSim->mainImage->img_url}}"   class="img-fluid mx-auto"  alt="main">
                            
                                @else
                                
							
							
							
							
                                             @if($aqarSim->firstImage)<img
                                            src="{{ URL::to('/').'/images/'.$aqarSim->firstImage->img_url}}"
                                            class="img-fluid mx-auto" alt="" />
                                            	@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"
                                            alt="main">
                                            @endif
                                            @endif
                                            
                                            </a></div>
                                        
                                        
                                    </div>
                                </div>
                                	               <div class="views">
                    
                        <div class="views-2">
                            <i class="fa fa-eye"></i>
                            <span>{{ $aqarSim->views }}</span>

                        </div>
                    </div>
                            </div>

                            <div class="listing-detail-wrapper">
                                <div class="listing-short-detail-wrap">
                                    <div class="listing-short-detail">
                                        <h4 class="listing-name verified center-name"><a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}"
                                                class="" target="_blank">{{ \Illuminate\Support\Str::limit($aqarSim->title, $limit = 33, $end = '...') }}</a></h4>
                                        <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
                                    </div>
                                    
                                </div>
                                
                            </div>
                            <div  class="listing-short-detail-flex">
                                @if ($aqarSim->offer_type == 1 || $aqarSim->offer_type == 2)
                                
                                <h6 class="listing-card-info-price">{{ $aqarSim->total_price }} {{ trans('langsite.egyptian_pound') }}</h6>

                                @endif
                                @if ($aqarSim->offer_type == 3 || $aqarSim->offer_type == 4)
                                <h6 class="listing-card-info-price">{{ $aqarSim->monthly_rent }} {{ trans('langsite.egyptian_pound') }}</h6>

                                @endif
                                
                            </div>
                            <div class="price-features-wrapper" >
                                <div class="list-fx-features" >
                                
                                    
                                    
                                
                                    
                                    <div class="listing-card-info-icon"> 
                                    {{ $aqarSim->baths }} حمام
                                        <div class="inc-fleat-icon"><img src="{{ asset('images/icons/bath.png') }}" width="12"
                                                alt="" /></div>
                                    </div>
                                    <div class="listing-card-info-icon">
                                        {{ $aqarSim->rooms }} غرف
                                        <div class="inc-fleat-icon"><img src="{{ asset('images/icons/room.png') }}" width="12"
                                                alt="" /></div>
                                    </div>
                                    
                                    <div class="listing-card-info-icon">
                                        {{ $aqarSim->total_area }}  م² 
                                        <div class="inc-fleat-icon"><img src="{{ asset('images/icons/area.png') }}" width="12"
                                                alt="" /></div>
                                    </div>
                                    
                                    
                                </div>
                            </div>

                            <div class="listing-detail-footer">
                                <div class="footer-first">
                                    <div class="foot-location">
                                        
                                    @if ($aqarSim->governrateq)
                                     
                                        {{ $aqarSim->governrateq->governrate }}	
                                    @endif
                                    
                                    @if ($aqarSim->districte)
                                    
                                        {{ $aqarSim->districte->district }}
                                    @endif
                                  
                                    
                                        <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
                                    </div>
                                </div>
                                <div class="footer-flex">
                                    <a target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqarSim->slug) }}" class="prt-view" target="_blank">عرض</a>
                                    <!-- <a href="property-detail.html" class="prt-view">View</a> -->
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




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#sorting').on('change', function() {
                var idCountry = this.value;
                $("#location2").html('');
                $.ajax({
                    url: "{{ url('api/fetch-states') }}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        $('#location2').html('<option value="" selected disabled  >الحي</option>');
                        $.each(result.states, function(key, value) {
                            $("#location2").append('<option value="' + value
                                .id + '">' + value.district + '</option>');
                        });
                    }
                });
            });

        });

    </script>

</x-layout>