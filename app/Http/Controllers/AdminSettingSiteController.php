<?php

namespace App\Http\Controllers;

use App\DataTables\AdminSettingSiteDataTable;
use App\Http\Requests\CreateSettingSiteRequest;
use App\Http\Requests\UpdateSettingSiteRequest;
use App\Repositories\SettingSiteRepository;
use Flash;
use Response;

class AdminSettingSiteController extends AppBaseController
{
    /** @var  SettingSiteRepository */
    private $settingSiteRepository;

    public function __construct(SettingSiteRepository $settingSiteRepo)
    {
        $this->settingSiteRepository = $settingSiteRepo;
    }

    /**
     * Display a listing of the SettingSite.
     */
    public function index(AdminSettingSiteDataTable $settingSiteDataTable)
    {
        return $settingSiteDataTable->render('admin_setting_sites.index');
    }

    /**
     * Show the form for creating a new SettingSite.
     */
    public function create()
    {
        return view('admin_setting_sites.create');
    }

    /**
     * Store a newly created SettingSite in storage.
     */
    public function store(CreateSettingSiteRequest $request)
    {
        if ($request->has('img_logo') && !is_null($request->img_logo))
            $request->merge(['logo' => _uploadFileWeb($request->img_logo, 'setting/')]);
        else
            $request->merge(['logo' => $request->img_logo]);

        if ($request->has('img_icon') && !is_null($request->img_icon))
            $request->merge(['icon' => _uploadFileWeb($request->img_icon, 'setting/')]);
        else
            $request->merge(['icon' => $request->img_icon]);

        $settingSite = $this->settingSiteRepository->create($request->all());

        Flash::success('Setting Site saved successfully.');

        return redirect(route('sitemanagement.settingSites.index'));
    }

    /**
     * Display the specified SettingSite.
     */
    public function show($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');
            return redirect(route('sitemanagement.settingSites.index'));
        }

        return view('admin_setting_sites.show')->with('settingSite', $settingSite);
    }

    /**
     * Show the form for editing the specified SettingSite.
     */
    public function edit($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');
            return redirect(route('sitemanagement.settingSites.index'));
        }

        return view('admin_setting_sites.edit')->with('settingSite', $settingSite);
    }

    /**
     * Update the specified SettingSite in storage.
     */
    public function update($id, UpdateSettingSiteRequest $request)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');
            return redirect(route('sitemanagement.settingSites.index'));
        }

        if ($request->has('img_logo') && !is_null($request->img_logo))
            $request->merge(['logo' => _uploadFileWeb($request->img_logo, 'setting/')]);
        else
            $request->merge(['logo' => $settingSite->logo]);

        if ($request->has('img_icon') && !is_null($request->img_icon))
            $request->merge(['icon' => _uploadFileWeb($request->img_icon, 'setting/')]);
        else
            $request->merge(['icon' => $settingSite->icon]);

        $settingSite = $this->settingSiteRepository->update($request->all(), $id);

        Flash::success('Setting Site updated successfully.');

        return redirect(route('sitemanagement.settingSites.index'));
    }

    /**
     * Remove the specified SettingSite from storage.
     */
    public function destroy($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');
            return redirect(route('sitemanagement.settingSites.index'));
        }

        $this->settingSiteRepository->delete($id);

        Flash::success('Setting Site deleted successfully.');

        return redirect(route('sitemanagement.settingSites.index'));
    }
}
