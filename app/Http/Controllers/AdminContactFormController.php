<?php

namespace App\Http\Controllers;

use App\DataTables\AdminContactFormDataTable;
use App\Http\Requests\CreateContactFormRequest;
use App\Http\Requests\UpdateContactFormRequest;
use App\Repositories\ContactFormRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AdminContactFormController extends AppBaseController
{
    /** @var ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepo)
    {
        $this->contactFormRepository = $contactFormRepo;
        $this->middleware('adminfCheckAdmin');
    }

    public function index(AdminContactFormDataTable $contactFormDataTable)
    {
        return $contactFormDataTable->render('admin_contact_forms.index');
    }

    public function create()
    {
        return view('admin_contact_forms.create');
    }

    public function store(CreateContactFormRequest $request)
    {
        $input = $request->all();
        $contactForm = $this->contactFormRepository->create($input);

        Flash::success('تم حفظ الرسالة بنجاح.');
        return redirect(route('sitemanagement.contactForms.index'));
    }

    public function show($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('الرسالة غير موجودة');
            return redirect(route('sitemanagement.contactForms.index'));
        }

        return view('admin_contact_forms.show')->with('contactForm', $contactForm);
    }

    public function edit($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('الرسالة غير موجودة');
            return redirect(route('sitemanagement.contactForms.index'));
        }

        return view('admin_contact_forms.edit')->with('contactForm', $contactForm);
    }

    public function update($id, UpdateContactFormRequest $request)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('الرسالة غير موجودة');
            return redirect(route('sitemanagement.contactForms.index'));
        }

        $contactForm = $this->contactFormRepository->update($request->all(), $id);

        Flash::success('تم تحديث الرسالة بنجاح.');
        return redirect(route('sitemanagement.contactForms.index'));
    }

    public function destroy($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('الرسالة غير موجودة');
            return redirect(route('sitemanagement.contactForms.index'));
        }

        $this->contactFormRepository->delete($id);

        Flash::success('تم حذف الرسالة بنجاح.');
        return redirect(route('sitemanagement.contactForms.index'));
    }
}
