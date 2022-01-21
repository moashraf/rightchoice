<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatesubareaAPIRequest;
use App\Http\Requests\API\UpdatesubareaAPIRequest;
use App\Models\subarea;
use App\Repositories\subareaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class subareaController
 * @package App\Http\Controllers\API
 */

class subareaAPIController extends AppBaseController
{
    /** @var  subareaRepository */
    private $subareaRepository;

    public function __construct(subareaRepository $subareaRepo)
    {
        $this->subareaRepository = $subareaRepo;
    }

    /**
     * Display a listing of the subarea.
     * GET|HEAD /subareas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $subareas = $this->subareaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($subareas->toArray(), 'Subareas retrieved successfully');
    }

    /**
     * Store a newly created subarea in storage.
     * POST /subareas
     *
     * @param CreatesubareaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatesubareaAPIRequest $request)
    {
        $input = $request->all();

        $subarea = $this->subareaRepository->create($input);

        return $this->sendResponse($subarea->toArray(), 'Subarea saved successfully');
    }

    /**
     * Display the specified subarea.
     * GET|HEAD /subareas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var subarea $subarea */
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            return $this->sendError('Subarea not found');
        }

        return $this->sendResponse($subarea->toArray(), 'Subarea retrieved successfully');
    }

    /**
     * Update the specified subarea in storage.
     * PUT/PATCH /subareas/{id}
     *
     * @param int $id
     * @param UpdatesubareaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatesubareaAPIRequest $request)
    {
        $input = $request->all();

        /** @var subarea $subarea */
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            return $this->sendError('Subarea not found');
        }

        $subarea = $this->subareaRepository->update($input, $id);

        return $this->sendResponse($subarea->toArray(), 'subarea updated successfully');
    }

    /**
     * Remove the specified subarea from storage.
     * DELETE /subareas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var subarea $subarea */
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            return $this->sendError('Subarea not found');
        }

        $subarea->delete();

        return $this->sendSuccess('Subarea deleted successfully');
    }
}
