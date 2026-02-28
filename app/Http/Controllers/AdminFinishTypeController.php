<?php

namespace App\Http\Controllers;

use App\DataTables\AdminFinishTypeDataTable;
use App\Http\Requests\Createfinish_typeRequest;
use App\Http\Requests\Updatefinish_typeRequest;
use App\Repositories\finish_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminFinishTypeController extends AppBaseController
{
    /** @var finish_typeRepository */
    private $finishTypeRepository;

    public function __construct(finish_typeRepository $finishTypeRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->finishTypeRepository = $finishTypeRepo;
    }

    public function index(AdminFinishTypeDataTable $finishTypeDataTable)
    {
        return $finishTypeDataTable->render('admin_finish_types.index');
    }

    public function create()
    {
        return view('admin_finish_types.create');
    }

    public function store(Createfinish_typeRequest $request)
    {
        $this->finishTypeRepository->create($request->all());

        Flash::success('تم حفظ نوع التشطيب بنجاح.');

        return redirect(route('sitemanagement.finishTypes.index'));
    }

    public function show($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('نوع التشطيب غير موجود');
            return redirect(route('sitemanagement.finishTypes.index'));
        }

        return view('admin_finish_types.show')->with('finishType', $finishType);
    }

    public function edit($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('نوع التشطيب غير موجود');
            return redirect(route('sitemanagement.finishTypes.index'));
        }

        return view('admin_finish_types.edit')->with('finishType', $finishType);
    }

    public function update($id, Updatefinish_typeRequest $request)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('نوع التشطيب غير موجود');
            return redirect(route('sitemanagement.finishTypes.index'));
        }

        $this->finishTypeRepository->update($request->all(), $id);

        Flash::success('تم تحديث نوع التشطيب بنجاح.');

        return redirect(route('sitemanagement.finishTypes.index'));
    }

    public function destroy($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('نوع التشطيب غير موجود');
            return redirect(route('sitemanagement.finishTypes.index'));
        }

        $this->finishTypeRepository->delete($id);

        Flash::success('تم حذف نوع التشطيب بنجاح.');

        return redirect(route('sitemanagement.finishTypes.index'));
    }
}
