<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class cartController extends Controller
{
    public function index()
    {
        $cart = cart::with(['product.galleries','user'])->where('users_id', Auth::user()->id)->get();
        $totalPrice = 0;

        return view('pages.cart',[
            'carts' => $cart,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function add_qty(Request $request, $id)
    {
        $cek = Crypt::decrypt($id);
        $data = $request->all();
        $item = cart::findOrFail($cek);

        $item->update($data);

        return redirect()->route('cart');
    }

    public function delete(Request $request,$id){
        $cart = cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success(){
        return view();
    }
}
