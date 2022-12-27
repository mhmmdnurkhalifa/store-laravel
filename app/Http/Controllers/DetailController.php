<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Store;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user', 'store'])->where('slug', $id)->firstOrFail();
        $products = Product::with(['galleries', 'user', 'store'])->where('categories_id', $product->categories_id)->orderBy('id', 'desc')->get();
        $carts = Cart::with(['product.galleries', 'user', 'store'])
            ->where('users_id', Auth::user()->id ?? null)
            // ->orderBy('id', 'desc')
            ->select(DB::raw('sum(qty) as qty'), DB::raw('products_id'), DB::raw('stores_id'))
            ->groupBy(['products_id', 'stores_id'])
            ->get();
        return view('pages.detail', [
            'product' => $product,
            'products' => $products,
            'carts' => $carts,
        ]);
    }

    public function add(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user', 'store'])->findOrFail($id);
        $carts = Cart::with(['product.galleries', 'user', 'store'])
            ->where('users_id', Auth::user()->id)
            // ->orderBy('id', 'desc')
            ->select(DB::raw('sum(qty) as qty'), DB::raw('products_id'), DB::raw('stores_id'))
            ->groupBy(['products_id', 'stores_id'])
            ->get();
        $qty = $product->qty;
        foreach ($carts as $cart) {
            if ($product->id == $cart->product->id) {
                $qty -= $cart->qty;
            }
        }
        // dd($qty);
        if ($qty >= $request->qty) {
            Cart::create([
                'products_id' => $id,
                'users_id' => Auth::user()->id,
                'stores_id' => $request->stores_id,
                'qty' => $request->qty,
            ]);
        }
        return redirect()->route('cart');
    }
}
