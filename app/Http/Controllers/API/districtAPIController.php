<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatedistrictAPIRequest;
use App\Http\Requests\API\UpdatedistrictAPIRequest;
use App\Models\district;
use App\Repositories\districtRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class districtController
 * @package App\Http\Controllers\API
 */

class districtAPIController extends AppBaseController
{
    /** @var  districtRepository */
    private $districtRepository;

    public function __construct(districtRepository $districtRepo)
    {
        $this->districtRepository = $districtRepo;
    }

    /**
     * Display a listing of the district.
     * GET|HEAD /districts
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $districts = $this->districtRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($districts->toArray(), 'Districts retrieved successfully');
    }

    /**
     * Store a newly created district in storage.
     * POST /districts
     *
     * @param CreatedistrictAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatedistrictAPIRequest $request)
    {
        $input = $request->all();

        $district = $this->districtRepository->create($input);

        return $this->sendResponse($district->toArray(), 'District saved successfully');
    }

    /**
     * Display the specified district.
     * GET|HEAD /districts/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        return $this->sendResponse($district->toArray(), 'District retrieved successfully');
    }

    /**
     * Update the specified district in storage.
     * PUT/PATCH /districts/{id}
     *
     * @param int $id
     * @param UpdatedistrictAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedistrictAPIRequest $request)
    {
        $input = $request->all();

        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district = $this->districtRepository->update($input, $id);

        return $this->sendResponse($district->toArray(), 'district updated successfully');
    }

    /**
     * Remove the specified district from storage.
     * DELETE /districts/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var district $district */
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            return $this->sendError('District not found');
        }

        $district->delete();

        return $this->sendSuccess('District deleted successfully');
    }
}
