<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createcall_timeAPIRequest;
use App\Http\Requests\API\Updatecall_timeAPIRequest;
use App\Models\call_time;
use App\Repositories\call_timeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class call_timeController
 * @package App\Http\Controllers\API
 */

class call_timeAPIController extends AppBaseController
{
    /** @var  call_timeRepository */
    private $callTimeRepository;

    public function __construct(call_timeRepository $callTimeRepo)
    {
        $this->callTimeRepository = $callTimeRepo;
    }

    /**
     * Display a listing of the call_time.
     * GET|HEAD /callTimes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $callTimes = $this->callTimeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($callTimes->toArray(), 'Call Times retrieved successfully');
    }

    /**
     * Store a newly created call_time in storage.
     * POST /callTimes
     *
     * @param Createcall_timeAPIRequest $request
     *
     * @return Response
     */
    public function store(Createcall_timeAPIRequest $request)
    {
        $input = $request->all();

        $callTime = $this->callTimeRepository->create($input);

        return $this->sendResponse($callTime->toArray(), 'Call Time saved successfully');
    }

    /**
     * Display the specified call_time.
     * GET|HEAD /callTimes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var call_time $callTime */
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            return $this->sendError('Call Time not found');
        }

        return $this->sendResponse($callTime->toArray(), 'Call Time retrieved successfully');
    }

    /**
     * Update the specified call_time in storage.
     * PUT/PATCH /callTimes/{id}
     *
     * @param int $id
     * @param Updatecall_timeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatecall_timeAPIRequest $request)
    {
        $input = $request->all();

        /** @var call_time $callTime */
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            return $this->sendError('Call Time not found');
        }

        $callTime = $this->callTimeRepository->update($input, $id);

        return $this->sendResponse($callTime->toArray(), 'call_time updated successfully');
    }

    /**
     * Remove the specified call_time from storage.
     * DELETE /callTimes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var call_time $callTime */
        $callTime = $this->callTimeRepository->find($id);

        if (empty($callTime)) {
            return $this->sendError('Call Time not found');
        }

        $callTime->delete();

        return $this->sendSuccess('Call Time deleted successfully');
    }
}
