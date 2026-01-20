<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section3;

class Section3Controller extends Controller
{
    //
        //
   public function index(){
     $categories = Category::all();
    $section = Section3::first(); // Agar sirf ek record ka data chahiye
    return view('admin.cms.home.categorysection_3.index', compact('categories','section'));
   }
   public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
    ]);

    $category = Category::find($request->category_id);

    // Agar sirf ek record update karna hai, ya first record ko create/update karna hai
    $section = Section3::first();
    if ($section) {
        $section->update(['name' => $category->name]);
    } else {
        Section3::create(['name' => $category->name]);
    }

    return redirect()->back()->with('success', 'Category saved to Section 3!');
}
}
