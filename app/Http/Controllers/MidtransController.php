<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TransactionSuccess;
use App\Transactions;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function notificationHandler(Request $request)
    {
        //set konfig midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // buat instan notification midtrans

        $notification = new Notification();

        //pecah order id

        $order = explode('-', $notification->order_id);

        // asign variable untuk memudahkan config 
        $status = $notification->transaction_status;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $order[1];

        $transaksi = Transactions::findOrFail($order_id);

        // handle status midtrans 
        if ($status == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $transaksi->transaction_status = 'CHALLENGE';
                } else {
                    $transaksi->transaction_status = 'SUCCESS';
                }
            }
        } else if ($status == 'settlement') {
            $transaksi->transaction_status = 'SUCCESS';
        } else if ($status == 'deny') {
            $transaksi->transaction_status = 'FAILED';
        } else if ($status == 'expire') {
            $transaksi->transaction_status = 'EXPIRE';
        } else if ($status == 'cancel') {
            $transaksi->transaction_status = 'FAILED';
        }

        // simpan transaksi 
        $transaksi->save();

        // kirim email

        if ($transaksi) {
            if ($status == 'capture' && $fraud == 'accept') {
                Mail::to($transaksi->user)->send(new TransactionSuccess($transaksi));
            } else if ($status == 'settlement') {
                Mail::to($transaksi->user)->send(new TransactionSuccess($transaksi));
            } else if ($status == 'success') {
                Mail::to($transaksi->user)->send(new TransactionSuccess($transaksi));
            } else if ($status == 'capture' && $fraud == 'challlenge') {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans payment challenge'
                    ]
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'message' => 'Midtrans Payment not settlement'
                    ]
                ]);
            }
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'message' => 'Midtrans notifacation success'
                ]
            ]);
        }
    }
    public function finishRedirect(Request $request)
    {
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Success',
        ];
        return view('pages.success', $data);
    }
    public function unfinishRedirect(Request $request)
    {
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Unfinish',
        ];
        return view('pages.unfinish', $data);
    }
    public function errorRedirect(Request $request)
    {
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Error',
        ];
        return view('pages.failed', $data);
    }
}
