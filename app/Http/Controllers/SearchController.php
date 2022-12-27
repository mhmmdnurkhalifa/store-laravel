<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $products = Product::with(['galleries', 'store'])->where('name', 'like', "%".$search."%")->paginate(16);
        return view('pages.search', [
            'products' => $products
        ]);
    }

    
}
