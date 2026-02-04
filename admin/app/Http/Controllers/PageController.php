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


    public function redirectBack()
    {
        return Redirect::back();
    }
}
