<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeveloperfawryPayment extends Controller
{





////////////////////////////////////////////////////////////////////////////




    public function buildMessageSignatureV2($amount, $merchantRefNum, $customerProfileId)
    {
        
$merchantCode    = 'TUDH+sU93QqTh4bRQqAadQ==';
$merchantRefNum  = '99900642041';
$merchant_cust_prof_id  = '458626698';
$payment_method = 'CARD';
$amount = '20.22';
$cardNumber = '4738640016203287';
$cardExpiryYear = '26';
$cardExpiryMonth = '08';
$cvv = 775;
$returnUrl = "https://rightchoice-co.com/";
$merchant_sec_key =  '160224c0e40347318144da5efa284eda'; // For the sake of demonstration
return hash('sha256' , $merchantCode . $merchantRefNum . $merchant_cust_prof_id . $payment_method .
                    $amount . $cardNumber . $cardExpiryYear . $cardExpiryMonth . $cvv . $returnUrl .$merchant_sec_key);


         //return hash('SHA256', 'TUDH+sU93QqTh4bRQqAadQ=='. $merchantRefNum . $customerProfileId . $paymentMethod . $amount . $hashKey);
    }










////////////////////////////////////////////////////////////////////////////
    
    
    
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
    
    
    
    ////////////////////////////////////////////////////////////////////////////

    
   
      public function callfary_api_card()
    {
 
  
       // $merchantRefNum=  $six_digit_random_number = random_int(100000, 999999);  
     //   $amount=20.22;
       // $amount = number_format((float)$amount, 2, '.', '');
$merchantCode    = 'TUDH+sU93QqTh4bRQqAadQ==';
$merchantRefNum  = '99900642041';
$merchant_cust_prof_id  = '458626698';
$payment_method = 'CARD';
$amount = '20.22';
$cardNumber = '4738640016203287';
$cardExpiryYear = '26';
$cardExpiryMonth = '08';
$cvv = 775;
$returnUrl = "https://rightchoice-co.com/";
$merchant_sec_key =  '160224c0e40347318144da5efa284eda'; // For the sake of demonstration



        $fawryUrl = 'https://www.atfawry.com/ECommerceWeb/api/cards/cardToken';
        $data = [
                   
         'merchantCode' => $merchantCode,
        'customerProfileId'=> $merchant_cust_prof_id,
        'customerMobile' => '01234567891',
        'customerEmail' => 'example@gmail.com',
        'cardNumber' => $cardNumber,
        'cardAlias' => 'customer name on the card or any alias',
        'expiryYear' => $cardExpiryYear,
        'expiryMonth' => $cardExpiryMonth,
        'cvv' => $cvv,
        'enable3ds' => true,
        'isDefault' => true,
        'returnUrl' => $returnUrl
        
                  
              
        ];
        //dd($data);
       // return $this->callPostApi($fawryUrl,$data);
        
         $payload = json_encode($data);
        $requestContent = [
            'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
     
  //  'Content-Length: ' . strlen($payload)

            ],
            'json' =>  $data 
                        
        ];
        try {
            //$client = new \GuzzleHttp\Client(['verify' => false ]);
            $client = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $fawryUrl, $requestContent);
            $response = json_decode($apiRequest->getBody()->getContents(), true);
 
 dd($response);
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
        return view('/th', compact('message'));  
        
        
         

        } catch (RequestException $re) {
            
           // dd($re);
            Log::debug($re);
            return false;
        }
  
  
  
  

    }
    
    
    ////////////////////////////////////////////////////////////////////////////

    
    
    
    
    
    
    
}


