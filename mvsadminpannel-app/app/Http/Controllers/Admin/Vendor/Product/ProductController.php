<?php

namespace App\Http\Controllers\Admin\Vendor\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;

class ProductController extends Controller
{
    //
   public function index(){
    $products = VendorProduct::with('vendor')->latest()->get();
    return view('admin.vendor.product.index', compact('products'));
   }
   public function show($id){
    $product = VendorProduct::with(['vendor', 'category'])->findOrFail($id);
    return view('admin.vendor.product.view', compact('product'));
}

}
