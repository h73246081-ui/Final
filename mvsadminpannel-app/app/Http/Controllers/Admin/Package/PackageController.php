<?php

namespace App\Http\Controllers\Admin\Package;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\VendorPackage;
use App\Models\Vendor;
use Carbon\Carbon;

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.package', compact('packages'));
    }

    /**
     * Store a newly created package.
     */
    public function store(Request $request)
    {
        $request->validate([
            'package_name'        => 'required|string|max:100',
            'price'               => 'required|numeric|min:0',
            'duration'            => 'required|integer|min:1',
            'product_limit'       => 'required|integer|min:1',
            'commission_percent'  => 'required|numeric|min:0|max:100',
            'status'              => 'required|in:active,inactive',
        ]);

        Package::create([
            'package_name'       => $request->package_name,
            'price'              => $request->price,
            'duration'           => $request->duration,
            'product_limit'      => $request->product_limit,
            'commission_percent' => $request->commission_percent,
            'status'             => $request->status,
        ]);

        return redirect()->back()->with('success', 'Package created successfully.');
    }

    /**
     * Update the specified package.
     */
    public function update(Request $request, $id)
    {
        $package = Package::findOrFail($id);

        $request->validate([
            'package_name'        => 'required|string|max:100',
            'price'               => 'required|numeric|min:0',
            'duration'            => 'required|integer|min:1',
            'product_limit'       => 'required|integer|min:1',
            'commission_percent'  => 'required|numeric|min:0|max:100',
            'status'              => 'required|in:active,inactive',
        ]);

        $package->update([
            'package_name'       => $request->package_name,
            'price'              => $request->price,
            'duration'           => $request->duration,
            'product_limit'      => $request->product_limit,
            'commission_percent' => $request->commission_percent,
            'status'             => $request->status,
        ]);

        return redirect()->back()->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package (Soft Delete).
     */
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->back()->with('success', 'Package deleted successfully.');
    }

    // package from vendor dashbaord post api
    public function packageAwale(Request $request, $id){
        $package=new VendorPackage;
        $vendorId=auth()->id();
        $vendor=Vendor::where('user_id',$vendorId)->first();
        $package->vendor_id=$vendor->id;
        $package->package_id=$id;
        if($request->payment_method){
            $package->payment_method=$request->payment_method;
        }
        if($request->amount){
            $package->amount=$request->amount;
        }
        $package->card_number=$request->card_number;
        $package->cvv=$request->cvv;
        $package->name_on_card=$request->name_on_card;
        if($request->expiry_date){
            $package->expiry_date=$request->expiry_date;

        }

        $package->save();
        return response()->json([
            'message'=>'Package Store Successfully!'
        ]);
    }

    public function vendorPackage(){
        $pack=Package::with('vendorPackages.vendor.vendorStore')->get();
        return view('admin.packages.vendorPackage',compact('pack'));
    }
}
