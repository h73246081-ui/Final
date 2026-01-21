<?php

namespace App\Http\Controllers\Admin\Cms\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellingPoint;

class AboutValueController extends Controller
{
    //
    public function create(){
        return view('admin.cms.about.values.create');
    }
        public function store(Request $request){

     $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

       $data = $request->only('title','description','icon');

        SellingPoint::create($data);

        return redirect()->route('cms.about.value')->with('success','About value added');

    }


    public function index(){
        $points = SellingPoint::latest()->get();
        return view('admin.cms.about.values.index', compact('points'));
    }


    public function edit($id){
       $selling = SellingPoint::find($id);
       return view('admin.cms.about.values.edit', compact('selling'));
    }


    public function update(Request $request, $id){

     $request->validate([
            'title' => 'nullable|string|max:255',
            'icon' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        
        $selling = SellingPoint::find($id);
        $selling->title = $request->title;
        $selling->icon = $request->icon;
        $selling->description = $request->description;

        $selling->save();

        return redirect()->route('cms.about.value')->with('success','About Value updated');

    }

     public function delete($id){

        $selling = SellingPoint::find($id);
        $selling->delete();
        return redirect()->route('cms.about.value')->with('warning','About Value deleted');

    }
}
