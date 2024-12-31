<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;


class PublicArticleController extends Controller
{
    public function index()
    {
        try {
            $articles = Article::where('isActive', true)
                ->latest()
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $articles
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to fetch articles'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $article = Article::where('isActive', true)
                ->findOrFail($id);
                
            return response()->json([
                'status' => 'success',
                'data' => $article
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Article not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to fetch article'
            ], 500);
        }
    }
}
