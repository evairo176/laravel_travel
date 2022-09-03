<?php

namespace App\Http\Controllers;

use App\Mail\TransactionSuccess;
use Illuminate\Http\Request;
use App\Transactions;
use App\TravelPackage;
use App\TransactionDetails;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function index($id)
    {
        $item = Transactions::with([
            'details', 'travel_package', 'user'
        ])->findOrFail($id);
        // dd($item);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Checkout',
            'item' => $item
        ];

        return view('pages.checkout', $data);
    }
    public function process($id)
    {
        $travel_package = TravelPackage::findOrFail($id);
        $transaksi = Transactions::create([
            'travel_packages_id' => $id,
            'users_id' => auth()->user()->id,
            'additional_visa' => 0,
            'transaction_total' => $travel_package->price,
            'transaction_status' => 'IN_CART',
        ]);

        $transaksiDetail = TransactionDetails::create([
            'transactions_id' => $transaksi->id,
            'username' => Auth::user()->username,
            'nationality' => 'ID',
            'is_visa' => false,
            'doe_passport' => Carbon::now()->addYear(5),
        ]);
        return redirect()->route('checkout', $transaksi->id);
    }

    public function create($id)
    {
        // dd($data);
        request()->validate([
            'username' => 'required|string|unique:transaction_details',
            'nationality' => 'required|string',
            'is_visa' => 'required|boolean',
            'doe_passport' => 'required'
        ]);
        $data = request()->all();

        $data['transactions_id'] = $id;

        // dd($data);


        TransactionDetails::create($data);

        $transaksi = Transactions::with(['travel_package'])->find($id);

        if (request()->is_visa) {
            $transaksi->transaction_total += 190;
            $transaksi->additional_visa += 190;
        }
        $transaksi->transaction_total += $transaksi->travel_package->price;

        $transaksi->save();

        return redirect()->route('checkout', $id)->with('sukses', 'Data Member Berhasil Ditambahkan!');
    }
    public function remove($detail_id)
    {
        $item = TransactionDetails::findOrFail($detail_id);
        $transaksi = Transactions::with([
            'details', 'travel_package',
        ])->findOrFail($item->transactions_id);

        if ($item->is_visa) {
            $transaksi->transaction_total -= 190;
            $transaksi->additional_visa -= 190;
        }
        $transaksi->transaction_total -= $transaksi->travel_package->price;

        $transaksi->save();
        $item->delete();

        return redirect()->route('checkout', $item->transactions_id);
    }
    public function success(Request $request, $id)
    {
        request()->validate([
            'payment' => 'required',
        ]);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Checkout Success',
        ];

        $transaksi = Transactions::with([
            'details', 'travel_package', 'user'
        ])->findOrFail($id);

        if ($request->payment != 'indomaret') {
            $user = User::findOrFail(auth()->user()->id);
            if ($user->saldo < $transaksi->transaction_total) {
                $error = 'saldo anda kurang!';
                return redirect()->route('checkout', $id)->with('error', $error);
            }
            $saldo = $user->saldo - $transaksi->transaction_total;
            $user->saldo = $saldo;
            $user->save();
            $transaksi->transaction_status = 'SUCCESS';
            Mail::to($transaksi->user)->send(
                new TransactionSuccess($transaksi)
            );
        } else {

            // configurasi midtrans 
            Config::$serverKey = config('midtrans.serverKey');
            Config::$isProduction = config('midtrans.isProduction');
            Config::$isSanitized = config('midtrans.isSanitized');
            Config::$is3ds = config('midtrans.is3ds');

            // buat array untuk dikirim ke midtrans 
            $midtrans_params =
                [
                    'transaction_details' => [
                        'order_id' => 'MIDTRANS-' . $transaksi->id,
                        'gross_amount' => $transaksi->transaction_total,
                    ],

                    'costumer_details' => [
                        'first_name' => $transaksi->user->name,
                        'email' => $transaksi->user->email,
                    ],
                    'enable_payments' => ['gopay'],
                    'vtweb' => []

                ];


            try {
                $paymentUrl = Snap::createTransaction($midtrans_params)->redirect_url;

                header('location: ' . $paymentUrl);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            $transaksi->transaction_status = 'PENDING';
            Mail::to($transaksi->user)->send(
                new TransactionSuccess($transaksi)
            );
            $transaksi->save();
            return view('pages.success', $data);
        }
    }
}
