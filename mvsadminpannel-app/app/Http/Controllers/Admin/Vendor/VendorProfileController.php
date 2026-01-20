<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Role;
use App\Models\User;
use App\Models\VendorStore;
use App\Models\VendorProduct;


class VendorProfileController extends Controller
{
    //
    public function vendor(){
        $vendors = Vendor::with('user','vendorStore')->where('seller_type','private')->latest()->get();
        return view('admin.vendor.vendor', compact('vendors'));
    }
    // all buisness seller
    public function Buisnessvendor(){
        $vendors = Vendor::with('user','vendorStore')->where('seller_type','business')->latest()->get();
        return view('admin.vendor.vendor', compact('vendors'));
    }

    public function redtrictVendor($id){
        $vendor=Vendor::find($id);
        $vendor->update([
            'status'=>'Restrict'
        ]);
        if($vendor){
            $vendorStore = VendorStore::where('vendor_id', $vendor->id)->first();
            if ($vendorStore) {
                $vendorStore->update([
                    'status' => 'Restrict'
                ]);
            }

        }
        return redirect()->back();
    }

    public function activateVendor($id){
        $vendor=Vendor::find($id);
        $vendor->update([
            'status'=>'Approved'
        ]);
        if($vendor){
            $vendorStore = VendorStore::where('vendor_id', $vendor->id)->first();
            if ($vendorStore) {
                $vendorStore->update([
                    'status' => 'Approved'
                ]);
            }

        }
        return redirect()->back();
    }
    public function deleteVendor($id){
        $vendor=Vendor::find($id);
        if($vendor->user){
            $vendor->user->delete();
        }
        $vendor->delete();
        return redirect()->back();
    }
    public function toggleStatus(Request $request)
    {
        $vendor = Vendor::find($request->id);
        if($vendor){
        $vendor->status = $request->status;
        if($request->status=='active'){
            $vendor->seller_type="business";
        }else{
            $vendor->seller_type="private";
        }



        $vendor->save();
        if($vendor->status=='active'){
            $store=VendorStore::where('vendor_id',$vendor->id)->first();
            $store->status='active';
            $store->save();
            $products=VendorProduct::where('vendor_id',$vendor->id)->get();
            foreach($products as $product){
                $product->status='active';
                $product->save();

            }

        }else{
            $store=VendorStore::where('vendor_id',$vendor->id)->first();
            $store->status='inactive';
            $store->save();
            $products=VendorProduct::where('vendor_id',$vendor->id)->get();
            foreach($products as $product){
                $product->status='inactive';
                $product->save();

            }
        }
        return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }


}
