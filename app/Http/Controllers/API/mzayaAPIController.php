<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatemzayaAPIRequest;
use App\Http\Requests\API\UpdatemzayaAPIRequest;
use App\Models\mzaya;
use App\Repositories\mzayaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class mzayaController
 * @package App\Http\Controllers\API
 */

class mzayaAPIController extends AppBaseController
{
    /** @var  mzayaRepository */
    private $mzayaRepository;

    public function __construct(mzayaRepository $mzayaRepo)
    {
        $this->mzayaRepository = $mzayaRepo;
    }

    /**
     * Display a listing of the mzaya.
     * GET|HEAD /mzayas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $mzayas = $this->mzayaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($mzayas->toArray(), 'Mzayas retrieved successfully');
    }

    /**
     * Store a newly created mzaya in storage.
     * POST /mzayas
     *
     * @param CreatemzayaAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatemzayaAPIRequest $request)
    {
        $input = $request->all();

        $mzaya = $this->mzayaRepository->create($input);

        return $this->sendResponse($mzaya->toArray(), 'Mzaya saved successfully');
    }

    /**
     * Display the specified mzaya.
     * GET|HEAD /mzayas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var mzaya $mzaya */
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            return $this->sendError('Mzaya not found');
        }

        return $this->sendResponse($mzaya->toArray(), 'Mzaya retrieved successfully');
    }

    /**
     * Update the specified mzaya in storage.
     * PUT/PATCH /mzayas/{id}
     *
     * @param int $id
     * @param UpdatemzayaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemzayaAPIRequest $request)
    {
        $input = $request->all();

        /** @var mzaya $mzaya */
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            return $this->sendError('Mzaya not found');
        }

        $mzaya = $this->mzayaRepository->update($input, $id);

        return $this->sendResponse($mzaya->toArray(), 'mzaya updated successfully');
    }

    /**
     * Remove the specified mzaya from storage.
     * DELETE /mzayas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var mzaya $mzaya */
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            return $this->sendError('Mzaya not found');
        }

        $mzaya->delete();

        return $this->sendSuccess('Mzaya deleted successfully');
    }
}
