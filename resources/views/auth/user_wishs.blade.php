<x-layout>
 @section('title')
            قائمه المفضلات
    @endsection
    <?PHP  
    $user = auth()->user();
    
    if(isset($user) ){ }else{ dd("يجب تسجيل الدخول ");  }   
    
     ?>
    
    <section id="profile-info" class="bg-light">
    
                    <div class="container">
    
                        <div class="main-body">
    
                     
    
                     
    
                
    
                              <div class="row gutters-sm">
    
                                <div class="col-md-8">
    
    
                                @if(!empty($allAqars))
                               @foreach ($allAqars as $aqar)
                               
                               <?php  //dd($aqar->aqarInfo) ?>
                                        @if($aqar->aqarInfo !== null)
                                    <div class="col-lg-12">
                                        <div class="card mt-3">
                                            <div class="row no-gutters">
    
                                              <div class="col-sm-5 col-card-imgs">
                                                <div class="click">

                                                        <div><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->aqarInfo->slug) }}">
                                                            
                                                                                                               @if($aqar->mainImage)
                                 <img src="{{ URL::to('/').'/images/'.$aqar->mainImage->img_url}}"  class="img-fluid main-img" alt="main">
                            
                                @else
                                
                                
                                
                                                            @if($aqar->aqarInfo->firstImage)
                                                            <img
                                                                    src="{{ URL::to('/') . '/images/' . $aqar->aqarInfo->firstImage->img_url }}"
                                                                    class="img-fluid mx-auto" alt="" />
                                                                    	@else
                                        <img src="https://rightchoice-co.com/images/FBO.png" class="img-fluid main-img"    alt="main">
                                                                    @endif
                                                                    @endif
                                                                    </a></div>
                                                                    


                                            
                                                </div>
                                                        <div class="views">
                    
                        <div class="views-2 views-2-user_ads">
                            <i class="fa fa-eye"></i>
                            <span>{{ $aqar->aqarInfo->views }}</span>

                        </div>
                    </div>
                                            </div>
                                          
                                                <div class="col-sm-7 order-lg-first col-card-details">
                                                    <div class="card-body">
                                                        <div class="listing-detail-wrapper">
                                                            <div class="listing-short-detail-wrap">
                                                                <div class="listing-short-detail">
                                                                   
                                                                    <h4 class="listing-name verified"><a href="{{ URL::to(Config::get('app.locale').'/aqars/' . $aqar->aqarInfo->slug) }}">
                                                                        {{ \Illuminate\Support\Str::limit($aqar->aqarInfo->title, 50) }}

                                                                    </a></h4>
                                                                    <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
    
    
    
                                                                </div>
                                                                
    
                                                            </div>
                                                            <div class="listing-short-detail-flex">
                                                                <h6  class="listing-card-info-price2">
                                                                    @if ($aqar->aqarInfo->offerTypes->id == 1 || $aqar->aqarInfo->offerTypes->id == 2 )
                                                                    {{ $aqar->aqarInfo->total_price }}
                                                                    @endif
                                                                    @if ($aqar->aqarInfo->offerTypes->id == 3 || $aqar->aqarInfo->offerTypes->id == 4 )
                                                                    {{ $aqar->aqarInfo->monthly_rent }}
                                                                    @endif  جنيه مصري   
                                                                </h6>
                                                            </div>
                                                         
                                                        </div>
    
                                                        <div class="">
                                                            <div class="list-fx-features2">
                                                                <div class="listing-card-info-icon">
                                                                {{ $aqar->aqarInfo->baths }} حمام
                                                                    <div class="inc-fleat-icon">
                                                                    
                                                                    <img
                                                                            src="{{ asset('images/icons/bath.png') }}" width="13"
                                                                            alt="" />
                                                                    </div>
                                                                </div>
                                                                <div class="listing-card-info-icon">
                                                                {{ $aqar->aqarInfo->rooms }} غرف
                                                                    <div class="inc-fleat-icon"><img
                                                                            src="{{ asset('images/icons/room.png') }}" width="13" alt="" />
                                                                    </div>
                                                                </div>
                                                              
                                                                <div class="listing-card-info-icon">
                                                                {{ $aqar->aqarInfo->total_area }} م²
                                                                    <div class="inc-fleat-icon"><img
                                                                            src="{{ asset('images/icons/area.png') }}" width="13" alt="" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                          
                                                        <div class="btnAdds listing-detail-footer" style="justify-content:space-between;">
                                                          
                                                            <div class="foot-location mb-2">
                                                              <div class="footer-first">
                                                                   @if ($aqar->aqarInfo->governrateq)
                                                                            {{ $aqar->aqarInfo->governrateq->governrate }}
                                                                        @endif,
                                                                         @if ($aqar->aqarInfo->districte)
                                                                        {{ $aqar->aqarInfo->districte->district }}
                                                                        @endif
                                                                       
                                                                        <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" /> 
                                                              </div>
                                                             
                                                            </div>
                                                            
                                                          <div>
                                                                    <a href="#" type="button" class="btn btn-danger  ml-2 removeFromCart" data-id="{{$aqar['id']}}"> الغاء <svg
                                                                xmlns="http://www.w3.org/2000/svg" width="16"
                                                                height="16" fill="currentColor" class="bi bi-heart"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z" />
                                                            </svg></a>
                                                            <a    target="_blank" href="{{ URL::to(Config::get('app.locale').'/aqars/' .$aqar->aqarInfo->slug) }}" id="btn1" class="btn">عرض</a>
                                                           
                                                           
                                                          </div>

                                                             
                                                             
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
                                                             <img style=" object-fit: contain;"
                                                                  src="https://rightchoice-co.com/assets/img/rclogo.png"
                                                                    class="img-fluid mx-auto" alt="" />
                                                                      </div>
                                                                    


                                            
                                                </div>

                         
                                            </div>
                                            <div class="col-sm-7 order-lg-first col-card-details">
                                                <div class="card-body">
                                                    <div class="listing-detail-wrapper">
                                                        <div class="listing-short-detail-wrap">
                                                            <div class="listing-short-detail">
                                                                <h4  class="listing-name verified"><a href="#" target="_blank">
       </a></h4>
                                                                <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->



                                                            </div>
                                                            
                                                                    <div>
                                                                     
                                                                       
                                                                </div>
                                                        </div>
                                                        <div class="listing-short-detail-flex">
                                                            <h6 class="listing-card-info-price2">
                                                          </h6>
                                                        </div>
                                                   
                                                    </div>

                                                    <div class="list-rap">
                                                        <div class="list-fx-features2" >
                                                            <div class="listing-card-info-icon">
 <h3></br></br>
     تم مسح العقار 
 </h3>
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
                                
                                {{ $allAqars->links() }}
                                @endif
    
                               
    
                                </div>
    
    
                                <div class="col-md-4 mb-3">
    
                                  <div class="card mt-3">
    
                                    <div class="card-body">
    
                                      <div class="d-flex flex-column align-items-center text-center">
    
                                        @if(!empty(Auth::user()->profile_image))
                                         <img src="{{ URL::to('/').'/images/'.Auth::user()->profile_image}}" alt="Admin"
    
                                            class="rounded-circle admin">
                                       @else
                                       <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"

                                        class="rounded-circle admin">
                                       @endif
    
                                        <div class="mt-3">
    
                                          <h4>  {{ $user->name }} </h4>
    
                              

<a href="{{ URL::to(Config::get('app.locale').'/user_point_count_history')}}"> <p><strong>عدد النقاط</strong>
<span> {{ $points }}</span>
  <i class=" fa fa-check-circle "></i>	
  </a>
  

                                          <hr class="hr-add">
    
    
 <a  data-toggle="tooltip" title="التنبيهات  !"  href="{{ URL::to(Config::get('app.locale').'/notification')}}" style="<?php if($countNotifi > 0){ ?> color:gold; <?php }?>  "  ><i class="fa fa-bell"></i></a>

<a data-toggle="tooltip" title=" اعلاناتي !" href="{{ URL::to(Config::get('app.locale').'/user_ads') }}" style="margin:0 10px" type="button"><i class="fa fa-building"></i></a>
  <a   data-toggle="tooltip" title="المفضله !"  href="{{ URL::to(Config::get('app.locale').'/user_wishs')}}" type="button"><i class="fa fa-heart"></i></a>


                                            
                                        


                                        </div>
    
                                      </div>
    
                                    </div>
    
                                  </div>
    
                           
    
<div class="sticky mt-3">
                                    <x-purchase-now />

</div>
                                  
    
                                </div>
    
    
    
    
                              </div>
    
                              
    
                            </div>
    
                        </div>
    
                   
    
                    
    
                </section>
    
    




		<!-- ============================ Call To Action ================================== -->
								<x-call-to-action />
		<!-- ============================ Call To Action End ================================== -->
  
    
    </x-layout>