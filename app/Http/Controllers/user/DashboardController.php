<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
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
            ->where('users_id', auth()->user()->id)
            ->get();
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Dashboard',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'dashboard',
        ];

        if (request()->ajax()) {
            return datatables()->of($item)
                ->addIndexColumn()
                ->addColumn('cek', 'pages.user.checkbox')
                ->addColumn('action', 'pages.user.user-action')
                ->rawColumns(['action', 'cek'])
                ->make(true);
        }
        return view('pages.user.dashboard', $data);
    }

    public function destroy(Request $request)
    {
        $data = $request->data;
        if ($data != '') {
            if ($request->multi != null) {
                foreach ($data as $key) {
                    $delete = Transactions::find($key);
                    $delete->delete();
                }
            } else {
                $delete = Transactions::find($request->data);
                $delete->delete();
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
