<?php

namespace App\Http\Controllers;

use App\DataTables\aqar_mzayaDataTable;
use App\Http\Requests;
use App\Http\Requests\Createaqar_mzayaRequest;
use App\Http\Requests\Updateaqar_mzayaRequest;
use App\Repositories\aqar_mzayaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class aqar_mzayaController extends AppBaseController
{
    /** @var  aqar_mzayaRepository */
    private $aqarMzayaRepository;

    public function __construct(aqar_mzayaRepository $aqarMzayaRepo)
    {
        $this->aqarMzayaRepository = $aqarMzayaRepo;
    }

    /**
     * Display a listing of the aqar_mzaya.
     *
     * @param aqar_mzayaDataTable $aqarMzayaDataTable
     * @return Response
     */
    public function index(aqar_mzayaDataTable $aqarMzayaDataTable)
    {
        return $aqarMzayaDataTable->render('aqar_mzayas.index');
    }

    /**
     * Show the form for creating a new aqar_mzaya.
     *
     * @return Response
     */
    public function create()
    {
        return view('aqar_mzayas.create');
    }

    /**
     * Store a newly created aqar_mzaya in storage.
     *
     * @param Createaqar_mzayaRequest $request
     *
     * @return Response
     */
    public function store(Createaqar_mzayaRequest $request)
    {
        $input = $request->all();

        $aqarMzaya = $this->aqarMzayaRepository->create($input);

        Flash::success('Aqar Mzaya saved successfully.');

        return redirect(route('aqarMzayas.index'));
    }

    /**
     * Display the specified aqar_mzaya.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            Flash::error('Aqar Mzaya not found');

            return redirect(route('aqarMzayas.index'));
        }

        return view('aqar_mzayas.show')->with('aqarMzaya', $aqarMzaya);
    }

    /**
     * Show the form for editing the specified aqar_mzaya.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            Flash::error('Aqar Mzaya not found');

            return redirect(route('aqarMzayas.index'));
        }

        return view('aqar_mzayas.edit')->with('aqarMzaya', $aqarMzaya);
    }

    /**
     * Update the specified aqar_mzaya in storage.
     *
     * @param  int              $id
     * @param Updateaqar_mzayaRequest $request
     *
     * @return Response
     */
    public function update($id, Updateaqar_mzayaRequest $request)
    {
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            Flash::error('Aqar Mzaya not found');

            return redirect(route('aqarMzayas.index'));
        }

        $aqarMzaya = $this->aqarMzayaRepository->update($request->all(), $id);

        Flash::success('Aqar Mzaya updated successfully.');

        return redirect(route('aqarMzayas.index'));
    }

    /**
     * Remove the specified aqar_mzaya from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $aqarMzaya = $this->aqarMzayaRepository->find($id);

        if (empty($aqarMzaya)) {
            Flash::error('Aqar Mzaya not found');

            return redirect(route('aqarMzayas.index'));
        }

        $this->aqarMzayaRepository->delete($id);

        Flash::success('Aqar Mzaya deleted successfully.');

        return redirect(route('aqarMzayas.index'));
    }
}
