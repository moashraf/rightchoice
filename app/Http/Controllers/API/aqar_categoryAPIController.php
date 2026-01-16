<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createaqar_categoryAPIRequest;
use App\Http\Requests\API\Updateaqar_categoryAPIRequest;
use App\Models\aqar_category;
use App\Repositories\aqar_categoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class aqar_categoryController
 * @package App\Http\Controllers\API
 */

class aqar_categoryAPIController extends AppBaseController
{
    /** @var  aqar_categoryRepository */
    private $aqarCategoryRepository;

    public function __construct(aqar_categoryRepository $aqarCategoryRepo)
    {
        $this->aqarCategoryRepository = $aqarCategoryRepo;
    }

    /**
     * Display a listing of the aqar_category.
     * GET|HEAD /aqarCategories
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $aqarCategories = $this->aqarCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($aqarCategories->toArray(), 'Aqar Categories retrieved successfully');
    }

    /**
     * Store a newly created aqar_category in storage.
     * POST /aqarCategories
     *
     * @param Createaqar_categoryAPIRequest $request
     *
     * @return Response
     */
    public function store(Createaqar_categoryAPIRequest $request)
    {
        $input = $request->all();

        $aqarCategory = $this->aqarCategoryRepository->create($input);

        return $this->sendResponse($aqarCategory->toArray(), 'Aqar Category saved successfully');
    }

    /**
     * Display the specified aqar_category.
     * GET|HEAD /aqarCategories/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var aqar_category $aqarCategory */
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            return $this->sendError('Aqar Category not found');
        }

        return $this->sendResponse($aqarCategory->toArray(), 'Aqar Category retrieved successfully');
    }

    /**
     * Update the specified aqar_category in storage.
     * PUT/PATCH /aqarCategories/{id}
     *
     * @param int $id
     * @param Updateaqar_categoryAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updateaqar_categoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var aqar_category $aqarCategory */
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            return $this->sendError('Aqar Category not found');
        }

        $aqarCategory = $this->aqarCategoryRepository->update($input, $id);

        return $this->sendResponse($aqarCategory->toArray(), 'aqar_category updated successfully');
    }

    /**
     * Remove the specified aqar_category from storage.
     * DELETE /aqarCategories/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var aqar_category $aqarCategory */
        $aqarCategory = $this->aqarCategoryRepository->find($id);

        if (empty($aqarCategory)) {
            return $this->sendError('Aqar Category not found');
        }

        $aqarCategory->delete();

        return $this->sendSuccess('Aqar Category deleted successfully');
    }
}
