<x-layout>

 @section('title')
    اختر احدى الباقات
@endsection




	<div class="image-cover hero-banner single-items" style="background:url('https://rightchoice-co.com//public/assets/img/sliders/pricing.jpg') no-repeat;">

		<div class="container">

			<div class="row">







				<div class="col-lg-12 col-md-12">



					<div class="hero__p">

						<h1>  {{ trans('langsite.Packages')}}</h1>

		                 	<p>

							اول موقع متميز في مصر من البائع للمشتري مباشر بدون

							عموالات وخدمات متكاملة مع افضل الشركات

							رايت تشويز  اقرب اليك في الاختيار
                            </p>
							 	</div>

				</div>

			</div>



		</div>

	</div>



        <section id="pricing" class="bg-light">

			<div class="container">

<h5 ><strong><u>فوائد الاشتراك في الباقات على موقع شركة (</u></strong><strong><u>Right Choice</u></strong><strong><u> )</u></strong></h5>
<p ><strong>1 /</strong> <strong>توفير المال بالتعامل المباشر مع الملاك الاصليين للعقارات بدون وسطاء</strong> <strong>وبدون عمولات .</strong></p>
<p ><strong>2 / </strong><strong>اتاحة </strong><strong>افضل الفرص والعروض من العقارات المتاحة للبيع او للايجار وبأسهل الطرق ( شقق- فلل– عمارات –اراضي – تجاري – اداري- مصانع .... الخ من العروض وبأسعار متفاوته ومساحات مختلفة ومحافظات ومناطق متعددة </strong></p>
<p ><strong>3 /</strong> <strong>توفير الوقت والمجهود في البحث عن العقار المناسب وسهولة التعامل والاختيار من خلال الموقع  . </strong></p>


				<div class="row pricingVip mt-5">
					@foreach ($allPricing as $single)
					<!-- Single Package -->
            <div class="col-lg-4 mb-2">
                <div class="card mb-lg-0 {{ $single->bk_color }}" style=" margin-bottom: 14px !important; ">
                  <div class="card-body">
                    <h5  style="  font- size: 1.9rem;" class="card-title text-uppercase text-center {{ $single->title_color }}">{!! $single->type  !!}</h5>
                    <h6   class="card-price text-center">{{ $single->price }}  ج.م </h6>
                    <hr>
                   <p  style=" font-weight: bold;" class="text-center ">{{ $single->desc1 }}</p>



 <button  style="font- size:1.4rem; width: 100%;  margin-bottom: 10px;" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal{{ $single->id }}">
 تفاصيل الباقه
 </button>

                    <a  style=" font- size: 1.4rem;"  href="{{ URL::to(Config::get('app.locale').'/pricing-seller/' . $single->id) }}" class="btn btn-block  bg-white  {{ $single->title_color }} text-uppercase">اشترك بالباقه</a>
                  </div>
                </div>
              </div>

					@endforeach
                </div>

                </div>

		</section>





<section id="pricing" class="bg-light">

    <div class="container">



        <div class="row">

            <div class="col-lg-12">
<h5 ><strong><u>كيفية الاشتراك في الباقات والاستفادة من النقاط عند اضافتها الى حساب المستخدم بعد الاشتراك في الباقات في التعامل مع ملاكالوحدات مباشرة  : </u></strong></h5>
<p ><strong><u>اولا :</u></strong><strong> جميع المبالغ المدفوعة الى موقع (</strong><strong>Right Choice</strong><strong>)</strong> <strong>يتم تحويلها الى عدد نقاط تضاف الى حساب العميل المستخدم لاستخدامها في التعامل مع ملاك الوحدات مباشرة بدون تدخل من ادرة الموقع ودون اي وسطاء .</strong><strong> </strong></p>
<p ><strong><u>ثانيا </u></strong><strong>: </strong><strong>يمكن للمستخدم بعد نفاذ الباقة المجانية ورغبته في معاينة عقارات  اكثر وجب عليه الاشتراك في احد الباقات الموجودة في الموقع ودفع قيمتها المحددة لكل باقة حسب اختياره من خلال وسائل الدفع الالكتروني على الموقع وتحول قيمة المبالغ النقدية المدفوعة الى عدد نقاط معين        ( حسب نوع الباقة المشترك فيها ) وتضاف النقاط في الباقة الى رصيد حساب المستخدم الخاص به المسجل على الموقع ويمكن الاستفادة من النقاط  بفتح بيانات وحدات عقارية معروضة للبيع او للايجار والاستفادة من نقاطه في التعامل المباشر مع ملاك الوحدات مباشرة دون تدخل من ادارة الموقع ودون أي عمولات عند اتمام الاتفاق مع المالك للوحدة وحسب ماتم توضيحه اعلاه بالبند الاول .</strong></p>
<p ><strong><u>ثالثا </u></strong><strong>: </strong><strong>الحالات التي يتم التعويض فيها للعميل المستخدم عن النقاط التي تم خصمها من رصيد نقاطه في حسابه بنقاط اخرى للاستفادة منها في فتح بيانات اخرى وهي  :</strong><strong> </strong></p>
<p ><strong>أ</strong><strong> / </strong>اشتراك المستخدم في قسم العقارات وشراءه احد الباقات ودفع الرسوم من خلال وسائل الدفع الالكتروني وظهر بعد فتح بيانات الاعلان للعقار المعلن عنه في الموقع وخصم نقاط من حسابه ان <strong>( المالك الموجود على الموقع وسيط عقاري او سمسار )</strong> وجب على المستخدم ان يقوم فورا بأعلام الموقع من خلال ارسال رسالة من قسم بلاغ عن مشكلة بالاعلان  تحت العقار نفسه الذي اخترته , وبهذه الحالة يتم تعويض المستخدم بعد التاكد من الشكوى وخلال مدة اقصاها (48 ساعة) على الاكثر بضعف النقاط التي تم خصمها من رصيده في الحساب للاستفاده من النقاط في معاينة وحدات أخرى ,  ويتم حذف الاعلان الخاطئ للوسيط او السمسار من الموقع أن وجد .</p>
<p ><strong>ب /</strong> اشتراك المستخدم في قسم العقارات وشراءه احد الباقات ودفع الرسوم من خلال وسائل الدفع الالكتروني وظهر بعد فتح بيانات الاعلان للعقار المعلن عنه في الموقع وخصم نقاط من حسابه  ان العقار <strong>( تم بيعه او ايجاره أوانه لم يعد متاح لاي سبب ) </strong>وجب على المستخدم ان يقوم باعلام الموقع من خلال رساله (الشكاوي) او شكوى تحت العقار نفسه بميعاد اقصاه خمسة ايام من تاريخ فتح البيانات واستخدام النقاط, وبهذه الحالة يتم تعويض المستخدم بأسترجاع النقاط التي تم خصمها من رصيده في الحساب بعد التاكد من الشكوى وخلال مدة اقصاها ( 48 ساعة ) على الاكثر للاستفاده من النقاط في معاينة وحدات أخرى , مما يسمح للمستخدم فتح وحدات أخرى مناسبة ويتم حذف الاعلان الخاطئ أن وجد</p>
<p ><strong><u>رابعا </u>: موقع (Right Choice ) وإدارة شركة رايت تشويز لإدارة الأصول العقارية غير مسؤولين عن اي ورق أو مستندات خاصة بالعقارات المعروضة ولا تتدخل ادرة الموقع في الوساطة العقارية او الكشف عن اي مستندات خاصة بأي وحدة عقارية عند عرضها أو عند إتمام البيع والشراء والايجار حيث ان موقعنا  قائم على اساس التعامل المباشر بين بائع ومشتري ومؤجر ومستاجر دون اي تدخل من ادارة الموقع والشركة حيث ان مسئولية المستندات والعقود هي مسئولية البائع والمشتري والمؤجر والمستأجر فقط دون ادنى مسئولية على  ادرة موقع (Right Choice ) وإدارة الشركة المالة للموقع  </strong></p>
            </div>

        </div>



    </div>

</section>
<style>
    .btn:hover{
        color:#212529;
    }
</style>





					<!-- SingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingle Package -->

	@foreach ($allPricing as $single)

	<div class="container">

  <!-- The Modal -->
  <div class="modal" id="myModal{{ $single->id }}">
    <div class="modal-dialog" style="
    text-align: right;
    direction: rtl;
    max-width: 1200px;
     //max-width: 70%;"   >
      <div class="modal-content" style="   background: #e6f2ff;">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">    </h4>
  <button style="
    background-color: red;
    padding: 6px;
    color: white;" type="button" class="close" data-dismiss="modal"> اغلق &times;</button>        </div>

        <!-- Modal body -->
        <div class="modal-body" style="  color: #2e6da4;">

<div class="container-fluid">
  <h1 style="  color: #2e6da4;"> {!! $single->type !!}  	 {{ $single->price }}  ج.م   </h1>

      <div class="card mb-lg-0 {{ $single->bk_color }}" style=" margin-bottom: 14px !important; ">
                  <div class="card-body" style="color: #2e6da4;     font-size: 20px;  text-align: center;  font-weight: bold;">

                      {!! $single->desc3 !!}
                 </div>
                </div>


                   <p  style=" font-weight: bold;" class="text-center ">{!! $single->desc2 !!}</p>

                      <div class="card mb-lg-0 {{ $single->bk_color }}" style=" margin-bottom: 14px !important; ">
                  <div class="card-body">



                    <a  style=" font-size: 1.4rem;"  href="{{ URL::to(Config::get('app.locale').'/pricing-seller/' . $single->id) }}"
                    class="btn btn-block  bg-white  {{ $single->title_color }} text-uppercase">اشترك بالباقه</a>
                  </div>
                </div>



  </div>

            </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button style="
    background-color: red;
    padding: 6px;
    color: white;" type="button" class="close" data-dismiss="modal"> اغلق &times;</button>
        </div>

      </div>
    </div>
  </div>




</div>



                                                     @endforeach





                       					<!-- SingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingleSingle Package -->


                                <link rel="stylesheet" href="https://rightchoice-co.com/public/assets/css/mof.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




</x-layout>
