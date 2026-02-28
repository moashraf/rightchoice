<?php

namespace App\Http\Controllers;

use App\DataTables\AdminPropertyTypeDataTable;
use App\Http\Requests\Createproperty_typeRequest;
use App\Http\Requests\Updateproperty_typeRequest;
use App\Repositories\property_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\aqar_category;

class AdminPropertyTypeController extends AppBaseController
{
    /** @var property_typeRepository */
    private $propertyTypeRepository;

    public function __construct(property_typeRepository $propertyTypeRepo)
    {
        $this->propertyTypeRepository = $propertyTypeRepo;
        $this->middleware('adminfCheckAdmin');
    }

    public function index(AdminPropertyTypeDataTable $propertyTypeDataTable)
    {
        return $propertyTypeDataTable->render('admin_property_types.index');
    }

    public function create()
    {
        $category = aqar_category::pluck('category_name', 'id');
        return view('admin_property_types.create', compact('category'));
    }

    public function store(Createproperty_typeRequest $request)
    {
        $input = $request->all();
        $propertyType = $this->propertyTypeRepository->create($input);

        Flash::success('تم حفظ نوع العقار بنجاح.');
        return redirect(route('sitemanagement.propertyTypes.index'));
    }

    public function show($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('نوع العقار غير موجود');
            return redirect(route('sitemanagement.propertyTypes.index'));
        }

        $category = aqar_category::pluck('category_name', 'id');
        return view('admin_property_types.show', compact('category'))->with('propertyType', $propertyType);
    }

    public function edit($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('نوع العقار غير موجود');
            return redirect(route('sitemanagement.propertyTypes.index'));
        }

        $category = aqar_category::pluck('category_name', 'id');
        return view('admin_property_types.edit', compact('category'))->with('propertyType', $propertyType);
    }

    public function update($id, Updateproperty_typeRequest $request)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('نوع العقار غير موجود');
            return redirect(route('sitemanagement.propertyTypes.index'));
        }

        $propertyType = $this->propertyTypeRepository->update($request->all(), $id);

        Flash::success('تم تحديث نوع العقار بنجاح.');
        return redirect(route('sitemanagement.propertyTypes.index'));
    }

    public function destroy($id)
    {
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            Flash::error('نوع العقار غير موجود');
            return redirect(route('sitemanagement.propertyTypes.index'));
        }

        $this->propertyTypeRepository->delete($id);

        Flash::success('تم حذف نوع العقار بنجاح.');
        return redirect(route('sitemanagement.propertyTypes.index'));
    }
}
