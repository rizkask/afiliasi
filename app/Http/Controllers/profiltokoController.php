<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class profiltokoController extends Controller
{
    public function index($slug)
    {
        $item = User::where('slug', $slug)->firstOrFail();
        $product = product::where('users_id',$item->id)->get();

        return view('pages.profil-toko',[
            'item' => $item,
            'products' => $product,
        ]);
    }
}
