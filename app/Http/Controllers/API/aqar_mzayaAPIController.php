<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createaqar_mzayaAPIRequest;
use App\Http\Requests\API\Updateaqar_mzayaAPIRequest;
use App\Models\aqar_mzaya;
use App\Repositories\aqar_mzayaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class aqar_mzayaController
 * @package App\Http\Controllers\API
 */

class aqar_mzayaAPIController extends AppBaseController
{
    /** @var  aqar_mzayaRepository */
    private $aqarMzayaRepository;

    public function __construct(aqar_mzayaRepository $aqarMzayaRepo)
    {
        $this->aqarMzayaRepository = $aqarMzayaRepo;
    }

    /**
     * Display a listing of the aqar_mzaya.
     * GET|HEAD /aqarMzayas
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $aqarMzayas = $this->aqarMzayaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($aqarMzayas->toArray(), 'Aqar Mzayas retrieved successfully');
    }

    /**
     * Store a newly created aqar_mzaya in storage.
     * POST /aqarMzayas
     *
     * @param Createaqar_mzayaAPIRequest $request
     *
     * @return Response
     */
    public function store(Createaqar_mzayaAPIRequest $request)
    {
        $input = $request->all();

        $aqarMzaya = $this->aqarMzayaRepository->create($input);

        return $this->sendResponse($aqarMzaya->toArray(), 'Aqar Mzaya saved successfully');
    }

    /**
     * Display the specified aqar_mzaya.
     * GET|HEAD /aqarMzayas/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var aqar_mzaya $aqarMzaya */
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            return $this->sendError('Aqar Mzaya not found');
        }

        return $this->sendResponse($aqarMzaya->toArray(), 'Aqar Mzaya retrieved successfully');
    }

    /**
     * Update the specified aqar_mzaya in storage.
     * PUT/PATCH /aqarMzayas/{id}
     *
     * @param int $id
     * @param Updateaqar_mzayaAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updateaqar_mzayaAPIRequest $request)
    {
        $input = $request->all();

        /** @var aqar_mzaya $aqarMzaya */
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            return $this->sendError('Aqar Mzaya not found');
        }

        $aqarMzaya = $this->aqarMzayaRepository->update($input, $id);

        return $this->sendResponse($aqarMzaya->toArray(), 'aqar_mzaya updated successfully');
    }

    /**
     * Remove the specified aqar_mzaya from storage.
     * DELETE /aqarMzayas/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var aqar_mzaya $aqarMzaya */
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            return $this->sendError('Aqar Mzaya not found');
        }

        $aqarMzaya->delete();

        return $this->sendSuccess('Aqar Mzaya deleted successfully');
    }
}
