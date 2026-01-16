<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateComplaintsAPIRequest;
use App\Http\Requests\API\UpdateComplaintsAPIRequest;
use App\Models\Complaints;
use App\Repositories\ComplaintsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ComplaintsController
 * @package App\Http\Controllers\API
 */

class ComplaintsAPIController extends AppBaseController
{
    /** @var  ComplaintsRepository */
    private $complaintsRepository;

    public function __construct(ComplaintsRepository $complaintsRepo)
    {
        $this->complaintsRepository = $complaintsRepo;
    }

    /**
     * Display a listing of the Complaints.
     * GET|HEAD /complaints
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $complaints = $this->complaintsRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($complaints->toArray(), 'Complaints retrieved successfully');
    }

    /**
     * Store a newly created Complaints in storage.
     * POST /complaints
     *
     * @param CreateComplaintsAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateComplaintsAPIRequest $request)
    {
        $input = $request->all();

        $complaints = $this->complaintsRepository->create($input);

        return $this->sendResponse($complaints->toArray(), 'Complaints saved successfully');
    }

    /**
     * Display the specified Complaints.
     * GET|HEAD /complaints/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Complaints $complaints */
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            return $this->sendError('Complaints not found');
        }

        return $this->sendResponse($complaints->toArray(), 'Complaints retrieved successfully');
    }

    /**
     * Update the specified Complaints in storage.
     * PUT/PATCH /complaints/{id}
     *
     * @param int $id
     * @param UpdateComplaintsAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateComplaintsAPIRequest $request)
    {
        $input = $request->all();

        /** @var Complaints $complaints */
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            return $this->sendError('Complaints not found');
        }

        $complaints = $this->complaintsRepository->update($input, $id);

        return $this->sendResponse($complaints->toArray(), 'Complaints updated successfully');
    }

    /**
     * Remove the specified Complaints from storage.
     * DELETE /complaints/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Complaints $complaints */
        $complaints = $this->complaintsRepository->find($id);

        if (empty($complaints)) {
            return $this->sendError('Complaints not found');
        }

        $complaints->delete();

        return $this->sendSuccess('Complaints deleted successfully');
    }
}
