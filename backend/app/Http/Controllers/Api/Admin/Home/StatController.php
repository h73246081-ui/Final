<?php

namespace App\Http\Controllers\Api\Admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stat;

class StatController extends Controller
{
    //
    public function stats(){
         $stats = Stat::all(); 
         return response()->json($stats);
    }
}
