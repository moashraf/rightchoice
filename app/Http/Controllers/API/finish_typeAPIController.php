<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createfinish_typeAPIRequest;
use App\Http\Requests\API\Updatefinish_typeAPIRequest;
use App\Models\finish_type;
use App\Repositories\finish_typeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class finish_typeController
 * @package App\Http\Controllers\API
 */

class finish_typeAPIController extends AppBaseController
{
    /** @var  finish_typeRepository */
    private $finishTypeRepository;

    public function __construct(finish_typeRepository $finishTypeRepo)
    {
        $this->finishTypeRepository = $finishTypeRepo;
    }

    /**
     * Display a listing of the finish_type.
     * GET|HEAD /finishTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $finishTypes = $this->finishTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($finishTypes->toArray(), 'Finish Types retrieved successfully');
    }

    /**
     * Store a newly created finish_type in storage.
     * POST /finishTypes
     *
     * @param Createfinish_typeAPIRequest $request
     *
     * @return Response
     */
    public function store(Createfinish_typeAPIRequest $request)
    {
        $input = $request->all();

        $finishType = $this->finishTypeRepository->create($input);

        return $this->sendResponse($finishType->toArray(), 'Finish Type saved successfully');
    }

    /**
     * Display the specified finish_type.
     * GET|HEAD /finishTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var finish_type $finishType */
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            return $this->sendError('Finish Type not found');
        }

        return $this->sendResponse($finishType->toArray(), 'Finish Type retrieved successfully');
    }

    /**
     * Update the specified finish_type in storage.
     * PUT/PATCH /finishTypes/{id}
     *
     * @param int $id
     * @param Updatefinish_typeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatefinish_typeAPIRequest $request)
    {
        $input = $request->all();

        /** @var finish_type $finishType */
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            return $this->sendError('Finish Type not found');
        }

        $finishType = $this->finishTypeRepository->update($input, $id);

        return $this->sendResponse($finishType->toArray(), 'finish_type updated successfully');
    }

    /**
     * Remove the specified finish_type from storage.
     * DELETE /finishTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var finish_type $finishType */
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            return $this->sendError('Finish Type not found');
        }

        $finishType->delete();

        return $this->sendSuccess('Finish Type deleted successfully');
    }
}
