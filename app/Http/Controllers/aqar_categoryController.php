<?php

namespace App\Http\Controllers;

use App\DataTables\aqar_categoryDataTable;
use App\Http\Requests;
use App\Http\Requests\Createaqar_categoryRequest;
use App\Http\Requests\Updateaqar_categoryRequest;
use App\Models\aqar_category;
use App\Models\offer_type;
use App\Repositories\aqar_categoryRepository;
use App\Services\ModelService;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class aqar_categoryController extends AppBaseController
{
    /** @var  aqar_categoryRepository */
    private $aqarCategoryRepository;

    public function __construct(aqar_categoryRepository $aqarCategoryRepo)
    {
        $this->aqarCategoryRepository = $aqarCategoryRepo;
    }

    /**
     * Display a listing of the aqar_category.
     *
     * @param aqar_categoryDataTable $aqarCategoryDataTable
     * @return Response
     */
    public function index(Request $request)
    {
        $aqar_categories = aqar_category::query();
        $aqar_categories = ModelService::filter_search($aqar_categories,'category_name',$request);

        return view('aqar_categories.index',compact('aqar_categories'));
    }

    /**
     * Show the form for creating a new aqar_category.
     *
     * @return Response
     */
    public function create()
    {
        return view('aqar_categories.create');
    }

    /**
     * Store a newly created aqar_category in storage.
     *
     * @param Createaqar_categoryRequest $request
     *
     * @return Response
     */
    public function store(Createaqar_categoryRequest $request)
    {
        $input = $request->all();

        $aqarCategory = $this->aqarCategoryRepository->create($input);

        Flash::success('Aqar Category saved successfully.');

        return redirect(route('aqarCategories.index'));
    }

    /**
     * Display the specified aqar_category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('Aqar Category not found');

            return redirect(route('aqarCategories.index'));
        }

        return view('aqar_categories.show')->with('aqarCategory', $aqarCategory);
    }

    /**
     * Show the form for editing the specified aqar_category.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('Aqar Category not found');

            return redirect(route('aqarCategories.index'));
        }

        return view('aqar_categories.edit')->with('aqarCategory', $aqarCategory);
    }

    /**
     * Update the specified aqar_category in storage.
     *
     * @param  int              $id
     * @param Updateaqar_categoryRequest $request
     *
     * @return Response
     */
    public function update($id, Updateaqar_categoryRequest $request)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('Aqar Category not found');

            return redirect(route('aqarCategories.index'));
        }

        $aqarCategory = $this->aqarCategoryRepository->update($request->all(), $id);

        Flash::success('Aqar Category updated successfully.');

        return redirect(route('aqarCategories.index'));
    }

    /**
     * Remove the specified aqar_category from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            Flash::error('Aqar Category not found');

            return redirect(route('aqarCategories.index'));
        }

        $this->aqarCategoryRepository->delete($id);

        Flash::success('Aqar Category deleted successfully.');

        return redirect(route('aqarCategories.index'));
    }
}
