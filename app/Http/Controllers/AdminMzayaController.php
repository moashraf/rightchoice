<?php

namespace App\Http\Controllers;

use App\DataTables\AdminMzayaDataTable;
use App\Http\Requests\CreatemzayaRequest;
use App\Http\Requests\UpdatemzayaRequest;
use App\Repositories\mzayaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminMzayaController extends AppBaseController
{
    /** @var mzayaRepository */
    private $mzayaRepository;

    public function __construct(mzayaRepository $mzayaRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->mzayaRepository = $mzayaRepo;
    }

    public function index(AdminMzayaDataTable $mzayaDataTable)
    {
        return $mzayaDataTable->render('admin_mzayas.index');
    }

    public function create()
    {
        return view('admin_mzayas.create');
    }

    public function store(CreatemzayaRequest $request)
    {
        $input = $request->all();

        if ($request->hasFile('img')) {
            $input['img_name'] = _uploadFileWeb($request->img, 'mzaya/');
        }

        $this->mzayaRepository->create($input);

        Flash::success('تم حفظ الميزة بنجاح.');

        return redirect(route('sitemanagement.mzayas.index'));
    }

    public function show($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('الميزة غير موجودة');
            return redirect(route('sitemanagement.mzayas.index'));
        }

        return view('admin_mzayas.show')->with('mzaya', $mzaya);
    }

    public function edit($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('الميزة غير موجودة');
            return redirect(route('sitemanagement.mzayas.index'));
        }

        return view('admin_mzayas.edit')->with('mzaya', $mzaya);
    }

    public function update($id, UpdatemzayaRequest $request)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('الميزة غير موجودة');
            return redirect(route('sitemanagement.mzayas.index'));
        }

        $input = $request->all();

        if ($request->hasFile('img')) {
            $input['img_name'] = _uploadFileWeb($request->img, 'mzaya/');
        } else {
            $input['img_name'] = $mzaya->img_name;
        }

        $this->mzayaRepository->update($input, $id);

        Flash::success('تم تحديث الميزة بنجاح.');

        return redirect(route('sitemanagement.mzayas.index'));
    }

    public function destroy($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('الميزة غير موجودة');
            return redirect(route('sitemanagement.mzayas.index'));
        }

        $this->mzayaRepository->delete($id);

        Flash::success('تم حذف الميزة بنجاح.');

        return redirect(route('sitemanagement.mzayas.index'));
    }
}
