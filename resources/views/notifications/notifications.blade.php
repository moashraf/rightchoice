<x-layout>
    
    @section('title')
        التنبيهات
    @endsection
<?PHP  
$user = auth()->user();

if(isset($user) ){ }else{ dd("يجب تسجيل الدخول ");  }   

 ?>

<section id="profile-info" class="bg-light">

                <div class="container">

                    <div class="main-body">

                 

                 

            

                          <div class="row gutters-sm">

                            <div class="col-md-8 mt-3">

                              @if(!empty($notifications))
                              @foreach($notifications as $not)
                               <div id="notifi-{{ $not->id }}"
                               class="rounded alert notifi_div  {{ !$not->status ? 'alert-success':'card' }}" >
                                   <div class="accordion" id="accordionExample">
    
                                            <div class="accordion-item ">
    
                                                <button class="accordion-button ChangeStatusNotfi" type="button" data-bs-toggle="collapse" data-id="{{$not->id}}"
                                                    data-bs-target="#collapseOne-{{$not->id}}" aria-expanded="true"
                                                    aria-controls="collapseOne" onclick="updateStatus({{ $not->id }})">
    
                                                    <h5> {{ $not->title }}</h5>
    
                                                </button>
    
                                                <div id="collapseOne-{{$not->id}}" class="accordion-collapse collapse notificationBody"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
    
                                              {!! $not->message !!}
    
                                                </div>
    
                                            </div>
    
    
    
    
    
                                    </div>
                               </div>
                               @endforeach
                               
                               {{ $notifications->links() }}
                               @endif

                            </div>
                                
                            <?php if(Auth()->user()->TYPE != 4) { ?>
                            <div class="col-md-4">

                              <div class="card mt-3">

                                <div class="card-body">

                                  <div class="d-flex flex-column align-items-center text-center">

                                    @if(!empty(Auth::user()->profile_image))
                                         <img src="{{ URL::to('/').'/images/'.Auth::user()->profile_image}}" alt="Admin"
    
                                            class="rounded-circle admin">
                                       @else
                                       <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin"

                                        class="rounded-circle admin" >
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
                            <?php }else{ ?>
                            <div class="col-md-4">
                                                    <x-vertical-adv />

                            </div>
                            <?php }?>



                          </div>

                          

                        </div>

                    </div>

               

                

            </section>


		<!-- ============================ Call To Action ================================== -->
								<x-call-to-action />
		<!-- ============================ Call To Action End ================================== -->

</x-layout>