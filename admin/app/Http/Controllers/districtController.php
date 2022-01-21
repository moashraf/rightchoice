<?php

namespace App\Http\Controllers;

use App\DataTables\districtDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatedistrictRequest;
use App\Http\Requests\UpdatedistrictRequest;
use App\Repositories\districtRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\governrate;
use Response;

class districtController extends AppBaseController
{
    /** @var  districtRepository */
    private $districtRepository;

    public function __construct(districtRepository $districtRepo)
    {
        $this->districtRepository = $districtRepo;
    }

    /**
     * Display a listing of the district.
     *
     * @param districtDataTable $districtDataTable
     * @return Response
     */
    public function index(districtDataTable $districtDataTable)
    {
        return $districtDataTable->render('districts.index');
    }

    /**
     * Show the form for creating a new district.
     *
     * @return Response
     */
    public function create()
    {
        $governrate   = governrate::pluck('governrate', 'id');
        return view('districts.create',compact('governrate'));
    }

    /**
     * Store a newly created district in storage.
     *
     * @param CreatedistrictRequest $request
     *
     * @return Response
     */
    public function store(CreatedistrictRequest $request)
    {
        $input = $request->all();

        $district = $this->districtRepository->create($input);

        Flash::success('District saved successfully.');

        return redirect(route('districts.index'));
    }

    /**
     * Display the specified district.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('District not found');

            return redirect(route('districts.index'));
        }

        $governrate   = governrate::pluck('governrate', 'id');
        return view('districts.show',compact('governrate'))->with('district', $district);
    }

    /**
     * Show the form for editing the specified district.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('District not found');

            return redirect(route('districts.index'));
        }

        $governrate   = governrate::pluck('governrate', 'id');
        return view('districts.edit',compact('governrate'))->with('district', $district);
    }

    /**
     * Update the specified district in storage.
     *
     * @param  int              $id
     * @param UpdatedistrictRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatedistrictRequest $request)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('District not found');

            return redirect(route('districts.index'));
        }

        $district = $this->districtRepository->update($request->all(), $id);

        Flash::success('District updated successfully.');

        return redirect(route('districts.index'));
    }

    /**
     * Remove the specified district from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $district = $this->districtRepository->find($id);

        if (empty($district)) {
            Flash::error('District not found');

            return redirect(route('districts.index'));
        }

        $this->districtRepository->delete($id);

        Flash::success('District deleted successfully.');

        return redirect(route('districts.index'));
    }
}
