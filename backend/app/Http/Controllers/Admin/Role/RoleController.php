<?php

namespace App\Http\Controllers\Admin\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
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
        $roles = Role::with('permissions')->latest()->get();
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

    public function allPermission(){
        $permission=Permission::latest()->get();
        return view('admin/roles/permission',compact('permission'));
    }
    public function storePermission(Request $request){
        $request->validate([
           'name' => 'required',
       ]);

       $permission = new Permission();
       $permission->name = $request->name;
       $permission->save();

      return redirect()->route('allPermission')->with('success', 'Permission created successfully.');

    }
    public function updatePermission(Request $request , $id){
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->save();
        return redirect()->route('allPermission')->with('success', 'Permission Updated successfully');
     }
     public function destroyPermission($id)
     {
         $permission = Permission::findOrFail($id);
         $permission->delete();

         return redirect()->route('allPermission')
                          ->with('warning', 'Permission deleted successfully.');
     }
     public function editPermissions($id)
     {
         $role = Role::with('permissions')->findOrFail($id);
         $permissions = Permission::all();

         return view('admin.roles.assignPermission', compact('role', 'permissions'));
     }

     public function assignPermissions(Request $request, $roleId)
     {
         $role = Role::findOrFail($roleId);

         // Validate input
         $request->validate([
             'permissions' => 'nullable|array',
             'permissions.*' => 'exists:permissions,id'
         ]);

         // Sync permissions (this will add/remove permissions as needed)
         $role->permissions()->sync($request->permissions ?? []);

         return redirect()->route('role.index')->with('success', 'Permissions assigned successfully!');
     }


}
