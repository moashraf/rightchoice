<?php

namespace App\Http\Controllers;

use App\DataTables\priceing_saleDataTable;
use App\Http\Requests;
use App\Http\Requests\Createpriceing_saleRequest;
use App\Http\Requests\Updatepriceing_saleRequest;
use App\Repositories\priceing_saleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class priceing_saleController extends AppBaseController
{
    /** @var  priceing_saleRepository */
    private $priceingSaleRepository;

    public function __construct(priceing_saleRepository $priceingSaleRepo)
    {
        $this->priceingSaleRepository = $priceingSaleRepo;
    }

    /**
     * Display a listing of the priceing_sale.
     *
     * @param priceing_saleDataTable $priceingSaleDataTable
     * @return Response
     */
    public function index(priceing_saleDataTable $priceingSaleDataTable)
    {
        return $priceingSaleDataTable->render('priceing_sales.index');
    }

    /**
     * Show the form for creating a new priceing_sale.
     *
     * @return Response
     */
    public function create()
    {
        return view('priceing_sales.create');
    }

    /**
     * Store a newly created priceing_sale in storage.
     *
     * @param Createpriceing_saleRequest $request
     *
     * @return Response
     */
    public function store(Createpriceing_saleRequest $request)
    {
        $input = $request->all();

        $priceingSale = $this->priceingSaleRepository->create($input);

        Flash::success('Priceing Sale saved successfully.');

        return redirect(route('priceingSales.index'));
    }

    /**
     * Display the specified priceing_sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('Priceing Sale not found');

            return redirect(route('priceingSales.index'));
        }

        return view('priceing_sales.show')->with('priceingSale', $priceingSale);
    }

    /**
     * Show the form for editing the specified priceing_sale.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('Priceing Sale not found');

            return redirect(route('priceingSales.index'));
        }

        return view('priceing_sales.edit')->with('priceingSale', $priceingSale);
    }

    /**
     * Update the specified priceing_sale in storage.
     *
     * @param  int              $id
     * @param Updatepriceing_saleRequest $request
     *
     * @return Response
     */
    public function update($id, Updatepriceing_saleRequest $request)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('Priceing Sale not found');

            return redirect(route('priceingSales.index'));
        }

        $priceingSale = $this->priceingSaleRepository->update($request->all(), $id);

        Flash::success('Priceing Sale updated successfully.');

        return redirect(route('priceingSales.index'));
    }

    /**
     * Remove the specified priceing_sale from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('Priceing Sale not found');

            return redirect(route('priceingSales.index'));
        }

        $this->priceingSaleRepository->delete($id);

        Flash::success('Priceing Sale deleted successfully.');

        return redirect(route('priceingSales.index'));
    }
}
