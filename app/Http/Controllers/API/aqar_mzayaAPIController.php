<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createaqar_mzayaAPIRequest;
use App\Http\Requests\API\Updateaqar_mzayaAPIRequest;
use App\Models\aqar_mzaya;
use App\Repositories\aqar_mzayaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class aqar_mzayaAPIController extends AppBaseController
{
    private $aqarMzayaRepository;

    public function __construct(aqar_mzayaRepository $aqarMzayaRepo)
    {
        $this->aqarMzayaRepository = $aqarMzayaRepo;
    }

    public function index(Request $request)
    {
        $items = $this->aqarMzayaRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse($items->toArray(), 'Aqar Mzayas retrieved successfully');
    }

    public function store(Createaqar_mzayaAPIRequest $request)
    {
        $item = $this->aqarMzayaRepository->create($request->all());
        return $this->sendResponse($item->toArray(), 'Aqar Mzaya saved successfully');
    }

    public function show($id)
    {
        $item = $this->aqarMzayaRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Mzaya not found');
        }
        return $this->sendResponse($item->toArray(), 'Aqar Mzaya retrieved successfully');
    }

    public function update($id, Updateaqar_mzayaAPIRequest $request)
    {
        $item = $this->aqarMzayaRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Mzaya not found');
        }
        $item = $this->aqarMzayaRepository->update($request->all(), $id);
        return $this->sendResponse($item->toArray(), 'Aqar Mzaya updated successfully');
    }

    public function destroy($id)
    {
        $item = $this->aqarMzayaRepository->find($id);
        if (empty($item)) {
            return $this->sendError('Aqar Mzaya not found');
        }
        $item->delete();
        return $this->sendSuccess('Aqar Mzaya deleted successfully');
    }
}
