<?php

namespace App\Http\Controllers;

use App\Mail\TransactionSaldoSuccess;
use App\Topup_transaction;
use App\Topup_transaction_details;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;


class TopUpController extends Controller
{
    public function index($id)
    {
        $topup = Topup_transaction::with([
            'user'
        ])->findOrFail($id);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Top Up',
            'item' => $topup
        ];
        return view('pages.topup', $data);
    }
    public function prosses()
    {
        $topup = Topup_transaction::create([
            'users_id' => auth()->user()->id,
            'transaction_total' => 0,
            'transaction_status' => 'PENDING',
        ]);
        // dd($topup->id);
        $topup_detail = Topup_transaction_details::create([
            'topup_transaction_id' => $topup->id,
            'username' => Auth::user()->username,
            'saldo' => 0,
        ]);
        return redirect()->route('checkout-top-up', $topup->id);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'saldo' => 'required|integer',
        ]);

        if ($validator->passes()) {
            $id = auth()->user()->id;
            if ($id) {
                $user = User::find($id);
                if ($user->saldo > 0) {
                    $user->saldo = $user->saldo + $request->saldo;
                } else {
                    $user->saldo = $request->saldo;
                }
            }
            $user->save();

            $topup = Topup_transaction::with([
                'user'
            ])->findOrFail($request->id);

            $topup->transaction_total = $request->saldo;
            $topup->transaction_status = 'SUCCESS';
            $topup->save();

            $detail = Topup_transaction_details::findOrFail($request->id);
            $detail->saldo = $user->saldo;
            $detail->save();

            Mail::to($topup->user)->send(
                new TransactionSaldoSuccess($topup)
            );

            return Response()->json([
                'user' => $user,
                'success' => true,
                'message' => 'Top Up successfully'
            ]);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
