<?php

namespace App\Http\Controllers\Admin\Cms\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;
use App\Models\Banner;

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
    // Reply to contact query
    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->reply = $request->reply;
        $contact->status = 'replied';
        $contact->replied_at = now();
        $contact->save();

        Mail::raw($request->reply, function ($message) use ($contact) {
            $message->to($contact->email)
                    ->subject('Reply to your query');
        });

        return redirect()->back()->with('success', 'Reply sent successfully & email delivered!');
    }
    // all bananers
    public function editBanner(){
        $banner=Banner::first();
        return view('admin.cms.banner.editBanner',compact('banner'));
    }
    public function updateBanner(Request $request)
    {
        $banner = Banner::firstOrCreate(['id' => 1]);
        $banner->update($request->all());

        return back()->with('success', 'Banners updated successfully');
    }
    public function bannerApi(){
        $banner=Banner::first();
        return repsonse()->json([
            'bannner'=>$banner
        ]);
    }


}



