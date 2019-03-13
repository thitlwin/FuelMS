<?php

namespace PowerMs\Http\Controllers;

use Illuminate\Http\Request;

use PowerMs\Http\Requests;
use PowerMs\Http\Requests\ContactRequest;
use Mail;

class ContactController extends Controller
{
     public function sentContactInfo(ContactRequest $request)
    {   
    
      $data =$request->all();
      $data['messageLines'] = explode("\n", $request->get('message'));
    //dd($data['messageLines']);

    Mail::send('email.contact', $data, function ($message) use ($data) {
      $message->subject('Contact Form: '.$data['name'])
              ->to('bitsmanager2015@gmail.com')
              ->From($data['email']);
    });
      toast()->success("Thank you for your message. It has been sent.");
       return redirect()->back();
  }
}
