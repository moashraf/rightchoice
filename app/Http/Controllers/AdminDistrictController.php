<?php

namespace App\Http\Controllers;

use App\DataTables\AdminDistrictDataTable;
use App\Http\Requests\CreatedistrictRequest;
use App\Http\Requests\UpdatedistrictRequest;
use App\Repositories\districtRepository;
use App\Models\Governrate;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminDistrictController extends AppBaseController
{
    /** @var districtRepository */
    private $districtRepository;

    public function __construct(districtRepository $districtRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->districtRepository = $districtRepo;
    }

    public function index(AdminDistrictDataTable $districtDataTable)
    {
        return $districtDataTable->render('admin_districts.index');
    }

    public function create()
    {
        $governrate = Governrate::pluck('governrate', 'id');
        return view('admin_districts.create', compact('governrate'));
    }

    public function store(CreatedistrictRequest $request)
    {
        $this->districtRepository->create($request->all());

        Flash::success('تم حفظ المنطقة بنجاح.');

        return redirect(route('sitemanagement.districts.index'));
    }

    public function show($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.districts.index'));
        }

        return view('admin_districts.show')->with('district', $district);
    }

    public function edit($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.districts.index'));
        }

        $governrate = Governrate::pluck('governrate', 'id');
        return view('admin_districts.edit', compact('district', 'governrate'));
    }

    public function update($id, UpdatedistrictRequest $request)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.districts.index'));
        }

        $this->districtRepository->update($request->all(), $id);

        Flash::success('تم تحديث المنطقة بنجاح.');

        return redirect(route('sitemanagement.districts.index'));
    }

    public function destroy($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.districts.index'));
        }

        $this->districtRepository->delete($id);

        Flash::success('تم حذف المنطقة بنجاح.');

        return redirect(route('sitemanagement.districts.index'));
    }
}
