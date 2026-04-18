<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedistrictAPIRequest;
use App\Http\Requests\API\UpdatedistrictAPIRequest;
use App\Models\District;
use App\Repositories\districtRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;
 use Illuminate\Support\Facades\Validator;
/**
 * Class districtController
 * @package App\Http\Controllers\API
 */

class districtAPIController extends AppBaseController
{
    /** @var  districtRepository */
    private $districtRepository;

    public function __construct(districtRepository $districtRepo)
    {
        $this->districtRepository = $districtRepo;
    }

    /**
     * Display a listing of the district.
     * GET|HEAD /districts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $perPage = (int) $request->get('per_page', 0); // 0 = return all (reference data)
        if ($perPage > 0) {
            $districts = District::paginate($perPage);
        } else {
            $districts = District::all();
        }
        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully');
    }

public function getByGovernorate(Request $request)
{
    $validator = Validator::make($request->all(), [
        'govern_id' => 'required|integer|min:1|exists:governrate,id',
    ], [
        'govern_id.required' => 'حقل معرف المحافظة مطلوب.',
        'govern_id.integer'  => 'معرف المحافظة يجب أن يكون رقمًا صحيحًا.',
        'govern_id.min'      => 'معرف المحافظة يجب أن يكون أكبر من صفر.',
        'govern_id.exists'   => 'المحافظة المطلوبة غير موجودة في النظام.',
    ]);

    if ($validator->fails()) {
        return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
    }

    $districts = District::where('govern_id', $request->govern_id)->get();

    if ($districts->isEmpty()) {
        return $this->sendError('لا توجد أحياء لهذه المحافظة.', 404);
    }

    return $this->sendResponse($districts->toArray(), 'تم جلب الأحياء بنجاح.');
}

    /**
     * Store a newly created district in storage.
     * POST /districts
     *
     * @param CreatedistrictAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedistrictAPIRequest $request)
    {
        $input = $request->all();

        $district = $this->districtRepository->create($input);

        return $this->sendResponse($district->toArray(), 'District saved successfully');
    }

    /**
     * Display the specified district.
     * GET|HEAD /districts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        return $this->sendResponse($district->toArray(), 'District retrieved successfully');
    }

    /**
     * Update the specified district in storage.
     * PUT/PATCH /districts/{id}
     *
     * @param int $id
     * @param UpdatedistrictAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedistrictAPIRequest $request)
    {
        $input = $request->all();

        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district = $this->districtRepository->update($input, $id);

        return $this->sendResponse($district->toArray(), 'district updated successfully');
    }

    /**
     * Remove the specified district from storage.
     * DELETE /districts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district->delete();

        return $this->sendSuccess('District deleted successfully');
    }
}
