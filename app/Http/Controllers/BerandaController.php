<?php

namespace App\Http\Controllers;

use App\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BerandaController extends Controller
{
    public function index()
    {
        $travel_package = DB::table('travel_packages')
            ->where('travel_packages.deleted_at', null)
            ->limit(4)
            ->get();
        // dd($travel_package);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Home',
            'items' => $travel_package
        ];
        return view('pages.home', $data);
    }
}
