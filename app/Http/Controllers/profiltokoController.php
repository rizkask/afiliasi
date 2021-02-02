<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\affiliate;
use App\Models\product;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class profiltokoController extends Controller
{
    public function index($slug)
    {
        $item = User::where('slug', $slug)->firstOrFail();
        $product = product::where('users_id',$item->id)->orderBy('created_at','DESC')->get();
        $aff = affiliate::where('users_id', $item->id)->get();
        //$cek = transactiondetail::where('shipping_status','SUCCESS')->get();
        //$tes = count($cek);
        //for(i==0; i<count()){
        //    $sold = TransactionDetail::where('products_id',$product[0]->id)->where('shipping_status','SUCCESS')->count();
        //}

        $sold=0;
        foreach($product as $q){
            $sold += $q->sold;
        }
        return view('pages.profil-toko',[
            'item' => $item,
            'products' => $product,
            'affs' => $aff,
            'sold' => $sold,
        ]);
    }
}
