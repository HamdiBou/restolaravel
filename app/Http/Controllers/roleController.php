<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class roleController extends Controller implements HasMiddleware
{

    public static function middleware():array
    {
        return[
            new Middleware('permission:view roles',only:['index']),
            new Middleware('permission:create roles',only:['create']),
            new Middleware('permission:update roles',only:['edit']),
            new Middleware('permission:delete roles',only:['destroy']),
        ];
    }
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->paginate(10);
        return view('roles.list', [
            'roles' => $roles
        ]);
    }
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.create', [
            'permissions' => $permissions
        ]);
    }
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => [
            'required',
            'unique:roles,name',
            'min:3'
        ],
        'permissions' => [
            'sometimes', // Optional field
            'array'
        ],
        'permissions.*' => [
            'string',
            'exists:permissions,name' // Ensures valid permission names
        ],
    ], [
        'name.required' => 'The role name is required.',
        'name.unique' => 'This role name is already in use.',
        'name.min' => 'The role name must be at least 3 characters.',
        'permissions.*.exists' => 'One or more permissions are invalid.',
    ]);

    if ($validator->fails()) {
        return redirect()->route('roles.create')
            ->withInput()
            ->withErrors($validator);
    }

    try {
        // Create the role
        $role = Role::create(['name' => $request->name]);

        // Attach permissions if provided
        if ($request->filled('permissions')) {
            $role->givePermissionTo($request->permissions); // Efficient way to assign permissions
        }

        return redirect()->route('roles.index')
            ->with('success', __('Role created successfully.'));
    } catch (\Exception $e) {
        return redirect()->route('roles.create')
            ->withInput()
            ->with('error', __('An error occurred while creating the role.'));
    }
}


    public function edit($id)
    {
        $roles = Role::findOrFail($id);
        $haspermissions = $roles->permissions->pluck('name');
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('roles.edit', [
            'roles' => $roles,
            'permissions' => $permissions,
            'haspermissions' => $haspermissions
        ]);
    }
    public function update(Request $request, $id)
    {
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
        $role->syncPermissions($request->permissions); // Efficient way to update permissions
        $role->save();
        
        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
    public function destroy(Request $request)
    {
        $id = $request->id;
        $role = Role::findOrFail($id);
        if ($role == null) {
            session()->flash('error', 'Role not found');
            return response()->json([
                'message' => 'Role not found'
            ], 404);
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully');
        return response()->json([
            'message' => 'Role deleted successfully'
        ], 200);
    }
}
