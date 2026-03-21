<?php

namespace App\Http\Controllers;

use App\DataTables\AdminAdsDataTable;
use App\Repositories\AdsRepository;
use Illuminate\Http\Request;
use Flash;

class AdminAdsController extends AppBaseController
{
    /** @var AdsRepository */
    private $adsRepository;

    public function __construct(AdsRepository $adsRepo)
    {
        $this->adsRepository = $adsRepo;
    }

    /**
     * Display a listing of the Ads.
     */
    public function index(AdminAdsDataTable $adsDataTable)
    {
        return $adsDataTable->render('admin_ads.index');
    }

    /**
     * Show the form for creating a new Ad.
     */
    public function create()
    {
        return view('admin_ads.create');
    }

    /**
     * Store a newly created Ad in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|url|max:255',
            'img_file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $input = $request->all();

        // Upload image
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()) {
            $file = $request->file('img_file');
            $namerand = '-' . rand(1, 900) . '-';
            $filename = $namerand . '.' . $file->getClientOriginalExtension();

            $fullDir = public_path('images/ads');
            if (!file_exists($fullDir)) {
                mkdir($fullDir, 0777, true);
            }

            $file->move($fullDir, $filename);
            $input['img'] = 'ads' . $filename;
        }

        unset($input['img_file']);
        $this->adsRepository->create($input);

        Flash::success('تم حفظ الإعلان بنجاح.');

        return redirect(route('sitemanagement.ads.index'));
    }

    /**
     * Display the specified Ad.
     */
    public function show($id)
    {
        $ad = $this->adsRepository->find($id);

        if (empty($ad)) {
            Flash::error('الإعلان غير موجود');
            return redirect(route('sitemanagement.ads.index'));
        }

        return view('admin_ads.show')->with('ad', $ad);
    }

    /**
     * Show the form for editing the specified Ad.
     */
    public function edit($id)
    {
        $ad = $this->adsRepository->find($id);

        if (empty($ad)) {
            Flash::error('الإعلان غير موجود');
            return redirect(route('sitemanagement.ads.index'));
        }

        return view('admin_ads.edit')->with('ad', $ad);
    }

    /**
     * Update the specified Ad in storage.
     */
    public function update($id, Request $request)
    {
        $ad = $this->adsRepository->find($id);

        if (empty($ad)) {
            Flash::error('الإعلان غير موجود');
            return redirect(route('sitemanagement.ads.index'));
        }

        $request->validate([
            'name' => 'nullable|url|max:255',
            'img_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $input = $request->all();

        // Upload image if new one provided
        if ($request->hasFile('img_file') && $request->file('img_file')->isValid()) {
            $file = $request->file('img_file');
            $namerand = '-' . rand(1, 900) . '-';
            $filename = $namerand . '.' . $file->getClientOriginalExtension();

            $fullDir = public_path('images/ads');
            if (!file_exists($fullDir)) {
                mkdir($fullDir, 0777, true);
            }

            $file->move($fullDir, $filename);
            $input['img'] = 'ads' . $filename;
        } else {
            $input['img'] = $ad->img;
        }

        unset($input['img_file']);
        $this->adsRepository->update($input, $id);

        Flash::success('تم تحديث الإعلان بنجاح.');

        return redirect(route('sitemanagement.ads.index'));
    }

    /**
     * Remove the specified Ad from storage.
     */
    public function destroy($id)
    {
        $ad = $this->adsRepository->find($id);

        if (empty($ad)) {
            Flash::error('الإعلان غير موجود');
            return redirect(route('sitemanagement.ads.index'));
        }

        $this->adsRepository->delete($id);

        Flash::success('تم حذف الإعلان بنجاح.');

        return redirect(route('sitemanagement.ads.index'));
    }
}
