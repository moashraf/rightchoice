<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class blogsController extends Controller
{
    // ...existing code...

//    public function uploadFile(Request $request)
//    {
//        if (!$request->hasFile('upload_file') || !$request->file('upload_file')->isValid()) {
//            return response()->json(['success' => false, 'message' => 'يرجى اختيار ملف صالح للرفع.'], 422);
//        }
//
//        $file = $request->file('upload_file');
//
//        // التحقق من الحجم يدوياً (1GB = 1,073,741,824 bytes)
//        if ($file->getSize() > 1073741824) {
//            return response()->json(['success' => false, 'message' => 'حجم الملف يجب ألا يتجاوز 1 جيجابايت.'], 422);
//        }
//
//        $originalName = $file->getClientOriginalName();
//        $fileName = time() . '_' . preg_replace('/\s+/', '_', $originalName);
//        $destination = public_path('uploads/blogs');
//
//        if (!file_exists($destination)) {
//            mkdir($destination, 0755, true);
//        }
//
//        $file->move($destination, $fileName);
//
//        return response()->json([
//            'success' => true,
//            'message' => 'تم رفع الملف "' . $originalName . '" بنجاح!',
//        ]);
//    }

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
