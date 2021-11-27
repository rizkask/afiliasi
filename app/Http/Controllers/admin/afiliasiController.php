<?php

namespace App\Http\Controllers\admin;

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

    public function create()
    {
        $transaction = TransactionDetail::with(['transaction.user','product.galleries'])
                    ->where('ref','!=',null)
                    ->orderBy('created_at','DESC')->get()->groupby('ref');

        return view('pages.admin.afiliasi.afiliator',[
            'transaction' => $transaction,
        ]);
    }

    public function edit()
    {
        $claim = claim::get();

        return view('pages.admin.afiliasi.pengajuankomisi',[
            'claim' => $claim,
        ]);
    }

}
