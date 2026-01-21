<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section3;

class Section3Controller extends Controller
{
    //
            // GET /api/section1
    public function index()
    {
        $section = Section3::first();
        return response()->json([
            'success' => true,
            'data' => $section
        ]);
    }
}
