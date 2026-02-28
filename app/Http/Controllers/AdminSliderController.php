<?php

namespace App\Http\Controllers;

use App\DataTables\AdminSliderDataTable;
use App\Http\Requests\CreateSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use App\Repositories\SliderRepository;
use Flash;
use Response;

class AdminSliderController extends AppBaseController
{
    /** @var  SliderRepository */
    private $sliderRepository;

    public function __construct(SliderRepository $sliderRepo)
    {
        $this->sliderRepository = $sliderRepo;
    }

    /**
     * Display a listing of the Slider.
     */
    public function index(AdminSliderDataTable $sliderDataTable)
    {
        return $sliderDataTable->render('admin_sliders.index');
    }

    /**
     * Show the form for creating a new Slider.
     */
    public function create()
    {
        return view('admin_sliders.create');
    }

    /**
     * Store a newly created Slider in storage.
     */
    public function store(CreateSliderRequest $request)
    {
        //generate => image file
        if ($request->has('img') && !is_null($request->img))
            $request->merge(['image' => _uploadFileWebSlid($request->img, 'slider/')]);
        else
            $request->merge(['image' => $request->img]);

        $slider = $this->sliderRepository->create($request->all());

        Flash::success('Slider saved successfully.');

        return redirect(route('sitemanagement.sliders.index'));
    }

    /**
     * Display the specified Slider.
     */
    public function show($id)
    {
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            Flash::error('Slider not found');
            return redirect(route('sitemanagement.sliders.index'));
        }

        return view('admin_sliders.show')->with('slider', $slider);
    }

    /**
     * Show the form for editing the specified Slider.
     */
    public function edit($id)
    {
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            Flash::error('Slider not found');
            return redirect(route('sitemanagement.sliders.index'));
        }

        return view('admin_sliders.edit')->with('slider', $slider);
    }

    /**
     * Update the specified Slider in storage.
     */
    public function update($id, UpdateSliderRequest $request)
    {
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            Flash::error('Slider not found');
            return redirect(route('sitemanagement.sliders.index'));
        }

        //generate => image file
        if ($request->has('img') && !is_null($request->img))
            $request->merge(['image' => _uploadFileWebSlid($request->img, 'slider/')]);
        else
            $request->merge(['image' => $slider->image]);

        $slider = $this->sliderRepository->update($request->all(), $id);

        Flash::success('Slider updated successfully.');

        return redirect(route('sitemanagement.sliders.index'));
    }

    /**
     * Remove the specified Slider from storage.
     */
    public function destroy($id)
    {
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            Flash::error('Slider not found');
            return redirect(route('sitemanagement.sliders.index'));
        }

        $this->sliderRepository->delete($id);

        Flash::success('Slider deleted successfully.');

        return redirect(route('sitemanagement.sliders.index'));
    }
}
