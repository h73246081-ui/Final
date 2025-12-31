<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //

    public function create(){
        return view('admin.categories.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only([
            'name',
            'description',
            'question_description',
            'meta_title',
            'meta_description',
            'meta_keyword',
        ]);

      
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                                     ->store('categories', 'public');
        }

        Category::create($data);

        return redirect()
            ->route('category.index')
            ->with('success', 'Category added successfully');
    }




    public function show(){
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function edit($id){
      $category = Category::find($id);
      return view('admin.categories.edit', compact('category'));
    }


    public function update(Request $request, $id)
{
    $category = Category::findOrFail($id);

    $data = $request->only([
        'name',
        'description',
        'question_description',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ]);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')
                                 ->store('categories', 'public');
    }

    $category->update($data);

    return redirect()
        ->route('category.index')
        ->with('success', 'Category updated successfully');
}



public function destroy($id)
{
    $category = Category::findOrFail($id);

    // Delete image from storage
    if ($category->image && Storage::disk('public')->exists($category->image)) {
        Storage::disk('public')->delete($category->image);
    }

    // Delete category from database
    $category->delete();

    return redirect()
        ->route('category.index')
        ->with('warning', 'Category deleted successfully');
}


}
