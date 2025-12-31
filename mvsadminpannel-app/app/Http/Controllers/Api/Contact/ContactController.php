<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactInfo;
use App\Models\ContactSocial;

class ContactController extends Controller
{
    //
        public function contact(Request $request){

         $validator = Validator::make($request->all(),[
            'name' => 'nullable',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'
         ]);

         if($validator->fails()){
             return response()->json([
                'status' => false,
                 'errors' => $validator->errors(),
             ],422);
         }

         $contact = new Contact();
         $contact->name = $request->name;
         $contact->email = $request->email;
         $contact->subject = $request->subject;
         $contact->message = $request->message;
         $contact->save();

          return response()->json([
            'status' => true,
            'message' => 'Thank you for contacting us. We will get back to you soon.',
            'data' => $contact
          ]);
    }


    public function ContactInfo(){

        $contact = ContactInfo::all();
        return response()->json($contact);

    }

        public function ContactSocial(){

        $contact = ContactSocial::all();
        return response()->json($contact);

    }

}
