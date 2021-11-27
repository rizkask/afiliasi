<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = User::where('roles','user')->count();
        $transactions = Transaction::where('transaction_status','SUCCESS')->get();
        $penghasilan = 0;

        foreach($transactions as $transaction){
            $penghasilan += $transaction->total_price - $transaction->shipping_price;
        }

        $terjual = TransactionDetail::whereHas('transaction', function($transaction){
                                                $transaction->where('transaction_status','SUCCESS');
                                            })->groupby('products_id')->count();

        $afiliasi = TransactionDetail::where('ref','!=',null)->whereHas('transaction', function($transaction){
            $transaction->where('transaction_status','SUCCESS');
        })->count();


        return view('pages.admin.dashboard',[
            'user' => $user,
            'penghasilan' => $penghasilan,
            'terjual' => $terjual,
            'afiliasi' => $afiliasi,

        ]);
    }
}
