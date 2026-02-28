<?php

namespace App\Http\Controllers;

use App\DataTables\AdminPagesDataTable;
use App\Http\Requests\CreatePagesRequest;
use App\Http\Requests\UpdatePagesRequest;
use App\Repositories\PagesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminPagesController extends AppBaseController
{
    /** @var PagesRepository */
    private $pagesRepository;

    public function __construct(PagesRepository $pagesRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->pagesRepository = $pagesRepo;
    }

    public function index(AdminPagesDataTable $pagesDataTable)
    {
        return $pagesDataTable->render('admin_pages.index');
    }

    public function create()
    {
        return view('admin_pages.create');
    }

    public function store(CreatePagesRequest $request)
    {
        $input = $request->all();

        $this->pagesRepository->create($input);

        Flash::success('تم حفظ الصفحة بنجاح.');

        return redirect(route('sitemanagement.pages.index'));
    }

    public function show($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('الصفحة غير موجودة');
            return redirect(route('sitemanagement.pages.index'));
        }

        return view('admin_pages.show')->with('pages', $pages);
    }

    public function edit($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('الصفحة غير موجودة');
            return redirect(route('sitemanagement.pages.index'));
        }

        return view('admin_pages.edit')->with('pages', $pages);
    }

    public function update($id, UpdatePagesRequest $request)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('الصفحة غير موجودة');
            return redirect(route('sitemanagement.pages.index'));
        }

        $this->pagesRepository->update($request->all(), $id);

        Flash::success('تم تحديث الصفحة بنجاح.');

        return redirect(route('sitemanagement.pages.index'));
    }

    public function destroy($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('الصفحة غير موجودة');
            return redirect(route('sitemanagement.pages.index'));
        }

        $this->pagesRepository->delete($id);

        Flash::success('تم حذف الصفحة بنجاح.');

        return redirect(route('sitemanagement.pages.index'));
    }
}
