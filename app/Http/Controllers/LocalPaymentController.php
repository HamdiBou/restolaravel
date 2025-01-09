<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class LocalPaymentController extends Controller implements HasMiddleware
{
    public static function middleware():array
    {
        return[
            new Middleware('permission:view payments',only:['index']),
            new Middleware('permission:update payments',only:['updateStatus']),
            new Middleware('permission:export payments',only:['export']),
        ];
    }
    public function index()
    {
        $payment = Payment::latest()->paginate(10);
        return view('payment.list', ['payments' => $payment]);
    }
    public function export()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="payments.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'ID',
                'Name',
                'Phone',
                'Address',
                'Articles',
                'Status',
                'Created At'
            ]);

            // Add data
            Payment::chunk(1000, function ($payments) use ($file) {
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->id,
                        $payment->name,
                        $payment->phone,
                        $payment->address,
                        json_encode($payment->articles),
                        $payment->status,
                        $payment->created_at
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => ['required', 'in:confirmed,failed']
        ]);

        if ($payment->status === 'pending') {
            $payment->update(['status' => $request->status]);
            return back()->with('success', 'Payment status updated successfully');
        }

        return back()->with('error', 'Only pending payments can be updated');
    }
}
