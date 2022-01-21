<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateImagesAPIRequest;
use App\Http\Requests\API\UpdateImagesAPIRequest;
use App\Models\Images;
use App\Repositories\ImagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ImagesController
 * @package App\Http\Controllers\API
 */

class ImagesAPIController extends AppBaseController
{
    /** @var  ImagesRepository */
    private $imagesRepository;

    public function __construct(ImagesRepository $imagesRepo)
    {
        $this->imagesRepository = $imagesRepo;
    }

    /**
     * Display a listing of the Images.
     * GET|HEAD /images
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $images = $this->imagesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($images->toArray(), 'Images retrieved successfully');
    }

    /**
     * Store a newly created Images in storage.
     * POST /images
     *
     * @param CreateImagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateImagesAPIRequest $request)
    {
        $input = $request->all();

        $images = $this->imagesRepository->create($input);

        return $this->sendResponse($images->toArray(), 'Images saved successfully');
    }

    /**
     * Display the specified Images.
     * GET|HEAD /images/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('Images not found');
        }

        return $this->sendResponse($images->toArray(), 'Images retrieved successfully');
    }

    /**
     * Update the specified Images in storage.
     * PUT/PATCH /images/{id}
     *
     * @param int $id
     * @param UpdateImagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateImagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('Images not found');
        }

        $images = $this->imagesRepository->update($input, $id);

        return $this->sendResponse($images->toArray(), 'Images updated successfully');
    }

    /**
     * Remove the specified Images from storage.
     * DELETE /images/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Images $images */
        $images = $this->imagesRepository->find($id);

        if (empty($images)) {
            return $this->sendError('Images not found');
        }

        $images->delete();

        return $this->sendSuccess('Images deleted successfully');
    }
}
