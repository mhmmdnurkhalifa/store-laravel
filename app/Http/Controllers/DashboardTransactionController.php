<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $sellTransaction = TransactionDetail::with(['transaction.user', 'store'])
            ->whereHas('store', function ($store) {
                $store->where('users_id', Auth::user()->id);
            })->select(DB::raw('stores_id'), DB::raw('transactions_id'), DB::raw('sum(qty)*sum(price) as price'))
            ->groupBy(['stores_id', 'transactions_id', 'price'])
            ->orderBy('transactions_id', 'desc')
            ->get();
        // dd($sellTransaction);
        $buyTransaction = Transaction::with(['user', 'product'])
            ->where('users_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('pages.dashboard-transactions', [
            'sellTransaction' => $sellTransaction,
            'buyTransaction' => $buyTransaction
        ]);
    }

    public function detailsSell($id)
    {
        $sellTransaction = TransactionDetail::with(['transaction.user', 'product.galleries', 'store'])
            ->whereHas('product', function ($store) {
                $store->where('users_id', Auth::user()->id);
            })->where('transactions_id', $id)->orderBy('id', 'desc')->get();
        return view('pages.dashboard-transactions-sell', [
            'sellTransaction' => $sellTransaction,
        ]);
    }

    public function detailsBuy($id)
    {
        $buyTransaction = TransactionDetail::with(['transaction.user', 'product.galleries'])
            ->whereHas('transaction', function ($transaction) {
                $transaction->where('users_id', Auth::user()->id);
            })->where('transactions_id', $id)->orderBy('id', 'desc')->get();
        return view('pages.dashboard-transactions-buy', [
            'buyTransaction' => $buyTransaction
        ]);
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user', 'product.galleries'])->findOrFail($id);
        return view('pages.dashboard-transactions-details', [
            'transaction' => $transaction
        ]);
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrfail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details', $id);
    }
}
