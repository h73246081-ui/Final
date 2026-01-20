<?php

namespace App\Http\Controllers\Api\Admin\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutStat;

class AboutStatController extends Controller
{
    //
    public function AboutStat(){
      $AboutStat = AboutStat::all();
      return response()->json($AboutStat);
    }
}
