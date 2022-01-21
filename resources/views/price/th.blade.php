<x-layout>
 @section('title')
    شكرا لك
@endsection
 
    <section id="thank-page">
        <div class="text-center container">
            <h1 class="display-3">!شكرا لك</h1>
            <p class="lead">{{ session('message') }}</p>
            <hr>
            
            
            <h5 style=" line-height: 41px;">   
       
كود الخدمة  788    الرقم المرجعي  {{ $FawryPayment->referenceNumber }}      المبلغ المطلوب سداده  {{ $FawryPayment->paymentAmount}}  جنيه مصري   الهاتف   {{  auth()->user()->MOP }}   <br>ويمكنك استخدام كود الخدمة والرقم المرجعي ورقم موبايلك عند الدفع في اي منفذ من منافذ فوري الموجودة في انحاء الجمهورية وعند الدفع سيتم اضافة رصيد النقاط الى حسابك بكل سهولة بامكانك التواصل مباشرة مع ملاك الوحدات
</h5>
           
             <br>
            <p>
              لديك مشكله ؟
              <a href="{{ url(Config::get('app.locale').'/contact-us') }}">
                  
                  
                  تواصل معنا</a>
            </p>
            <p class="lead">
                @if(session('id'))
              <a class="btn btn-light btn-sm" style="padding:10px" href="{{ url(Config::get('app.locale').'/pricing-vip/'.session('id')) }}" role="button">ميز اعلانك</a>
                @endif
            
            </p>
          </div>
    </section>


    <x-call-to-action />

</x-layout>