<?php



namespace App\Http\Controllers;

use Laravel\Jetstream\Jetstream;

use App\Models\aqar;
use App\Models\wish;
use App\Models\FawryPayment;

use App\Models\UserPriceing;
use App\Models\UserContactAqar;
use App\Models\Notification;
use Auth;
use App;


use Illuminate\Http\Request;

use App\Models\User;

use Validator;

use Redirect;
use Illuminate\Support\Facades\Hash;
use App\Models\RequestPhotoSession;


class PageController extends Controller

{




    public function customLoginManual(request $request)
    {
        //dd('hello admin');
        $locale =   app()->getLocale();
        if (is_numeric($request->email)) {
            $userdata = array(
                'MOP' => $request->email,
                'password' =>  $request->password
            );
        } else {
            $userdata = array(
                'email' => $request->email,
                'password' =>  $request->password
            );
        }

        $user = User::where('email', $request->email)->orWhere('MOP', $request->email)->first();

        // dd($user->status);
        if ($user) {
            if ($user->status == 1 && $user->phone_verfied_sms_status == 1) {

                // attempt to do the login
                if (\Auth::attempt($userdata)) {
                    //dd("تم");

                    return  redirect()->intended('/');
                } else {
                    //dd("no");     
                    if ($locale == 'ar') {
                        return back()->withErrors([
                            'email' => 'البيانات التى تم ادخالها غير صحيحه.',
                        ]);
                    } else {
                        return back()->withErrors([
                            'email' => 'The provided credentials do not match our records.',
                        ]);
                    }
                }
            } else if ($user->phone_verfied_sms_status != 1) {

                return redirect()->route('otbPage', ['userID' => $user->id, 'locale' => $locale]);
            } else {
                return back()->withErrors([
                    'email' => 'User is currently blocked kindly refer back tp customer service',
                ]);
            }
        } else {
            return back()->withErrors([
                'email' => 'User not found',
            ]);
        }
    }

    public function user_wishs(Request $request)
    {

        $getUser = Auth::user();

        $points = 0;
        if (($getUser->userpricin)) {

            if ($getUser->userpricin->current_points >= 0) {
                $points = $getUser->userpricin->current_points;
            } else {
                $points = 0;
            }
        }

        $allAqars = wish::where('user_id', $getUser->id)->with('aqarInfo')->paginate(9);
        //dd($allAqars->aqarInfo->offerTypes->offer_id);
        //dd($allAqars);

        return view('auth.user_wishs', compact('allAqars', 'points'));
    }



    public function user_ads(Request $request)

    {

        $getUser = Auth::user();
        $points = 0;
        if (($getUser->userpricin)) {

            if ($getUser->userpricin->current_points >= 0) {
                $points = $getUser->userpricin->current_points;
            } else {
                $points = 0;
            }
        }

        $allAqars = aqar::where('user_id', $getUser->id)->paginate(9);


        return view('auth.user_ads', compact('allAqars', 'points'));
    }


    public function register(Request $request, $locale)

    {

        return view('auth.register');
    }


    ///////////////////////////////////////////////////////

    public function custom_register(Request $request, $locale)
    {

        //dd($request['name']);


        $locale =   app()->getLocale();

        $random_mass_num = random_int(111, 10000);

        $validator = Validator::make($request->all(), [

            'name' => 'required|min:3|max:90',

            'email' => 'required|min:3|email|max:90|unique:users',

            'password'     => 'required|confirmed|max:255',
            //    'TYPE' => 'required|max:90',
            // 'AGE' => 'required|max:90',

            'MOP' => 'required|min:3|max:90|unique:users',



        ]);





        if ($validator->fails()) {

            return \Redirect::back()->withErrors($validator)->withInput($request->all());
        } else {



            $register_user_data =  User::create([

                'Commercial_Register' => $request['Commercial_Register'],
                'Tax_card' => $request['Tax_card'],
                'TYPE' => $request['TYPE'],

                'MOP' => $request['MOP'],

                'AGE' => $request['AGE'],

                'name' => $request['name'],

                'email' => $request['email'],

                'password' => bcrypt($request->password),

                'phone_sms_otp' => $random_mass_num,

                'Employee_Name' => $request['Employee_Name'],
                'Job_title' => $request['Job_title'],

            ]);
            $userID = $register_user_data->id;
            //dd($register_user_data->id);

            /******************************************************/


            $MOP  = $request['MOP'];

            $url = "https://e3len.vodafone.com.eg/web2sms/sms/submit/";
            $stringnalue = "AccountId=200002798&Password=Vodafone.1&SenderName=RightChoice&ReceiverMSISDN=$MOP&SMSText=$random_mass_num is your verification code for https://rightchoice-co.com";
            $code = "D8FBFDD3DD684C85BC00E708FC5872EB";
            $sig = hash_hmac('sha256', $stringnalue, $code);
            $str = strtoupper($sig);

            echo ($random_mass_num);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $headers = array(
                "Accept: application/xml",
                "Content-Type: application/xml",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($curl, CURLOPT_POSTFIELDS, "<?xml version='1.0' encoding='UTF-8'?>
<SubmitSMSRequest xmlns:='http://www.edafa.com/web2sms/sms/model/' xmlns:xsi='http://www.w3.org/2001/XMLSchemainstance' xsi:schemaLocation='http://www.edafa.com/web2sms/sms/model/ SMSAPI.xsd ' xsi:type='SubmitSMSRequest'>
<AccountId>200002798</AccountId>
<Password>Vodafone.1</Password>
<SecureHash>$str</SecureHash>
<SMSList>
<SenderName>RightChoice</SenderName>
<ReceiverMSISDN>$MOP</ReceiverMSISDN>
<SMSText>$random_mass_num is your verification code for https://rightchoice-co.com</SMSText>
</SMSList>
</SubmitSMSRequest>");


            $resp = curl_exec($curl);
            curl_close($curl);
            //echo($random_mass_num);

            //var_dump($resp);

            /******************************************************/


            // return redirect('/');

            return redirect()->route('otbPage', ['userID' => $userID, 'locale' => $locale]);
        }
    }

    public function otbPage()
    {
        //  dd($_GET['userID'] );
        $user = User::where('id', $_GET['userID'])->first();
        //   dd( $user);

        return view('auth.otb-page', compact('user'));
    }



    public function otbReset()
    {
        //  dd($_GET['userID'] );
        $user = User::where('id', $_GET['userID'])->first();
        //   dd( $user);

        return view('auth.otb-reset', compact('user'));
    }





    public function verifyOtbPage(Request $request)
    {
        $user = User::where('id', $request->userID)->first();
        // dd($user);
        if ($user->phone_sms_otp == $request->otb) {
            // $user->update('phone_verfied_sms_status',true);
            $user->update(['phone_verfied_sms_status' => true]);



            Auth::loginUsingId($user->id);
            return redirect()->intended('/');
        } else {
            return back()->withErrors([
                'otp' => 'البيانات التى تم ادخالها غير صحيحه.',
            ]);
        }
    }

    public function verifyOtbReset(Request $request)
    {
        $user = User::where('id', $request->userID)->first();
        $userPhone = $user->MOP;
        // dd($user);

        if ($user->phone_sms_otp == $request->otb) {
            // $user->update('phone_verfied_sms_status',true);
            // dd('hell');
            return view('auth.resetPassPhone', compact('userPhone'));
        } else {
            return back()->withErrors([
                'otp' => 'البيانات التى تم ادخالها غير صحيحه.',
            ]);
        }
        // dd('afterelse');

    }



    public function phoneResetPassword(Request $request)
    {

        $user = User::where('MOP', $request->phone)->first();
        // dd($user);
        $user->password = Hash::make($request->password);

        $user->save();

        session()->flash('success', 'تم تغيير كلمه المرور بنجاح');
        return Redirect()->to('ar/login');
    }




    public function donePhoneVerf()
    {
        return View('auth.phone_ver');
    }





    public function usersession(Request $request)
    {

        $rules = array('user_phone' => 'required', 'user_name' => 'required', 'user_email' => 'required', 'user_address' => 'required', 'session_description' => 'required');
        $validator = Validator::make($request->all(), $rules);

        // Validate the input and return correct response
        if ($validator->fails()) {
            return response()->json(['massage' => 'يجب إدخال رساله البلاغ المقدم من سيادتكم', 'status' => 400], 400);
        } else {

            try {

                if (Auth::user()) {
                    $request->merge(['user_id' => Auth::user()->id]);
                }
                $request->merge(['phone' => $request->user_phone]);
                $request->merge(['email' => $request->user_email]);
                $request->merge(['user_name' => $request->user_name]);
                $request->merge(['address' => $request->user_address]);
                $request->merge(['description' => $request->session_description]);

                $session = RequestPhotoSession::create($request->all());



                return response()->json(['massage' => 'تم إرسال بياناتك بنجاح , وسوف يتم التواصل مع سيادتكم فى اقرب وقت', 'status' => 200], 200);
            } catch (\Exception $ex) {
                return response()->json(['massage' => $ex, 'status' => 404], 404);
            }
        }
    }


    public function user_point_count_history()
    {

        $getUser = Auth::user();

        //  $data_con = user::with('contact')->where('id','=',$getUser->id)->get();
        $all_data = UserContactAqar::with('all_aqat_viw')->where('user_id', '=', $getUser->id)->orderBy('created_at', 'DESC')->paginate(5);

        //dd($all_data);
        $all_history_of_point_of_user = UserPriceing::with('pricing')->where('user_id', '=', $getUser->id)->get();
        //  dd($all_history_of_point_of_user);
        $points = 0;
        $allpoints = ($getUser->userpricin);
        if ($getUser->userpricin) {
            if ($getUser->userpricin->current_points >= 0) {
                $points = $getUser->userpricin->current_points;
            } else {
                $points = 0;
            }
        } else {
            $points = 0;
        }


        $FawryPayment_data = FawryPayment::where('user_id', $getUser->id)->where('paymentStatus', 'PAID')->paginate(4, '*', 'posts');
        $FawryPayment_data_unpaid = FawryPayment::where('user_id', $getUser->id)->where('paymentStatus', 'UNPAID')->paginate(4, '*', 'posts');
        //dd($FawryPayment_data_unpaid);
        if (count($FawryPayment_data) != 0) {
            foreach ($FawryPayment_data as $FawryPayment_data_val) {

                //dd($FawryPayment_data_val->signature);
                $merchantCode    = 'TUDH+sU93QqTh4bRQqAadQ==';
                $merchantRefNumber  = $FawryPayment_data_val->merchantRefNumber;
                $merchant_sec_key =  '160224c0e40347318144da5efa284eda'; // For the sake of demonstration
                $signature = hash('sha256', $merchantCode . $merchantRefNumber . $merchant_sec_key);


                $url_data = "https://www.atfawry.com/ECommerceWeb/Fawry/payments/status?merchantCode=$merchantCode&merchantRefNumber=$FawryPayment_data_val->merchantRefNumber&signature=$signature";
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_data);
                //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_HEADER, 0);

                //$body = '{}';
                //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
                //curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $authToken = curl_exec($ch);

                //echo($authToken);
            }
        }



        return view('user_point_count_history', compact('FawryPayment_data', 'FawryPayment_data_unpaid','all_data', 'points', 'all_history_of_point_of_user'));
    }





    public function notification()
    {
        $getUser = Auth::user();
        $points = 0;

        if ($getUser->userpricin) {
            if ($getUser->userpricin->current_points >= 0) {
                $points = $getUser->userpricin->current_points;
            } else {
                $points = 0;
            }
        } else {
            $points = 0;
        }



        $notifications = Notification::where('user_id', $getUser->id)

            ->paginate(9);
        return view('notifications.notifications', compact('points', 'notifications'));
    }

    public function ChangeStatus(Request $request)
    {
        $noti_id = (int)$request->item_id;
        $notifi = Notification::find($noti_id);
        $notifi->status = 1;
        $notifi->save();

        if (!$notifi) {

            return response()->json(['massage' => 'This item is not found', 'status' => 202], 202);
        }


        return response()->json(['massage' => 'Change Success!', 'status' => 200], 200);
    }


    public function resendOTB(Request $request)
    {


        //dd($request);

        $random_mass_num = random_int(111, 10000);

        $user = User::where('id', $request->userID)->first();
        //dd($user);
        $user->update(['phone_sms_otp' => $random_mass_num]);

        $MOP  = $request['MOP'];

        $url = "https://e3len.vodafone.com.eg/web2sms/sms/submit/";
        $stringnalue = "AccountId=200002798&Password=Vodafone.1&SenderName=RightChoice&ReceiverMSISDN=$MOP&SMSText=$random_mass_num is your verification code for https://rightchoice-co.com";
        $code = "D8FBFDD3DD684C85BC00E708FC5872EB";
        $sig = hash_hmac('sha256', $stringnalue, $code);
        $str = strtoupper($sig);

        echo ($random_mass_num);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Accept: application/xml",
            "Content-Type: application/xml",
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, "<?xml version='1.0' encoding='UTF-8'?>
        <SubmitSMSRequest xmlns:='http://www.edafa.com/web2sms/sms/model/' xmlns:xsi='http://www.w3.org/2001/XMLSchemainstance' xsi:schemaLocation='http://www.edafa.com/web2sms/sms/model/ SMSAPI.xsd ' xsi:type='SubmitSMSRequest'>
        <AccountId>200002798</AccountId>
        <Password>Vodafone.1</Password>
        <SecureHash>$str</SecureHash>
        <SMSList>
        <SenderName>RightChoice</SenderName>
        <ReceiverMSISDN>$MOP</ReceiverMSISDN>
        <SMSText>$random_mass_num is your verification code for https://rightchoice-co.com</SMSText>
        </SMSList>
        </SubmitSMSRequest>");


        $resp = curl_exec($curl);
        curl_close($curl);



        return \Redirect::back()->withInput($request->all());
    }

    public function redirectBack()
    {
        return Redirect::back();
    }
}
