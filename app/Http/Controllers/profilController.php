<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class profilController extends Controller
{
    public function index($id)
    {
        $data = Crypt::decrypt($id);
        $item = User::findOrFail($data);

        return view('pages.profil',[
            'item' => $item
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = Crypt::decrypt($id);
        $request->validate([
            'name' => 'required|string',
        ]);

        $item = User::findOrFail($data);
        if($item->image){
            $item->update([
                'name' => $request->name,
                'store_name' => $request->store_name,
                'slug' => Str::slug($request->store_name),
                'phone_number' => $request->phone_number,
            ]);
        }
        else{
            $item->update([
                'name' => $request->name,
                'store_name' => $request->store_name,
                'slug' => Str::slug($request->store_name),
                'phone_number' => $request->phone_number,
                'image' => $request->file('image')->store('assets/avatar','public'),
            ]);
        }
        

        return redirect()->back()->with(['success' => 'Data berhasil diubah']);
    }

    public function updateaddress(Request $request, $id)
    {
        $data = Crypt::decrypt($id);
        $request->validate([
            'provinces_id' => 'required|int',
            'regencies_id' => 'required|int',
            'zip_code' => 'required|int',
            'address_one' => 'required',
        ]);

        $item = User::findOrFail($data);
        $item->update([
            'provinces_id' => $request->provinces_id,
            'regencies_id' => $request->regencies_id,
            'zip_code' => $request->zip_code,
            'address_one' => $request->address_one,
        ]);

        return redirect()->back()->with(['success' => 'Data berhasil diubah']);
    }
}
