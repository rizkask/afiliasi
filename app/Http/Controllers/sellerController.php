<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product;
use App\Models\TransactionDetail;
use App\Models\Transaction;
use App\Models\user;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $product = product::where('users_id',Auth::user()->id)->get();

        $sell = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->whereHas('product', function($product){
                        $product->where('users_id',Auth::user()->id);
                    })->orderBy('created_at','DESC')->get();
        
        $transaction=$sell->count();

        $customer = $sell->groupby('transactions_id')->count();

        $revenue=0;
        foreach($sell as $p){
            $revenue += $p->price;
        }

        $product=0;
        foreach($sell as $q){
            $product += $q->quantity;
        }

        return view('pages.seller.dashboard',[
            'transaction' => $transaction,
            'customer' => $customer,
            'revenue' => $revenue,
            'product' => $product,
        ]);
    }
}
