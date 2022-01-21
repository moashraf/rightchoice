<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContactFormAPIRequest;
use App\Http\Requests\API\UpdateContactFormAPIRequest;
use App\Models\ContactForm;
use App\Repositories\ContactFormRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ContactFormController
 * @package App\Http\Controllers\API
 */

class ContactFormAPIController extends AppBaseController
{
    /** @var  ContactFormRepository */
    private $contactFormRepository;

    public function __construct(ContactFormRepository $contactFormRepo)
    {
        $this->contactFormRepository = $contactFormRepo;
    }

    /**
     * Display a listing of the ContactForm.
     * GET|HEAD /contactForms
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $contactForms = $this->contactFormRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($contactForms->toArray(), 'Contact Forms retrieved successfully');
    }

    /**
     * Store a newly created ContactForm in storage.
     * POST /contactForms
     *
     * @param CreateContactFormAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateContactFormAPIRequest $request)
    {
        $input = $request->all();

        $contactForm = $this->contactFormRepository->create($input);

        return $this->sendResponse($contactForm->toArray(), 'Contact Form saved successfully');
    }

    /**
     * Display the specified ContactForm.
     * GET|HEAD /contactForms/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var ContactForm $contactForm */
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            return $this->sendError('Contact Form not found');
        }

        return $this->sendResponse($contactForm->toArray(), 'Contact Form retrieved successfully');
    }

    /**
     * Update the specified ContactForm in storage.
     * PUT/PATCH /contactForms/{id}
     *
     * @param int $id
     * @param UpdateContactFormAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContactFormAPIRequest $request)
    {
        $input = $request->all();

        /** @var ContactForm $contactForm */
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            return $this->sendError('Contact Form not found');
        }

        $contactForm = $this->contactFormRepository->update($input, $id);

        return $this->sendResponse($contactForm->toArray(), 'ContactForm updated successfully');
    }

    /**
     * Remove the specified ContactForm from storage.
     * DELETE /contactForms/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var ContactForm $contactForm */
        $contactForm = $this->contactFormRepository->find($id);

        if (empty($contactForm)) {
            return $this->sendError('Contact Form not found');
        }

        $contactForm->delete();

        return $this->sendSuccess('Contact Form deleted successfully');
    }
}
