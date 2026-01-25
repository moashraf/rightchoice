<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateaqarAPIRequest;
use App\Http\Requests\API\UpdateaqarAPIRequest;
use App\Models\aqar;
use App\Repositories\aqarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class aqarController
 * @package App\Http\Controllers\API
 */

class aqarAPIController extends AppBaseController
{
    /** @var  aqarRepository */
    private $aqarRepository;

    public function __construct(aqarRepository $aqarRepo)
    {
        $this->aqarRepository = $aqarRepo;
    }

    /**
     * Display a listing of the aqar.
     * GET|HEAD /aqars
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $aqars = $this->aqarRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($aqars->toArray(), 'Aqars retrieved successfully');
    }

    /**
     * Store a newly created aqar in storage.
     * POST /aqars
     *
     * @param CreateaqarAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateaqarAPIRequest $request)
    {
        $input = $request->all();

        $aqar = $this->aqarRepository->create($input);

        return $this->sendResponse($aqar->toArray(), 'Aqar saved successfully');
    }

    /**
     * Display the specified aqar.
     * GET|HEAD /aqars/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var aqar $aqar */
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }

        return $this->sendResponse($aqar->toArray(), 'Aqar retrieved successfully');
    }

    /**
     * Update the specified aqar in storage.
     * PUT/PATCH /aqars/{id}
     *
     * @param int $id
     * @param UpdateaqarAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateaqarAPIRequest $request)
    {
        $input = $request->all();

        /** @var aqar $aqar */
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }

        $aqar = $this->aqarRepository->update($input, $id);

        return $this->sendResponse($aqar->toArray(), 'aqar updated successfully');
    }

    /**
     * Remove the specified aqar from storage.
     * DELETE /aqars/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var aqar $aqar */
        $aqar = $this->aqarRepository->find($id);

        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }

        $aqar->delete();

        return $this->sendSuccess('Aqar deleted successfully');
    }
}
