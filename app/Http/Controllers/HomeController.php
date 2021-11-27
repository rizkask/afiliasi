<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use App\Models\category;
use App\Models\product;
use App\Models\user;


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
        $product = product::orderBy('sold','DESC')->take(10)->get();
        $contact = user::where('id',1)->first();
        return view('pages.home',[
            'slider' => $slider,
            'count' => $count,
            'i' => $i,
            'categories' => $category,
            'products' => $product,
            'contact' => $contact,
        ]);
    }

    public function success()
    {
        return view('pages.payment-success');
    }

    public function dataprovinsi()
    {
        return view('pages.dataprovinsi');
    }

    public function datadistrik()
    {
        return view('pages.datadistrik');
    }

    public function dataekspedisi()
    {
        return view('pages.dataekspedisi');
    }

    public function dataongkir()
    {
        return view('pages.dataongkir');
    }
}
