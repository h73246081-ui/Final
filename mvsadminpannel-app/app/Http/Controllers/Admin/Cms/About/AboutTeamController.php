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
            'initial' => 'nullable|string|max:1',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'image' => 'nullable',
        ]);

        $data = $request->only('initial','name','role');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team','public');
        }

        AboutTeam::create($data);

        return redirect()->route('cms.about.team')->with('success','Team member added');
    }

    public function destroy($id)
{
    $team = AboutTeam::findOrFail($id);


    if ($team->image && \Storage::disk('public')->exists($team->image)) {
        \Storage::disk('public')->delete($team->image);
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
            'image' => 'nullable|image|max:2048',
        ]);

    $data = $request->only(['initial','name','role']);

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('team', 'public');
    }

    $team->update($data);

    return redirect()->route('cms.about.team')->with('success', 'Team updated successfully!');
}


}
