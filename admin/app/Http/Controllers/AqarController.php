<?php

namespace App\Http\Controllers;

use App\DataTables\aqarDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateaqarRequest;
use App\Http\Requests\UpdateaqarRequest;
use App\Models\LogActivity;
use App\Repositories\ActivityLogger;
use App\Repositories\ActivityLogStatus;
use App\Repositories\aqarRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Governrate;
use App\Models\district;
use App\Models\Finish_type;
use App\Models\Floor;
use App\Models\license_type;
use App\Models\offer_type;
use App\Models\SubArea;
use App\Models\property_type;
use App\Models\User;
use App\Models\aqar;
use App\Models\Viewer;
use App\Models\UserPriceing;

use App\Models\aqar_category;
use App\Models\Compound;
use App\Models\call_time;
use App\Models\Mzaya;
use App\Models\aqar_mzaya;
use App\Models\Images;
use App\DataTables\NotificationDataTable;
use App\Models\Notification;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Repositories\NotificationRepository;
use App\Models\Activity;

class aqarController extends AppBaseController
{
    /** @var  aqarRepository */
    private $aqarRepository;

    public function __construct(aqarRepository $aqarRepo)
    {
        $this->aqarRepository = $aqarRepo;
    }

    /**
     * Display a listing of the aqar.
     *
     * @param aqarDataTable $aqarDataTable
     * @return Response
     */
    public function index(Request $request,aqarDataTable $aqarDataTable)
    {

          $allAqars = aqar::with('mzaya')->with('compounds')->with('governrateq')
            ->with('districte')->with('subAreaa')->with('images')->with('finishType')
             ->with('propertyType')->with('offertype');
        if($request->sortBy == 0)
            $allAqars->orderBy('id', 'DESC');
        else
            $allAqars->orderBy('id', 'ASC');

        if($request->filter_vip != null)
            $allAqars->where('vip',$request->filter_vip);

        if($request->filter_status  != null)
            $allAqars->where('status',$request->filter_status);

        if($request->key_word)
        {
            $allAqars
                ->where('title','like','%'.$request->key_word.'%')
                ->orWhereHas('user',function($q) use ($request){
                    $q->where('name','like','%'.$request->key_word.'%');
                });
        }
        $allAqars = $allAqars->paginate(100);
//dd($allAqars);
       // return $aqarDataTable->render('aqars.index');

       return view('aqars.table',compact('allAqars'));
    }

    /**
     * Show the form for creating a new aqar.
     *
     * @return Response
     */
    public function create()
    {
        $governrate = governrate::pluck('governrate', 'id');
        $district = district::get();
        $finishtype = finish_type::pluck('finish_type', 'id');
        $floor = floor::pluck('floor', 'id');
        $licensetype = license_type::pluck('license_type', 'id');
        $offertype = offer_type::pluck('type_offer', 'id');
        $subarea = subarea::pluck('area', 'id');
        $propertytype = property_type::get();
        $users = User::pluck('name', 'id');
        $aqarcategory = aqar_category::pluck('category_name', 'id');
        $compound = compound::get();
        $callTimes = call_time::pluck('call_time', 'id');
        return view('aqars.create',compact('governrate','district','finishtype','floor','licensetype','offertype','subarea','propertytype','users','aqarcategory','compound','callTimes'));
    }



    /**
     * Store a newly created aqar in storage.
     *
     * @param CreateaqarRequest $request
     *
     * @return Response
     */
    public function store(CreateaqarRequest $request)
    {
        $input = $request->all();

        $aqar = $this->aqarRepository->create($input);

        Flash::success('Aqar saved successfully.');

        return redirect(route('aqars.index'));
    }

    /**
     * Display the specified aqar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('Aqar not found');

            return redirect(route('aqars.index'));
        }

        $governrate = governrate::pluck('governrate', 'id');
        $district = district::where('govern_id',1)->pluck('district', 'id','govern_id');
        $finishtype = finish_type::pluck('finish_type', 'id');
        $floor = floor::pluck('floor', 'id');
        $licensetype = license_type::pluck('license_type', 'id');
        $offertype = offer_type::pluck('type_offer', 'id');
        $subarea = subarea::pluck('area', 'id');
        $propertytype = property_type::where('cat_id',1)->pluck('property_type', 'id' ,'cat_id');
        $users = User::pluck('name', 'id');
        $aqarcategory = aqar_category::pluck('category_name', 'id');
        $compound = compound::get();

        $aqar_viewers = Viewer::where('aqar_id', $aqar->id)->paginate(10);

        return view('aqars.show',compact('governrate','district','finishtype','floor','licensetype','offertype','subarea','propertytype','users','aqarcategory','compound', 'aqar_viewers'))->with('aqar', $aqar);
    }






    /**
     * Show the form for editing the specified aqar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('Aqar not found');

            return redirect(route('aqars.index'));
        }

        $governrate = governrate::pluck('governrate', 'id');
        $district = district::get();
  //  dd($aqar);
        $finishtype = finish_type::pluck('finish_type', 'id');
        $floor = floor::pluck('floor', 'id');

        $licensetype = license_type::pluck('license_type', 'id');
        $offertype = offer_type::pluck('type_offer', 'id');
        $subarea = subarea::pluck('area', 'id');
        //$propertytype = property_type::where('cat_id',1)->pluck('property_type', 'id' ,'cat_id');
       $propertytype = property_type::get();
        $users = User::pluck('name', 'id');
        $getPhoneFirst = User::where('id',$aqar->user_id)->first('MOP');
        $aqarcategory = aqar_category::pluck('category_name', 'id');
        $compound = compound::get();


        $callTimes = call_time::pluck('call_time', 'id');
        $mzaya = Mzaya::select('mzaya_type', 'id')->get();
        $mzayaAqar = aqar_mzaya::where('aqar_id', $id)->get();
         //dd($aqar);
        $activity_logs = Activity::forSubject($aqar)->orderBy('id','DESC')->paginate(10);

        return view('aqars.edit',compact('governrate','activity_logs','callTimes','mzaya','mzayaAqar','getPhoneFirst','district','finishtype','floor','licensetype','offertype','subarea','propertytype','users','aqarcategory','compound'))->with('aqar', $aqar);
    }



    /**
     * Update the specified aqar in storage.
     *
     * @param  int              $id
     * @param UpdateaqarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateaqarRequest $request)
    {

        $user = User::where('id' ,$request->user_id)->first();
       // dd($user->id);
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('Aqar not found');

            return redirect(route('aqars.index'));
        }

        $aqar = $this->aqarRepository->update($request->all(), $id);

        if (is_array($request->images)) {

            foreach ($request->images as $fil) {

                Images::create(['aqar_id' => $id,'main_img'=>0, 'img_url' => _uploadFileWebAqar($fil, '')]);
            }
        }

        if (is_array($request->input('feature_id'))) {


            aqar_mzaya::where('aqar_id', $id)->delete();
            foreach ($request->input('feature_id') as $key => $feature) {
                 $request->merge(['mzaya_id' => $request->input('feature_id')[$key]]);
                 $request->merge(['aqar_id' => $id]);
                 $perperties = aqar_mzaya::create($request->all());
            }
        }
        if($request->status == 1){


            $message = 'تم قبول الاعلان';




         $message.="
            <br/>
              <br/>
         <div class='btnAdds' style='text-align: center;'>
               <a href='https://rightchoice-co.com/ar/aqars/$aqar->slug' class='btn btn-outline-primary ml-2'>عرض</a>
                </div>
                ";
        }
        else{
            $message = 'تم رفض الاعلان بسبب احد الاسباب الاتيه
                         <br/>
                        1/عدم وجود صور بالإعلان
                         <br/>
                        2/ عدم استكمال البيانات
                         <br/>
                        3 / محتوى غير لائق
                         <br/>
                        4/ وجود اكثر من عرض  في وصف الإعلان
                         <br/>
                        5/عرض اكثر من وحده في الإعلان';
        }
        activity()
            ->causedBy(Auth::user())
            ->performedOn($aqar)
            ->tap(function(Activity $activity) use ($request) {
                $activity->comment = $request->comment;
            })
            ->log('edited');

        $notification = Notification::create([
            'user_id'=>$user->id,
            'type'=> 0,
            'title'=> 'حاله الاعلان رقم ' . $aqar->id,
            'message' => $message
            ]);
 // dd("fdgf");
        Flash::success('Aqar updated successfully.');

        return redirect(route('aqars.index'));
    }

    /**
     * Remove the specified aqar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('Aqar not found');

            return redirect(route('aqars.index'));
        }

        $this->aqarRepository->delete($id);
         $aqar_viewers = Viewer::where('aqar_id', $aqar->id)->delete($id);


        Flash::success('Aqar deleted successfully.');
        return redirect(route('aqars.index'));
    }

    public function RemoveImgAqar(Images $Images)
    {
        if(file_exists(public_path().'/images/'.$Images->img_url)){
            $image_path = public_path().'/images/'.$Images->img_url;
                  unlink($image_path);
        }
        $Images->delete();

        Flash::success('deleted successfully.');

        return redirect::back();
    }

    public function getpropertyByCat(Request $request)
    {
        $Categories = property_type::select('property_type','id')->where('cat_id', $request->category)->get();
        if (!count($Categories) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $Categories], 200);
    }

    public function getdistrictByGovernrate(Request $request)
    {
        $district = district::select('district','id')->where('govern_id', $request->governrate_id)->get();
        if (!count($district) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $district], 200);
    }

    public function getPhoneUser(Request $request)
    {
        $user = User::select('MOP','id')->where('id', $request->user_id)->get();
        if (!count($user) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $user], 200);
    }

    public function refund_points(Viewer $viewer)
    {
        $viewer->refund = 2;
        $viewer->update();

        $user_points = UserPriceing::where('user_id', $viewer->user_id)->where('statues', 1)->first();

        $user_points->current_points = ( $user_points->current_points + $viewer->points );
        $user_points->sub_points = ( $user_points->sub_points - $viewer->points );
        $user_points->update();

        return redirect()->route('aqars.show', $viewer->aqar_id);
    }
}
