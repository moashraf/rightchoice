<?php

namespace App\Http\Controllers;

use App\DataTables\AdminOfferTypeDataTable;
use App\Http\Requests\Createoffer_typeRequest;
use App\Http\Requests\Updateoffer_typeRequest;
use App\Repositories\offer_typeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminOfferTypeController extends AppBaseController
{
    /** @var offer_typeRepository */
    private $offerTypeRepository;

    public function __construct(offer_typeRepository $offerTypeRepo)
    {
        $this->middleware('adminfCheckAdmin');
        $this->offerTypeRepository = $offerTypeRepo;
    }

    public function index(AdminOfferTypeDataTable $offerTypeDataTable)
    {
        return $offerTypeDataTable->render('admin_offer_types.index');
    }

    public function create()
    {
        return view('admin_offer_types.create');
    }

    public function store(Createoffer_typeRequest $request)
    {
        $this->offerTypeRepository->create($request->all());

        Flash::success('تم حفظ نوع العرض بنجاح.');

        return redirect(route('sitemanagement.offerTypes.index'));
    }

    public function show($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('نوع العرض غير موجود');
            return redirect(route('sitemanagement.offerTypes.index'));
        }

        return view('admin_offer_types.show')->with('offerType', $offerType);
    }

    public function edit($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('نوع العرض غير موجود');
            return redirect(route('sitemanagement.offerTypes.index'));
        }

        return view('admin_offer_types.edit')->with('offerType', $offerType);
    }

    public function update($id, Updateoffer_typeRequest $request)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('نوع العرض غير موجود');
            return redirect(route('sitemanagement.offerTypes.index'));
        }

        $this->offerTypeRepository->update($request->all(), $id);

        Flash::success('تم تحديث نوع العرض بنجاح.');

        return redirect(route('sitemanagement.offerTypes.index'));
    }

    public function destroy($id)
    {
        $offerType = $this->offerTypeRepository->find($id);

        if (empty($offerType)) {
            Flash::error('نوع العرض غير موجود');
            return redirect(route('sitemanagement.offerTypes.index'));
        }

        $this->offerTypeRepository->delete($id);

        Flash::success('تم حذف نوع العرض بنجاح.');

        return redirect(route('sitemanagement.offerTypes.index'));
    }
}
