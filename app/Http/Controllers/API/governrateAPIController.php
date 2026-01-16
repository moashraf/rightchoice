<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreategovernrateAPIRequest;
use App\Http\Requests\API\UpdategovernrateAPIRequest;
use App\Models\governrate;
use App\Repositories\governrateRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class governrateController
 * @package App\Http\Controllers\API
 */

class governrateAPIController extends AppBaseController
{
    /** @var  governrateRepository */
    private $governrateRepository;

    public function __construct(governrateRepository $governrateRepo)
    {
        $this->governrateRepository = $governrateRepo;
    }

    /**
     * Display a listing of the governrate.
     * GET|HEAD /governrates
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $governrates = $this->governrateRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($governrates->toArray(), 'Governrates retrieved successfully');
    }

    /**
     * Store a newly created governrate in storage.
     * POST /governrates
     *
     * @param CreategovernrateAPIRequest $request
     *
     * @return Response
     */
    public function store(CreategovernrateAPIRequest $request)
    {
        $input = $request->all();

        $governrate = $this->governrateRepository->create($input);

        return $this->sendResponse($governrate->toArray(), 'Governrate saved successfully');
    }

    /**
     * Display the specified governrate.
     * GET|HEAD /governrates/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var governrate $governrate */
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            return $this->sendError('Governrate not found');
        }

        return $this->sendResponse($governrate->toArray(), 'Governrate retrieved successfully');
    }

    /**
     * Update the specified governrate in storage.
     * PUT/PATCH /governrates/{id}
     *
     * @param int $id
     * @param UpdategovernrateAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategovernrateAPIRequest $request)
    {
        $input = $request->all();

        /** @var governrate $governrate */
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            return $this->sendError('Governrate not found');
        }

        $governrate = $this->governrateRepository->update($input, $id);

        return $this->sendResponse($governrate->toArray(), 'governrate updated successfully');
    }

    /**
     * Remove the specified governrate from storage.
     * DELETE /governrates/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var governrate $governrate */
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            return $this->sendError('Governrate not found');
        }

        $governrate->delete();

        return $this->sendSuccess('Governrate deleted successfully');
    }
}
