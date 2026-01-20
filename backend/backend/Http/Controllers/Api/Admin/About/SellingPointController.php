<?php

namespace App\Http\Controllers\Api\Admin\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SettingPoint;

class SellingPointController extends Controller
{
    //
    public function index(){
        $sellings = SellingPoint::all();
        return response()->json($sellings);
    }
}
