<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = TransactionDetail::with(['store.user'])
                ->select(DB::raw('id'), DB::raw('stores_id'), DB::raw('(price*qty) as price'), DB::raw('shipping_status'));
            return DataTables::of($query)
                ->addcolumn('price', function ($item) {
                    return 'Rp. ' . number_format($item->price) . '';
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

        return view('pages.superadmin.transaction.index');
    }
}
