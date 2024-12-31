<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PublicCategorieController extends Controller
{
    public function index()
    {
        try {
            $categories = Categorie::where('isActive', true)
                ->select('id', 'name', 'description', 'image')
                ->get();

            return response()->json([
                'status' => 'success',
                'data' => $categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'image' => $category->image ? base64_encode($category->image) : null
                    ];
                })
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve categories'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $category = Categorie::where('isActive', true)
                ->findOrFail($id);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'image' => $category->image ? base64_encode($category->image) : null,
                    'articles' => $category->articles()
                        ->where('isActive', true)
                        ->select('id', 'name', 'price', 'stock')
                        ->get()
                ]
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve category'
            ], 500);
        }
    }
}
