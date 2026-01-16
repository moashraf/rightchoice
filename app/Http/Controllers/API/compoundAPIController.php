<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatecompoundAPIRequest;
use App\Http\Requests\API\UpdatecompoundAPIRequest;
use App\Models\compound;
use App\Repositories\compoundRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class compoundController
 * @package App\Http\Controllers\API
 */

class compoundAPIController extends AppBaseController
{
    /** @var  compoundRepository */
    private $compoundRepository;

    public function __construct(compoundRepository $compoundRepo)
    {
        $this->compoundRepository = $compoundRepo;
    }

    /**
     * Display a listing of the compound.
     * GET|HEAD /compounds
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $compounds = $this->compoundRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($compounds->toArray(), 'Compounds retrieved successfully');
    }

    /**
     * Store a newly created compound in storage.
     * POST /compounds
     *
     * @param CreatecompoundAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatecompoundAPIRequest $request)
    {
        $input = $request->all();

        $compound = $this->compoundRepository->create($input);

        return $this->sendResponse($compound->toArray(), 'Compound saved successfully');
    }

    /**
     * Display the specified compound.
     * GET|HEAD /compounds/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var compound $compound */
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            return $this->sendError('Compound not found');
        }

        return $this->sendResponse($compound->toArray(), 'Compound retrieved successfully');
    }

    /**
     * Update the specified compound in storage.
     * PUT/PATCH /compounds/{id}
     *
     * @param int $id
     * @param UpdatecompoundAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecompoundAPIRequest $request)
    {
        $input = $request->all();

        /** @var compound $compound */
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            return $this->sendError('Compound not found');
        }

        $compound = $this->compoundRepository->update($input, $id);

        return $this->sendResponse($compound->toArray(), 'compound updated successfully');
    }

    /**
     * Remove the specified compound from storage.
     * DELETE /compounds/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var compound $compound */
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            return $this->sendError('Compound not found');
        }

        $compound->delete();

        return $this->sendSuccess('Compound deleted successfully');
    }
}
