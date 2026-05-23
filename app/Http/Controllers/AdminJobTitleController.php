<?php

namespace App\Http\Controllers;

use App\DataTables\AdminJobTitleDataTable;
use App\Http\Requests\CreateJobTitleRequest;
use App\Http\Requests\UpdateJobTitleRequest;
use App\Repositories\JobTitlesRepository;
use Flash;

class AdminJobTitleController extends AppBaseController
{
    /** @var JobTitlesRepository */
    private $jobTitlesRepository;

    public function __construct(JobTitlesRepository $jobTitlesRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->jobTitlesRepository = $jobTitlesRepo;
    }

    public function index(AdminJobTitleDataTable $jobTitleDataTable)
    {
        return $jobTitleDataTable->render('admin_job_titles.index');
    }

    public function create()
    {
        return view('admin_job_titles.create');
    }

    public function store(CreateJobTitleRequest $request)
    {
        $this->jobTitlesRepository->create($request->only(['Job_title', 'Job_title_en']));

        Flash::success('تم حفظ المسمى الوظيفي بنجاح.');

        return redirect(route('sitemanagement.jobTitles.index'));
    }

    public function show($id)
    {
        $jobTitle = $this->jobTitlesRepository->find($id);

        if (empty($jobTitle)) {
            Flash::error('المسمى الوظيفي غير موجود');
            return redirect(route('sitemanagement.jobTitles.index'));
        }

        return view('admin_job_titles.show')->with('jobTitle', $jobTitle);
    }

    public function edit($id)
    {
        $jobTitle = $this->jobTitlesRepository->find($id);

        if (empty($jobTitle)) {
            Flash::error('المسمى الوظيفي غير موجود');
            return redirect(route('sitemanagement.jobTitles.index'));
        }

        return view('admin_job_titles.edit')->with('jobTitle', $jobTitle);
    }

    public function update($id, UpdateJobTitleRequest $request)
    {
        $jobTitle = $this->jobTitlesRepository->find($id);

        if (empty($jobTitle)) {
            Flash::error('المسمى الوظيفي غير موجود');
            return redirect(route('sitemanagement.jobTitles.index'));
        }

        $this->jobTitlesRepository->update($request->only(['Job_title', 'Job_title_en']), $id);

        Flash::success('تم تحديث المسمى الوظيفي بنجاح.');

        return redirect(route('sitemanagement.jobTitles.index'));
    }

    public function destroy($id)
    {
        $jobTitle = $this->jobTitlesRepository->find($id);

        if (empty($jobTitle)) {
            Flash::error('المسمى الوظيفي غير موجود');
            return redirect(route('sitemanagement.jobTitles.index'));
        }

        $this->jobTitlesRepository->delete($id);

        Flash::success('تم حذف المسمى الوظيفي بنجاح.');

        return redirect(route('sitemanagement.jobTitles.index'));
    }
}
