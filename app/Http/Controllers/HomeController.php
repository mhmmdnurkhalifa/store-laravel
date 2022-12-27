<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::take(6)->orderBy('id', 'desc')->get();
        $products = Product::with(['galleries', 'user', 'store'])->take(8)->orderBy('id', 'desc')->get();
        return view('pages.home', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
