<?php

namespace App\Http\Controllers\Api\Admin\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutJourney;

class JournyController extends Controller
{
    //
    public function journy(){
        $journy = AboutJourny::all();
        return response()->json($journy);
    }
}
