<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str; 

class SubCategoryController extends Controller
{
    //
    public function create(){
        $categories = Category::latest()->get();
        return view('admin.subcategories.create', compact('categories'));
    }

   
public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required',
        'name' => 'required',
    ]);

    SubCategory::create([
        'category_id' => $request->category_id,
        'name' => $request->name,
        'description' => $request->description,
        'question_description' => $request->question_description,
        'meta_title' =>  $request->meta_description,
        'meta_description' => $request->meta_description,
         'meta_keyword' => $request->meta_keyword,
        'slug' => Str::slug($request->name),
    ]);

    return redirect()->route('subcategory.index')->with('success', 'Subcategory created!');
}

    public function index(){
        $subcategories = SubCategory::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.subcategories.index', compact('subcategories','categories'));
    }


        public function edit($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $categories = \App\Models\Category::all(); // For category dropdown
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    // Update method
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
        ]);

        $subcategory = SubCategory::findOrFail($id);
        $subcategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
            'question_description' => $request->question_description,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keyword' => $request->meta_keyword,
        ]);

        return redirect()->route('subcategory.index')->with('success', 'Subcategory updated!');
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $subcategory->delete();

        return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted!');
    }


}
