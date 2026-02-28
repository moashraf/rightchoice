<?php

namespace App\Http\Controllers;

use App\DataTables\AdminSubareaDataTable;
use App\Http\Requests\CreatesubareaRequest;
use App\Http\Requests\UpdatesubareaRequest;
use App\Repositories\subareaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminSubareaController extends AppBaseController
{
    /** @var subareaRepository */
    private $subareaRepository;

    public function __construct(subareaRepository $subareaRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->subareaRepository = $subareaRepo;
    }

    public function index(AdminSubareaDataTable $subareaDataTable)
    {
        return $subareaDataTable->render('admin_subareas.index');
    }

    public function create()
    {
        return view('admin_subareas.create');
    }

    public function store(CreatesubareaRequest $request)
    {
        $this->subareaRepository->create($request->all());

        Flash::success('تم حفظ المنطقة بنجاح.');

        return redirect(route('sitemanagement.subareas.index'));
    }

    public function show($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.subareas.index'));
        }

        return view('admin_subareas.show')->with('subarea', $subarea);
    }

    public function edit($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.subareas.index'));
        }

        return view('admin_subareas.edit')->with('subarea', $subarea);
    }

    public function update($id, UpdatesubareaRequest $request)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.subareas.index'));
        }

        $this->subareaRepository->update($request->all(), $id);

        Flash::success('تم تحديث المنطقة بنجاح.');

        return redirect(route('sitemanagement.subareas.index'));
    }

    public function destroy($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('المنطقة غير موجودة');
            return redirect(route('sitemanagement.subareas.index'));
        }

        $this->subareaRepository->delete($id);

        Flash::success('تم حذف المنطقة بنجاح.');

        return redirect(route('sitemanagement.subareas.index'));
    }
}
