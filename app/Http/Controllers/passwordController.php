<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\admin\ubahpassRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Hash;

class passwordController extends Controller
{
    public function index($id)
    {
        $data = Crypt::decrypt($id);
        $item = User::findOrFail($data);

        return view('pages.pass',[
            'item' => $item
        ]);
    }

    public function update(ubahpassRequest $request,$id)
    {
        $data = Crypt::decrypt($id);
        $item = User::findOrFail($data);

        $item->update([
            'password' => Hash::make($request->get('kata_sandi_baru'))
        ]);

        return redirect()->back()->with(['success' => 'Password berhasil diubah']);
    }
}
