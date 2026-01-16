<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceVip;

use App\Models\Pricing;
use App\Models\aqar;
use App\Models\FawryPayment;
 
use App\Models\UserPriceing;
use Redirect;



class PricController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
      public function CARDbuildMessageSignatureV2($amount, $merchantRefNum, $customerProfileId)
    {
        $hashKey       = '160224c0e40347318144da5efa284eda';
        $paymentMethod = 'CARD';
        $cardNumber = 5419617005715011;
        $cardExpiryYear = 24;
        $cardExpiryMonth = 12;
        $cvv = 441;

        return hash('SHA256', 'TUDH+sU93QqTh4bRQqAadQ=='. $merchantRefNum . $customerProfileId . $paymentMethod .
        $amount . $cardNumber . $cardExpiryYear . $cardExpiryMonth . $cvv . $hashKey);

  

    }


    public function buildMessageSignatureV2($amount, $merchantRefNum, $customerProfileId)
    {
        $hashKey       = '160224c0e40347318144da5efa284eda';
        $paymentMethod = 'PAYATFAWRY';
        return hash('SHA256', 'TUDH+sU93QqTh4bRQqAadQ=='. $merchantRefNum . $customerProfileId . $paymentMethod . $amount . $hashKey);
    }



    public function callPostApi($url, array $data)
    {
       $payload = json_encode($data);
        $requestContent = [
            'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
     
    'Content-Length: ' . strlen($payload)

            ],
            'json' =>  $data 
                        
        ];
        try {
            //$client = new \GuzzleHttp\Client(['verify' => false ]);
            $client = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $url, $requestContent);
            $response = json_decode($apiRequest->getBody()->getContents(), true);


           // $GIHO= json_decode($apiRequest->getBody());
           // return   $GIHO;
           
              $referenceNumber=($response['referenceNumber']);
              $customerMobile=($response['customerMobile']);
          //  dd($response);
 
 $message="
 $referenceNumber
  استخدم الكود دا وانت بتدفع في اي منفذ من منافذ فوري الموجودة في انحاء الجمهورية  رقم  الهاتف الخاص بك هو 
  $customerMobile
  ";
        session()->flash('success',$message );
        return view('/th', compact('message'));  
        
        
         

        } catch (RequestException $re) {
            
           // dd($re);
            Log::debug($re);
            return false;
        }
    }

    public function getNumber( )
    {
        
        
        $merchantRefNum=  $six_digit_random_number = random_int(100000, 999999); 
        $amount=10.00;
        $amount = number_format((float)$amount, 2, '.', '');
        
       
        $fawryUrl = 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge';
        $data = [
            "merchantCode"        => 'TUDH+sU93QqTh4bRQqAadQ==',
            "merchantRefNum"      => $merchantRefNum,
            "customerProfileId"   => 68765,
            "customerMobile"      => "01091376",
            "customerEmail"       => "dd@email.com",
            "paymentMethod"       => 'PAYATFAWRY',
            "amount"              => $amount,
            "currencyCode"        => "EGP",
            "description"         => "purchases product by fawry",
            "chargeItems"         => $this->getProductsJSON()->getData(),
            "signature"           => $this->buildMessageSignatureV2($amount,$merchantRefNum,68765)
        ];
        //dd($data);
       // return $this->callPostApi($fawryUrl,$data);
        
         $payload = json_encode($data);
        $requestContent = [
            'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
     
    'Content-Length: ' . strlen($payload)

            ],
            'json' =>  $data 
                        
        ];
        try {
            //$client = new \GuzzleHttp\Client(['verify' => false ]);
            $client = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $fawryUrl, $requestContent);
            $response = json_decode($apiRequest->getBody()->getContents(), true);


           // $GIHO= json_decode($apiRequest->getBody());
           // return   $GIHO;
           
              $referenceNumber=($response['referenceNumber']);
              $customerMobile=($response['customerMobile']);
          //  dd($response);
 
 $message="
 $referenceNumber
  استخدم الكود دا وانت بتدفع في اي منفذ من منافذ فوري الموجودة في انحاء الجمهورية  رقم  الهاتف الخاص بك هو 
  $customerMobile
  ";
        session()->flash('success',$message );
        return view('/th', compact('message'));  
        
        
         

        } catch (RequestException $re) {
            
           // dd($re);
            Log::debug($re);
            return false;
        }
        
        
    }


    public function CARDFAWRY( )
    {
        
        $merchantRefNum=902341079;
        $amount=20.00;
        $amount = number_format((float)$amount, 2, '.', '');
        $cardNumber = 5419617005715011;
        $cardExpiryYear = 24;
        $cardExpiryMonth = 12;
        $cvv = 441;
       
        $fawryUrl = 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge';
        $data = [
            "merchantCode"        => 'TUDH+sU93QqTh4bRQqAadQ==',
            "merchantRefNum"      => $merchantRefNum,
            "customerProfileId"   => 58765,
            "customerMobile"      => "01009914490",
          //  "customerName"      => "MOHASMED",
           'cardNumber' => $cardNumber,
            'cardExpiryYear' =>   $cardExpiryYear,
            'cardExpiryMonth' =>  $cardExpiryMonth,
            'cvv' =>  $cvv,
                 'language' => 'en-gb',
            "customerEmail"       => "FF@email.com",
            "paymentMethod"       => 'CARD',
            "amount"              => $amount,
            "currencyCode"        => "EGP",
            "description"         => "purchases product by fawry",
            "chargeItems"         => $this->getProductsJSON()->getData(),
            "signature"           => $this->CARDbuildMessageSignatureV2($amount,$merchantRefNum,58765)
        ];
      // dd($data);
        return $this->callPostApi($fawryUrl,$data);
    }


    public function getProductsJSON($amount)
    {
        $data = [] ;
        
          $data[0]['itemId']       = 4365;
            $data[0]['description']  = "435435";
            $data[0]['price']        = $amount;
            $data[0]['quantity']     = 1;
            /*
        foreach ($orderItems as $i => $item) {
            $producttype= $item->card != null ? $item->card->name_en : $item->product->name_en;
            $card_id=$item->card_id != null ? $item->card_id : $item->product_id;
            $price=$item->card_id != null ? number_format((float)$item->price  * loadOption('dollar'), 2, '.', '') : number_format((float)$item->price, 2, '.', '');
            $data[$i]['itemId']       = $card_id;
            $data[$i]['description']  = $producttype;
            $data[$i]['price']        = $price;
            $data[$i]['quantity']     = $item->qty;
        }
        */
        return response()->json($data);
    }
    
    
   public function fawryCallback()
    {
        if ( isset($_GET['orderStatus'])) {

 if (  ($_GET['orderStatus'])=='PAID') {

     
         $ckeckPricing = UserPriceing::where('user_id',auth()->user()->id)->where('statues',1)->orderBy('id', 'DESC')->first();
         $free_points_olny_one_time = UserPriceing::where('user_id',auth()->user()->id)->where('pricing_id','=',2) ->first();
         //dd($free_points_olny_one_time);
         if(($free_points_olny_one_time) != NULL && $request->price_id == 2)
         {  
             
        $message = ' غير مسموح     ';
       // dd($message);
        session()->flash('success',  $message);
                return Redirect::back();

  //return view('/th', compact('message'));     
             
             
         }
        $current = 0;
        if($ckeckPricing){
            
            $ckeckPricing->update(['statues' => 0]);

            if($ckeckPricing->current_points >= 0){
                $current = $ckeckPricing->current_points;
            } 
        }
        
                     if ( isset($_GET['customerProfileId'])) {     
                         
        $pieces_id = explode("55555", $_GET['customerProfileId']);
 
                         $pric= Pricing::find($pieces_id[0]);
                         
                     //    dd($pric);
}

        $subscription = new UserPriceing();

        $subscription->user_id = auth()->user()->id;
        $subscription->pricing_id = $pric->id;
        $subscription->statues = 1;
        $subscription->start_points = $pric->points;
        $subscription->current_points = $pric->points + $current;
        $subscription->sub_points = 0;

        $subscription->save();



 /////////////////////////////////////////////
 /*
            $FawryPayment = new FawryPayment();

        $FawryPayment->paymentAmount =$amount  ;
    //    $FawryPayment->tmyezz_price_vip_id = $request->price_id;
        $FawryPayment->user_id = auth()->user()->id;
        $FawryPayment->paymentStatus ='مدفوعه';
        $FawryPayment->paymentMethod = 'بطاقه';
        $FawryPayment->signature =0;
        $FawryPayment->referenceNumber = $referenceNumber;
         $FawryPayment->merchantRefNumber = $merchantRefNum;
        $FawryPayment->paqaat_priceing_sale_id = $request->price_id;
         $FawryPayment->save();
         
         */
    /////////////////////////////////////////////
         
         
         
$message ="  ربحت معنا   $pric->points نقطة ممكن تتعامل مع المالك مباشرة بدون عمولة وممكن تشوف وحدة او اكثر رايت تشويز الافضل في الاختيار ";
$pric= Pricing::find(2);

        //$dsgfsg= json_encode(['entities'=> $pric], JSON_PRETTY_PRINT);
 //  dd($dsgfsg);
        session()->flash('success',  $message);
        return view('/th', compact('message'));  
        
        }
        }else{
            
             /////////////////////////////////////////////

            $FawryPayment = new FawryPayment();

        $FawryPayment->paymentAmount =000  ;
    //    $FawryPayment->tmyezz_price_vip_id = $request->price_id;
        $FawryPayment->user_id = auth()->user()->id;
        $FawryPayment->paymentStatus ='غير مدفوع';
        $FawryPayment->paymentMethod = 'بطاقه';
        $FawryPayment->signature = "no";
        $FawryPayment->referenceNumber = 00;
         $FawryPayment->merchantRefNumber = 000;
        $FawryPayment->paqaat_priceing_sale_id = 0;
         $FawryPayment->save();
    /////////////////////////////////////////////
    
    
            dd("جاري تجهيز الدفع ");
            
        }


      
    }
    
    
        
   public function tmyezz_fawryCallback()
    {

        if ( isset($_GET['orderStatus'])) {
    
 if (  ($_GET['orderStatus'])=='PAID') {

        
        
                       if ( isset($_GET['customerProfileId'])) {     
                          
        $pieces_id = explode("55555", $_GET['customerProfileId']);
 
         $aqar = aqar::where('id','=',$pieces_id[1])->first();
               //dd($aqar);
        $aqar->vip = 1;
        $aqar->save();
       
        
                         
                     //    dd($pric);
}


   
        


$message ="  تم تميز اعلانك بنجاح ";
 
        //$dsgfsg= json_encode(['entities'=> $pric], JSON_PRETTY_PRINT);
 //  dd($dsgfsg);
        session()->flash('success',  $message);
        return view('/th', compact('message'));  
        
        }
        }else{
            dd("جاري تجهيز الدفع ");
            
        }


      
    }
    
    
    
    public function index($locale)
    {
        //
        $allPricing = Pricing::all();
        return view('price.pricing', compact('allPricing'));
    }


  public function add_to_vip(Request $request)
    {
   
 $add_to_vip = aqar::where('id', $request->aqar_id)->where('user_id', $request->user_id)->first();

// dd($add_to_vip);
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        
          //  dd(auth()->user()->email);
        
        
        $merchantRefNum=  $six_digit_random_number = random_int(100000, 999999);  
        $amount=$request->price;
        $amount = number_format((float)$amount, 2, '.', '');
        
       
        $fawryUrl = 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge';
        $data = [
            "merchantCode"        => 'TUDH+sU93QqTh4bRQqAadQ==',
            "merchantRefNum"      => $merchantRefNum,
            "customerProfileId"   => auth()->user()->id,
            "customerMobile"      => auth()->user()->MOP,
            "customerEmail"       => auth()->user()->email,
            "paymentMethod"       => 'PAYATFAWRY',
            "amount"              => $amount,
            "currencyCode"        => "EGP",
            "description"         => "purchases   by fawry",
            "chargeItems"         => $this->getProductsJSON($amount)->getData(),
            "signature"           => $this->buildMessageSignatureV2($amount,$merchantRefNum,auth()->user()->id)
        ];
        //dd($data);
       // return $this->callPostApi($fawryUrl,$data);
        
         $payload = json_encode($data);
        $requestContent = [
            'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
     
    'Content-Length: ' . strlen($payload)

            ],
            'json' =>  $data 
                        
        ];
        try {
            //$client = new \GuzzleHttp\Client(['verify' => false ]);
            $client = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $fawryUrl, $requestContent);
            $response = json_decode($apiRequest->getBody()->getContents(), true);

 //dd($response);
           // $GIHO= json_decode($apiRequest->getBody());
           // return   $GIHO;
           
              $referenceNumber=($response['referenceNumber']);
              $customerMobile=($response['customerMobile']);
           
 /////////////////////////////////////////////
 
            $FawryPayment = new FawryPayment();

        $FawryPayment->paymentAmount =$amount  ;
    //    $FawryPayment->tmyezz_price_vip_id = $request->price_id;
        $FawryPayment->user_id = auth()->user()->id;
        $FawryPayment->paymentStatus ='UNPAID';
        $FawryPayment->paymentMethod = 'PAYATFAWRY';
        $FawryPayment->signature = $this->buildMessageSignatureV2($amount,$merchantRefNum,auth()->user()->id);
        $FawryPayment->referenceNumber = $referenceNumber;
         $FawryPayment->merchantRefNumber = $merchantRefNum;
        $FawryPayment->paqaat_priceing_sale_id = $request->price_id;
         $FawryPayment->save();
         /////////////////////////////////////////////
        
 $message="
 $referenceNumber
  استخدم الكود دا وانت بتدفع في اي منفذ من منافذ فوري الموجودة في انحاء الجمهورية  رقم  الهاتف الخاص بك هو 
  $customerMobile
  المبلغ الطلوب سداده 
  $amount
  ";
        session()->flash('success',$message );
        return view('price.th', compact('message','FawryPayment'));  
        
        
         

        } catch (RequestException $re) {
            
           // dd($re);
            Log::debug($re);
            return false;
        }
  
  
  
  
  
        /* dd("dfg");
 $merchantCode    = '1tSa6uxz2nRlhbmxHHde5A==';
     $six_digit_random_number = random_int(100000, 999999); 
   //  dd($six_digit_random_number);
$merchantRefNum  =  9129715960 ;
 $merchant_cust_prof_id  = 458626698;
$payment_method = 'CARD';
$amount = 580.55;
$cardNumber = 4005550000000001;
$cardExpiryYear = 21;
$cardExpiryMonth = 12;
$cvv = 123;
$merchant_sec_key = '160224c0e40347318144da5efa284eda'; // For the sake of demonstration
$signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method . $amount . $cardNumber . $cardExpiryYear . $cardExpiryMonth . $cvv . $merchant_sec_key);
$httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
$response = $httpClient->request('POST', 'https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'body' => json_encode( [
                            'merchantCode' => $merchantCode,
                            'merchantRefNum' => $merchantRefNum,
                            'customerMobile' => '01234567891',
                            'customerEmail' => 'example@gmail.com',
                            
                            'customerProfileId'=> $merchant_cust_prof_id,
                            'cardNumber' => $cardNumber,
                            'cardExpiryYear' => $cardExpiryYear,
                            'cardExpiryMonth' => $cardExpiryMonth,
                           
                            'cvv' => $cvv,
                            'amount' => $amount,
                            'currencyCode' => 'EGP',
                            'language' => 'en-gb',
                             'chargeItems' => [
                              'itemId' => '897fa8e81be26df25db592e81c31c',
                              'description' => 'Item Description',
                               'quantity' => 1,
                          ],
                            'signature' => $signature,
                            'paymentMethod' => $payment_method,
                            'description' => 'example description'
                        ] , true)
]);
$response = json_decode($response->getBody()->getContents(), true);
$paymentStatus = $response['type'];


DD($response);
 
 
 
 */
 
/*
$merchantCode    = '1tSa6uxz2nTwlaAmt38enA==';
$merchantRefNum  = '2312465464';
$merchant_cust_prof_id  = '777777';
$payment_method = 'PAYATFAWRY';
$amount = '50.75';
$merchant_sec_key =  '259af31fc2f74453b3a55739b21ae9ef'; // For the sake of demonstration
$signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method . $amount . $merchant_sec_key);

$url='https://atfawry.fawrystaging.com/ECommerceWeb/Fawry/payments/charge';


$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 1);

  
$headers = array(
   "Accept: application/json",
  "Content-Type: application/json",
      'x-api-key: XXXXXX',
        //    'Content-Type: text/plain'
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
 $sfdgfd=  json_encode( [
     
        'merchantCode' => $merchantCode,
        'merchantRefNum' => $merchantRefNum,
        'customerName' => 'Ahmed Ali',
        'customerMobile' => '01000000000',
        'customerEmail' => 'test@email.com',
        'customerProfileId'=> $merchant_cust_prof_id,
        'amount' => $amount,
        'paymentExpiry' => 1631138400000,
        'currencyCode' => 'EGP',
        'language' => 'en-gb',
        'chargeItems' => [
                              'itemId' => '897fa8e81be26df25db592e81c31c',
                              'description' => 'Item Description',
                              'price' => "50.75",
                              'quantity' => '1'
                          ],
        'signature' => $signature,
        'paymentMethod' => $payment_method,
        'description' => 'example description'
        ] , true);
curl_setopt($curl, CURLOPT_VERBOSE, '1');
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '1');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, $sfdgfd);


$resp = curl_exec($curl);
curl_close($curl);



    dd($resp);
 */
         
   /*   
 
$url = "https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge";

 $merchantCode    = 'TUDH+sU93QqTh4bRQqAadQ==';
     $six_digit_random_number = random_int(100000, 999999); 
   //  dd($six_digit_random_number);
$merchantRefNum  =  90284121 ;
 $merchant_cust_prof_id  = 458626698;
$payment_method = 'CARD';
$amount = 50.55;
$cardNumber = 4005550000000001;
$cardExpiryYear = "21";
$cardExpiryMonth = "05";
$cvv = 123;
$merchant_sec_key = '160224c0e40347318144da5efa284eda'; // For the sake of demonstration
$signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method . $amount . $cardNumber . $cardExpiryYear . $cardExpiryMonth . $cvv . $merchant_sec_key);

//dd($signature);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
 $sfdgfd=  json_encode( [
                            'merchantCode' => $merchantCode,
                            'merchantRefNum' => $merchantRefNum,
                            'customerMobile' => '01234567891',
                            'customerEmail' => 'example@gmail.com',
                            
                            'customerProfileId'=> $merchant_cust_prof_id,
                            'cardNumber' => $cardNumber,
                            'cardExpiryYear' => $cardExpiryYear,
                            'cardExpiryMonth' => $cardExpiryMonth,
                           
                            'cvv' => $cvv,
                            'amount' => $amount,
                            'currencyCode' => 'EGP',
                            'language' => 'en-gb',
                        
                            'signature' => $signature,
                            'paymentMethod' => $payment_method,
                            'description' => 'example description'
                        ] , true);
curl_setopt($curl, CURLOPT_VERBOSE, '1');
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, '0');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, '1');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl, CURLOPT_POSTFIELDS, $sfdgfd);


$resp = curl_exec($curl);
curl_close($curl);



    dd($resp);
  
 
*/
 






/*


 ////////////////////////////////////////////////////////////////////////////////////
    $merchantCode    = 'TUDH+sU93QqTh4bRQqAadQ==';
          $six_digit_random_number = random_int(100000, 999999); 
$merchantRefNum  =  $six_digit_random_number ;;
$merchant_cust_prof_id  = '458626698';
$payment_method = 'CARD';
$amount = '580.55';
$cardNumber = '4005550000000001';
$cardExpiryYear = '21';
$cardExpiryMonth = '05';
 $cvv = 123;
$fdgh= json_encode( [
                            'merchantCode' => $merchantCode,
                            'merchantRefNum' =>$merchantRefNum,
                            'customerMobile' => '01234567891',
                            'customerEmail' => 'example@gmail.com',
                            'customerProfileId'=> $merchant_cust_prof_id,
                            'cardNumber' => $cardNumber,
                            'cardExpiryYear' => $cardExpiryYear,
                            'cardExpiryMonth' => $cardExpiryMonth,
                            'cvv' =>  $cvv,
                            'amount' => $amount,
                           
                            'currencyCode' => 'EGP',
                            'language' => 'en-gb',
                              'signature' => "fgh2651515",
                            'paymentMethod' => $payment_method,
                            'description' => 'example description'
                        ] , true);
                     // dd($fdgh);
                        

$merchant_sec_key =  '160224c0e40347318144da5efa284eda'; // For the sake of demonstration
$signature = hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method .
                    $amount . $cardNumber . $cardExpiryYear . $cardExpiryMonth . $cvv . $merchant_sec_key);
$httpClient = new \GuzzleHttp\Client(); // guzzle 6.3
$response = $httpClient->request('POST', 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json'
            ],
            'body' =>$fdgh
]);
 $response = json_decode($response->getBody()->getContents(), true);
$paymentStatus = $response['type']; // get response values

 dd($response);
 
 */
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/*
         $ckeckPricing = UserPriceing::where('user_id',auth()->user()->id)->where('statues',1)->orderBy('id', 'DESC')->first();
         $free_points_olny_one_time = UserPriceing::where('user_id',auth()->user()->id)->where('pricing_id','=',2) ->first();
         //dd($free_points_olny_one_time);
         if(($free_points_olny_one_time) != NULL&& $request->price_id == 2)
         {  
             
        $message = ' غير مسموح     ';
       // dd($message);
        session()->flash('success',  $message);
                return Redirect::back();

  //return view('/th', compact('message'));     
             
             
         }
        $current = 0;
        if($ckeckPricing){
            
            $ckeckPricing->update(['statues' => 0]);

            if($ckeckPricing->current_points >= 0){
                $current = $ckeckPricing->current_points;
            } 
        }
        $subscription = new UserPriceing();

        $subscription->user_id = auth()->user()->id;
        $subscription->pricing_id = $request->price_id;
        $subscription->statues = 1;
        $subscription->start_points = $request->pricePoints;
        $subscription->current_points = $request->pricePoints + $current;
        $subscription->sub_points = 0;

        $subscription->save();

        $message = 'تم الاشتراك بنجاح';
                $pric= Pricing::find(2);

        $dsgfsg= json_encode(['entities'=> $pric], JSON_PRETTY_PRINT);
 //  dd($dsgfsg);
        session()->flash('success', ' تم الاشتراك بنجاح');
        return view('/th', compact('message'));        
        */
    }
    
    
      /**********/
    
    public function storeFree(Request $request){
        
        
                $check_user_one_time_ok_only = UserPriceing::where('user_id' , '=', auth()->user()->id )->where('pricing_id','=',2)->get();
               
 
 if(count($check_user_one_time_ok_only) == 0 ){
    
    
    
  //Dd($check_user_one_time_ok_only);
         $pric= Pricing::find($request->price_id);
           $subscription = new UserPriceing();

        $subscription->user_id = auth()->user()->id;
        $subscription->pricing_id = $request->price_id;
        $subscription->statues = 1;
        $subscription->start_points = $pric->points;
      //  $subscription->current_points = $pric->points + $current;
        $subscription->current_points = $pric->points;
        $subscription->sub_points = 0;

        $subscription->save();
             
        $message = " تم منحك 50 نقطه مجانا للتواصل مع الملاك";
        session()->flash('success',$message );
        return view('/th', compact('message')); 
        
      
 }
     

        
 
        
        
        $message = "انت مشترك سابقا بالباقه المجانيه للاستمرار التواصل مع الملاك  برجاء الاشتراك باحد الباقات ";
        session()->flash('success',$message );
        return view('/th', compact('message')); 
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function show($locale,$single)
    {
        //

        $pric= Pricing::find($single);
//dd($pric);
        return view('price.show', ['single' => $pric]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function edit(c $c)
    {
        //
    }


    public function vip($locale,$aqarSingle)
    {
        //
        $aqar = aqar::find($aqarSingle);
        $vips = PriceVip::all();
        return view('price.vip_aqar', ['aqarSingle' => $aqar],compact('vips'));
    }
    
    
      public function tamyeez_vip($locale,$vipid,$aqarSingle_id)
    {
 
      $PriceVip = PriceVip::find($vipid);
      
     // dd($vipid);
         return view('aqar_tmez_singel', ['vipid' => $vipid ,'aqarSingle_id' => $aqarSingle_id ],compact('PriceVip','aqarSingle_id'));
    }
    
    
    
    public function ChangeUpdated(aqar $aqarid)
    {
       
        //
        $aqar = aqar::findOrFail($aqarid->id);
        $aqar->vip = 1;
        $aqar->save();
        
        session()->flash('success', 'تم تمييز إعلانك بنجاح');
         //dd($aqarid->id);
        return Redirect::back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, c $c)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\c  $c
     * @return \Illuminate\Http\Response
     */
    public function destroy(c $c)
    {
        //
    }







}
