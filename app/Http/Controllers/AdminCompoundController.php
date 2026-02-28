<?php

namespace App\Http\Controllers;

use App\DataTables\AdminCompoundDataTable;
use App\Http\Requests\CreatecompoundRequest;
use App\Http\Requests\UpdatecompoundRequest;
use App\Repositories\compoundRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminCompoundController extends AppBaseController
{
    /** @var compoundRepository */
    private $compoundRepository;

    public function __construct(compoundRepository $compoundRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->compoundRepository = $compoundRepo;
    }

    public function index(AdminCompoundDataTable $compoundDataTable)
    {
        return $compoundDataTable->render('admin_compounds.index');
    }

    public function create()
    {
        return view('admin_compounds.create');
    }

    public function store(CreatecompoundRequest $request)
    {
        $this->compoundRepository->create($request->all());

        Flash::success('تم حفظ الكمبوند بنجاح.');

        return redirect(route('sitemanagement.compounds.index'));
    }

    public function show($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('الكمبوند غير موجود');
            return redirect(route('sitemanagement.compounds.index'));
        }

        return view('admin_compounds.show')->with('compound', $compound);
    }

    public function edit($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('الكمبوند غير موجود');
            return redirect(route('sitemanagement.compounds.index'));
        }

        return view('admin_compounds.edit')->with('compound', $compound);
    }

    public function update($id, UpdatecompoundRequest $request)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('الكمبوند غير موجود');
            return redirect(route('sitemanagement.compounds.index'));
        }

        $this->compoundRepository->update($request->all(), $id);

        Flash::success('تم تحديث الكمبوند بنجاح.');

        return redirect(route('sitemanagement.compounds.index'));
    }

    public function destroy($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('الكمبوند غير موجود');
            return redirect(route('sitemanagement.compounds.index'));
        }

        $this->compoundRepository->delete($id);

        Flash::success('تم حذف الكمبوند بنجاح.');

        return redirect(route('sitemanagement.compounds.index'));
    }
}
