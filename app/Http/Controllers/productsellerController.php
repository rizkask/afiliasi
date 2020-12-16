<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\productRequest;
use Illuminate\Support\Str;
use App\Models\product;
use App\Models\user;
use App\Models\productgallery;
use App\Models\category;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Crypt;

class productsellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = product::with(['user','category'])->where('users_id',Auth::user()->id)->get();

        return view('pages.seller.product',[
            'items' => $item
        ]);
    }

    public function uploadgallery(Request $request)
    {
        $data = $request->all();

        $data['image'] = $request->file('image')->store('assets/product','public');

        productgallery::create($data);

        return redirect()->route('product-seller-edit', $request->products_id);
    }

    public function deletegallery(Request $request,$id)
    {
        $item = productgallery::findorFail($id);
        $item->delete();

        return redirect()->route('product-seller-create', $request->products_id);
    }

    public function create()
    {
        $user = user::get();
        $category = category::get();
        $product = product::with(['user','category'])->where('users_id',Auth::user()->id)->get();

        return view('pages.seller.tambah-produk',[
            'users' => $user,
            'categories' => $category,
            'product' => $product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $parameter= Crypt::encrypt(Auth::user()->id);
        $request->validate([
            'name' => 'required|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        $product = product::create([
            'users_id' => Auth::user()->id,
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'categories_id' => $request->categories_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        $gallery = [
            'products_id' => $product->id,
            'image' => $request->file('image')->store('assets/product','public'),
        ];

        productgallery::create($gallery);

        return redirect()->route('product-seller',$parameter);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = product::findOrFail($id);
        $category = category::get();

        return view('pages.seller.edit-produk',[
            'item' => $item,
            'categories' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'categories_id' => 'required|exists:categories,id',
            'price' => 'required|integer',
            'description' => 'required',
        ]);

        $item = product::findOrFail($id);
        
        $item->update([
            'users_id' => Auth::user()->id,
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'categories_id' => $request->categories_id,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        
        $parameter= Crypt::encrypt(Auth::user()->id);

        return redirect()->route('product-seller',$parameter);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $parameter= Crypt::encrypt(Auth::user()->id);
        $item = product::findorFail($id);
        $item->delete();

        return redirect()->route('product-seller',$parameter);
    }
}
