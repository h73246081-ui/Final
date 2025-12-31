<?php

namespace App\Http\Controllers\Admin\Vendor\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorStore;
use App\Models\VendorProduct;

class StoreController extends Controller
{
    //
    public function index(){
          // Get all stores with products count
        $stores = VendorStore::withCount('vendorProducts')->get();
        return view('admin.vendor.stores.index', compact('stores'));
    }

    
    public function show($id){
        $store = VendorStore::with('vendorProducts')->findOrFail($id);
        return view('admin.vendor.stores.view', compact('store'));
    }


}
