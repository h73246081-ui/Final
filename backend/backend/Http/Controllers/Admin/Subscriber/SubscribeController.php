<?php

namespace App\Http\Controllers\Admin\Subscriber;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscribeController extends Controller
{
    public function storeSubscribe(Request $request){
        $data= $request->validate([
            'email'=>'required'
        ]);
        $subscribe=Subscriber::create($data);
        return response()->json([
            'message'=>'store'
        ]);
    }
    public function allSub(){
        $sub=Subscriber::latest()->get();
        return view('admin.subscriber.allSubscriber',compact('sub'));
    }
    public function delete($id){
        $sub=Subscriber::find($id);
        $sub->delete();
        return redirect()->back();
    }

}
