<?php

namespace App\Http\Controllers;

use App\DataTables\ContactFormDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateContactFormRequest;
use App\Http\Requests\UpdateContactFormRequest;
use App\Repositories\ContactFormRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class adController extends AppBaseController
{
    /** @var  ContactFormRepository */
    private $contactFormRepository;
    public function index2(){
        return view('ads_forms.index');
    }
    public function __construct()
    {
    }

    /**
     * Display a listing of the ContactForm.
     *
     * @param ContactFormDataTable $contactFormDataTable
     * @return Response
     */
    public function index()
    {
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
  
    }
}
