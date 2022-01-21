<?php

namespace App\Http\Controllers;

use App\DataTables\blogDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateblogRequest;
use App\Http\Requests\UpdateblogRequest;
use App\Repositories\blogRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class blogController extends AppBaseController
{
    /** @var  blogRepository */
    private $blogRepository;

    public function __construct(blogRepository $blogRepo)
    {
        $this->blogRepository = $blogRepo;
    }

    /**
     * Display a listing of the blog.
     *
     * @param blogDataTable $blogDataTable
     * @return Response
     */
    public function index(blogDataTable $blogDataTable)
    {
        return $blogDataTable->render('blogs.index');
    }

    /**
     * Show the form for creating a new blog.
     *
     * @return Response
     */
    public function create()
    {
       
        return view('blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     *
     * @param CreateblogRequest $request
     *
     * @return Response
     */
    public function store(CreateblogRequest $request)
    {
        
        
        $input = $request->all();

        //generate => image file
        if ($request->has('img1') && !is_null($request->img1))
        $request->merge(['main_img_alt' => _uploadFileWeb($request->img1, 'blog/')]);
        else
        $request->merge(['main_img_alt' => $request->img1]);

        if ($request->has('img2') && !is_null($request->img2))
         $request->merge(['single_photo' => _uploadFileWeb($request->img2, 'blog/')]);
        else
         $request->merge(['single_photo' => $request->img2]);

        // dd($array,$array2);

        $blog = $this->blogRepository->create($request->all());

        Flash::success('Blog saved successfully.');

        return redirect(route('blogs.index'));
    }

    /**
     * Display the specified blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        return view('blogs.show')->with('blog', $blog);
    }

    /**
     * Show the form for editing the specified blog.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        return view('blogs.edit')->with('blog', $blog);
    }

    /**
     * Update the specified blog in storage.
     *
     * @param  int              $id
     * @param UpdateblogRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateblogRequest $request)
    {
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        //generate => image file
        if ($request->has('img1') && !is_null($request->img1))
        $request->merge(['main_img_alt' => _uploadFileWeb($request->img1, 'blog/')]);
        else
        $request->merge(['main_img_alt' => $blog->main_img_alt]);

        if ($request->has('img2') && !is_null($request->img2))
         $request->merge(['single_photo' => _uploadFileWeb($request->img2, 'blog/')]);
        else
         $request->merge(['single_photo' => $blog->single_photo]);

        $blog = $this->blogRepository->update($request->all(), $id);

        Flash::success('Blog updated successfully.');

        return redirect(route('blogs.index'));
    }

    /**
     * Remove the specified blog from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->find($id);

        if (empty($blog)) {
            Flash::error('Blog not found');

            return redirect(route('blogs.index'));
        }

        $this->blogRepository->delete($id);

        Flash::success('Blog deleted successfully.');

        return redirect(route('blogs.index'));
    }
}
