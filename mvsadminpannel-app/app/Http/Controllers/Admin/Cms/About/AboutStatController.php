<?php

namespace App\Http\Controllers\Admin\Cms\About;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutStat;

class AboutStatController extends Controller
{
    //
  
        // Show edit form
    public function AboutStat()
    {

        $stats = AboutStat::all(); 
        return view('admin.cms.about.stat', compact('stats'));
    }

    public function updateAll(Request $request)
    {
        $statsData = $request->input('stats');

        foreach ($statsData as $data) {
            $stat = AboutStat::find($data['id']); 
            if ($stat) {
                $stat->update([
                    'icon' => $data['icon'],
                    'value' => $data['value'],
                    'suffix' => $data['suffix'],
                    'label' => $data['label'],
                    'color' => $data['color'],
                ]);
            }
        }

        return redirect()->back()->with('success', 'About Stats updated successfully!');
    }
}
