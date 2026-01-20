<?php

namespace App\Http\Controllers\Admin\Cms\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutTeam;

class AboutTeamController extends Controller
{
    //
    public function create(){
        return view('admin.cms.about.team.create');
    }

    public function index(){
        $teams = AboutTeam::latest()->get();
        return view('admin.cms.about.team.index', compact('teams'));
    }

        public function store(Request $request)
    {
        $request->validate([
            'initial' => 'nullable|string',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $data = $request->only('initial','name','role');

        if ($request->hasFile('image')) {
            $image=$request->file('image');
            $imageName=uniqid().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/team'),$imageName);
            $data['image'] = 'upload/team/'.$imageName;
        }

        AboutTeam::create($data);

        return redirect()->back()->with('success','Team member added');
    }

    public function destroy($id)
{
    $team = AboutTeam::findOrFail($id);


    if($team->image){
        $path=public_path($team->image);
        if($path){
            unlink($path);
        }
    }
    $team->delete();

    return redirect()->route('cms.about.team')
        ->with('warning', 'About team deleted successfully!');
}

public function edit($id){
   $team = AboutTeam::find($id);
   return view('admin.cms.about.team.edit', compact('team'));
}

    public function update(Request $request, $id)
{
    $team = AboutTeam::findOrFail($id);

      $request->validate([
            'initial' => 'nullable|string|max:1',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

    $data = $request->only(['initial','name','role']);

    if ($request->hasFile('image')) {
        if($team->image){
            $path=public_path($team->image);
            if($path){
                unlink($path);
            }
        }
        $image=$request->file('image');
        $imageName=uniqid().'.'.$image->getClientOriginalExtension();
        $image->move(public_path('upload/team'),$imageName);
        $data['image'] = 'upload/team/'.$imageName;
    }

    $team->update($data);

    return redirect()->route('cms.about.team')->with('success', 'Team updated successfully!');
}


}
