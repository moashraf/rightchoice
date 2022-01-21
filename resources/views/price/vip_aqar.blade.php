<x-layout>
 @section('title')
    ميز اعلانك
@endsection

    <div class="image-cover hero-banner single-items" style="background:url(https://rightchoice-co.com/admin/public/uploads/slider/-448-.NoPath.png) no-repeat;">

        <div class="container">
  
           <div class="row">
  
              
  
              
  
  
  
              <div class="col-lg-12 col-md-12">
  
               
  
                 <div class="hero__p">
  
                    <h1>
  
                        
  
                        
  
ميز اعلانك  
                        
  
                        
  
                        
  
                    </h1>
  
                     
  
                    <p>
                        
                        
                        
  
                     لظهور اعلانك بالصفحات الاولى بالموقع و الحصول على مشاهدات اكثر قم بتمييز اعلانك
                       
                       
                       
                       </p>
  
                 </div>
  
              </div>
  
           </div>
  
           
  
        </div>
  
     </div>
    <section class="pricingVip py-5">

    <div class="container">



        <div class="row">

            <div class="col-lg-12">
<p style="text-align: right;"><strong><u>  الإعلانات المميزة على الموقع</u></strong></p>

<p  dir="rtl">
    
  <ol dir="rtl" style="text-align:right; padding:0;">
 	<li><strong>الاعلان يفضل على الموقع بشكل مميز حسب صلاحية الاعلان هو صلاحية الباقة المشترك فيها </strong></li>
 	<li><strong>اتاحة عدد مشاهدات اكثر حسب نوع الباقة</strong></li>
</ol>
<h5 style="text-align: center; line-height:1.8">وخدمة الاعلانات المميزة هي خدمة على موقع شركة رايت تشويز لادارة الاصول العقارية ، تضمن لإعلانك نسبة مشاهدات عالية ، وبتزود فرصك في البيع او الايجار، كون إعلانك يكون ضمن اول صفحات الاعلانات فى القسم المنشور فيه الاعلان وييظهر اعلانك على الصفحات الاولى
     </h5>

                   
                    </div> </div> </div>

</section>


    <section class="pricingVip py-5">
        <div class="container">
          <div class="row">
            @foreach ($vips as $vip)
            <div class="col-lg-4">
                <div class="card mb-5 mb-lg-0 {{ $vip->bgColor }}">
                  <div class="card-body">
                    <h5 class="card-title text-muted text-uppercase text-center">{{ $vip->name }}</h5>
                    <h6  style=" direction:rtl;"class="card-price text-center">{{ $vip->price }}<span class="period">/ج.م</span></h6>
                    <hr>
                   <p class="text-center">عدد المشاهدات يصل الى {{ $vip->views }}</p>
                    <a href="{{ url('ar/tamyeez_vip/' . $vip->id ) }}/<?php  echo request()->segment(count(request()->segments())); ?>" class="btn btn-block text-uppercase text-primary" style="background: #fff;">ميز اعلانك</a>
                  </div>
                </div>
              </div>
            @endforeach
           
          </div>
        </div>
      </section>
    <x-call-to-action />

</x-layout>