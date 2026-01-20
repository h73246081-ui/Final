<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section1;


class Section1Controller extends Controller
{
    //

        // GET /api/section1
    public function index()
    {
        $section = Section1::first();
        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }

}
