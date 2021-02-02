<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    
    public function index()
    {
        
        $sell = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->whereHas('product', function($product){
                        $product->where('users_id',Auth::user()->id);
                    })->orderBy('created_at','DESC')->get();

        //dd($sell[1]->transactions_id);
    
        $items = Transaction::with(['user','details'])
                    ->get();

        return view('pages.seller.transaction.sell',[
            'items' => $items,
            'sells' => $sell,
        ]);
    }

    public function buy()
    {

        $buy = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->whereHas('transaction', function($transaction){
                        $transaction->where('users_id',Auth::user()->id);
                    })->orderBy('created_at','DESC')->get();

        //dd($sell[1]->transactions_id);

        return view('pages.seller.transaction.buy',[
            'buys' => $buy,
        ]);
    }

    public function details($id)
    {
        $item = TransactionDetail::findOrFail($id);

        return view('pages.seller.transaction.detail',[
            'item' => $item
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrFail($id);
        $item->update($data);

        //pending,success,failed
        
        //transactiondetail: pending, shipping, success
        
        return redirect()->back();
    }
}
