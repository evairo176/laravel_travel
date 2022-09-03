<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Topup_transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopupTransactionController extends Controller
{
    public function index()
    {
        $item = DB::table('topup_transaction')
            ->leftJoin('users', 'topup_transaction.users_id', '=', 'users.id')
            ->select(
                'topup_transaction.*',
                'users.*',
                'topup_transaction.id as id_trans',
            )
            ->where('topup_transaction.deleted_at', null)
            ->get();
        // dd($item);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Travel Packages',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'topup_transaction',
        ];

        if (request()->ajax()) {
            return datatables()->of($item)
                ->addIndexColumn()
                ->addColumn('cek', 'pages.admin.topup-transactions.checkbox')
                ->addColumn('action', 'pages.admin.topup-transactions.topup-transactions-action')
                ->rawColumns(['action', 'image', 'cek'])
                ->make(true);
        }
        // dd($data);
        return view('pages.admin.topup-transactions.index', $data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_status' => 'required|string|in:IN_CART,PENDING,SUCCESS,CANCEL,FAILED',
        ]);
        if ($validator->passes()) {
            $travelId = $request->id;
            if ($travelId) {
                $travel = Transactions::find($travelId);
                $travel->transaction_status = $request->transaction_status;
            } else {
                $travel = new Transactions();

                $travel->transaction_status = $request->transaction_status;
            }

            $travel->save();

            return Response()->json([
                'travel' => $travel,
                'success' => true,
                'message' => 'Data inserted successfully'
            ]);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $travel  = Transactions::where($where)->first();

        return Response()->json($travel);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = $request->data;
        if ($data != '') {
            if ($request->multi != null) {
                foreach ($data as $key) {
                    $delete = Topup_transaction::find($key)
                        ->delete();
                }
            } else {
                $delete = Topup_transaction::find($request->data)
                    ->delete();
            }
            return Response()->json($delete);
        } else {
            $text = 'Data select kosong';
            return Response()->json([
                'text' => $text
            ]);
        }
    }
}
