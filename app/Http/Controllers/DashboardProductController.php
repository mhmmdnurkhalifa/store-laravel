<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsGallery;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class DashboardProductController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $products = Product::with(['galleries', 'category'])->where('users_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('pages.dashboard-products', [
            'products' => $products
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $stores = Store::with(['user'])->where('users_id', Auth::user()->id)->first();
        return view('pages.dashboard-products-create', [
            'stores' => $stores,
            'categories' => $categories

        ]);
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $item = Product::findOrFail($id);
        $item->update($data);

        return redirect()->route('dashboard-product')->with('success', 'Item update successfully!');
    }

    public function details(Request $request, $id)
    {
        $product = Product::with(['galleries', 'user', 'category'])->findOrFail($id);
        $categories = Category::all();
        $stores = Store::with(['user'])->where('users_id', Auth::user()->id)->firstOrFail();
        return view('pages.dashboard-products-details', [
            'stores' => $stores,
            'product' => $product,
            'categories' => $categories
        ]);
    }


    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);
        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->store('assets/product', 'public'),
        ];
        ProductsGallery::create($gallery);
        return redirect()->route('dashboard-product')->with('success', 'Add Product successfully!');
    }

    public function uploadGallery(Request $request)
    {
        $data = $request->all();
        $data['photos'] = $request->file('photos')->store('assets/product', 'public');

        ProductsGallery::create($data);
        return redirect()->route('dashboard-product-details', $request->products_id);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductsGallery::findOrFail($id);
        $item->delete();
        return redirect()->route('dashboard-product-details', $item->products_id);
    }
}
