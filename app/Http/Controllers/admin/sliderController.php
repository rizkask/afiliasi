<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\sliderRequest;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class sliderController extends Controller
{
    
    public function index()
    
    {
        $items = slider::orderBy('created_at','DESC')->get();

        return view('pages.admin.slider.index',[
            'items' => $items,
        ]);
    }

    
    public function create()
    {
        return view('pages.admin.slider.create');
    }

    
    public function store(sliderRequest $request)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store(
            'assets/slider', 'public'
        );

        slider::create($data);

        return redirect()->route('slider.index');
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $item = slider::findOrFail($id);

        return view('pages.admin.slider.edit',[
            'item' => $item,
        ]);
    }

    
    public function update(sliderRequest $request, $id)
    {
        $data = $request->all();
        $data['image'] = $request->file('image')->store(
            'assets/slider', 'public'
        );

        $item = slider::findOrFail($id);

        $item->update($data);

        return redirect()->route('slider.index');
    }

    
    public function destroy($id)
    {
        $item = slider::findorFail($id);
        $item->delete();

        return redirect()->route('slider.index');

    }
}
