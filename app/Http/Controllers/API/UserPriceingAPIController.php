<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserPriceingAPIRequest;
use App\Http\Requests\API\UpdateUserPriceingAPIRequest;
use App\Models\UserPriceing;
use App\Repositories\UserPriceingRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserPriceingController
 * @package App\Http\Controllers\API
 */

class UserPriceingAPIController extends AppBaseController
{
    /** @var  UserPriceingRepository */
    private $userPriceingRepository;

    public function __construct(UserPriceingRepository $userPriceingRepo)
    {
        $this->userPriceingRepository = $userPriceingRepo;
    }

    /**
     * Display a listing of the UserPriceing.
     * GET|HEAD /userPriceings
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userPriceings = $this->userPriceingRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userPriceings->toArray(), 'User Priceings retrieved successfully');
    }

    /**
     * Store a newly created UserPriceing in storage.
     * POST /userPriceings
     *
     * @param CreateUserPriceingAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserPriceingAPIRequest $request)
    {
        $input = $request->all();

        $userPriceing = $this->userPriceingRepository->create($input);

        return $this->sendResponse($userPriceing->toArray(), 'User Priceing saved successfully');
    }

    /**
     * Display the specified UserPriceing.
     * GET|HEAD /userPriceings/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserPriceing $userPriceing */
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            return $this->sendError('User Priceing not found');
        }

        return $this->sendResponse($userPriceing->toArray(), 'User Priceing retrieved successfully');
    }

    /**
     * Update the specified UserPriceing in storage.
     * PUT/PATCH /userPriceings/{id}
     *
     * @param int $id
     * @param UpdateUserPriceingAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserPriceingAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserPriceing $userPriceing */
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            return $this->sendError('User Priceing not found');
        }

        $userPriceing = $this->userPriceingRepository->update($input, $id);

        return $this->sendResponse($userPriceing->toArray(), 'UserPriceing updated successfully');
    }

    /**
     * Remove the specified UserPriceing from storage.
     * DELETE /userPriceings/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserPriceing $userPriceing */
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            return $this->sendError('User Priceing not found');
        }

        $userPriceing->delete();

        return $this->sendSuccess('User Priceing deleted successfully');
    }
}
