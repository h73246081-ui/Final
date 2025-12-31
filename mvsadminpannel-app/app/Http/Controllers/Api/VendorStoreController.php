<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorStore;
use App\Models\VendorProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VendorStoreController extends Controller
{
    //
        public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        // Basic validation
        if (!$request->store_name) {
            return response()->json(['error' => 'Store name is required'], 422);
        }

        $request->validate([
            'store_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            // 'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $store = new VendorStore();
        $store->vendor_id = $vendor->id;
        $store->store_name = $request->store_name;
        // $store->slug = Str::slug($request->store_name);
        $store->email = $request->email;
        $store->phone = $request->phone;
        $store->description = $request->description;
        $store->address = $request->address;
        $store->response_rate = $request->response_rate ?? 0;
        // $store->date = $request->date;

        // Image upload (same logic as product)
        if ($request->hasFile('logo')) {

            if ($store->image) {
                $oldPath = public_path($store->image);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $image = $request->file('logo');
            $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('upload/vendorstore'), $imageName);
            $store->image = 'upload/vendorstore/' . $imageName;
        }

        $store->save();

        return response()->json([
            'message' => 'Vendor store created successfully',
            'store' => $store
        ], 201);
    }

    public function myStore()
{
    $vendor = Auth::user()->vendor;

    if (!$vendor) {
        return response()->json(['error' => 'Vendor not found'], 404);
    }

    $store = VendorStore::where('vendor_id', $vendor->id)->first();

    if (!$store) {
        return response()->json(['message' => 'Store not found'], 404);
    }

    return response()->json([
        'store' => $store
    ], 200);
} 



public function allStores()
{
    // Fetch all vendor stores
    $stores = VendorStore::all()->map(function($store) {
        $store->products_count = VendorProduct::where('vendor_id', $store->vendor_id)->count();
        return $store;
    });

    return response()->json([
        'stores' => $stores
    ], 200);
}


public function storeDetail($id)
{
    // Fetch single store with products
    $store = VendorStore::with(['vendorProducts'])->find($id);

    if (!$store) {
        return response()->json([
            'message' => 'Store not found'
        ], 404);
    }

    return response()->json([
        'store' => $store
    ], 200);
}




}
