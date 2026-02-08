<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatePriceVipAPIRequest;
use App\Http\Requests\API\UpdatePriceVipAPIRequest;
use App\Models\PriceVip;
use App\Repositories\PriceVipRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class PriceVipController
 * @package App\Http\Controllers\API
 */

class PriceVipAPIController extends AppBaseController
{
    /** @var  PriceVipRepository */
    private $priceVipRepository;

    public function __construct(PriceVipRepository $priceVipRepo)
    {
        $this->priceVipRepository = $priceVipRepo;
    }

    /**
     * Display a listing of the PriceVip.
     * GET|HEAD /priceVips
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $priceVips = $this->priceVipRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($priceVips->toArray(), 'Price Vips retrieved successfully');
    }

    /**
     * Store a newly created PriceVip in storage.
     * POST /priceVips
     *
     * @param CreatePriceVipAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatePriceVipAPIRequest $request)
    {
        $input = $request->all();

        $priceVip = $this->priceVipRepository->create($input);

        return $this->sendResponse($priceVip->toArray(), 'Price Vip saved successfully');
    }

    /**
     * Display the specified PriceVip.
     * GET|HEAD /priceVips/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var PriceVip $priceVip */
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            return $this->sendError('Price Vip not found');
        }

        return $this->sendResponse($priceVip->toArray(), 'Price Vip retrieved successfully');
    }

    /**
     * Update the specified PriceVip in storage.
     * PUT/PATCH /priceVips/{id}
     *
     * @param int $id
     * @param UpdatePriceVipAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePriceVipAPIRequest $request)
    {
        $input = $request->all();

        /** @var PriceVip $priceVip */
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            return $this->sendError('Price Vip not found');
        }

        $priceVip = $this->priceVipRepository->update($input, $id);

        return $this->sendResponse($priceVip->toArray(), 'PriceVip updated successfully');
    }

    /**
     * Remove the specified PriceVip from storage.
     * DELETE /priceVips/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var PriceVip $priceVip */
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            return $this->sendError('Price Vip not found');
        }

        $priceVip->delete();

        return $this->sendSuccess('Price Vip deleted successfully');
    }
}
