<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CartController extends Controller
{
    public function index()
    {
        $data = Auth::user()->id;
        $user = User::findOrFail($data);
        $cart = cart::with(['product.galleries','user'])->where('users_id', Auth::user()->id)->get();
        //dd($cart->keys()->get(0));
        $totalPrice = 0;
        return view('pages.cart',[
            'carts' => $cart,
            'totalPrice' => $totalPrice,
            'user' => $user,
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

    public function getAddress()
    {  
        $user  = User::where('id',Auth::user()->id)->first();

        return json_encode($user->regencies_id);
    }

    public function getTotalPrice()
    {  
        $carts  = Cart::where('users_id',Auth::user()->id)->get();
        $totalPrice = 0;

        foreach($carts as $cart){
            $totalPrice += $cart->product->price*$cart->quantity;
        }

        return json_encode($totalPrice);
    }

    public function totalongkir()
    {
        return view('pages.totalongkir');
    }

    public function getWeight()
    {  
        $carts = cart::where('users_id',Auth::user()->id)->get();

        $berat = 0;
        foreach($carts as $cart){
            $berat += $cart->product->berat;
        }
        

        return json_encode($berat);
    }
}
