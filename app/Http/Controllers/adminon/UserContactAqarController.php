<?php

namespace App\Http\Controllers;

use App\DataTables\UserContactAqarDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserContactAqarRequest;
use App\Http\Requests\UpdateUserContactAqarRequest;
use App\Repositories\UserContactAqarRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserContactAqarController extends AppBaseController
{
    /** @var  UserContactAqarRepository */
    private $userContactAqarRepository;

    public function __construct(UserContactAqarRepository $userContactAqarRepo)
    {
        $this->userContactAqarRepository = $userContactAqarRepo;
    }

    /**
     * Display a listing of the UserContactAqar.
     *
     * @param UserContactAqarDataTable $userContactAqarDataTable
     * @return Response
     */
    public function index(UserContactAqarDataTable $userContactAqarDataTable)
    {
        return $userContactAqarDataTable->render('user_contact_aqars.index');
    }

    /**
     * Show the form for creating a new UserContactAqar.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_contact_aqars.create');
    }

    /**
     * Store a newly created UserContactAqar in storage.
     *
     * @param CreateUserContactAqarRequest $request
     *
     * @return Response
     */
    public function store(CreateUserContactAqarRequest $request)
    {
        $input = $request->all();

        $userContactAqar = $this->userContactAqarRepository->create($input);

        Flash::success('User Contact Aqar saved successfully.');

        return redirect(route('userContactAqars.index'));
    }

    /**
     * Display the specified UserContactAqar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            Flash::error('User Contact Aqar not found');

            return redirect(route('userContactAqars.index'));
        }

        return view('user_contact_aqars.show')->with('userContactAqar', $userContactAqar);
    }

    /**
     * Show the form for editing the specified UserContactAqar.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            Flash::error('User Contact Aqar not found');

            return redirect(route('userContactAqars.index'));
        }

        return view('user_contact_aqars.edit')->with('userContactAqar', $userContactAqar);
    }

    /**
     * Update the specified UserContactAqar in storage.
     *
     * @param  int              $id
     * @param UpdateUserContactAqarRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserContactAqarRequest $request)
    {
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            Flash::error('User Contact Aqar not found');

            return redirect(route('userContactAqars.index'));
        }

        $userContactAqar = $this->userContactAqarRepository->update($request->all(), $id);

        Flash::success('User Contact Aqar updated successfully.');

        return redirect(route('userContactAqars.index'));
    }

    /**
     * Remove the specified UserContactAqar from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userContactAqar = $this->userContactAqarRepository->find($id);

        if (empty($userContactAqar)) {
            Flash::error('User Contact Aqar not found');

            return redirect(route('userContactAqars.index'));
        }

        $this->userContactAqarRepository->delete($id);

        Flash::success('User Contact Aqar deleted successfully.');

        return redirect(route('userContactAqars.index'));
    }
}
