<?php

namespace App\Http\Controllers;

use App\DataTables\offer_typeDataTable;
use App\Http\Requests;
use App\Http\Requests\Createoffer_typeRequest;
use App\Http\Requests\Updateoffer_typeRequest;
use App\Models\offer_type;
use App\Repositories\offer_typeRepository;
use App\Services\ModelService;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class offer_typeController extends AppBaseController
{
    /** @var  offer_typeRepository */
    private $offerTypeRepository;

    public function __construct(offer_typeRepository $offerTypeRepo)
    {
        $this->offerTypeRepository = $offerTypeRepo;
    }

    /**
     * Display a listing of the offer_type.
     *
     * @param offer_typeDataTable $offerTypeDataTable
     * @return Response
     */
    public function index(Request $request )
    {
        $offer_types = offer_type::query();
        $offer_types = ModelService::filter_search($offer_types,'type_offer');

        return view('offer_types.index',compact('offer_types'));
    }

    /**
     * Show the form for creating a new offer_type.
     *
     * @return Response
     */
    public function create()
    {
        return view('offer_types.create');
    }

    /**
     * Store a newly created offer_type in storage.
     *
     * @param Createoffer_typeRequest $request
     *
     * @return Response
     */
    public function store(Createoffer_typeRequest $request)
    {
        $input = $request->all();

        $offerType = $this->offerTypeRepository->create($input);

        Flash::success('Offer Type saved successfully.');

        return redirect(route('offerTypes.index'));
    }

    /**
     * Display the specified offer_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('Offer Type not found');

            return redirect(route('offerTypes.index'));
        }

        return view('offer_types.show')->with('offerType', $offerType);
    }

    /**
     * Show the form for editing the specified offer_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('Offer Type not found');

            return redirect(route('offerTypes.index'));
        }

        return view('offer_types.edit')->with('offerType', $offerType);
    }

    /**
     * Update the specified offer_type in storage.
     *
     * @param  int              $id
     * @param Updateoffer_typeRequest $request
     *
     * @return Response
     */
    public function update($id, Updateoffer_typeRequest $request)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('Offer Type not found');

            return redirect(route('offerTypes.index'));
        }

        $offerType = $this->offerTypeRepository->update($request->all(), $id);

        Flash::success('Offer Type updated successfully.');

        return redirect(route('offerTypes.index'));
    }

    /**
     * Remove the specified offer_type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('Offer Type not found');

            return redirect(route('offerTypes.index'));
        }

        $this->offerTypeRepository->delete($id);

        Flash::success('Offer Type deleted successfully.');

        return redirect(route('offerTypes.index'));
    }
}
