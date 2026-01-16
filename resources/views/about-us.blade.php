<x-layout>
 @section('title')
    من نحن
@endsection

    <div class="image-cover hero-banner single-items" style="background:url('{{asset('assets/img/about.jpeg')}}') no-repeat;" loading="lazy" >
        <div class="container">
            <div class="row">
                
                

                <div class="col-lg-12 col-md-12">
                 
                    <div class="hero__p">
                        <h1>من نحن</h1>
                        
                        <p>
                            اول موقع متميز في مصر من البائع للمشتري مباشر بدون
								عمولات وخدمات متكاملة مع افضل الشركات
                   		</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>




    <section id="img-desc" style="background-color:#f5faff;" >
        <div class="container">
            <div class="row">
                 
                <div class="col-lg-12">
                    <h5>من نحن؟</h5>
                    <br>
                    <p>

                                                                                                               شركة رايت تشويز لأدارة الاصول العقارية <strong> Right Choice </strong>
<br/><br/>
شركه متخصصة لادارة الاصول العقارية والتسويق والتجارة عبر الإنترنت ، نعمل بكل جهودنا لضمان توفير التواصل بكل سهولة  بين العملاء المالكين بالعقارات والراغبين في البيع والشراء والايجار حيث نمتلك أفضل موقع إلكتروني في مصر ، من خلاله يمكن لجميع العملاء معاينة افضل  العقارات المعروضة للبيع او للإيجار والتعامل المباشر مع المالك  بدون وسيط وبدون عمولة .                                                            
           
          <br>
          وتنص سياستنا في الموقع على عدم نشر أي إعلان من قبل وسطاء عقاريين أو شركات تسويق عقاري ، كونه قائم على الية محددة وهي  توفير التعامل المباشر الراغبين بالبيع او الايجار من الملاك للعقارات ( شقق سكنية - فلل– عمارات –اراضي – تجاري – اداري .... الخ من العروض ) وبأسعار متفاوته ومساحات مختلفة ومحافظات ومناطق متعددة والمهتمين بهذه العقارات وكذلك يوفر موقعنا لجميع المستخدمين  أفضل الشركات المتخصصة في بيع الأثاث المنزلي والأثاث المكتبي وشركات بيع الأجهزة الكهربائية والالكترونيه وخدمات لشركات نقل الأثاث    
           
                </p></div>
            </div>
        </div>
    </section>








            <!-- ======= Featured Services Section ======= -->
            <section id="featured-services" class="featured-services ">
                <div class="container" data-aos="fade-up">
          
                    @foreach ($about as $bt)

					{!! $bt->description !!}

				@endforeach
          
                </div>
              </section><!-- End Featured Services Section -->
          

</x-layout>