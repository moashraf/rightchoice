<?php

namespace App\Http\Controllers;

use App\DataTables\ContactFormDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateContactFormRequest;
use App\Http\Requests\UpdateContactFormRequest;
use App\Repositories\ContactFormRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;
use Spatie\Activitylog\Models\Activity;

class ContactFormController extends AppBaseController
{
    /** @var  ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepo)
    {
        $this->contactFormRepository = $contactFormRepo;
    }

    /**
     * Display a listing of the ContactForm.
     *
     * @param ContactFormDataTable $contactFormDataTable
     * @return Response
     */
    public function index(ContactFormDataTable $contactFormDataTable)
    {
        return $contactFormDataTable->render('contact_forms.index');
    }

    /**
     * Show the form for creating a new ContactForm.
     *
     * @return Response
     */
    public function create()
    {
        return view('contact_forms.create');
    }

    /**
     * Store a newly created ContactForm in storage.
     *
     * @param CreateContactFormRequest $request
     *
     * @return Response
     */
    public function store(CreateContactFormRequest $request)
    {
        $input = $request->all();

        $contactForm = $this->contactFormRepository->create($input);

        Flash::success('Contact Form saved successfully.');

        return redirect(route('contactForms.index'));
    }

    /**
     * Display the specified ContactForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('Contact Form not found');

            return redirect(route('contactForms.index'));
        }

        return view('contact_forms.show')->with('contactForm', $contactForm);
    }

    /**
     * Show the form for editing the specified ContactForm.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('Contact Form not found');

            return redirect(route('contactForms.index'));
        }
        $activity_logs = Activity::forSubject($contactForm)->orderBy('id','DESC')->paginate(10);

        return view('contact_forms.edit',compact('activity_logs'))
            ->with('contactForm', $contactForm,);
    }

    /**
     * Update the specified ContactForm in storage.
     *
     * @param  int              $id
     * @param UpdateContactFormRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactFormRequest $request)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('Contact Form not found');

            return redirect(route('contactForms.index'));
        }

        $contactForm = $this->contactFormRepository->update($request->all(), $id);
        activity()
            ->causedBy(Auth::user())
            ->performedOn($contactForm)
            ->tap(function(Activity $activity) use ($request) {
                $activity->comment = $request->comment;
            })
            ->log('edited');

        Flash::success('Contact Form updated successfully.');

        return redirect(route('contactForms.index'));
    }

    /**
     * Remove the specified ContactForm from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            Flash::error('Contact Form not found');

            return redirect(route('contactForms.index'));
        }

        $this->contactFormRepository->delete($id);

        Flash::success('Contact Form deleted successfully.');

        return redirect(route('contactForms.index'));
    }
}
