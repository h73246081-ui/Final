<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Role;
use App\Models\User;

 
class VendorProfileController extends Controller
{
    //
    public function vendor(){
     
          $vendors = Vendor::with('user')->get(); // user relation bhi load kar rahe hain


        return view('admin.vendor.vendor', compact('vendors'));
    }
}
