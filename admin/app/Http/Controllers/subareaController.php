<?php

namespace App\Http\Controllers;

use App\DataTables\subareaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatesubareaRequest;
use App\Http\Requests\UpdatesubareaRequest;
use App\Repositories\subareaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class subareaController extends AppBaseController
{
    /** @var  subareaRepository */
    private $subareaRepository;

    public function __construct(subareaRepository $subareaRepo)
    {
        $this->subareaRepository = $subareaRepo;
    }

    /**
     * Display a listing of the subarea.
     *
     * @param subareaDataTable $subareaDataTable
     * @return Response
     */
    public function index(subareaDataTable $subareaDataTable)
    {
        return $subareaDataTable->render('subareas.index');
    }

    /**
     * Show the form for creating a new subarea.
     *
     * @return Response
     */
    public function create()
    {
        return view('subareas.create');
    }

    /**
     * Store a newly created subarea in storage.
     *
     * @param CreatesubareaRequest $request
     *
     * @return Response
     */
    public function store(CreatesubareaRequest $request)
    {
        $input = $request->all();

        $subarea = $this->subareaRepository->create($input);

        Flash::success('Subarea saved successfully.');

        return redirect(route('subareas.index'));
    }

    /**
     * Display the specified subarea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('Subarea not found');

            return redirect(route('subareas.index'));
        }

        return view('subareas.show')->with('subarea', $subarea);
    }

    /**
     * Show the form for editing the specified subarea.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('Subarea not found');

            return redirect(route('subareas.index'));
        }

        return view('subareas.edit')->with('subarea', $subarea);
    }

    /**
     * Update the specified subarea in storage.
     *
     * @param  int              $id
     * @param UpdatesubareaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatesubareaRequest $request)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('Subarea not found');

            return redirect(route('subareas.index'));
        }

        $subarea = $this->subareaRepository->update($request->all(), $id);

        Flash::success('Subarea updated successfully.');

        return redirect(route('subareas.index'));
    }

    /**
     * Remove the specified subarea from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $subarea = $this->subareaRepository->find($id);

        if (empty($subarea)) {
            Flash::error('Subarea not found');

            return redirect(route('subareas.index'));
        }

        $this->subareaRepository->delete($id);

        Flash::success('Subarea deleted successfully.');

        return redirect(route('subareas.index'));
    }
}
