<?php

namespace App\Http\Controllers\Api\Admin\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutTeam;

class AboutTeamController extends Controller
{
    //
    public function index(){
        $teams = AboutTeam::latest()->get();
        return response()->json($teams);
    }
}
