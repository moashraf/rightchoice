<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateaqarAPIRequest;
use App\Http\Requests\API\UpdateaqarAPIRequest;
use App\Models\aqar;
use App\Repositories\aqarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

class aqarAPIController extends AppBaseController
{
    private $aqarRepository;

    public function __construct(aqarRepository $aqarRepo)
    {
        $this->aqarRepository = $aqarRepo;
    }

    public function index(Request $request)
    {
        $aqars = $this->aqarRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse($aqars->toArray(), 'Aqars retrieved successfully');
    }

    public function store(CreateaqarAPIRequest $request)
    {
        $aqar = $this->aqarRepository->create($request->all());
        return $this->sendResponse($aqar->toArray(), 'Aqar saved successfully');
    }

    public function show($id)
    {
        $aqar = $this->aqarRepository->find($id);
        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        return $this->sendResponse($aqar->toArray(), 'Aqar retrieved successfully');
    }

    public function update($id, UpdateaqarAPIRequest $request)
    {
        $aqar = $this->aqarRepository->find($id);
        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        $aqar = $this->aqarRepository->update($request->all(), $id);
        return $this->sendResponse($aqar->toArray(), 'Aqar updated successfully');
    }

    public function destroy($id)
    {
        $aqar = $this->aqarRepository->find($id);
        if (empty($aqar)) {
            return $this->sendError('Aqar not found');
        }
        $aqar->delete();
        return $this->sendSuccess('Aqar deleted successfully');
    }
}
