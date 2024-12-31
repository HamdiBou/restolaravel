<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\Middleware;

class userController extends Controller implements HasMiddleware
{

    public static function middleware():array
    {
        return[
            new Middleware('permission:view users',only:['index','show']),
            //new Middleware('permission:create users',only:['create','store']),
            new Middleware('permission:update users',only:['edit','update']),
           // new Middleware('permission:delete users',only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::latest()->paginate(10);
        return view('users.list', ['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users=User::FindOrFail($id);
        $roles=Role::orderBy('name','ASC')->get();
        $hasRoles=$users->roles->pluck('id');
        return view('users.edit', ['users'=>$users,'roles'=>$roles,'hasRoles'=>$hasRoles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id.',id',
        ]);
        if($validator->fails()){
            return redirect()->route('users.edit',$id)
                             ->withErrors($validator)
                             ->withInput();
        }
        $user=User::FindOrFail($id);
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->save();

        $user->syncRoles($request->input('roles'));
        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
