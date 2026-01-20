<?php

namespace App\Http\Controllers\Admin\Cms\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddBlog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //

    public function create(){
        return view('admin.cms.blog.create');
    }

    public function index(){
        $blogs = AddBlog::latest()->get();
        return view('admin.cms.blog.index', compact('blogs'));
    }
        public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'date' => 'required|date',
            'description' => 'required',
            'image' => 'nullable|image',
            'author_image' => 'nullable|image',
        ]);

        $data = $request->only(['title','author','date','description']);

        if ($request->hasFile('image')) {
            // if($testimonial->image){
            //     $path=public_path($testimonial->image);
            //     if($path){
            //         unlink($path);
            //     }
            // }
            $image=$request->file('image');
            $imageName=uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/blog'),$imageName);
            $data['image'] = 'upload/blog/'.$imageName;
        }
        if ($request->hasFile('author_image')) {
            $image1=$request->file('author_image');
            $imageName1=uniqid().'.'.$image1->getClientOriginalExtension();
            $image1->move(public_path('upload/blog'),$imageName1);
            $data['author_image'] = 'upload/blog/'.$imageName1;
        }


        AddBlog::create($data);

        return redirect()->back()->with('success', 'Blog added successfully');
    }

    public function edit($id){
        $blog = AddBlog::find($id);
        return view('admin.cms.blog.edit', compact('blog'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
        'author' => 'required',
        'date' => 'required|date',
        'description' => 'required',
        'image' => 'nullable|image',
        'author_image' => 'nullable|image',
    ]);

    $blog = AddBlog::findOrFail($id);

    $data = $request->only(['title','author','date','description']);

    if ($request->hasFile('image')) {
        if($blog->image){
            $path=public_path($blog->image);
            if($path){
                unlink($path);
            }
        }
        $image=$request->file('image');
        $imageName=uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/blog'),$imageName);
        $data['image'] = 'upload/blog/'.$imageName;
    }
    if ($request->hasFile('author_image')) {
        if($blog->author_image){
            $path=public_path($blog->author_image);
            if($path){
                unlink($path);
            }
        }
        $image1=$request->file('author_image');
        $imageName1=uniqid().'.'.$image1->getClientOriginalExtension();
        $image1->move(public_path('upload/blog'),$imageName1);
        $data['author_image'] = 'upload/blog/'.$imageName1;
    }

    $blog->update($data);

    return redirect()->route('cms.blog.index')->with('success', 'Blog updated successfully');
}

public function destroy($id)
{
    $blog = AddBlog::findOrFail($id);
    if($blog->image){
        $path=public_path($blog->image);
        if($path){
            unlink($path);
        }
    }
    if($blog->author_image){
        $path=public_path($blog->author_image);
        if($path){
            unlink($path);
        }
    }



    $blog->delete();

    return redirect()->back()->with('success', 'Blog deleted successfully');
}


}
