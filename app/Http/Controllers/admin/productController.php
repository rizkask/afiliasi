<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\productRequest;
use Illuminate\Support\Str;
use App\Models\product;
use App\Models\productgallery;
use App\Models\user;
use App\Models\category;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = product::with(['user','category'])->orderBy('created_at','DESC')->get();

        return view('pages.admin.product.index',[
            'items' => $item
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = user::get();
        $category = category::get();

        return view('pages.admin.product.create',[
            'users' => $user,
            'categories' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(productRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $product = product::create($data);

        $gallery = [
            'products_id' => $product->id,
            'image' => $request->file('image')->store('assets/product','public'),
        ];

        productgallery::create($gallery);

        return redirect()->route('product.index');
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
        $item = product::findorfail($id);
        $category = category::get();

        return view('pages.admin.product.edit',[
            'item' => $item,
            'categories' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(productRequest $request, $id)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $item = product::findorfail($id);

        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = product::findorFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }

    public function deletegallery(Request $request,$id)
    {
        $item = productgallery::findorFail($id);
        $item->delete();

        return redirect()->back();
    }

    public function uploadgallery(Request $request)
    {
        $data = $request->all();

        $cek = productgallery::where('products_id',$request->products_id)->count();

        if($cek<4){
            $data['image'] = $request->file('image')->store('assets/product','public');

            productgallery::create($data);

            return redirect()->back();
        }
        else{
            return redirect()->back()->with(['error' => 'Maksimal 4 foto tiap produk']);
        }
        
    }
}
