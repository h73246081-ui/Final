<?php

namespace App\Http\Controllers\Admin\PrivateSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PrivateSeller;

class PrivateSellerController extends Controller
{
    public function allPrivateSeller(){
        $privateSeller=PrivateSeller::with('user')->latest()->get();
        return view('admin.privateSellers.allPrivateSeller',compact('privateSeller'));
    }
}
