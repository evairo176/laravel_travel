<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TransactionsRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Transactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $item = DB::table('transactions')
            ->leftJoin('travel_packages', 'transactions.travel_packages_id', '=', 'travel_packages.id')
            ->leftJoin('users', 'transactions.users_id', '=', 'users.id')
            ->select(
                'transactions.*',
                'travel_packages.*',
                'users.*',
                'transactions.id as id_trans',
                'travel_packages.title as name_title',
                'users.name as name_users',
            )
            ->where('transactions.deleted_at', null)
            ->get();
        // dd($item);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Travel Packages',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'transactions',
        ];

        if (request()->ajax()) {
            return datatables()->of($item)
                ->addIndexColumn()
                ->addColumn('cek', 'pages.admin.transactions.checkbox')
                ->addColumn('action', 'pages.admin.transactions.transactions-action')
                ->rawColumns(['action', 'image', 'cek'])
                ->make(true);
        }
        // dd($data);
        return view('pages.admin.transactions.index', $data);
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
                    $delete = Transactions::find($key)
                        ->delete();
                }
            } else {
                $delete = Transactions::find($request->data)
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
