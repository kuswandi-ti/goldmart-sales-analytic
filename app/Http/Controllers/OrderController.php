<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function callbackPayment(Request $request)
    {
        $result_status = '';
        $serverKey = config('midtrans.midtrans_server_key');

        $signatureKey = hash(
            "sha512",
            $request->order_id .
                $request->status_code .
                $request->gross_amount .
                $serverKey
        );

        if ($signatureKey !== $request->signature_key) {
            // return response()->json(['message' => 'Invalid signature key'], 403);
            return view('customer_visit.order_confirmation')->with('error', __('403. Invalid signature key'));
        }

        $order = Order::find($request->order_id);

        if (!$order) {
            // return response()->json(['message' => 'Transaction not found'], 404);
            return view('customer_visit.order_confirmation')->with('error', __('403. Transaction not found'));
        }

        if ($request->transaction_status == 'settlement' || $request->transaction_status == 'capture') {
            $order->status_bayar = 'paid'; // Status pembayaran berhasil
            $result_status = 'sukses';
        } elseif ($request->transaction_status == 'expire') {
            $order->status_bayar = 'failed'; // Status pembayaran kadaluarsa
            $result_status = 'failed';
        } elseif ($request->transaction_status == 'cancel') {
            $order->status_bayar = 'cancel'; // Status pembayaran gagal
            $result_status = 'cancel';
        } elseif ($request->transaction_status == 'pending') {
            $order->status_bayar = 'pending'; // Status menunggu pembayaran
            $result_status = 'pending';
        }

        $order->save();

        // return response()->json(['message' => 'Pembayaran sukses']);

        // return redirect()->route('customervisit.index')->with('success', __('Data customer visit berhasil diperbarui'));

        // return redirect()->route('customervisit.index')->with('success', __('Pembayaran Berhasil'));

        $data = [
            'status' => $result_status,
        ];

        return response()->json($data, 200);
    }
}
