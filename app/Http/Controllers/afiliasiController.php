<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\product;
use App\Models\affiliate;
use App\Models\bukti;
use App\Models\claim;
use App\Models\TransactionDetail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class AfiliasiController extends Controller
{
    public function index($id)
    {
        $product = affiliate::where('users_id', Auth::user()->id)->get();
        $detail = TransactionDetail::where('ref',Auth::user()->id)
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('transaction_status','SUCCESS');
                        })->orderBy('created_at','DESC')->get();

        $revenue = 0;
        foreach($detail as $one){
            $revenue += $one->komisi;
        }
        $jml = count($detail);
        $item = product::where('affiliate',1)->get();

        return view('pages.afiliasi.index',[
            'product' => $product,
            'revenue' => $revenue,
            'jml' => $jml,
            'items' => $item,
            'detail' => $detail,
        ]);
    }

    public function transaksi($id)
    {
        $detail = TransactionDetail::where('ref',Auth::user()->id)
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('transaction_status','SUCCESS');
                        })->orderBy('created_at','DESC')->get();
        $get = TransactionDetail::where('ref',Auth::user()->id)->where('claims_id','!=',NULL)->where('bukti',NULL)
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('transaction_status','SUCCESS');
                        })->orderBy('created_at','DESC')->get();

        $ajukan = 0;
        foreach($get as $z){
            $ajukan += $z->komisi;
        }

        $revenue = 0;
        foreach($detail as $one){
            $revenue += $one->komisi;
        }
        $jml = count($detail);

        

        return view('pages.afiliasi.transaksi',[
            'detail' => $detail,
            'revenue' => $revenue,
            'jml' => $jml,
            'ajukan' => $ajukan,
            
        ]);
    }

    public function pengajuan($id)
    {
        $items = TransactionDetail::where('ref',Auth::user()->id)
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('transaction_status','SUCCESS');
                        })->orderBy('created_at','DESC')->get();

        $detail = TransactionDetail::where('ref',Auth::user()->id)->where('bukti','!=',null)
                        ->whereHas('transaction', function($transaction){
                            $transaction->where('transaction_status','SUCCESS');
                        })->groupby('bukti')->get();

        $revenue = 0;
        foreach($items as $one){
            $revenue += $one->komisi;
        }
        $jml = count($items);

        return view('pages.afiliasi.pengajuan',[
            'detail' => $detail,
            'revenue' => $revenue,
            'jml' => $jml,
        ]);
    }

    public function confirm($code,$id)
    {
        //konfirmasi komisi afiliasi diterima
        $cek = bukti::findorFail($code);
        $claim = claim::where('id', $cek->claim_id)->first();
        $detail = TransactionDetail::where('claims_id', $claim->id)->get();

        $cek->update([
            'confirm' => 1,
        ]);

        $claim->update([
            'confirm' => 1,
        ]);

        foreach($detail as $d){
            $d->update([
                'ref_status' => 2,
            ]);
        }
        
        return redirect()->back();
    }

    public function claim(Request $request,$id)
    {
        //ajukan komisi
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->where('claims_id',NULL)
                            ->whereHas('transaction', function($transaction){
                                $transaction->where('transaction_status','SUCCESS');
                            })->get();
                    
        $total=0; 

        foreach($transaction as $p){
            $total += $p->komisi;
        }
        
        $claim = claim::create([
            'afiliator_id' => Auth::user()->id,
            'total_claim' => $total,
        ]);

        
        foreach($transaction as $item){
            $item->update([
                'claims_id' => $claim->id,
                'ref_status' => 1,
            ]);
        }

        return redirect()->back();
    }


    

    public function referalProduct($user, $product)
    {
        $code = $user . '-' . $product;
        $product = Product::find($product);
        $cookie = cookie('dw-afiliasi', json_encode($code), 2880);
        return redirect(route('detail', $product->slug))->cookie($cookie);
    }

    public function delete_aff($code, $id)
    {
        //hapus produk afiliasi
        $aff = affiliate::findOrFail($code);

        $aff->delete();

        return redirect()->back();
    }

    public function add($code, $id)
    {

        $product = product::findorFail($code);

        $aff = [
            'products_id' => $product->id,
            'users_id' => Auth::user()->id,
        ];

        affiliate::create($aff);

        return redirect()->back();
    }

//-------------------------------------------------------------------
//--------------------------buat admin-------------------------------

    public function on_affiliate(Request $request, $id)
    {
        $request->validate([
            'komisi' => 'required|integer',
        ]);

        $product = product::where('id',$id)->get();


        $product->first()->update([
            'affiliate' => 1,
            'komisi' => $request->komisi,
        ]);

        return redirect()->back();
    }

    public function off_affiliate(Request $request, $id)
    {
        $product = product::findorFail($id);

        $product->update([
            'affiliate' => 0,
        ]);

        return redirect()->back();
    }

    public function bukti(Request $request,$id)
    {
        //admin upload bukti transfer komisi
        $request->validate([
            'image' => 'required|image',
        ]);

        $data = $request->all();

        $x = bukti::where('claim_id', $id)->get();
        $y = claim::where('id',$id)->first();

        if($x->count() > 0){
            $x->first()->update([
                'image' => $request->file('image')->store('assets/bukti','public'),
            ]);
        }
        else{
            $bukti = bukti::create([
                'image' => $request->file('image')->store('assets/bukti','public'),
                'claim_id' => $id,
                'total_claim' => $y->total_claim,
            ]);

            $tes = TransactionDetail::where('claims_id',$id)->get();
            foreach($tes as $t){
                $t->update([
                    'bukti' => $bukti->id,
                ]);
            }
            
        }
        

        return redirect()->back();
    }

}
