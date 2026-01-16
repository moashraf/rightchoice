<?php

namespace App\Http\Controllers;

use App\DataTables\PriceVipDataTable;
use App\Http\Requests;
use App\Http\Requests\CreatePriceVipRequest;
use App\Http\Requests\UpdatePriceVipRequest;
use App\Repositories\PriceVipRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PriceVipController extends AppBaseController
{
    /** @var  PriceVipRepository */
    private $priceVipRepository;

    public function __construct(PriceVipRepository $priceVipRepo)
    {
        $this->priceVipRepository = $priceVipRepo;
    }

    /**
     * Display a listing of the PriceVip.
     *
     * @param PriceVipDataTable $priceVipDataTable
     * @return Response
     */
    public function index(PriceVipDataTable $priceVipDataTable)
    {
        return $priceVipDataTable->render('price_vips.index');
    }

    /**
     * Show the form for creating a new PriceVip.
     *
     * @return Response
     */
    public function create()
    {
        return view('price_vips.create');
    }

    /**
     * Store a newly created PriceVip in storage.
     *
     * @param CreatePriceVipRequest $request
     *
     * @return Response
     */
    public function store(CreatePriceVipRequest $request)
    {
        $input = $request->all();

        $priceVip = $this->priceVipRepository->create($input);

        Flash::success('Price Vip saved successfully.');

        return redirect(route('priceVips.index'));
    }

    /**
     * Display the specified PriceVip.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');

            return redirect(route('priceVips.index'));
        }

        return view('price_vips.show')->with('priceVip', $priceVip);
    }

    /**
     * Show the form for editing the specified PriceVip.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');

            return redirect(route('priceVips.index'));
        }

        return view('price_vips.edit')->with('priceVip', $priceVip);
    }

    /**
     * Update the specified PriceVip in storage.
     *
     * @param  int              $id
     * @param UpdatePriceVipRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePriceVipRequest $request)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');

            return redirect(route('priceVips.index'));
        }

        $priceVip = $this->priceVipRepository->update($request->all(), $id);

        Flash::success('Price Vip updated successfully.');

        return redirect(route('priceVips.index'));
    }

    /**
     * Remove the specified PriceVip from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');

            return redirect(route('priceVips.index'));
        }

        $this->priceVipRepository->delete($id);

        Flash::success('Price Vip deleted successfully.');

        return redirect(route('priceVips.index'));
    }
}
