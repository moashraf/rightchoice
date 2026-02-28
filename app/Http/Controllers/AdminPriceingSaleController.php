<?php

namespace App\Http\Controllers;

use App\DataTables\AdminPriceingSaleDataTable;
use App\Http\Requests\Createpriceing_saleRequest;
use App\Http\Requests\Updatepriceing_saleRequest;
use App\Repositories\priceing_saleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminPriceingSaleController extends AppBaseController
{
    /** @var priceing_saleRepository */
    private $priceingSaleRepository;

    public function __construct(priceing_saleRepository $priceingSaleRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->priceingSaleRepository = $priceingSaleRepo;
    }

    public function index(AdminPriceingSaleDataTable $priceingSaleDataTable)
    {
        return $priceingSaleDataTable->render('admin_priceing_sales.index');
    }

    public function create()
    {
        return view('admin_priceing_sales.create');
    }

    public function store(Createpriceing_saleRequest $request)
    {
        $this->priceingSaleRepository->create($request->all());

        Flash::success('تم حفظ السعر بنجاح.');

        return redirect(route('sitemanagement.priceingSales.index'));
    }

    public function show($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('السعر غير موجود');
            return redirect(route('sitemanagement.priceingSales.index'));
        }

        return view('admin_priceing_sales.show')->with('priceingSale', $priceingSale);
    }

    public function edit($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('السعر غير موجود');
            return redirect(route('sitemanagement.priceingSales.index'));
        }

        return view('admin_priceing_sales.edit')->with('priceingSale', $priceingSale);
    }

    public function update($id, Updatepriceing_saleRequest $request)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('السعر غير موجود');
            return redirect(route('sitemanagement.priceingSales.index'));
        }

        $this->priceingSaleRepository->update($request->all(), $id);

        Flash::success('تم تحديث السعر بنجاح.');

        return redirect(route('sitemanagement.priceingSales.index'));
    }

    public function destroy($id)
    {
        $priceingSale = $this->priceingSaleRepository->find($id);

        if (empty($priceingSale)) {
            Flash::error('السعر غير موجود');
            return redirect(route('sitemanagement.priceingSales.index'));
        }

        $this->priceingSaleRepository->delete($id);

        Flash::success('تم حذف السعر بنجاح.');

        return redirect(route('sitemanagement.priceingSales.index'));
    }
}
