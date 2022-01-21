<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createdistrict_testAPIRequest;
use App\Http\Requests\API\Updatedistrict_testAPIRequest;
use App\Models\district_test;
use App\Repositories\district_testRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class district_testController
 * @package App\Http\Controllers\API
 */

class district_testAPIController extends AppBaseController
{
    /** @var  district_testRepository */
    private $districtTestRepository;

    public function __construct(district_testRepository $districtTestRepo)
    {
        $this->districtTestRepository = $districtTestRepo;
    }

    /**
     * Display a listing of the district_test.
     * GET|HEAD /districtTests
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $districtTests = $this->districtTestRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($districtTests->toArray(), 'District Tests retrieved successfully');
    }

    /**
     * Store a newly created district_test in storage.
     * POST /districtTests
     *
     * @param Createdistrict_testAPIRequest $request
     *
     * @return Response
     */
    public function store(Createdistrict_testAPIRequest $request)
    {
        $input = $request->all();

        $districtTest = $this->districtTestRepository->create($input);

        return $this->sendResponse($districtTest->toArray(), 'District Test saved successfully');
    }

    /**
     * Display the specified district_test.
     * GET|HEAD /districtTests/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var district_test $districtTest */
        $districtTest = $this->districtTestRepository->find($id);

        if (empty($districtTest)) {
            return $this->sendError('District Test not found');
        }

        return $this->sendResponse($districtTest->toArray(), 'District Test retrieved successfully');
    }

    /**
     * Update the specified district_test in storage.
     * PUT/PATCH /districtTests/{id}
     *
     * @param int $id
     * @param Updatedistrict_testAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatedistrict_testAPIRequest $request)
    {
        $input = $request->all();

        /** @var district_test $districtTest */
        $districtTest = $this->districtTestRepository->find($id);

        if (empty($districtTest)) {
            return $this->sendError('District Test not found');
        }

        $districtTest = $this->districtTestRepository->update($input, $id);

        return $this->sendResponse($districtTest->toArray(), 'district_test updated successfully');
    }

    /**
     * Remove the specified district_test from storage.
     * DELETE /districtTests/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var district_test $districtTest */
        $districtTest = $this->districtTestRepository->find($id);

        if (empty($districtTest)) {
            return $this->sendError('District Test not found');
        }

        $districtTest->delete();

        return $this->sendSuccess('District Test deleted successfully');
    }
}
