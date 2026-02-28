<?php

namespace App\Http\Controllers;

use App\DataTables\AdminCompanyDataTable;
use App\Http\Requests\CreateCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Repositories\CompanyRepository;
use App\Models\Governrate;
use App\Models\District;
use App\Models\SubArea;
use App\Models\Service;
use App\Models\services;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminCompanyController extends AppBaseController
{
    /** @var CompanyRepository */
    private $companyRepository;

    public function __construct(CompanyRepository $companyRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->companyRepository = $companyRepo;
    }

    public function index(AdminCompanyDataTable $companyDataTable)
    {
        return $companyDataTable->render('admin_companies.index');
    }

    public function create()
    {
        $governrate = Governrate::pluck('governrate', 'id');
        $district   = District::pluck('district', 'id');
        $subarea    = SubArea::pluck('area', 'id');
        $service    = services::pluck('service', 'id');

        return view('admin_companies.create', compact('governrate', 'district', 'subarea', 'service'));
    }

    public function store(CreateCompanyRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('photo')) {
            $input['photo'] = _uploadFileWeb($request->photo, 'company/');
        }

        $this->companyRepository->create($input);

        Flash::success('تم حفظ الشركة بنجاح.');

        return redirect(route('sitemanagement.companies.index'));
    }

    public function show($id)
    {
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            Flash::error('الشركة غير موجودة');
            return redirect(route('sitemanagement.companies.index'));
        }

        return view('admin_companies.show')->with('company', $company);
    }

    public function edit($id)
    {
        $company    = $this->companyRepository->find($id);

        if (empty($company)) {
            Flash::error('الشركة غير موجودة');
            return redirect(route('sitemanagement.companies.index'));
        }

        $governrate = Governrate::pluck('governrate', 'id');
        $district   = District::pluck('district', 'id');
        $subarea    = SubArea::pluck('area', 'id');
        $service    = services::pluck('service', 'id');

        return view('admin_companies.edit', compact('governrate', 'district', 'subarea', 'service'))
            ->with('company', $company);
    }

    public function update($id, UpdateCompanyRequest $request)
    {
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            Flash::error('الشركة غير موجودة');
            return redirect(route('sitemanagement.companies.index'));
        }

        $input = $request->all();

        if ($request->hasFile('photo')) {
            $input['photo'] = _uploadFileWeb($request->photo, 'company/');
        }

        $this->companyRepository->update($input, $id);

        Flash::success('تم تحديث الشركة بنجاح.');

        return redirect(route('sitemanagement.companies.index'));
    }

    public function destroy($id)
    {
        $company = $this->companyRepository->find($id);

        if (empty($company)) {
            Flash::error('الشركة غير موجودة');
            return redirect(route('sitemanagement.companies.index'));
        }

        $this->companyRepository->delete($id);

        Flash::success('تم حذف الشركة بنجاح.');

        return redirect(route('sitemanagement.companies.index'));
    }
}
