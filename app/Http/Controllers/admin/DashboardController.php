<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Transactions;
use App\TravelPackage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $travel_package = TravelPackage::count();
        $transaksi = Transactions::count();
        $pending = Transactions::where('transaction_status', 'PENDING')->count();
        $sukses = Transactions::where('transaction_status', 'SUCCESS')->count();
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Dashboard',
            'currentmenu' => 'dashboard',
            'currentsubmenu' => 'dashboard',
            'travel_package' => $travel_package,
            'transaksi' => $transaksi,
            'pending' => $pending,
            'sukses' => $sukses
        ];
        return view('pages.admin.dashboard', $data);
    }
}
