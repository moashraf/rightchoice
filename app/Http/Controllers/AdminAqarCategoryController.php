<?php

namespace App\Http\Controllers;

use App\DataTables\AdminAqarCategoryDataTable;
use App\Http\Requests\Createaqar_categoryRequest;
use App\Http\Requests\Updateaqar_categoryRequest;
use App\Repositories\aqar_categoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminAqarCategoryController extends AppBaseController
{
    /** @var aqar_categoryRepository */
    private $aqarCategoryRepository;

    public function __construct(aqar_categoryRepository $aqarCategoryRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->aqarCategoryRepository = $aqarCategoryRepo;
    }

    public function index(AdminAqarCategoryDataTable $aqarCategoryDataTable)
    {
        return $aqarCategoryDataTable->render('admin_aqar_categories.index');
    }

    public function create()
    {
        return view('admin_aqar_categories.create');
    }

    public function store(Createaqar_categoryRequest $request)
    {
        $this->aqarCategoryRepository->create($request->all());

        Flash::success('تم حفظ الفئة بنجاح.');

        return redirect(route('sitemanagement.aqarCategories.index'));
    }

    public function show($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('الفئة غير موجودة');
            return redirect(route('sitemanagement.aqarCategories.index'));
        }

        return view('admin_aqar_categories.show')->with('aqarCategory', $aqarCategory);
    }

    public function edit($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('الفئة غير موجودة');
            return redirect(route('sitemanagement.aqarCategories.index'));
        }

        return view('admin_aqar_categories.edit')->with('aqarCategory', $aqarCategory);
    }

    public function update($id, Updateaqar_categoryRequest $request)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('الفئة غير موجودة');
            return redirect(route('sitemanagement.aqarCategories.index'));
        }

        $this->aqarCategoryRepository->update($request->all(), $id);

        Flash::success('تم تحديث الفئة بنجاح.');

        return redirect(route('sitemanagement.aqarCategories.index'));
    }

    public function destroy($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('الفئة غير موجودة');
            return redirect(route('sitemanagement.aqarCategories.index'));
        }

        $this->aqarCategoryRepository->delete($id);

        Flash::success('تم حذف الفئة بنجاح.');

        return redirect(route('sitemanagement.aqarCategories.index'));
    }
}
