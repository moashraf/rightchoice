<?php
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use App\Http\Requests;
use Carbon\Carbon;
use App\SmsGateways;
use App\SystemSettings;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\User;
function loadAssets($asset)
{
    return url($asset);
}

function loadOption($option)
{

    $option = SystemSettings::getOption($option);
    return ($option) ? $option->value : '';
}

function _SetRedirectWithMsg($case, $redirectPath, $msg = null, $alertType = 'success' ,$icon = 'check')
{
    if (is_null($msg)) {
        switch ($case) {
            case 'create':
                $msg = trans('Messenger.create');
                break;
            case 'update':
                $msg = trans('Messenger.update');
                break;
            case 'delete':
                $msg = trans('Messenger.delete');
                break;
            default:
                $msg = trans('Messenger.other');
        }
    }
    return $redirect = redirect()->to(Url($redirectPath))->with([$alertType => '<i class="fas fa-'.$icon.'"></i>' . $msg]);
}
function backEnd()
{
    return 'backEnd.';
}
function _PushNotification($title,$msg,$UserObject,$typeThisNotify,$redirectionID)
{
    $ob = [
        'title'        => $title,
        'message'      => $msg,
        'user_id'      => $UserObject->id,
        'notify_type'  => $typeThisNotify,
        'redirect_id'  => $redirectionID,
        'is_send'      => 0
    ];
    $NotificationObject = (new \App\Notifications())->create($ob);
    $data = [
            'title'         => $NotificationObject->title, // Return Title
            'body'          => $NotificationObject->message,
            'redirect_type' => $typeThisNotify,
            'redirect_id'   => $redirectionID,
        ];
        notify($data['title'], null, $data, $UserObject);
}


function notify($title = null, $body = null, $json_data, $user)
{
    try {
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 50);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder->setBody($body)->setSound('default');
        $optionBuilder->setDelayWhileIdle(true);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($json_data);
        $option = $optionBuilder->build();
        $notificationBuilder->build();
        $data = $dataBuilder->build();
        if ($user->device_type == 0) {
            $downstreamResponse = \FCM::sendTo($user->firebase_token,$option,null,$data);
        } else {
            $downstreamResponse = notifyIOS($data,$user->firebase_token);
        }
        return true;
    } catch (\Exception $exception) {
        return false;
    }
}

function notifyIOS($data, $user_token)
{
    $body = array(
        "to"            => $user_token,
        "priority"      => "high",
        "badge"         => "true",
        "notification"  => array_merge($data->toArray(), ["sound" => 'true'])
    );
    $body = json_encode($body);
    $headers = array('Content-Type:application/json', "Authorization:key=".env('FCM_SERVER_KEY'));
    $ret = FCMCurl($body,$headers);
    return $ret;
}

function FCMCurl($body, $headers)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    curl_close($ch);
    return $server_output;
}
function _fireSMS($number, $msg)
{
    $newEndPoint = "https://smsmisr.com/api/webapi/?username=pMvRospw&password=PumGA9G6gF&mobile=2.$number&sender=EgyptGameST&message=$msg&language=1";
    $client = new \GuzzleHttp\Client();
    try {
        $response = $client->post($newEndPoint);
        $sms = \GuzzleHttp\json_decode($response->getBody());
        return (int)$sms->code;

    } catch (\Exception $e) {
        $e->getMessage();
    }
    return false;
}

function ReturnJsonResponse($AcStatus,$Status,$MessageKey = "",$Errors = [],$Data = [],$StatusResponse = 200){
    $result = [];
    $result['activation_status']   = $AcStatus;
    $result['status']              = $Status;
    $result['message']             = Lang::get("api.$MessageKey");
    $result['errors']              = (is_array($Errors)) ? $Errors : [Lang::get("api.$Errors")];
    if ($Status == true) {
        $result['data'] = $Data;
    }
    return response()->json($result, $StatusResponse);
}

function _getIDDay($case)
{
        switch ($case) {
            case 'Saturday':
                $id = 1;
                break;
            case 'Sunday':
                $id = 2;
                break;
            case 'Monday':
                $id = 3;
                break;
            case 'Tuesday':
                $id = 4;
                break;
            case 'Wednesday':
                $id = 5;
                break;
            case 'Thursday':
                $id = 6;
                break;
            case 'Friday':
                $id = 7;
                break;

        }

    return $id ;


}

function _uploadFileWeb($image_file, $path)
{
   
    try {

        $file = $image_file;
        $pathfile = 'uploads/'.$path;
        $namerand = '-'.rand(1,900).'-';
        $filename = $namerand . '.' . $file->getClientOriginalName();
        if (!file_exists('public/uploads/'.$path)) {
            mkdir('public/uploads/'.$path, 0777, true);
        }

        $image_resize100 = Image::make($file->getRealPath());
        $image_resize100->resize(300,300);
        $image_resize100->save(public_path($pathfile .$filename));

        $rezult = $pathfile .$filename;

        return $rezult ;

    }
    catch (Exception $exception){
        return "" ;
    }

}

function _uploadFileWebNoCrop($image_file, $path)
{
   
    try {

        $file = $image_file;
        $pathfile = 'uploads/'.$path;
        $namerand = '-'.rand(1,900).'-';
        $filename = $namerand . '.' . $file->getClientOriginalName();
        if (!file_exists('public/uploads/'.$path)) {
            mkdir('public/uploads/'.$path, 0777, true);
        }
         $imagesave = Image::make($file->getRealPath());
        $imagesave->save(public_path($pathfile .$filename));
        $rezult = $pathfile .$filename;

        return $rezult ;

    }
    catch (Exception $exception){
        return "" ;
    }

}

function _uploadFileWebSlid($image_file, $path)
{
   
    try {

        $file = $image_file;
        $pathfile = 'uploads/'.$path;
        $namerand = '-'.rand(1,900).'-';
        $filename = $namerand . '.' . $file->getClientOriginalName();
        if (!file_exists('public/uploads/'.$path)) {
            mkdir('public/uploads/'.$path, 0777, true);
        }

        $image_resize100 = Image::make($file->getRealPath());
        $image_resize100->resize(732,549);
        $image_resize100->save(public_path($pathfile .$filename));

        $rezult = $pathfile .$filename;

        return $rezult ;

    }
    catch (Exception $exception){
        return "" ;
    }

}

function _uploadFileWebAqar($image_file, $path)
{
   
    try {

        $file = $image_file;
        $pathfile = $path;
        $namerand = '-'.rand(1,900).'-';
        $filename = $namerand . '.' . $file->getClientOriginalName();
        if (!file_exists('public/'.$path)) {
            mkdir('public/'.$path, 0777, true);
        }

        $image_resize100 = Image::make($file->getRealPath());
        $image_resize100->resize(512,613);
        $image_resize100->save(public_path($pathfile .$filename));

        $rezult = $pathfile .$filename;

        return $rezult ;

    }
    catch (Exception $exception){
        return "" ;
    }

}

 function _getCreatedAtAttribute($key)
{
    return Carbon::parse($key)->format('Y-m-d');
}
