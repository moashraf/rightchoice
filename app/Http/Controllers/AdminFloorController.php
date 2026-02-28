<?php

namespace App\Http\Controllers;

use App\DataTables\AdminFloorDataTable;
use App\Http\Requests\CreatefloorRequest;
use App\Http\Requests\UpdatefloorRequest;
use App\Repositories\floorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminFloorController extends AppBaseController
{
    /** @var floorRepository */
    private $floorRepository;

    public function __construct(floorRepository $floorRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->floorRepository = $floorRepo;
    }

    public function index(AdminFloorDataTable $floorDataTable)
    {
        return $floorDataTable->render('admin_floors.index');
    }

    public function create()
    {
        return view('admin_floors.create');
    }

    public function store(CreatefloorRequest $request)
    {
        $this->floorRepository->create($request->all());

        Flash::success('تم حفظ الدور بنجاح.');

        return redirect(route('sitemanagement.floors.index'));
    }

    public function show($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('الدور غير موجود');
            return redirect(route('sitemanagement.floors.index'));
        }

        return view('admin_floors.show')->with('floor', $floor);
    }

    public function edit($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('الدور غير موجود');
            return redirect(route('sitemanagement.floors.index'));
        }

        return view('admin_floors.edit')->with('floor', $floor);
    }

    public function update($id, UpdatefloorRequest $request)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('الدور غير موجود');
            return redirect(route('sitemanagement.floors.index'));
        }

        $this->floorRepository->update($request->all(), $id);

        Flash::success('تم تحديث الدور بنجاح.');

        return redirect(route('sitemanagement.floors.index'));
    }

    public function destroy($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('الدور غير موجود');
            return redirect(route('sitemanagement.floors.index'));
        }

        $this->floorRepository->delete($id);

        Flash::success('تم حذف الدور بنجاح.');

        return redirect(route('sitemanagement.floors.index'));
    }
}
