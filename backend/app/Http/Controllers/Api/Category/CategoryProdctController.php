<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\VendorProduct;

class CategoryProdctController extends Controller
{
    //
        public function index()
    {
        $categories = Category::with(['products' => function ($q) {
            $q->where('stock', '>', 0)->orderBy('name');
        }])->get();

        return response()->json($categories);
    }
}
