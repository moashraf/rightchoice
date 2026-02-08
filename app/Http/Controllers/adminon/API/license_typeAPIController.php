<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createlicense_typeAPIRequest;
use App\Http\Requests\API\Updatelicense_typeAPIRequest;
use App\Models\license_type;
use App\Repositories\license_typeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class license_typeController
 * @package App\Http\Controllers\API
 */

class license_typeAPIController extends AppBaseController
{
    /** @var  license_typeRepository */
    private $licenseTypeRepository;

    public function __construct(license_typeRepository $licenseTypeRepo)
    {
        $this->licenseTypeRepository = $licenseTypeRepo;
    }

    /**
     * Display a listing of the license_type.
     * GET|HEAD /licenseTypes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $licenseTypes = $this->licenseTypeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($licenseTypes->toArray(), 'License Types retrieved successfully');
    }

    /**
     * Store a newly created license_type in storage.
     * POST /licenseTypes
     *
     * @param Createlicense_typeAPIRequest $request
     *
     * @return Response
     */
    public function store(Createlicense_typeAPIRequest $request)
    {
        $input = $request->all();

        $licenseType = $this->licenseTypeRepository->create($input);

        return $this->sendResponse($licenseType->toArray(), 'License Type saved successfully');
    }

    /**
     * Display the specified license_type.
     * GET|HEAD /licenseTypes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var license_type $licenseType */
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            return $this->sendError('License Type not found');
        }

        return $this->sendResponse($licenseType->toArray(), 'License Type retrieved successfully');
    }

    /**
     * Update the specified license_type in storage.
     * PUT/PATCH /licenseTypes/{id}
     *
     * @param int $id
     * @param Updatelicense_typeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatelicense_typeAPIRequest $request)
    {
        $input = $request->all();

        /** @var license_type $licenseType */
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            return $this->sendError('License Type not found');
        }

        $licenseType = $this->licenseTypeRepository->update($input, $id);

        return $this->sendResponse($licenseType->toArray(), 'license_type updated successfully');
    }

    /**
     * Remove the specified license_type from storage.
     * DELETE /licenseTypes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var license_type $licenseType */
        $licenseType = $this->licenseTypeRepository->find($id);

        if (empty($licenseType)) {
            return $this->sendError('License Type not found');
        }

        $licenseType->delete();

        return $this->sendSuccess('License Type deleted successfully');
    }
}
