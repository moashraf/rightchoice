<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateSliderAPIRequest;
use App\Http\Requests\API\UpdateSliderAPIRequest;
use App\Models\Slider;
use App\Repositories\SliderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class SliderController
 * @package App\Http\Controllers\API
 */

class SliderAPIController extends AppBaseController
{
    /** @var  SliderRepository */
    private $sliderRepository;

    public function __construct(SliderRepository $sliderRepo)
    {
        $this->sliderRepository = $sliderRepo;
    }

    /**
     * Display a listing of the Slider.
     * GET|HEAD /sliders
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $sliders = $this->sliderRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($sliders->toArray(), 'Sliders retrieved successfully');
    }

    /**
     * Store a newly created Slider in storage.
     * POST /sliders
     *
     * @param CreateSliderAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateSliderAPIRequest $request)
    {
        $input = $request->all();

        $slider = $this->sliderRepository->create($input);

        return $this->sendResponse($slider->toArray(), 'Slider saved successfully');
    }

    /**
     * Display the specified Slider.
     * GET|HEAD /sliders/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }

        return $this->sendResponse($slider->toArray(), 'Slider retrieved successfully');
    }

    /**
     * Update the specified Slider in storage.
     * PUT/PATCH /sliders/{id}
     *
     * @param int $id
     * @param UpdateSliderAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSliderAPIRequest $request)
    {
        $input = $request->all();

        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }

        $slider = $this->sliderRepository->update($input, $id);

        return $this->sendResponse($slider->toArray(), 'Slider updated successfully');
    }

    /**
     * Remove the specified Slider from storage.
     * DELETE /sliders/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Slider $slider */
        $slider = $this->sliderRepository->find($id);

        if (empty($slider)) {
            return $this->sendError('Slider not found');
        }

        $slider->delete();

        return $this->sendSuccess('Slider deleted successfully');
    }
}
