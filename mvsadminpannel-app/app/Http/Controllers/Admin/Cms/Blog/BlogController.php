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
        $blogs = AddBlog::all();
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
            $data['image'] = $request->file('image')->store('blogs', 'public');
        }

        if ($request->hasFile('author_image')) {
            $data['author_image'] = $request->file('author_image')->store('authors', 'public');
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

    // Blog image update
    if ($request->hasFile('image')) {
        // Optional: Delete old image
        if ($blog->image && \Storage::disk('public')->exists($blog->image)) {
            \Storage::disk('public')->delete($blog->image);
        }
        $data['image'] = $request->file('image')->store('blogs', 'public');
    }

    // Author image update
    if ($request->hasFile('author_image')) {
        // Optional: Delete old author image
        if ($blog->author_image && \Storage::disk('public')->exists($blog->author_image)) {
            \Storage::disk('public')->delete($blog->author_image);
        }
        $data['author_image'] = $request->file('author_image')->store('authors', 'public');
    }

    $blog->update($data);

    return redirect()->route('cms.blog.index')->with('success', 'Blog updated successfully');
}

public function destroy($id)
{
    $blog = AddBlog::findOrFail($id);

    // Delete images from storage
    if ($blog->image && \Storage::disk('public')->exists($blog->image)) {
        \Storage::disk('public')->delete($blog->image);
    }

    if ($blog->author_image && \Storage::disk('public')->exists($blog->author_image)) {
        \Storage::disk('public')->delete($blog->author_image);
    }

    $blog->delete();

    return redirect()->back()->with('success', 'Blog deleted successfully');
}


}
