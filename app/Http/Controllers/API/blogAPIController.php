<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateblogAPIRequest;
use App\Http\Requests\API\UpdateblogAPIRequest;
use App\Models\Blog;
use App\Repositories\blogRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'per_page' => 'nullable|integer|min:1|max:100',
            'page'     => 'nullable|integer|min:1',
        ], [
            'per_page.integer' => 'عدد العناصر في الصفحة يجب أن يكون رقمًا صحيحًا.',
            'per_page.min'     => 'عدد العناصر في الصفحة يجب أن يكون 1 على الأقل.',
            'per_page.max'     => 'عدد العناصر في الصفحة لا يتجاوز 100.',
            'page.integer'     => 'رقم الصفحة يجب أن يكون رقمًا صحيحًا.',
            'page.min'         => 'رقم الصفحة يجب أن يكون 1 على الأقل.',
        ]);

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة.', 422, $validator->errors());
        }

        $perPage = (int) $request->get('per_page', 15);
        $blogs = Blog::latest()->paginate($perPage);
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
