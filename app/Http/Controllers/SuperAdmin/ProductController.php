<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with(['user', 'category']);

            return DataTables::of($query)
                ->addcolumn('price', function ($item) {
                    return 'Rp. '. number_format($item->price).'';
                })
                ->addcolumn('action', function ($item) {
                    return '
                        <div class="btn-group">
                            <div class="dropdwon">
                                <button class="btn btn-primary dropdown-toggle mr-1 mb-1" type="button" data-toggle="dropdown">
                                    Aksi
                                </button>
                                <div class="dropdown-menu">
                                    <a href="' . route('product.edit', $item->id) . '" class="dropdown-item">
                                        Edit
                                    </a>
                                    <form action="' . route('product.destroy', $item->id) . '" method="POST">
                                        ' . method_field('delete') . csrf_field() . '
                                        <button class="dropdown-item text-danger" type="submit">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                })
                ->rawColumns(['price'])
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.superadmin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        $stores = Store::all();
        return view('pages.superadmin.product.create', [
            'users' => $users,
            'stores' => $stores,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $stores = Store::all();
        foreach ($stores as $store) {
            if ($request->stores_id == $store->id) {
                $data = $request->all();
                $data['users_id'] = $store->users_id;
                $data['slug'] = Str::slug($request->name);
            }
        }
        Product::create($data);
        return redirect()->route('product.index');
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
        $product = Product::with(['store', 'category'])->findOrFail($id);
        $users = User::all();
        $stores = Store::all();
        $categories = Category::all();
        return view('pages.superadmin.product.edit', [
            'product' => $product,
            'users' => $users,
            'stores' => $stores,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $stores = Store::all();
        foreach ($stores as $store) {
            if ($request->stores_id == $store->id) {
                $data = $request->all();
                $data['users_id'] = $store->users_id;
                $data['slug'] = Str::slug($request->name);
                
            }
        }
        $item = Product::findOrFail($id);
        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();
        return redirect()->route('product.index');
    }
}
