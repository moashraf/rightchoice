<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatewishAPIRequest;
use App\Http\Requests\API\UpdatewishAPIRequest;
use App\Models\wish;
use App\Repositories\wishRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class wishController
 * @package App\Http\Controllers\API
 */

class wishAPIController extends AppBaseController
{
    /** @var  wishRepository */
    private $wishRepository;

    public function __construct(wishRepository $wishRepo)
    {
        $this->wishRepository = $wishRepo;
    }

    /**
     * Display a listing of the wish.
     * GET|HEAD /wishes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $wishes = $this->wishRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($wishes->toArray(), 'Wishes retrieved successfully');
    }

    /**
     * Store a newly created wish in storage.
     * POST /wishes
     *
     * @param CreatewishAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatewishAPIRequest $request)
    {
        $input = $request->all();

        $wish = $this->wishRepository->create($input);

        return $this->sendResponse($wish->toArray(), 'Wish saved successfully');
    }

    /**
     * Display the specified wish.
     * GET|HEAD /wishes/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var wish $wish */
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            return $this->sendError('Wish not found');
        }

        return $this->sendResponse($wish->toArray(), 'Wish retrieved successfully');
    }

    /**
     * Update the specified wish in storage.
     * PUT/PATCH /wishes/{id}
     *
     * @param int $id
     * @param UpdatewishAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatewishAPIRequest $request)
    {
        $input = $request->all();

        /** @var wish $wish */
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            return $this->sendError('Wish not found');
        }

        $wish = $this->wishRepository->update($input, $id);

        return $this->sendResponse($wish->toArray(), 'wish updated successfully');
    }

    /**
     * Remove the specified wish from storage.
     * DELETE /wishes/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var wish $wish */
        $wish = $this->wishRepository->find($id);

        if (empty($wish)) {
            return $this->sendError('Wish not found');
        }

        $wish->delete();

        return $this->sendSuccess('Wish deleted successfully');
    }
}
