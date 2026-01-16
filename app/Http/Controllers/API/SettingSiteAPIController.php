<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSettingSiteAPIRequest;
use App\Http\Requests\API\UpdateSettingSiteAPIRequest;
use App\Models\SettingSite;
use App\Repositories\SettingSiteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SettingSiteController
 * @package App\Http\Controllers\API
 */

class SettingSiteAPIController extends AppBaseController
{
    /** @var  SettingSiteRepository */
    private $settingSiteRepository;

    public function __construct(SettingSiteRepository $settingSiteRepo)
    {
        $this->settingSiteRepository = $settingSiteRepo;
    }

    /**
     * Display a listing of the SettingSite.
     * GET|HEAD /settingSites
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $settingSites = $this->settingSiteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($settingSites->toArray(), 'Setting Sites retrieved successfully');
    }

    /**
     * Store a newly created SettingSite in storage.
     * POST /settingSites
     *
     * @param CreateSettingSiteAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSettingSiteAPIRequest $request)
    {
        $input = $request->all();

        $settingSite = $this->settingSiteRepository->create($input);

        return $this->sendResponse($settingSite->toArray(), 'Setting Site saved successfully');
    }

    /**
     * Display the specified SettingSite.
     * GET|HEAD /settingSites/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var SettingSite $settingSite */
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            return $this->sendError('Setting Site not found');
        }

        return $this->sendResponse($settingSite->toArray(), 'Setting Site retrieved successfully');
    }

    /**
     * Update the specified SettingSite in storage.
     * PUT/PATCH /settingSites/{id}
     *
     * @param int $id
     * @param UpdateSettingSiteAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingSiteAPIRequest $request)
    {
        $input = $request->all();

        /** @var SettingSite $settingSite */
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            return $this->sendError('Setting Site not found');
        }

        $settingSite = $this->settingSiteRepository->update($input, $id);

        return $this->sendResponse($settingSite->toArray(), 'SettingSite updated successfully');
    }

    /**
     * Remove the specified SettingSite from storage.
     * DELETE /settingSites/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var SettingSite $settingSite */
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            return $this->sendError('Setting Site not found');
        }

        $settingSite->delete();

        return $this->sendSuccess('Setting Site deleted successfully');
    }
}
