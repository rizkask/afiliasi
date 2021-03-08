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

class AffiliateController extends Controller
{

    public function transaction($id)
    {
        $product = product::where('users_id',Auth::user()->id)->get();
        $data = Crypt::decrypt($id);
        $user = User::findOrFail($data);
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->orderBy('created_at','DESC')->get();

        return view('pages.seller.affiliate.transaction',[
            'user' => $user,
            'transaction' => $transaction,
            'product' => $product,
        ]);
    }

    public function detailowner($id)
    {
        $item = TransactionDetail::findOrFail($id);
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->orderBy('created_at','DESC')->get();
        dd($transaction);

        return view('pages.seller.affiliate.detail-owner',[
            'transaction' => $transaction,
        ]);
    }

    public function owner($id)
    {
        $product = product::where('users_id',Auth::user()->id)->get();
        $data = Crypt::decrypt($id);
        $user = User::findOrFail($data);
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->orderBy('created_at','DESC')->get();
        $x = $transaction->groupby('users_id');

        return view('pages.seller.affiliate.owner',[
            'x' => $x,
            'transaction' => $transaction,
            'product' => $product,
        ]);
    }

    public function transin($id)
    {
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->where('bukti','!=',NULL)->get();

        return view('pages.seller.affiliate.bukti-komisi',[
            'transaction' => $transaction,
        ]);
    }

    public function confirm($id)
    {
        $cek = bukti::findorFail($id);
        $claim = claim::where('id', $cek->claim_id)->first();

        $cek->update([
            'confirm' => 1,
        ]);

        $claim->update([
            'confirm' => 1,
        ]);

        return redirect()->back();
    }

    public function claim($id)
    {
        $own = TransactionDetail::findorfail($id);
        $transaction = TransactionDetail::where('ref',Auth::user()->id)->get();
        $x = $transaction->groupby('users_id');

        $total=0; 
        $y=TransactionDetail::where('claims_id',NULL)->where('users_id',$own->users_id)->get();

        foreach($y as $p){
            $total += $p->product->komisi;
        }
        
        $claim = claim::create([
            'afiliator_id' => Auth::user()->id,
            'total_claim' => $total,
            'owner_id' => $own->users_id,
        ]);

        
        foreach($x as $item){
            $y=$item->where('claims_id',null)->where('users_id',$own->users_id);
            

            foreach($y as $p){
                $p->update([
                    'claims_id' => $claim->id,
                ]);
            }
            
        }
        return redirect()->back();
    }

    public function afiliator($id)
    {
        $data = Crypt::decrypt($id);
        $user = User::findOrFail($data);
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->where('ref','!=',null)
                    ->whereHas('product', function($product){
                        $product->where('users_id',Auth::user()->id);
                    })->orderBy('created_at','DESC')->get()->groupby('ref');

        return view('pages.seller.affiliate.afiliator',[
            'user' => $user,
            'transaction' => $transaction,
        ]);
    }

    public function afiliatortrans($id)
    {
        $data = Crypt::decrypt($id);
        $user = User::findOrFail($data);
        $claim = claim::where('owner_id',Auth::user()->id)->get();

        return view('pages.seller.affiliate.afiliator-trans',[
            'claim' => $claim,
        ]);
    }

    public function bukti(Request $request,$id)
    {
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
            $claim = bukti::create([
                'image' => $request->file('image')->store('assets/bukti','public'),
                'claim_id' => $id,
                'total_claim' => $y->total_claim,
            ]);

            $tes = TransactionDetail::where('claims_id',$id)->get();
            $tes->first()->update([
                'bukti' => $claim->id,
            ]);
            
        }
        

        return redirect()->back();
    }

    public function myproduct($id)
    {
        $product = product::where('users_id',Auth::user()->id)->where('affiliate',1)->get();
        $all = product::where('users_id',Auth::user()->id)->where('affiliate',0)->get();
        $data = Crypt::decrypt($id);
        $user = User::findOrFail($data);

        return view('pages.seller.affiliate.myproductaff',[
            'user' => $user,
            'product' => $product,
            'all' => $all,
        ]);
    }
    

    public function add(Request $request, $id)
    {

        $product = product::findorFail($id);

        $aff = [
            'products_id' => $product->id,
            'users_id' => Auth::user()->id,
        ];

        affiliate::create($aff);

        return redirect()->back();
    }

    public function referalProduct($user, $product)
    {
        $code = $user . '-' . $product;
        $product = Product::find($product);
        $cookie = cookie('dw-afiliasi', json_encode($code), 2880);
        return redirect(route('detail', $product->slug))->cookie($cookie);
    }

    public function aff()
    {
        $aff = affiliate::where('users_id', Auth::user()->id)->get();

        return view('pages.seller.affiliate.list-affiliate',[
            'affs' => $aff,
        ]);
    }

    public function pilihan()
    {
        $item = product::where('affiliate',1)->where('users_id','!=',Auth::user()->id)->get();

        return view('pages.seller.affiliate.pilihan',[
            'items' => $item,
        ]);
    }

    public function delete_aff(Request $request,$id){
        $parameter= Crypt::encrypt(Auth::user()->id);
        
        $aff = affiliate::findOrFail($id);

        $aff->delete();

        return redirect()->route('list-affiliate',$parameter);
    }

    public function on_affiliate(Request $request, $id)
    {
        $request->validate([
            'komisi' => 'required|integer',
        ]);

        $product = product::where('id',$request->product)->get();

        $product->first()->update([
            'affiliate' => 1,
            'komisi' => $request->komisi,
        ]);

        return redirect()->back();
    }

}
