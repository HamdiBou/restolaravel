<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class roleController extends Controller
{
    public function index(){
        $roles=Role::orderBy('name','ASC')->paginate(10);
        return view('roles.list',[
            'roles'=>$roles
        ]);
    }
    public function create(){
        $permissions=Permission::orderBy('name','ASC')->get();
        return view('roles.create',[
            'permissions'=>$permissions
        ]);
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:roles|min:3',
        'permissions' => 'array', // Validate permissions as an array if provided
        'permissions.*' => 'string|exists:permissions,name', // Ensure each permission is valid
    ]);

    if ($validator->fails()) {
        return redirect()->route('roles.create')
            ->withInput()
            ->withErrors($validator);
    }

    // Create the role
    $role = Role::create(['name' => $request->name]);

    // Attach permissions if provided
    if (!empty($request->permissions)) {
        foreach ($request->permissions as $permissionName) {
            $role->givePermissionTo($permissionName);
        }
    }

    return redirect()->route('roles.index')
        ->with('success', 'Role created successfully');
}

    public function edit($id){
        $roles =Role::findOrFail($id);
        $haspermissions=$roles->permissions->pluck('name');
        $permissions=Permission::orderBy('name','ASC')->get();
        return view('roles.edit',[
            'roles'=>$roles,
            'permissions'=>$permissions,
            'haspermissions'=>$haspermissions
        ]);
    }
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'permissions' => 'array', // Validate permissions as an array if provided
            'permissions.*' => 'string|exists:permissions,name', // Ensure each permission is valid
        ]);
        if ($validator->fails()) {
            return redirect()->route('roles.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }
        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($request->permissions);
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
            }
    public function destroy(Request $request){
        $id=$request->id;
        $role = Role::findOrFail($id);
        if($role == null){
            session()->flash('error','Role not found');
            return response()->json([
                'message'=>'Role not found'
            ],404);
        }

        $role->delete();
        session()->flash('success','Role deleted successfully');
        return response()->json([
            'message'=>'Role deleted successfully'
        ],200);
    }

}
