<!DOCTYPE html>



<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">



<head>



    <meta charset="utf-8">



    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="facebook-domain-verification" content="k6v3agddx5gb0bvfva7xsnguqsrleg" />


                <!-- Facebook Pixel Code -->
            <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '2084977348310462');
            fbq('track', 'PageView');
            </script>
            <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=2084977348310462&ev=PageView&noscript=1"
            /></noscript>
            <!-- End Facebook Pixel Code -->




<!-- Hotjar Tracking Code for https://rightchoice-co.com/ -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:2759523,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>



    <title>RightChoice  @if (!\Request::is('/')) | @endif @yield('title')</title>



    <link rel="shortcut icon" href="{{ asset('assets/img/icon.png') }}" type="image/x-icon">



    <!-- Custom CSS -->
 <?php  if (  App::getLocale()== 'en' )
    { 
        
        ?>
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
         
         <?php 
    }
else{  
    
    
    ?>
    
    <link href="{{asset('assets/css/rtl.css')}}" rel="stylesheet">

    <?php
}  
?> 





    <link rel="stylesheet" href="{{asset('assets/css/plugins/owl.carousel.css')}}">



    <link rel="stylesheet" href="{{asset('assets/css/plugins/popup.css')}}">



    <link rel="stylesheet" href="{{asset('assets/css/plugins/owl.theme.css')}}">







    <!-- Custom Color Option -->



    <link href="{{asset('assets/css/colors.css')}}" rel="stylesheet">



    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.rtl.min.css" integrity="sha384-mUkCBeyHPdg0tqB6JDd+65Gpw5h/l8DKcCTV2D2UpaMMFd7Jo8A+mDAosaWgFBPl" crossorigin="anonymous"> -->



    <link rel="stylesheet" href="{{asset('assets/bootstrap.min.css')}}">



    <link rel="stylesheet" href="{{asset('assets/css/plugins/light-box.css')}}">








</head>







<body class="blue-skin">







    <div id="loader-wrapper">



        <div id="loader">



            <div class="lds-circle">

                <div></div>

            </div>



        </div>



        <div class="loader-section section-left"></div>



        <div class="loader-section section-right"></div>



    </div>



    <!-- ============================================================== -->



    <!-- Preloader - style you can find in spinners.css -->



    <!-- ============================================================== -->



    <!-- <div id="preloader"><div class="preloader"><span></span><span></span></div></div> -->







    <!-- ============================================================== -->



    <!-- Main wrapper - style you can find in pages.scss -->



    <!-- ============================================================== -->



    <div id="main-wrapper">







        <!-- ============================================================== -->



        <!-- Top header  -->



        <!-- ============================================================== -->



        <!-- Start Navigation -->



        <div class="header header-light head-shadow">



            <div class="container-fluid">



                <nav style="padding-left: 10px;padding-right: 10px;" id="navigation"

                    class="navigation navigation-landscape container">



                    <div class="nav-header">



                        <a href="{{ URL::to('/'.Config::get('app.locale'))}}">
                            
                             <?php  if (  App::getLocale()== 'en' )
    { 
        
        ?>
                        <img src="{{ asset('assets/img/rclogo.png') }}" class="logo" alt="" />
         
         <?php 
    }
else{  
    
    
    ?>
    
                        <img src="{{ asset('assets/img/rclogo.png') }}" class="logo" alt="" />

    <?php
}  
?> 




                        </a>



                        <div class="nav-toggle"></div>



                    </div>



                    <div class="nav-menus-wrapper" style="transition-property: none;">



                        <ul class="nav-menu">







                            <li class="{{ Request::is('/') ? 'active' : '' }}"><a

                                    href="{{ asset('/').Config::get('app.locale') }}">{{ trans('langsite.Home')}}</a>







                            </li>















                            <li

                                class="{{ Request::is('aqars-cash') || Request::is('aqars-installment') || Request::is('aqar-finnance') ? 'active' : '' }}">

                                <a href="JavaScript:Void(0);"><span class="submenu-indicator"></span>

                                    {{ trans('langsite.NavCash')}}</a>



                                <ul class="nav-dropdown nav-submenu">
                                    
                                       	<li><a href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_sale') }}">  
                                       	الكل 
                                       	</a></li>

                                    @if(!empty($offersTypeForCashAndInstallment))
                                    @foreach($offersTypeForCashAndInstallment as $cash)
                                    
                                            <li><a href="{{ URL::to(Config::get('app.locale') .'/aqars-' . $cash->slug) }}">
                                                @if(App::isLocale('en'))
                                                 {{ $cash->type_offer_en }}
                                                @else
                                                 {{ $cash->type_offer }}
                                                @endif
                                               
                                                </a></li>
                                    @endforeach
                                    @endif
                                  	<li><a href="{{ URL::to(Config::get('app.locale').'/aqar-finnance') }}"> {{ trans('langsite.finnance')}}</a></li>


                                   <!-- <li><a href="{{ asset('aqars-cash') }}">{{ trans('langsite.Nav-Aqars-Cash')}}</a>

                                    </li>



                                    <li><a href="{{ asset('aqars-installment') }}">{{ trans('langsite.Nav-Aqars-Installment')}}</a>

                                    </li>



                                    <li><a

                                            href="{{ asset('aqars-finnance') }}">{{ trans('langsite.Nav-Aqars-Bank')}}</a>

                                    </li>


                                  	<li><a href="{{ asset('') }}"> عقارات تصلح تمويل عقاري </a></li>
                                  	
                                  	-->
                                        
                                      


                                </ul>



                            </li>



                            <li

                                class="{{ Request::is('aqars-new-rent-law') || Request::is('aqars-furnished-rent') ? 'active' : '' }}">

                                <a href=""><span class="submenu-indicator"></span>{{ trans('langsite.NavRent')}}</a>



                                <ul class="nav-dropdown nav-submenu">
                                    
                                        	<li><a href="{{ URL::to(Config::get('app.locale').'/all_aqar_for_rent') }}">  
                                       	الكل 
                                       	</a></li>
                             @if(!empty($offersTypeForRents))
                                  @foreach($offersTypeForRents as $rent)
                                                            
                                                        <li><a href="{{ URL::to(Config::get('app.locale').'/aqars-' . $rent->slug) }}"> 
                                                        
                                                         @if(App::isLocale('en'))
                                                 {{ $rent->type_offer_en }}
                                                @else
                                                 {{ $rent->type_offer }}
                                                @endif
                                                        
                                                        </a></li>
                                          @endforeach
                             @endif


                          <!--          <li><a href="{{ asset('aqars-rent-new') }}">{{ trans('langsite.Nav-Rent-New')}}</a>

                                    </li>



                                    <li><a

                                            href="{{ asset('aqars-rent-finish') }}">{{ trans('langsite.Nav-Rent-Finish')}}</a>

                                    </li>-->







                                </ul>



                            </li>






                         @if(count($serviceInHeader) > 0)
                            <li

                                class="{{ Request::is('companies-furnitures') || Request::is('companies-finish') || Request::is('companies-home-sale') || Request::is('companies-electronics') ? 'active' : '' }}">

                                <a href=""><span class="submenu-indicator"></span>{{ trans('langsite.services')}}</a>



                                <ul class="nav-dropdown nav-submenu">


                                   @if(!empty($serviceInHeader))
                                    @foreach($serviceInHeader as $serv)
                                    <li>
                                        @if(App::isLocale('en'))
                                        <a href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug_en) }}">{{ $serv->Service_en}}</a>
                                        @else
                                        <a href="{{ URL::to(Config::get('app.locale').'/ourcompanies-' . $serv->slug) }}">{{ $serv->Service}}</a>
                                        @endif
                                        
                                    </li>
                                    @endforeach
                                  @endif


                                </ul>



                            </li>

                        @endif

















                        </ul>







                        <ul class="nav-menu nav-menu-social align-to-right">

<!--
                     <?php  if (  App::getLocale()== 'en' )
                        { 
                            
                            ?>
                        <li>



                                <a href="{{ url($newUrl) }}">عربي</a>

                   



                            </li>
                             
                             <?php 
                        }
                    else{  
                        
                        
                        ?>
                        
                         <li>


                           
                                <a  class="text-success"  href="{{ url($newUrl) }}" >English</a>
                          





                            </li>
                    
                        <?php
                    }  
                    ?> 


-->                                 
                                @if(Auth::check())  
                            @if(Auth()->user()->TYPE == 4)
                 
                    
                      
                            
                            
                            @else
                                    <li class="{{ Request::is('newlisting') ? 'active' : '' }}">



                                <a href="{{ url(Config::get('app.locale').'/aqars/create') }}" class="text-success">
                                  <!--    
                                    <img

                                        src="{{ asset('assets/img/submit.svg') }}"
                                        style="    margin-right: -0.9rem!important;
    margin-left: 10px;" width="20" alt=""

                                        class="mr-2" />
                                         -->
                                        {{ trans('langsite.add_aqar-free')}}</a>



                                <!-- <a href="submit-property.html" class="text-success"><img src="assets/img/submit.svg" width="20" alt="" class="mr-2" />Add Property</a> -->



                            </li>

                            
                                  @endif  
                                  
                                  
                                  @else
                                   <li class="{{ Request::is('newlisting') ? 'active' : '' }}">



                                <a href="{{ url(Config::get('app.locale').'/aqars/create') }}" class="text-success">
                                  <!--    
                                    <img

                                        src="{{ asset('assets/img/submit.svg') }}"
                                        style="    margin-right: -0.9rem!important;
    margin-left: 10px;" width="20" alt=""

                                        class="mr-2" />
                                         -->
                                        {{ trans('langsite.add_aqar-free')}}</a>



                                <!-- <a href="submit-property.html" class="text-success"><img src="assets/img/submit.svg" width="20" alt="" class="mr-2" />Add Property</a> -->



                            </li>
                                  
                                  
                       
                            @endif
                            
                            
                            @if(Auth::check())


                            @else
                            
                                <li class="{{ Request::is(Config::get('app.locale').'/register') ? 'active' : '' }}"><a href="{{ asset(Config::get('app.locale').'/register') }}"

                                    class="text-success">{{ trans('langsite.register')}}</a></li>

                            @endif





                            @if(Auth::check())



                            <li class="add-listing"><a href=""><span class=""></span>



                                  @if(Auth::check())
                                    @if(Auth::user()->TYPE == 3)
                                    {{\Illuminate\Support\Str::limit(Auth::user()->Employee_Name, 10, $ned='') }}

                                    
                                    @else
                                    {{\Illuminate\Support\Str::limit(Auth::user()->name, 10, $ned='') }}

                                    
                                    @endif
                                  @else

                                  {{ trans('langsite.login')}}

                                  @endif





                                </a>



                                <ul style="top:60px;" class="nav-dropdown nav-submenu">

                                      @if(Auth()->user()->TYPE != 4)

                                    <li><a href="{{ asset(Config::get('app.locale').'/login') }}">





                                             @if(Auth::check())

                                           

                                    {{ trans('langsite.profile')}}
                                             @else
                                            {{ trans('langsite.login')}}

                                            @endif





                                        </a></li>


                                        @else 
                                        
                                          <li><a

                                            href="{{ URL::to(Config::get('app.locale').'/update_companies/'.Auth()->user()->id) }}">Update Company</a>

                                    </li>
                                    
                                        @endif
                                     @if(Auth::check())


                            
                                      @if(Auth()->user()->TYPE != 4)

                                    <li>
                                        <a  href="{{ URL::to(Config::get('app.locale').'/user_wishs') }}">{{ trans('langsite.fav')}}</a>

                                    </li>
                                    
                                    
                                  <li>
                                        <a  href="{{ URL::to(Config::get('app.locale').'/user_ads') }}">اعلاناتي</a>

                                    </li>
                                    
                                      <li>
                                        <a  href="{{ URL::to(Config::get('app.locale').'/user_point_count_history') }}">النقاط</a>

                                    </li>
                                    
                                    
                                        @endif

                                           <li><a href="{{ URL::to(Config::get('app.locale').'/notification')}}">
                                               
                                               
                                                {{ trans('langsite.Notifications')}}
                                               @if($countNotifi > 0)<span class="badge badgedanger badge-pill noti-icon-badge ml-1">{{$countNotifi}}</span>@endif</a>

                                    </li>

<!--
                                    <li><a href="{{ url(Config::get('app.locale').'/add_company') }}">



                                            {{ trans('langsite.add_company')}}



                                        </a></li>
                                        -->







                                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();

  document.getElementById('logout-form').submit();">



                                            {{ trans('langsite.logout')}}

                                        </a>





                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"

                                            class="d-none">

                                            @csrf

                                        </form>



                                    </li>





                                    @endif









                                </ul>





                            </li>

                            @else

                            <li class="add-listing"><a href="{{ asset(Config::get('app.locale').'/login') }}"><span class=""></span> {{ trans('langsite.login')}}</li>

                            <ul class="nav-dropdown nav-submenu">

                                    <li class="{{ Request::is(Config::get('app.locale').'/login') ? 'active' : '' }}"><a href="{{ asset(Config::get('app.locale').'/login') }}"

                                    class="text-success">{{ trans('langsite.login')}}</a></li>

                             </ul>

                            @endif

                        </ul>



                    </div>



                </nav>



            </div>



        </div>



        <!-- End Navigation -->



        <!-- ============================================================== -->



        <!-- Top header  -->



        <!-- ============================================================== -->







        {{ $slot }}







        <!-- ============================ Footer Start ================================== -->



        <!-- Footer -->

        <!-- Footer 

<footer style="background-image: url('{{asset('assets/img/footer\ BG.jpg')}}');" class=" text-center text-white">

    

    <div class="container p-4">

  

      

      <div class="row">

        <div class="col-lg-2" style="text-align: center; justify-content: center; margin: auto;">

          <br>

          <br>

          <br>

          <img src="{{ asset('assets/img/footer-logo.png') }}" alt="">

        </div>

        <div class="col-lg-4"></div>

        <div class="col-lg-6" style="text-align: right;">

          <br>

          <br>

          <div style="text-align: center;">

            <ul class="footer-links">

            <li class="fw-bolder">

              <a href="{{ asset('/') }}" class="text-white">الرئيسيه</a>

            </li>

            <li class="text-white fw-bolder">

             <a href="{{ asset('about-us') }}" class="text-white"> من نحن</a>

            </li>

            <li class="text-white fw-bolder">

              <a href="{{ asset('contact-us') }}" class="text-white">تواصل معنا </a>

            </li>

            <li class="text-white fw-bolder">

              <a href="{{ asset('blogs') }}" class="text-white">المقالات</a>

            </li> 

            <li class="text-white fw-bolder">

              <a href="{{ asset('terms-conditions') }}" class="text-white">الشروط و الاحكام</a>

            </li>

            

          </ul>

          <ul >

            

            <li style=" display: block; margin: auto;" class="text-white fw-bolder">

              <a href="{{ asset('add_company') }}" class="text-white">سجل شركتك مجانا</a>

            </li>

          </ul>





    

	  <ul class="footer-bottom-social">



        <li><a href="#"><i style="background-color: #3b5998;" class="shadow ti-facebook"></i></a></li>



        <li><a href="#"><i style="background-color: #55acee;" class="shadow ti-twitter"></i></a></li>



        <li><a href="#"><i style=" background: #f09433; 



  background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); 



  background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 



  background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 



  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );



   " class="instagram shadow ti-instagram"></i></a></li>



        <li><a href="#"><i style="background-color: #0082ca;" class="shadow ti-linkedin"></i></a></li>



        <li><a href="#"><i style="background-color: #dd4b39;" class="shadow fab fa-youtube"></i></a></li>



    </ul>



    



     



          

          </div>

        </div>

      </div>

  

     </div>



  </footer>

   Footer -->





        <footer class="mainfooter" style=" <?php  if (  App::getLocale()== 'ar' )
    {  echo'background-image: url(https://rightchoice-co.com/public/assets/img/footerwith.jpg);background-size: cover;';}
else{  echo'background-image: url(https://rightchoice-co.com/public/assets/img/footerwithen.jpg);background-size: cover;'; }  
?> "
role="contentinfo">

            <div class="container">





                <div class="row">

                    <div class="col-lg-8" style="position:static;">



                        <ul class="footer-links text-center">

                            <li class="fw-bolder">

                                <a href="{{ asset('/') }}" class="text-white">{{ trans('langsite.Home')}} </a>

                            </li>

                            <li class="text-white fw-bolder">

                                <a href="{{ url(Config::get('app.locale').'/about-us') }}" class="text-white">{{ trans('langsite.About')}} </a>

                            </li>

                            <li class="text-white fw-bolder">

                                <a href="{{ url(Config::get('app.locale').'/contact-us') }}" class="text-white">{{ trans('langsite.Get_In')}}

                                </a>

                            </li>

                            <li class="text-white fw-bolder">

                                <a href="{{ URL::to(Config::get('app.locale').'/blogs')}}" class="text-white">{{ trans('langsite.blogs')}} </a>

                            </li>

                            <li class="text-white fw-bolder">

                                <a href="{{ url(Config::get('app.locale').'/terms-conditions') }}"

                                    class="text-white">{{ trans('langsite.terms')}}</a>

                            </li>
                            @if(!Auth()->user())
                         
                            <li class="text-white fw-bolder d-block" >

                                <a href="{{ url(Config::get('app.locale').'/add_company') }}"

                                    class="text-white">{{ trans('langsite.add_company')}}</a>

                            </li>
                            @endif
        

                        </ul>



                        <br>



                        <ul class="footer-bottom-social text-center">



                            <li><a target="_blank" href="https://www.facebook.com/right.choice.co"><i style="background-color: #3b5998;" class="shadow ti-facebook"></i></a>

                            </li>



                      <!--      <li><a href="#"><i style="background-color: #55acee;" class="shadow ti-twitter"></i></a> -->

                            </li>



                            <li><a target="_blank" href="https://www.instagram.com/right.choice.co"><i style=" background: #f09433; 

  

    background: -moz-linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%); 

  

    background: -webkit-linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 

  

    background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); 

  

    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f09433', endColorstr='#bc1888',GradientType=1 );

  

     " class="instagram shadow ti-instagram"></i></a></li>



                        <!--       <li><a href="#"><i style="background-color: #0082ca;" class="shadow ti-linkedin"></i></a>

                            </li>
-->


                         <li><a target="_blank" href="https://www.youtube.com/channel/UCuatA5ibPU-K_GHHqjK_6UA"><i style="background-color: #dd4b39;" class="shadow fab fa-youtube"></i></a>

                            </li>



                        </ul>

        <br>

                    </div>

                    <div style="position:static;" class="col-lg-4 footer-logo-col">





                        <br>



                        <div class="footer-logo">
                             <?php  if (  App::getLocale()== 'en' )
    { 
        
        ?>
                         <img src="{{ asset('assets/img/footer-logo.png') }}" />
         
         <?php 
    }
else{  
    
    
    ?>
    
                         <img src="{{ asset('assets/img/footer-logo.png') }}" />

    <?php
}  
?> 
                          

                        </div>

                    </div>

                </div>

            </div>
            
            
            <!-- 
            
        <div  class="text-center p-1 footer-bottom text-white">



        All rights reserved @
        <a class="text-white" href="#">RightChoice-co</a>


        <a class="text-white small" target="_blank" href="https://corddigital.com/">by Cord Digital</a>
      </div>
      
       -->
       
       
         <div  class="text-center p-1 footer-bottom text-white">
جميع  الحقوق كامله محفوظة لشركة   رايت تشويز
        
      </div>
      


      
        </footer>

        <!-- Copyright -->






        <!-- ============================ Footer End ================================== -->























        <a id="back2Top" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>



        <!-- The Modal -->









    </div>



    <!-- The Modal 2 -->





    <div id="overlay-2">



        <div id="popup-2">



            <div id="close-2">X</div>




            <ul class="footer-bottom-social">



                <li><a target="_blank"  href="https://www.facebook.com/sharer/sharer.php?u=
                <?php $currentURL = url()->current();  echo $currentURL ;?>">
                    
                    <i style="background-color: #3b5998;" class="shadow ti-facebook"></i></a></li>

 


            </ul>



            <div class="mt-3">



                <textarea id="url" class="myselect2"></textarea>


                <a class="btn btn-danger clipboard" href="#">{{ trans('langsite.copy_link')}}</a>



            </div>



        </div>



    </div>

 


    </div>

    @if (session()->has('success'))

    <div id="successMessage" class="whats-app shadow">



        <p class="my-float">{{ session('success') }}</p>

        <div class="circle" style="padding:10px; display: inline; background-color:white;"><i

                style="margin-top:2px; color:#294c5f; " class="fas fa-check"></i></div>





    </div>



    @endif

    <script>

        setTimeout(function () {

            $('#successMessage').fadeOut('slow');

        }, 5000);

    </script>

    <style>

        .whats-app {

            position: fixed;

            width: auto;

            height: auto;

            padding: 15px;

            bottom: 60px;

            border-radius: 20px;

            background-color: #294c5f;

            color: #FFF;

            border-radius: 50px;

            text-align: center;

            right: 20px;

            z-index: 100;

        }



        .my-float {

            padding-right: 5px;

            display: inline !important;

            margin-top: 10px;

        }

    </style>

    <!-- ============================================================== -->



    <!-- End Wrapper -->



    <!-- ============================================================== -->







    <!-- ============================================================== -->



    <!-- All Jquery -->



    <!-- ============================================================== -->







    <script src="{{asset('assets/js/jquery.min.js')}}"></script>



    <script src="{{asset('assets/js/jquery.popup.js')}}"></script>



    <script src="{{asset('assets/js/popper.min.js')}}"></script>



    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>



    <script src="{{asset('assets/js/rangeslider.js')}}"></script>



    <script src="{{asset('assets/js/select2.min.js')}}"></script>



    <script src="{{asset('assets/js/jquery.magnific-popup.min.js')}}"></script>



    <script src="{{asset('assets/js/slick.js')}}"></script>



    <script src="{{asset('assets/js/slider-bg.js')}}"></script>



    <script src="{{asset('assets/js/lightbox.js')}}"></script>



    <script src="{{asset('assets/js/imagesloaded.js')}}"></script>



    <script src="{{asset('assets/js/owl.carousel.js')}}"></script>




 <?php  if (  App::getLocale()== 'en' )
    { 
        
        ?>

    <script src="{{asset('assets/js/rtl.js')}}"></script>
         <?php 
    }
else{  
    
    
    ?>
    
    <script src="{{asset('assets/js/rtl.js')}}"></script>

    <?php
}  
?> 



 <?php  if (  App::getLocale()== 'en' )
    { 
        
        ?>

    <script src="{{asset('assets/js/english-listing.js')}}"></script>
         <?php 
    }
else{  
    
    
    ?>
    
    <script src="{{asset('assets/js/arabic-listing.js')}}"></script>

    <?php
}  
?> 





    <!-- ============================================================== -->



    <!-- This page plugins -->



    <!-- ============================================================== -->



    <!-- /GetButton.io widget -->



    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js?ver=1.1"></script>

    <link rel="stylesheet" type="text/css"

        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css?ver=1.1">



    

    @if(Session::has('success'))

    <script>

        toastr.options.positionClass = 'toast-top-right';

        toastr.info("{{ Session::get('success') }}");

    </script>



    @elseif(Session::has('error'))



    <script>

        toastr.options.positionClass = 'toast-top-right';

        toastr.error("{{ Session::get('error') }}");

    </script>

    @endif

    <script>

        $(document).ready(function () {



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

           

            $('body').on("click","a.addToCart",function () {

                var token = "{{ csrf_token() }}"

                var aqars_id = $(this).data('id');

                var $input = $('.js-result').val();



                var url = "{{route('add-wish_list')}}";

               @auth

                $.ajax({



                    type: "POST",

                    url: url,

                    data: {

                        _token: token,

                        aqars_id: aqars_id

                    },

                    success: function (data) {

                        // location.reload();

                        if(data.status == 202){

                               toastr.info(data.massage, '', {

                                timeOut: 5000

                            }); 

                        }else{

                           

                            toastr.success(data.massage, '', {

                            timeOut: 5000

                           }); 

                        }



                    },

                    error: function (data) {

                        //console.log('Error:', data);

                     

                    }

                });

                @else

                toastr.error("you must login!", '');

                @endauth

            });

        });

    </script>



    <script>

  $(document).ready(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

     

      $('body').on("click","a.removeFromCart",function () {

          var token = "{{ csrf_token() }}"

          var item_id = $(this).data('id');

          var $input = $('.js-result').val();



          var url = "{{route('remove-wish_list')}}";

         @auth

          $.ajax({



              type: "POST",

              url: url,

              data: {

                  _token: token,

                  item_id: item_id

              },

              

              success: function (data) {



                  if(data.status == 202){



                         toastr.info(data.massage, '', {

                          timeOut: 10000

                          

                      }); 



                  }else{



                      toastr.success(data.massage, '', {

                      timeOut: 10000



                     }); 



                     location.reload();



                  }



              },

              error: function (data) {

                  //console.log('Error:', data);

               

              }

          });

          @else

          toastr.error("you must login!", '');

          @endauth

      });

  });

</script>



   <script>
/*
  $(document).ready(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

     

      $('body').on("click","a.removeFromCompany",function () {

          var token = "{{ csrf_token() }}"

          var item_id = $(this).data('id');

          var $input = $('.js-result').val();



          var url = "{{route('remove-user-company')}}";

         @auth

          $.ajax({



              type: "POST",

              url: url,

              data: {

                  _token: token,

                  item_id: item_id

              },

              

              success: function (data) {



                  if(data.status == 202){



                         toastr.info(data.massage, '', {

                          timeOut: 50000,

                          extendedTimeOut : 50000

                          

                      }); 



                  }else{





                      toastr.success(data.massage, '', {

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     }); 



                     location.reload();



                  }



              },

              error: function (data) {

                  //console.log('Error:', data);

               

              }

          });

          @else

          toastr.error("you must login!", '');

          @endauth

      });

  });*/

</script>



   <script>

        $(document).ready(function () {



            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

           

            $('body').on("click","button.addToContact",function () {

                var token = "{{ csrf_token() }}"

                var aqars_id = $(this).data('id');

                var $input = $('.js-result').val();



                var url = "{{route('add-contactaqar')}}";

               @auth

                $.ajax({



                    type: "POST",

                    url: url,

                    data: {

                        _token: token,

                        aqars_id: aqars_id

                    },

                    success: function (data) {

                        // location.reload();
                       if(data.status == 202){

                               toastr.info(data.massage, '', {

                                timeOut: 5000

                            }); 

                        }
                        document.getElementById('contMop').innerHTML='<a class="btn btn-success" href="tel:' + data.massage + '">' + data.massage + '</a>';



                    },

                    error: function (data) {

                        toastr.success(data.massage, '', {

                            timeOut: 5000

                           });

                     

                    }

                });

                @else

                toastr.error("you must login!", '');

                @endauth

            });

        });

    </script>

    

<script>

   $(document).ready(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });
  $('body').on("click","a.removeFromAds",function () {
   var token = "{{ csrf_token() }}"

          var item_id = $(this).data('id');

          var $input = $('.js-result').val();



          var url = "{{route('remove-user-Ads')}}";     var confirmation =  confirm('تاكيد حذف العقار ؟');
        if(confirmation){
            
         @auth

          $.ajax({



              type: "POST",

              url: url,

              data: {

                  _token: token,

                  item_id: item_id

              },

              

              success: function (data) {



                  if(data.status == 202){



                         toastr.info(data.massage, '', {

                          timeOut: 50000,

                          extendedTimeOut : 50000

                          

                      }); 



                  }else{





                      toastr.success(data.massage, '', {

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     }); 



                     location.reload();



                  }



              },

              error: function (data) {

                  //console.log('Error:', data);

               

              }

          });

          @else

          toastr.error("you must login!", '');

          @endauth
        }

      }); 
     


  });

</script>

<script>

   $(document).ready(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

     

      $('body').on("click","a.AddComplain",function () {

          var token = "{{ csrf_token() }}"

          var item_id = $(this).data('id');

          var $input = $('.js-result').val();
          
          var message = $("textarea[name='message']").val();


          var url = "{{route('add-user-complain')}}";

         @auth

          $.ajax({



              type: "POST",

              url: url,

              data: {

                  _token: token,

                  item_id: item_id,
                  
                  message:message,

              },

              

              success: function (data) {



                  if(data.status == 202){
                              setTimeout(function(){
                               location.reload();
                             }, 1000);

   
                         toastr.info(data.massage, '', {

                          timeOut: 50000,

                          extendedTimeOut : 50000

                          

                      }); 


                  }else if(data.status == 404){





                      toastr.error(data.massage, '', {

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     }); 



                    //  location.reload();



                  } else{




                     setTimeout(function(){
                               location.reload();
                             }, 1000);
                      toastr.success(data.massage, '', {

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     }); 



                    //  location.reload();



                  }



              },

              error: function (data) {
                if(data.status == 400){
                 toastr.error('يجب إدخال رساله البلاغ المقدم من سيادتكم', '', {  

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     });
                }else{
                   toastr.error('يوجد خطأ ما ، حاول مرة اخرى', '', {  

                      timeOut: 50000,

                        extendedTimeOut : 50000



                     }); 
                }

               

              }

          });

          @else

          toastr.error("you must login!", '');

          @endauth

      });

  });

</script>

<script>

   $(document).ready(function () {



      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

     

      $('body').on("click","a.SendUserSession",function () {

          var token = "{{ csrf_token() }}"

          var $input = $('.js-result').val();
          
          var user_phone = $("input[name='user_session_phone']").val();
          
          var user_name = $("input[name='user_session_name']").val();
          
          var user_email = $("input[name='user_session_email']").val();
          
          var user_address = $("input[name='user_session_address']").val();
          
          var session_description = $("textarea[name='session_description']").val();


          var url = "{{route('add-user-session')}}";


          $.ajax({



              type: "POST",

              url: url,

              data: {

                  _token: token,

                  user_phone: user_phone,
                  user_name: user_name,
                  user_email: user_email,
                  user_address: user_address,
                  session_description: session_description,

              },

              

              success: function (data) {


                  if(data.status == 404){





                      toastr.error(data.massage, '', {

                      timeOut: 5000,

                        extendedTimeOut : 5000



                     }); 



                     



                  } else{


                        setTimeout(function(){
                               location.reload();
                             }, 1000);


                      toastr.success(data.massage, '', {

                      timeOut: 1000,

                        extendedTimeOut : 1000



                     }); 



                    // location.reload();



                  }



              },

              error: function (data) {
                if(data.status == 400){
                toastr.error('يجب إدخال البيانات المطلوبه امامكم', '', {  

                      timeOut: 3000,

                        extendedTimeOut : 3000



                     });
                }else{
                   toastr.error('يوجد خطأ ما ، حاول مرة اخرى', '', {  

                      timeOut: 1000,

                        extendedTimeOut : 1000



                     }); 
                }

               

              }

          });


      });

  });

</script>

<script>



function updateStatus(id) {
  
    //   $('.accordion-button').on("click",function () {
 
      
          var token = "{{ csrf_token() }}";
          var item_id =id;
          var $input = $('.js-result').val();
          var url = "{{route('change-user-notfi')}}";
          console.log(token , item_id);
         @auth
          $.ajax({
              type: "POST",
              url: url,
              data: {
                  _token: token,
                  item_id: item_id,
              },

              success: function (data) {
        
                  $('#notifi-'+ id).removeClass('alert-success');
                     $('#notifi-'+ id).addClass('card');
              },
              error: function (data) {
              }

          });

          @else

          toastr.error("you must login!", '');

          @endauth

    //   });
}
   $(document).ready(function () {




      $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });

 


  });

</script>

</body>



<x-cookies/>



</html>