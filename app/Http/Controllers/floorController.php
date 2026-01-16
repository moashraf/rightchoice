<?php

namespace App\Http\Controllers;

use App\DataTables\floorDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatefloorRequest;
use App\Http\Requests\UpdatefloorRequest;
use App\Repositories\floorRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class floorController extends AppBaseController
{
    /** @var  floorRepository */
    private $floorRepository;

    public function __construct(floorRepository $floorRepo)
    {
        $this->floorRepository = $floorRepo;
    }

    /**
     * Display a listing of the floor.
     *
     * @param floorDataTable $floorDataTable
     * @return Response
     */
    public function index(floorDataTable $floorDataTable)
    {
        return $floorDataTable->render('floors.index');
    }

    /**
     * Show the form for creating a new floor.
     *
     * @return Response
     */
    public function create()
    {
        return view('floors.create');
    }

    /**
     * Store a newly created floor in storage.
     *
     * @param CreatefloorRequest $request
     *
     * @return Response
     */
    public function store(CreatefloorRequest $request)
    {
        $input = $request->all();

        $floor = $this->floorRepository->create($input);

        Flash::success('Floor saved successfully.');

        return redirect(route('floors.index'));
    }

    /**
     * Display the specified floor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('Floor not found');

            return redirect(route('floors.index'));
        }

        return view('floors.show')->with('floor', $floor);
    }

    /**
     * Show the form for editing the specified floor.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('Floor not found');

            return redirect(route('floors.index'));
        }

        return view('floors.edit')->with('floor', $floor);
    }

    /**
     * Update the specified floor in storage.
     *
     * @param  int              $id
     * @param UpdatefloorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatefloorRequest $request)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('Floor not found');

            return redirect(route('floors.index'));
        }

        $floor = $this->floorRepository->update($request->all(), $id);

        Flash::success('Floor updated successfully.');

        return redirect(route('floors.index'));
    }

    /**
     * Remove the specified floor from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $floor = $this->floorRepository->find($id);

        if (empty($floor)) {
            Flash::error('Floor not found');

            return redirect(route('floors.index'));
        }

        $this->floorRepository->delete($id);

        Flash::success('Floor deleted successfully.');

        return redirect(route('floors.index'));
    }
}
