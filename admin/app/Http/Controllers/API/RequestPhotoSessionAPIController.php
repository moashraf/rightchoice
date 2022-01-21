<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRequestPhotoSessionAPIRequest;
use App\Http\Requests\API\UpdateRequestPhotoSessionAPIRequest;
use App\Models\RequestPhotoSession;
use App\Repositories\RequestPhotoSessionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class RequestPhotoSessionController
 * @package App\Http\Controllers\API
 */

class RequestPhotoSessionAPIController extends AppBaseController
{
    /** @var  RequestPhotoSessionRepository */
    private $requestPhotoSessionRepository;

    public function __construct(RequestPhotoSessionRepository $requestPhotoSessionRepo)
    {
        $this->requestPhotoSessionRepository = $requestPhotoSessionRepo;
    }

    /**
     * Display a listing of the RequestPhotoSession.
     * GET|HEAD /requestPhotoSessions
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $requestPhotoSessions = $this->requestPhotoSessionRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($requestPhotoSessions->toArray(), 'Request Photo Sessions retrieved successfully');
    }

    /**
     * Store a newly created RequestPhotoSession in storage.
     * POST /requestPhotoSessions
     *
     * @param CreateRequestPhotoSessionAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestPhotoSessionAPIRequest $request)
    {
        $input = $request->all();

        $requestPhotoSession = $this->requestPhotoSessionRepository->create($input);

        return $this->sendResponse($requestPhotoSession->toArray(), 'Request Photo Session saved successfully');
    }

    /**
     * Display the specified RequestPhotoSession.
     * GET|HEAD /requestPhotoSessions/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var RequestPhotoSession $requestPhotoSession */
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            return $this->sendError('Request Photo Session not found');
        }

        return $this->sendResponse($requestPhotoSession->toArray(), 'Request Photo Session retrieved successfully');
    }

    /**
     * Update the specified RequestPhotoSession in storage.
     * PUT/PATCH /requestPhotoSessions/{id}
     *
     * @param int $id
     * @param UpdateRequestPhotoSessionAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestPhotoSessionAPIRequest $request)
    {
        $input = $request->all();

        /** @var RequestPhotoSession $requestPhotoSession */
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            return $this->sendError('Request Photo Session not found');
        }

        $requestPhotoSession = $this->requestPhotoSessionRepository->update($input, $id);

        return $this->sendResponse($requestPhotoSession->toArray(), 'RequestPhotoSession updated successfully');
    }

    /**
     * Remove the specified RequestPhotoSession from storage.
     * DELETE /requestPhotoSessions/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var RequestPhotoSession $requestPhotoSession */
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            return $this->sendError('Request Photo Session not found');
        }

        $requestPhotoSession->delete();

        return $this->sendSuccess('Request Photo Session deleted successfully');
    }
}
