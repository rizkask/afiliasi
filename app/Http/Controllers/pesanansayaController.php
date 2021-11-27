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
use PDF;

class PesanansayaController extends Controller
{
    public function index()
    {
        $totalPrice = 0;
        $item = TransactionDetail::whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.pesanan-saya',[
            'items' => $item,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function sent($id)
    {
        $item = TransactionDetail::where('shipping_status','SHIPPING')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.sent',[
            'items' => $item
        ]);
    }

    public function done($id)
    {
        $item = TransactionDetail::where('shipping_status','SUCCESS')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id);
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.done',[
            'items' => $item
        ]);
    }

    public function cancel($id)
    {
        $item = TransactionDetail::where('shipping_status','PENDING')->whereHas('transaction', function($transaction){
            $now = \Carbon\Carbon::now()->subMinutes(1440);
            $transaction->where('users_id',Auth::user()->id)->where('created_at','<',$now);
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.cancel',[
            'items' => $item
        ]);
    }

    public function unpay($id)
    {
        $item = TransactionDetail::whereHas('transaction', function($transaction){
            $now = \Carbon\Carbon::now()->subMinutes(1440);
            $transaction->where('users_id',Auth::user()->id)->where('transaction_status','PENDING')->where('created_at','>=',$now);
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.unpay',[
            'items' => $item
        ]);
    }

    public function dikemas($id)
    {
        $item = TransactionDetail::where('shipping_status','DIKEMAS')->whereHas('transaction', function($transaction){
            $transaction->where('users_id',Auth::user()->id)->where('transaction_status','SUCCESS');
        })->orderBy('created_at','desc')->get()->groupby('transactions_id');

        return view('pages.dikemas',[
            'items' => $item
        ]);
    }

    public function belilagi($code)
    {
        $data = Crypt::decrypt($code);

        $items = TransactionDetail::where('transactions_id',$data)->get();

        foreach($items as $item){
            $cekproduct = cart::where('products_id',$item->product->id)->where('users_id',Auth::user()->id)->first();
            if($cekproduct==null){
            $data = [
                'products_id' => $item->product->id,
                'users_id' => Auth::user()->id,
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

        $detail = TransactionDetail::where('transactions_id',$item->id)->get()->groupby('transactions_id');

        return view('pages.rincian-pesanan',[
            'items' => $item,
            'details' => $detail,
        ]);
    }

    public function faktur($code,$id){

        $item = Transaction::where('code',$code)->first();

        $detail = TransactionDetail::where('transactions_id',$item->id)->get();
 
    	$pdf = PDF::loadview('pages.faktur',[
                'items'=>$detail,
                ]);

    	return $pdf->download('invoice');
    }

    public function konfirmasipesanan($code, $id)
    {
        $data = TransactionDetail::findOrFail($code);

        $items = TransactionDetail::where('transactions_id',$data->transactions_id)->get();

        foreach($items as $item){
            $item->update([
                'shipping_status' => 'SUCCESS',
            ]);
        }

        return redirect()->back();
    }
    
}
