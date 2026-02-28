<?php

namespace App\Http\Controllers;

use App\DataTables\AdminCallTimeDataTable;
use App\Http\Requests\Createcall_timeRequest;
use App\Http\Requests\Updatecall_timeRequest;
use App\Repositories\call_timeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminCallTimeController extends AppBaseController
{
    /** @var call_timeRepository */
    private $callTimeRepository;

    public function __construct(call_timeRepository $callTimeRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->callTimeRepository = $callTimeRepo;
    }

    public function index(AdminCallTimeDataTable $callTimeDataTable)
    {
        return $callTimeDataTable->render('admin_call_times.index');
    }

    public function create()
    {
        return view('admin_call_times.create');
    }

    public function store(Createcall_timeRequest $request)
    {
        $this->callTimeRepository->create($request->all());

        Flash::success('تم حفظ وقت الاتصال بنجاح.');

        return redirect(route('sitemanagement.callTimes.index'));
    }

    public function show($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('وقت الاتصال غير موجود');
            return redirect(route('sitemanagement.callTimes.index'));
        }

        return view('admin_call_times.show')->with('callTime', $callTime);
    }

    public function edit($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('وقت الاتصال غير موجود');
            return redirect(route('sitemanagement.callTimes.index'));
        }

        return view('admin_call_times.edit')->with('callTime', $callTime);
    }

    public function update($id, Updatecall_timeRequest $request)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('وقت الاتصال غير موجود');
            return redirect(route('sitemanagement.callTimes.index'));
        }

        $this->callTimeRepository->update($request->all(), $id);

        Flash::success('تم تحديث وقت الاتصال بنجاح.');

        return redirect(route('sitemanagement.callTimes.index'));
    }

    public function destroy($id)
    {
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            Flash::error('وقت الاتصال غير موجود');
            return redirect(route('sitemanagement.callTimes.index'));
        }

        $this->callTimeRepository->delete($id);

        Flash::success('تم حذف وقت الاتصال بنجاح.');

        return redirect(route('sitemanagement.callTimes.index'));
    }
}
