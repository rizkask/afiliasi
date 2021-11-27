<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\cart;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DetailController extends Controller
{
    public function index(Request $request, $slug)
    {
        $item = product::with(['galleries'])
                ->where('slug', $slug)
                ->firstOrFail();
        $transaksi = TransactionDetail::where('products_id', $item->id)->get();

        return view('pages.detail',[
            'product' => $item,
        ]);
    }

    
}
