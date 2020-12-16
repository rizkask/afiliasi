<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\category;
use App\Models\product;


class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $slider = slider::get();
        $count = $slider->count();
        $i=1;
        $category = category::get();
        $product = product::get();
        return view('pages.home',[
            'slider' => $slider,
            'count' => $count,
            'i' => $i,
            'categories' => $category,
            'products' => $product,
        ]);
    }
}
