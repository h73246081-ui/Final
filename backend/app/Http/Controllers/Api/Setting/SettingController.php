<?php

namespace App\Http\Controllers\Api\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;

class SettingController extends Controller
{
    //
    public function website(){
        $setting = WebsiteSetting::first();
        return response()->json($setting);
    }
}
