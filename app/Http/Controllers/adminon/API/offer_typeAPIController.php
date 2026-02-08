<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createoffer_typeAPIRequest;
use App\Http\Requests\API\Updateoffer_typeAPIRequest;
use App\Models\offer_type;
use App\Repositories\offer_typeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class offer_typeController
 * @package App\Http\Controllers\API
 */

class offer_typeAPIController extends AppBaseController
{
    /** @var  offer_typeRepository */
    private $offerTypeRepository;

    public function __construct(offer_typeRepository $offerTypeRepo)
    {
        $this->offerTypeRepository = $offerTypeRepo;
    }

    /**
     * Display a listing of the offer_type.
     * GET|HEAD /offerTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $offerTypes = $this->offerTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($offerTypes->toArray(), 'Offer Types retrieved successfully');
    }

    /**
     * Store a newly created offer_type in storage.
     * POST /offerTypes
     *
     * @param Createoffer_typeAPIRequest $request
     *
     * @return Response
     */
    public function store(Createoffer_typeAPIRequest $request)
    {
        $input = $request->all();

        $offerType = $this->offerTypeRepository->create($input);

        return $this->sendResponse($offerType->toArray(), 'Offer Type saved successfully');
    }

    /**
     * Display the specified offer_type.
     * GET|HEAD /offerTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var offer_type $offerType */
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            return $this->sendError('Offer Type not found');
        }

        return $this->sendResponse($offerType->toArray(), 'Offer Type retrieved successfully');
    }

    /**
     * Update the specified offer_type in storage.
     * PUT/PATCH /offerTypes/{id}
     *
     * @param int $id
     * @param Updateoffer_typeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updateoffer_typeAPIRequest $request)
    {
        $input = $request->all();

        /** @var offer_type $offerType */
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            return $this->sendError('Offer Type not found');
        }

        $offerType = $this->offerTypeRepository->update($input, $id);

        return $this->sendResponse($offerType->toArray(), 'offer_type updated successfully');
    }

    /**
     * Remove the specified offer_type from storage.
     * DELETE /offerTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var offer_type $offerType */
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            return $this->sendError('Offer Type not found');
        }

        $offerType->delete();

        return $this->sendSuccess('Offer Type deleted successfully');
    }
}
