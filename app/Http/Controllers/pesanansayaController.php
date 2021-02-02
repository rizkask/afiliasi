<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\cart;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class pesanansayaController extends Controller
{
    public function index()
    {
        $totalPrice = 0;
        $item = TransactionDetail::whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->get()->groupby('transactions_id');

        return view('pages.pesanan-saya',[
            'items' => $item,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function sent($id)
    {
        $item = TransactionDetail::where('shipping_status','SHIPPING')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->get()->groupby('transactions_id');

        return view('pages.sent',[
            'items' => $item
        ]);
    }

    public function done($id)
    {
        $item = TransactionDetail::where('shipping_status','SUCCESS')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->get()->groupby('transactions_id');

        return view('pages.done',[
            'items' => $item
        ]);
    }

    public function cancel($id)
    {
        $item = TransactionDetail::where('shipping_status','FAILED')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->get()->groupby('transactions_id');

        return view('pages.cancel',[
            'items' => $item
        ]);
    }

    public function belilagi($id)
    {
        $titip = TransactionDetail::where('id',$id);
        $cek=$titip->transaction->id;
        $items = TransactionDetail::where('transactions_id',$cek);

        foreach($items as $item){
            $cekproduct = cart::where('products_id',$item->product->id)->where('users_id',Auth::user()->id)->first();
            if($cekproduct==null){
            $data = [
                'products_id' => $item->product->id,
                'users_id' => Auth::user()->id,
                'pemilik_id' => $item->product->user->id,
                'quantity' => $item->quantity,
            ];
            cart::create($data);
            }
            else{
                $cekproduct->update([
                    'quantity' => $item->quantity,
                ]);
            }
        }

        return redirect()->route('cart');
    }

    public function rincian($code,$id)
    {

        $item = Transaction::where('code',$code)->first();

        $detail = TransactionDetail::where('transactions_id',$item->id)->where('shipping_status','SHIPPING')->first();

        return view('pages.rincian-pesanan',[
            'items' => $item,
            'detail' => $detail,
        ]);
    }
    
}
