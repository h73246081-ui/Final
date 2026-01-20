<?php

namespace App\Http\Controllers\Admin\Cms\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\HomeSetting;
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
            $image=$request->file('image_bw');
            $imageName=uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/brand'),$imageName);
            $data['image_bw'] = 'upload/brand/'.$imageName;
        }
        if ($request->hasFile('image_color')) {
            $image1=$request->file('image_color');
            $imageName1=uniqid().'.'.$image1->getClientOriginalExtension();
            $image1->move(public_path('upload/brand'),$imageName1);
            $data['image_color'] = 'upload/brand/'.$imageName1;
        }

        Brand::create($data);

        return redirect()->route('cms.brand.index')->with('success', 'Brand added successfully.');
    }


    public function index(){
        $brands = Brand::latest()->get();
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
        if($brand->image_bw){
            $path=public_path($brand->image_bw);
            if($path){
                unlink($path);
            }
        }
        $image=$request->file('image_bw');
        $imageName=uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/brand'),$imageName);
        $data['image_bw'] = 'upload/brand/'.$imageName;
    }
    if ($request->hasFile('image_color')) {
        if($brand->image_color){
            $path1=public_path($brand->image_color);
            if($path1){
                unlink($path1);
            }
        }
        $image1=$request->file('image_color');
        $imageName1=uniqid().'.'.$image1->getClientOriginalExtension();
        $image1->move(public_path('upload/brand'),$imageName1);
        $data['image_color'] = 'upload/brand/'.$imageName1;
    }



    $brand->update($data);

    return redirect()->route('cms.brand.index')->with('success', 'Brand updated successfully.');
}

public function destroy(Brand $brand) {
    $brand->delete();
    return redirect()->route('cms.brand.index')->with('success', 'Brand deleted successfully.');
}

public function editHero()
    {
        $hero = HomeSetting::first(); // assuming only 1 row
        return view('admin.cms.home.heroSection.edit', compact('hero'));
    }

}
