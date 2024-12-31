<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategorieController extends Controller implements HasMiddleware
{


    public static function middleware():array
    {
        return[
            new Middleware('permission:view categories',only:['index']),
            new Middleware('permission:create categories',only:['create','store']),
            new Middleware('permission:update categories',only:['edit','update']),
            new Middleware('permission:delete categories',only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories=Categorie::latest()->paginate(10);
        return view('categories.list',[
            'categories'=>$categories
        ]);
    }
    //api
    public function showall(){
        try {
            $categories=Categorie::all();
            return response()->json($categories);
            } catch (\Exception $e) {
            return response()->json("probleme de récupération de la liste des catégories");
        }
    }
    public function show($id){
        try {
            $categorie=Categorie::findOrFail($id);
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de récupération de la catégorie");
        }
    }
    //
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories|min:3', // Make sure name is unique
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // Ensure image is required and has a valid format
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('categories.create')
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Create a new category instance
        $categorie = new Categorie();
        $categorie->name = $request->name;
        $categorie->description = $request->description;
    
        // Handle the image upload if provided
        if ($request->hasFile('image')) {
            // Read the image file as binary data
            $image = $request->file('image');
            $imageData = file_get_contents($image->getRealPath());
    
            // Store the binary image data in the database
            $categorie->image = $imageData;
        }
    
        // Update the status based on checkbox value
        $categorie->isActive = $request->has('isActive') ? true : false;
    
        // Save the new category
        $categorie->save();
    
        // Redirect to the categories index page with success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }
    

    public function edit($id){
        $categorie=Categorie::findOrFail($id);
        return view('categories.edit',[
            'categorie'=>$categorie
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $id . '|min:3', // Ignore current category ID for uniqueness
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // Make image optional
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('categories.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }
    
        // Find the category to update
        $categorie = Categorie::findOrFail($id);
        $categorie->name = $request->name;
        $categorie->description = $request->description;
    
        // Handle image upload if new image is provided
        if ($request->hasFile('image')) {
            // Read the image as binary data if uploaded
            $image = $request->file('image');
            $imageData = file_get_contents($image->getRealPath());
    
            // Store the binary image data in the database
            $categorie->image = $imageData;
        }
    
        // Update the status based on checkbox value
        $categorie->isActive = $request->has('isActive') ? true : false;
    
        // Save the category
        $categorie->save();
    
        // Redirect to the categories index page with success message
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $categorie=Categorie::findOrFail($request->id);
        if($categorie==null){
            session()->flash('error','Category not found');
            return response()->json(['status'=>false]);
        }

        $categorie->delete();
        session()->flash('success','Category deleted successfully');
        return response()->json(['status'=>true]);
    }
}
