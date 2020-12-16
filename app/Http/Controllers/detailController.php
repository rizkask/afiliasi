<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\cart;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class detailController extends Controller
{
    public function index(Request $request, $slug)
    {
        $item = product::with(['galleries'])
                ->where('slug', $slug)
                ->firstOrFail();
        $transaksi = TransactionDetail::where('products_id', $item->id)->get();
        $sold = count($transaksi);
        return view('pages.detail',[
            'product' => $item,
            'sold' => $sold,
        ]);
    }

    public function add(Request $request, $id)
    {
        $cek = Crypt::decrypt($id);
        $data = [
            'products_id' => $cek,
            'users_id' => Auth::user()->id,
            'quantity' => $request->quantity,
        ];

        cart::create($data);

        return redirect()->route('cart');
    }
}
