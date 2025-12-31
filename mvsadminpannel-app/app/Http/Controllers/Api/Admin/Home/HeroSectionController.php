<?php
namespace App\Http\Controllers\Api\Admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;

class HeroSectionController extends Controller
{
    //
        public function index()
    {
        $hero = HomeSetting::first(); // assuming only 1 row
        return response()->json($hero);
    }
}
