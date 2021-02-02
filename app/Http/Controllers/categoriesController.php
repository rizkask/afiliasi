<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\category;
use App\Models\product;


class categoriesController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $category = category::get();
        $product = product::get();
        return view('pages.categories',[
            'categories' => $category,
            'products' => $product,
        ]);
    }
}
