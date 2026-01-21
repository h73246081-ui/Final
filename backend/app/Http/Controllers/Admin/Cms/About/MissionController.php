<?php

namespace App\Http\Controllers\Admin\Cms\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;

class MissionController extends Controller
{
    //
    public function mission(){
        $mission = Mission::first();
        return view('admin.cms.about.mission', compact('mission'));
    }


    public function update(Request $request)
{
      $request->validate([
            'title' => 'required|string|max:255',
        ]);

    $mission = Mission::first() ?? new Mission();

    $mission->title = $request->title;
    $mission->description = $request->description;



    $mission->save();

    return redirect()->back()->with('success', 'Our Mission updated successfully.');
}

}
