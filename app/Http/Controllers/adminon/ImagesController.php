<?php

namespace App\Http\Controllers;

use App\DataTables\ImagesDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateImagesRequest;
use App\Http\Requests\UpdateImagesRequest;
use App\Repositories\ImagesRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ImagesController extends AppBaseController
{
    /** @var  ImagesRepository */
    private $imagesRepository;

    public function __construct(ImagesRepository $imagesRepo)
    {
        $this->imagesRepository = $imagesRepo;
    }

    /**
     * Display a listing of the Images.
     *
     * @param ImagesDataTable $imagesDataTable
     * @return Response
     */
    public function index(ImagesDataTable $imagesDataTable)
    {
        return $imagesDataTable->render('images.index');
    }

    /**
     * Show the form for creating a new Images.
     *
     * @return Response
     */
    public function create()
    {
        return view('images.create');
    }

    /**
     * Store a newly created Images in storage.
     *
     * @param CreateImagesRequest $request
     *
     * @return Response
     */
    public function store(CreateImagesRequest $request)
    {
        $input = $request->all();

        $images = $this->imagesRepository->create($input);

        Flash::success('Images saved successfully.');

        return redirect(route('images.index'));
    }

    /**
     * Display the specified Images.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            Flash::error('Images not found');

            return redirect(route('images.index'));
        }

        return view('images.show')->with('images', $images);
    }

    /**
     * Show the form for editing the specified Images.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            Flash::error('Images not found');

            return redirect(route('images.index'));
        }

        return view('images.edit')->with('images', $images);
    }

    /**
     * Update the specified Images in storage.
     *
     * @param  int              $id
     * @param UpdateImagesRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateImagesRequest $request)
    {
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            Flash::error('Images not found');

            return redirect(route('images.index'));
        }

        $images = $this->imagesRepository->update($request->all(), $id);

        Flash::success('Images updated successfully.');

        return redirect(route('images.index'));
    }

    /**
     * Remove the specified Images from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            Flash::error('Images not found');

            return redirect(route('images.index'));
        }

        $this->imagesRepository->delete($id);

        Flash::success('Images deleted successfully.');

        return redirect(route('images.index'));
    }
}
