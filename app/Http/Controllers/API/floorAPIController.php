<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatefloorAPIRequest;
use App\Http\Requests\API\UpdatefloorAPIRequest;
use App\Models\floor;
use App\Repositories\floorRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class floorController
 * @package App\Http\Controllers\API
 */

class floorAPIController extends AppBaseController
{
    /** @var  floorRepository */
    private $floorRepository;

    public function __construct(floorRepository $floorRepo)
    {
        $this->floorRepository = $floorRepo;
    }

    /**
     * Display a listing of the floor.
     * GET|HEAD /floors
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $floors = $this->floorRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($floors->toArray(), 'Floors retrieved successfully');
    }

    /**
     * Store a newly created floor in storage.
     * POST /floors
     *
     * @param CreatefloorAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatefloorAPIRequest $request)
    {
        $input = $request->all();

        $floor = $this->floorRepository->create($input);

        return $this->sendResponse($floor->toArray(), 'Floor saved successfully');
    }

    /**
     * Display the specified floor.
     * GET|HEAD /floors/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var floor $floor */
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            return $this->sendError('Floor not found');
        }

        return $this->sendResponse($floor->toArray(), 'Floor retrieved successfully');
    }

    /**
     * Update the specified floor in storage.
     * PUT/PATCH /floors/{id}
     *
     * @param int $id
     * @param UpdatefloorAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatefloorAPIRequest $request)
    {
        $input = $request->all();

        /** @var floor $floor */
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            return $this->sendError('Floor not found');
        }

        $floor = $this->floorRepository->update($input, $id);

        return $this->sendResponse($floor->toArray(), 'floor updated successfully');
    }

    /**
     * Remove the specified floor from storage.
     * DELETE /floors/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var floor $floor */
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            return $this->sendError('Floor not found');
        }

        $floor->delete();

        return $this->sendSuccess('Floor deleted successfully');
    }
}
