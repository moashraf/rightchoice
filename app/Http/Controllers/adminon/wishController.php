<?php

namespace App\Http\Controllers;

use App\DataTables\wishDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatewishRequest;
use App\Http\Requests\UpdatewishRequest;
use App\Repositories\wishRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class wishController extends AppBaseController
{
    /** @var  wishRepository */
    private $wishRepository;

    public function __construct(wishRepository $wishRepo)
    {
        $this->wishRepository = $wishRepo;
    }

    /**
     * Display a listing of the wish.
     *
     * @param wishDataTable $wishDataTable
     * @return Response
     */
    public function index(wishDataTable $wishDataTable)
    {
        return $wishDataTable->render('wishes.index');
    }

    /**
     * Show the form for creating a new wish.
     *
     * @return Response
     */
    public function create()
    {
        return view('wishes.create');
    }

    /**
     * Store a newly created wish in storage.
     *
     * @param CreatewishRequest $request
     *
     * @return Response
     */
    public function store(CreatewishRequest $request)
    {
        $input = $request->all();

        $wish = $this->wishRepository->create($input);

        Flash::success('Wish saved successfully.');

        return redirect(route('wishes.index'));
    }

    /**
     * Display the specified wish.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            Flash::error('Wish not found');

            return redirect(route('wishes.index'));
        }

        return view('wishes.show')->with('wish', $wish);
    }

    /**
     * Show the form for editing the specified wish.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            Flash::error('Wish not found');

            return redirect(route('wishes.index'));
        }

        return view('wishes.edit')->with('wish', $wish);
    }

    /**
     * Update the specified wish in storage.
     *
     * @param  int              $id
     * @param UpdatewishRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatewishRequest $request)
    {
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            Flash::error('Wish not found');

            return redirect(route('wishes.index'));
        }

        $wish = $this->wishRepository->update($request->all(), $id);

        Flash::success('Wish updated successfully.');

        return redirect(route('wishes.index'));
    }

    /**
     * Remove the specified wish from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            Flash::error('Wish not found');

            return redirect(route('wishes.index'));
        }

        $this->wishRepository->delete($id);

        Flash::success('Wish deleted successfully.');

        return redirect(route('wishes.index'));
    }
}
