<?php

namespace App\Http\Controllers;

use App\TravelPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function index()
    {
        if (Auth::user()->roles == 'Admin') {
            return redirect('/admin');
        } else {
            return redirect('/user/dashboard');
        }
    }
}
