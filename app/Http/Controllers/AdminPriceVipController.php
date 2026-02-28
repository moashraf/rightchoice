<?php

namespace App\Http\Controllers;

use App\DataTables\AdminPriceVipDataTable;
use App\Http\Requests\CreatePriceVipRequest;
use App\Http\Requests\UpdatePriceVipRequest;
use App\Repositories\PriceVipRepository;
use Flash;
use Response;

class AdminPriceVipController extends AppBaseController
{
    /** @var  PriceVipRepository */
    private $priceVipRepository;

    public function __construct(PriceVipRepository $priceVipRepo)
    {
        $this->priceVipRepository = $priceVipRepo;
    }

    public function index(AdminPriceVipDataTable $priceVipDataTable)
    {
        return $priceVipDataTable->render('admin_price_vips.index');
    }

    public function create()
    {
        return view('admin_price_vips.create');
    }

    public function store(CreatePriceVipRequest $request)
    {
        $priceVip = $this->priceVipRepository->create($request->all());

        Flash::success('Price Vip saved successfully.');

        return redirect(route('sitemanagement.priceVips.index'));
    }

    public function show($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');
            return redirect(route('sitemanagement.priceVips.index'));
        }

        return view('admin_price_vips.show')->with('priceVip', $priceVip);
    }

    public function edit($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');
            return redirect(route('sitemanagement.priceVips.index'));
        }

        return view('admin_price_vips.edit')->with('priceVip', $priceVip);
    }

    public function update($id, UpdatePriceVipRequest $request)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');
            return redirect(route('sitemanagement.priceVips.index'));
        }

        $priceVip = $this->priceVipRepository->update($request->all(), $id);

        Flash::success('Price Vip updated successfully.');

        return redirect(route('sitemanagement.priceVips.index'));
    }

    public function destroy($id)
    {
        $priceVip = $this->priceVipRepository->find($id);

        if (empty($priceVip)) {
            Flash::error('Price Vip not found');
            return redirect(route('sitemanagement.priceVips.index'));
        }

        $this->priceVipRepository->delete($id);

        Flash::success('Price Vip deleted successfully.');

        return redirect(route('sitemanagement.priceVips.index'));
    }
}
