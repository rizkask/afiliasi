<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SettingSellerController extends Controller
{
    public function index($id)
    {
        $data = Crypt::decrypt($id);
        $item = User::findOrFail($data);

        return view('pages.seller.setting',[
            'item' => $item
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = Crypt::decrypt($id);
        $request->validate([
            'store_name' => 'required|string',
            'store_status' => 'required|string',
        ]);

        $item = User::findOrFail($data);

        $item->update([
            'store_name' => $request->store_name,
            'slug' => Str::slug($request->store_name),
            'store_status' => $request->store_status,
        ]);
        
        return redirect()->back()->with(['success' => 'Data berhasil diubah']);
    }

}
