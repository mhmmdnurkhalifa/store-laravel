<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::with(['product.galleries', 'user', 'store'])
            ->where('users_id', Auth::user()->id)
            // ->orderBy('id', 'desc')
            ->select(DB::raw('sum(qty) as qty'), DB::raw('products_id'), DB::raw('stores_id'))
            ->groupBy(['products_id', 'stores_id'])
            ->get();
        foreach ($carts as $cart) {
            if ($cart->product->qty <= 0) {
                Cart::where('products_id', $cart->product->id)->delete();
            }
        }
        return view('pages.cart', [
            'carts' => $carts,
            'user' => $user,
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::where('products_id', $id);
        $cart->delete();
        return redirect()->route('cart');
    }
}
