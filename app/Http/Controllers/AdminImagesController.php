<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminImagesController extends AppBaseController
{
    /**
     * Display a listing of all images (paginated, 10 per page).
     */
    public function index(Request $request)
    {
        $query = Images::with('aqar')->orderBy('id', 'desc');

        // Filter by aqar_id if provided
        if ($request->filled('aqar_id')) {
            $query->where('aqar_id', $request->aqar_id);
        }

        $images = $query->paginate(10)->withQueryString();

        return view('admin_images.index', compact('images'));
    }

    /**
     * Delete a specific image.
     */
    public function destroy($id)
    {
        $image = Images::findOrFail($id);

        // Delete the physical file
        $filePath = public_path('images/' . $image->img_url);
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $image->delete();

        return redirect()->back()->with('success', 'تم حذف الصورة بنجاح');
    }

    /**
     * Delete multiple images at once.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'integer|exists:aqars_imgs,id',
        ]);

        $images = Images::whereIn('id', $request->ids)->get();

        foreach ($images as $image) {
            $filePath = public_path('images/' . $image->img_url);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $image->delete();
        }

        return redirect()->back()->with('success', 'تم حذف ' . count($request->ids) . ' صورة بنجاح');
    }
}

