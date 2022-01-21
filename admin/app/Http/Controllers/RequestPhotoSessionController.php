<?php

namespace App\Http\Controllers;

use App\DataTables\RequestPhotoSessionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateRequestPhotoSessionRequest;
use App\Http\Requests\UpdateRequestPhotoSessionRequest;
use App\Repositories\RequestPhotoSessionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use App\Models\User;
class RequestPhotoSessionController extends AppBaseController
{
    /** @var  RequestPhotoSessionRepository */
    private $requestPhotoSessionRepository;

    public function __construct(RequestPhotoSessionRepository $requestPhotoSessionRepo)
    {
        $this->requestPhotoSessionRepository = $requestPhotoSessionRepo;
    }

    /**
     * Display a listing of the RequestPhotoSession.
     *
     * @param RequestPhotoSessionDataTable $requestPhotoSessionDataTable
     * @return Response
     */
    public function index(RequestPhotoSessionDataTable $requestPhotoSessionDataTable)
    {
        return $requestPhotoSessionDataTable->render('request_photo_sessions.index');
    }

    /**
     * Show the form for creating a new RequestPhotoSession.
     *
     * @return Response
     */
    public function create()
    {
        return view('request_photo_sessions.create');
    }

    /**
     * Store a newly created RequestPhotoSession in storage.
     *
     * @param CreateRequestPhotoSessionRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestPhotoSessionRequest $request)
    {
        $input = $request->all();

        $requestPhotoSession = $this->requestPhotoSessionRepository->create($input);

        Flash::success('Request Photo Session saved successfully.');

        return redirect(route('requestPhotoSessions.index'));
    }

    /**
     * Display the specified RequestPhotoSession.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');

            return redirect(route('requestPhotoSessions.index'));
        }

        $users = User::pluck('name', 'id');
        return view('request_photo_sessions.show',compact('users'))->with('requestPhotoSession', $requestPhotoSession);
    }

    /**
     * Show the form for editing the specified RequestPhotoSession.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');

            return redirect(route('requestPhotoSessions.index'));
        }

        $users = User::pluck('name', 'id');
        return view('request_photo_sessions.edit',compact('users'))->with('requestPhotoSession', $requestPhotoSession);
    }

    /**
     * Update the specified RequestPhotoSession in storage.
     *
     * @param  int              $id
     * @param UpdateRequestPhotoSessionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestPhotoSessionRequest $request)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');

            return redirect(route('requestPhotoSessions.index'));
        }

        $requestPhotoSession = $this->requestPhotoSessionRepository->update($request->all(), $id);

        Flash::success('Request Photo Session updated successfully.');

        return redirect(route('requestPhotoSessions.index'));
    }

    /**
     * Remove the specified RequestPhotoSession from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');

            return redirect(route('requestPhotoSessions.index'));
        }

        $this->requestPhotoSessionRepository->delete($id);

        Flash::success('Request Photo Session deleted successfully.');

        return redirect(route('requestPhotoSessions.index'));
    }
}
