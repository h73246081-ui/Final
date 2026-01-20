<?php

namespace App\Http\Controllers\Admin\Cms\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutJourney;

class AboutJourneyController extends Controller
{
    //

    public function create(){
        return view('admin.cms.about.journey.create');
    }


    public function store(Request $request){

     $request->validate([
            'title' => 'nullable|string|max:255',
            'year' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

       $data = $request->only('title','description','year');

        AboutJourney::create($data);

        return redirect()->route('cms.about.journey')->with('success','About Journey added');

    }


    public function journey(){
        $abouts = AboutJourney::latest()->get();
        return view('admin.cms.about.journey.index', compact('abouts'));
    }

    public function edit($id){
       $journey = AboutJourney::find($id);
       return view('admin.cms.about.journey.edit', compact('journey'));
    }

    public function update(Request $request, $id){

     $request->validate([
            'title' => 'nullable|string|max:255',
            'year' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        
        $journey = AboutJourney::find($id);
        $journey->title = $request->title;
        $journey->year = $request->year;
        $journey->description = $request->description;

        $journey->save();

        return redirect()->route('cms.about.journey')->with('success','About Journey updated');

    }

     public function delete($id){

        $journey = AboutJourney::find($id);
        $journey->delete();
        return redirect()->route('cms.about.journey')->with('warning','About Journey deleted');

    }

}
