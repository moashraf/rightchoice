<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createproperty_typeAPIRequest;
use App\Http\Requests\API\Updateproperty_typeAPIRequest;
use App\Models\property_type;
use App\Repositories\property_typeRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\aqar_category;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class property_typeController
 * @package App\Http\Controllers\API
 */

class property_typeAPIController extends AppBaseController
{
    /** @var  property_typeRepository */
    private $propertyTypeRepository;

    public function __construct(property_typeRepository $propertyTypeRepo)
    {
        $this->propertyTypeRepository = $propertyTypeRepo;
    }

    /**
     * Display a listing of the property_type.
     * GET|HEAD /propertyTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $propertyTypes = $this->propertyTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($propertyTypes->toArray(), 'Property Types retrieved successfully');
    }


    /**
 * Display property types filtered by category ID.
 * GET /propertyTypes/by-category/{cat_id}
 *
 * @param int $cat_id
 * @return JsonResponse
 */
public function getByCategory($cat_id): JsonResponse
{
    if (!is_numeric($cat_id) || (int) $cat_id <= 0) {
        return $this->sendError('The category ID must be a valid positive integer.');
    }

    $category = aqar_category::find($cat_id);
    if (empty($category)) {
        return $this->sendError('Aqar Category not found.');
    }

    $propertyTypes = property_type::where('cat_id', $cat_id)->get();

    return $this->sendResponse(
        $propertyTypes->toArray(),
        'Property Types retrieved successfully by category ID.'
    );
}


    

    /**
     * Store a newly created property_type in storage.
     * POST /propertyTypes
     *
     * @param Createproperty_typeAPIRequest $request
     *
     * @return Response
     */
    public function store(Createproperty_typeAPIRequest $request)
    {
        $input = $request->all();

        $propertyType = $this->propertyTypeRepository->create($input);

        return $this->sendResponse($propertyType->toArray(), 'Property Type saved successfully');
    }

    /**
     * Display the specified property_type.
     * GET|HEAD /propertyTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var property_type $propertyType */
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            return $this->sendError('Property Type not found');
        }

        return $this->sendResponse($propertyType->toArray(), 'Property Type retrieved successfully');
    }

    /**
     * Update the specified property_type in storage.
     * PUT/PATCH /propertyTypes/{id}
     *
     * @param int $id
     * @param Updateproperty_typeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updateproperty_typeAPIRequest $request)
    {
        $input = $request->all();

        /** @var property_type $propertyType */
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            return $this->sendError('Property Type not found');
        }

        $propertyType = $this->propertyTypeRepository->update($input, $id);

        return $this->sendResponse($propertyType->toArray(), 'property_type updated successfully');
    }

    /**
     * Remove the specified property_type from storage.
     * DELETE /propertyTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var property_type $propertyType */
        $propertyType = $this->propertyTypeRepository->find($id);

        if (empty($propertyType)) {
            return $this->sendError('Property Type not found');
        }

        $propertyType->delete();

        return $this->sendSuccess('Property Type deleted successfully');
    }
}
