<?php

namespace App\Http\Controllers\Api\Admin\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function testimonial(){
        $testimonials = Testimonial::latest()->get();
        return response()->json($testimonials);
    }
}
