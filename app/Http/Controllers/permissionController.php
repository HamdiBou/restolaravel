<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class permissionController extends Controller
{
    //
    public function index(){
        $permissions = Permission::orderBy('created_at','DESC')->paginate(3);
        return view('permissions.list',[
            'permissions' => $permissions
        ]);
    }
    public function create(){
        return view('permissions.create');
    }
    public function store(Request $request){
        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:permissions|min:3',
        ]);
        if($validator->passes()){
            Permission::create(['name' =>$request->name]);
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
        }else{
            return redirect()->route('permissions.create')->withInput()->withErrors($validator);
        }
    }
    public function edit($id){
        $permissions = Permission::findOrFail($id);
        return view('permissions.edit',[
            'permissions' => $permissions
            ]);
    }
    public function update($id,Request $request){
        $permissions =Permission::FindOrFail($id);

        $validator =Validator::make($request->all(),[
            'name' => 'required|unique:permissions,name,'.$id.',id|min:3',
        ]);
        if($validator->passes()){
           // Permission::create(['name' =>$request->name]);
           $permissions->name=$request->name;
           $permissions->save();
            return redirect()->route('permissions.index')->with('success','Permission created successfully');
        }else{
            return redirect()->route('permissions.edit',$id)->withInput()->withErrors($validator);
        }
    }
    public function destroy(Request $request){
        $id=$request->id;
        $permissions=Permission::Find($id);
        if($permissions==null){
            session()->flash('error','permission not found');
            return response()->json([
                'status' => false,
            ]);
        }
        $permissions->delete();
            session()->flash('success','permission deleted successfully');
            return response()->json([
                'status' => true,
            ]);
        
    }
}