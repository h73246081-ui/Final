<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    //
    public function SubCategory(){
        $subcategories = SubCategory::latest()->get();
        return response()->json($subcategories);
    }
}
