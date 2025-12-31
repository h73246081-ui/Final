<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    //
    public function WebsiteSetting(){
        $setting = WebsiteSetting::first();
        return view('admin.setting.website-setting', compact('setting'));
    }

        // Update settings
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:255',
            'contact'   => 'nullable|string|max:255',
            'logo'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'address'   => 'nullable|string|max:300',
            'direction_address' => 'nullable|string|max:300',
            'direction_link' => 'nullable|string',
            'support_hours' => 'nullable|string|max:255',
            'facebook'  => 'nullable|string|max:255',
            'twitter'   => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'tiktok'    => 'nullable|string|max:255',
            'youtube'   => 'nullable|string|max:255',
            'linkedin'  => 'nullable|string|max:255',
        ]);

        $setting = WebsiteSetting::first() ?? new WebsiteSetting();

        $setting->site_name = $request->site_name;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->contact = $request->contact;
        $setting->address = $request->address;
        $setting->direction_address = $request->direction_address;
        $setting->direction_link = $request->direction_link;
        $setting->support_hours = $request->support_hours;
        $setting->facebook = $request->facebook;
        $setting->twitter = $request->twitter;
        $setting->instagram = $request->instagram;
        $setting->tiktok = $request->tiktok;
        $setting->youtube = $request->youtube;
        $setting->linkedin = $request->linkedin;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            $imageName = 'logo_' . time() . '.' . $request->file('logo')->getClientOriginalExtension();
            $request->file('logo')->storeAs('Website_logo', $imageName, 'public');
            $setting->logo = 'logo/' . $imageName;
        }

        $setting->save();

        return redirect()->route('website.setting')->with('success', 'Settings updated successfully.');
    }
}
