<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserContactAqarAPIRequest;
use App\Http\Requests\API\UpdateUserContactAqarAPIRequest;
use App\Models\UserContactAqar;
use App\Repositories\UserContactAqarRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class UserContactAqarController
 * @package App\Http\Controllers\API
 */

class UserContactAqarAPIController extends AppBaseController
{
    /** @var  UserContactAqarRepository */
    private $userContactAqarRepository;

    public function __construct(UserContactAqarRepository $userContactAqarRepo)
    {
        $this->userContactAqarRepository = $userContactAqarRepo;
    }

    /**
     * Display a listing of the UserContactAqar.
     * GET|HEAD /userContactAqars
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $userContactAqars = $this->userContactAqarRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($userContactAqars->toArray(), 'User Contact Aqars retrieved successfully');
    }

    /**
     * Store a newly created UserContactAqar in storage.
     * POST /userContactAqars
     *
     * @param CreateUserContactAqarAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateUserContactAqarAPIRequest $request)
    {
        $input = $request->all();

        $userContactAqar = $this->userContactAqarRepository->create($input);

        return $this->sendResponse($userContactAqar->toArray(), 'User Contact Aqar saved successfully');
    }

    /**
     * Display the specified UserContactAqar.
     * GET|HEAD /userContactAqars/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var UserContactAqar $userContactAqar */
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            return $this->sendError('User Contact Aqar not found');
        }

        return $this->sendResponse($userContactAqar->toArray(), 'User Contact Aqar retrieved successfully');
    }

    /**
     * Update the specified UserContactAqar in storage.
     * PUT/PATCH /userContactAqars/{id}
     *
     * @param int $id
     * @param UpdateUserContactAqarAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserContactAqarAPIRequest $request)
    {
        $input = $request->all();

        /** @var UserContactAqar $userContactAqar */
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            return $this->sendError('User Contact Aqar not found');
        }

        $userContactAqar = $this->userContactAqarRepository->update($input, $id);

        return $this->sendResponse($userContactAqar->toArray(), 'UserContactAqar updated successfully');
    }

    /**
     * Remove the specified UserContactAqar from storage.
     * DELETE /userContactAqars/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var UserContactAqar $userContactAqar */
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            return $this->sendError('User Contact Aqar not found');
        }

        $userContactAqar->delete();

        return $this->sendSuccess('User Contact Aqar deleted successfully');
    }
}
