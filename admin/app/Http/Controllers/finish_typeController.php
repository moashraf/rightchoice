<?php

namespace App\Http\Controllers;

use App\DataTables\finish_typeDataTable;
use App\Http\Requests;
use App\Http\Requests\Createfinish_typeRequest;
use App\Http\Requests\Updatefinish_typeRequest;
use App\Repositories\finish_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class finish_typeController extends AppBaseController
{
    /** @var  finish_typeRepository */
    private $finishTypeRepository;

    public function __construct(finish_typeRepository $finishTypeRepo)
    {
        $this->finishTypeRepository = $finishTypeRepo;
    }

    /**
     * Display a listing of the finish_type.
     *
     * @param finish_typeDataTable $finishTypeDataTable
     * @return Response
     */
    public function index(finish_typeDataTable $finishTypeDataTable)
    {
        return $finishTypeDataTable->render('finish_types.index');
    }

    /**
     * Show the form for creating a new finish_type.
     *
     * @return Response
     */
    public function create()
    {
        return view('finish_types.create');
    }

    /**
     * Store a newly created finish_type in storage.
     *
     * @param Createfinish_typeRequest $request
     *
     * @return Response
     */
    public function store(Createfinish_typeRequest $request)
    {
        $input = $request->all();

        $finishType = $this->finishTypeRepository->create($input);

        Flash::success('Finish Type saved successfully.');

        return redirect(route('finishTypes.index'));
    }

    /**
     * Display the specified finish_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('Finish Type not found');

            return redirect(route('finishTypes.index'));
        }

        return view('finish_types.show')->with('finishType', $finishType);
    }

    /**
     * Show the form for editing the specified finish_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('Finish Type not found');

            return redirect(route('finishTypes.index'));
        }

        return view('finish_types.edit')->with('finishType', $finishType);
    }

    /**
     * Update the specified finish_type in storage.
     *
     * @param  int              $id
     * @param Updatefinish_typeRequest $request
     *
     * @return Response
     */
    public function update($id, Updatefinish_typeRequest $request)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('Finish Type not found');

            return redirect(route('finishTypes.index'));
        }

        $finishType = $this->finishTypeRepository->update($request->all(), $id);

        Flash::success('Finish Type updated successfully.');

        return redirect(route('finishTypes.index'));
    }

    /**
     * Remove the specified finish_type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $finishType = $this->finishTypeRepository->find($id);

        if (empty($finishType)) {
            Flash::error('Finish Type not found');

            return redirect(route('finishTypes.index'));
        }

        $this->finishTypeRepository->delete($id);

        Flash::success('Finish Type deleted successfully.');

        return redirect(route('finishTypes.index'));
    }
}
