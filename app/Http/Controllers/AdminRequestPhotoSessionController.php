<?php

namespace App\Http\Controllers;

use App\DataTables\AdminRequestPhotoSessionDataTable;
use App\Http\Requests\CreateRequestPhotoSessionRequest;
use App\Http\Requests\UpdateRequestPhotoSessionRequest;
use App\Repositories\RequestPhotoSessionRepository;
use App\Models\User;
use Flash;
use Response;

class AdminRequestPhotoSessionController extends AppBaseController
{
    /** @var  RequestPhotoSessionRepository */
    private $requestPhotoSessionRepository;

    public function __construct(RequestPhotoSessionRepository $requestPhotoSessionRepo)
    {
        $this->requestPhotoSessionRepository = $requestPhotoSessionRepo;
    }

    /**
     * Display a listing of the RequestPhotoSession.
     */
    public function index(AdminRequestPhotoSessionDataTable $requestPhotoSessionDataTable)
    {
        return $requestPhotoSessionDataTable->render('admin_request_photo_sessions.index');
    }

    /**
     * Show the form for creating a new RequestPhotoSession.
     */
    public function create()
    {
        $users = User::pluck('name', 'id');
        return view('admin_request_photo_sessions.create', compact('users'));
    }

    /**
     * Store a newly created RequestPhotoSession in storage.
     */
    public function store(CreateRequestPhotoSessionRequest $request)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->create($request->all());

        Flash::success('Request Photo Session saved successfully.');

        return redirect(route('sitemanagement.requestPhotoSessions.index'));
    }

    /**
     * Display the specified RequestPhotoSession.
     */
    public function show($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');
            return redirect(route('sitemanagement.requestPhotoSessions.index'));
        }

        $users = User::pluck('name', 'id');
        return view('admin_request_photo_sessions.show', compact('users'))->with('requestPhotoSession', $requestPhotoSession);
    }

    /**
     * Show the form for editing the specified RequestPhotoSession.
     */
    public function edit($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');
            return redirect(route('sitemanagement.requestPhotoSessions.index'));
        }

        $users = User::pluck('name', 'id');
        return view('admin_request_photo_sessions.edit', compact('users'))->with('requestPhotoSession', $requestPhotoSession);
    }

    /**
     * Update the specified RequestPhotoSession in storage.
     */
    public function update($id, UpdateRequestPhotoSessionRequest $request)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');
            return redirect(route('sitemanagement.requestPhotoSessions.index'));
        }

        $requestPhotoSession = $this->requestPhotoSessionRepository->update($request->all(), $id);

        Flash::success('Request Photo Session updated successfully.');

        return redirect(route('sitemanagement.requestPhotoSessions.index'));
    }

    /**
     * Remove the specified RequestPhotoSession from storage.
     */
    public function destroy($id)
    {
        $requestPhotoSession = $this->requestPhotoSessionRepository->find($id);

        if (empty($requestPhotoSession)) {
            Flash::error('Request Photo Session not found');
            return redirect(route('sitemanagement.requestPhotoSessions.index'));
        }

        $this->requestPhotoSessionRepository->delete($id);

        Flash::success('Request Photo Session deleted successfully.');

        return redirect(route('sitemanagement.requestPhotoSessions.index'));
    }
}
