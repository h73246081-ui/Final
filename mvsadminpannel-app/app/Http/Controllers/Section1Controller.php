<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section1;

class Section1Controller extends Controller
{
    //
 
    
public function index()
{
    $categories = Category::all();
    $section = Section1::first(); // Agar sirf ek record ka data chahiye
    return view('admin.cms.home.categorysection_1.index', compact('categories', 'section'));
}

public function store(Request $request)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
    ]);

    $category = Category::find($request->category_id);

    // Agar sirf ek record update karna hai, ya first record ko create/update karna hai
    $section = Section1::first();
    if ($section) {
        $section->update(['name' => $category->name]);
    } else {
        Section1::create(['name' => $category->name]);
    }

    return redirect()->back()->with('success', 'Category saved to Section 1!');
}
   
}
