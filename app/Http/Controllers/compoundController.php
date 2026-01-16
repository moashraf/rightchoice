<?php

namespace App\Http\Controllers;

use App\DataTables\compoundDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatecompoundRequest;
use App\Http\Requests\UpdatecompoundRequest;
use App\Models\compound;
use App\Repositories\compoundRepository;
use App\Services\ModelService;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Response;

class compoundController extends AppBaseController
{
    /** @var  compoundRepository */
    private $compoundRepository;

    public function __construct(compoundRepository $compoundRepo)
    {
        $this->compoundRepository = $compoundRepo;
    }

    /**
     * Display a listing of the compound.
     *
     * @param compoundDataTable $compoundDataTable
     * @return Response
     */
    public function index(Request $request)
    {

        $compounds = compound::query();
        $compounds = ModelService::filter_search($compounds,'compound',$request);

        return view('compounds.index', compact('compounds'));
    }

    /**
     * Show the form for creating a new compound.
     *
     * @return Response
     */
    public function create()
    {
        return view('compounds.create');
    }

    /**
     * Store a newly created compound in storage.
     *
     * @param CreatecompoundRequest $request
     *
     * @return Response
     */
    public function store(CreatecompoundRequest $request)
    {
        $input = $request->all();

        $compound = $this->compoundRepository->create($input);

        Flash::success('Compound saved successfully.');

        return redirect(route('compounds.index'));
    }

    /**
     * Display the specified compound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('Compound not found');

            return redirect(route('compounds.index'));
        }

        return view('compounds.show')->with('compound', $compound);
    }

    /**
     * Show the form for editing the specified compound.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('Compound not found');

            return redirect(route('compounds.index'));
        }

        return view('compounds.edit')->with('compound', $compound);
    }

    /**
     * Update the specified compound in storage.
     *
     * @param  int              $id
     * @param UpdatecompoundRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatecompoundRequest $request)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('Compound not found');

            return redirect(route('compounds.index'));
        }

        $compound = $this->compoundRepository->update($request->all(), $id);

        Flash::success('Compound updated successfully.');

        return redirect(route('compounds.index'));
    }

    /**
     * Remove the specified compound from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $compound = $this->compoundRepository->find($id);

        if (empty($compound)) {
            Flash::error('Compound not found');

            return redirect(route('compounds.index'));
        }

        $this->compoundRepository->delete($id);

        Flash::success('Compound deleted successfully.');

        return redirect(route('compounds.index'));
    }
}
