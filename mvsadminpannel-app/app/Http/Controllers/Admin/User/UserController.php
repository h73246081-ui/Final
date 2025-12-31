<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::with('role')
        ->where('role_id', '!=', 1) 
        ->latest()->get();
        return view('admin.users.index', compact('users'));
    }
    public function delete($id){
       $user = User::find($id);
       $user->delete();
       return redirect()->route('user.index')->with('warning', 'user deleted successfully!');
    }
}
