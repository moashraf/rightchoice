<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateaqarRequest;
use App\Http\Requests\UpdateaqarRequest;
use App\Repositories\aqarRepository;
use Illuminate\Http\Request;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\Governrate;
use App\Models\District;
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
use App\Models\Notification;

class AdminAqarController extends AppBaseController
{
    /** @var aqarRepository */
    private $aqarRepository;

    public function __construct(aqarRepository $aqarRepo)
    {
        $this->aqarRepository = $aqarRepo;
        $this->middleware('adminfCheckAdmin');
    }

    /**
     * Display a listing of the aqar with filters & search.
     */
    public function index(Request $request)
    {
        $allAqars = aqar::with('mzaya', 'compounds', 'governrateq', 'districte', 'subAreaa', 'images', 'finishType', 'propertyType', 'user');

        $allAqars->orderBy('status', 'ASC')->orderBy('created_at', 'DESC');

        if ($request->filter_vip !== null && $request->filter_vip !== '')
            $allAqars->where('vip', $request->filter_vip);

        if ($request->filter_status !== null && $request->filter_status !== '')
            $allAqars->where('status', $request->filter_status);

        if ($request->key_word) {
            $allAqars->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->key_word . '%')
                  ->orWhereHas('user', function ($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->key_word . '%');
                  });
            });
        }

        $allAqars = $allAqars->paginate(50);

        return view('admin_aqars.index', compact('allAqars'));
    }

    /**
     * Show the form for creating a new aqar.
     */
    public function create()
    {
        $governrate    = Governrate::pluck('governrate', 'id');
        $district      = District::get();
        $finishtype    = Finish_type::pluck('finish_type', 'id');
        $floor         = Floor::pluck('floor', 'id');
        $licensetype   = license_type::pluck('license_type', 'id');
        $offertype     = offer_type::pluck('type_offer', 'id');
        $subarea       = SubArea::pluck('area', 'id');
        $propertytype  = property_type::get();
        $users         = User::pluck('name', 'id');
        $aqarcategory  = aqar_category::pluck('category_name', 'id');
        $compound      = Compound::get();
        $callTimes     = call_time::pluck('call_time', 'id');

        return view('admin_aqars.create', compact(
            'governrate', 'district', 'finishtype', 'floor', 'licensetype',
            'offertype', 'subarea', 'propertytype', 'users', 'aqarcategory',
            'compound', 'callTimes'
        ));
    }

    /**
     * Store a newly created aqar in storage.
     */
    public function store(CreateaqarRequest $request)
    {
        $input = $request->all();
        $aqar = $this->aqarRepository->create($input);

        Flash::success('تم حفظ العقار بنجاح.');
        return redirect(route('sitemanagement.aqars.index'));
    }

    /**
     * Display the specified aqar.
     */
    public function show($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('العقار غير موجود');
            return redirect(route('sitemanagement.aqars.index'));
        }

        $governrate    = Governrate::pluck('governrate', 'id');
        $district      = District::where('govern_id', 1)->pluck('district', 'id', 'govern_id');
        $finishtype    = Finish_type::pluck('finish_type', 'id');
        $floor         = Floor::pluck('floor', 'id');
        $licensetype   = license_type::pluck('license_type', 'id');
        $offertype     = offer_type::pluck('type_offer', 'id');
        $subarea       = SubArea::pluck('area', 'id');
        $propertytype  = property_type::where('cat_id', 1)->pluck('property_type', 'id', 'cat_id');
        $users         = User::pluck('name', 'id');
        $aqarcategory  = aqar_category::pluck('category_name', 'id');
        $compound      = Compound::get();

        $aqar_viewers  = Viewer::where('aqar_id', $aqar->id)->paginate(10);

        return view('admin_aqars.show', compact(
            'governrate', 'district', 'finishtype', 'floor', 'licensetype',
            'offertype', 'subarea', 'propertytype', 'users', 'aqarcategory',
            'compound', 'aqar_viewers'
        ))->with('aqar', $aqar);
    }

    /**
     * Show the form for editing the specified aqar.
     */
    public function edit($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('العقار غير موجود');
            return redirect(route('sitemanagement.aqars.index'));
        }

        $governrate    = Governrate::pluck('governrate', 'id');
        $district      = District::get();
        $finishtype    = Finish_type::pluck('finish_type', 'id');
        $floor         = Floor::pluck('floor', 'id');
        $licensetype   = license_type::pluck('license_type', 'id');
        $offertype     = offer_type::pluck('type_offer', 'id');
        $subarea       = SubArea::pluck('area', 'id');
        $propertytype  = property_type::get();
        $users         = User::pluck('name', 'id');
        $getPhoneFirst = User::where('id', $aqar->user_id)->first('MOP');
        $aqarcategory  = aqar_category::pluck('category_name', 'id');
        $compound      = Compound::get();
        $callTimes     = call_time::pluck('call_time', 'id');
        $mzaya         = Mzaya::select('mzaya_type', 'id')->get();
        $mzayaAqar     = aqar_mzaya::where('aqar_id', $id)->get();

        return view('admin_aqars.edit', compact(
            'governrate', 'callTimes', 'mzaya', 'mzayaAqar', 'getPhoneFirst',
            'district', 'finishtype', 'floor', 'licensetype', 'offertype',
            'subarea', 'propertytype', 'users', 'aqarcategory', 'compound'
        ))->with('aqar', $aqar);
    }

    /**
     * Update the specified aqar in storage.
     */
    public function update($id, UpdateaqarRequest $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('العقار غير موجود');
            return redirect(route('sitemanagement.aqars.index'));
        }

        $aqar = $this->aqarRepository->update($request->all(), $id);

        // Upload images
        if (is_array($request->images)) {
            foreach ($request->images as $fil) {
       Images::create(['aqar_id' => $id, 'main_img' => 0, 'img_url' => _uploadFileWebAqar($fil, '')]);
            }
        }

        // Update mzaya (advantages)
        if (is_array($request->input('feature_id'))) {
            aqar_mzaya::where('aqar_id', $id)->delete();
            foreach ($request->input('feature_id') as $key => $feature) {
                $request->merge(['mzaya_id' => $request->input('feature_id')[$key]]);
                $request->merge(['aqar_id' => $id]);
                aqar_mzaya::create($request->all());
            }
        }

        // Send notification based on status
        if ($user) {
            if ($request->status == 1) {
                $message = 'تم قبول الاعلان';
                $message .= "<br/><br/><div class='btnAdds' style='text-align: center;'><a href='/ar/aqars/$aqar->slug' class='btn btn-outline-primary ml-2'>عرض</a></div>";
            } else {
                $message = 'تم رفض الاعلان بسبب احد الاسباب الاتيه<br/>1/عدم وجود صور بالإعلان<br/>2/ عدم استكمال البيانات<br/>3 / محتوى غير لائق<br/>4/ وجود اكثر من عرض في وصف الإعلان<br/>5/عرض اكثر من وحده في الإعلان';
            }

            Notification::create([
                'user_id' => $user->id,
                'type'    => 0,
                'title'   => 'حاله الاعلان رقم ' . $aqar->id,
                'message' => $message,
            ]);
        }

        Flash::success('تم تحديث العقار بنجاح.');
        return redirect(route('sitemanagement.aqars.index'));
    }

    /**
     * Remove the specified aqar from storage.
     */
    public function destroy($id)
    {
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            Flash::error('العقار غير موجود');
            return redirect(route('sitemanagement.aqars.index'));
        }

        $this->aqarRepository->delete($id);
        Viewer::where('aqar_id', $aqar->id)->delete();

        Flash::success('تم حذف العقار بنجاح.');
        return redirect(route('sitemanagement.aqars.index'));
    }

    /**
     * Remove an image from aqar.
     */
    public function removeImage(Images $Images)
    {
        if (file_exists(public_path() . '/images/' . $Images->img_url)) {
            unlink(public_path() . '/images/' . $Images->img_url);
        }
        $Images->delete();

        Flash::success('تم الحذف بنجاح.');
        return redirect()->back();
    }

    /**
     * AJAX: Get property types by category.
     */
    public function getPropertyByCat(Request $request)
    {
        $categories = property_type::select('property_type', 'id')->where('cat_id', $request->category)->get();
        if (!count($categories) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $categories], 200);
    }

    /**
     * AJAX: Get districts by governrate.
     */
    public function getDistrictByGovernrate(Request $request)
    {
        $district = District::select('district', 'id')->where('govern_id', $request->governrate_id)->get();
        if (!count($district) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $district], 200);
    }

    /**
     * AJAX: Get user phone.
     */
    public function getPhoneUser(Request $request)
    {
        $user = User::select('MOP', 'id')->where('id', $request->user_id)->get();
        if (!count($user) > 0) {
            return response()->json(['status' => 401, 'data' => []], 200);
        }
        return response()->json(['status' => 200, 'data' => $user], 200);
    }

    /**
     * Refund points for a viewer.
     */
    public function refundPoints(Viewer $viewer)
    {
        $viewer->refund = 2;
        $viewer->update();

        $user_points = UserPriceing::where('user_id', $viewer->user_id)->where('statues', 1)->first();
        $user_points->current_points = ($user_points->current_points + $viewer->points);
        $user_points->sub_points     = ($user_points->sub_points - $viewer->points);
        $user_points->update();

        return redirect()->route('sitemanagement.aqars.show', $viewer->aqar_id);
    }
}
