<?php

namespace App\Http\Controllers\Admin\Cms\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stat;

class StatController extends Controller
{
    // Show edit form
    public function edit()
    {

        $stats = Stat::all(); 
        return view('admin.cms.home.stats.edit', compact('stats'));
    }

    public function updateAll(Request $request)
    {
        $statsData = $request->input('stats');

        foreach ($statsData as $data) {
            $stat = Stat::find($data['id']); 
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

        return redirect()->back()->with('success', 'Stats updated successfully!');
    }
}
