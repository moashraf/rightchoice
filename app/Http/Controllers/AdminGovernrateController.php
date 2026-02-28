<?php

namespace App\Http\Controllers;

use App\DataTables\AdminGovernrateDataTable;
use App\Http\Requests\CreategovernrateRequest;
use App\Http\Requests\UpdategovernrateRequest;
use App\Repositories\governrateRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminGovernrateController extends AppBaseController
{
    /** @var governrateRepository */
    private $governrateRepository;

    public function __construct(governrateRepository $governrateRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->governrateRepository = $governrateRepo;
    }

    public function index(AdminGovernrateDataTable $governrateDataTable)
    {
        return $governrateDataTable->render('admin_governrates.index');
    }

    public function create()
    {
        return view('admin_governrates.create');
    }

    public function store(CreategovernrateRequest $request)
    {
        $this->governrateRepository->create($request->all());

        Flash::success('تم حفظ المحافظة بنجاح.');

        return redirect(route('sitemanagement.governrates.index'));
    }

    public function show($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('المحافظة غير موجودة');
            return redirect(route('sitemanagement.governrates.index'));
        }

        return view('admin_governrates.show')->with('governrate', $governrate);
    }

    public function edit($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('المحافظة غير موجودة');
            return redirect(route('sitemanagement.governrates.index'));
        }

        return view('admin_governrates.edit')->with('governrate', $governrate);
    }

    public function update($id, UpdategovernrateRequest $request)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('المحافظة غير موجودة');
            return redirect(route('sitemanagement.governrates.index'));
        }

        $this->governrateRepository->update($request->all(), $id);

        Flash::success('تم تحديث المحافظة بنجاح.');

        return redirect(route('sitemanagement.governrates.index'));
    }

    public function destroy($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('المحافظة غير موجودة');
            return redirect(route('sitemanagement.governrates.index'));
        }

        $this->governrateRepository->delete($id);

        Flash::success('تم حذف المحافظة بنجاح.');

        return redirect(route('sitemanagement.governrates.index'));
    }
}
