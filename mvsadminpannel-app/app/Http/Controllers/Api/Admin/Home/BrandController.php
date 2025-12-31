<?php

namespace App\Http\Controllers\Api\Admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    //
    public function brand(){
        $brands = Brand::all();
        return response()->json($brands);
    }
}
