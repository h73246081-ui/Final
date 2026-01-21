<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\VendorPolicie;
use App\Models\Order;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\VendorOrder;
use App\Models\VendorStore;
use Illuminate\Support\Facades\Validator;
use App\Models\VendorPackage;

class VendorController extends Controller
{
    public function vendorDashboardCard(){
        $user_id=auth()->id();
        $vendor=Vendor::where('user_id',$user_id)->first();
        $product=VendorProduct::where('vendor_id',$vendor->id)->count();
        // total sale
        $sale=VendorOrder::where('vendor_id',$vendor->id)->sum('vendor_total');
        // total orders
        $order=VendorOrder::where('vendor_id',$vendor->id)->count();
        // store status
        $status=VendorStore::where('vendor_id',$vendor->id)->first();
        // recent orders
        $recent=VendorOrder::where('vendor_id',$vendor->id)->with('order','items')->limit(5)->latest()->get();
        return response()->json([
            'total_products'=>$product,
            'sales'=>$sale,
            'orders'=>$order,
            'store'=>$status,
            'recent_orders'=>$recent
        ]);

    }

    public function allPackage(){
        $package=Package::latest()->get();
        return response()->json([
            'message'=>'All Packages',
            'data'=>$package
        ]);
    }
    public function purchasedPackage(){
        $userId=auth()->id();
        $vendor=Vendor::where('user_id',$userId)->first();
        $vendorPackage = VendorPackage::where('vendor_id', $vendor->id)
        ->with('package')
        ->get();
        return response()->json([
            'awale_package'=>$vendorPackage
        ]);
    }
    public function packagedProduct(){
        $products=VendorProduct::whereHas('vendorPackage', fn($q) => $q->active()->paid())->get();
        return response()->json([
            'products'=>$products
        ]);
    }




    // vendor policies
    public function allPolicy(){
        $data=PrivacyAndPolicy::latest()->get();
        return view('admin.privacyPolicy.indexPrivacyPolicy',compact('data'));
    }
    public function allVendorPolicy(){
        $data=VendorPolicie::latest()->get();
        return response()->json([
            'data'=>$data
        ]);
    }
    public function storePolicy(Request $request){
        $request->validate([
            'title'=>'required',
            'content'=>'required'
        ]);
        $userId=auth()->id();
        $vendorId=Vendor::where('user_id',$userId)->first();

        $data=new VendorPolicie;
        $data->vendor_id=$vendorId->id;
        $data->title=$request->title;
        $data->content=$request->content;
        $data->save();
        return response()->json([
            'message'=>'store successfully'
        ]);
    }
    public function editPolicy($id){
        $term = VendorPolicie::find($id);
        return response()->json($term);
    }
    public function updatePolicy(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'content'=>'required'
        ]);
        $data=VendorPolicie::find($id);
        $data->title=$request->title;
        $data->content=$request->content;
        $data->save();
        return response()->json([
            'message'=>'Updated'
        ]);
    }

    public function deletePolicy($id){
        $data=VendorPolicie::find($id);
        $data->delete();
        return response()->json([
            'message'=>'Deleted '
        ]);;
    }

    // vendor verified
    public function vendorRegister(Request $request){
        try{
            $validator=Validator::make($request->all(),[
                'name'=>'required|string',
                'ntn_number'=>'required|string',
                'cnic_number'=>'required|string',
                'city'=>'required|string',
                'country'=>'required|string',
                'address'=>'required|string',
                'cnic_front'=>'nullable|image',
                'cnic_back'=>'nullable|image',
                'bank_name'=>'required',
                'bank_account'=>'required'
            ]);
            if($validator->fails()){
                return response()->json([
                    'status'=>'fail',
                    'error'=>$validator->errors()
                ]);
            }
            $userId=auth()->id();
            $vendor=Vendor::where('user_id',$userId)->first();
            if(!$vendor){
                return response()->json([
                    'message'=>'Vendor Not Found'
                ]);
            }
            $vendor->name=$request->name;
            $vendor->ntn_number=(string) $request->ntn_number;
            $vendor->cnic_number=(string) $request->cnic_number;
            $vendor->address=$request->address;
            $vendor->city=$request->city;
            $vendor->country=$request->country;
            $vendor->bank_name=$request->bank_name;
            $vendor->bank_account=(string) $request->bank_account;
            if($request->hasFile('cnic_front')){
                $image=$request->file('cnic_front');
                $imageName=uniqid().'.'.$image->getClientOriginalExtension();
                $image->move(public_path('upload/cnic'),$imageName);
                $vendor->cnic_front='upload/cnic/'.$imageName;
            }
            if($request->hasFile('cnic_back')){
                $image1=$request->file('cnic_back');
                $imageName1=uniqid().'.'.$image1->getClientOriginalExtension();
                $image1->move(public_path('upload/cnic'),$imageName1);
                $vendor->cnic_back='upload/cnic/'.$imageName1;
            }
            $vendor->seller_type='private';
            $vendor->save();
            return response()->json([
                'message'=>'Success'
            ],200);
        }catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }

    }
    public function getVendorData(){
        $userId=auth()->id();
        $vendor=Vendor::where('user_id',$userId)->first();
        return response()->json([
            'data'=>$vendor
        ]);
    }






}
