<?php

namespace App\Http\Controllers;

use App\DataTables\SettingSiteDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateSettingSiteRequest;
use App\Http\Requests\UpdateSettingSiteRequest;
use App\Repositories\SettingSiteRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class SettingSiteController extends AppBaseController
{
    /** @var  SettingSiteRepository */
    private $settingSiteRepository;

    public function __construct(SettingSiteRepository $settingSiteRepo)
    {
        $this->settingSiteRepository = $settingSiteRepo;
    }

    /**
     * Display a listing of the SettingSite.
     *
     * @param SettingSiteDataTable $settingSiteDataTable
     * @return Response
     */
    public function index(SettingSiteDataTable $settingSiteDataTable)
    {
        return $settingSiteDataTable->render('setting_sites.index');
    }

    /**
     * Show the form for creating a new SettingSite.
     *
     * @return Response
     */
    public function create()
    {
        return view('setting_sites.create');
    }

    /**
     * Store a newly created SettingSite in storage.
     *
     * @param CreateSettingSiteRequest $request
     *
     * @return Response
     */
    public function store(CreateSettingSiteRequest $request)
    {
        $input = $request->all();

        //generate => image file
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

        return redirect(route('settingSites.index'));
    }

    /**
     * Display the specified SettingSite.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');

            return redirect(route('settingSites.index'));
        }

        return view('setting_sites.show')->with('settingSite', $settingSite);
    }

    /**
     * Show the form for editing the specified SettingSite.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');

            return redirect(route('settingSites.index'));
        }

        return view('setting_sites.edit')->with('settingSite', $settingSite);
    }

    /**
     * Update the specified SettingSite in storage.
     *
     * @param  int              $id
     * @param UpdateSettingSiteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSettingSiteRequest $request)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');

            return redirect(route('settingSites.index'));
        }

         //generate => image file
         if ($request->has('img_logo') && !is_null($request->img_logo))
         $request->merge(['logo' => _uploadFileWeb($request->img_logo, 'setting/')]);
         else
         $request->merge(['logo' => $settingSite->img_logo]);
 
         if ($request->has('img_icon') && !is_null($request->img_icon))
          $request->merge(['icon' => _uploadFileWeb($request->img_icon, 'setting/')]);
         else
          $request->merge(['icon' => $settingSite->img_icon]);
 

        $settingSite = $this->settingSiteRepository->update($request->all(), $id);

        Flash::success('Setting Site updated successfully.');

        return redirect(route('settingSites.index'));
    }

    /**
     * Remove the specified SettingSite from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $settingSite = $this->settingSiteRepository->find($id);

        if (empty($settingSite)) {
            Flash::error('Setting Site not found');

            return redirect(route('settingSites.index'));
        }

        $this->settingSiteRepository->delete($id);

        Flash::success('Setting Site deleted successfully.');

        return redirect(route('settingSites.index'));
    }
}
