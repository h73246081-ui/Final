<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FlashDeal;
use App\Models\Category;
use App\Models\VendorProduct;


class FlashDealController extends Controller
{
    //

        public function index()
    {
        // Fetch only active deals within current date
        $deals = FlashDeal::with(['category:id,name', 'product:id,name,price,image'])
            ->where('is_active', 1)
            // ->where('start_at', '<=', now())
            // ->where('end_at', '>=', now())
            // ->orderBy('start_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'count' => $deals->count(),
            'data' => $deals
        ]);
    }



    public function getProductsByCategory($categoryId)
{
    $products = VendorProduct::where('category_id', $categoryId)
        ->where('stock', '>', 0)
        ->select('id', 'name')
        ->orderBy('name')
        ->get();

    return response()->json($products);
}




 

}
