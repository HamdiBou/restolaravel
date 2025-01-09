<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function confirmPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'phone' => 'required|string',
                'address' => 'required|string',
                'articles' => 'required|array',
                'articles.*.id' => 'required|exists:articles,id',
                'articles.*.quantity' => 'required|integer|min:1'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 422);
            }

            return DB::transaction(function () use ($request) {
                $user = User::findOrFail($request->user_id);
                
                // Check and update stock for each article
                foreach ($request->articles as $item) {
                    $article = Article::lockForUpdate()->find($item['id']);
                    
                    if (!$article || $article->stock < $item['quantity']) {
                        throw new \Exception('Insufficient stock for article ID: ' . $item['id']);
                    }
                    
                    $article->stock -= $item['quantity'];
                    $article->save();
                }

                $payment = Payment::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'articles' => json_encode($request->articles),
                    'status' => 'pending'
                ]);

                return response()->json([
                    'status' => 'success',
                    'data' => $payment
                ]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}