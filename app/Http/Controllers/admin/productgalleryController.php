<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\admin\productgalleryRequest;
use Illuminate\Support\Str;
use App\Models\productgallery;
use App\Models\product;
use App\Models\category;
use Yajra\DataTables\Facades\DataTables;

class productgalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $item = productgallery::with(['product'])->orderBy('created_at','DESC')->get();

        return view('pages.admin.productgallery.index',[
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
        $category = category::get();
        $product = product::get();

        return view('pages.admin.productgallery.create',[
            'products' => $product,
            'categories' => $category,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(productgalleryRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $data['image'] = $request->file('image')->store('assets/product','public');

        productgallery::create($data);

        return redirect()->route('productgallery.index');
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
        $item = productgallery::findorfail($id);

        return view('pages.admin.productgallery.edit',[
            'item' => $item,
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
            'image' => 'required|image',
        ]);
        
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);
        $data['image'] = $request->file('image')->store('assets/product','public');

        $item = productgallery::findorfail($id);

        $item->update($data);

        return redirect()->route('productgallery.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = productgallery::findorFail($id);
        $item->delete();

        return redirect()->route('productgallery.index');
    }
}
