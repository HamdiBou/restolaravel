<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
class ArticleController extends Controller implements HasMiddleware
{

    public static function middleware():array
    {
        return[
            new Middleware('permission:view roles',only:['index','show']),
            new Middleware('permission:create roles',only:['create','store']),
            new Middleware('permission:update roles',only:['edit','update']),
            new Middleware('permission:delete roles',only:['destroy']),
        ];
    }
    // Show all articles
    public function index()
    {
        $articles = Article::latest()->paginate(10); // Retrieve all articles
        return view('articles.list', ['articles'=>$articles]);
    }

    // Show the form to create a new article
    public function create()
    {
        $categories = Categorie::all(); // Retrieve all categories
        return view('articles.create', compact('categories'));
    }

    // Store the newly created article
    public function store(Request $request)
    {
        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:articles|min:3',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return redirect()->route('articles.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        // Handle image upload as binary data
        $imageData = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = file_get_contents($image->getRealPath());
        }

        // Create the article
        Article::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageData,
            'isActive' => $request->has('isActive') ? true : false,
            'price' => $request->price,
            'stock' => $request->stock,
            'categorie_id' => $request->categorie_id,
        ]);

        // Redirect back to the articles list with success message
        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }

    // Show the form to edit an existing article
    public function edit($id)
    {
        $article = Article::findOrFail($id); // Find the article by ID
        $categories = Categorie::all(); // Retrieve all categories
        return view('articles.edit', compact('article', 'categories'));
    }

    // Update an existing article
    public function update(Request $request, $id)
    {
        // Validate the data
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|unique:articles,name,' . $id,
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        // If validation fails
        if ($validator->fails()) {
            return redirect()->route('articles.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        // Find the article
        $article = Article::findOrFail($id);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = file_get_contents($image->getRealPath());
            $article->image = $imageData;
        }

        // Update article data
        $article->name = $request->name;
        $article->description = $request->description;
        $article->isActive = $request->has('isActive') ? true : false;
        $article->price = $request->price;
        $article->stock = $request->stock;
        $article->categorie_id = $request->categorie_id;

        // Save the changes
        $article->save();

        // Redirect back to the articles list with success message
        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');
    }

    // Delete an article
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }
}
