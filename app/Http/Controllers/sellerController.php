<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class sellerController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.seller.dashboard');
    }
}
