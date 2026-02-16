<?php



namespace App\Http\Controllers;

use App\Models\aqar;


use App\Models\Company;

use App\Models\Service;

use Illuminate\Http\Request;

use App\Models\Governrate;

use App\Models\SubArea;
use App\Models\User;
use App\Models\Ads;

use App\Models\District;
use App\Models\JobTitles;

use Illuminate\Support\Facades\Validator;
use App\Models\wish;
use App\Models\UserPriceing;
use Illuminate\Support\Str;
use Auth;
use App;
use Redirect;
use Config;


class CompanyController extends Controller

{



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index()

    {

        //



    }


      public function sorting(Request $request, $locale, $slug)

        {

                    $districtw = $request->location2;


                    $allAqars = aqar::with('images')->with('governrateq')->with('districte')->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();


            //

        $governrates = Governrate::all();
        $district = District::all();

        $governratew = $request->governrate;

        $getService = Service::where('slug',$slug)->first();


        if($getService){

         if($districtw){
              $companies = Company::where('status',1)->where('serv_id', $getService->id)->where('governrate_id', $governratew)->Where('district_id', $districtw)->paginate(8);
         }else {
              $companies = Company::where('status',1)->where('serv_id', $getService->id)->where('governrate_id', $governratew)->orWhere('district_id', $districtw)->paginate(8);
         }

        }else{
            $companies = [];
        }

             return view('companies.companies', compact('companies','getService','governrates' ,'governratew', 'allAqars','district','districtw'));

        }




    public function furn(Request $request, $locale,$slug){
                $allAqars = aqar::with('images')->with('governrateq')->with('districte')->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();



        $governratew = $request->governrate;
        $district = District::all();

        $districtw = $request->location2;

         $governrates = Governrate::all();
           // dd($locale);
        $getService = Service::where('slug',$slug)->first();


      //  dd($getService);

        if($getService){

          $companies = Company::where('status',1)->where('serv_id', $getService->id)->paginate(6);

        }else{
            dd("f");
            $companies = [];
        }

        return view('companies.companies', compact('companies','getService','governrates', 'governratew','allAqars','district','districtw'));



    }

    public function finish(){
        $allAqars = aqar::with('images')->with('governrateq')->with('districte')->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();



        $companies = Company::where('status',1)->where('serv_id', 2)->paginate(6);



        return view('companies.companies', compact('companies', 'allAqars'));



    }

    public function homeSale(){
        $allAqars = aqar::with('images')->with('governrateq')->with('districte')->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();



        $companies = Company::where('status',1)->where('serv_id', 3)->paginate(6);



        return view('companies.companies', compact('companies', 'allAqars'));



    }

    public function electronics(){


        $allAqars = aqar::with('images')->with('governrateq')->with('districte')->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();

        $companies = Company::where('status',1)->where('serv_id', 4)->paginate(6);



        return view('companies.companies', compact('companies', 'allAqars'));



    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $areas = SubArea::all();

        $governrate = Governrate::with('districts')->get();

        $jobs = JobTitles::all();

        return view('companies.create-company', compact('areas', 'governrate', 'jobs' ));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

     public function store(Request $request)

    {

          if (!empty($request->area_id)) {
                $areaCheck =  SubArea::where('area', $request->area_id)->orWhere('area', $request->area_id)->first();
            if($areaCheck){
               $areaTab = $areaCheck->id;
            }else{
            $areaTab = new SubArea();
            $areaTab->area = $request->area_id;
            $areaTab->save();

            }

         }

      //   $vendor = Auth::user();



        if ($request->isMethod('post')) {
        $random_mass_num= random_int(111, 10000);



            $rules = [

                'Employee_Name' => 'required|max:225',

                'details' => 'required|max:2500',

                'Serv_id' => 'required|integer',

                'Job_title' => 'required|integer',

                'Name' => 'required|max:225',

                'Phone' => 'required|numeric|unique:company',
                'email' => 'required|unique:users',
                 'landline' => '',

                'governrate_id' => 'required|integer',

                'district_id' => 'required|integer',

                'building_number' => 'required|min:1',

                'Floor' => 'required|min:1',

                'unit_number' => '',

                'Tax_card' => '',

                'Commercial_Register' => '',

                'photo'         => 'required|image|mimes:jpeg,jpg,png,gif',



            ];

            $Validator = Validator::make($request->all(),$rules);

            if($Validator->fails()) {



                session()->flash('error', 'تأكد من البيانات المطلوب ادخالها');

                return Redirect::back()->withErrors($Validator)->withInput($request->all());

            } else {

                try {

                         $register_user_data=  User::create([

                                                    'TYPE' => 4,

                                                    'MOP' => $request['Phone'],

                                                    'AGE' => 0,

                                                    'name' => $request['Name'],

                                                    'email' => $request['email'],

                                                    'password' =>bcrypt($request->password),

                                                    'phone_sms_otp' => $random_mass_num

                                                ]);

                                                $locale=   app()->getLocale();

                                                $userID = $register_user_data->id;

                        $findSlug = false;
                        $cheackSlug = Company::where('slug',Str::slug($request->Name, '-'))->first();
                        if($cheackSlug){
                           $findSlug = true;
                        }


                        $company = new Company();

                        if (App::isLocale('en')) {
                            $company->name_en = request('Name');
                        }else {
                            $company->Name = request('Name');
                        }


                        if($findSlug == true){

                             $company->slug = Str::slug($request->Name, '-').'-'.Str::random(2);
                        }else{

                           $company->slug = Str::slug($request->Name, '-');
                        }

                        $company->governrate_id = request('governrate_id');

                       // $company->area_id = request('area_id');
                        if (!empty($request->area_id)) {
                            if($areaCheck){
                            $company->area_id = $areaTab;
                            }else{
                              $company->area_id = $areaTab->id;
                            }
                        }
                        $company->district_id = request('district_id');

                        $company->Company_activity = request('Serv_id');

                        $company->user_id = $userID;
                       // dd($userID);

                          if (App::isLocale('en')) {
                            $company->Employee_Name = request('Employee_Name_en');
                        }else {
                          $company->Employee_Name = request('Employee_Name');
                        }



                        $company->Job_title = request('Job_title');

                        $company->Phone = request('Phone');
                        $company->Phone2 = request('Phone2');
                        $company->landline = request('landline');

                        $company->building_number = request('building_number');

                        $company->Floor = request('Floor');

                        $company->unit_number = request('unit_number');

                        if (App::isLocale('en')) {
                            $company->details = request('details_en');
                        }else {
                           $company->details = request('details');
                        }



                        $company->Tax_card = request('Tax_card');

                        $company->Commercial_Register = request('Commercial_Register');

                        $company->Serv_id = request('Serv_id');


                        if (!empty($request->photo)) {



                               $photoexplode = $request->photo->getClientOriginalName();

                               $photoexplode = explode(".", $photoexplode);

                              // $namerand = '-'.rand(1,900).'-';
                            $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

                               $namerand.= $photoexplode[0];

                               $imageNameGallery2 = $namerand . '.' . $request->photo->getClientOriginalExtension();

                               $request->photo->move(base_path() . '/public/images/', $imageNameGallery2);

                               $input['photo']=    $imageNameGallery2;



                               $company->photo = "$imageNameGallery2";



                       }
   $company->save();


/******************************************************/


$MOP  = $request['Phone'];

$url = "https://e3len.vodafone.com.eg/web2sms/sms/submit/";
$stringnalue="AccountId=200002798&Password=Vodafone.1&SenderName=RightChoice&ReceiverMSISDN=$MOP&SMSText=$random_mass_num is your verification code for RightChoice";
$code="D8FBFDD3DD684C85BC00E708FC5872EB";
  $sig = hash_hmac('sha256',$stringnalue,$code );
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
<ReceiverMSISDN>$MOP</ReceiverMSISDN>
<SMSText>$random_mass_num is your verification code for  RightChoice </SMSText>
</SMSList>
</SubmitSMSRequest>");

$resp = curl_exec($curl);
curl_close($curl);
   return redirect()->route('otbPage', ['userID' => $userID,'locale'=>$locale]) ;

                }catch (\Exception $ex) {
                     session()->flash('error', 'عفوا, يوجد خطأ ما');
  return Redirect::back()->withInput($request->all());

                }





            }





        }



        return Redirect::back();



    }




    public function updatedProfileCompany(Request $request ,Company $company)
    {


        $vendor = Auth::user();

        if ($request->isMethod('post')) {
        //   dd($request->all());
            $rules = [
                'Employee_Name' => 'required|max:225',

                'details' => 'required|max:2500',

                'Serv_id' => 'required|integer',

                'Job_title' => 'required|integer',

                'Name' => 'required|max:225',

                'Phone' => 'required|numeric',

                'governrate_id' => 'required|integer',

                 'area_id' => ( $request->area_id != null) ? 'integer' : '',

                'district_id' => 'required|integer',

                'building_number' => 'required|min:1|integer',

                'Floor' => 'required|min:1|integer',

                'unit_number' => 'required|min:1|integer',

                'Tax_card' => '',

                'Commercial_Register' => '',

                'img'         => ( $request->img != null ? 'required|image|mimes:jpeg,jpg,png,gif' : ''),

            ];
            $Validator = Validator::make($request->all(),$rules);
            if($Validator->fails()) {

                session()->flash('error', 'تأكد من البيانات المطلوب ادخالها');
                return Redirect::back()->withErrors($Validator)->withInput($request->input());
            } else {
                try {


                    //Upload Image
                   if ($request->has('img') && !is_null($request->img))
                   {

                           $photoexplode = $request->img->getClientOriginalName();
                           $photoexplode = explode(".", $photoexplode);
                       //    $namerand = '-'.rand(1,900).'-';
                                                       $namerand = '-'.rand(1,999900).rand(1,999900).rand(1,999900).'-';

                           $namerand.= $photoexplode[0];
                           $imageNameGallery2 = $namerand . '.' . $request->img->getClientOriginalExtension();
                           $request->img->move(base_path() . '/public/images/', $imageNameGallery2);
                           $input['img'] =    $imageNameGallery2;

                           $request->merge(['photo' =>  $input['img']]);

                   }

                   //update aqarDetails
                   if($request->Name){
                    $request->merge(['slug' => Str::slug($request->Name, '-')]);
                    }

                    $updatedata = Company::findOrFail($company->id);
                    $updatedata->update($request->all());


                    $vendor->update([
                        'name' => $request->Name,
                        'MOP' => $request->Phone,
                            ]);


                    session()->flash('success', 'تم التعديل بنجاح');
                   // return Redirect(Config::get('app.locale').'/user_companies');
                   return Redirect::back();
                }catch (\Exception $ex) {
                    session()->flash('error', 'عفوا, يوجد خطأ ما');

                    return Redirect::back()->withInput($request->all());
                }


            }
        }
        return Redirect::back();
    }





    /**

     * Display the specified resource.

     *

     * @param  \App\Models\Company  $company

     * @return \Illuminate\Http\Response

     */

    public function show($locale,$compan)

    {

          $random_ads= Ads::inRandomOrder()->first();

    $allAqars = aqar::where('category',1)
         ->where('status',1)
         ->where('vip',1)
         ->with('images')->with('governrateq')->with('districte')
        ->with('subAreaa')->inRandomOrder()->take(5)->latest()->get();



        $company = Company::where('slug', $compan)->with("governrateq")->with("district_ashraf")->with("serv")->with('jobTitles')->where('status',1)->first();
    //dd($company->serv->Service);
   // dd($company);

        return view('companies.single-company',  ['company' => $company,'random_ads' => $random_ads,'allAqars' => $allAqars]);

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\Models\Company  $company

     * @return \Illuminate\Http\Response

     */

    public function updateCompany($locale, $company)

    {

        //

        $areas = SubArea::all();

        $district = District::all();

        $governrate = Governrate::with('districts')->get();


        $companyy = Company::where('user_id',$company)->first();

       // dd($companyy);
        return view('companies.update', ['company' => $companyy],  compact('areas', 'governrate' ,'district', 'companyy'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\Models\Company  $company

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, Company $company)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\Models\Company  $company

     * @return \Illuminate\Http\Response

     */

    public function destroy(Company $company)

    {

        //

    }


    public function userComp(Request $request)
    {
         $getUser = Auth::user();

        if($getUser->userpricin){
        if($getUser->userpricin->current_points >= 0 ){
            $points = $getUser->userpricin->current_points;
        }else{
            $points = 0;
        }}
        else{
            $points = 0;
        }



            $allCompanies = Company::where('user_id', $getUser->id)->paginate(9);


            return view('companies.user-companies',compact('allCompanies', 'points'));
    }

     public function removeuserCompany(Request $request)
    {

        $cheackAqar = Company::find($request->item_id)->delete();

        if(!$cheackAqar){

           return response()->json(['massage'=>'This item is not found','status'=>202], 202);
        }


        return response()->json(['massage'=>'Deleted Suucess!','status'=>200], 200);

    }

}

