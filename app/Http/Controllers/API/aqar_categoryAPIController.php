<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createaqar_categoryAPIRequest;
use App\Http\Requests\API\Updateaqar_categoryAPIRequest;
use App\Models\aqar_category;
use App\Repositories\aqar_categoryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;

class aqar_categoryAPIController extends AppBaseController
{
    private $aqarCategoryRepository;

    public function __construct(aqar_categoryRepository $aqarCategoryRepo)
    {
        $this->aqarCategoryRepository = $aqarCategoryRepo;
    }

    /** GET /api/aqar_categories */
    public function index(Request $request): JsonResponse
    {
        $items = $this->aqarCategoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse($items->toArray(), 'Aqar Categories retrieved successfully');
    }

    /** POST /api/aqar_categories */
    public function store(Createaqar_categoryAPIRequest $request): JsonResponse
    {
        $item = $this->aqarCategoryRepository->create($request->all());
        return $this->sendResponse($item->toArray(), 'Aqar Category saved successfully');
    }

    /** GET /api/aqar_categories/{id} */
    public function show($id): JsonResponse
    {
        $item = $this->aqarCategoryRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Category not found');
        }
        return $this->sendResponse($item->toArray(), 'Aqar Category retrieved successfully');
    }

    /** PUT /api/aqar_categories/{id} */
    public function update($id, Updateaqar_categoryAPIRequest $request): JsonResponse
    {
        $item = $this->aqarCategoryRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Category not found');
        }
        $item = $this->aqarCategoryRepository->update($request->all(), $id);
        return $this->sendResponse($item->toArray(), 'Aqar Category updated successfully');
    }

    /** DELETE /api/aqar_categories/{id} */
    public function destroy($id): JsonResponse
    {
        $item = $this->aqarCategoryRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Category not found');
        }
        $item->delete();
        return $this->sendSuccess('Aqar Category deleted successfully');
    }
}
