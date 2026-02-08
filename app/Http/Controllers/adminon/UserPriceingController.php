<?php

namespace App\Http\Controllers;

use App\DataTables\UserPriceingDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateUserPriceingRequest;
use App\Http\Requests\UpdateUserPriceingRequest;
use App\Repositories\UserPriceingRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class UserPriceingController extends AppBaseController
{
    /** @var  UserPriceingRepository */
    private $userPriceingRepository;

    public function __construct(UserPriceingRepository $userPriceingRepo)
    {
        $this->userPriceingRepository = $userPriceingRepo;
    }

    /**
     * Display a listing of the UserPriceing.
     *
     * @param UserPriceingDataTable $userPriceingDataTable
     * @return Response
     */
    public function index(UserPriceingDataTable $userPriceingDataTable)
    {
        return $userPriceingDataTable->render('user_priceings.index');
    }

    /**
     * Show the form for creating a new UserPriceing.
     *
     * @return Response
     */
    public function create()
    {
        return view('user_priceings.create');
    }

    /**
     * Store a newly created UserPriceing in storage.
     *
     * @param CreateUserPriceingRequest $request
     *
     * @return Response
     */
    public function store(CreateUserPriceingRequest $request)
    {
        $input = $request->all();

        $userPriceing = $this->userPriceingRepository->create($input);

        Flash::success('User Priceing saved successfully.');

        return redirect(route('userPriceings.index'));
    }

    /**
     * Display the specified UserPriceing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            Flash::error('User Priceing not found');

            return redirect(route('userPriceings.index'));
        }

        return view('user_priceings.show')->with('userPriceing', $userPriceing);
    }

    /**
     * Show the form for editing the specified UserPriceing.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            Flash::error('User Priceing not found');

            return redirect(route('userPriceings.index'));
        }

        return view('user_priceings.edit')->with('userPriceing', $userPriceing);
    }

    /**
     * Update the specified UserPriceing in storage.
     *
     * @param  int              $id
     * @param UpdateUserPriceingRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserPriceingRequest $request)
    {
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            Flash::error('User Priceing not found');

            return redirect(route('userPriceings.index'));
        }

        $userPriceing = $this->userPriceingRepository->update($request->all(), $id);

        Flash::success('User Priceing updated successfully.');

        return redirect(route('userPriceings.index'));
    }

    /**
     * Remove the specified UserPriceing from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $userPriceing = $this->userPriceingRepository->find($id);

        if (empty($userPriceing)) {
            Flash::error('User Priceing not found');

            return redirect(route('userPriceings.index'));
        }

        $this->userPriceingRepository->delete($id);

        Flash::success('User Priceing deleted successfully.');

        return redirect(route('userPriceings.index'));
    }
}
