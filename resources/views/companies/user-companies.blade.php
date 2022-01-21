<x-layout>
 @section('title')
    شركاتي
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
    
    
    
                               @foreach ($allCompanies as $comp)
                              <div class="col-lg-12">
                                        <div class="card mt-3">
                                            <div class="row no-gutters">
    
                                            
                                                <div class="col-sm-5 col-card-imgs">
                                                    <div class="click">
                                                      

                                                        <div><a href="{{ URL::to(Config::get('app.locale').'/companies/' . $comp->slug) }}"><img
                                                                    src="{{ URL::to('/') . '/images/' . $comp->photo }}"
                                                                    class="img-fluid mx-auto" alt="" /></a></div>
    
    
    
                                                    </div>
                                                </div>
                                                <div class="col-sm-7 order-lg-first col-card-details">
                                                    <div class="card-body">
                                                        <div class="listing-detail-wrapper">
                                                            <div class="listing-short-detail-wrap">
                                                                <div class="listing-short-detail">
                                                                   
                                                                    <h4  class="listing-name verified"><a href="{{ URL::to(Config::get('app.locale').'/update_companies/' .$comp->slug) }}" class="">

                                                                        {{ $comp->Name }}
                                                                    </a></h4>
                                                                    <!-- <h4 class="listing-name verified"><a href="single-property-1.html" class="prt-link-detail">Banyon Tree Realty</a></h4> -->
    
    
    
                                                                </div>
                                                                @if ($comp->status == 0)
                                                                 <div>
                                                                     
                                                                      <a  href="#" class="btn btn-outline-warning">جاري المراجعه</a>
                                                                      
                                                                </div>
                                                                @endif
    
                                                            </div>
                                                            <div class="listing-short-detail-flex">
                                                                <p  class="listing-card-info-price2">
                                                                  {{ Str::limit($comp->details, 60, '...') }}
                                                                </p>
                                                            </div>
                                                            <div class="foot-location" >
                                                                       
                                                                        @if ($comp->governrate_id)
                                                                        {{ $comp->governrateq->governrate }},
                                                                        @endif
                                                                         @if ($comp->district_id)
                                                                        {{ $comp->district_ashraf->district }}
                                                                        @endif
                                                                        @if ($comp->area_id && $comp->subArea)
                                                                        ,{{ $comp->subArea->area }}
                                                                        @endif
                                                                        <img src="{{ asset('assets/img/pin.svg') }}" width="18" alt="" />
                                                            </div>
                                                        </div>
    
                                                     
                                                        <div class="btnAdds">
                                                           <!-- <a href="#" type="button" class="btn btn-outline-danger  ml-2 removeFromCompany" data-id="{{$comp['id']}}"> حذف</a>   -->
                                                            <a href="#" type="button" class="btn btn-outline-danger  ml-2 " data-id="{{$comp['id']}}"> حذف</a>
                                                            <a  href="{{ URL::to(Config::get('app.locale').'/update_companies/' .$comp->slug) }}"  class="btn btn-outline-dark ml-2">تعديل</a>
                                                           
                                                        </div>
    
    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
    
                                {{ $allCompanies->links() }}
    
    
                               
    
                                </div>
    
    
                                <div class="col-md-4 mb-3">
    
                                  <div class="card">
    
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
    
                                          <p><strong>عدد النقاط</strong> {{ $points }}</p>
    
                                          <hr class="hr-add">
    
                                          
								               <a href="{{ URL::to(Config::get('app.locale').'/user_ads')}}" type="button"

                                            class="btn btn-info">اعلاناتي</a>

                                            @if(count(Auth::user()->companiess) > 0)

                                         <a href="{{ URL::to(Config::get('app.locale').'/user_companies')}}" type="button"

                                            class="btn btn-info">شركاتي</a>

                                            @endif






                                        <a href="{{ URL::to(Config::get('app.locale').'/pricing-seller') }}" class="btn btn-info">الباقات</a>




									  <a href="{{ URL::to(Config::get('app.locale').'/user_wishs') }}" type="button" class="btn btn-light mt-3 ml-2 mr-2"> قائمه المفضلات <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">



										<path d="M8 2.748l-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>



									  </svg></a>


                                        </div>
    
                                      </div>
    
                                    </div>
    
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