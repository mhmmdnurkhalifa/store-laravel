<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterStoreController extends Controller
{
    public function index()
    {
        return view('auth.registerStore');
    }

    public function create(Request $request)
    {
        $data = [
            'users_id' => Auth::user()->id,
            'store_name' => $request->store_name,
            'account_number' => $request->account_number,
            'store_status' => $request->store_status,

        ];
        Store::create($data);
        return redirect()->route('home');
    }
}
