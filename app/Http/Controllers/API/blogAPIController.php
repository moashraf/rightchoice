<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateblogAPIRequest;
use App\Http\Requests\API\UpdateblogAPIRequest;
use App\Models\Blog;
use App\Repositories\blogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;

class blogAPIController extends AppBaseController
{
    private $blogRepository;

    public function __construct(blogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /** GET /api/blogs */
    public function index(Request $request): JsonResponse
    {
        $blogs = $this->blogRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );
        return $this->sendResponse($blogs->toArray(), 'Blogs retrieved successfully');
    }

    /** POST /api/blogs */
    public function store(CreateblogAPIRequest $request): JsonResponse
    {
        $blog = $this->blogRepository->create($request->all());
        return $this->sendResponse($blog->toArray(), 'Blog saved successfully');
    }

    /** GET /api/blogs/{id} */
    public function show($id): JsonResponse
    {
        $blog = $this->blogRepository->find($id);
        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }
        return $this->sendResponse($blog->toArray(), 'Blog retrieved successfully');
    }

    /** PUT /api/blogs/{id} */
    public function update($id, UpdateblogAPIRequest $request): JsonResponse
    {
        $blog = $this->blogRepository->find($id);
        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }
        $blog = $this->blogRepository->update($request->all(), $id);
        return $this->sendResponse($blog->toArray(), 'Blog updated successfully');
    }

    /** DELETE /api/blogs/{id} */
    public function destroy($id): JsonResponse
    {
        $blog = $this->blogRepository->find($id);
        if (empty($blog)) {
            return $this->sendError('Blog not found');
        }
        $blog->delete();
        return $this->sendSuccess('Blog deleted successfully');
    }
}
