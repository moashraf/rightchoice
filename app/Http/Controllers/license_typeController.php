<?php

namespace App\Http\Controllers;

use App\DataTables\license_typeDataTable;
use App\Http\Requests;
use App\Http\Requests\Createlicense_typeRequest;
use App\Http\Requests\Updatelicense_typeRequest;
use App\Repositories\license_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class license_typeController extends AppBaseController
{
    /** @var  license_typeRepository */
    private $licenseTypeRepository;

    public function __construct(license_typeRepository $licenseTypeRepo)
    {
        $this->licenseTypeRepository = $licenseTypeRepo;
    }

    /**
     * Display a listing of the license_type.
     *
     * @param license_typeDataTable $licenseTypeDataTable
     * @return Response
     */
    public function index(license_typeDataTable $licenseTypeDataTable)
    {
        return $licenseTypeDataTable->render('license_types.index');
    }

    /**
     * Show the form for creating a new license_type.
     *
     * @return Response
     */
    public function create()
    {
        return view('license_types.create');
    }

    /**
     * Store a newly created license_type in storage.
     *
     * @param Createlicense_typeRequest $request
     *
     * @return Response
     */
    public function store(Createlicense_typeRequest $request)
    {
        $input = $request->all();

        $licenseType = $this->licenseTypeRepository->create($input);

        Flash::success('License Type saved successfully.');

        return redirect(route('licenseTypes.index'));
    }

    /**
     * Display the specified license_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('License Type not found');

            return redirect(route('licenseTypes.index'));
        }

        return view('license_types.show')->with('licenseType', $licenseType);
    }

    /**
     * Show the form for editing the specified license_type.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('License Type not found');

            return redirect(route('licenseTypes.index'));
        }

        return view('license_types.edit')->with('licenseType', $licenseType);
    }

    /**
     * Update the specified license_type in storage.
     *
     * @param  int              $id
     * @param Updatelicense_typeRequest $request
     *
     * @return Response
     */
    public function update($id, Updatelicense_typeRequest $request)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('License Type not found');

            return redirect(route('licenseTypes.index'));
        }

        $licenseType = $this->licenseTypeRepository->update($request->all(), $id);

        Flash::success('License Type updated successfully.');

        return redirect(route('licenseTypes.index'));
    }

    /**
     * Remove the specified license_type from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            Flash::error('License Type not found');

            return redirect(route('licenseTypes.index'));
        }

        $this->licenseTypeRepository->delete($id);

        Flash::success('License Type deleted successfully.');

        return redirect(route('licenseTypes.index'));
    }
}
