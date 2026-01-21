<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Vendor;
use App\Models\VendorProduct;

class CategoryController extends Controller
{
    //
    public function category(){
        $categories = Category::latest()
        ->withCount(['SubCategory', 'products'])
        ->get();
        return response()->json($categories);
    }


public function categorycount()
{
    // Get only 4 categories that have products
    $categories = Category::withCount('products')
                    ->has('products') // only categories with products
                    ->take(4)
                    ->get();

    // Format response
    $data = $categories->map(function($cat) {
        return [
            'id' => $cat->id,
            'name' => $cat->name,
            'image' => $cat->image,
            'products_count' => $cat->products_count,
        ];
    });

    return response()->json([
        'categories' => $data
    ]);
}




    public function categoriesWithSub()
{
        $categories = Category::latest()
        ->with([
            'SubCategory:id,category_id,name',
            'products' => function ($q) {
                $q->select('id','category_id','name','price','image')
                  ->where('stock', '>', 0)
                  ->latest()
                  ->take(3);
            }
        ])
        ->get();

    return response()->json($categories);
}

    //     old 1
    //     public function index()
    // {
    //     $categories = Category::with(['products' => function ($q) {
    //         $q->where('stock', '>', 0)->orderBy('name');
    //     }])->get();

    //     return response()->json($categories);
    // }


    //old 2

    //     public function index(Request $request)
    // {
    //     $query = Category::with(['products' => function ($q) {
    //         $q->where('stock', '>', 0)
    //           ->orderBy('name');
    //     }]);

    //     if ($request->filled('category')) {
    //         $query->where('name', 'LIKE', '%' . $request->category . '%');
    //     }

    //     $categories = $query->get();

    //     return response()->json($categories);
    // }




public function index(Request $request)
{
    // 1️⃣ If subcategory filter is provided
    if ($request->filled('subcategory')) {
        $subcategoryName = $request->subcategory;

        $subcategory = SubCategory::where('name', 'LIKE', '%' . $subcategoryName . '%')->first();

        if (!$subcategory) {
            return response()->json([
                'status' => false,
                'message' => 'Subcategory not found'
            ], 404);
        }

        $products = VendorProduct::where('subcategory_id', $subcategory->id)
                    ->where('stock', '>', 0)
                    ->orderBy('name')
                    ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Products not found for this subcategory'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'subcategory' => $subcategory->name,
            'products' => $products
        ]);
    }

    // 2️⃣ Otherwise, fetch categories + their products + subcategories + subcategory products
    $categories = Category::with([
        'products' => function ($q) {
            $q->where('stock', '>', 0)->orderBy('name');
        },
        'SubCategory' => function ($q) {
            $q->with(['products' => function ($p) {
                $p->where('stock', '>', 0)->orderBy('name');
            }]);
        }
    ])
    ->when($request->filled('category'), function ($q) use ($request) {
        $q->where('name', 'LIKE', '%' . $request->category . '%');
    })
    ->get();

    // Check if any products exist in categories or subcategories
    $hasProducts = $categories->pluck('products')->flatten()->count() +
                   $categories->pluck('SubCategory')->flatten()
                              ->pluck('products')->flatten()->count() > 0;

    if (!$hasProducts) {
        return response()->json([
            'status' => false,
            'message' => 'Products not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'data' => $categories
    ]);
}








    public function allProducts()
    {
        $products = VendorProduct::with(['category', 'vendor'])->where('status','active')->latest()->get();
//         ->whereHas('vendor', function($query) {
//             $query->where('status', '!=',
// 'inactive');
        // })
        // ->latest()
        // ->get();
        return response()->json($products);
    }


public function productDetail($id)
{
    $product = VendorProduct::with(['category', 'vendor'])
        ->where('id', $id)
        ->first();

    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }

    return response()->json($product);
}


public function productsByCategory($id)
{
    $category = Category::with(['products' => function ($q) {
        $q->where('stock', '>', 0)
          ->orderBy('name');
    }])->find($id);

    if (!$category) {
        return response()->json([
            'status' => false,
            'message' => 'Category not found'
        ], 404);
    }

    if ($category->products->isEmpty()) {
        return response()->json([
            'status' => false,
            'message' => 'Products not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'category' => $category->name,
        'products' => $category->products
    ]);
}




    // Recent Products API (session-style, single endpoint)
    public function recentProducts()
    {
        $products = VendorProduct::with(['category','vendor.vendorStore'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json([
            'status' => true,
            'count' => $products->count(),
            'products' => $products
        ]);
    }




}
