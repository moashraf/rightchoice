<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceVip;
use Illuminate\Support\Facades\Validator;
use App\Models\Pricing;
use App\Models\aqar;
use App\Models\FawryPayment;
use App\Models\PropertyPromotion;

use App\Models\UserPriceing;
use App\Enums\PaymentStatusEnum;
use App\Services\FawryPaymentGatewayService;
use App\Services\PropertyPromotionService;
use DomainException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Redirect;



class PricController extends Controller
{

    private function companyRestrictionMessage(): string
    {
        return 'حسابات الشركات غير مسموح لها بالاشتراك في باقات العقارات أو الباقة المجانية أو مشاهدة أرقام التواصل.';
    }

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

         if (auth()->check() && auth()->user()->isCompanyAccount()) {
             $message = $this->companyRestrictionMessage();
             session()->flash('success', $message);
             return Redirect::back();
         }


         $ckeckPricing = UserPriceing::where('user_id',auth()->user()->id)->where('statues',1)->orderBy('id', 'DESC')->first();
         $free_points_olny_one_time = UserPriceing::where('user_id',auth()->user()->id)->where('pricing_id','=',2) ->first();
         //dd($free_points_olny_one_time);
         if(($free_points_olny_one_time) != NULL && request('price_id') == 2)
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

    public function tmyezz_fawryCallback(Request $request)
    {
        $orderStatus = strtoupper((string) $request->query('orderStatus', ''));
        $locale = app()->getLocale();

        if ($orderStatus === '') {
            $message = 'لم تكتمل عملية الدفع. برجاء المحاولة مرة أخرى.';
            session()->flash('success', $message);
            return view('th', compact('message'));
        }

        if ($orderStatus !== 'PAID') {
            $message = 'لم يتم الدفع بنجاح. حالة العملية: ' . $orderStatus;
            session()->flash('success', $message);
            return view('th', compact('message'));
        }

        $parsed = $this->parseVipCustomerProfileId((string) $request->query('customerProfileId', ''));
        if (!$parsed) {
            Log::error('VIP Fawry callback: invalid customerProfileId.', $request->query());
            return redirect()
                ->route('user_ads', ['locale' => $locale])
                ->withErrors(['aqar' => 'تعذر تحديد بيانات الإعلان من عملية الدفع.']);
        }

        $package = PriceVip::find($parsed['vip_id']);
        $aqar = aqar::find($parsed['aqar_id']);

        if (!$package || !$aqar) {
            return redirect()
                ->route('user_ads', ['locale' => $locale])
                ->withErrors(['aqar' => 'الإعلان أو باقة التمييز غير موجودة.']);
        }

        if ((int) $aqar->user_id !== (int) auth()->id()) {
            return redirect()
                ->route('user_ads', ['locale' => $locale])
                ->withErrors(['aqar' => 'لا يمكنك تمييز إعلان لا يخصك.']);
        }

        $referenceNumber = (string) $request->query('referenceNumber', $request->query('fawryRefNumber', ''));
        $merchantRefNumber = (string) $request->query('merchantRefNumber', '');

        $alreadyPaid = $referenceNumber !== '' && FawryPayment::where('referenceNumber', $referenceNumber)
            ->where('paymentStatus', PaymentStatusEnum::PAID)
            ->exists();

        if ($alreadyPaid && $aqar->isPromotionActive()) {
            $message = 'تم تمييز إعلانك بنجاح';
            session()->flash('success', $message);
            return view('th', compact('message'));
        }

        try {
            $payment = $this->findOrCreateVipCardPayment(
                $package,
                $aqar,
                $merchantRefNumber,
                $referenceNumber
            );

            $this->markVipPaymentPaidAndActivate($payment, $aqar, $package, $request->query());
        } catch (DomainException $exception) {
            return redirect()
                ->route('user_ads', ['locale' => $locale])
                ->withErrors(['aqar' => $exception->getMessage()]);
        }

        $message = 'تم تمييز إعلانك بنجاح';
        session()->flash('success', $message);
        return view('th', compact('message'));
    }

    public function initVipCardCheckout(Request $request, FawryPaymentGatewayService $fawryGateway): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'price_id' => 'required|integer|exists:price_vip,id',
            'aqar_id'  => 'required|integer|exists:aqar,id',
        ], [
            'price_id.required' => 'باقة التمييز مطلوبة.',
            'price_id.exists'   => 'باقة التمييز غير موجودة.',
            'aqar_id.required'  => 'العقار مطلوب.',
            'aqar_id.exists'    => 'العقار غير موجود.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            [$package, $aqar, $amount] = $this->resolveVipCheckout($request->integer('price_id'), $request->integer('aqar_id'));
        } catch (DomainException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 422);
        }

        $user = auth()->user();
        if (empty($user->email) || empty($user->MOP)) {
            return response()->json([
                'success' => false,
                'message' => 'برجاء استكمال البريد الإلكتروني ورقم الموبايل في حسابك قبل الدفع بالفيزا.',
            ], 422);
        }

        $merchantRefNum = $this->makeVipMerchantRefNum($aqar->id, $package->id);
        $customerProfileId = $this->buildVipCustomerProfileId((int) $package->id, (int) $aqar->id);
        $itemId = (string) $package->id;
        $itemQuantity = 1;
        $returnUrl = $this->buildFawryPluginReturnUrl('tmyezz_fawryCallback');
        $signature = $fawryGateway->buildPluginSignature(
            $merchantRefNum,
            $customerProfileId,
            $returnUrl,
            $itemId,
            $itemQuantity,
            $amount
        );

        $cardPayment = FawryPayment::create([
            'paymentAmount'       => $amount,
            'currency'            => 'EGP',
            'tmyezz_price_vip_id' => $package->id,
            'paqaat_priceing_sale_id' => 0,
            'user_id'             => $user->id,
            'paymentStatus'       => PaymentStatusEnum::UNPAID,
            'paymentMethod'       => 'CARD',
            'transaction_type'    => 'vip_card',
            'signature'           => $signature,
            'referenceNumber'     => $merchantRefNum,
            'merchantRefNumber'   => $merchantRefNum,
            'gateway_response'    => json_encode(['aqar_id' => $aqar->id], JSON_UNESCAPED_UNICODE),
        ]);

        PropertyPromotion::recordPending(
            (int) $user->id,
            (int) $aqar->id,
            (int) $package->id,
            (int) $cardPayment->id,
            (float) $amount,
            (int) $package->duration_days
        );

        Log::info('VIP Fawry CARD checkout initiated.', [
            'merchantRefNumber' => $merchantRefNum,
            'aqar_id' => $aqar->id,
            'price_vip_id' => $package->id,
        ]);

        return response()->json([
            'success' => true,
            'chargeRequest' => [
                'merchantCode'      => $fawryGateway->merchantCode(),
                'merchantRefNum'    => $merchantRefNum,
                'customerMobile'    => (string) $user->MOP,
                'customerEmail'     => (string) $user->email,
                'customerName'      => (string) ($user->name ?? ''),
                'paymentExpiry'     => strval((time() + 86400) . '000'),
                'customerProfileId' => $customerProfileId,
                'chargeItems'       => [[
                    'itemId'      => $itemId,
                    'description' => strip_tags((string) ($package->name ?: 'تمييز إعلان')),
                    'price'       => (float) $amount,
                    'quantity'    => $itemQuantity,
                    'imageUrl'    => 'https://www.atfawry.com/ECommercePlugin/resources/images/atfawry-ar-logo.png',
                ]],
                'paymentMethod'          => 'CARD',
                'authCaptureModePayment' => false,
                'returnUrl'              => $returnUrl,
                'signature'              => $signature,
            ],
        ]);
    }

    public function storeVipFawry(Request $request, FawryPaymentGatewayService $fawryGateway)
    {
        $validator = Validator::make($request->all(), [
            'price_id' => 'required|integer|exists:price_vip,id',
            'aqar_id'  => 'required|integer|exists:aqar,id',
        ], [
            'price_id.required' => 'باقة التمييز مطلوبة.',
            'price_id.exists'   => 'باقة التمييز غير موجودة.',
            'aqar_id.required'  => 'العقار مطلوب.',
            'aqar_id.exists'    => 'العقار غير موجود.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        try {
            [$package, $aqar, $amount] = $this->resolveVipCheckout($request->integer('price_id'), $request->integer('aqar_id'));
        } catch (DomainException $exception) {
            return Redirect::back()->withErrors(['aqar' => $exception->getMessage()]);
        }

        $user = auth()->user();
        if (empty($user->email) || empty($user->MOP)) {
            return Redirect::back()->withErrors([
                'aqar' => 'برجاء استكمال البريد الإلكتروني ورقم الموبايل في حسابك قبل الدفع من فوري.',
            ]);
        }

        $merchantRefNum = $this->makeVipMerchantRefNum($aqar->id, $package->id);
        $customerProfileId = $this->buildVipCustomerProfileId((int) $package->id, (int) $aqar->id);
        $signature = $fawryGateway->buildPayAtFawrySignature($merchantRefNum, $customerProfileId, $amount);
        $webhookUrl = (string) config('services.fawry.webhook_url') ?: route('fawry.payment.notification');

        $data = [
            'merchantCode'      => $fawryGateway->merchantCode(),
            'merchantRefNum'    => $merchantRefNum,
            'customerProfileId' => $customerProfileId,
            'customerMobile'    => (string) $user->MOP,
            'customerEmail'     => (string) $user->email,
            'paymentMethod'     => 'PAYATFAWRY',
            'amount'            => $amount,
            'currencyCode'      => 'EGP',
            'description'       => 'تمييز إعلان عبر فوري',
            'orderWebHookUrl'   => $webhookUrl,
            'chargeItems'       => $this->getProductsJSON($amount)->getData(),
            'signature'         => $signature,
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $fawryGateway->chargeUrl(), [
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);
            $response = json_decode($apiRequest->getBody()->getContents(), true);
            $referenceNumber = $response['referenceNumber'] ?? null;

            if (!$referenceNumber) {
                Log::error('VIP Fawry PAYATFAWRY charge missing reference.', ['response' => $response]);
                return Redirect::back()->withErrors(['aqar' => 'رفضت فوري طلب الدفع، حاول مرة أخرى.']);
            }

            $FawryPayment = FawryPayment::create([
                'paymentAmount'       => $amount,
                'currency'            => 'EGP',
                'tmyezz_price_vip_id' => $package->id,
                'paqaat_priceing_sale_id' => 0,
                'user_id'             => $user->id,
                'paymentStatus'       => PaymentStatusEnum::UNPAID,
                'paymentMethod'       => 'PAYATFAWRY',
                'transaction_type'    => 'vip_fawry',
                'signature'           => $signature,
                'referenceNumber'     => $referenceNumber,
                'merchantRefNumber'   => $merchantRefNum,
                'gateway_response'    => json_encode(['aqar_id' => $aqar->id], JSON_UNESCAPED_UNICODE),
            ]);

            PropertyPromotion::recordPending(
                (int) $user->id,
                (int) $aqar->id,
                (int) $package->id,
                (int) $FawryPayment->id,
                (float) $amount,
                (int) $package->duration_days
            );

            $customerMobile = $response['customerMobile'] ?? $user->MOP;
            $message = "$referenceNumber
  استخدم الكود دا وانت بتدفع في اي منفذ من منافذ فوري الموجودة في انحاء الجمهورية  رقم  الهاتف الخاص بك هو
  $customerMobile
  المبلغ المطلوب سداده
  $amount
  ";
            session()->flash('success', $message);
            return view('th', compact('message'));
        } catch (\Throwable $exception) {
            Log::error('VIP Fawry PAYATFAWRY charge failed.', ['message' => $exception->getMessage()]);
            return Redirect::back()->withErrors(['aqar' => 'تعذر الاتصال بخدمة فوري، حاول مرة أخرى لاحقًا.']);
        }
    }

    public function index($locale)
    {
        return $this->buyer($locale);
    }

    public function seller($locale)
    {
        return view('price.pricing', [
            'audience' => 'seller',
            'allPricing' => collect(),
            'sellerPricing' => PriceVip::all(),
        ]);
    }

    public function buyer($locale)
    {
        return view('price.pricing', [
            'audience' => 'buyer',
            'allPricing' => Pricing::all(),
            'sellerPricing' => collect(),
        ]);
    }


  public function add_to_vip(Request $request)
    {

 $add_to_vip = aqar::where('id', $request->aqar_id)->where('user_id', $request->user_id)->first();

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

        if (!auth()->check() || auth()->user()->isCompanyAccount()) {
            $message = $this->companyRestrictionMessage();
            session()->flash('success', $message);
            return Redirect::back();
        }


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
            "orderWebHookUrl"     => (string) config('services.fawry.webhook_url') ?: route('fawry.payment.notification'),
            "chargeItems"         => $this->getProductsJSON($amount)->getData(),
            "signature"           => $this->buildMessageSignatureV2($amount,$merchantRefNum,auth()->user()->id)
        ];

       // return $this->callPostApi($fawryUrl,$data);

         $payload = json_encode($data);
        $requestContent = [
            'headers' => [
              'Accept' => 'application/json',
              'Content-Type' => 'application/json',
               'Content-Length: ' . strlen($payload)   ],
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

    /**
     * Append a Fawry response without removing previously stored responses.
     */
    private function appendGatewayResponse(FawryPayment $payment, array $payload): void
    {
        $gatewayResponse = json_encode(
            $payload,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );

        $payment->gateway_response = !empty($payment->gateway_response)
            ? rtrim($payment->gateway_response) . ",\n" . $gatewayResponse
            : $gatewayResponse;
    }

    private function buildFawryPluginReturnUrl(string $path): string
    {
        if ((string) config('services.fawry.env') !== 'production') {
            return url(app()->getLocale() . '/' . ltrim($path, '/'));
        }

        $base = rtrim((string) config('services.fawry.return_url_base'), '/');
        if ($base === '') {
            $base = 'https://rightchoice-co.com';
        }

        return $base . '/' . app()->getLocale() . '/' . ltrim($path, '/');
    }

    private function buildVipCustomerProfileId(int $vipId, int $aqarId): string
    {
        return $vipId . '55555' . $aqarId;
    }

    private function parseVipCustomerProfileId(string $profileId): ?array
    {
        $pieces = explode('55555', $profileId, 2);
        if (count($pieces) !== 2 || !ctype_digit((string) $pieces[0]) || !ctype_digit((string) $pieces[1])) {
            return null;
        }

        return [
            'vip_id'  => (int) $pieces[0],
            'aqar_id' => (int) $pieces[1],
        ];
    }

    private function makeVipMerchantRefNum(int $aqarId, int $vipId): string
    {
        return (string) (time() . $aqarId . $vipId . random_int(10, 99));
    }

    /**
     * @return array{0: PriceVip, 1: aqar, 2: string}
     */
    private function resolveVipCheckout(int $priceVipId, int $aqarId): array
    {
        $user = auth()->user();
        if (!$user) {
            throw new DomainException('يجب تسجيل الدخول أولاً لإتمام الدفع.');
        }

        if ($user->isCompanyAccount()) {
            throw new DomainException('باقات تمييز العقارات غير متاحة لحسابات الشركات.');
        }

        $package = PriceVip::find($priceVipId);
        $aqar = aqar::find($aqarId);

        if (!$package || !$aqar) {
            throw new DomainException('الإعلان أو باقة التمييز غير موجودة.');
        }

        if ((int) $aqar->user_id !== (int) $user->id) {
            throw new DomainException('لا يمكنك تمييز إعلان لا يخصك.');
        }

        if ($aqar->isPromotionActive()) {
            throw new DomainException('هذا العقار مميز حاليًا بالفعل.');
        }

        if (!$aqar->isEligibleForPromotion()) {
            throw new DomainException('يجب أن يكون العقار منشورًا وغير مميز حاليًا.');
        }

        $sessionCheckout = session('sell_faster_checkout');
        if (
            is_array($sessionCheckout)
            && (int) ($sessionCheckout['price_vip_id'] ?? 0) === (int) $package->id
            && (int) ($sessionCheckout['aqar_id'] ?? 0) === (int) $aqar->id
            && isset($sessionCheckout['discounted_price'])
        ) {
            $amount = number_format((float) $sessionCheckout['discounted_price'], 2, '.', '');
        } else {
            $amount = number_format((float) $package->price, 2, '.', '');
        }

        if ((float) $amount <= 0) {
            throw new DomainException('سعر باقة التمييز غير صالح.');
        }

        return [$package, $aqar, $amount];
    }

    private function findOrCreateVipCardPayment(
        PriceVip $package,
        aqar $aqar,
        string $merchantRefNumber,
        string $referenceNumber
    ): FawryPayment {
        $payment = null;

        if ($merchantRefNumber !== '') {
            $payment = FawryPayment::where('merchantRefNumber', $merchantRefNumber)->first();
        }

        if (!$payment && $referenceNumber !== '') {
            $payment = FawryPayment::where('referenceNumber', $referenceNumber)->first();
        }

        if ($payment) {
            return $payment;
        }

        $sessionCheckout = session('sell_faster_checkout');
        if (
            is_array($sessionCheckout)
            && (int) ($sessionCheckout['price_vip_id'] ?? 0) === (int) $package->id
            && (int) ($sessionCheckout['aqar_id'] ?? 0) === (int) $aqar->id
            && isset($sessionCheckout['discounted_price'])
        ) {
            $amount = number_format((float) $sessionCheckout['discounted_price'], 2, '.', '');
        } else {
            $amount = number_format((float) $package->price, 2, '.', '');
        }

        return FawryPayment::create([
            'paymentAmount'       => $amount,
            'currency'            => 'EGP',
            'tmyezz_price_vip_id' => $package->id,
            'paqaat_priceing_sale_id' => 0,
            'user_id'             => $aqar->user_id,
            'paymentStatus'       => PaymentStatusEnum::UNPAID,
            'paymentMethod'       => 'CARD',
            'transaction_type'    => 'vip_card',
            'signature'           => 'callback',
            'referenceNumber'     => $referenceNumber !== '' ? $referenceNumber : ($merchantRefNumber !== '' ? $merchantRefNumber : (string) random_int(100000, 999999)),
            'merchantRefNumber'   => $merchantRefNumber !== '' ? $merchantRefNumber : ($referenceNumber !== '' ? $referenceNumber : (string) time()),
            'gateway_response'    => json_encode(['aqar_id' => $aqar->id], JSON_UNESCAPED_UNICODE),
        ]);
    }

    private function extractAqarIdFromPayment(FawryPayment $payment, array $payload = []): ?int
    {
        $promotionAqarId = $payment->propertyPromotion()->value('aqar_id');
        if ($promotionAqarId) {
            return (int) $promotionAqarId;
        }

        $gateway = json_decode((string) $payment->gateway_response, true);
        if (is_array($gateway) && isset($gateway['aqar_id']) && is_numeric($gateway['aqar_id'])) {
            return (int) $gateway['aqar_id'];
        }

        $profileId = (string) ($payload['customerMerchantId'] ?? $payload['customerProfileId'] ?? '');
        $parsed = $this->parseVipCustomerProfileId($profileId);
        if ($parsed) {
            return $parsed['aqar_id'];
        }

        return null;
    }

    private function markVipPaymentPaidAndActivate(
        FawryPayment $payment,
        aqar $aqar,
        PriceVip $package,
        array $payload = []
    ): void {
        $referenceNumber = (string) ($payload['referenceNumber'] ?? $payload['fawryRefNumber'] ?? '');
        if ($referenceNumber !== '') {
            $payment->referenceNumber = $referenceNumber;
        }

        if (!empty($payload['merchantRefNumber'])) {
            $payment->merchantRefNumber = $payload['merchantRefNumber'];
        }

        $payment->tmyezz_price_vip_id = $payment->tmyezz_price_vip_id ?: $package->id;
        $payment->callback_payload = json_encode($payload, JSON_UNESCAPED_UNICODE);

        if ($payment->paymentStatus !== PaymentStatusEnum::PAID) {
            $payment->paymentStatus = PaymentStatusEnum::PAID;
            $payment->paid_at = $payment->paid_at ?: now();
        }

        $payment->save();

        if ($aqar->isPromotionActive()) {
            return;
        }

        if (!$aqar->isEligibleForPromotion()) {
            throw new DomainException('يجب أن يكون العقار منشورًا وغير مميز حاليًا.');
        }

        app(PropertyPromotionService::class)->activate($aqar, $package, true, $payment);
    }

    /**
     * Receive Fawry server-to-server payment status notifications.
     */
    public function paymentNotification(Request $request): JsonResponse
    {
        Log::info('Fawry payment notification received.', [
            'requestId' => $request->input('requestId'),
            'fawryRefNumber' => $request->input('fawryRefNumber'),
            'merchantRefNumber' => $request->input('merchantRefNumber'),
            'orderStatus' => $request->input('orderStatus'),
            'paymentMethod' => $request->input('paymentMethod'),
        ]);

        $validator = Validator::make(
            $request->all(),
            [
                'fawryRefNumber'        => ['required'],
                'merchantRefNumber'     => ['required'],
                'paymentAmount'         => ['required'],
                'orderAmount'           => ['required'],
                'orderStatus'           => ['required'],
                'paymentMethod'         => ['required'],
                'paymentRefrenceNumber' => ['nullable'],
                'messageSignature'      => ['required'],
            ],
            [
                'fawryRefNumber.required' =>
                    'رقم مرجع فوري مطلوب.',

                'fawryRefNumber.string' =>
                    'رقم مرجع فوري يجب أن يكون نصًا.',

                'merchantRefNumber.required' =>
                    'رقم مرجع العملية في الموقع مطلوب.',

                'merchantRefNumber.string' =>
                    'رقم مرجع العملية يجب أن يكون نصًا.',

                'paymentAmount.required' =>
                    'المبلغ المدفوع مطلوب.',

                'paymentAmount.numeric' =>
                    'المبلغ المدفوع يجب أن يكون رقمًا.',

                'orderAmount.required' =>
                    'قيمة الطلب مطلوبة.',

                'orderAmount.numeric' =>
                    'قيمة الطلب يجب أن تكون رقمًا.',

                'orderStatus.required' =>
                    'حالة عملية الدفع مطلوبة.',

                'orderStatus.string' =>
                    'حالة عملية الدفع يجب أن تكون نصًا.',

                'paymentMethod.required' =>
                    'طريقة الدفع مطلوبة.',

                'paymentMethod.string' =>
                    'طريقة الدفع يجب أن تكون نصًا.',

                'paymentRefrenceNumber.string' =>
                    'رقم مرجع الدفع يجب أن يكون نصًا.',

                'messageSignature.required' =>
                    'توقيع رسالة فوري مطلوب.',

                'messageSignature.string' =>
                    'توقيع رسالة فوري يجب أن يكون نصًا.',
            ]
        );

        if ($validator->fails()) {
            Log::warning('Fawry callback validation failed.', [
                'errors'  => $validator->errors()->toArray(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'بيانات إشعار الدفع المرسلة من فوري غير صحيحة.',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();


        $orderAmount = number_format((float) $data['orderAmount'], 2, '.', '');
        $paymentReferenceNumber = $data['paymentRefrenceNumber'] ?? '';
        $payment = FawryPayment::where('merchantRefNumber', $data['merchantRefNumber'])->first();

        if (!$payment) {
            $payment = FawryPayment::where('referenceNumber', $data['fawryRefNumber'])->first();
        }

         if (!$payment) {
            Log::warning('Fawry callback payment not found.', $request->all());

            return response()->json(['message' => 'Payment not found.'], 404);
        }

        $paymentAmount = number_format((float) $data['paymentAmount'], 2, '.', '');

//        $expectedSignature = hash('sha256',
//            $data['fawryRefNumber']
//            . $data['merchantRefNumber']
//            . $paymentAmount
//            . $orderAmount
//            . $data['orderStatus']
//            . $data['paymentMethod']
//            . $paymentReferenceNumber
//            . config('services.fawry.secure_key')
//        );
//
//        if (!hash_equals(strtolower($expectedSignature), strtolower($data['messageSignature']))) {
//            Log::warning('Invalid Fawry callback signature.', [
//                'merchantRefNumber' => $data['merchantRefNumber'],
//            ]);
//
//            return response()->json(['message' => 'Invalid signature.'], 403);
//        }

        if (number_format((float) $payment->paymentAmount, 2, '.', '') !== $paymentAmount) {
            Log::warning('Fawry callback amount mismatch.', [
                'merchantRefNumber' => $data['merchantRefNumber'],
                'expectedAmount' => $payment->paymentAmount,
                'receivedAmount' => $paymentAmount,
            ]);

            return response()->json(['message' => 'Payment amount mismatch.'], 422);
        }

        $status = strtoupper($data['orderStatus']);
        if ($status === 'CANCELED') {
            $status = 'CANCELLED';
        }

        $allowedStatuses = ['UNPAID', 'PAID', 'EXPIRED', 'FAILED', 'CANCELLED'];
        if (!in_array($status, $allowedStatuses, true)) {
            return response()->json(['message' => 'Unsupported payment status.'], 422);
        }

        $payment->paymentStatus = $status;
        $payment->referenceNumber = $data['fawryRefNumber'];
        $payment->callback_payload = json_encode($request->all(), JSON_UNESCAPED_UNICODE);

        if ($status === 'FAILED') {
            $this->appendGatewayResponse($payment, $request->all());
        }

        if ($status === 'PAID' && !$payment->paid_at) {
            $payment->paid_at = now();
        }

        $payment->save();

        if ($status === 'PAID' && $payment->tmyezz_price_vip_id) {
            try {
                $package = PriceVip::find($payment->tmyezz_price_vip_id);
                $aqarId = $this->extractAqarIdFromPayment($payment, $request->all());
                $aqar = $aqarId ? aqar::find($aqarId) : null;

                if (!$package || !$aqar) {
                    throw new DomainException('تعذر تحديد العقار أو باقة التمييز المرتبطة بعملية الدفع.');
                }

                $this->markVipPaymentPaidAndActivate($payment, $aqar, $package, $request->all());

                Log::info('Fawry VIP notification activated listing.', [
                    'payment_id' => $payment->id,
                    'aqar_id' => $aqar->id,
                    'price_vip_id' => $package->id,
                    'vip_expires_at' => $aqar->fresh()->vip_expires_at,
                ]);
            } catch (\Throwable $exception) {
                Log::error('Fawry VIP notification activation failed; callback must be retried.', [
                    'payment_id' => $payment->id,
                    'merchantRefNumber' => $data['merchantRefNumber'],
                    'message' => $exception->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Payment was recorded but the property promotion could not be activated.',
                ], 500);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Payment status updated successfully.',
            'paymentStatus' => $payment->paymentStatus,
        ]);
    }


      /**********/

    public function storeFree(Request $request){

        if (!auth()->check() || auth()->user()->isCompanyAccount()) {
            $message = $this->companyRestrictionMessage();
            session()->flash('success', $message);
            return view('/th', compact('message'));
        }

   $check_user_one_time_ok_only = UserPriceing::where('user_id' , '=', auth()->user()->id )->where('pricing_id','=',2)->get();

         if(count($check_user_one_time_ok_only) == 0 ){

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

                $message = " تم منحك 100 نقطه مجانا للتواصل مع الملاك";
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
        $pric = Pricing::find($single);

        if (!$pric) {
            return view('price.show', ['single' => null]);
        }

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
        $aqar = aqar::where('id', $aqarSingle)->where('status', 1)->firstOrFail();
        $vips = PriceVip::all();
        return view('price.vip_aqar', ['aqarSingle' => $aqar],compact('vips'));
    }


    public function tamyeez_vip($locale,$vipid,$aqarSingle_id)
    {

      $PriceVip = PriceVip::find($vipid);
      $aqar = aqar::where('id', $aqarSingle_id)->where('status', 1)->firstOrFail();

     // dd($vipid);
         return view('aqar_tmez_singel', ['vipid' => $vipid ,'aqarSingle_id' => $aqarSingle_id ],compact('PriceVip','aqarSingle_id'));
    }



    public function ChangeUpdated(aqar $aqarid)
    {

        //
        $aqar = aqar::findOrFail($aqarid->id);

        if (!$aqar->isEligibleForPromotion()) {
            return Redirect::back()->withErrors([
                'aqar' => $aqar->isPromotionActive()
                    ? 'هذا العقار مميز حاليًا بالفعل.'
                    : 'يجب أن يكون العقار منشورًا وغير مميز حاليًا.',
            ]);
        }

        $package = PriceVip::orderBy('duration_days')->firstOrFail();
        app(PropertyPromotionService::class)->activate($aqar, $package, false);

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
