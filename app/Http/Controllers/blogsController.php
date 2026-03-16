<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class blogsController extends Controller
{
    // ...existing code...

    public function uploadFile(Request $request)
    {
        $request->validate([
            'upload_file' => 'required|file|max:1048576', // 1GB = 1,048,576 KB
        ], [
            'upload_file.required' => 'يرجى اختيار ملف للرفع.',
            'upload_file.file'     => 'الملف الذي تم رفعه غير صالح.',
            'upload_file.max'      => 'حجم الملف يجب ألا يتجاوز 1 جيجابايت.',
        ]);

        $file = $request->file('upload_file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
        $destination = public_path('uploads/blogs');

        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        $file->move($destination, $fileName);

        return back()->with('upload_success', 'تم رفع الملف "' . $originalName . '" بنجاح!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

                $allBlogs = Blog::paginate(9);
                 return view('blogs.blogs', compact('allBlogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show($locale,$slug)
    {
        //

        $blog = Blog::where('slug', $slug)->first();
        //dd($blog);
    // dd($company);

        return view('blogs.blog',  ['blog' => $blog]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
