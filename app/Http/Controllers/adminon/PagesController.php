<?php

namespace App\Http\Controllers;

use App\DataTables\PagesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePagesRequest;
use App\Http\Requests\UpdatePagesRequest;
use App\Repositories\PagesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PagesController extends AppBaseController
{
    /** @var  PagesRepository */
    private $pagesRepository;

    public function __construct(PagesRepository $pagesRepo)
    {
        $this->pagesRepository = $pagesRepo;
    }

    /**
     * Display a listing of the Pages.
     *
     * @param PagesDataTable $pagesDataTable
     * @return Response
     */
    public function index(PagesDataTable $pagesDataTable)
    {
        return $pagesDataTable->render('pages.index');
    }

    /**
     * Show the form for creating a new Pages.
     *
     * @return Response
     */
    public function create()
    {
        return view('pages.create');
    }

    /**
     * Store a newly created Pages in storage.
     *
     * @param CreatePagesRequest $request
     *
     * @return Response
     */
    public function store(CreatePagesRequest $request)
    {
        $input = $request->all();

        $pages = $this->pagesRepository->create($input);

        Flash::success('Pages saved successfully.');

        return redirect(route('pages.index'));
    }

    /**
     * Display the specified Pages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('Pages not found');

            return redirect(route('pages.index'));
        }

        return view('pages.show')->with('pages', $pages);
    }

    /**
     * Show the form for editing the specified Pages.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('Pages not found');

            return redirect(route('pages.index'));
        }

        return view('pages.edit')->with('pages', $pages);
    }

    /**
     * Update the specified Pages in storage.
     *
     * @param  int              $id
     * @param UpdatePagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePagesRequest $request)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('Pages not found');

            return redirect(route('pages.index'));
        }

        $pages = $this->pagesRepository->update($request->all(), $id);

        Flash::success('Pages updated successfully.');

        return redirect(route('pages.index'));
    }

    /**
     * Remove the specified Pages from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            Flash::error('Pages not found');

            return redirect(route('pages.index'));
        }

        $this->pagesRepository->delete($id);

        Flash::success('Pages deleted successfully.');

        return redirect(route('pages.index'));
    }
}
