<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Models\ContactForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
Use Redirect;

class PagesController extends Controller
{
    //
    public function index()
    {   
        $terms = Pages::where('id', 1)->get();
        //dd($terms);
        return view('terms-conditions', compact('terms'));
    }

    public function about()
    {   
        $about = Pages::where('id', 2)->get();
        //dd($terms);
        return view('about-us', compact('about'));
    }

    public function contact()
    {   
        $terms = Pages::where('id', 1)->get();
        //dd($terms);
        return view('contact-us', compact('terms'));
    }

    public function store(Request $request){
        $locale=   app()->getLocale();

        $contact = new ContactForm();

        $validator = Validator::make($request->all(), [
            'name' => 'nullable',
            'email' => 'required|email',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'subject' => 'required',
            'body' => 'nullable',
            ]);



            if(!$validator->fails())
            {
                $contact->phone = request('phone');
                $contact->email = request('email');
                $contact->subject = request('subject');
                $contact->body = request('body');

                $contact->save();

                session()->flash('success', 'تم تلقى الرساله و سوف يتم التواصل');
                return redirect($locale."/contact-us")->with('status', '  تم الحفظ بنجاح!');
           
            }else{
                return Redirect::back()->withErrors($validator)->withInput($request->input());
           
            }

           


    }
}
