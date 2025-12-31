<?php

namespace App\Http\Controllers\Admin\Cms\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    //
    public function create(){
        return view('admin.cms.home.testimonials.create');
    }
   
 
        public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name'       => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'location'   => 'nullable|string|max:255',
            'rating'     => 'required|integer|between:1,5',
            'comments'   => 'required|string',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // File Upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        // Create Testimonial
        Testimonial::create([
            'name'       => $request->name,
            'role' => $request->profession,
            'location'   => $request->location,
            'rating'     => $request->rating,
            'comments'   => $request->comments,
            'avatar'      => $imagePath,
        ]);

        return redirect()->route('cms.testimonial.index')->with('success', 'Testimonial added successfully!');
    }

    public function index(){
        $testimonials = Testimonial::latest()->get();
        return view('admin.cms.home.testimonials.index', compact('testimonials'));
    }

    public function edit($id){
        $testimonial = Testimonial::find($id);
        return view('admin.cms.home.testimonials.edit', compact('testimonial'));
    }


    public function update(Request $request, $id)
{
    $testimonial = Testimonial::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'comments' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'image' => 'nullable|image|max:2048'
    ]);

    $data = $request->only(['name','role','location','rating','comments']);

    if ($request->hasFile('image')) {
        $data['avatar'] = $request->file('image')->store('testimonials', 'public');
    }

    $testimonial->update($data);

    return redirect()->route('cms.testimonial.index')->with('success', 'Testimonial updated successfully!');
}

public function destroy($id)
{
    $testimonial = Testimonial::findOrFail($id);


    if ($testimonial->image && \Storage::disk('public')->exists($testimonial->image)) {
        \Storage::disk('public')->delete($testimonial->image);
    }

    $testimonial->delete();

    return redirect()->route('cms.testimonial.index')
        ->with('warning', 'Testimonial deleted successfully!');
}


}
