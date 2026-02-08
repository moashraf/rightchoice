<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePagesAPIRequest;
use App\Http\Requests\API\UpdatePagesAPIRequest;
use App\Models\Pages;
use App\Repositories\PagesRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PagesController
 * @package App\Http\Controllers\API
 */

class PagesAPIController extends AppBaseController
{
    /** @var  PagesRepository */
    private $pagesRepository;

    public function __construct(PagesRepository $pagesRepo)
    {
        $this->pagesRepository = $pagesRepo;
    }

    /**
     * Display a listing of the Pages.
     * GET|HEAD /pages
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $pages = $this->pagesRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * Store a newly created Pages in storage.
     * POST /pages
     *
     * @param CreatePagesAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePagesAPIRequest $request)
    {
        $input = $request->all();

        $pages = $this->pagesRepository->create($input);

        return $this->sendResponse($pages->toArray(), 'Pages saved successfully');
    }

    /**
     * Display the specified Pages.
     * GET|HEAD /pages/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Pages $pages */
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        return $this->sendResponse($pages->toArray(), 'Pages retrieved successfully');
    }

    /**
     * Update the specified Pages in storage.
     * PUT/PATCH /pages/{id}
     *
     * @param int $id
     * @param UpdatePagesAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePagesAPIRequest $request)
    {
        $input = $request->all();

        /** @var Pages $pages */
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        $pages = $this->pagesRepository->update($input, $id);

        return $this->sendResponse($pages->toArray(), 'Pages updated successfully');
    }

    /**
     * Remove the specified Pages from storage.
     * DELETE /pages/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Pages $pages */
        $pages = $this->pagesRepository->find($id);

        if (empty($pages)) {
            return $this->sendError('Pages not found');
        }

        $pages->delete();

        return $this->sendSuccess('Pages deleted successfully');
    }
}
