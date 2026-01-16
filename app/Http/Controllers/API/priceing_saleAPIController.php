<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Createpriceing_saleAPIRequest;
use App\Http\Requests\API\Updatepriceing_saleAPIRequest;
use App\Models\priceing_sale;
use App\Repositories\priceing_saleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class priceing_saleController
 * @package App\Http\Controllers\API
 */

class priceing_saleAPIController extends AppBaseController
{
    /** @var  priceing_saleRepository */
    private $priceingSaleRepository;

    public function __construct(priceing_saleRepository $priceingSaleRepo)
    {
        $this->priceingSaleRepository = $priceingSaleRepo;
    }

    /**
     * Display a listing of the priceing_sale.
     * GET|HEAD /priceingSales
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $priceingSales = $this->priceingSaleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($priceingSales->toArray(), 'Priceing Sales retrieved successfully');
    }

    /**
     * Store a newly created priceing_sale in storage.
     * POST /priceingSales
     *
     * @param Createpriceing_saleAPIRequest $request
     *
     * @return Response
     */
    public function store(Createpriceing_saleAPIRequest $request)
    {
        $input = $request->all();

        $priceingSale = $this->priceingSaleRepository->create($input);

        return $this->sendResponse($priceingSale->toArray(), 'Priceing Sale saved successfully');
    }

    /**
     * Display the specified priceing_sale.
     * GET|HEAD /priceingSales/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var priceing_sale $priceingSale */
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            return $this->sendError('Priceing Sale not found');
        }

        return $this->sendResponse($priceingSale->toArray(), 'Priceing Sale retrieved successfully');
    }

    /**
     * Update the specified priceing_sale in storage.
     * PUT/PATCH /priceingSales/{id}
     *
     * @param int $id
     * @param Updatepriceing_saleAPIRequest $request
     *
     * @return Response
     */
    public function update($id, Updatepriceing_saleAPIRequest $request)
    {
        $input = $request->all();

        /** @var priceing_sale $priceingSale */
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            return $this->sendError('Priceing Sale not found');
        }

        $priceingSale = $this->priceingSaleRepository->update($input, $id);

        return $this->sendResponse($priceingSale->toArray(), 'priceing_sale updated successfully');
    }

    /**
     * Remove the specified priceing_sale from storage.
     * DELETE /priceingSales/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var priceing_sale $priceingSale */
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            return $this->sendError('Priceing Sale not found');
        }

        $priceingSale->delete();

        return $this->sendSuccess('Priceing Sale deleted successfully');
    }
}
