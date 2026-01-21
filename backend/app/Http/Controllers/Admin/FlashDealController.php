<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashDeal;
use App\Models\Category;
use App\Models\VendorProduct;
use Carbon\Carbon;

class FlashDealController extends Controller
{
    //

    //     public function __construct()
    // {
    //     $this->middleware('auth');
    //     $this->middleware(function ($request, $next) {
    //         if (auth()->user()->role !== 'admin') {
    //             abort(403, 'Unauthorized');
    //         }
    //         return $next($request);
    //     });
    // }


        public function index()
    {
        $deals = FlashDeal::with('category', 'product')->latest()->get();
        $categories = Category::latest()->get();
        $products = VendorProduct::latest()->get();
        return view('admin.flash_deals.index', compact('deals', 'categories', 'products'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = VendorProduct::all();
        return view('admin.flash_deals.create', compact('categories', 'products'));
    }

 
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'product_id' => 'nullable|exists:vendor_products,id',
        'discount' => 'required|numeric|min:0',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after:start_at',
    ]);

    $data = $request->all();

    // Convert checkbox to integer
    $data['is_active'] = $request->has('is_active') ? 1 : 0;

    FlashDeal::create($data);

    return redirect()->route('flash.index')->with('success', 'Flash deal created successfully');
}


    public function edit($id)
    {
        $categories = Category::all();
        $products = VendorProduct::all();
        $deal = FlashDeal::find($id);
        return view('admin.flash_deals.edit', compact('deal', 'categories', 'products'));
    }

 



public function update(Request $request, $id)
{
    // Validation
    $request->validate([
        'title' => 'required|string|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'product_id' => 'nullable|exists:vendor_products,id',
        'discount' => 'required|numeric|min:0|max:100',
        'start_at' => 'required|date',
        'end_at' => 'required|date|after:start_at',
        'is_active' => 'nullable|boolean',
    ]);

    // Find the existing flash deal
    $flash = FlashDeal::findOrFail($id);

    // Fill data using new instance approach
    $data = $request->all();
    $data['is_active'] = $request->has('is_active') ? 1 : 0;

    // Update using fill() + save()
    $flash->fill($data)->save();

    return redirect()->back()->with('success', 'Flash deal updated successfully');
}




    public function destroy($id)
    {
        $flashDeal = FlashDeal::find($id);
        $flashDeal->delete();
        return redirect()->route('flash.index')->with('warning', 'Flash deal deleted successfully');
    }


}
