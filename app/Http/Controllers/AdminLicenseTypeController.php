<?php

namespace App\Http\Controllers;

use App\DataTables\AdminLicenseTypeDataTable;
use App\Http\Requests\Createlicense_typeRequest;
use App\Http\Requests\Updatelicense_typeRequest;
use App\Repositories\license_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminLicenseTypeController extends AppBaseController
{
    /** @var license_typeRepository */
    private $licenseTypeRepository;

    public function __construct(license_typeRepository $licenseTypeRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->licenseTypeRepository = $licenseTypeRepo;
    }

    public function index(AdminLicenseTypeDataTable $licenseTypeDataTable)
    {
        return $licenseTypeDataTable->render('admin_license_types.index');
    }

    public function create()
    {
        return view('admin_license_types.create');
    }

    public function store(Createlicense_typeRequest $request)
    {
        $this->licenseTypeRepository->create($request->all());

        Flash::success('تم حفظ نوع الترخيص بنجاح.');

        return redirect(route('sitemanagement.licenseTypes.index'));
    }

    public function show($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('نوع الترخيص غير موجود');
            return redirect(route('sitemanagement.licenseTypes.index'));
        }

        return view('admin_license_types.show')->with('licenseType', $licenseType);
    }

    public function edit($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('نوع الترخيص غير موجود');
            return redirect(route('sitemanagement.licenseTypes.index'));
        }

        return view('admin_license_types.edit')->with('licenseType', $licenseType);
    }

    public function update($id, Updatelicense_typeRequest $request)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('نوع الترخيص غير موجود');
            return redirect(route('sitemanagement.licenseTypes.index'));
        }

        $this->licenseTypeRepository->update($request->all(), $id);

        Flash::success('تم تحديث نوع الترخيص بنجاح.');

        return redirect(route('sitemanagement.licenseTypes.index'));
    }

    public function destroy($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('نوع الترخيص غير موجود');
            return redirect(route('sitemanagement.licenseTypes.index'));
        }

        $this->licenseTypeRepository->delete($id);

        Flash::success('تم حذف نوع الترخيص بنجاح.');

        return redirect(route('sitemanagement.licenseTypes.index'));
    }
}
