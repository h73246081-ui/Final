<?php

namespace App\Http\Controllers\Api\Admin\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\SellingPoint;
use App\Models\AboutJourney;

class MissionController extends Controller
{
    //
        public function mission(){
        $mission = Mission::first();
        return response()->json($mission);
    }

    public function index(){
        $selling = SellingPoint::all();
        return response()->json($selling);
    }
        public function journy(){
        $journy = AboutJourney::all();
        return response()->json($journy);
    }
}
