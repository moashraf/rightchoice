<?php

namespace App\Http\Controllers;

use App\DataTables\mzayaDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatemzayaRequest;
use App\Http\Requests\UpdatemzayaRequest;
use App\Repositories\mzayaRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class mzayaController extends AppBaseController
{
    /** @var  mzayaRepository */
    private $mzayaRepository;

    public function __construct(mzayaRepository $mzayaRepo)
    {
        $this->mzayaRepository = $mzayaRepo;
    }

    /**
     * Display a listing of the mzaya.
     *
     * @param mzayaDataTable $mzayaDataTable
     * @return Response
     */
    public function index(mzayaDataTable $mzayaDataTable)
    {
        return $mzayaDataTable->render('mzayas.index');
    }

    /**
     * Show the form for creating a new mzaya.
     *
     * @return Response
     */
    public function create()
    {
        return view('mzayas.create');
    }

    /**
     * Store a newly created mzaya in storage.
     *
     * @param CreatemzayaRequest $request
     *
     * @return Response
     */
    public function store(CreatemzayaRequest $request)
    {
        $input = $request->all();
        // dd($request->all());

        if ($request->has('img') && !is_null($request->img))
        $request->merge(['img_name' => _uploadFileWeb($request->img, 'mzaya/')]);
        else
        $request->merge(['img_name' => $request->img]);


        $mzaya = $this->mzayaRepository->create($request->all());

        Flash::success('Mzaya saved successfully.');

        return redirect(route('mzayas.index'));
    }

    /**
     * Display the specified mzaya.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('Mzaya not found');

            return redirect(route('mzayas.index'));
        }

        return view('mzayas.show')->with('mzaya', $mzaya);
    }

    /**
     * Show the form for editing the specified mzaya.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('Mzaya not found');

            return redirect(route('mzayas.index'));
        }

        return view('mzayas.edit')->with('mzaya', $mzaya);
    }

    /**
     * Update the specified mzaya in storage.
     *
     * @param  int              $id
     * @param UpdatemzayaRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatemzayaRequest $request)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('Mzaya not found');

            return redirect(route('mzayas.index'));
        }

        //generate => image file
        if ($request->has('img') && !is_null($request->img))
        $request->merge(['img_name' => _uploadFileWeb($request->img, 'mzaya/')]);
        else
        $request->merge(['img_name' => $mzaya->img_name]);

        $mzaya = $this->mzayaRepository->update($request->all(), $id);

        Flash::success('Mzaya updated successfully.');

        return redirect(route('mzayas.index'));
    }

    /**
     * Remove the specified mzaya from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $mzaya = $this->mzayaRepository->find($id);

        if (empty($mzaya)) {
            Flash::error('Mzaya not found');

            return redirect(route('mzayas.index'));
        }

        $this->mzayaRepository->delete($id);

        Flash::success('Mzaya deleted successfully.');

        return redirect(route('mzayas.index'));
    }
}
