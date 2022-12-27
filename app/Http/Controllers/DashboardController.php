<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transactions = TransactionDetail::with(['transaction.user'])
            ->whereHas('product', function ($store) {
                $store->where('users_id', Auth::user()->id);
            })->select(DB::raw('stores_id'), DB::raw('transactions_id'))
            ->groupBy(['stores_id', 'transactions_id'])
            ->orderBy('transactions_id', 'desc')->get();


        $revenue = TransactionDetail::with(['transaction.user'])
            ->whereHas('product', function ($store) {
                $store->where('users_id', Auth::user()->id);
            })->get()->reduce(function ($carry, $item) {
                return $carry + $item->price * $item->qty;
            });

        $customer = TransactionDetail::with(['transaction.user'])
        ->whereHas('product', function ($store) {
            $store->where('users_id', Auth::user()->id);
        })->select(DB::raw('stores_id'), DB::raw('transactions_id'))
        ->groupBy(['stores_id', 'transactions_id'])
        ->orderBy('transactions_id', 'desc')->get();

        return view('pages.dashboard', [
            'transactions' => $transactions,
            'revenue' => $revenue,
            'customer' => $customer
        ]);
    }
}
