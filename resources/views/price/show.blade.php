 <x-layout>
 @section('title')
{{    $single->type   }}
@endsection

    <div   class="{{    $single->bk_color   }} text-center">
        <div style="height: 100%;">
                        <br> <br> 

            <span>{{    $single->type   }}</span>
            <br> <br>
            <h1 style="display: inline; font-weight:bold;" class="pr-value {{    $single->title_color   }}">{{ $single->price }}</h1><span>ج.م</span>
            <br>
                <p> {{    $single->description   }} </p>
                 <br>
                <p> {{    $single->desc1   }} </p>
            
            
            
  @if($single->id == 2)
  
   <section id="register" class="bg-light text-center">
     
     
     
       <form action="{{ route('price-free-subscribed') }}" method="POST">
                            @csrf
                            <input  TYPE="hidden" NAME="price_id" value="{{ $single->id }}">
                            <input  TYPE="hidden" NAME="price" value="{{$single->price}}">
                                <div class="form-group" style="text-align: center; align-items:center;">
                                        <input type="submit" class="btn btn-theme-light rounded" name="submit" id="" value="اشترك الان">
                                    </div>
                                    
                           <!-- <input  TYPE="hidden" NAME="currency_code" value="CurrencyCode">
                            <input  TYPE="hidden" NAME="price_id" value="{{ $single->id }}">
                            <input  TYPE="hidden" NAME="pricePoints" value="{{ $single->points }}">

                               <div class="form-group">
                                   <label for="cardName">الاسم على الكارت</label>
                                   <input  type="text" placeholder="عميل مميز" name="cardName" class="myselect">
                               </div>
                               <div class="form-group">
                                <label for="cardNo">رقم الكارت</label>
                                <input  type="text" placeholder="1111-2222-3333-4444" name="cardNo" class="myselect">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="expyear">تاريخ الانتهاء</label>
                                        <input  class="myselect" type="text" id="expyear" name="expyear" placeholder="2018">
                                      
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input  class="myselect" type="text" id="cvv" name="cvv" placeholder="352">
                                      
                                    </div>
                                </div>
                              </div>
                              <br>
                              <br>
                                
                                    -->
                            </form>
     
   </section>
  @else
    <section id="register" class="bg-light text-center">
        <div class="container">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="pills-bank-tab" data-bs-toggle="pill"
                        data-bs-target="#pills-bank" type="button" role="tab" aria-controls="pills-bank"
                        aria-selected="true">الدفع عن طريق البنك</a>    
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="pills-fawry-tab" data-bs-toggle="pill" data-bs-target="#pills-fawry"
                        type="button" role="tab" aria-controls="pills-fawry" aria-selected="false">الدفع عن طريق فوري</a>
                </li>


            </ul>
            <div class="tab-content" id="pills-tabContent">

                <div class="tab-pane fade" id="pills-fawry" role="tabpanel" aria-labelledby="pills-fawry-tab">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                   <form action="{{ route('price-subscribed') }}" method="POST">
                            @csrf
                            <input  TYPE="hidden" NAME="currency_code" value="CurrencyCode">
                            <input  TYPE="hidden" NAME="price_id" value="{{ $single->id }}">
                            <input  TYPE="hidden" NAME="price" value="{{$single->price}}">
                                <div class="form-group" style="text-align: center; align-items:center;">
                                        <input type="submit" class="btn btn-theme-light rounded" name="submit" id="" value="اشترك الان">
                                    </div>
                                    
                           <!-- <input  TYPE="hidden" NAME="currency_code" value="CurrencyCode">
                            <input  TYPE="hidden" NAME="price_id" value="{{ $single->id }}">
                            <input  TYPE="hidden" NAME="pricePoints" value="{{ $single->points }}">

                               <div class="form-group">
                                   <label for="cardName">الاسم على الكارت</label>
                                   <input  type="text" placeholder="عميل مميز" name="cardName" class="myselect">
                               </div>
                               <div class="form-group">
                                <label for="cardNo">رقم الكارت</label>
                                <input  type="text" placeholder="1111-2222-3333-4444" name="cardNo" class="myselect">
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="expyear">تاريخ الانتهاء</label>
                                        <input  class="myselect" type="text" id="expyear" name="expyear" placeholder="2018">
                                      
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="cvv">CVV</label>
                                        <input  class="myselect" type="text" id="cvv" name="cvv" placeholder="352">
                                      
                                    </div>
                                </div>
                              </div>
                              <br>
                              <br>
                                
                                    -->
                            </form>
                            <img src="{{ url('public/images/icons/fawry.jpg') }}" class="img-thumbnail"/>
                     
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade show active" id="pills-bank" role="tabpanel"
                    aria-labelledby="pills-bank-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            
                             
          
                <div class=" ">
                            
                             
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" href="https://www.atfawry.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css">
 
<script src="https://www.atfawry.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js"></script>
<script src="UAT.js"></script>
 
	<button type="image" class="btn btn-theme-light rounded"   onclick="checkout()" alt="pay-using-fawry" id="fawry-payment-btn">     اشترك الان </button>
	   <br> <br>
	<div id="fawry-UAT"></div>
	<script>
		
function checkout() {
	 const configuration = {
       locale: "ar", //default en, allowed [ar, en]
       divSelector: 'fawry-UAT', //required and you can change it as desired
	   mode: DISPLAY_MODE.SEPARATED, //required, allowd values [POPUP, INSIDE_PAGE, SIDE_PAGE, SEPARATED]
	   onSuccess: successCallBack, //optional and not supported with separated display mode
	   onFailure: failureCallBack, //optional and not supported with separated display mode
	};
   
	FawryPay.checkout(buildChargeRequest(), configuration);
}

function buildChargeRequest() {
	const chargeRequest = {
		merchantCode: 'TUDH+sU93QqTh4bRQqAadQ==', // the merchant account number in Fawry
		merchantRefNum: '<?php  $six_digit_random_number = random_int(100000, 999999); echo $six_digit_random_number ;?>', // order refrence number from merchant side
		customerMobile: "<?php echo Auth()->user()->MOP ; ?>",
		customerEmail: "<?php echo Auth()->user()->email ; ?>",
		customerName: '',
		paymentExpiry: '1672351200000',
		customerProfileId: <?php  $numsort=55555;  echo$single->id.$numsort. $six_digit_random_number; ?>, // in case merchant has customer profiling then can send profile id to attach it with order as reference 
		chargeItems: [
			{
				itemId: '23432',
				description: '23423423',
				price: {{$single->price}},
				quantity: 1,
				imageUrl: 'https://www.atfawry.com/ECommercePlugin/resources/images/atfawry-ar-logo.png'
			}
		],
                           
		paymentMethod: 'CARD',
		returnUrl: 'https://rightchoice-co.com/ar/fawryCallback',
		signature: '553051e4bfdbaf83361825a12e7245447a4bdece7bdf57d9ca862f3cbb141073'
	};
	
	return chargeRequest;
}

function successCallBack(data) {
    alert("success");
	console.log('handle success call back as desired, data', data);
	document.getElementById('fawryPayPaymentFrame')?.remove();
}

function failureCallBack(data) {
    alert("success");
	console.log('handle failure call back as desired, data', data);
	document.getElementById('fawryPayPaymentFrame')?.remove();
}
		</script>
 


                        </div>
                                                    <img src="{{ url('public/images/icons/download.png') }}" class="img-thumbnail"/>

                        
                      </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
 
  @endif
           
                        
                           <br> <br>
                           
                     
                           
                           
                           
                        
</div>          
    </div>
 

</x-layout>


 