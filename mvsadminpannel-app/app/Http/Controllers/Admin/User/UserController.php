<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validate;
use App\Models\Vendor;

class UserController extends Controller
{
    //
    public function index(){
        $users = User::with('role')
        ->where('role_id', '!=', 1)
        ->latest()->get();
        $roles = Role::all();
        return view('admin.users.index', [
            'users'=>$users,
            'roles'=>$roles
        ]);
    }
    public function delete($id){
       $user = User::find($id);
       $user->delete();
       return redirect()->route('user.index')->with('warning', 'user deleted successfully!');
    }
    public function storeUser(Request $request)
{
    $request->validate([
        'name'      => 'required|string|max:255',
        'last_name' =>'nullable|string',
        'email'     => 'required|email|unique:users,email',
        'phone'     => 'nullable|string|max:20',
        'role_id'   => 'required|exists:roles,id',
        'password'  => 'required|string|min:6|confirmed',
    ]);


    /** Create User **/
    $user = User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'phone'     => $request->phone,
        'last_name'   => $request->last_name,
        'password'  => Hash::make($request->password),
    ]);
    if($user){
        $vendor=Vendor::create([
            'user_id'=>$user->id
        ]);
    }

    $user->role_id = $request->role_id;
    $user->save();

    return redirect()->back()->with('success', 'User created successfully');
}


// public function create()
// {
//     $roles = Role::all();
//     return view('admin.users.index', compact('roles'));
// }
}
