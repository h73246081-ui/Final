<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    //
        //
    public function create(){
        return view('admin.roles.create');
    }
        public function store(Request $request){
        $request->validate([
           'name' => 'required|unique:roles,name|max:255',
       ]);
   
       $role = new Role();
       $role->name = $request->name;
       $role->save();

      return redirect()->route('role.index')->with('success', 'Role created successfully.');
      
    }
        public function index(){
        $roles = Role::latest()->get();
        return view('admin.roles.index', compact('roles'));
    }
            public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.manage')
                         ->with('warning', 'Role deleted successfully.');
    }

    public function edit($id){
       $role = Role::find($id);
       return view('admin.roles.edit', compact('role'));
    }
    public function update(Request $request , $id){
       $role = Role::find($id);
       $role->name = $request->name;
       $role->save();
       return redirect()->route('role.index')->with('success', 'Role Updated successfully');
    }
}
