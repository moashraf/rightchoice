<?php 


 

$strggggggggggggg = 'للبيع شقة1582  متر بشارع اللاسلكي الرئيسي بالمعادي الجديدة ثلاث غرف وحمامين مسجلة بحرية غير مجروحةدور خامس غير اخير اثنين 01065875485  اسانسير.سكني طبي إداري بحرية بالكامل مسجلة شهر عقاري اتحاد ملاك مشهر ارضيات رخام وغرف موسكي.غاز طبيعي وعداد كهرباء قديم مطلوب مل  ٢٣٤٥٦٧٨ ٩ يون و وسبعمائة وخمسين الف جنية. اقرا اقل';
$pattern = '/\d+/u';

 $eastern_arabic  = array('0','1','2','3','4','5','6','7','8','9');
  $western_arabic= array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');

$str = str_replace($western_arabic, $eastern_arabic, $strggggggggggggg);
  
 
 var_dump($str);
/*

 $url_data="https://www.atfawry.com/ECommerceWeb/Fawry/payments/status?merchantCode=TUDH+sU93QqTh4bRQqAadQ==&merchantRefNumber=445486&signature=5599e4baffd9cfcd4118685e94a35a85d791cb594b9e4c548c9725d5c36c5ba3";
   $ch = curl_init(); 
 curl_setopt($ch, CURLOPT_URL, $url_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0);

//$body = '{}';
//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
//curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $authToken = curl_exec($ch);







$random_mass_num= random_int(111, 10000);

$url = "https://e3len.vodafone.com.eg/web2sms/sms/submit/";
$stringnalue="AccountId=200002798&Password=Vodafone.1&SenderName=RightChoice&ReceiverMSISDN=01096138138&SMSText=بتبيع أو تشتري عقار؟ .. بدون عمولة ومن المالك مباشر rightchoice-co.com";

  $sig = hash_hmac('sha256',$stringnalue, D8FBFDD3DD684C85BC00E708FC5872EB);
$str = strtoupper($sig);

echo($random_mass_num);
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
<ReceiverMSISDN>01096138138</ReceiverMSISDN>
<SMSText>بتبيع أو تشتري عقار؟ .. بدون عمولة ومن المالك مباشر rightchoice-co.com</SMSText></SMSList>
</SubmitSMSRequest>");


$resp = curl_exec($curl);

curl_setopt($curl, CURLINFO_HEADER_OUT, true);
$information = curl_getinfo($curl);
curl_close($curl);
//var_dump($information);
 
  
  
  /*
$curl = curl_init();
        curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://e3len.vodafone.com.eg/web2sms/sms/submit/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            			"Accept: application/json",
						"Content-Type: application/x-www-form-urlencoded",
						
            CURLOPT_POSTFIELDS => array(
            'lastname' => $request->lastname,
            'mobile' => $request->mobile,
            'cf_895' => $request->cf_895,
            'cf_1046' => $request->cf_1046,
            'cf_1058' => $request->cf_1058,
            'cf_1048' => $request->cf_1048,
            'cf_1054' => $request->cf_1054,
            
            
            'cf_905' => $request->cf_905,
            'cf_1060' => $request->cf_1060,
            '__vtrftk' => 'sid:b04b8d6be32a7c9259bea56763a9ce692cba39d1,1622666784',
            'publicid' => 'a17cb8fe390c4caa6aae8b60126876f0',
            'urlencodeenable' => 1,
            'name' => $request->name),
        ));
        
             
        $response = curl_exec($curl);
var_dump($response);
        curl_close($curl);
   */
        
?>