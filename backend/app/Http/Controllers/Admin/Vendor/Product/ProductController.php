<?php

namespace App\Http\Controllers\Admin\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Category;


class ProductController extends Controller
{
    //
   public function index(){
        $products = VendorProduct::with('vendor.vendorStore','vendor.user')->latest()->get();
        $categories=Category::latest()->get();
        return view('admin.vendor.product.index', compact('products','categories'));
   }
   public function toggleStatus(Request $request)
    {
        $product = VendorProduct::find($request->id);
        if($product){
        $product->status = $request->status;
        $product->save();
        return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
   public function show($id){
        $product = VendorProduct::with(['vendor.vendorStore',
        'vendor.user', 'category'])->findOrFail($id);
        return view('admin.vendor.product.view', compact('product'));
    }

}
