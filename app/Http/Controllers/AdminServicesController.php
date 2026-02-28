<?php

namespace App\Http\Controllers;

use App\DataTables\AdminServicesDataTable;
use App\Http\Requests\CreateservicesRequest;
use App\Http\Requests\UpdateservicesRequest;
use App\Repositories\servicesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminServicesController extends AppBaseController
{
    /** @var servicesRepository */
    private $servicesRepository;

    public function __construct(servicesRepository $servicesRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->servicesRepository = $servicesRepo;
    }

    public function index(AdminServicesDataTable $servicesDataTable)
    {
        return $servicesDataTable->render('admin_services.index');
    }

    public function create()
    {
        return view('admin_services.create');
    }

    public function store(CreateservicesRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('serv_img')) {
            $input['image'] = _uploadFileWebNoCrop($request->serv_img, 'service/');
        }

        $this->servicesRepository->create($input);

        Flash::success('تم حفظ الخدمة بنجاح.');

        return redirect(route('sitemanagement.adminServices.index'));
    }

    public function show($id)
    {
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            Flash::error('الخدمة غير موجودة');
            return redirect(route('sitemanagement.adminServices.index'));
        }

        return view('admin_services.show')->with('services', $services);
    }

    public function edit($id)
    {
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            Flash::error('الخدمة غير موجودة');
            return redirect(route('sitemanagement.adminServices.index'));
        }

        return view('admin_services.edit')->with('services', $services);
    }

    public function update($id, UpdateservicesRequest $request)
    {
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            Flash::error('الخدمة غير موجودة');
            return redirect(route('sitemanagement.adminServices.index'));
        }

        $input = $request->all();

        if ($request->hasFile('serv_img')) {
            $input['image'] = _uploadFileWebNoCrop($request->serv_img, 'service/');
        } else {
            $input['image'] = $services->image;
        }

        $this->servicesRepository->update($input, $id);

        Flash::success('تم تحديث الخدمة بنجاح.');

        return redirect(route('sitemanagement.adminServices.index'));
    }

    public function destroy($id)
    {
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            Flash::error('الخدمة غير موجودة');
            return redirect(route('sitemanagement.adminServices.index'));
        }

        $this->servicesRepository->delete($id);

        Flash::success('تم حذف الخدمة بنجاح.');

        return redirect(route('sitemanagement.adminServices.index'));
    }
}
