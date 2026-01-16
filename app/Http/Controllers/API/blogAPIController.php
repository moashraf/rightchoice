<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateblogAPIRequest;
use App\Http\Requests\API\UpdateblogAPIRequest;
use App\Models\blog;
use App\Repositories\blogRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class blogController
 * @package App\Http\Controllers\API
 */

class blogAPIController extends AppBaseController
{
    /** @var  blogRepository */
    private $blogRepository;

    public function __construct(blogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /**
     * Display a listing of the blog.
     * GET|HEAD /blogs
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $blogs = $this->blogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($blogs->toArray(), 'Blogs retrieved successfully');
    }

    /**
     * Store a newly created blog in storage.
     * POST /blogs
     *
     * @param CreateblogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateblogAPIRequest $request)
    {
        $input = $request->all();

        $blog = $this->blogRepository->create($input);

        return $this->sendResponse($blog->toArray(), 'Blog saved successfully');
    }

    /**
     * Display the specified blog.
     * GET|HEAD /blogs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        return $this->sendResponse($blog->toArray(), 'Blog retrieved successfully');
    }

    /**
     * Update the specified blog in storage.
     * PUT/PATCH /blogs/{id}
     *
     * @param int $id
     * @param UpdateblogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateblogAPIRequest $request)
    {
        $input = $request->all();

        /** @var blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        $blog = $this->blogRepository->update($input, $id);

        return $this->sendResponse($blog->toArray(), 'blog updated successfully');
    }

    /**
     * Remove the specified blog from storage.
     * DELETE /blogs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var blog $blog */
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }

        $blog->delete();

        return $this->sendSuccess('Blog deleted successfully');
    }
}
