<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    
    public function index()
    {
        
        $items = TransactionDetail::with(['transaction.user','product.galleries'])->orderBy('created_at','desc')->get();

        //dd($sell[1]->transactions_id);
    
        $sell = Transaction::with(['user','details'])->orderBy('created_at','desc')->get();

        return view('pages.admin.transaction.index',[
            'items' => $items,
            'sells' => $sell,
        ]);
    }

    public function buy()
    {

        $buy = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->whereHas('transaction', function($transaction){
                        $transaction->where('users_id',Auth::user()->id);
                    })->orderBy('created_at','desc')->get();

        //dd($sell[1]->transactions_id);

        return view('pages.seller.transaction.buy',[
            'buys' => $buy,
        ]);
    }

    public function edit($id)
    {
        $data = TransactionDetail::findOrFail($id);
        $item = TransactionDetail::where('transactions_id',$data->transactions_id)->get();
        $i = 1;

        return view('pages.admin.transaction.detail',[
            'item' => $item,
            'i' => $i
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrFail($id);

        $get = TransactionDetail::where('transactions_id',$item->transactions_id)->get();
        foreach($get as $x){
            $x->update($data);
        }

        if($get->first()->shipping_status == 'SHIPPING'){
            $transaction = Transaction::where('id', $item->transactions_id)->first();

            $transaction->update([
                'bayar_time' => $transaction->updated_at->addMinutes(421),
            ]);
            
            $transaction->update([
                'shipping_time' => \Carbon\Carbon::now()->addMinutes(421),
            ]);
        }

        //pending,success,failed
        
        //transactiondetail: pending, shipping, success
        
        return redirect()->back();
    }
}
