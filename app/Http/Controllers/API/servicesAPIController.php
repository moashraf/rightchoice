<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateservicesAPIRequest;
use App\Http\Requests\API\UpdateservicesAPIRequest;
use App\Models\services;
use App\Repositories\servicesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class servicesController
 * @package App\Http\Controllers\API
 */

class servicesAPIController extends AppBaseController
{
    /** @var  servicesRepository */
    private $servicesRepository;

    public function __construct(servicesRepository $servicesRepo)
    {
        $this->servicesRepository = $servicesRepo;
    }

    /**
     * Display a listing of the services.
     * GET|HEAD /services
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $services = $this->servicesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     * Store a newly created services in storage.
     * POST /services
     *
     * @param CreateservicesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateservicesAPIRequest $request)
    {
        $input = $request->all();

        $services = $this->servicesRepository->create($input);

        return $this->sendResponse($services->toArray(), 'Services saved successfully');
    }

    /**
     * Display the specified services.
     * GET|HEAD /services/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        return $this->sendResponse($services->toArray(), 'Services retrieved successfully');
    }

    /**
     * Update the specified services in storage.
     * PUT/PATCH /services/{id}
     *
     * @param int $id
     * @param UpdateservicesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateservicesAPIRequest $request)
    {
        $input = $request->all();

        /** @var services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        $services = $this->servicesRepository->update($input, $id);

        return $this->sendResponse($services->toArray(), 'services updated successfully');
    }

    /**
     * Remove the specified services from storage.
     * DELETE /services/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var services $services */
        $services = $this->servicesRepository->find($id);

        if (empty($services)) {
            return $this->sendError('Services not found');
        }

        $services->delete();

        return $this->sendSuccess('Services deleted successfully');
    }
}
