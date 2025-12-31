<?php

namespace App\Http\Controllers\Admin\Cms\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    //
    public function contact(){
        $contacts = Contact::latest()->get();
        return view('admin.cms.contact.message', compact('contacts'));
    }
        public function destroy($id)
{
    $contact = Contact::findOrFail($id);
    $contact->delete();

    return redirect()->back()->with('warning', 'Contact deleted successfully.');
}
}
