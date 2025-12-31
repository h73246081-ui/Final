<?php

namespace App\Http\Controllers\Admin\Cms\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    //

    public function create(){
        return view('admin.cms.home.brand.create');
    }


        public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_bw' => 'nullable|image|mimes:png,jpg,jpeg',
            'image_color' => 'nullable|image|mimes:png,jpg,jpeg',
        ]);

        $data = $request->only('name');

        if ($request->hasFile('image_bw')) {
            $data['image_bw'] = $request->file('image_bw')->store('brands', 'public');
        }
        if ($request->hasFile('image_color')) {
            $data['image_color'] = $request->file('image_color')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('cms.brand.index')->with('success', 'Brand added successfully.');
    }


    public function index(){
        $brands = Brand::all();
        return view('admin.cms.home.brand.index', compact('brands'));
    }

    public function edit(Brand $brand) {
    return view('admin.cms.home.brand.edit', compact('brand'));
}

public function update(Request $request, Brand $brand) {
    $request->validate([
        'name' => 'required|string|max:255',
        'image_bw' => 'nullable|image|mimes:png,jpg,jpeg',
        'image_color' => 'nullable|image|mimes:png,jpg,jpeg',
    ]);

    $data = $request->only('name');

    if ($request->hasFile('image_bw')) {
        $data['image_bw'] = $request->file('image_bw')->store('brands', 'public');
    }
    if ($request->hasFile('image_color')) {
        $data['image_color'] = $request->file('image_color')->store('brands', 'public');
    }

    $brand->update($data);

    return redirect()->route('cms.brand.index')->with('success', 'Brand updated successfully.');
}

public function destroy(Brand $brand) {
    $brand->delete();
    return redirect()->route('cms.brand.index')->with('success', 'Brand deleted successfully.');
}


}
