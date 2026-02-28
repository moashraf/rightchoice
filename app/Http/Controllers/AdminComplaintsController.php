<?php

namespace App\Http\Controllers;

use App\DataTables\AdminComplaintsDataTable;
use App\Http\Requests\CreateComplaintsRequest;
use App\Http\Requests\UpdateComplaintsRequest;
use App\Repositories\ComplaintsRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
use App\Models\aqar;

class AdminComplaintsController extends AppBaseController
{
    /** @var ComplaintsRepository */
    private $complaintsRepository;

    public function __construct(ComplaintsRepository $complaintsRepo)
    {
        $this->complaintsRepository = $complaintsRepo;
        $this->middleware('adminfCheckAdmin');
    }

    public function index(AdminComplaintsDataTable $complaintsDataTable)
    {
        return $complaintsDataTable->render('admin_complaints.index');
    }

    public function create()
    {
        $users  = User::pluck('name', 'id');
        $aqars  = aqar::pluck('title', 'id');
        return view('admin_complaints.create', compact('users', 'aqars'));
    }

    public function store(CreateComplaintsRequest $request)
    {
        $input = $request->all();
        $complaints = $this->complaintsRepository->create($input);

        Flash::success('تم حفظ الشكوى بنجاح.');
        return redirect(route('sitemanagement.complaints.index'));
    }

    public function show($id)
    {
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            Flash::error('الشكوى غير موجودة');
            return redirect(route('sitemanagement.complaints.index'));
        }

        $users = User::pluck('name', 'id');
        $aqars = aqar::pluck('title', 'id');
        return view('admin_complaints.show', compact('users', 'aqars'))->with('complaints', $complaints);
    }

    public function edit($id)
    {
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            Flash::error('الشكوى غير موجودة');
            return redirect(route('sitemanagement.complaints.index'));
        }

        $users = User::pluck('name', 'id');
        $aqars = aqar::pluck('title', 'id');
        return view('admin_complaints.edit', compact('users', 'aqars'))->with('complaints', $complaints);
    }

    public function update($id, UpdateComplaintsRequest $request)
    {
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            Flash::error('الشكوى غير موجودة');
            return redirect(route('sitemanagement.complaints.index'));
        }

        $complaints = $this->complaintsRepository->update($request->all(), $id);

        Flash::success('تم تحديث الشكوى بنجاح.');
        return redirect(route('sitemanagement.complaints.index'));
    }

    public function destroy($id)
    {
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            Flash::error('الشكوى غير موجودة');
            return redirect(route('sitemanagement.complaints.index'));
        }

        $this->complaintsRepository->delete($id);

        Flash::success('تم حذف الشكوى بنجاح.');
        return redirect(route('sitemanagement.complaints.index'));
    }
}
