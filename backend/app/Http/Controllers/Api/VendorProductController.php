<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VendorProduct;
use App\Models\Vendor;
use App\Models\User;
use App\Models\Role;
use App\Models\Category;
use App\Models\ProductLimit;
use App\Models\SubCategory;
use App\Models\VendorPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class VendorProductController extends Controller
{
        // 1. LIST PRODUCTS
    // =========================
//     public function index()
//     {
//         $user = Auth::user();

//         if (!$user || !$user->vendor) {
//             return response()->json(['error' => 'Vendor not found'], 404);
//         }

//         $products = VendorProduct::with(['category:id,name', 'subcategory:id,name'])
//         ->where('vendor_id', $user->vendor->id)
//         ->get();

//         return response()->json(
//     $products->map(function ($product) {
//         return [
//             'id' => $product->id,
//             'name' => $product->name,
//             'description' => $product->description,
//             'price' => $product->price,
//             'discount' => $product->discount,
//             'stock' => $product->stock,
//             'image' => $product->image,
//             'category' => $product->category->name ?? null,
//             'subcategory' => $product->subcategory->name ?? null,
//             'created_at' => $product->created_at,
//         ];
//     })
// );

// }


public function index()
{
    $user = Auth::user();

    if (!$user || !$user->vendor) {
        return response()->json(['error' => 'Vendor not found'], 404);
    }

    $products = VendorProduct::with(['category:id,name', 'subcategory:id,name'])
        ->where('vendor_id', $user->vendor->id)
        ->get();

    return response()->json(
        $products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'discount' => $product->discount,
                'stock' => $product->stock,
                'image' => $product->image,
                'category' => $product->category->name ?? null,
                'subcategory' => $product->subcategory->name ?? null,
                'sizes' => $product->sizes ?? [],          // new
                'color' => $product->color ?? [],          // new
                'specification' => $product->specification ?? null,  // new
                'created_at' => $product->created_at,
            ];
        })
    );
}




    // =========================
    // 2. SHOW SINGLE PRODUCT
    // =========================
    public function show($id)
    {
        $vendor = Auth::user()->vendor;
        $product = VendorProduct::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($product->vendor_id != $vendor->id) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        return response()->json($product);
    }

    // =========================
    // 3. STORE PRODUCT
    // =========================
    // public function testBlade(){
    //     return view('test');

    // }


    public function store(Request $request)
    {
        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return response()->json(['error' => 'Vendor not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'vendor_package_id' => 'nullable|exists:vendor_packages,id',
            'images' => 'nullable|array',
            'images.*' => 'image',
        ]);

        $count = VendorProduct::where('vendor_id', $vendor->id)->count();
        $limit = ProductLimit::first();

        if ($vendor->seller_type === 'private' && $limit && $count >= $limit->limit) {
            return response()->json([
                'message' => 'Product limit reached. Please buy a package.'
            ], 403);
        }

        DB::beginTransaction();

        try {

            $vendorPackage = null;

            if ($request->vendor_package_id) {

                $vendorPackage = VendorPackage::where('id', $request->vendor_package_id)
                    ->where('vendor_id', $vendor->id)
                    ->paid()
                    ->active()
                    ->with('package')
                    ->lockForUpdate()
                    ->first();

                if (!$vendorPackage) {
                    return response()->json([
                        'message' => 'Invalid or inactive package'
                    ], 403);
                }

                if ($vendorPackage->product_added >= $vendorPackage->package->product_limit) {
                    return response()->json([
                        'message' => 'Package product limit reached'
                    ], 403);
                }
            }

            $product = new VendorProduct();
            $product->vendor_id = $vendor->id;
            $product->vendor_package_id = $vendorPackage?->id;
            $product->name = $request->name;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discount = $request->discount ?? 0;
            $product->stock = $request->stock;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->meta_title = $request->meta_title;
            $product->meta_description = $request->meta_description;
            $product->product_keyword = $request->product_keyword;
            $product->sizes = $request->sizes ?? [];
            $product->color = $request->colors ?? [];
            $product->specification = $request->specifications ?? null;

            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('upload/products'), $imageName);
                    $imagePaths[] = 'upload/products/' . $imageName;
                }
            }

            $product->image = $imagePaths;
            $product->final_price = $request->price - ($request->price * (($request->discount ?? 0) / 100));
            $product->save();

            if ($vendorPackage) {
                $vendorPackage->increment('product_added');
            }

            DB::commit();

            return response()->json([
                'message' => 'Product added successfully',
                'product' => $product
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }




    // =========================
    // 4. UPDATE PRODUCT
    // =========================
    // public function update(Request $request, $id)
    // {
    //     $vendor = Auth::user()->vendor;
    //     $product = VendorProduct::find($id);

    //     if (!$product) {
    //         return response()->json(['error' => 'Product not found'], 404);
    //     }

    //     if ($product->vendor_id != $vendor->id) {
    //         return response()->json(['error' => 'Not allowed'], 403);
    //     }

    //     if ($request->name) $product->name = $request->name;
    //     if ($request->description) $product->description = $request->description;
    //     if ($request->price) $product->price = $request->price;
    //     if ($request->discount) $product->discount = $request->discount;
    //     if ($request->stock) $product->stock = $request->stock;
    //     if ($request->category_id) $product->category_id = $request->category_id;
    //     if ($request->subcategory_id) $product->subcategory_id = $request->subcategory_id;
    //     if ($request->meta_title) $product->meta_title = $request->meta_title;
    //     if ($request->meta_description) $product->meta_description = $request->meta_description;
    //     if ($request->product_keyword) $product->product_keyword = $request->product_keyword;

    //     // image update
    //     if ($request->hasFile('image')) {

    //         // delete old image
    //         if ($product->image && Storage::disk('public')->exists($product->image)) {
    //             Storage::disk('public')->delete($product->image);
    //         }

    //         $path = $request->file('image')->store('products', 'public');
    //         $product->image = $path;
    //     }

    //     $product->save();

    //     return response()->json([
    //         'message' => 'Product updated successfully',
    //         'product' => $product
    //     ]);
    // }


    public function update(Request $request, $id)
{
    $vendor = Auth::user()->vendor;
    $product = VendorProduct::find($id);

    if (!$product) {
        return response()->json(['error' => 'Product not found'], 404);
    }

    if ($product->vendor_id != $vendor->id) {
        return response()->json(['error' => 'Not allowed'], 403);
    }

    // Basic fields
    if ($request->name) $product->name = $request->name;
    if ($request->description) $product->description = $request->description;
    if ($request->price) $product->price = $request->price;
    if ($request->discount !== null) $product->discount = $request->discount;
    if ($request->stock !== null) $product->stock = $request->stock;
    if ($request->category_id) $product->category_id = $request->category_id;
    if ($request->subcategory_id) $product->subcategory_id = $request->subcategory_id;
    if ($request->meta_title) $product->meta_title = $request->meta_title;
    if ($request->meta_description) $product->meta_description = $request->meta_description;
    if ($request->product_keyword) $product->product_keyword = $request->product_keyword;

    // ✅ New JSON fields
    if ($request->sizes) $product->sizes = $request->sizes;       // array
    if ($request->color) $product->color = $request->colors;       // array
    if ($request->specification) $product->specification = $request->specifications; // string


    if ($request->hasFile('images')) {
        if (is_array($product->image)) {
            foreach ($product->image as $oldImage) {

                if ($oldImage && file_exists(public_path($oldImage))) {
                    @unlink(public_path($oldImage));
                }
            }
        }

       $imagePaths = [];

        foreach ($request->file('images') as $image) {
            if ($image) {

                $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('upload/products'), $imageName);

                $imagePaths[] = 'upload/products/' . $imageName;
            }
        }

        $product->image = $imagePaths;
    }


    $product->save();

    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ]);
}



    // =========================
    // 5. DELETE PRODUCT
    // =========================
    public function destroy($id)
    {
        $vendor = Auth::user()->vendor;
        $product = VendorProduct::find($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        if ($product->vendor_id != $vendor->id) {
            return response()->json(['error' => 'Not allowed'], 403);
        }

        // delete image
        if (is_array($product->image)) {
            foreach ($product->image as $oldImage) {

                if ($oldImage && file_exists(public_path($oldImage))) {
                    @unlink(public_path($oldImage));
                }
            }
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
