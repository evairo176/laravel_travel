<?php

namespace App\Http\Controllers;

use App\TravelPackage;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index($slug)
    {
        $travel_package = TravelPackage::where('slug', $slug)
            ->firstOrFail();
        $travel_packages = TravelPackage::all();
        // dd($travel_package);
        $data = [
            'title' => 'Nomeds',
            'subtitle' => 'Detail',
            'item' => $travel_package,
            'items' => $travel_packages
        ];

        return view('pages.detail', $data);
    }
}
