<?php

namespace App\Http\Controllers;

use App\DataTables\governrateDataTable;
use App\Http\Requests;
use App\Http\Requests\CreategovernrateRequest;
use App\Http\Requests\UpdategovernrateRequest;
use App\Repositories\governrateRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class governrateController extends AppBaseController
{
    /** @var  governrateRepository */
    private $governrateRepository;

    public function __construct(governrateRepository $governrateRepo)
    {
        $this->governrateRepository = $governrateRepo;
    }

    /**
     * Display a listing of the governrate.
     *
     * @param governrateDataTable $governrateDataTable
     * @return Response
     */
    public function index(governrateDataTable $governrateDataTable)
    {
        return $governrateDataTable->render('governrates.index');
    }

    /**
     * Show the form for creating a new governrate.
     *
     * @return Response
     */
    public function create()
    {
        return view('governrates.create');
    }

    /**
     * Store a newly created governrate in storage.
     *
     * @param CreategovernrateRequest $request
     *
     * @return Response
     */
    public function store(CreategovernrateRequest $request)
    {
        $input = $request->all();

        $governrate = $this->governrateRepository->create($input);

        Flash::success('Governrate saved successfully.');

        return redirect(route('governrates.index'));
    }

    /**
     * Display the specified governrate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('Governrate not found');

            return redirect(route('governrates.index'));
        }

        return view('governrates.show')->with('governrate', $governrate);
    }

    /**
     * Show the form for editing the specified governrate.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('Governrate not found');

            return redirect(route('governrates.index'));
        }

        return view('governrates.edit')->with('governrate', $governrate);
    }

    /**
     * Update the specified governrate in storage.
     *
     * @param  int              $id
     * @param UpdategovernrateRequest $request
     *
     * @return Response
     */
    public function update($id, UpdategovernrateRequest $request)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('Governrate not found');

            return redirect(route('governrates.index'));
        }

        $governrate = $this->governrateRepository->update($request->all(), $id);

        Flash::success('Governrate updated successfully.');

        return redirect(route('governrates.index'));
    }

    /**
     * Remove the specified governrate from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $governrate = $this->governrateRepository->find($id);

        if (empty($governrate)) {
            Flash::error('Governrate not found');

            return redirect(route('governrates.index'));
        }

        $this->governrateRepository->delete($id);

        Flash::success('Governrate deleted successfully.');

        return redirect(route('governrates.index'));
    }
}
