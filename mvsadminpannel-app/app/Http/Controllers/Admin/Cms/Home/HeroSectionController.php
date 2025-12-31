<?php

namespace App\Http\Controllers\Admin\Cms\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;

class HeroSectionController extends Controller
{
    //
       // Show edit form
    public function edit()
    {
        $hero = HomeSetting::first(); // assuming only 1 row
        return view('admin.cms.home.hero_section.edit', compact('hero'));
    }

    // // Update hero section
    public function update(Request $request)
    {
        $request->validate([
            'badge' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $hero = HomeSetting::first();
        if (!$hero) {
            $hero = HomeSetting::create($request->all());
        } else {
            $hero->update($request->all());
        }

        return redirect()->back()->with('success', 'Hero section updated successfully!');
    }
}
