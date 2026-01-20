<?php

namespace App\Http\Controllers\Api\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddBlog;

class BlogController extends Controller
{
    //
    public function blog(){
        $blogs = AddBlog::all();
        return response()->json($blogs);
    }
    public function blogDetail($id){
        $blog = AddBlog::find($id);
        return response()->json($blog);
    }
}
