<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ProfilController extends Controller
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
        if($request->image){
            $item->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'image' => $request->file('image')->store('assets/avatar','public'),
            ]);
        }
        else{
            $item->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
            ]);
        }
        

        return redirect()->back()->with(['success' => 'Data berhasil diubah']);
    }

    public function updateaddress(Request $request, $id)
    {
        $data = Crypt::decrypt($id);
        $request->validate([
            'nama_provinsi' => 'required',
            'nama_distrik' => 'required',
            'zip_code' => 'required|int',
            'address_one' => 'required',
        ]);

        $item = User::findOrFail($data);
        $item->update([
            'provinces_id' => $request->nama_provinsi,
            'regencies_id' => $request->nama_distrik,
            'zip_code' => $request->zip_code,
            'address_one' => $request->address_one,
            'regencies_name' => $request->regencies_name,
        ]);

        return redirect()->back()->with(['success' => 'Data berhasil diubah']);
    }

    public function prof($id)
    {
        $data = Crypt::decrypt($id);
        $item = User::findOrFail($data);

        return view('pages.profil',[
            'item' => $item
        ])->with(['success' => 'Lengkapi alamat']);
    }
}
