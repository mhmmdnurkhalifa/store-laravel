<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class CheckOutController extends Controller
{
    public function process(Request $request)
    {
        // Save User Data
        $user = Auth::user();
        $user->update($request->except('total_price'));

        // Proses CheckOut
        $code = 'STORE-' . mt_rand(00000, 99999);
        $carts = Cart::with(['product', 'user', 'store'])
            ->where('users_id', Auth::user()->id)
            ->select(DB::raw('sum(qty) as qty'), DB::raw('users_id'), DB::raw('products_id'), DB::raw('stores_id'))
            ->groupBy(['users_id','products_id', 'stores_id'])
            ->get();

        // Transaction Create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'inscurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status'  => 'PENDING',
            'code'  => $code,
            'stores_id' => $request->stores_id,
        ]);

        // TransactionDetail Create
        foreach ($carts as $cart) {
            $trx = 'TRX-' . mt_rand(00000, 99999);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'stores_id' => $cart->store->id,
                'price' => $cart->product->price,
                'qty' => $cart->qty,
                'shipping_status' => 'PENDING',
                'resi'  => '',
                'code'  => $trx,
                'address_one'  => $cart->user->address_one,
                'address_two'  => $cart->user->address_two,
                'provinces_id'  => $cart->user->provinces_id,
                'regencies_id'  => $cart->user->regencies_id,
                'zip_code'  => $cart->user->zip_code,
                'country'  => $cart->user->country,
                'phone_number'  => $cart->user->phone_number

            ]);

            $data = [
                'qty' => $cart->product->qty - $cart->qty
            ];
            $item = Product::find($cart->product->id);
            $item->update($data);
        }

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        // Configuration Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat Array untuk dikirim ke Midtrans
        $midtrans = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,

            ],
            'enabled_payments' => [
                'bank_transfer',
                'gopay',
                'indomaret',
                // 'alfamart',
            ],
            'vtweb' => []
        ];
        try {
            // Get Snap Payment Page URL
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            // Redirect to Snap Payment Page
            return redirect($paymentUrl);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function callback(Request $request)
    {
    }
}
