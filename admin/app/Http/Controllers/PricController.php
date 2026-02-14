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
               $customerMobile = isset($response['customerMobile']) ? $response['customerMobile'] : 'N/A';
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
               $customerMobile = isset($response['customerMobile']) ? $response['customerMobile'] : 'N/A';
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

     }



    public function show($locale,$single)
    {


        $pric= Pricing::find($single);
         return view('price.show', ['single' => $pric]);
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
