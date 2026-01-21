<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreMessage;
use App\Models\Vendor;
class VendorMessageController extends Controller
{
    public function storeMessage(Request $request){
        $request->validate([
            'message'=>'required'
        ]);
        $message=new StoreMessage();
        $userId=auth()->id();
        $message->user_id=$userId;
        $message->vendor_id=$request->vendor_id;
        $message->message=$request->message;
        if($request->subject){
            $message->subject=$request->subject;
        }
        $message->save();
        return response()->json([
            'message'=>'Data Stored'
        ]);
    }
    public function allMessage(){
        $vendorId=auth()->id();
        $vendor=Vendor::where('user_id',$vendorId)->first();
        $message=StoreMessage::where('vendor_id',$vendor->id)->with('user')->get();
        return response()->json([
            'message'=>$message
        ]);
    }
    public function reply(Request $request, $id){
        $userId=auth()->id();
        $vendor=Vendor::where('user_id',$userId)->first();
        $message=StoreMessage::where('vendor_id',$vendor->id)->where('id',$id)->first();
        if(!$message){
            return response()->json([
                'message'=>'fail'
            ]);
        }
        $message->reply=$request->reply;
        $message->save();
        return response()->json([
            'message'=>'reply successfull'
        ]);
    }
    public function customerMessage(){
        $customer=auth()->id();
        $message=StoreMessage::where('user_id',$customer)->with('vendor.vendorStore')->get();
        return response()->json([
            'message'=>'Customer Messages',
            'message'=>$message
        ]);
    }
}
